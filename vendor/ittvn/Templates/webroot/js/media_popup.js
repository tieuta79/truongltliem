var medias_popup = [];
medias_popup.admin = [];
medias_popup.site = [];

medias_popup.admin.get_media_by_gallery = function (gallery_id) {
    $.get(ittvn.config.base_url + 'admin/medias/galleries/view/' + gallery_id, {popup: true}, function (d) {
        $('#tab-2 .row .col-lg-12').empty();
        var type_images = ['image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png'];
        var type_docs = ['application/pdf', 'text/plain', 'application/msword', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.wordprocessingml.template'];
        var type_excels = ['application/vnd.ms-excel', 'application/vnd.ms-excel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.spreadsheetml.template'];
        var type_power = ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.openxmlformats-officedocument.presentationml.template', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow'];
        var type_mp4 = ['video/mp4'];
        var file_box = '<div class="file-box col-sm-3">';
        file_box += '<div class="file clearfix">';
        //file_box += '<a href="#">';
        file_box += '<span class="corner"></span>';
        file_box += '{{file_content}}';
        file_box += '<div class="file-name col-md-12">';
        file_box += '<div class="row">';
        file_box += '<div class="col-md-10 no-padding">';
        file_box += '{{file_name}}<br/><small>Created: {{file_date}}</small>';
        file_box += '</div>';
        file_box += '<div class="col-md-2 text-center delete_file_image" data-id="{{id}}">';
        file_box += '<i class="fa fa-remove btn btn-danger" style="padding-right: 10px;"></i>';
        file_box += '</div>';
        file_box += '</div>';
        //file_box += '</a>';
        file_box += '</div>';
        file_box += '</div>';
        file_box += '</div>';
        var box_content_image = '<div class="image">';
        if ($('#element_multiple').val() == 1) {
            box_content_image += '<a href="javascript:void(0)" class="insert_file" value="{{path_image}}"><img media_id="{{id}}" alt="image" class="img-responsive thumbnail" src="{{path_image}}" /></a>';
        } else {
            box_content_image += '<a href="javascript:void(0)" data-dismiss="modal" aria-hidden="false" class="insert_file" value="{{path_image}}"><img media_id="{{id}}" alt="image" class="img-responsive thumbnail" src="{{path_image}}" /></a>';
        }
        box_content_image += '</div>';

        var box_content_file = '<div class="icon">';
        if ($('#element_multiple').val() == 1) {
            box_content_file += '<a href="javascript:void(0)" class="insert_file" value="{{path_file}}"><i class="fa {{icon_file}}"></i></a>';
        } else {
            box_content_file += '<a href="javascript:void(0)" data-dismiss="modal" aria-hidden="true" class="insert_file" value="{{path_file}}"><i class="fa {{icon_file}}"></i></a>';
        }
        box_content_file += '</div>';

        $.each(d.content, function (x, y) {
            var truncate_name = (y.name).substring((y.name).length - 15, (y.name).length);
            if (truncate_name.length < (y.name).length) {
                truncate_name = '...' + truncate_name;
            }

            if ($.inArray(y.type, type_images) !== -1) {
                var tmp_box_content_image = box_content_image.replace('{{path_image}}', ittvn.config.url_upload+y.url).replace('{{id}}', y.id);
                tmp_box_content_image = tmp_box_content_image.replace('{{path_image}}', ittvn.config.url_upload+y.url);
                var tmp_file_box = file_box.replace('{{file_content}}', tmp_box_content_image);
                tmp_file_box = tmp_file_box.replace('{{file_name}}', truncate_name);
                tmp_file_box = tmp_file_box.replace('{{file_date}}', ittvn.admin.formatDate(y.created));
                tmp_file_box = tmp_file_box.replace('{{id}}', y.id);
                $('#tab-2 .row .col-lg-12').append(tmp_file_box);
            } else {
                var tmp_box_content_file = '';
                if ($.inArray(y.type, type_docs) !== -1) {
                    tmp_box_content_file = box_content_file.replace('{{icon_file}}', 'fa-file');
                } else if ($.inArray(y.type, type_excels) !== -1) {
                    tmp_box_content_file = box_content_file.replace('{{icon_file}}', 'fa-bar-chart-o');
                } else if ($.inArray(y.type, type_power) !== -1) {
                    tmp_box_content_file = box_content_file.replace('{{icon_file}}', 'fa-file-powerpoint-o');
                } else if ($.inArray(y.type, type_mp4) !== -1) {
                    tmp_box_content_file = box_content_file.replace('{{icon_file}}', 'fa-film img-responsive');
                } else {
                    tmp_box_content_file = box_content_file.replace('{{icon_file}}', 'fa-file');
                }

                var tmp_file_box = file_box.replace('{{path_file}}', ittvn.config.url_upload+y.url);
                tmp_file_box = tmp_file_box.replace('{{file_content}}', tmp_box_content_file);
                tmp_file_box = tmp_file_box.replace('{{file_name}}', truncate_name);
                tmp_file_box = tmp_file_box.replace('{{file_date}}', ittvn.admin.formatDate(y.created));
                tmp_file_box = tmp_file_box.replace('{{id}}', y.id);
                $('#tab-2 .row .col-lg-12').append(tmp_file_box);
            }
        });
    });

    ittvn.admin.scrollBox();
}

