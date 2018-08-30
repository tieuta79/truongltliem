var medias = [];
medias.admin = [];
medias.site = [];

medias.admin.selectType = function () {
    medias.admin.showHideType($('#type').val());
    $('#type').change(function () {
        medias.admin.showHideType($(this).val());
    });
}

medias.admin.showHideType = function (type) {
    if (type == 0) {
        $('#input-galleries').parent().show();
        $('#input-categories').parent().hide();
        $('#input-contents').parent().hide();
    } else if (type == 1) {
        $('#input-galleries').parent().hide();
        $('#input-categories').parent().show();
        $('#input-contents').parent().hide();
    } else if (type == 2) {
        $('#input-galleries').parent().hide();
        $('#input-categories').parent().hide();
        $('#input-contents').parent().show();
    } else if (type == 3) {
        $('#input-galleries').parent().hide();
        $('#input-categories').parent().hide();
        $('#input-contents').parent().hide();
    }
}

medias.admin.checboxToggle = function () {
    $('.toggle input[type="checkbox"]').click(function () {
        var clicks = $(this).data("clicks");
        if (clicks) {
            $(this).removeAttr('checked').val(0);
        } else {
            $(this).attr('checked', true).val(1);
        }
        $(this).data("clicks", !clicks);
    });
}

medias.admin.layersDrag = function () {
    $(".layerslider .ls-l").draggable({containment: ".layerslider", scroll: true});
}

medias.admin.changeBg = function () {
    $('input:radio[id*="-bg-"]').on('change', function () {
        if ($(this).val() == 0) {
            $(this).parents('.panel-body').find('.btn_change_bg').removeAttr('disabled');
            $(this).parents('.panel-body').find('input[id*="-bg-color"]').attr('disabled', 'disabled');
        } else if ($(this).val() == 1) {
            $(this).parents('.panel-body').find('.btn_change_bg').attr('disabled', 'disabled');
            $(this).parents('.panel-body').find('input[id*="-bg-color"]').attr('disabled', 'disabled');
        } else if ($(this).val() == 2) {
            $(this).parents('.panel-body').find('.btn_change_bg').attr('disabled', 'disabled');
            $(this).parents('.panel-body').find('input[id*="-bg-color"]').removeAttr('disabled');
        }
    });
}

medias.admin.addLayer = function () {
    $('.btn_add_layer').click(function () {
        var text = $('<div/>', {
            class: 'ls-l slide_typo',
            text: 'Caption text'
        });
        $(this).parents('.tab-pane').find('div[id^="custom_slideshow-"]').find('.ls-slide').append(text);
        medias.admin.layersDrag();
        
        //scroll top
        $('html,body').animate({scrollTop: $('div[id^="custom_slideshow-"]').offset().top}, 'slow');
    });
}

medias.admin.chooseLayer = function () {
    $('.layerslider').on('click', '.ls-l', function () {
        $(this).parents('.ls-slide').find('.selected').removeClass('selected');
        $(this).addClass('selected');
        medias.admin.loadAttrLayer(this);
    });
}

medias.admin.loadAttrLayer = function(obj){
    var html = $(this).html();
    $(this).parents('.tab-pane').find('div[id^="collapseLayerGeneral-"]').find('textarea[id*="-layer-text"]').val(html);
}

$(document).ready(function () {
    if (ittvn.config.params.prefix == 'admin') {
        medias.admin.selectType();
        medias.admin.checboxToggle();
        medias.admin.changeBg();
        medias.admin.layersDrag();
        medias.admin.addLayer();
        medias.admin.chooseLayer();
    }
})