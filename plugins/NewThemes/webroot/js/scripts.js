var itTheme = [];
itTheme.sites = [];

itTheme.sites.menusDropdown = function () {
    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).slideDown();
        $(this).addClass('open');
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).slideUp();
        $(this).removeClass('open');
    });
}

itTheme.sites.inputType = function () {
    $('input[data-type], textarea[data-type]').each(function () {
        switch ($(this).attr('data-type')) {
            case 'date':
                var options = {};
                if ($(this).attr('data-format') != undefined) {
                    options.format = $(this).attr('data-format');
                }
                $(this).datepicker(options);
                break;
        }
    })
}

itTheme.sites.tooltip = function () {
    $('[data-toggle="tooltip"]').tooltip()
}

itTheme.sites.carousel = function () {
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 3,
                nav: false
            },
            1000: {
                items: 5,
                nav: true,
                loop: false,
                margin: 20
            }
        }
    });
}

itTheme.sites.scrollBox = function () {
    $('div[data-scroll="true"]').each(function () {
        var height = $(this).attr('data-height');
        if (height == undefined) {
            height = $(window).height();
            $('div[data-scroll="true"]').slimScroll({
                height: height + 'px',
                railOpacity: 0.4,
                railVisible: true,
                alwaysVisible: true,
                color: '#0275d8',
                size: '10px',
                railColor: '#fff',
            });
        } else {
            $('div[data-scroll="true"]').slimScroll({
                height: height + 'px',
                railOpacity: 0.4,
                railVisible: true,
                alwaysVisible: true,
                color: '#0275d8',
                size: '10px',
                railColor: '#fff',
            });
        }
    });
}

itTheme.sites.modal = function () {
    $('body').on('click', '*[data-modal]', function (e) {
        e.preventDefault();
        var obj = $(this);
        var url = '';
        var target = obj.attr('data-target');

        if ($(target).css('display') != 'none') {
            $(target).find('.itmodal-content').empty();
        }

        if (obj.attr('href') != undefined) {
            url = obj.attr('href');
        }
        $(target).fadeIn('medium', function () {
            if (url != '') {
                $(this).find('.itmodal-content').load(url, function () {
                    itTheme.sites.scrollBox();
                });
            }
        });

        $('body').css('overflow-y', 'hidden');
    }).on('click', '*[data-modal="close"]', function (e) {
        $(this).parent('.itmodal').fadeOut('medium', function () {
            $('body').css('overflow-y', '');
            $(this).find('.itmodal-content').empty();
        })
    });
}

itTheme.sites.validateForm = function () {
    $('body').on('click', 'form[data-validate] button.btn-submit, form[data-validate] input.btn-submit', function (e) {
        e.preventDefault();
        var form = $(this).parents('form');
        var data = form.serializeArray();
        var type_validate = form.attr('data-validate');
        var data_validate = [];
        var obj = '';
        var error = '';
        if (data.length > 0) {
            $.each(data, function (x, y) {
                if (y.name != '_method') {
                    obj = form.find('*[name="' + y.name + '"]');
                    data_validate = obj.attr('data-validate');
                    if (data_validate != undefined) {
                        $.each($.parseJSON(data_validate), function (i, validate) {
                            $.each(validate, function (type, message) {
                                if (eval("typeof itvalidate." + type + " === 'function'")) {
                                    if (!eval('itvalidate.' + type)(obj)) {
                                        error += '<li title="' + message + '">' + message + '</li>';
                                    }
                                }
                            });
                        });
                    }
                }
            });
        }

        if (error != '') {
            swal({
                title: "Error",
                text: '<ul class="message_error">' + error + '</ul>',
                type: 'error',
                html: true,
                confirmButtonText: 'OK'
            });
        } else {
            if (type_validate == 'submit') {
                form.submit();
            } else if (type_validate == 'ajax') {
                //loading
                var btn = $(this);
                var i = btn.find('i').attr('class');
                btn.find('i').attr('class', 'fa fa-spinner fa-spin fa-fw');

                $.ajax({
                    url: form.attr('action'),
                    headers: {'X-IT-AUTHORIZE': 'ITFORM'},
                    data: form.serialize(),
                    type: 'post',
                    dataType: 'json',
                    success: function (res) {
                        if (form.attr('callback') != undefined) {
                            if (eval("typeof " + form.attr('callback') + " === 'function'")) {
                                eval(form.attr('callback'))(obj, form, res, 'success');
                            }
                        } else {
                            if (res.status == true) {
                                swal({
                                    title: "User registered.",
                                    text: res.message,
                                    type: 'success',
                                    confirmButtonText: 'OK'
                                }, function (isConfirm) {
                                    if (isConfirm) {
                                        if (form.parents('.itmodal').size() > 0) {
                                            form.parents('.itmodal').fadeOut('medium', function () {
                                                $('body').css('overflow-y', '');
                                                $(this).find('.itmodal-content').empty();
                                            })
                                        }
                                    }
                                });
                            } else {
                                swal({
                                    title: "User registered.",
                                    text: res.message,
                                    type: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    },
                    error: function (jqXHR) {
                        if (form.attr('callback') != undefined) {
                            if (eval("typeof " + form.attr('callback') + " === 'function'")) {
                                eval(form.attr('callback'))(obj, form, jqXHR, 'error');
                            }
                        } else {
                            swal({
                                title: "User registered.",
                                text: 'Error',
                                type: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    complete: function () {
                        btn.find('i').attr('class', i);
                    }
                });
            }
        }
    });
}

$(document).ready(function () {
    if (ittvn.config.params.prefix != 'admin') {
        itTheme.sites.menusDropdown();
        itTheme.sites.inputType();
        itTheme.sites.tooltip();
        itTheme.sites.carousel();
        itTheme.sites.scrollBox();
        itTheme.sites.modal();
        itTheme.sites.validateForm();
    }
});

$(window).resize(function () {
    if (ittvn.config.params.prefix != 'admin') {
        itTheme.sites.scrollBox();
    }
})