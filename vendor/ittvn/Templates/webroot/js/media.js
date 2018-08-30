var medias = [];
medias.admin = [];
medias.site = [];

medias.admin.selectedGallery = function (gallery) {
    $('.tree span').removeClass('active-node');
    $(gallery).addClass('active-node');

    var path = $(gallery).parent('li').attr('data-path');
    $(".medias-path").text(path);
    var id = $(gallery).parent('li').attr('data-id');
    //update gallery_id in dropzone
    $("#gallery_id").val(id);
    //update gallery_id and gallery name in edit form
    $("#edit-galleries-popup .gallery-id-update").val(id);
    $("#edit-galleries-popup .gallery-name-update").val($(gallery).text());
};

medias.admin.mediaByGallery = function (id) {
    $("#gallery_id").val(id);
    $('.superbox').empty();
    $('.superbox').html('<div class="progress progress-striped active" rel="tooltip" data-original-title="55%" data-placement="bottom"><div class="progress-bar progress-bar-success" role="progressbar" style="width: 100%"></div></div>');
    $.ajax({
        url: ittvn.config.base_url + 'admin/medias/medias/get_medias',
        data: {gallery_id: id},
        type: 'POST',
        dataType: 'json',
        success: function (res) {
            if (res.status == true && res.data.length > 0) {
                medias.admin.displayMedias(res.data);
            }
            $('.superbox .progress').remove();
        },
        error: function () {
            $('.superbox .progress').remove();
        }
    });
};

medias.admin.displayMedias = function (medias) {
    
    var fileList = [];
    var pattern = $('#superbox-list-pattern').html();
    var html = '';
    var fileExtension = ['doc','docx', 'xlsx','xlsm','xlsb','xltx','xltm','xls','xlt','xls','xml', 'zip', 'rar','pdf'];
    var fileTypedoc = ['doc', 'docx'];
    var fileTypeexcel = ['xlsx','xlsm','xlsb','xltx','xltm','xls','xlt','xls','xml'];
    var fileTypezr = ['zip', 'rar'];
    var fileTypepdf = ['pdf'];
    var iconFa = '';
    
    for (var i in medias) {    
        fileList.push(medias[i]);
        if($.inArray(medias[i]['title'].split('.').pop().toLowerCase(),fileExtension) == -1){
            html += pattern.replace(/{path}/g, ittvn.config.url_upload+medias[i]['url'])
                .replace('{title}', medias[i]['title'])
                .replace('{description}', medias[i]['description'])
                .replace('{id}', medias[i]['id'])
                .replace('{date}', ittvn.admin.formatDate(medias[i]['created']));
        }else{
            if($.inArray(medias[i]['title'].split('.').pop().toLowerCase(),fileTypedoc) != -1){
                iconFa = 'fa-file-text-o';
            }else if($.inArray(medias[i]['title'].split('.').pop().toLowerCase(),fileTypeexcel) != -1){
                iconFa = 'fa-file-excel-o';
            }else if($.inArray(medias[i]['title'].split('.').pop().toLowerCase(),fileTypezr) != -1){
                iconFa = 'fa-file-archive-o';
            }else if($.inArray(medias[i]['title'].split('.').pop().toLowerCase(),fileTypepdf) != -1){
                iconFa = 'fa-file-pdf-o';
            }
            html += '<div class="superbox-list"><div class="file_size_icon"><i class="fa '+iconFa+'" aria-hidden="true"></i></div><span class="superbox-img" data-type="'+iconFa+'" data-superbox-id="'+medias[i]['id']+'" data-date="'+ittvn.admin.formatDate(medias[i]['created'])+'" data-img="'+ittvn.config.url_upload+medias[i]['url']+'" title="'+medias[i]['title']+'">'+medias[i]['title']+'</span></div>';   
        }
    }
    $('.superbox').prepend(html);

    $('.superbox').SuperBox();
}

