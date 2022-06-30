<?php

add_action( 'woocommerce_before_add_to_cart_quantity', 'smt_display_quantity_plus' );
  
function smt_display_quantity_plus() 
{
   echo '<div class="minus-button"><button type="button" style="margin-right:10px;" class="minus" >-</button></div>';
}
  
add_action( 'woocommerce_after_add_to_cart_quantity', 'smt_display_quantity_minus' );
  
function smt_display_quantity_minus() 
{
   echo '<div class="plus-button"><button type="button" style="margin-left:5px;" class="plus" >+</button></div>';
}
  
add_action( 'wp_footer', 'smt_add_cart_quantity_plus_minus' );
  
function smt_add_cart_quantity_plus_minus() 
{
   // Only run this on the single product page
   if ( ! is_product() ) return;
   ?>
      <script type="text/javascript">
           
      jQuery(document).ready(function($)
      {   
          $( ".quantity" ).find( "input" ).removeAttr( "type" );
          //$(".single_add_to_cart_button").wrap("<div class='add_to_cart'></div>");
           
         $('form.cart').on( 'click', 'button.plus, button.minus', function() {
  
            // Get current quantity values
            var qty = $( this ).closest( 'form.cart' ).find( '.qty' );
            var val   = parseFloat(qty.val());
            var max = parseFloat(qty.attr( 'max' ));
            var min = parseFloat(qty.attr( 'min' ));
            var step = parseFloat(qty.attr( 'step' ));
  
            // Change the value if plus or minus
            if ( $( this ).is( '.plus' ) ) {
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
           
      </script>
   <?php
}

function smt_wc_plus_minus_scripts() 
{
    wp_enqueue_style( 'wc-plus-minus', plugins_url( '/css/woocommerce-plus-minus.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'smt_wc_plus_minus_scripts' );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
  
// Second, add View Product Button
  
add_action( 'woocommerce_after_shop_loop_item', 'bbloomer_view_product_button', 10 );
  
function bbloomer_view_product_button() 
{
    global $product;
    $link = $product->get_permalink();
    echo '<a href="' . $link . '" class="button addtocartbutton">View Product</a>';
}
