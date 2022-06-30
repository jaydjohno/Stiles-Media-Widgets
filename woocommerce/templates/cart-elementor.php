<?php
/**
 * Cart Page 
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

?>
<div class="woocommerce woolentor-elementor-cart">
    <?php
        wc_print_notices();
        do_action( 'stiles_cart_content_build' );
    ?>
</div>