$(document).ready(function () {
    $('.btn-save').on('click', function () {
        var html = $(this).html();
        var text = $(this).text();
        if ($(this).find('i').size() > 0) {
            $(this).find('i').attr('class', 'fa fa-refresh fa-spin');
        } else {
            $(this).html('<i class="fa fa-refresh fa-spin"></i> ' + text);
        }
    });    

    //$(".connectedSortable .box-header").css("cursor", "move");

    $("select").select2({
        allowClear: true,
        //minimumInputLength: 2,
        formatResult: formatIcon,
        formatSelection: formatIcon,
        escapeMarkup: function (m) {
            return m;
        }
    });

    function formatIcon(obj) {
        if (!obj.id)
            return obj.text; // optgroup
        //alert(JSON.stringify(obj));
        return "<i class='" + obj.id + "'></i> " + obj.text;
    }

    $('.delete_submit').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var urls = url.split('/');
        var conf = confirm("Are you sure you want to delete #" + urls[urls.length - 1] + "?");
        if (conf == true) {
            var form = '<form id="frm_delete_submit" action="' + url + '" method="post" name="delete_submit" style="display:none;"><input type="hidden" name="_method" value="POST"></form>';
            $('body').append(form);
            $('#frm_delete_submit').submit();
        }
    });

    /*
     * Add Options for settings 
     */
    if ($('#setting_type').val() != 'select' && $('#setting_type').val() != 'radio' && $('#setting_type').val() != 'checkbox') {
        $('#setting_options').parent().hide();
    }

    if ($('#setting_options').size() > 0 && $('#setting_options').val() != '') {
        var setting_options = JSON.parse($('#setting_options').val());
        $.each(setting_options, function (x, y) {
            var html = '<div class="row list_setting_options">';
            html += '<div class="col-md-4"><input type="text" placeholder="Key" value="' + y.key + '" name="options[' + x + '][key]" class="form-control" /></div>';
            html += '<div class="col-md-2 text-center">=</div>';
            html += '<div class="col-md-4"><input type="text" placeholder="Value" value="' + y.value + '" name="options[' + x + '][value]" class="form-control" /></div>';
            html += '<div class="col-md-2 text-center"><i class="fa fa-trash btn btn-danger delete_setting_option"></i></div>';
            html += '</div>';
            $('#setting_add_option').before(html);
        });
        $('#setting_options').val('');
    }

    $('#setting_type').change(function () {
        if ($(this).val() == 'select' || $(this).val() == 'radio' || $(this).val() == 'checkbox') {
            $('#setting_options').parent().show();
        } else {
            $('#setting_options').parent().hide();
        }
    });

    $('#setting_add_option').click(function () {
        var count = $('.list_setting_options').size();
        var html = '<div class="row list_setting_options">';
        html += '<div class="col-md-4"><input type="text" placeholder="Key" name="options[' + count + '][key]" class="form-control" /></div>';
        html += '<div class="col-md-2 text-center">=</div>';
        html += '<div class="col-md-4"><input type="text" placeholder="Value" name="options[' + count + '][value]" class="form-control" /></div>';
        html += '<div class="col-md-2 text-center"><i class="fa fa-trash btn btn-danger delete_setting_option"></i></div>';
        html += '</div>';
        $(this).before(html);
    })

    $('.row').on('click', '.delete_setting_option', function () {
        $(this).parents('.list_setting_options').remove();
    });

    /*
     * End add options for settings 
     */

    if ($('#meta_type').val() != 'select' && $('#meta_type').val() != 'radio' && $('#meta_type').val() != 'checkbox') {
        $('#meta_options').parent().hide();
    }

    if ($('#meta_options').size() > 0 && $('#meta_options').val() != '') {
        var meta_options = JSON.parse($('#meta_options').val());
        $.each(meta_options, function (x, y) {
            var html = '<div class="row list_meta_options">';
            html += '<div class="col-md-4"><input type="text" placeholder="Key" value="' + y.key + '" name="options[' + x + '][key]" class="form-control" /></div>';
            html += '<div class="col-md-2 text-center">=</div>';
            html += '<div class="col-md-4"><input type="text" placeholder="Value" value="' + y.value + '" name="options[' + x + '][value]" class="form-control" /></div>';
            html += '<div class="col-md-2 text-center"><i class="fa fa-trash btn btn-danger delete_meta_option"></i></div>';
            html += '</div>';
            $('#meta_add_option').before(html);
        });
        $('#meta_options').val('');
    }

    $('#meta_type').change(function () {
        if ($(this).val() == 'select' || $(this).val() == 'radio' || $(this).val() == 'checkbox') {
            $('#meta_options').parent().show();
        } else {
            $('#meta_options').parent().hide();
        }
    });

    $('#meta_add_option').click(function () {
        var count = $('.list_meta_options').size();
        var html = '<div class="row list_meta_options">';
        html += '<div class="col-md-4"><input type="text" placeholder="Key" name="options[' + count + '][key]" class="form-control" /></div>';
        html += '<div class="col-md-2 text-center">=</div>';
        html += '<div class="col-md-4"><input type="text" placeholder="Value" name="options[' + count + '][value]" class="form-control" /></div>';
        html += '<div class="col-md-2 text-center"><i class="fa fa-trash btn btn-danger delete_meta_option"></i></div>';
        html += '</div>';
        $(this).before(html);
    })

    $('.row').on('click', '.delete_meta_option', function () {
        $(this).parents('.list_meta_options').remove();
    });

    if ($('.model_load_ajax').size() > 0) {
        if ($('.model_load_ajax :checked').val() == undefined) {
            $('.model_load_ajax :radio:first').prop('checked', true);
        }
        get_content_type($('.model_load_ajax :checked').val());
    }

    $('.model_load_ajax input').on('click', function () {
        get_content_type($(this).val());
    });

    if ($('.it_upload_image').size() > 0) {
        $('.it_upload_image').each(function () {
            var value = $(this).prev().val();
            if (value != '') {
                $(this).find('.preview_file').html($('<img>', {class: "img-responsive thumbnail", alt: 'image', src: value}));
                $(this).find('.preview_file').after('<span class="RemoveImages"><i class="fa fa-remove text-danger"></i></span>');
            }
        });
    }
    $('.sidebarF').on('click', '.RemoveImages', function () {
        $(this).parent().prev().val('');
        $(this).prev().html('<i class="fa fa-cloud-upload"></i>');
        $(this).remove();
    });
});

function get_content_type(model) {
    $.ajax({
        url: ittvn.config.base_url + 'admin/metas/metas/content-types',
        data: {model: model},
        dataType: 'json',
        type: 'post',
        success: function (res) {
            var options = '';
            $('.model_get_load_ajax label').remove();

            options = '<label class="radio" for="foreign_key.0"><input type="radio" name="foreign_key" value="" id="foreign_key.0" /><i></i>Global</label>';
            $('.model_get_load_ajax').append(options);

            $.each(res, function (x, y) {
                options = '<label class="radio" for="foreign_key.' + x + '"><input type="radio" name="foreign_key" value="' + x + '" id="foreign_key.' + x + '" /><i></i>' + y + '</label>';
                $('.model_get_load_ajax').append(options);
            });

            $('.model_get_load_ajax input[value="' + $('.model_get_load_ajax').attr('value') + '"]').prop('checked', true);
        }
    });
}