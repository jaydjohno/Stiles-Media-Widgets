<?php
/**
 * The template for displaying product content in the quickview-product.php template
 *
 */
if ( ! defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly
}

global $product;
$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();

?>
<div class="sm-row">

    <div class="sm-col-md-5 sm-col-sm-5 sm-col-xs-12">
    	<div class="sm-quick-view-left">
            <div class="sm-quick-view-large-img">
                <?php if ( has_post_thumbnail() ): ?>
                    <div class="sm-quick-view-single images">
                        <?php 
                            $html = wc_get_gallery_image_html( $post_thumbnail_id, true );
                            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
                        ?>
                    </div>
                <?php endif; 
                    if ( $attachment_ids ) {
                        foreach ( $attachment_ids as $attachment_id ) {
                            $i++;
                            ?>
                                <div class="sm-quick-view-single">
                                    <?php 
                                        $html = wc_get_gallery_image_html( $attachment_id, true );
                                        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
                                    ?>
                                </div>
                            <?php
                        }
                    }
                ?>
                
            </div>

            <div class="sm-quick-view-thumbnails">
                <?php if ( has_post_thumbnail() ): ?>
                    
                    <div class="sm-quick-thumb-single">
                        <?php
                            $thumbnail_src = wp_get_attachment_image_src( $post_thumbnail_id, 'woocommerce_gallery_thumbnail' );
                            echo '<img src=" '.$thumbnail_src[0].' " alt="'.get_the_title().'">';
                        ?>
                    </div>
                    
                <?php endif; ?>
                <?php
                    if ( $attachment_ids && $product->get_image_id() ) {
                        foreach ( $attachment_ids as $attachment_id ) {
                            ?>
                                <div class="sm-quick-thumb-single">
                                    <?php
                                      $thumbnail_src = wp_get_attachment_image_src( $attachment_id, 'woocommerce_gallery_thumbnail' );
                                      echo '<img src=" '.$thumbnail_src[0].' " alt="'.get_the_title().'">';
                                    ?>
                                </div>
                            <?php
                        }
                    }
                ?>
            </div>

        </div>
    </div>

    <div class="sm-col-md-7 sm-col-sm-7 sm-col-xs-12">
        <div class="sm-quick-view-right">
            <div class="qwick-view-content">
                <?php do_action( 'stiles_quickview_before_summary' ); ?>
    			<div class="content-woolentorquickview entry-summary">
    				<?php
                        add_action( 'stiles_quickview_content', 'woocommerce_template_single_title', 5 );
                        add_action( 'stiles_quickview_content', 'woocommerce_template_single_rating', 10 );
                        add_action( 'stiles_quickview_content', 'woocommerce_template_single_price', 10 );
                        add_action( 'stiles_quickview_content', 'woocommerce_template_single_excerpt', 20 );
                        add_action( 'stiles_quickview_content', 'woocommerce_template_single_add_to_cart', 30 );
                        add_action( 'stiles_quickview_content', 'woocommerce_template_single_meta', 40 );
                        add_action( 'stiles_quickview_content', 'woocommerce_template_single_sharing', 50 );

                        // Render Content
                        do_action( 'stiles_quickview_content' );
    				?>
    			</div><!-- .summary -->
    			<?php do_action( 'stiles_quickview_after_summary' ); ?>
            </div>
        </div>
    </div>
</div>