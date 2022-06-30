<?php
/**
 * Plugin Name: Stiles Media Widgets
 * Plugin URI: https://stiles.media
 * Description: This plugin installs Elementor Site Widgets for your Theme.
 * Version: 2.1.0
 * Author: Stiles Media
 * Author URI: https://stiles.media
 * 
 * @package StilesMediaWidgets
 */

if ( ! defined( 'ABSPATH' ) ) 
{
	exit; // Exit if accessed directly.
}

// Define constants
define( 'smw_base', plugin_basename( __FILE__ ) );
define( 'smw_dir', plugin_dir_path( __FILE__ ) );
define( 'smw_url', plugins_url( '/', __FILE__ ) );
define( 'smw_ver', '2.1.0' );
define( 'smw_modules_dir', smw_dir . 'modules/' );
define( 'smw_modules_url', smw_url . 'modules/' );
define( 'smw_heading_dir', smw_dir . 'modules/headings/' );
define( 'smw_heading_url', smw_url . 'modules/headings/' );
define( 'smw_user_dir', smw_dir . 'modules/user-widgets/' );
define( 'smw_user_url', smw_url . 'modules/user-widgets/' );
define( 'smw_forms_dir', smw_dir . 'modules/forms/' );
define( 'smw_forms_url', smw_url . 'modules/forms/' );
define( 'smw_woocommerce_dir', smw_dir . 'modules/woocommerce/' );
define( 'smw_woocommerce_url', smw_url . 'modules/woocommerce/' );
define( 'smw_slug', 'stiles-media-widgets' );
define( 'smw_category', 'Stiles Media' );
define( 'smw_form_category', 'Stiles Media Forms' );
define( 'smw_user_category', 'Stiles Media User' );
define( 'smw_headers_category', 'Stiles Media Headings' );
define( 'smw_commerce_category', 'Stiles Media WooCommerce' );
define( 'smw_job_category', 'Stiles Media Job Manager' );
define('smw_category_icon', 'fonts');
define('SMW_Required_PHP_Version', '7.0');
define('SMW_Required_WP_Version',  '5.0');
define('SMW_Required_ELEMENTOR_Version',  '2.1.0');