medias.admin.filterMedias = function () {
    $('#media-filter-text, select[name="media_filter_date[month]"], select[name="media_filter_date[year]"]').on('keyup change', function () {
        var q = $('#media-filter-text').val();
        var month = $('select[name="media_filter_date[month]"]').val();
        var year = $('select[name="media_filter_date[year]"]').val();
        var gallery_id = $("#gallery_id").val();

        $('.superbox').empty();
        $('.superbox').html('<div class="progress progress-striped active" rel="tooltip" data-original-title="55%" data-placement="bottom"><div class="progress-bar progress-bar-success" role="progressbar" style="width: 100%"></div></div>');
        $.ajax({
            url: ittvn.config.base_url + 'admin/medias/medias/filterMedias',
            type: 'post',
            data: {q: q, month: month, year: year, gallery_id: gallery_id},
            dataType: 'json',
            success: function (res) {
                if (res.status == true && res.data.length > 0) {
                    medias.admin.displayMedias(res.data);
                }
                $('.superbox .progress').remove();
            }
        });
    });
}

medias.admin.currentFolder = function () {
    return [{
            'path': $('ul[role="tree"] .active-node').parent().attr('data-path'),
            'id': $('ul[role="tree"] .active-node').parent().attr('data-id')
        }];
}

medias.admin.addOrEditGellary = function () {
    $('.add_gallery, .edit_gallery').click(function (e) {
        var current = medias.admin.currentFolder();
        var url = $(this).attr('data-path');
        if (current[0].id != 0) {
            url = url + '/' + current[0].id;
        } else {
            if ($(this).hasClass('edit_gallery')) {
                e.preventDefault();
                $.smallBox({
                    title: "Error rename Folder " + current[0].path + ".",
                    content: "<i class='fa fa-clock-o'></i> <i>Can rename folder root.</i>",
                    color: "#C46A69",
                    iconSmall: "fa fa-times fa-2x fadeInRight animated",
                    timeout: 4000
                });
                return false;
            }
        }

        $(this).attr('href', url);
    });

    $(this)

    $('body').on('click', '.btn_add_folder', function (e) {
        e.preventDefault();
        var current = medias.admin.currentFolder();
        var form = $('#modal_ajax').find('form');
        var data = form.serialize();
        var url = form.attr('action');
        var action = 'Add';
        if (url.indexOf('edit')) {
            action = 'Edit';
        }
        $.ajax({
            url: url,
            data: data,
            type: 'post',
            dataType: 'json',
            success: function (res) {
                if (res.status == true) {
                    $.smallBox({
                        title: action + " Folder " + current[0].path + ".",
                        content: "<i class='fa fa-clock-o'></i> <i>" + res.message + "</i>",
                        color: "#659265",
                        iconSmall: "fa fa-check fa-2x fadeInRight animated",
                        timeout: 4000
                    });
                    $('#modal_ajax').find('.close').trigger('click');
                    window.parent.location.reload(true);
                } else {
                    $.smallBox({
                        title: action + " Folder " + current[0].path + ".",
                        content: "<i class='fa fa-clock-o'></i> <i>" + res.message + "</i>",
                        color: "#C46A69",
                        iconSmall: "fa fa-times fa-2x fadeInRight animated",
                        timeout: 4000
                    });
                    return false;
                }
            },
            error: function () {
                $.smallBox({
                    title: action + " Folder " + current[0].path + ".",
                    content: '<i class="fa fa-clock-o"></i> <i>Can\'t '+action.toLowerCase()+' folder ' + current[0].path + '.</i>',
                    color: "#C46A69",
                    iconSmall: "fa fa-times fa-2x fadeInRight animated",
                    timeout: 4000
                });
                return false;
            }
        });
    });
}

