var menus = [];
menus.site = [];
menus.admin = [];

menus.admin.addMenuType = function () {
    $('.save_menutype').click(function () {
        var name = $('#menutype input[name="menutype[name]"]').val();
        var slug = $('#menutype input[name="menutype[slug]"]').val();
        var description = $('#menutype textarea[name="menutype[description]"]').val();
        $.ajax({
            url: ittvn.config.base_url + 'admin/menus/menutypes/add',
            type: 'post',
            data: {name: name, slug: slug, description: description},
            dataType: 'json',
            success: function (res) {
                if (res.success == true) {
                    $('#menutype').prepend('<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' + res.message + '.</div>');
                    window.location.reload(true);
                } else {
                    $('#menutype').prepend('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' + res.message + '.</div>');
                }
            }
        });
        return false;
    });
}

menus.admin.changeMenuType = function () {
    $('#menutype-id').change(function () {
        var value = $(this).val();
        if (value != '') {
            window.location = ittvn.config.base_url + 'admin/menus/menus/index/' + value;
        }
    });
}

menus.admin.checkAllMenus = function () {
    $('.checkall_menu').on('click', function () {
        if ($(this).val() == 'on') {
            $(this).parents('.widget-body').find('.box_menu :checkbox').prop('checked', true);
            $(this).val('off');
        } else {
            $(this).parents('.widget-body').find('.box_menu :checkbox').removeAttr('checked');
            $(this).val('on');
        }
    });
}

menus.admin.addMenus = function () {
    $('.add_menu').on('click', function () {
        var menutype_id = $('#menutype-id').val();
        var type = $.trim($(this).parents('.widget-body').prev().find('h5').text());
        var posttype = $(this).attr('posttype');

        if (menutype_id == '')
            return false;

        if (posttype != 'link') {
            $(this).parents('.widget-body').find('.box_menu :checked').each(function (x, y) {
                var id = $(this).val();
                var name = $.trim($(this).parents('label').text());

                if (posttype == 'Contents') {
                    $.ajax({
                        url: ittvn.config.base_url + 'admin/menus/menus/add',
                        type: 'post',
                        data: {name: name, content_id: id, menutype_id: menutype_id},
                        dataType: 'json',
                        success: function (res) {
                            if (res.status == true && res.data != '') {
                                $('#nestable > ol').append(res.data);
                            }
                        }
                    });
                } else if (posttype == 'Categories') {
                    $.ajax({
                        url: ittvn.config.base_url + 'admin/menus/menus/add',
                        type: 'post',
                        data: {name: name, category_id: id, menutype_id: menutype_id},
                        dataType: 'json',
                        success: function (res) {
                            if (res.status == true && res.data != '') {
                                $('#nestable > ol').append(res.data);
                            }
                        }
                    });
                }

                //reset checkbox
                $(this).parents('.widget-body').find('.box_menu :checkbox').removeAttr('checked');
                if ($(this).parents('.widget-body').find('.checkall_menu').val() == 'off') {
                    $(this).parents('.widget-body').find('.checkall_menu').trigger('click');
                }
            });
        } else {
            var title_link = $('#title-link').val();
            var url = $('#link').val();
            if (title_link != '') {
                $.ajax({
                    url: ittvn.config.base_url + 'admin/menus/menus/add',
                    type: 'post',
                    data: {name: title_link, url: url, menutype_id: menutype_id},
                    dataType: 'json',
                    success: function (res) {
                        if (res.status == true && res.data != '') {
                            $('#nestable > ol').append(res.data);
                        }
                    }
                });
                $('#title-link').val('');
                $('#link').val('');
            }            
        }
        
        $('#nestable').trigger('change');
        $('#nestable-output').val(JSON.stringify($('#nestable').nestable('serialize')));
        //scroll top
        $('html,body').animate({scrollTop: $('header[role="heading"]').offset().top}, 'slow');
    });
}

menus.admin.removeMenus = function () {
    $('#nestable').on('click', '.remove_menu', function (e) {
        $(this).parent().parent().parent().remove();
        $('#nestable').trigger('change');
        $('#nestable-output').val(JSON.stringify($('#nestable').nestable('serialize')));
    });
}

menus.admin.updateMenu = function (menu, parent_id) {
    $(menu).each(function (x, y) {
        if (y.children != undefined) {
            $('#nestable input[type="hidden"][name="menus[' + (y.id) + '][parent_id]"]').val(parent_id);
            menus.admin.updateMenu(y.children, y.id);
        } else {
            $('#nestable input[type="hidden"][name="menus[' + (y.id) + '][parent_id]"]').val(parent_id);
        }
    })
}

menus.admin.ChangeTitle = function () {
    $('#nestable').on('keyup', '.change_title_menu', function (e) {
        $(this).parent().parent().parent().parent().find('.title_menu').html($(this).val());
    })
}

$(document).ready(function () {
    menus.admin.addMenuType();
    menus.admin.changeMenuType();
    menus.admin.checkAllMenus();
    menus.admin.ChangeTitle();

    $('#nestable').nestable({
        group: 1
    }).on('change', function (e) {
        var list = e.length ? e : $(e.target);
        menus.admin.updateMenu(list.nestable('serialize'), '');
        $('#nestable-output').val(JSON.stringify(list.nestable('serialize')));
    });

    $('#nestable').on('mousedown', 'i', function (e) {
        e.preventDefault();
        return false;
    });

    menus.admin.addMenus();
    menus.admin.removeMenus();
});