jQuery(document).ready(function ($) {
    var nt_title = $('#homecategory-5 ul').newsTicker({
        row_height: 40,
        max_rows: 5,
        duration: 3000,
        pauseOnHover: 0
    });

    $(".fancybox").fancybox();       
});