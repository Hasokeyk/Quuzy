;(function($){
    if ($.adblockDetector) {
        console.error('AdBlock Detector instance exists already');
        return;
    }

    $.adblockDetector = {
        detect: function() {
            var dfd = new $.Deferred();
            var adsEnabled = false;
            var $dummy = $('<div class="adsbox">&nbsp;</div>').appendTo('body');

            setTimeout(function () {
                if ($dummy.height() > 0) {
                    adsEnabled = true;
                }
                $dummy.remove();

                dfd.resolve(adsEnabled);
            }, 100);

            return dfd;
        }
    };
})(jQuery);
