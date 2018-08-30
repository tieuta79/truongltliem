(function ($) {

    $.fn.buttonLoading = function (options) {
        // Establish our default settings
        var settings = $.extend({
            element: 'i',
            parent: true,
            classLoading: 'fa fa-refresh fa-spin',
            callback: null
        }, options);

        this.each(function () {
            if (settings.parent == true) {
                var cl = $(this).find(settings.element).attr('class');
                $(this).find(settings.element).attr('class', settings.classLoading);
                if ($.isFunction(settings.callback)) {
                    settings.callback.call(this);
                }
                $(this).find(settings.element).attr('class', cl);
            } else {
                var cl = $(this).attr('class');
                $(this).attr('class', settings.classLoading);
                if ($.isFunction(settings.callback)) {
                    settings.callback.call(this);
                }
                $(this).attr('class', cl);
            }
        });
    }

}(jQuery));

ittvn.admin = [];
ittvn.site = [];

ittvn.admin.updateValueCheckbox = function () {

}

//ittvn.admin.gallerySortable = function () {
//    $('.gallery_sortable').sortable({
//        placeholder: "col-xs-6 col-md-3 ui-state-highlight",
//        start: function (event, ui) {
//            var arr = [];
//            $('.gallery_sortable img').each(function () {
//                arr.push($(this).attr('media_id'));
//            })
//            $('.gallery_sortable').parent().prev().val(arr);
//        }
//    }).disableSelection();
//}
ittvn.admin.gallerySortable = function () {
    $('.gallery_sortable').sortable({
        placeholder: "col-xs-6 col-md-3 ui-state-highlight",
        start: function (event, ui) {
        },
        stop: function (evt, ui) {
            setTimeout(
                    function () {
                        var ids = '';
                        $('.gallery_sortable img').each(function () {
                            var arr = [];
                            arr.push('["' + $(this).attr('media_id') + '"');
                            arr.push('"' + $(this).attr('src') + '"]');
                            ids += arr.join(',') + ",";

                        });
                        ids = "[" + ids.substring(0, ids.length - 1) + "]";
                        $('.gallery_sortable').parent().prev().delay(800).val(ids);
                    },
                    200
                    )
        }
    }).disableSelection();
}

ittvn.admin.galleryCheckbox = function () {
    $('.galleryTree > ul').attr('role', 'tree').find('ul').attr('role', 'group');
    $('.galleryTree').find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span').attr('title', 'Collapse this branch').on('click', function (e) {
        var children = li.find(' > ul > li');
        if (children.is(':visible')) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i').removeClass().addClass('fa fa-lg fa-folder');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').removeClass().addClass('fa fa-lg fa-folder-open');
        }
        e.stopPropagation();
    });
}

ittvn.admin.formatDate = function (dateObject, format, delimit) {
    if (delimit == undefined) {
        delimit = '-';
    }
    if (format == undefined) {
        format = 'dd' + delimit + "mm" + delimit + "yyyy";
    }

    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }

    return  format.replace('dd', day).replace('mm', month).replace('yyyy', year);
}

ittvn.admin.checkLoginBeforeAjax = function () {
    $(document).ajaxError(function (event, request, settings) {
        window.location = ittvn.config.base_url + 'admin/login';
    });
}

ittvn.admin.action = function () {
    $('.it_dataTable').on('click', '.action_check input', function () {
        if ($(this).val() == 'on') {
            $('.it_dataTable tbody input[type="checkbox"]').prop('checked', true);
            $(this).val('off');
        } else {
            $('.it_dataTable tbody input[type="checkbox"]').removeAttr('checked');
            $(this).val('on');
        }
    })

    var loading = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
    $('.ibox-content .action .action_table').on('change', function () {
        if ($('.dataTable :checked').size() > 0) {
            $('.box-body').after(loading);
            var checked = [];
            $('.dataTable :checked').each(function () {
                checked.push($(this).val());
            });
            $('#action-table-value').val(checked);
            $(this).parents('form').submit();
        } else {
            $(this).val('');
            alert('NO checked.');
        }
    });
}

