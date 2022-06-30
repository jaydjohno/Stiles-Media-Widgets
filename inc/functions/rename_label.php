<?php

/*
* Shop Page
*/

// Add to Basket Button Text
add_filter( 'woocommerce_product_add_to_cart_text', 'smw_custom_add_cart_button_shop_page', 99, 2 );

function smw_custom_add_cart_button_shop_page( $label ) 
{
   return __( smw_get_option_text( 'smw_shop_add_to_cart_txt', 'smw_rename_label_tabs', 'Add to Basket' ), smw_slug );
}

/*
* Product Details Page
*/

// Add to Basket Button Text
add_filter( 'woocommerce_product_single_add_to_cart_text', 'smw_custom_add_cart_button_single_product' );

function smw_custom_add_cart_button_single_product( $label ) 
{
   return __( smw_get_option_text( 'smw_add_to_cart_txt', 'smw_rename_label_tabs', 'Add to Basket' ), smw_slug );
}

//Description tab
add_filter( 'woocommerce_product_description_tab_title', 'smw_rename_description_product_tab_label' );

function smw_rename_description_product_tab_label() 
{
    return __( smw_get_option_text( 'smw_description_tab_menu_title', 'smw_rename_label_tabs', 'Description' ), smw_slug );
}

add_filter( 'woocommerce_product_description_heading', 'smw_rename_description_tab_heading' );

function smw_rename_description_tab_heading() 
{
    return __( smw_get_option_text( 'smw_description_tab_menu_title', 'smw_rename_label_tabs', 'Description' ), smw_slug );
}

//Additional Info tab
add_filter( 'woocommerce_product_additional_information_tab_title', 'smw_rename_additional_information_product_tab_label' );

function smw_rename_additional_information_product_tab_label() 
{
    return __( smw_get_option_text( 'smw_additional_information_tab_menu_title', 'smw_rename_label_tabs','Additional Information' ), smw_slug );
}

add_filter( 'woocommerce_product_additional_information_heading', 'smw_rename_additional_information_tab_heading' );

function smw_rename_additional_information_tab_heading() 
{
    return __( smw_get_option_text( 'smw_additional_information_tab_menu_title', 'smw_rename_label_tabs','Additional Information' ), smw_slug );
}

//Reviews Info tab
add_filter( 'woocommerce_product_reviews_tab_title', 'smw_rename_reviews_product_tab_label' );

function smw_rename_reviews_product_tab_label() 
{
    return __( smw_get_option_text( 'smw_reviews_tab_menu_title', 'smw_rename_label_tabs','Reviews' ), smw_slug);
}

/*
* Checkout Page
*/
add_filter( 'woocommerce_order_button_text', 'smw_rename_place_order_button' );

function smw_rename_place_order_button() 
{
   return __( smw_get_option_text( 'smw_checkout_placeorder_btn_txt', 'smw_rename_label_tabs','Place Order' ), smw_slug);
}
/*
* Shop Page
*/

add_action('template_redirect','rename_checkout_labels');

function rename_checkout_labels()
{
    if( is_checkout() )
    {
        // Translate
        add_filter( 'gettext', 'smw_translate_text', 20, 3 );
            
        function smw_translate_text( $translated, $untranslated, $domain ) 
        {
            $smtext = '';
                
            switch ( $untranslated ) 
            {
                case 'Billing details':
                    $smtext = smw_get_option_label_text( 'sm_checkout_billig_form_title', 'smw_rename_label_tabs', 'Billing Details' );
                    $translated = $smtext;
                    break;
            }
            
            return $translated;
        }
    }
}