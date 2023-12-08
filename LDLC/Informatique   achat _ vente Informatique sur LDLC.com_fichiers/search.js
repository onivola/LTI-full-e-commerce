(function($, Routing, i18n, searchDataCollectEnable){

    var SearchCollect = function (routing, i18n, enable) {
        this.routing = routing;
        this.i18n = i18n;
        this.enable = enable;
    };

    SearchCollect.prototype.init = function ()
    {
        if (!this.enable) {
            return;
        }

        this._initAutoCompleteEvents();
        this._initResultEvents();
    };

    SearchCollect.prototype._initAutoCompleteEvents = function ()
    {
        this._initCollectEvent("#formSearch .list-pdt .pdt-item a", function () {
            var searchElement = $('#search_search_text');

            if (searchElement.length === 0) {
                return "";
            }

            return searchElement.val() || "";
        });
    };

    SearchCollect.prototype._initResultEvents = function ()
    {
        this._initCollectEvent("#searchPage .pdt-item > .pic a, #searchPage .pdt-item > .pdt-info h3 a", function () {
            var searchElement = $('#searchPage');

            if (searchElement.length === 0) {
                return "";
            }

            return searchElement.data('searchText') || "";
        });
    };

    SearchCollect.prototype._initCollectEvent = function (productItemSelector, getSearchTextCallback)
    {
        var that = this;

        $("body").on('click', productItemSelector, debounce(function (event) {
            var element = $(event.target).closest('.pdt-item');

            if (element.length === 0) {
                return;
            }

            if (typeof getSearchTextCallback !== 'function') {
                return;
            }

            var searchText = getSearchTextCallback.call(that);
            var productId = element.data('id') || "";
            var position = element.data('position') || 0;

            if (!searchText || !productId) {
                return;
            }

            that._collect(searchText, productId, position);
        }, 200));
    };

    SearchCollect.prototype._collect = function (searchText, productId, position)
    {
        var url = this.routing.generate('search_data_collect', {
            "_locale" : this.i18n.locale,
            "country" : this.i18n.country,
        }, true);

        var data = {
            "searchText": searchText,
            "productId": productId,
            "position": position
        };

        $.ajax(url, {
            "method": "POST",
            "data": data
        });
    };


    $(function () {
        var searchCollect = new SearchCollect(Routing, i18n, searchDataCollectEnable);
        searchCollect.init();
    });

})(jQuery, window.Routing, window.i18n, window.search_data_collect_enable);

var previousSearch = '';
function autoComplete($input){
    var searchText = encodeURIComponent($input.val());

    if (previousSearch === searchText && $('html').hasClass('open-search')) {
        return;
    }

    previousSearch = searchText;

    if( searchText.length > 2 ) {
        var url = Routing.generate('search_autocomplete', {
            "searchText" : searchText,
            "country" : request_country,
            "_locale" : request_locale
        });
        var data = {'searchText': searchText, 'department': $('#search_department').val()};
        var $target = $('.search-engine');
        $.ajax({
            url : url,
            data: data,
            method: 'POST',
            statusCode: {
                200: function(response) {
                    $target.replaceWith(response);
                    $('html').addClass('open-search');
                    $('.ajaxWait').hide();
                }
            }
        });
    } else {
        $('html').removeClass('open-search');
    }
}
var searchDebounce = 300;
$('.search input').keyup(debounce(function() { autoComplete($(this))}, searchDebounce));


$( document ).ready(function() {
    $('#search_department').change(function() {
        if ($('#search_search_text').length >= 0){
            autoComplete($('#search_search_text'));
        }
    });

    $('#formSearch').on('submit', function (event) {
        if ($('#search_search_text').val() === '') {
            event.preventDefault();
            return;
        }
    });
});
