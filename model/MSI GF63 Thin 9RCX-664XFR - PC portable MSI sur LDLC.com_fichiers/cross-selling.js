$(function () {
    $('[data-cross-selling-url]').each(function (index, element) {
        var $element = $(element);
        var url = Base64.decode($element.data('cross-selling-url'));

        var tab = url.split('<|>');
        url = tab.shift();
        var callable = tab.shift();

        if (!url) {
            return;
        }

        var $parent = $element.parents('.cross-selling-parent');

        $.ajax({
            url: url,
            success: function (response) {
                if (response.length < 1) {
                    $parent.remove();
                    return;
                }
                $element.html(response);
                if (callable) {
                    CrossSellingCallabled[callable]($element, $parent);
                }
            },
            error: function () {
                $parent.remove();
            }
        });
    });
});

var CrossSellingCallabled = {
    bindSlider: function($element, $parent) {
        $parent.removeClass('slide');
        sliderGen();
        initSwiper6();
    }
};