medias.admin.deleteGellary = function () {
    $('.delete_gallery').click(function (e) {
        e.preventDefault();
        var current = medias.admin.currentFolder();
        var url = $(this).attr('data-path');
        if (current[0].id != 0) {
            $.SmartMessageBox({
                title: "Alert!",
                content: "Do you want delete folder " + current[0].path + "?",
                buttons: '[No][Yes]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {id: current[0].id},
                        dataType: 'json',
                        success: function (res) {
                            if (res.status == true) {
                                $.smallBox({
                                    title: "Delete Folder " + current[0].path + ".",
                                    content: "<i class='fa fa-clock-o'></i> <i>" + res.message + "</i>",
                                    color: "#659265",
                                    iconSmall: "fa fa-check fa-2x fadeInRight animated",
                                    timeout: 4000
                                });
                                window.parent.location.reload(true);
                            } else {
                                $.smallBox({
                                    title: "Delete Folder " + current[0].path + ".",
                                    content: "<i class='fa fa-clock-o'></i> <i>" + res.message + "</i>",
                                    color: "#C46A69",
                                    iconSmall: "fa fa-times fa-2x fadeInRight animated",
                                    timeout: 4000
                                });
                            }
                        },
                        error: function () {
                            $.smallBox({
                                title: "Delete Folder " + current[0].path + ".",
                                content: '<i class="fa fa-clock-o"></i> <i>Can\'t delete folder ' + current[0].path + '.</i>',
                                color: "#C46A69",
                                iconSmall: "fa fa-times fa-2x fadeInRight animated",
                                timeout: 4000
                            });
                        }
                    });
                }
            });
        } else {
            $.smallBox({
                title: "Delete Folder " + current[0].path + ".",
                content: '<i class="fa fa-clock-o"></i> <i>Can\'t delete folder Root.</i>',
                color: "#C46A69",
                iconSmall: "fa fa-times fa-2x fadeInRight animated",
                timeout: 4000
            });
        }
    });
}

