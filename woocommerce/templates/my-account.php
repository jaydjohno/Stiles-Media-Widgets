<?php
/**
 * My Account page
 */

defined( 'ABSPATH' ) || exit;

/**
 * My Account navigation.
 *
 * @since 3.5.0
 */
?>

<div class="woocommerce stiles_my_account_page">
    <?php
        /**
         * My Account content.
         *
         * @since 3.5.0
         */
        do_action( 'stiles_woocommerce_account_content' );
        
        remove_action( 'woocommerce_account_content', 'woocommerce_account_content' );
        remove_action( 'woocommerce_account_content', 'woocommerce_output_all_notices', 5 );
        
        do_action( 'woocommerce_account_content' );
    ?>
</div>