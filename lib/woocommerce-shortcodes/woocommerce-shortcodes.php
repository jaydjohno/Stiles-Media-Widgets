<?php

function product_add_to_cart_custom()
{
    if ( is_null( $product ) ) {
      $product = $GLOBALS['product'];
    }

    $defaults = array(
      'input_id'     => uniqid( 'quantity_' ),
      'input_name'   => 'quantity',
      'input_value'  => '1',
      'classes'      => apply_filters( 'woocommerce_quantity_input_classes', array( 'input-text', 'qty', 'text', 'smt_product_fix' ), $product ),
      'max_value'    => apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
      'min_value'    => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
      'step'         => apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
      'pattern'      => apply_filters( 'woocommerce_quantity_input_pattern', has_filter( 'woocommerce_stock_amount', 'intval' ) ? '[0-9]*' : '' ),
      'inputmode'    => apply_filters( 'woocommerce_quantity_input_inputmode', has_filter( 'woocommerce_stock_amount', 'intval' ) ? 'numeric' : '' ),
      'product_name' => $product ? $product->get_title() : '',
      'placeholder'  => apply_filters( 'woocommerce_quantity_input_placeholder', '', $product ),
    );

    $args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults ), $product );

    // Apply sanity to min/max args - min cannot be lower than 0.
    $args['min_value'] = max( $args['min_value'], 0 );
    $args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : '';

    // Max cannot be lower than min if defined.
    if ( '' !== $args['max_value'] && $args['max_value'] < $args['min_value'] ) {
      $args['max_value'] = $args['min_value'];
    }

    ob_start();

    wc_get_template( 'global/quantity-input.php', $args );
    
    $left = '<div class="left-button"><button type="button" class="minus" >-</button></div>';
    
    $right = '<div class-"right-button"><button type="button" class="plus" >+</button></div>';
    
    $script = '<script type="text/javascript">
           
      jQuery(document).ready(function($)
      {   
          $( ".quantity" ).find( "input" ).removeAttr( "type" );
          //$(".single_add_to_cart_button").wrap("<div class="add_to_cart"></div>");
           
         $("form.cart").on( "click", "button.plus, button.minus", function() {
  
            // Get current quantity values
            var qty = $( this ).closest( "form.cart" ).find( ".qty" );
            var val   = parseFloat(qty.val());
            var max = parseFloat(qty.attr( "max" ));
            var min = parseFloat(qty.attr( "min" ));
            var step = parseFloat(qty.attr( "step" ));
  
            // Change the value if plus or minus
            if ( $( this ).is( ".plus" ) ) {
               if ( max && ( max <= val ) ) {
                  qty.val( max );
               } else {
                  qty.val( val + step );
               }
            } else {
               if ( min && ( min >= val ) ) {
                  qty.val( min );
               } else if ( val > 1 ) {
                  qty.val( val - step );
               }
            }
              
         });
           
      });
           
      </script>';

    return $left . ob_get_clean() . $right . $script;
}

function register_shortcodes()
{
    add_shortcode('add-to-cart', 'product_add_to_cart_custom');
}

add_action( 'init', 'register_shortcodes');

