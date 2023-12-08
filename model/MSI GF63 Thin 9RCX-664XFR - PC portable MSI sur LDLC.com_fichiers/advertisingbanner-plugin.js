var html = '';
(function ($) {
    $.fn.advertisingBanner = function (preserve) {
        var $bannerDiv = $(this);
        var $bannerUrl = $(this).data("url");
        var $bannerData = $(this).data("bannerCustom");
        var $bannerParent = $(this).data("bannerParentId");
        initDataCustom();
        getBanner(preserve);

        function initDataCustom() {
            $bannerData.cb = Math.floor(Math.random() * 99999999999);
            if (!document.MAX_used) document.MAX_used = ',';
            if (document.MAX_used != ',') $bannerData.exclude = document.MAX_used;
            if (document.charset) $bannerData.charset = document.charset;
            else if (document.characterSet) $bannerData.charset = document.characterSet;
            $bannerData.loc = window.location.href;
            if (document.referrer) $bannerData.referer = escape(document.referrer);
            if (document.context) $bannerData.context = escape(document.context);
            if (document.mmm_fo) $bannerData.mmm_fo = 1;
        }

        function getBanner(preserve) {
            if ($bannerUrl !== null) {
                $.ajax({
                    method: "GET",
                    dataType: "text",
                    data: $bannerData,
                    url: $bannerUrl,
                    success: function (response, status, xhr) {
                        if (status !== "success") $($bannerParent).remove();
                        html = parseBannerToHtml(response);
                        if (html) {
                            if (preserve) {
                                $bannerDiv.html(html);
                            } else {
                                $bannerDiv.replaceWith(html);
                                $($bannerParent).slideDown();
                            }
                        } else {
                            $($bannerParent).remove();
                        }
                    }
                });
            }
        }

        function parseBannerToHtml(bannerText) {
            var line = bannerText.match(/^.*((\r\n|\n|\r)|$)/gm)[1];
            var parts = line.split('"');
            var result = "";
            for (var i = 1; i < parts.length - 1; i++) {
                if (parts[i] !== "+")
                    result += parts[i];
            }
            result = result.replace(/\\n|\\/g, '');
            return result;
        }
    }
})(jQuery);