ittvn.admin.inputDate = function () {
    $('input[type="text"][data-type!=""]').each(function () {
        var data_type = $(this).attr('data-type');
        //$(this).attr('type',data_type);       
        //$(this).trigger(data_type,$(this));

        switch (data_type) {
            case 'date':
                $(this).datepicker();
                break;
            case 'datetime':
                $(this).datetimepicker();
                break;
            case 'daterangepicker':
                $(this).daterangepicker();
                break;
            case 'colorpicker':
                var obj = $(this);
                if (obj.val() != '') {
                    obj.css('background', obj.val());
                }
                $(this).colorpicker().on('changeColor.colorpicker', function (event) {
                    obj.val(event.color.toHex());
                    obj.css('background', event.color.toHex());
                }).on('hide', function (event) {
                    obj.css('background', event.color.toHex());
                });
                break;
            default:

        }
    });
}

ittvn.admin.orderPlugins = function () {
    if ($('.list_plugin').size() > 0) {
        $('.list_plugin').sortable({
            handle: '.forum-icon',
            connectWith: '.list_plugin',
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            opacity: 0.8,
            update: function (event, ui) {
                var strItems = "";

                $(".list_plugin .forum-item").each(function () {
                    strItems += $(this).attr("data-order") + ',';
                });

                //alert(strItems);
            }
        }).disableSelection();
    }
}

ittvn.admin.autoFilter = function () {
    $('.row-table table thead th:not(.row-table table thead th.action_check, .row-table table thead th:last)').each(function () {
        $(this).append('<input style="margin-top: 5px;" type="text" class="it_filter form-control input-sm" placeholder="Enter ' + $(this).text() + '" id="filter_' + $('.row-table table thead th').index(this) + '" value="" />');
    });

    $('.row-table table thead th').on('keyup', '.it_filter', function () {
        var index = $('.row-table table thead th').index($(this).parents('th'));
        //hide all the rows
        $(".row-table table tbody").find("tr").hide();
        //split the current value of searchInput
        var data = this.value.split(" ");
        //create a jquery object of the rows
        var jo = $(".row-table table tbody").find("tr");

        //Recusively filter the jquery object to get results.
        $.each(data, function (i, v) {
            jo = jo.filter("*:contains('" + v + "')");
        });
        //show the rows that match.
        jo.show();
        //Removes the placeholder text  

    }).focus(function () {
        this.value = "";
        $(this).css({"color": "black"});
        $(this).unbind('focus');
    }).css({"color": "#C0C0C0"});

};

