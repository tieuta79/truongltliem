$(document).ready(function () {
    $("input").iCheck({
        checkboxClass: "icheckbox_flat-blue",
        radioClass: "iradio_flat-blue"
    });
    $(".checkbox-toggle").click(function () {
        var clicks = $(this).data("clicks");
        if (clicks) {
            $(".table input[type='checkbox']").iCheck("uncheck");
            $(".fa", ".checkbox-toggle").removeClass("fa-check-square-o").addClass("fa-square-o");
        } else {
            $(".table input[type='checkbox']").iCheck("check");
            $(".fa", ".checkbox-toggle").removeClass("fa-square-o").addClass("fa-check-square-o");
        }
        $(this).data("clicks", !clicks);
    });
    $("select").select2();
});