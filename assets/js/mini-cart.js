;(function($){
"use strict";

    // Open cart
    var minicart_open = function() 
    {
        $('body,.stiles_mini_cart_area').addClass('stiles_mini_cart_open');
        var contentarea = $('.stiles_cart_content_container').outerWidth();
        
        if( $( ".stiles_mini_cart_area" ).hasClass( "stiles_mini_cart_pos_right" ) )
        {
            $('.stiles_mini_cart_icon_area').css('right',(contentarea+10)+'px' );
        }else{
            $('.stiles_mini_cart_icon_area').css('left',(contentarea+10)+'px' );
        }
    };

    // Close Cart
    var minicart_close = function()
    {
        $('body,.stiles_mini_cart_area').removeClass('stiles_mini_cart_open');
        
        if( $( ".stiles_mini_cart_area" ).hasClass( "stiles_mini_cart_pos_right" ) )
        {
            $('.stiles_mini_cart_icon_area').css('right',10+'px' );
        }else{
            $('.stiles_mini_cart_icon_area').css('left',10+'px' );
        }
    };

    // Cart Open If click on icon
    $('.stiles_mini_cart_icon_area').on( 'click', minicart_open );

    // Cart Close If click on close | body opacity
    $('body').on('click','.stiles_mini_cart_close , .stiles_body_opacity', function()
    {
        minicart_close();
    });

    // Cart Open when item is added if no Ajax Action
    $(document).on('wc_fragments_refreshed', function()
    {
        if( stilesMiniCart.addedToCart )
        {
            var opened = false;
            if( opened === false )
            {
                setTimeout( minicart_open, 1 );
                opened = true;
            }
        }
    });
    
    // Open cart when item is added if Ajax Action
    $(document).on('added_to_cart',function(e)
    {
        setTimeout( minicart_open, 1 );
    });

    // Set Content area Height
    $( document.body ).on( 'wc_fragments_refreshed wc_fragments_loaded', function()
    {
        minicart_content_height();
    });

    // Content Area Height
    var minicart_content_height = function() 
    {
        var headerarea = $('.stiles_mini_cart_header').outerHeight(), 
            footerarea = $('.stiles_mini_cart_footer').outerHeight(),
            windowHeight = $(window).height();

        var content_height = windowHeight - ( headerarea + footerarea );
        $('.stiles_mini_cart_content').css('height',content_height);

    };

    var minicart_refresh_cart_checkout = function()
    {
        //Checkout page
        if( window.wc_checkout_params && wc_checkout_params.is_checkout === "1" )
        {
            if( $( 'form.checkout' ).length === 0 )
            {
                location.reload();
                return;
            }
            $( document.body ).trigger( "update_checkout" );
        }

        //Cart page
        if( window.wc_add_to_cart_params && window.wc_add_to_cart_params.is_cart && wc_add_to_cart_params.is_cart === "1" )
        {
            $( document.body ).trigger( "wc_update_cart" );
        }

    }

    // After load the window then refresh cart and set height
    $(window).on( 'load', function() 
    {
        minicart_content_height();
        // if Do not get add-to-cart action refresh cart fragment
        if( !stilesMiniCart.addedToCart )
        {
            $( document.body ).trigger( 'wc_fragment_refresh' );
        }
        
        minicart_refresh_cart_checkout();
    });

    // Set Content height if window is resize.
    $(window).resize(function()
    {
        minicart_content_height();
    });

})(jQuery);