ittvn.admin.dataTable = function () {
    if ($('.it_dataTable').size() > 0) {
        var responsiveHelper_datatable_fixed_column = undefined;
        var breakpointDefinition = {
            tablet: 1024,
            phone: 480
        };
        var count_column = $('.it_dataTable thead tr:eq(1) th').size() - 1;
        var columns = [];
        var col_name = '';
        var default_order = [1, 'desc'];
        $('.it_dataTable thead tr:eq(1) th').each(function () {
            col_name = $(this).attr('name');
            if (col_name == 'checkbox' || col_name == 'action') {
                columns.push({name: col_name, searchable: false, orderable: false});
            } else if (col_name == 'id') {
                columns.push({name: col_name, searchable: false, visible: true});
            } else {
                if ($(this).attr('disable_order') != undefined) {
                    columns.push({name: col_name, orderable: false});
                } else {
                    columns.push({name: col_name});
                }
            }

            if ($(this).attr('default_order') != undefined) {
                var index = $('.it_dataTable thead tr:eq(1) th').index($(this));
                default_order = [index, $(this).attr('default_order')];
            }
        });

        var otable = $('.it_dataTable').DataTable({
            responsive: true,
            language: {
                processing: "Đang tải dữ liệu"
            },
            bAutoWidth: false,
            columnDefs: [
                {
                    targets: [0, count_column],
                    bSortable: false
                }
            ],
            columns: columns,
            searching: true,
            order: [default_order],
            sDom: "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs toollast'<'toolbar'>l>r>" +
                    "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            autoWidth: false,
            //sDom: '<"#action-right"l>rt<".dataTables_paginate"ip>',
            //bFilter:false,
            lengthMenu: [[10, 25, 50, 5000], [10, 25, 50, "All"]],
            iDisplayLength: ittvn.config.paging_limit,
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: window.location.href,
                type: 'post',
                data: function (d) {
                    //alert(JSON.stringify(d));
                    //d.myKey = "myValue";
                    // d.custom = $('#myInput').val();
                    // etc
                }
            },
            preDrawCallback: function () {
                if (!responsiveHelper_datatable_fixed_column) {
                    responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('.it_dataTable'), breakpointDefinition);
                }
            },
            rowCallback: function (nRow) {
                responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
            },
            drawCallback: function (oSettings) {
                responsiveHelper_datatable_fixed_column.respond();
            },
            initComplete: function (settings, json) {
                var api = this.api();
                /*
                 var th_filter = '';
                 api.columns().indexes().flatten().each(function (i) {
                 
                 var column = api.column(i);
                 
                 var filter = $('.it_dataTable thead tr:eq(1) th:eq(' + column[0] + ')').attr('filter');
                 
                 if (filter == 'no' || filter == undefined || column.visible() == false) {
                 th_filter += '<th class="hasinput"></th>';
                 } else {
                 var title = $('.it_dataTable thead th:eq(' + column[0] + ')').text();
                 if (filter == 'text') {
                 th_filter += '<th class="hasinput">';
                 th_filter += '<input type="text" class="form-control" placeholder="Filter ' + title + '" />';
                 th_filter += '</th>';
                 } else if (filter == 'list') {
                 th_filter += '<th class="hasinput">';
                 th_filter += '<select class="form-control"><option value="">Choose ' + title + '</option>';
                 column.data().unique().sort().each(function (d, j) {
                 if (d != null) {
                 $(d).filter('span').each(function () {
                 th_filter += '<option value="' + $(this).attr('filter_id') + '">' + $(this).text() + '</option>';
                 });
                 }
                 });
                 th_filter += '</select>';
                 th_filter += '</th>';
                 } else if (filter == 'date') {
                 th_filter += '<th class="hasinput icon-addon">';
                 var id_filter = slugify(title);
                 th_filter += '<input id="filter-' + id_filter + '" type="text" placeholder="Filter ' + title + '" class="form-control datepicker" data-type="date" data-dateformat="yy/mm/dd" />';
                 th_filter += '<label for="filter-' + id_filter + '" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Filter ' + title + '"></label>';
                 th_filter += '</th>';
                 }
                 }
                 });
                 $('.it_dataTable thead').prepend('<tr role="row">' + th_filter + '</tr>');
                 */
            }
        });
        //$('.dataTables_filter').parent().parent().hide();

        //$('.it_dataTable tfoot').each(function () {
        //    $(this).insertBefore($(this).siblings('tbody'));
        //});
        $('.dataTables_filter').html($('#it_search_fix').html());
        $('#it_search_fix').remove();
        $('#q').on('keyup change', function () {
            otable.search($(this).val()).draw();
        })
        // Apply the filter
        $(".it_dataTable thead th input[type=text], .it_dataTable thead th select").on('keyup change', function () {
            otable
                    .column($(this).parents('th').index() + ':visible')
                    .search(this.value)
                    .draw();

        });
        /* END COLUMN FILTER */
        // custom toolbar
        //$("div.toolbar").html($('#it_toolbar_index').html());
    }
};

ittvn.admin.changePermission = function () {
    $('#change_permission_role').change(function () {
        window.location.href = ittvn.config.base_url + 'admin/users/users/permission/' + $(this).val();
    });
}
ittvn.admin.changeExportdata = function () {
    $('#change_export_data').change(function () {
        window.location.href = ittvn.config.base_url + 'admin/extensions/tools/exportdata/' + $(this).val();
    });
}

ittvn.admin.scrollBox = function () {
    $('div[data-scroll="true"]').each(function () {
        var height = $(this).attr('data-height');
        $(this).slimScroll({
            height: height + 'px',
            railOpacity: 0.4,
        });
    });
}

ittvn.admin.SetDefaultImage = function () {
    $('input[type="hidden"][data-type="image"]').each(function (x, y) {
        var value = $(this).val();
        if (value != '') {
            $(this).next().find('.preview_file').html('<img src="' + value + '" class="img-responsive" alt="image" />');
        }
    })
}

ittvn.admin.clickCheckbox = function () {
    $('.checkbox input[type="checkbox"][checked="checked"]').each(function () {
        if ($(this).val() == '' || $(this).val() == undefined) {
            $(this).val(1);
        }
    })
    $('.checkbox input[type="checkbox"]').click(function () {
        if ($(this).attr('name').indexOf('[]') == -1) {
            var clicks = $(this).data("clicks");
            if (clicks) {
                $(this).removeAttr('checked').val(0);
            } else {
                $(this).attr('checked', true).val(1);
            }
            $(this).data("clicks", !clicks);
        }
    });
}

