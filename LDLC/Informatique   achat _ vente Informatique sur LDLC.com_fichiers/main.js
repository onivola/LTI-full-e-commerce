function I18N() {
    var $body = $('body');
    this.locale = $body.data('language');
    this.country = $body.data('country');
    this.countryLabel = $body.data('country-label');
    this.error = $body.data('error');
}
var i18n = new I18N();

var DEFAULT_WAIT = 100;
function debounce(func, wait) {
    var timeout = null;
    if (wait === undefined) {
        wait = DEFAULT_WAIT;
    }

    return function () {
        var _this = this;
        var args = [].slice.apply(arguments);

        clearTimeout(timeout);
        timeout = setTimeout(function () {
            func.apply(_this, args);
        }, wait);
    };
}

// https://developer.mozilla.org/fr/docs/D%C3%A9coder_encoder_en_base64#Premi%C3%A8re_solution_%E2%80%93_%C3%A9chapper_la_cha%C3%AEne_avant_de_l'encoder
var Base64 = {
    encode: function(str) {
        return window.btoa(encodeURIComponent(str));
    },

    decode: function(str) {
        var decodedString = window.atob(str);
        try {
            return decodeURIComponent(decodedString);
        } catch (e) {
            return decodedString;
        }
    }
};

function displaySimpleErrorModal(message){
    $('#simple_modal .modal-content').html(message);
    $('#simple_modal').modal('show');
}

