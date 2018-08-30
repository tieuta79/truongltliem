var itvalidate = [];
itvalidate.empty = function (input) {
    return input.val() == '' ? false : true;
}

itvalidate.email = function (input) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(input.val());
}

itvalidate.number = function (input) {
    return !isNaN(parseFloat(input.val())) && isFinite(input.val());
}