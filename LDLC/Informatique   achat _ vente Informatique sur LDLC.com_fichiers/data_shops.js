function initShopsData(favoriteShopId, stockViewMode, initialisationPage){
    var offerListingType = typeof offerListing !== 'undefined' ? offerListing.type : '';
    var dataViewModeForced = $('#category').attr('data-view-mode-forced')
        || $('div.tab-pane#product').attr('data-view-mode-forced');
    //display 'stock-option' element only if there isn't viewModeForced
    if (dataViewModeForced === undefined || dataViewModeForced === '-1') {
        if (initialisationPage) {
            if (favoriteShopId !== -1 && !checkFavoriteShopAvailability()){
                hideShopStockForUnavailableFavoriteShop();
            }
            displayViewMode();
            initModalToChooseFavoriteShop();
        }

        //ne pas décacher le bloc '#filter-availability' quand on est sur un listing shop
        if (typeof offerListing !== 'undefined' && offerListingType === 'shop') {
            return;
        }

        if (stockViewMode === '-1' || stockViewMode === '0') {
            $('#filter-availability').removeClass('hide');
        }
    } else if (dataViewModeForced === '0' || (dataViewModeForced === '2' &&
            (favoriteShopId === -1 || stockViewMode === '0'))) {
        //if stockWeb or stockShopWeb but without shop => it's a web stock viewMode so display disponibilityFilter
        $('#filter-availability').removeClass('hide');
    } else {
        $('#filter-availability').addClass('hide');
    }
}

function updateShopTagTitle() {
    if (typeof openedShops === 'undefined') {
        return;
    }
    for (var i in openedShops){
        if (parseInt(openedShops[i].id) === favoriteShopId) {
            var $shopTag = $('#shopTag');
            $shopTag.prepend($shopTag.attr('data-shop-dispo') + ' ' + openedShops[i].title);
            $shopTag.removeClass('hide');
        }
    }
}
