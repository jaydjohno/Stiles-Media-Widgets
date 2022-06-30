<div class="stiles-add-to-cart-sticky">
    <div class="sm-container">

        <div class="sm-row">
            <div class="sm-col-lg-6 sm-col-md-6 sm-col-sm-6 sm-col-xs-12">
                <div class="stiles-addtocart-content">
                    <div class="stiles-sticky-thumbnail">
                        <?php echo woocommerce_get_product_thumbnail(); ?>  
                    </div>
                    <div class="stiles-sticky-product-info">
                        <h4 class="title"><?php the_title(); ?></h4>
                        <span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>     
                    </div>
                </div>
            </div>
            <div class="sm-col-lg-6 sm-col-md-6 sm-col-sm-6 sm-col-xs-12">
                <div class="stiles-sticky-btn-area">
                    <?php 
                        if ( $product->is_type( 'simple' ) )
                        { 
                            woocommerce_simple_add_to_cart();
                        }else
                        {
                            echo '<a href="'.esc_url( $product->add_to_cart_url() ).'" class="stiles-sticky-add-to-cart button alt">'.( true == $product->is_type( 'variable' ) ? esc_smml__( 'Select Options', smw_slug ) : $product->single_add_to_cart_text() ).'</a>';
                        }

                        if ( class_exists( 'YITH_WCWL' ) ) 
                        {
                            echo '<div class="stiles-sticky-wishlist">'.stiles_add_to_wishlist_button().'</div>';
                        }
                        if( class_exists('TInvWL_Public_AddToWishlist') )
                        {
                            echo '<div class="stiles-sticky-wishlist">';
                                \TInvWL_Public_AddToWishlist::instance()->smmloutput();
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>