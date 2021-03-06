<?php

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{
	/**
	 * Image Flipper class
	 */
	if ( ! class_exists( 'SMT_IF' ) ) 
	{
		class SMT_IF {

			public function __construct() 
			{
				add_action( 'init', array( $this, 'smt_init' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'smt_scripts' ) );
				add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woocommerce_template_loop_second_product_thumbnail' ), 11 );
				add_filter( 'post_class', array( $this, 'product_has_gallery' ) );
			}

			/**
			 * Plugin initilisation
			 */
			public function smt_init() 
			{
				load_plugin_textdomain( 'woocommerce-product-image-flipper', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
			}

			/**
			 * Class functions
			 */

			public function smt_scripts() 
			{
				if ( apply_filters( 'woocommerce_product_image_flipper_styles', true ) ) 
				{
					wp_enqueue_style( 'smt-styles', plugins_url( '/css/image-flipper.css', __FILE__ ) );
				}
			}

			public function product_has_gallery( $classes ) 
			{
				global $product;

				$post_type = get_post_type( get_the_ID() );

				if ( ! is_admin() ) 
				{
					if ( $post_type == 'product' ) 
					{

						$attachment_ids = $this->get_gallery_image_ids( $product );

						if ( $attachment_ids ) 
						{
							$classes[] = 'smt-has-gallery';
						}
					}
				}

				return $classes;
			}

			/**
			 * Frontend functions
			 */
			public function woocommerce_template_loop_second_product_thumbnail() 
			{
				global $product, $woocommerce;

				$attachment_ids = $this->get_gallery_image_ids( $product );

				if ( $attachment_ids ) 
				{
					$attachment_ids     = array_values( $attachment_ids );
					$secondary_image_id = $attachment_ids['0'];

					$secondary_image_alt = get_post_meta( $secondary_image_id, '_wp_attachment_image_alt', true );
					$secondary_image_title = get_the_title($secondary_image_id);

					echo wp_get_attachment_image(
						$secondary_image_id,
						'shop_catalog',
						'',
						array(
							'class' => 'secondary-image attachment-shop-catalog wp-post-image wp-post-image--secondary',
							'alt' => $secondary_image_alt,
							'title' => $secondary_image_title
						)
					);
				}
			}

			/**
			 * WooCommerce Compatibility Functions
			 */
			public function get_gallery_image_ids( $product ) 
			{
				if ( ! is_a( $product, 'WC_Product' ) ) {
					return;
				}

				if ( is_callable( 'WC_Product::get_gallery_image_ids' ) ) 
				{
					return $product->get_gallery_image_ids();
				} else {
					return $product->get_gallery_attachment_ids();
				}
			}
		}


		$SMT_IF = new SMT_IF();
	}
}