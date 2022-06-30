<?php

namespace StilesMediaWidgets;

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

if ( ! class_exists( 'SMW_Helper' ) ) 
{
	/**
	 * Class SMW_Helper.
	 */
	final class SMW_Helper 
	{
    	/**
    	 * Elementor Saved page templates list
    	 *
    	 * @var page_templates
    	 */
    	private static $page_templates = null;
    
    	/**
    	 * Elementor saved section templates list
    	 *
    	 * @var section_templates
    	 */
    	private static $section_templates = null;
    
    	/**
    	 * Elementor saved widget templates list
    	 *
    	 * @var widget_templates
    	 */
    	private static $widget_templates = null;

        /**
    	 * Empty instance for class inititialisation
    	 *
    	 * @since 1.0.0
    	 *
    	 * @var string Minimum PHP version required to run the plugin.
    	 */
	    private static $instance;
    	
    	public static function get_instance() 
    	{
    		if ( ! isset( self::$instance ) ) 
    		{
    			self::$instance = new self();
    		}
		    return self::$instance;
	    }
	    
	    public function __construct() 
		{
			$this->load_styles();
			
			$this->load_scripts();
			
			$this->load_dependencies();
		}
	    
	    public function load_scripts()
        {
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_js' ) );
        }
        
        public function widget_js()
        {
            //load Bootstrap Javascript files
            wp_register_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js' , array( 'jquery', ), '3.4.1' , true );
            //load Slick JS
            wp_register_script( 'slick-js', plugins_url( '../assets/js/slick.js', __FILE__ ), array( 'jquery', ), smw_ver , true );
            
            //load our product JS files if WooCommerce installed
            if ( class_exists( 'woocommerce' ) ) 
            {
                wp_register_script( 'product-slider-js', plugins_url( '../assets/js/product-slider.js', __FILE__ ), array( 'jquery' ), '', true );
                wp_register_script( 'product-image-thumbnail-js', plugins_url( '../assets/js/product-image-thumbnail.js', __FILE__ ), array( 'jquery' ), '', true );
                wp_register_script( 'product-tooltip-js', plugins_url( '../assets/js/product-tooltip.js', __FILE__ ), array( 'jquery' ), '', true );
                wp_register_script( 'product-tabs-js', plugins_url( '../assets/js/product-tabs.js', __FILE__ ), array( 'jquery' ), '', true );
                wp_register_script( 'countdown', plugins_url( '../assets/js/countdown.js', __FILE__ ), array( 'jquery' ), '', true );
                wp_register_script( 'main-js', plugins_url( '../assets/js/main.js', __FILE__ ), array( 'jquery' ), '', true );
                wp_register_script( 'mini-cart-js', plugins_url( '../assets/js/mini-cart.js', __FILE__ ), array( 'jquery' ), '', true );
                wp_register_script( 'jquery-single-product-ajax-cart', plugins_url( '../assets/js/single_product_ajax_add_to_cart.js', __FILE__ ), array( 'jquery' ), '', true );
                
                if( smw_get_option( 'ajaxsearch', 'smw_others_tabs', 'off' ) == 'on' )
                {
                    //Load our Ajax Search JS file
                    wp_register_script( 'stiles-ajax-search', plugins_url( '../assets/js/ajax-search.js', __FILE__ ), array( 'jquery' ), '', true );
                }
            }
            
            //Load in the JQuery Nice Scroll Library
            wp_register_script( 'jquery-nicescroll', plugins_url( '../assets/js/jquery.nicescroll.js', __FILE__ ), array( 'jquery' ), '', true );
 
		    //load Lottie Animations Files
            wp_register_script( 'lottie-js', plugins_url( '../assets/js/lottie.js', __FILE__ ), array( 'jquery' ), '', true );
		    //load Frontend files for Ajax etc
		    wp_register_script( 'smwFrontend', plugins_url( '../assets/js/frontend.js', __FILE__ ), array( 'jquery' ), '', true );
		
    		wp_localize_script(
			    'smwFrontend', 'smw_ajax_url', admin_url("admin-ajax.php")
		    );
		    
		    wp_localize_script(
			    'smwFrontend', 'smw_nonce', wp_create_nonce("smw-nonce")
		    );
    		
    		wp_enqueue_script( 'smwFrontend' );
    		
    		if( smw_get_option( 'languagetranslator', 'smw_others_tabs', 'off' ) == 'on' )
            {
        		//register our JS for our Website Translator
        	    wp_register_script( 'stiles-website-translator', plugins_url( '../assets/js/website-translator.js', __FILE__ ), array( 'jquery' ), '', true );
        	    
        	    //register our Google JS Translate file as well
        	    wp_register_script('googletranslate', 'http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit');
            }
        }
        
        public function load_styles() 
        {
        	// Register Widget Styles
        	add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'widget_styles' ) );
        }
        
        public function widget_styles() 
        {
            //load our main css file
        	wp_register_style( 'stiles-media-frontend', plugins_url( '../assets/css/frontend.css', __FILE__ ) );
        	wp_enqueue_style('stiles-media-frontend');
        	//register our products css
        	wp_register_style( 'sm-products-css', plugins_url( '../assets/css/products.css', __FILE__ ) );
        	wp_enqueue_style('sm-products-css');
        	//register product qucik view
        	wp_register_style( 'product-quick-view', plugins_url( '../assets/css/product-quick-view.css', __FILE__ ) );
        	wp_enqueue_style('product-quick-view');
        	//register slick CSS file
            wp_register_style( 'slick-css', plugins_url( '../assets/css/slick.css', __FILE__ ) );
        	//register Bootstrap CSS
        	wp_register_style( 'bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css' );
            //load font awesome for our widgets
            wp_register_style( 'font-awesome', plugins_url( '../assets/css/font-awesome.min.css', __FILE__ ) );
            //load simple lince icons for our widgets
        	wp_register_style( 'simple-line-icons', plugins_url( '../assets/css/simple-line-icons.css', __FILE__ ) );
            //load our flex box grid stiles
        	wp_register_style( 'flex-box-grid', plugins_url( '../assets/css/flex-box-grid.css', __FILE__ ) );
        	//add our animate CSS
        	wp_register_style( 'animate-css', plugins_url( '../assets/css/animate.css', __FILE__ ) );
        	//Add our Mini Cart CSS
        	wp_register_style( 'mini-cart-css', plugins_url( '../assets/css/mini-cart.css', __FILE__ ) );
        	//add our sticky cart css
        	wp_register_style( 'sticky-cart-css', plugins_url( '../assets/css/sticky-cart.css', __FILE__ ) );
        	//register our sales notifications style
        	wp_register_style( 'sales-notification-css', plugins_url( '../assets/css/product-notifications.css', __FILE__ ) );
            wp_enqueue_style('sales-notification-css');
            
        	if( smw_get_option( 'mini_side_cart', 'smw_others_tabs', 'off' ) == 'on' )
            {
                wp_enqueue_style('mini-cart-css');
                wp_enqueue_style('simple-line-icons');
            }
            
            if( smw_get_option( 'single_product_sticky_add_to_cart', 'smw_others_tabs', 'off' ) == 'on' )
            {
                wp_enqueue_style( 'sticky-cart-css' );
                wp_enqueue_style( 'flex-box-grid' );
            }
            
            if( smw_get_option( 'ajaxsearch', 'smw_others_tabs', 'off' ) == 'on' )
            {
                //Add our Ajax Search CSS
        	    wp_register_style( 'stiles-ajax-search', plugins_url( '../assets/css/ajax-search.css', __FILE__ ) );
            }
        	
        	if( smw_get_option( 'languagetranslator', 'smw_others_tabs', 'off' ) == 'on' )
            {
                //add our CSS for the Website Translator
        	    wp_register_style( 'stiles-website-translator', plugins_url( '../assets/css/stiles-translate.css', __FILE__ ) );
            }
        }
        
        public function load_dependencies()
        {
            //load our other helpers
            require_once smw_dir . 'classes/class-jm-helper.php';
            require_once smw_dir . 'classes/class-wc-helper.php';
        }
        
        public static function get_animation_options()
        {
            return array(
                'no-animation' => esc_html__( 'No-animation', smw_slug ),
        		'transition.fadeIn' => esc_html__( 'FadeIn', smw_slug ),
        		'transition.flipXIn' => esc_html__( 'FlipXIn', smw_slug ),
        		'transition.flipYIn' => esc_html__( 'FlipYIn', smw_slug ),
        		'transition.flipBounceXIn' => esc_html__( 'FlipBounceXIn', smw_slug ),
        		'transition.flipBounceYIn' => esc_html__( 'FlipBounceYIn', smw_slug ),
        		'transition.swoopIn' => esc_html__( 'SwoopIn', smw_slug ),
        		'transition.whirlIn' => esc_html__( 'WhirlIn', smw_slug ),
        		'transition.shrinkIn' => esc_html__( 'ShrinkIn', smw_slug ),
        		'transition.expandIn' => esc_html__( 'ExpandIn', smw_slug ),
        		'transition.bounceIn' => esc_html__( 'BounceIn', smw_slug ),
        		'transition.bounceUpIn' => esc_html__( 'BounceUpIn', smw_slug ),
        		'transition.bounceDownIn' => esc_html__( 'BounceDownIn', smw_slug ),
        		'transition.bounceLeftIn' => esc_html__( 'BounceLeftIn', smw_slug ),
        		'transition.bounceRightIn' => esc_html__( 'BounceRightIn', smw_slug ),
        		'transition.slideUpIn' => esc_html__( 'SlideUpIn', smw_slug ),
        		'transition.slideDownIn' => esc_html__( 'SlideDownIn', smw_slug ),
        		'transition.slideLeftIn' => esc_html__( 'SlideLeftIn', smw_slug ),
        		'transition.slideRightIn' => esc_html__( 'SlideRightIn', smw_slug ),
        		'transition.slideUpBigIn' => esc_html__( 'SlideUpBigIn', smw_slug ),
        		'transition.slideDownBigIn' => esc_html__( 'SlideDownBigIn', smw_slug ),
        		'transition.slideLeftBigIn' => esc_html__( 'SlideLeftBigIn', smw_slug ),
        		'transition.slideRightBigIn' => esc_html__( 'SlideRightBigIn', smw_slug ),
        		'transition.perspectiveUpIn' => esc_html__( 'PerspectiveUpIn', smw_slug ),
        		'transition.perspectiveDownIn' => esc_html__( 'PerspectiveDownIn', smw_slug ),
        		'transition.perspectiveLeftIn' => esc_html__( 'PerspectiveLeftIn', smw_slug ),
        		'transition.perspectiveRightIn' => esc_html__( 'PerspectiveRightIn', smw_slug ),
            );
        }
        
        public static function get_out_animation_options()
        {
            return array(
                'no-animation' => esc_html__( 'No-animation', smw_slug ),
        		'transition.fadeOut' => esc_html__( 'FadeOut', smw_slug ),
        		'transition.flipXOut' => esc_html__( 'FlipXOut', smw_slug ),
        		'transition.flipYOut' => esc_html__( 'FlipYOut', smw_slug ),
        		'transition.flipBounceXOut' => esc_html__( 'FlipBounceXOut', smw_slug ),
        		'transition.flipBounceYOut' => esc_html__( 'FlipBounceYOut', smw_slug ),
        		'transition.swoopOut' => esc_html__( 'SwoopOut', smw_slug ),
        		'transition.whirlOut' => esc_html__( 'WhirlOut', smw_slug ),
        		'transition.shrinkOut' => esc_html__( 'ShrinkOut', smw_slug ),
        		'transition.expandOut' => esc_html__( 'ExpandOut', smw_slug ),
        		'transition.bounceOut' => esc_html__( 'BounceOut', smw_slug ),
        		'transition.bounceUpOut' => esc_html__( 'BounceUpOut', smw_slug ),
        		'transition.bounceDownOut' => esc_html__( 'BounceDownOut', smw_slug ),
        		'transition.bounceLeftOut' => esc_html__( 'BounceLeftOut', smw_slug ),
        		'transition.bounceRightOut' => esc_html__( 'BounceRightOut', smw_slug ),
        		'transition.slideUpOut' => esc_html__( 'SlideUpOut', smw_slug ),
        		'transition.slideDownOut' => esc_html__( 'SlideDownOut', smw_slug ),
        		'transition.slideLeftOut' => esc_html__( 'SlideLeftOut', smw_slug ),
        		'transition.slideRightOut' => esc_html__( 'SlideRightOut', smw_slug ),
        		'transition.slideUpBigOut' => esc_html__( 'SlideUpBigOut', smw_slug ),
        		'transition.slideDownBigOut' => esc_html__( 'SlideDownBigOut', smw_slug ),
        		'transition.slideLeftBigOut' => esc_html__( 'SlideLeftBigOut', smw_slug ),
        		'transition.slideRightBigOut' => esc_html__( 'SlideRightBigOut', smw_slug ),
        		'transition.perspectiveUpOut' => esc_html__( 'PerspectiveUpOut', smw_slug ),
        		'transition.perspectiveDownOut' => esc_html__( 'PerspectiveDownOut', smw_slug ),
        		'transition.perspectiveLeftOut' => esc_html__( 'PerspectiveLeftOut', smw_slug ),
        		'transition.perspectiveRightOut' => esc_html__( 'PerspectiveRightOut', smw_slug ),
            );
        }
        
        public static function get_saved_data( $type = 'page' ) 
	    {
    		$template_type = $type . '_templates';
    
    		$templates_list = array();
    
    		if ( ( null === self::$page_templates && 'page' === $type ) || ( null === self::$section_templates && 'section' === $type ) || ( null === self::$widget_templates && 'widget' === $type ) ) {
    
    			$posts = get_posts(
    				array(
    					'post_type'      => 'elementor_library',
    					'orderby'        => 'title',
    					'order'          => 'ASC',
    					'posts_per_page' => '-1',
    					'tax_query'      => array(
    						array(
    							'taxonomy' => 'elementor_library_type',
    							'field'    => 'slug',
    							'terms'    => $type,
    						),
    					),
    				)
    			);
    
    			foreach ( $posts as $post ) 
    			{
    				$templates_list[] = array(
    					'id'   => $post->ID,
    					'name' => $post->post_title,
    				);
    			}
    
    			self::${$template_type}[-1] = __( 'Select', smw_slug );
    
    			if ( count( $templates_list ) ) 
    			{
    				foreach ( $templates_list as $saved_row ) 
    				{
    					$content_id                            = $saved_row['id'];
    					$content_id                            = apply_filters( 'wpml_object_id', $content_id );
    					self::${$template_type}[ $content_id ] = $saved_row['name'];
    
    				}
    			} else {
    				self::${$template_type}['no_template'] = __( 'We couldn\'t find any templates in your library', smw_slug );
    			}
    		}
    
    		return self::${$template_type};
	    }
	    
	    public static function get_registered_sidebars()
    	{
    	    global $wp_registered_sidebars;
            $options = [];
    
            if (!$wp_registered_sidebars) {
                $options[''] = __('No sidebars were found', 'essential-addons-elementor');
            } else {
                $options['---'] = __('Choose Sidebar', 'essential-addons-elementor');
    
                foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
                    $options[$sidebar_id] = $sidebar['name'];
                }
            }
            return $options;
    	}
    	
    	public function get_all_posts() 
	    {
    		$all_posts = get_posts( array(
                    'posts_per_page'    => -1,
    				'post_type'         => array ( 'page', 'post' ),
    			)
    		);
    		if( !empty( $all_posts ) && !is_wp_error( $all_posts ) ) {
    			foreach ( $all_posts as $post ) {
    				$this->options[ $post->ID ] = strlen( $post->post_title ) > 20 ? substr( $post->post_title, 0, 20 ).'...' : $post->post_title;
    			}
    		}
    		return $this->options;
	    }
    	
    	public static function is_elementor_updated() 
    	{
    		if ( class_exists( 'Elementor\Icons_Manager' ) ) {
    			return true;
    		} else {
    			return false;
    		}
    	}
    	
    	public static function get_new_icon_name( $control_name ) 
    	{
    		if ( class_exists( 'Elementor\Icons_Manager' ) ) {
    			return 'new_' . $control_name . '[value]';
    		} else {
    			return $control_name;
    		}
    	}
	}
	
	SMW_Helper::get_instance();
}