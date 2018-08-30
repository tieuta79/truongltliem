$(document).ready(function () {
    // DO NOT REMOVE : GLOBAL FUNCTIONS!
    pageSetUp();

    /*
     * PAGE RELATED SCRIPTS
     */

    $(".js-status-update a").click(function () {
        var selText = $(this).text();
        var $this = $(this);
        $this.parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
        $this.parents('.dropdown-menu').find('li').removeClass('active');
        $this.parent().addClass('active');
    });

});
