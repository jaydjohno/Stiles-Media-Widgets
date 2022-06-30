<?php
/**
* Variable product add to cart
*
* This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce/Templates
* @version 3.5.5
*/

defined( 'ABSPATH' ) || exit;

global $product;

$attributes = $product->get_variation_attributes();
$attribute_keys = array_keys( $attributes );
$available_variations = $product->get_available_variations();

echo '<div class="before-cart-form spacing">';

    do_action( 'woocommerce_before_add_to_cart_form' );

echo '</div>';

foreach( $available_variations as $i => $variation ) 
{
    //check if variation has stock or not 
    if ( $variation['is_in_stock'] ) 
    {
        // Get max qty that user can purchase
        $max_qty = $variation['max_qty'];

        // Prepare availability html for stock available instance
        $availability_html = '<p class="stock in-stock">' . $max_qty . ' units available for your purchase.' . '</p>';
    } else 
    {
        // Prepare availability html for out of stock instance
        $availability_html = '<p class="stock out-of-stock">Oops, we have no stock left.</p>';
    }
    $available_variations[$i]['availability_html'] = $availability_html;
}

?>

<form class="variations_form cart stiles-add-cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $product->get_available_variations() ) ); ?>">
    <div class="before-variations-form spacing">
        <?php do_action( 'woocommerce_before_variations_form' ); ?>
    </div>

    <?php if ( empty( $product->get_available_variations() ) && false !== $product->get_available_variations() ) : ?>
        <p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
    <?php else : ?>
        <table class="variations" cellspacing="0">
            <tbody>
                <?php 
                $variations_arr = array();
                foreach ( $attributes as $attribute_name => $options ) :
                    ob_start(); ?>
                    <tr>
                        <td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
                        <td class="value">
                            <?php
                            $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $product->get_variation_default_attribute( $attribute_name );
                            $args = array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected );
                            wc_dropdown_variation_attribute_options( $args );
                            //wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
                            echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . __( 'Clear', 'woocommerce' ) . '</a>' ) : ''; ?>
                        </td>
                    </tr>
                    <?php $variations_ob = ob_get_clean();
                    $variations_arr[wc_attribute_label($attribute_name)] = $variations_ob;
                endforeach;

                foreach ($variations_arr as $name => $ob) {
                    echo str_ireplace('choose an option', 'Choose '.$name, $ob );
                } ?>
            </tbody>
        </table>

        <div class="single_variation_wrap">
            <?php
                /**
                 * Hook: woocommerce_before_single_variation.
                 */
                 ?>
                 <div class="before-single-variation spacing">
                    <?php do_action( 'woocommerce_before_single_variation' ); ?>
                </div>

                <div class="before-cart-quantity spacing">
                    <?php do_action( 'woocommerce_before_add_to_cart_quantity' ); ?>
                </div>
                
                <script>
                    jQuery(document).ready(function() 
                    {
                        jQuery( ".variations_form" ).each( function() 
                        {
                            // when variation is found, do something
                            jQuery(this).on( "found_variation", function( event, variation ) 
                            {
                                console.log(variation);
                                if( variation.availability_html == "" )
                                {
                                    //either no product or stock is not enabled, remove it all
                                    jQuery( "#stock-output" ).hide();
                                    jQuery( "#stock-output" ).html( variation.availability_html );
                                }
                                else
                                {
                                    jQuery( "#stock-output" ).show();
                                    jQuery( "#stock-output" ).html( variation.availability_html );
                                }
                            });
                        });
                    });
                    
                    jQuery(document).ready(function() 
                    {
                        jQuery('input.variation_id').change( function()
                        {
                            if( '' != jQuery('input.variation_id').val() ) 
                            {
                                var var_id = jQuery('input.variation_id').val();
                                console.log(var_id);
                            }
                            else
                            {
                                jQuery( "#stock-output" ).show();
                                jQuery( "#stock-output" ).html( "" );
                            }
                        });
                    });
                </script>
                        
                <div id="stock-output" class="stock-container spacing" style="display:none">stock here</div>

                <?php
                
                echo '<div class="quantity-container spacing">';

                    echo '<div class="minus-button"><button type="button" class="minus typo" >-</button></div>';

                    woocommerce_quantity_input(
                        array(
                            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                        )
                    );

                    echo '<div class="plus-button"><button type="button" class="plus typo" >+</button></div>';

                echo '</div>';

                echo '<div class="after-cart-quantity spacing">';

                    do_action( 'woocommerce_after_add_to_cart_quantity' );

                echo '</div>';

                ?>
                
                <?php //button here ?>
                <div class="before-cart-button spacing">
                    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
                </div>

                <div class="button-container spacing">
                    <div class="wc-add-button">
                        <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
                    </div>
                </div>

                <div class="after-cart-button spacing">
                    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                </div>


                <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
                <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
                <input type="hidden" name="variation_id" class="variation_id" value="0" />

                <?php
                /**
                 * Hook: woocommerce_after_single_variation.
                 */
                ?>
                <div class="after-single-variation spacing">
                    <?php do_action( 'woocommerce_after_single_variation' ); ?>
                </div>
        </div>
    <?php endif; ?>

    <?php do_action( 'woocommerce_after_variations_form' ); ?>

</form>
<?php
do_action( 'woocommerce_after_add_to_cart_form' );