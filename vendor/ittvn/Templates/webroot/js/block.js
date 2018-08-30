var blocks = [];
blocks.admin = [];
blocks.admin.loadMetaCategories = function (obj, meta_type_id) {
    if (meta_type_id != '') {
        var nextObj = obj.parents('form').find('.choose_category');
        $.ajax({
            url: ittvn.config.base_url + 'admin/metas/metaCategories/listCategories/' + meta_type_id,
            data: {},
            type: 'post',
            dataType: 'json',
            success: function (res) {
                var selected = 0;
                obj.empty();
                if (res.status == true) {
                    $('<option/>', {
                        value: '',
                        text: 'Select All'
                    }).appendTo(obj);
                    var i = 0;
                    $.each(res.data, function (x, y) {
                        $('<option/>', {
                            value: x,
                            text: y
                        }).appendTo(obj);
                        if (i == 0) {
                            selected = x;
                        }
                        i++;
                    });
                }
                blocks.admin.loadCategories(nextObj, selected);
            }
        });
    }
}

blocks.admin.loadCategories = function (obj, meta_category_id) {
    //if (meta_category_id != '') {
    var nextObj = obj.parents('form').find('.choose_post');
    $.ajax({
        url: ittvn.config.base_url + 'admin/contents/categories/listCategories/' + meta_category_id,
        data: {},
        type: 'post',
        dataType: 'json',
        success: function (res) {
            var selected = 0;
            obj.empty();
            if (res.status == true) {
                $('<option/>', {
                    value: '',
                    text: 'Select All'
                }).appendTo(obj);
                var i = 0;
                $.each(res.data, function (x, y) {
                    $('<option/>', {
                        value: x,
                        text: y
                    }).appendTo(obj);
                    if (i == 0) {
                        selected = x;
                    }
                    i++;
                });
            }
            blocks.admin.loadContents(nextObj, selected);
        },
        error: function () {
            obj.empty();
        }
    });
    //}
}

blocks.admin.loadContents = function (obj, category_id) {
    //if (category_id != '') {
    var objMetaType = obj.parents('form').find('.choose_meta_type').val();
    $.ajax({
        url: ittvn.config.base_url + 'admin/contents/contents/listContents/' + category_id,
        data: {meta_type_id: objMetaType},
        type: 'post',
        dataType: 'json',
        success: function (res) {
            obj.empty();
            if (res.status == true) {
                $('<option/>', {
                    value: '',
                    text: 'Select All'
                }).appendTo(obj);
                $.each(res.data, function (x, y) {
                    $('<option/>', {
                        value: x,
                        text: y
                    }).appendTo(obj);
                });
            }
        },
        error: function () {
            obj.empty();
        }
    });
    //}
}

