$(function() {
    var $body = $('body');

    $body.on('click', '[data-add-review-product][data-offer-id]', wantToReview);

    function wantToReview(event)
    {
        event.preventDefault();

        var windowLocationUrl = new URL(window.location.href);
        var offerIdUrl = windowLocationUrl.searchParams.get('offerId');

        var $element = $(event.currentTarget);
        var $body = $('body');
        var country = $body.data('country');
        var language = $body.data('language');
        var urlId = $element.data('add-review-product');
        var offerId = offerIdUrl === null ? $element.attr('data-offer-id') : offerIdUrl;

        $.ajax({
            url: Routing.generate('user_can_review', {
                'urlId': urlId,
                'offerId': offerId,
                'country': country,
                '_locale': language
            }),
            method: 'POST',
            data: $('#formReview').serialize(),
            statusCode: {
                200: function (data) {
                    if (data.success === true) {
                        window.location.href = Routing.generate(data.route, {
                            'urlId': urlId,
                            'offerId': offerId
                        });
                        return;
                    } else {
                        $('#error-modal .modal-content').html(data.modal_content);
                        $('#error-modal').modal('show');
                    }
                },
                403: function (data) {
                    displayModalLoginForm(function() {
                        wantToReview(event);
                    }, window.location.href);
                }
            }
        });
    }

    $body.on('click', '[data-toggle="review-modal"][data-target]', showReviewTranslatedModal);
});

function showReviewTranslatedModal(event) {
    event.preventDefault();
    var $anchor = $(this);
    var $modal = $($anchor.data('target'));
    var $content = $modal.find('.modal-content');
    var url = Routing.generate('show_review', {
        'reviewId' :  $anchor.attr('data-review-id'),
        'country' : i18n.country,
        '_locale' : i18n.locale
    });
    $content.html('');
    $content.load(url, function () {
        $modal.modal('show');
    });
}
