;(function($)
{
    "use strict";

    /*
    * Tool Tip
    */
    function stiles_tool_tips(element, content) 
    {
        if ( content == 'html' ) 
        {
            var tipText = element.html();
        } else 
        {
            var tipText = element.attr('title');
        }
        element.on('mouseover', function() 
        {
            if ( $('.stiles-tip').length == 0 ) 
            {
                element.before('<span class="stiles-tip">' + tipText + '</span>');
                $('.stiles-tip').css('transition', 'all 0.5s ease 0s');
                $('.stiles-tip').css('margin-left', 0);
            }
        });
        element.on('mouseleave', function() 
        {
            $('.stiles-tip').remove();
        });
    }

    /*
    * Tooltip Render
    */
    var WidgetWoolentorTooltipHandler = function woolentor_tool_tip()
    {
        $('a.woolentor-compare').each(function() 
        {
            stiles_tool_tips( $(this), 'title' );
        });
        $('.stiles-cart a.add_to_cart_button,.stiles-cart a.added_to_cart,.stiles-cart a.button').each(function() {
            stiles_tool_tips( $(this), 'html');
        });
    }

    $(window).on('elementor/frontend/init', function () 
    {
        //add to our universal product
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-universal-product.default', WidgetWoolentorTooltipHandler);
        //add to our cross sell widget
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-cross-sell-advanced.default', WidgetWoolentorTooltipHandler);
        //add to our upsell widget
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-product-upsell-advanced.default', WidgetWoolentorTooltipHandler);
        //add to our related widget
        elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-product-related-advanced.default', WidgetWoolentorTooltipHandler);
    });
})(jQuery);