ittvn.admin.resetModal = function () {
    $(document.body).on('hidden.bs.modal', function () {
        $('#modal_ajax').removeData('bs.modal')
    });
}

ittvn.admin.reloadImageInGallery = function () {
    if ($('.it_upload_image').size() > 0) {
        var value = '';
        $('.it_upload_image').each(function () {
            value = $(this).prev().val();
            if (value != '') {
                $(this).find('.preview_file').html(
                        $('<img/>', {
                            class: 'img-responsive thumbnail',
                            src: value
                        })
                        );
            }
        })
    }
}

ittvn.admin.removeImageInGallery = function () {
    $('.preview_file').on('click', '.fa-remove', function () {
        var obj = $(this).parent();
        var index = $('.preview_file .gallery_preview').index(obj);
        var value = obj.parents('.it_upload_image').prev().val();
        var attr = [];
        var attrs = [];
        attr = value.split(',');
        $.each(attr, function (x, y) {
            if (x != index) {
                attrs.push(y);
            }
        });
        obj.parents('.it_upload_image').prev().val(attrs);
        obj.remove();
    });
}

//ittvn.admin.showImageInGallery = function () {
//    if ($('.it_input_gallery').size() > 0) {
//        var image = '';
//        var images = '';
//        var obj = '';
//        $('.it_input_gallery').each(function () {
//            obj_next = $(this).next();
//            image = $(this).val();
//            images = image.split(',');
//            $.each(images, function (x, y) {
//                obj_next.find('.preview_file').append('<div class="col-md-4 gallery_preview"><img src="' + y + '" class="img-responsive" alt="image" /><i class="fa fa-remove text-danger"></i></div>');
//            });
//        })
//    }
//}
ittvn.admin.showImageInGallery = function () {
    if ($('.it_input_gallery').size() > 0 && $('.it_input_gallery').val() != '') {
        var image = $('.it_input_gallery').val();
        //var images = image.replace("{", "").replace("}", "").split(',');
        var images = JSON.parse(image);
        var obj = $('.it_input_gallery').next();
        $.each(images, function (x, y) {
            //var img = y.split(':');
            var img = y;
            obj.find('.preview_files').append('<div class="col-md-3 gallery_preview"><img media_id=' + img[0] + ' src=' + img[1] + ' class="img-responsive thumbnail" alt="image" /><i class="fa fa-remove text-danger imgs-remove"></i></div>');
        });
    }
}

ittvn.admin.deleteImageGallery = function () {
    $('.preview_files').on('click', '.imgs-remove', function () {
        var ids = '';
        $(this).parent().remove();
        $('.preview_files img').each(function () {
            var arr = [];
            arr.push('"' + $(this).attr('media_id') + '"');
            arr.push('"' + $(this).attr('src') + '"');
            ids += arr.join(':') + ",";
        });
        ids = "{" + ids.substring(0, ids.length - 1) + "}";
        $('.it_input_gallery').val(ids);
    });
}

ittvn.admin.submitDelete = function () {
    $('.ibox-content').on('click', '.delete_submit', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.post(url, [], function () {
            window.location.reload(true);
        })
    })
}

