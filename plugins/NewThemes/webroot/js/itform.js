var itform = [];

itform.register = function (obj, form, res, type) {
    if (type == 'success') {
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
    } else if (type == 'error') {
        swal({
            title: "User registered.",
            text: 'Error',
            type: 'error',
            confirmButtonText: 'OK'
        });
    }
}

itform.login = function (obj, form, res, type) {
    if (type == 'success') {
        if (res.status == true) {
            $.ajax({
                url: ittvn.config.base_url + 'it-themes/it-themes/reloadElement',
                data: {element: 'header'},
                headers: {'X-IT-AUTHORIZE': 'ITFORM'},
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    if (res.status == true) {
                        if (form.parents('.itmodal').size() > 0) {
                            form.parents('.itmodal').fadeOut('medium', function () {
                                var header = $(res.data).html();
                                $('header').html(header);
                                itTheme.sites.tooltip();

                                $('body').css('overflow-y', '');
                                $(this).find('.itmodal-content').empty();

                                if (ittvn.config.params.action == 'login') {
                                    window.location.href = '/';
                                }
                            })
                        }
                        window.location.reload();
                    } else {
                        window.location.reload();
                    }
                },
                error: function () {
                    window.location.reload();
                }
            });
        } else {
            swal({
                title: "Error login.",
                text: res.message,
                type: 'error',
                confirmButtonText: 'OK'
            });
        }
    } else if (type == 'error') {
        swal({
            title: "Error login.",
            text: 'Error login.',
            type: 'error',
            confirmButtonText: 'OK'
        });
    }
}

itform.update_info = function (obj, form, res, type) {
    if (type == 'success') {
        if (res.status == true) {
            $.ajax({
                url: ittvn.config.base_url + 'it-themes/it-themes/reloadElement',
                data: {element: 'header'},
                headers: {'X-IT-AUTHORIZE': 'ITFORM'},
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    if (res.status == true) {
                        var header = $(res.data).html();
                        $('header').html(header);
                        itTheme.sites.tooltip();

                        swal({
                            title: "Cập nhật thông tin cá nhân",
                            text: res.message,
                            type: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        window.location.reload();
                    }
                },
                error: function () {
                    window.location.reload();
                }
            });
        } else {
            if (res.data == 'redirect') {
                window.location.reload();
            } else {
                swal({
                    title: "Cập nhật thông tin cá nhân",
                    text: res.message,
                    type: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    } else if (type == 'error') {
        swal({
            title: "Cập nhật thông tin cá nhân",
            text: res.message,
            type: 'error',
            confirmButtonText: 'OK'
        });
    }
}

itform.update_school = function (obj, form, res, type) {
    if (type == 'success') {
        if (res.status == true) {
            swal({
                title: "Cập nhật thông tin đơn vị",
                text: res.message,
                type: 'success',
                confirmButtonText: 'OK'
            });
        } else {
            if (res.data == 'redirect') {
                window.location.reload();
            } else {
                swal({
                    title: "Cập nhật thông tin đơn vị",
                    text: res.message,
                    type: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    } else if (type == 'error') {
        swal({
            title: "Cập nhật thông tin đơn vị",
            text: res.message,
            type: 'error',
            confirmButtonText: 'OK'
        });
    }
}

itform.update_password = function (obj, form, res, type) {
    if (type == 'success') {
        if (res.status == true) {
            swal({
                title: "Đổi mật khẩu",
                text: res.message,
                type: 'success',
                confirmButtonText: 'OK'
            }, function (isConfirm) {
                if (isConfirm) {
                    $.each(form.find('input'), function () {
                        $(this).val('');
                    })
                }
            });
        } else {
            if (res.data == 'redirect') {
                window.location.reload();
            } else {
                swal({
                    title: "Đổi mật khẩu",
                    text: res.message,
                    type: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    } else if (type == 'error') {
        swal({
            title: "Đổi mật khẩu",
            text: res.message,
            type: 'error',
            confirmButtonText: 'OK'
        });
    }

}
itform.setting_website = function (obj, form, res, type) {
    if (type == 'success') {
        if (res.status == true) {
            swal({
                title: "Cập nhật giao diện thành công",
                text: res.message,
                type: 'success',
                confirmButtonText: 'OK'
            },
                    function (isConfirm) {
                        if (isConfirm == true) {
                            window.location.reload();
                        }
                    });
        } else {
            if (res.data == 'redirect') {
                window.location.reload();
            } else {
                swal({
                    title: "Cập nhật giao diện thành công",
                    text: res.message,
                    type: 'error',
                    confirmButtonText: 'OK'
                });
            }

        }
    } else if (type == 'error') {
        swal({
            title: "Cập nhật giao diện thành công",
            text: res.message,
            type: 'error',
            confirmButtonText: 'OK'
        });
    }
}