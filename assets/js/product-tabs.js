;(function($)
{
    "use strict";

    /*
    * Custom Tab
    */
    function stiles_tabs( $tabmenus, $tabpane )
    {
        $tabmenus.on('click', 'a', function(e)
        {
            e.preventDefault();
            var $this = $(this),
                $target = $this.attr('href');
            $this.addClass('smactive').parent().siblings().children('a').removeClass('smactive');
            $( $tabpane + $target ).addClass('smactive').siblings().removeClass('smactive');

            // slick refresh
            if( $('.slick-slider').length > 0 )
            {
                var $id = $this.attr('href');
                $( $id ).find('.slick-slider').slick('refresh');
            }

        });
    }

    /*
    * Product Tab
    */
    var  WidgetProducttabsHandler = woolentor_tabs( $(".sm-tab-menus"),'.sm-tab-pane' );

    /*
    * Single Product Video Gallery tab
    */
    var WidgetProductVideoGallery = function thumbnailsvideogallery()
    {
        woolentor_tabs( $(".stiles-product-video-tabs"), '.video-cus-tab-pane' );
    }

    /*
    * Run this code under Elementor.
    */
    $(window).on('elementor/frontend/init', function () 
    {
        //add tabs to our Product tabs widget
        elementorFronten d.hooks.addAction( 'frontend/element_ready/stiles-tabs.default', WidgetProducttabsHandler);
        //add tabs to our video gallery
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-video-gallery.default', WidgetProductVideoGallery );
    });
})(jQuery);