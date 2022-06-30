;(function($)
{
    "use strict";

    var WidgetProductSliderHandler = function ($scope, $) 
    {
        var slider_elem = $scope.find('.product-slider').eq(0);
    
        if (slider_elem.length > 0) {
    
            var settings = slider_elem.data('settings');
            var arrows = settings['arrows'];
            var dots = settings['dots'];
            var autoplay = settings['autoplay'];
            var rtl = settings['rtl'];
            var autoplay_speed = parseInt(settings['autoplay_speed']) || 3000;
            var animation_speed = parseInt(settings['animation_speed']) || 300;
            var fade = settings['fade'];
            var pause_on_hover = settings['pause_on_hover'];
            var display_columns = parseInt(settings['product_items']) || 4;
            var scroll_columns = parseInt(settings['scroll_columns']) || 4;
            var tablet_width = parseInt(settings['tablet_width']) || 800;
            var tablet_display_columns = parseInt(settings['tablet_display_columns']) || 2;
            var tablet_scroll_columns = parseInt(settings['tablet_scroll_columns']) || 2;
            var mobile_width = parseInt(settings['mobile_width']) || 480;
            var mobile_display_columns = parseInt(settings['mobile_display_columns']) || 1;
            var mobile_scroll_columns = parseInt(settings['mobile_scroll_columns']) || 1;
    
            slider_elem.slick({
                arrows: arrows,
                prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
                dots: dots,
                infinite: true,
                autoplay: autoplay,
                autoplaySpeed: autoplay_speed,
                speed: animation_speed,
                fade: false,
                pauseOnHover: pause_on_hover,
                slidesToShow: display_columns,
                slidesToScroll: scroll_columns,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: tablet_width,
                        settings: {
                            slidesToShow: tablet_display_columns,
                            slidesToScroll: tablet_scroll_columns
                        }
                    },
                    {
                        breakpoint: mobile_width,
                        settings: {
                            slidesToShow: mobile_display_columns,
                            slidesToScroll: mobile_scroll_columns
                        }
                    }
                ]
            });
        };
    };
    
    $(window).on('elementor/frontend/init', function () 
    {
        //add to our logo brand
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-product-brand.default', WidgetProductSliderHandler );
        //add to our WC Tabs
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-tabs.default', WidgetProductSliderHandler);
        //Add to our universal product
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-universal-product.default', WidgetProductSliderHandler);
        //add to our cross sell widget
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-cross-sell-advanced.default', WidgetProductSliderHandler);
        //add to our upsell product widget
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-product-upsell-advanced.default', WidgetProductSliderHandler);
        //Add to our related products widget
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-product-related-advanced.default', WidgetProductSliderHandler);
    });

})(jQuery);