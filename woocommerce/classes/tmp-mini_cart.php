<?php  
    $cart_position = smw_get_option( 'mini_cart_position', 'smw_others_tabs', 'left' );
?>
<div class="stiles_mini_cart_area stiles_mini_cart_pos_<?php echo esc_attr( $cart_position ); ?>">
    <div class="stiles_mini_cart_icon_area">
        <?php $count_item = WC()->cart->get_cart_contents_count(); ?>
        <span class="stiles_mini_cart_counter"><?php echo $count_item; ?></span>
        <span class="stiles_mini_cart_icon"><i class="sli sli-basket-loaded"></i></span>
    </div>
    <div class="stiles_body_opacity"></div>
    <div class="stiles_cart_content_container">
        <?php do_action( 'stiles_cart_content' ); ?>
    </div>
</div>