/**
 * Main Elementor SMW Loader Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class SMW_Loader 
{
	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance() 
	{
		if ( is_null( self::$_instance ) ) 
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() 
	{
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() 
	{
		load_plugin_textdomain( smw_slug );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() 
	{
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) 
		{
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, SMW_Required_ELEMENTOR_Version, '>=' ) ) 
		{
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, SMW_Required_PHP_Version, '<' ) ) 
		{
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}
		
		// Check for required PHP version
		if ( version_compare( get_bloginfo('version'), SMW_Required_WP_Version, '<' ) ) 
		{
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_wp_version' ] );
			return;
		}

		self::load_dependencies();
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() 
	{
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', smw_slug ),
			'<strong>' . esc_html__( 'Stiles Media Widgets', smw_slug ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', smw_slug ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() 
	{
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', smw_slug ),
			'<strong>' . esc_html__( 'Stiles Media Widgets', smw_slug ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', smw_slug ) . '</strong>',
			 SMW_Required_ELEMENTOR_Version
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() 
	{
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', smw_slug ),
			'<strong>' . esc_html__( 'Stiles Media Widgets', smw_slug ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', smw_slug ) . '</strong>',
			 SMW_Required_PHP_Version
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required WP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_wp_version() 
	{
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', smw_slug ),
			'<strong>' . esc_html__( 'Stiles Media Widgets', smw_slug ) . '</strong>',
			'<strong>' . esc_html__( 'WordPress', smw_slug ) . '</strong>',
			 SMW_Required_WP_Version
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	
	public function load_dependencies()
	{
	    /**
         * The core plugin classes that is used to define internationalization,
         * admin-specific hooks, and public-facing site hooks.
         */
        require smw_dir .  'classes/class-smw.php';
        
        /**
         * The core plugin file that loads all our ajax functions.
         */
        require smw_dir .  'inc/ajax/ajax-functions.php';
        
        /**
         * The core plugin file that loads all helper functions.
         */
        require smw_dir .  'inc/functions/helper-functions.php';
        
        //do they want to use the language translator
        
        if( smw_get_option( 'languagetranslator', 'smw_others_tabs', 'off' ) == 'on' )
        {
            require( smw_dir . 'inc/widgets/language-translator/base.php' );
        }
        
        //load in our theme options panel if our theme is active
        
        $theme = wp_get_theme(); // gets the current theme
        
        if ( 'Stiles Media' == $theme->name || 'Stiles Media' == $theme->parent_theme ) 
        {
            require( smw_dir . 'theme-options/setup.php' );
        }
        
        /**
         * Load all our woocommerce classes if WooCommerce is activated.
         */
        if ( class_exists( 'woocommerce' ) )
        {
            require smw_dir .  'woocommerce/classes/class.my_account.php';
            
            if( smw_get_option( 'enablecustomlayout', 'smw_template_tabs', 'on' ) == 'on' )
            {
                include( smw_dir . 'woocommerce/classes/sm_woo_shop.php' );
    
                if( ! is_admin() && smw_get_option( 'enablerenamelabel', 'smw_rename_label_tabs', 'off' ) == 'on' )
                {
                    require smw_dir .  'inc/functions/rename_label.php';
                }
            }
            
            if( ! empty( smw_get_option( 'productcheckoutpage', 'smw_template_tabs', '0' ) ) )
            {
                require smw_dir .  'woocommerce/classes/class.checkout_page.php';
            }
            
            if( smw_get_option( 'enableresalenotification', 'smw_sales_notification_tabs', 'off' ) == 'on' )
            {
                if( smw_get_option( 'notification_content_type', 'smw_sales_notification_tabs', 'actual' ) == 'fakes' )
                {
                    include( smw_dir . 'classes/class.sale_notification_fake.php' );
                }else
                {
                    include( smw_dir . 'classes/class.sale_notification.php' );
                }
            }
          
          	// Search
            if( smw_get_option( 'ajaxsearch', 'smw_others_tabs', 'off' ) == 'on' )
            {
                require( smw_dir . 'inc/widgets/ajax-search/base.php' );
            }
          
          	// Single Product Ajax cart
            if( smw_get_option( 'ajaxcart_singleproduct', 'smw_others_tabs', 'off' ) == 'on' )
            {
                if ( 'yes' === get_option('woocommerce_enable_ajax_add_to_cart') ) 
                {
                    require( smw_dir . 'woocommerce/classes/class.single_product_ajax_add_to_cart.php' );
                }
            }
            
            require( smw_dir . 'classes/class.extension.php' );
        }
        
        // Admin Setting file
        if( is_admin() )
        {
            require( smw_dir . 'inc/admin/admin-init.php' );
            
            if ( class_exists( 'woocommerce' ) )
            {
                require( smw_dir . 'inc/functions/custom-metabox.php' );
            }

            // Post / Page Duplicator
            if( smw_get_option( 'postduplicator', 'smw_others_tabs', 'off' ) === 'on' )
            {
                require_once ( smw_dir . '/lib/duplicator/duplicator.php' );
            }
            
            // User Switching
            if( smw_get_option( 'user_switching', 'smw_others_tabs', 'off' ) === 'on' )
            {
                require_once ( smw_dir . '/lib/user-switching/user-switching.php' );
                require_once ( smw_dir . '/lib/admin-bar-user-switching/admin-bar-user-switching.php' );
            }
            
            // WooCommerce Image Flipping
            if( smw_get_option( 'image_flipper', 'smw_others_tabs', 'off' ) === 'on' )
            {
                require_once ( smw_dir . '/lib/image-flipper/image-flipper.php' );
            }
        }
	}
}

SMW_Loader::instance();