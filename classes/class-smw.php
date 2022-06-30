<?php

/**
 * Stiles Media Widgets Main Class
 *
 * @author 	Stiles Media
 * @version 2.1.0
 * @package stiles-media-widgets
 * @subpackage stiles-media-widgets/inc
 */
 
namespace StilesMediaWidgets;

defined( 'ABSPATH' ) or die( 'Direct Access Not Allowed!' );

if( !class_exists('Stiles_Media_Widgets') ) :

	class Stiles_Media_Widgets 
	{
		/**
	     * Plugin slug
	     *
	     * @since 1.0.0
	     *
	     * @type string
	     */
		public $plugin_slug;

		/**
	     * Plugin version
	     *
	     * @since 1.0.0
	     *
	     * @type string
	     */
		private $version;
		
		/**
	     * Plugin version
	     *
	     * @since 1.0.0
	     *
	     * @type string
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

		/**
		 * Plugin initialization functions
		 *
		 * @return 	null
		 * @since    1.0.0
		 */
		public function __construct() 
		{
			$this->plugin_slug = smw_slug;
			$this->version = smw_ver;

			$this->set_locale();
			$this->load_dependencies();
		}


		/**
		 * Loads all required plugin files and loads classes
		 *
		 * @return 	null
		 * @since   1.0.0
		 */
		private function load_dependencies() 
		{
			require_once smw_dir . 'classes/class-smw-base.php';
			require_once smw_dir . 'classes/class-smw-helper.php';
			require_once smw_dir . 'classes/class-smw-modules.php';
			//require_once smw_dir . 'classes/class.icon-manager.php';
		}

		/**
		 * Loads the plugin text-domain for internationalization
		 *
		 * @return 	null
		 * @since   1.0.0
		 */
		private function set_locale() 
		{
			load_plugin_textdomain( $this->plugin_slug, false, smw_dir . 'language' );
	    }
	}
	
    Stiles_Media_Widgets::get_instance();

endif;