ittvn.admin.MultipleUpload = function () {
    $('a[select-file="true"]').click(function () {
        var obj = $(this);
        $('#input_by_upload_ajax').trigger('click');
        $('#input_by_upload_ajax').change(function () {
            $(this).attr('it_remove', '');

            var html_preview = '';
            $.each($(this)[0].files, function (i, file) {

                html_preview += '<div class="col-md-12 file_item" it_id="' + i + '">';
                html_preview += '<div class="row">';
                html_preview += '<div class="col-md-2">' + file.name + '</div>';
                html_preview += '<div class="col-md-4 progress progress-mini"><div class="progress-bar"></div></div>';
                html_preview += '<div class="col-md-1"><a href="javascript:void(0)" class="btn btn-danger btn-sm" delete-file="true" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a></div>';
                html_preview += '</div>';
                html_preview += '</div>';

                //data.append('files[' + i + ']', file);
            });
            obj.parents('.panel-body').find('.list_preview').html(html_preview);
        });
    });

    $('a[upload-file="true"]').click(function (e) {
        e.preventDefault();
        var remove = $('#input_by_upload_ajax').attr('it_remove');
        var arrs = remove.split(',');
        var obj = $(this);
        var data = new FormData();

        //disable button
        obj.find('i').attr('class', 'fa fa-refresh fa-spin disabled');
        //End disable

        $.each($('#input_by_upload_ajax')[0].files, function (i, file) {

            if (in_array(i, arrs) == false || arrs == '') {
                data.append('file', file);
                var field = obj.parents('.panel-body').find('table').attr('it_gallery');
                data.append('field', field);

                $.upload(ittvn.config.base_url + 'admin/medias/medias/upload_file', data)
                        .progress(function (progressEvent, upload) {
                            if (progressEvent.lengthComputable) {
                                var percent = Math.round(progressEvent.loaded * 100 / progressEvent.total) + '%';
                                if (upload) {
                                    console.log(percent + ' uploaded');
                                    obj.parents('.panel-body').find('.list_preview').find('div[it_id="' + i + '"]').find('.progress-bar').css('width', percent);
                                }
                            }
                        })
                        .done(function (res) {
                            obj.parents('.panel-body').find('.list_preview').find('div[it_id="' + i + '"]').fadeOut('medium').remove();
                            console.log('Finished upload');

                            obj.parents('.panel-body').find('input[name="' + field + '"]').remove();
                            var table = obj.parents('.panel-body').find('table tbody');
                            table.append(res.replace(/{{order}}/g, table.find('tr').size()));


                            if ($('#input_by_upload_ajax')[0].files.length == (i + 1)) {
                                obj.find('i').attr('class', 'fa fa-cloud-upload');
                            }

                        });

                data.delete('file');
                //data.append('files[' + i + ']', file);                
            }
        });

    })

    $('.list_preview').on('click', 'a[delete-file="true"]', function (e) {
        e.preventDefault();
        var id = $(this).parents('.file_item').attr('it_id');
        var remove = $('#input_by_upload_ajax').attr('it_remove');
        if (remove == '') {
            remove = id;
        } else {
            remove += ',' + id;
        }
        $('#input_by_upload_ajax').attr('it_remove', remove);
        $(this).parents('.file_item').fadeOut('medium').remove();

    });

    $('table').on('click', 'a[delete-item-file="true"]', function (e) {
        e.preventDefault();
        var obj = $(this);
        var id = obj.parents('tr').attr('it_id');
        $.ajax({
            url: ittvn.config.base_url + 'admin/medias/medias/delete/' + id,
            type: 'post',
            success: function () {
                obj.parents('tr').fadeOut('medium').remove();
            }
        });

    });

    //Show image if edit
    if ($('.it_input_gallery').size() > 0) {
        $('.it_input_gallery').each(function () {
            var obj = $(this);
            if (obj.val() != '') {
                $.ajax({
                    url: ittvn.config.base_url + 'admin/medias/medias/show_file',
                    data: {name: obj.attr('name'), files: obj.val()},
                    type: 'post',
                    success: function (res) {
                        obj.parents('.panel-body').find('table tbody').append(res);
                        obj.remove();
                    }
                });
            }
        })
    }
}

ittvn.admin.textCode = function () {
    $('textarea[data-type="code"]').each(function () {
        var mode = 'application/x-httpd-php';
        if ($(this).attr('mode') == 'js' || $(this).attr('mode') == 'json') {
            mode = 'javascript';
        } else if ($(this).attr('mode') == 'sql') {
            mode = 'text/x-mysql';
        } else if ($(this).attr('mode') == 'css') {
            mode = 'text/css';
        }

        var code = CodeMirror.fromTextArea(this, {
            mode: mode,
            lineNumbers: true,
            styleActiveLine: true,
            matchBrackets: true,
            indentUnit: 4,
            indentWithTabs: true,
            //autoRefresh:true,
            extraKeys: {"Ctrl-Space": "autocomplete"}
        });

        // to fix code mirror not showing up until clicked
        $(document).on('click', 'a[data-parent="#theme_options"]', function () {
            this.refresh();
        }.bind(code));
    });
}

ittvn.admin.editor = function () {
    $('textarea[data-type="editor"]').summernote();
}