$(document).ready(function () {
    var new_and_update_order = true;

    $("#cells li").draggable({
        connectToSortable: ".block",
        helper: "clone",
        revert: "invalid",
        opacity: 0.4,
    });

    $(".block").sortable({
        revert: true,
        start: function (event, ui) {
            var start_pos = ui.item.index();
            ui.item.data('start_pos', start_pos);
        },
        update: function (event, ui) {
            var start_pos = ui.item.data('start_pos');
            var end_pos = ui.item.index();
            var block_id = $(this).parents('.widget-body').attr('block_id');
            if (start_pos != end_pos) {
                var t = setInterval(function () {
                    if (new_and_update_order == true) {
                        clearInterval(t);
                        orderModule(block_id, start_pos, end_pos);
                    }
                }, 1000);
                //alert(start_pos + ' ' + end_pos);
            }
        },
        receive: function (event, ui) {
            var html = [];
            var itemId = guid();
            $(this).find('li').each(function () {
                //html.push('<div class="block-item">' + $(this).html() + '</div>');
                html.push($(this).html().replace('[!block_id!]', itemId));
            });

            var cell = $(this).find('li').find('.dd-handle').attr('cell');
            var block_id = $.trim($(this).parents('.widget-body').attr('block_id'));
            var obj = $(this);
            new_and_update_order = false;
            $.ajax({
                url: ittvn.config.base_url + 'admin/blocks/blocks/module/' + cell,
                sync: true,
                type: 'post',
                data: {},
                success: function (res) {
                    var form = '<div class="collapse box_widget_cell form-horizontal" id="' + itemId + '">';
                    form += res;
                    form += '</div>';
                    obj.find('li').replaceWith('<div class="block-item">' + html.join('') + form + '</div>');
                    saveModule(obj.find('#' + itemId).find('form'), block_id, cell, 'null');
                }
            });
        }
    });

    $('.block').on('click', '.cell_button button', function () {
        $(this).buttonLoading({
            callback: function () {
                var form = $(this).parents('form');
                var block_item = $(this).parents('.block-item');
                var box_content = $(this).parents('.widget-body');
                var block_id = $.trim(box_content.attr('block_id'));
                var cell = $(this).parents('.box_widget_cell').prev().attr('cell');
                var id = $('#block' + block_id + ' .block-item').index(block_item);
                saveModule(form, block_id, cell, id);
            }
        });
    }).on('click', '.remove_cell', function () {
        $(this).buttonLoading({
            parent: false,
            callback: function () {
                var block_id = $.trim($(this).parents('.widget-body').attr('block_id'));
                var block_item = $(this).parents('.block-item');
                var id = $('#block' + block_id + ' .block-item').index(block_item);
                deleteModule(block_item, block_id, id);
            }
        });
    }).on('keyup', '.block-cell-title', function () {
        $(this).parents('.block-item').find('.title_block').text($(this).val());
    }).on('change', '.choose_meta_type', function () {
        var obj = $(this).parents('form').find('.choose_meta_category');
        blocks.admin.loadMetaCategories(obj, $(this).val());
    }).on('change', '.choose_meta_category', function () {
        var obj = $(this).parents('form').find('.choose_category');
        blocks.admin.loadCategories(obj, $(this).val());
    }).on('change', '.choose_category', function () {
        var obj = $(this).parents('form').find('.choose_post');
        blocks.admin.loadContents(obj, $(this).val());
    });



    $('.blocks').on('click', '.remove_block', function () {
        $(this).buttonLoading({
            parent: false,
            callback: function () {
                var blocks = $(this).parents('.blocks');
                var block_id = $.trim($(this).parents('.ibox-title').next().attr('block_id'));
                deleteBlock(blocks, block_id);
            }
        });
    });


    function guid() {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                    .toString(16)
                    .substring(1);
        }
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
                s4() + '-' + s4() + s4() + s4();
    }

    function saveModule(form, block_id, cell, id_cell) {
        $.ajax({
            url: ittvn.config.base_url + 'admin/blocks/blocks/saveModule/' + block_id + '/' + cell + '/' + id_cell,
            type: 'post',
            sync: true,
            data: form.serializeArray(),
            success: function (res) {
                new_and_update_order = true;
            }
        });
    }

    function deleteModule(block_item, block_id, id_cell) {
        $.ajax({
            url: ittvn.config.base_url + 'admin/blocks/blocks/deleteModule/' + block_id,
            type: 'post',
            sync: true,
            data: {cell: id_cell},
            success: function (res) {
                block_item.remove().fadeOut('medium');
            }
        });
    }

    function orderModule(block_id, start, end) {
        $.ajax({
            url: ittvn.config.base_url + 'admin/blocks/blocks/orderModule/' + block_id,
            data: {start: start, end: end},
            type: 'post',
            sync: true,
            success: function (res) {

            }
        });
    }

    function deleteBlock(blocks, block_id) {
        $.ajax({
            url: ittvn.config.base_url + 'admin/blocks/blocks/delete',
            type: 'post',
            sync: true,
            data: {id: block_id},
            success: function (res) {
                blocks.remove().fadeOut('medium');
            }
        });
    }

    $('.save_block').click(function () {
        var name = $('#add_block input[name="block[name]"]').val();
        var slug = $('#add_block input[name="block[slug]"]').val();
        var description = $('#add_block textarea[name="block[description]"]').val();
        $.ajax({
            url: ittvn.config.base_url + 'admin/blocks/blocks/add',
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

    $('.block').on('keyup', '.change_title_block', function (e) {
        $(this).parents('.block-item').find('.title_block').html($(this).val());
    });

})


