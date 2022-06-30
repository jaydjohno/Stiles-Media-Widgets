<?php
/**
 * SMW Module Manager.
 *
 * @package StilesMediaWidgets
 */

namespace StilesMediaWidgets;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) 
{
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'SMW_Modules' ) ) 
{
    class SMW_Modules 
    {
        private static $instance;
    	
    	public static function get_instance() 
    	{
    		if ( ! isset( self::$instance ) ) 
    		{
    			self::$instance = new self();
    		}
		    return self::$instance;
	    }
	    
        public function __construct ()
    	{
    		$this->register_categories();
    		$this->register_modules();
    	}
    	
    	public function register_modules()
    	{
    	    add_action( 'elementor/widgets/widgets_registered', function() 
            {
                $smw_user_module_manager = array(
                    'login',
                    'register',
                    'reset-password'
                );
                
                $smw_headings_module_manager = array(
                    'dual-headings',
                    'advanced-headings',
                    'fancy-headings'
                );
                
                $smw_forms_module_manager = array(
                );
                
                if ( function_exists('mc4wp') ) 
                {
                    $smw_forms_module_manager[] = 'newsletter';
                }
                
                $smw_modules_manager = array(
                    'working-hours',
                    'search',
                    'faq',
                    'off-canvas',
                    'advanced-menu',
                    'dual-buttons',
                    'multi-buttons',
                    'advanced-tabs',
                    'team-members',
                    'team-member-carousel',
                    'advanced-banner',
                    'advanced-button',
                    'countdown-timer',
                    'google-maps',
                    'image-button',
                    'progress-bar',
                    'testimonials',
                    'template-selector'
                );
                
                if( smw_get_option( 'languagetranslator', 'smw_others_tabs', 'off' ) == 'on' )
                {
                    $smw_modules_manager[] = 'language-translator';
                }
                
                foreach ( $smw_forms_module_manager as $element )
                {
                    if (  ( smw_get_option( $element, 'smw_elements_tabs', 'on' ) === 'on' ) && file_exists( smw_forms_dir . $element . '/widget.php' ) )
                    {
                        require( smw_forms_dir . $element . '/widget.php' );
                    }
                }
                
                foreach ( $smw_user_module_manager as $element )
                {
                    if (  ( smw_get_option( $element, 'smw_elements_tabs', 'on' ) === 'on' ) && file_exists( smw_user_dir . $element . '/widget.php' ) )
                    {
                        require( smw_user_dir . $element . '/widget.php' );
                    }
                }
                
                foreach ( $smw_headings_module_manager as $element )
                {
                    if (  ( smw_get_option( $element, 'smw_elements_tabs', 'on' ) === 'on' ) && file_exists( smw_heading_dir . $element . '/widget.php' ) )
                    {
                        require( smw_heading_dir . $element . '/widget.php' );
                    }
                }
                
                foreach ( $smw_modules_manager as $element )
                {
                    if (  ( smw_get_option( $element, 'smw_elements_tabs', 'on' ) === 'on' ) && file_exists( smw_modules_dir . $element . '/widget.php' ) )
                    {
                        require( smw_modules_dir . $element . '/widget.php' );
                    }
                }
                
                if ( class_exists( 'woocommerce' ) )
                {
                    $smw_woocommerce_modules_manager = array(
                        'wc-categories',
                        'wc-product-archive',
                        'wc-special-offer',
                        'wc-cart-table',
                        'wc-cart-empty-message',
                        'wc-cart-empty-shop-redirect',
                        'wc-cart-total',
                        'wc-checkout-additional-form',
                        'wc-checkout-billing',
                        'wc-checkout-shipping-form',
                        'wc-checkout-payment',
                        'wc-checkout-coupon-form',
                        'wc-checkout-login-form',
                        'wc-my-account-account',
                        'wc-my-account-dashboard',
                        'wc-my-account-download',
                        'wc-my-account-edit-account',
                        'wc-my-account-address',
                        'wc-my-account-login-form',
                        'wc-my-account-register-form',
                        'wc-my-account-logout',
                        'wc-my-account-order',
                        'wc-order-review',
                        'wc-thank-you-order',
                        'wc-thank-you-customer-address-details',
                        'wc-thank-you-order-details',
                    );
                    
                    if( smw_get_option( 'ajaxsearch', 'smw_others_tabs', 'off' ) == 'on' )
                    {
                        $smw_woocommerce_modules_manager[] = 'wc-ajax-search';
                    }
                
                    $smw_woocommerce_product_modules_manager  = array(
                        'wc-add-to-cart-advanced',
                        'wc-price',
                        'wc-rating',
                        'wc-reviews',
                        'wc-add-to-cart',
                        'wc-additional-information',
                        'wc-brand',
                        'wc-call-for-price',
                        'wc-data-tabs',
                        'wc-description',
                        'wc-product-image',
                        'wc-product-meta',
                        'wc-product-stock',
                        'wc-product-title',
                        'wc-related',
                        'wc-related-advanced',
                        'wc-short-description',
                        'wc-suggest-price',
                        'wc-tabs',
                        'wc-universal-product',
                        'wc-upsell',
                        'wc-upsell-advanced',
                        'wc-video-gallery',
                        'wc-cross-sell',
                        'wc-cross-sell-advanced',
                        'wc-product-advance-thumbnails',
                        'wc-social-share',
                        'wc-stock-progress-bar',
                        'wc-single-product-sale',
                    );
                    
                    $smw_woocommerce_modules_manager = array_merge( $smw_woocommerce_modules_manager, $smw_woocommerce_product_modules_manager );
                    
                    foreach ( $smw_woocommerce_modules_manager as $element )
                    {
                        if (  ( smw_get_option( $element, 'smw_elements_tabs', 'on' ) === 'on' ) && file_exists( smw_woocommerce_dir . $element . '/widget.php' ) )
                        {
                            require( smw_woocommerce_dir . $element . '/widget.php' );
                        }
                    }
                }
            });
    	}
    	
    	public function register_categories()
    	{
    	    add_action( 'elementor/elements/categories_registered', function () 
            {
            	$elementsManager = Plugin::instance()->elements_manager;
            		
            	$elementsManager->add_category
            	(
            		'stiles-media-category',
            			array(
            				'title' => smw_category,
            				'icon'  => smw_category_icon,
            			)
            	);
            	
            	$elementsManager->add_category
            	(
            		'stiles-media-forms',
            			array(
            				'title' => smw_form_category,
            				'icon'  => smw_category_icon,
            			)
            	);
            	
            	$elementsManager->add_category
            	(
            		'stiles-media-users',
            			array(
            				'title' => smw_user_category,
            				'icon'  => smw_category_icon,
            			)
            	);
            	
            	$elementsManager->add_category
            	(
            		'stiles-media-headers',
            			array(
            				'title' => smw_headers_category,
            				'icon'  => smw_category_icon,
            			)
            	);
            	
            	$elementsManager->add_category
            	(
            		'stiles-media-commerce',
            			array(
            				'title' => smw_commerce_category,
            				'icon'  => smw_category_icon,
            			)
            	);
            });
    	}
    }
    
    SMW_Modules::get_instance();
}