ittvn.admin.help = function () {
    $('.block-right-help .help-toggle').click(function () {
        if ($(this).attr('data-open') == 'close') {
            $(this).attr('data-open', 'open');
            $(this).find('i').attr('class', 'fa fa-times-circle-o');
            $('.block-right-help').animate({right: '+=500'}, 'medium');
        } else {
            $(this).attr('data-open', 'close');
            $(this).find('i').attr('class', 'fa fa-info-circle');
            $('.block-right-help').animate({right: '-=500'}, 'medium');
        }

    })
}
ittvn.admin.ajaxLanguage = function () {
    $('.ajaxLanguages').click(function () {
        if ($(this).is("[disabled=disabled]") == false) {
            var id = ittvn.config.params.pass[0];
            $.ajax({
                url: "/admin/contents/contents/ajax/" + id + "/posts",
                type: 'post',
                async: false,
                dataType: 'json',
                data: {},
                success: function (data) {
                    $('#name').val(data.content.name);
                    $('#excerpt').val(data.content.excerpt);
                    $('#slug').val(data.content.slug);
                    $('#description').next().find('.note-editable').text(data.content.description);
                    $('.preview_file img').attr('src', data.content.image);
                }
            });
        }
        $(this).attr('disabled', 'disabled');
        return false;
    });
    $('.ajaxLangCategories').click(function () {
        if ($(this).is("[disabled=disabled]") == false) {
            var id = ittvn.config.params.pass[0];
            $.ajax({
                url: "/admin/contents/categories/ajax/" + id + "/categories",
                type: 'post',
                async: false,
                dataType: 'json',
                data: {},
                success: function (data) {
                    $('#name').val(data.category.name);
                    $('#slug').val(data.category.slug);
                    $('#description').text(data.category.description);
                }
            });
        }
        $(this).attr('disabled', 'disabled');
        return false;
    });

}

ittvn.admin.ajaxDeletepermission = function () {
    $('#DeleteSet').click(function () {
        if ($('input[name="SellectedAdmin[]"]:checked').length > 0) {
            var arr = $('input[name="SellectedAdmin[]"]:checked');
            var data = [];
            $.each(arr, function (i, val) {
                data.push($(this).val());
            });
            $.ajax({
                url: ittvn.config.base_url + 'admin/users/users/deleteset/' + data,
                type: 'post',
                success: function (msg) {
                    //console.log(msg);
                    window.location.reload();
                }
            });

        }
        return false;
    });
}


$(document).ready(function () {
    ittvn.admin.help();
    ittvn.admin.clickCheckbox();
    //ittvn.admin.checkLoginBeforeAjax();
    ittvn.admin.action();
    ittvn.admin.inputDate();
    ittvn.admin.orderPlugins();
    ittvn.admin.changePermission();
    ittvn.admin.changeExportdata();
    ittvn.admin.dataTable();
    //ittvn.admin.submitDelete();
    ittvn.admin.scrollBox();
    ittvn.admin.SetDefaultImage();
    ittvn.admin.resetModal();
    ittvn.admin.removeImageInGallery();
    ittvn.admin.showImageInGallery();
    //ittvn.admin.MultipleUpload();
    ittvn.admin.gallerySortable();
    ittvn.admin.galleryCheckbox();
    ittvn.admin.updateValueCheckbox();

    ittvn.admin.reloadImageInGallery();
    ittvn.admin.textCode();
    ittvn.admin.editor();
    ittvn.admin.ajaxLanguage();
    ittvn.admin.ajaxDeletepermission();
    ittvn.admin.deleteImageGallery();
});

$(window).load(function () {
    runAllForms();
    setup_widgets_desktop();
})

function in_array(needle, haystack, argStrict) {
    //  discuss at: http://phpjs.org/functions/in_array/
    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: vlado houba
    // improved by: Jonas Sciangula Street (Joni2Back)
    //    input by: Billy
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //   example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
    //   returns 1: true
    //   example 2: in_array('vlado', {0: 'Kevin', vlado: 'van', 1: 'Zonneveld'});
    //   returns 2: false
    //   example 3: in_array(1, ['1', '2', '3']);
    //   example 3: in_array(1, ['1', '2', '3'], false);
    //   returns 3: true
    //   returns 3: true
    //   example 4: in_array(1, ['1', '2', '3'], true);
    //   returns 4: false

    var key = '',
            strict = !!argStrict

    // we prevent the double check (strict && arr[key] === ndl) || (!strict && arr[key] == ndl)
    // in just one for, in order to improve the performance
    // deciding wich type of comparation will do before walk array
    if (strict) {
        for (key in haystack) {
            if (haystack[key] === needle) {
                return true
            }
        }
    } else {
        for (key in haystack) {
            if (haystack[key] == needle) {
                return true
            }
        }
    }

    return false
}

function slugify(text) {
    return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
}