$(document).ready(function () {
    medias.admin.mediaByGallery(0);
    medias.admin.filterMedias();
    medias.admin.addOrEditGellary();
    medias.admin.deleteGellary();
    $('.superbox').on('click', '.btn-delete-superbox', function () {        
        if($(this).parents('.superbox-show').find('.superbox-current-img').css('display') != 'none'){
            var mediaPath = $(this).parents('div#imgInfoBox').attr('src');
            var mediaId = $('.superbox img[src="' + mediaPath + '"]').attr('data-superbox-id');
        }else{
            var mediaId = $(this).parents('.superbox-show').find('.superbox-current-i').attr('data-srr');
        }
       
        $.ajax({
            type: 'post',
            url: '/admin/medias/medias/delete',
            dataType: 'json',
            data: {id: mediaId},
            success: function (res) {
                if (res.status == true) {
                    $('.superbox .superbox-show').remove().fadeOut('slow');
                    $('html,body').animate({scrollTop: $('.superbox .active').offset().top}, 'slow');
                    $('.superbox .active').remove().fadeOut('slow');
                }
            },
            error: function () {

            }
        });
    });

    /*
     $.contextMenu({
     selector: '.tree li',
     callback: function (key, options) {
     var m = "clicked: " + key;
     console.log(m);
     console.log(options.$trigger.attr('id'));
     },
     items: {
     add: {name: "Add new", icon: "fa-plus"},
     edit: {name: "Rename", icon: "fa-pencil-square-o"},
     delete: {name: "Delete", icon: "fa-minus-circle"}
     }
     });
     */
    //End creating medias tree

    $("#edit-galleries-popup .btn-update-gallery").on('click', function () {
        var popup = $('#edit-galleries-popup');
        var gallery_id = popup.find('.gallery-id-update').val();
        var gallery_name = popup.find('.gallery-name-update').val();
        if (gallery_id) {
            $.ajax({
                type: 'post',
                url: '/admin/medias/galleries/update_gallery',
                dataType: 'json',
                data: {id: gallery_id, name: gallery_name},
                success: function (response) {
                    $('#edit-galleries-popup .msg').text(response['msg']);
                },
                error: function () {

                }
            });
        }
    });


    $('.tree > ul').attr('role', 'tree').find('ul').attr('role', 'group');
    $('.tree').find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span').attr('title', 'Collapse this branch').on('click', function (e) {
        var li = $(this).parent('li.parent_li');
        if (li.attr('id') != 'tree_root') {
            var children = li.find(' > ul > li');
            if (children.is(':visible')) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').removeClass().addClass('fa fa-lg fa-folder');
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').removeClass().addClass('fa fa-lg fa-folder-open');
            }
        }
        e.stopPropagation();
    });
    $('.tree > ul li span').on('click', function () {
        medias.admin.selectedGallery(this);
        medias.admin.mediaByGallery($("#gallery_id").val());
    });



    $(window).resize(function () {
        var h = Math.max($(window).height() - 0, 420);
        $('#container, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
    }).resize();

    $('#file_manager .col-lg-9 .col-lg-12').on('click', '.delete_file_image', function () {
        var id = $(this).attr('data-id');
        var file_box = $(this).parents('.file-box');
        $.post(ittvn.config.base_url + 'admin/medias/medias/delete/' + id, {}, function () {
            file_box.remove().fadeOut('slow');
        });
    });

    //click button uploads
    $('.it_upload').click(function () {
        if ($('#my-awesome-dropzone').hasClass('dz-started')) {
            $('#my-awesome-dropzone').removeClass('dz-started');
            $('#my-awesome-dropzone .dz-preview').remove();
        }
    });

    //upload ajax    
    if ($('.dropzone').size() > 0) {
        Dropzone.autoDiscover = false;
        $(".dropzone").dropzone({
            addRemoveLinks: true,
            maxFilesize: 0.5,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,
            dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
            dictResponseError: 'Error uploading file!',
            completemultiple: function () {
                medias.admin.mediaByGallery($("#gallery_id").val());
            }
        });
    }


    // $('#galleries')
    //         .jstree({
    //             core: {
    //                 data: {
    //                     url: ittvn.config.base_url + 'admin/medias/galleries/index',
    //                     data: function (node) {
    //                         return {'id': node.id};
    //                     },
    //                     dataType: 'json',
    //                     contentType: 'application/json charset=utf-8',
    //                 },
    //                 'check_callback': function (o, n, p, i, m) {
    //                     if (m && m.dnd && m.pos !== 'i') {
    //                         return false;
    //                     }
    //                     if (o === "move_node" || o === "copy_node") {
    //                         if (this.get_node(n).parent === this.get_node(p).id) {
    //                             return false;
    //                         }
    //                     }
    //                     return true;
    //                 },
    //                 'themes': {
    //                     'responsive': false,
    //                     'variant': 'small',
    //                     'stripes': true
    //                 }
    //             },
    //             'sort': function (a, b) {
    //                 return this.get_type(a) === this.get_type(b) ? (this.get_text(a) > this.get_text(b) ? 1 : -1) : (this.get_type(a) >= this.get_type(b) ? 1 : -1);
    //             },
    //             'contextmenu': {
    //                 'items': function (node) {
    //                     var tmp = $.jstree.defaults.contextmenu.items();
    //                     return tmp;
    //                 }
    //             },
    //             'types': {
    //                 'default': {'icon': 'folder'},
    //                 'file': {'valid_children': [], 'icon': 'file'}
    //             },
    //             'unique': {
    //                 'duplicate': function (name, counter) {
    //                     return name + ' ' + counter;
    //                 }
    //             },
    //             'plugins': ['state', 'dnd', 'sort', 'types', 'contextmenu', 'unique']
    //         })
    //         .on('delete_node.jstree', function (e, data) {
    //             var id = data.node.id;
    //             $.post(ittvn.config.base_url + 'admin/medias/galleries/delete/' + id, {})
    //                     .fail(function () {
    //                         data.instance.refresh();
    //                     });
    //         })
    //         .on('create_node.jstree', function (e, data) {
    //             var type = data.node.type;
    //             var parent_id = data.node.parent == 'j1_1' ? '' : data.node.parent;
    //             var name = data.node.text;
    //             $.post(ittvn.config.base_url + 'admin/medias/galleries/add', {name: name, parent_id: parent_id})
    //                     .done(function (d) {
    //                         data.instance.set_id(data.node, d.id);
    //                     })
    //                     .fail(function () {
    //                         data.instance.refresh();
    //                     });
    //         })
    //         .on('rename_node.jstree', function (e, data) {
    //             if (data.node.id == 'j1_1') {
    //                 data.instance.refresh();
    //                 return true;
    //             }

    //             var id = data.node.id == 'j1_1' ? '' : data.node.id;
    //             var name = data.text;
    //             $.post(ittvn.config.base_url + 'admin/medias/galleries/edit/' + id, {'id': id, name: name})
    //                     .done(function (d) {
    //                         data.instance.set_id(data.node, d.id);
    //                         //data.instance.refresh();
    //                     })
    //                     .fail(function () {
    //                         data.instance.refresh();
    //                     });
    //         })
    //         .on('move_node.jstree', function (e, data) {
    //             var id = data.node.id;
    //             var parent_id = data.parent;
    //             $.post(ittvn.config.base_url + 'admin/medias/galleries/move/' + id, {id: id, parent_id: parent_id})
    //                     .done(function (d) {
    //                         //data.instance.load_node(data.parent);
    //                         data.instance.refresh();
    //                     })
    //                     .fail(function () {
    //                         data.instance.refresh();
    //                     });
    //         })
    //         .on('copy_node.jstree', function (e, data) {
    //             var id = data.original.id;
    //             var parent_id = data.parent;
    //             $.post(ittvn.config.base_url + 'admin/medias/galleries/copy/' + id, {parent_id: parent_id})
    //                     .done(function (d) {
    //                         //data.instance.load_node(data.parent);
    //                         data.instance.refresh();
    //                     })
    //                     .fail(function () {
    //                         data.instance.refresh();
    //                     });
    //         })
    //         .on('changed.jstree', function (e, data) {
    //             if (data && data.selected && data.selected.length) {
    //                 var gallery_id = 0;
    //                 if (data.selected.join(':') != 'j1_1') {
    //                     gallery_id = data.selected.join(':');
    //                 }
    //                 $('#file_manager .col-lg-9 .row').prepend('<div class="sk-spinner sk-spinner-wave"><div class="sk-rect1"></div><div class="sk-rect2"></div><div class="sk-rect3"></div><div class="sk-rect4"></div><div class="sk-rect5"></div></div>');
    //                 $.get(ittvn.config.base_url + 'admin/medias/galleries/view/' + gallery_id, function (d) {
    //                     if (d && typeof d.type !== 'undefined') {
    //                         $('#file_manager .col-lg-9 .col-lg-12').empty();
    //                         switch (d.type) {
    //                             case 'text':
    //                             case 'txt':
    //                             case 'md':
    //                             case 'htaccess':
    //                             case 'log':
    //                             case 'sql':
    //                             case 'php':
    //                             case 'js':
    //                             case 'json':
    //                             case 'css':
    //                             case 'html':
    //                                 $('#data .code').show();
    //                                 $('#code').val(d.content);
    //                                 break;
    //                             case 'png':
    //                             case 'jpg':
    //                             case 'jpeg':
    //                             case 'bmp':
    //                             case 'gif':
    //                                 $('#data .image img').one('load', function () {
    //                                     $(this).css({'marginTop': '-' + $(this).height() / 2 + 'px', 'marginLeft': '-' + $(this).width() / 2 + 'px'});
    //                                 }).attr('src', d.content);
    //                                 $('#data .image').show();
    //                                 break;
    //                             default:
    //                                 var type_images = ['image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/x-png', 'image/png'];
    //                                 var type_docs = ['application/pdf', 'text/plain', 'application/msword', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.wordprocessingml.template'];
    //                                 var type_excels = ['application/vnd.ms-excel', 'application/vnd.ms-excel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.spreadsheetml.template'];
    //                                 var type_power = ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.openxmlformats-officedocument.presentationml.template', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow'];
    //                                 var type_mp4 = ['video/mp4'];
    //                                 var file_box = '<div class="file-box">';
    //                                 file_box += '<div class="file clearfix">';
    //                                 //file_box += '<a href="#">';
    //                                 file_box += '<span class="corner"></span>';
    //                                 file_box += '{{file_content}}';
    //                                 file_box += '<div class="file-name col-md-12">';
    //                                 file_box += '<div class="col-md-10">';
    //                                 file_box += '{{file_name}}<br/><small>Created: {{file_date}}</small>';
    //                                 file_box += '</div>';
    //                                 file_box += '<div class="col-md-2 text-center btn btn-danger delete_file_image" data-id="{{id}}">';
    //                                 file_box += '<i class="fa fa-remove"></i>';
    //                                 file_box += '</div>';
    //                                 file_box += '</div>';
    //                                 //file_box += '</a>';
    //                                 file_box += '</div>';
    //                                 file_box += '</div>';
    //                                 var box_content_image = '<div class="image">';
    //                                 box_content_image += '<a href="' + ittvn.config.base_url + 'admin/medias/medias/view/{{id}}" class="view_image" data-toggle="modal" data-target="#modal_ajax"><img alt="image" class="img-responsive" src="{{path_image}}" /></a>';
    //                                 box_content_image += '</div>';

    //                                 var box_content_file = '<div class="icon">';
    //                                 box_content_file += '<i class="fa {{icon_file}}"></i>';
    //                                 box_content_file += '</div>';

    //                                 $.each(d.content, function (x, y) {
    //                                     var truncate_name = (y.name).substring((y.name).length - 15, (y.name).length);
    //                                     if (truncate_name.length < (y.name).length) {
    //                                         truncate_name = '...' + truncate_name;
    //                                     }

    //                                     if ($.inArray(y.type, type_images) !== -1) {
    //                                         var tmp_box_content_image = box_content_image.replace('{{path_image}}', y.url);
    //                                         var tmp_file_box = file_box.replace('{{file_content}}', tmp_box_content_image);
    //                                         tmp_file_box = tmp_file_box.replace('{{file_name}}', truncate_name);
    //                                         tmp_file_box = tmp_file_box.replace('{{file_date}}', $.date(y.created));
    //                                         tmp_file_box = tmp_file_box.replace('{{id}}', y.id);
    //                                         $('#file_manager .col-lg-9 .col-lg-12').append(tmp_file_box);
    //                                     } else {
    //                                         var tmp_box_content_file = '';
    //                                         if ($.inArray(y.type, type_docs) !== -1) {
    //                                             tmp_box_content_file = box_content_file.replace('{{icon_file}}', 'fa-file');
    //                                         } else if ($.inArray(y.type, type_excels) !== -1) {
    //                                             tmp_box_content_file = box_content_file.replace('{{icon_file}}', 'fa-bar-chart-o');
    //                                         } else if ($.inArray(y.type, type_power) !== -1) {
    //                                             tmp_box_content_file = box_content_file.replace('{{icon_file}}', 'fa-file-powerpoint-o');
    //                                         } else if ($.inArray(y.type, type_mp4) !== -1) {
    //                                             tmp_box_content_file = box_content_file.replace('{{icon_file}}', 'fa-film img-responsive');
    //                                         } else {
    //                                             tmp_box_content_file = box_content_file.replace('{{icon_file}}', 'fa-file');
    //                                         }

    //                                         var tmp_file_box = file_box.replace('{{file_content}}', tmp_box_content_file);
    //                                         tmp_file_box = tmp_file_box.replace('{{file_name}}', truncate_name);
    //                                         tmp_file_box = tmp_file_box.replace('{{file_date}}', $.date(y.created));
    //                                         tmp_file_box = tmp_file_box.replace('{{id}}', y.id);
    //                                         $('#file_manager .col-lg-9 .col-lg-12').append(tmp_file_box);
    //                                     }
    //                                 });
    //                                 break;
    //                         }
    //                     }
    //                 }).done(function () {
    //                     $('#file_manager').parent().find('.sk-spinner').remove();
    //                 });
    //             }
    //             else {
    //                 $('#data .content').hide();
    //                 $('#data .default').html('Select a file from the tree.').show();
    //             }
    //         });


}
);