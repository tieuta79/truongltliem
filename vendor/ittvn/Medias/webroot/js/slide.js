$(document).ready(function () {
    var path = '';
    $('script').each(function (x, y) {
        var src = $(this).attr('src');
        if (src != undefined && src.indexOf('/medias/js/slide.js') != -1) {
            path = src;
            return true;
        }
    });

    $("#layerslider").layerSlider({
        pauseOnHover: getParameterByName('hover', path),
        skinsPath: ittvn.config.base_url + 'medias/skins/'
    });
});

function getParameterByName(name, url) {
    if (!url) {
        url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
    if (!results)
        return null;
    if (!results[2])
        return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}