medias_popup.admin.upload = function () {
    if ($('#it_uploads').size() > 0) {
        Dropzone.autoDiscover = false;
        $("#it_uploads").dropzone({
            addRemoveLinks: true,
            maxFilesize: 0.5,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,
            dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
            dictResponseError: 'Error uploading file!',
            completemultiple: function () {
                medias_popup.admin.get_media_by_gallery('');
            }
        });
    }
}

medias_popup.admin.changeFolder = function () {
    $('.choose_folder').click(function () {
        var title = $(this).attr('title');
        var value = $(this).attr('value');
        $('.show_folder').text(title);
        medias_popup.admin.get_media_by_gallery(value);
    });
}

medias_popup.admin.deleteImage = function () {
    $('#tab-2 .row .col-lg-12').on('click', '.delete_file_image', function () {
        var id = $(this).attr('data-id');
        var file_box = $(this).parents('.file-box');
        $.post(ittvn.config.base_url + 'admin/medias/medias/delete/' + id, {}, function () {
            file_box.remove().fadeOut('slow');
        });
    });
}

medias_popup.admin.insertFile = function () {
    flagf = true;
    $('#modal_ajax').on('click', '#tab-2 .row .col-lg-12 .file-box a.insert_file', function (e) {
        e.preventDefault();
        var value = $(this).attr('value');
        var element_return = $('#element_return').val();
        var html_preview = $(this).html();
        if ($('#element_multiple').val() == 1) {
            if ($(this).hasClass('selected') && flagf == true) {
                $(this).removeClass('selected').find('i').remove();
            } else {
                $(this).addClass('selected').append('<i class="fa-fw fa fa-check"></i>');
                flagf = false;
            }
        } else {
            $(element_return).next().find('.preview_file').html(html_preview);
            if ($(element_return).next().find('.preview_file').next().size() == 0) {
                $(element_return).next().find('.preview_file').after('<span class="RemoveImages"><i class="fa fa-remove text-danger"></i></span>');
            }
            $(element_return).val(value);
            $('#modal_ajax').off('click', '#tab-2 .row .col-lg-12 .file-box a.insert_file');
        }
        return true;
    });
}
//medias_popup.admin.insertFiles = function () {
//    $('#modal_ajax').on('click', '#insert_files', function () {
//        var element_return = $('#element_return').val();
//        var value = $(element_return).val();
//        var html = '<div class="col-xs-6 col-md-3 ui-state-default">[image]</div>';
//        var data = '';
//        var ids = [];
//        $('#tab-2 .row .col-lg-12 .file-box .selected').each(function () {
//            ids.push($(this).find('img').attr('media_id').addClass('thumbnail'));
//            data += html.replace('[image]', $("<div />").append($(this).find('img').clone()).html());
//        });
//        $(element_return).next().find('.preview_files').append(data);
//        if (value != '') {
//            var tmp_value = new Array(value);
//            tmp_value.push(ids.join(','));
//            ids = tmp_value;
//        }
//        $(element_return).val(ids);
//        $('#modal_ajax').off('click', '#insert_files');
//    });
//}
medias_popup.admin.insertFiles = function () {
    flag = true;
    $('#modal_ajax').on('click', '#insert_files', function () {
        var element_return = $('#element_return').val();
        var value = $(element_return).val();
        var html = '<div class="col-md-3 gallery_preview">[image]</div>';
        var data = '';
        var ids = [];
        if (flag == true) {
            $('#tab-2 .row .col-lg-12 .file-box .selected').each(function () {
                arr = [];
                arr.push($(this).find('img').attr('media_id'));
                arr.push($(this).find('img').attr('src'));
                ids.push(arr);
                data += html.replace('[image]', $("<div />").append($(this).find('img').clone().attr('style', 'cursor: pointer;')).prepend('<i class="fa fa-remove text-danger imgs-remove"></i>').html());
                flag = false;
            });
        }
        $(element_return).next().find('.preview_files').append(data);
        if (value != '') {
            var valjson = JSON.parse(value);
            for (x in ids) {
                valjson.push(ids[x]);
            }
            ids = valjson;
        }
        $(element_return).val(JSON.stringify(ids));
        $('#modal_ajax').off('click', '#insert_files');
    });
    return false;
}


$(document).ready(function () {
    //upload ajax    
    medias_popup.admin.upload();
    medias_popup.admin.get_media_by_gallery('');
    medias_popup.admin.changeFolder();
    medias_popup.admin.deleteImage();
    medias_popup.admin.insertFile();
    medias_popup.admin.insertFiles();
});