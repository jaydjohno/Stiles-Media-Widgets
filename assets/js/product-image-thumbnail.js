;(function($)
{
    "use strict";

    var WidgetThumbnailsImagesHandler = function thumbnailsimagescontroller()
    {
        stiles_tabs( $(".sm-product-cus-tab-links"), '.sm-product-cus-tab-pane' );
        stiles_tabs( $(".sm-tab-menus"), '.sm-tab-pane' );

        // Countdown
        var finalTime, daysTime, hours, minutes, second;
        $('.sm-product-countdown').each(function() 
        {
            var $this = $(this), finalDate = $(this).data('countdown');
            var customlavel = $(this).data('customlavel');
            $this.countdown(finalDate, function(event) 
            {
                $this.html(event.strftime('<div class="cd-single"><div class="cd-single-inner"><h3>%D</h3><p>'+customlavel.daytxt+'</p></div></div><div class="cd-single"><div class="cd-single-inner"><h3>%H</h3><p>'+customlavel.hourtxt+'</p></div></div><div class="cd-single"><div class="cd-single-inner"><h3>%M</h3><p>'+customlavel.minutestxt+'</p></div></div><div class="cd-single"><div class="cd-single-inner"><h3>%S</h3><p>'+customlavel.secondstxt+'</p></div></div>'));
            });
        });
    }
  
    $(window).on('elementor/frontend/init', function () 
    {
        //add to our universal products widget
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-universal-product.default', WidgetThumbnailsImagesHandler);
        //add to our cross sell widget
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-cross-sell-advanced.default', WidgetThumbnailsImagesHandler);
        //add to our upsell product
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-product-upsell-advanced.default', WidgetThumbnailsImagesHandler);
        //add to our related products widget
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-product-related-advanced.default', WidgetThumbnailsImagesHandler);
    });
})(jQuery);