<?php

namespace StilesMediaWidgets;

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) 
{
    if ( ! class_exists( 'Stiles_WC_Helper' ) ) 
    {
        class Stiles_WC_Helper
        {
            public function __construct() 
            {
				// Called only after woocommerce has finished loading.
				add_action( 'woocommerce_init', array( $this, 'woocommerce_loaded' ) );
				// Called after all plugins have loaded.
				add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

				// Called just before the woocommerce template functions are included.
				add_action( 'init', array( $this, 'include_template_functions' ), 20 );

				// Indicates we are running the admin.
				if ( is_admin() ) 
				{
					is_admin();
				}

				// Indicates we are being served over ssl.
				if ( is_ssl() ) 
				{
					is_ssl();
				}

				// Take care of anything else that needs to be done immediately upon plugin instantiation, here in the constructor.
			}
			
			 /* Take care of anything that needs woocommerce to be loaded.
			 *  For instance, if you need access to the $woocommerce global
			 */
			public function woocommerce_loaded() 
			{
				include smw_dir . 'modules/woocommerce/wc-product-archive/product_archive_render.php';
			}

			/**
			 * Take care of anything that needs all plugins to be loaded
			 */
			public function plugins_loaded() 
			{

				/**
				 * Localisation
				 */
				load_plugin_textdomain( 'stiles-media-widgets', false, dirname( plugin_basename( __FILE__ ) ) . '/' );
			}
			
			/**
			 * Override any of the template functions from woocommerce/woocommerce-template.php
			 * with our own template functions file
			 */
			public function include_template_functions() 
			{
				//include 'woocommerce-template.php';
			}
        }
        
        $GLOBALS['sm_wc_helper'] = new Stiles_WC_Helper();
    }
    
    function myplugin_plugin_path() 
    {
      // gets the absolute path to this plugin directory
    
      return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }
    
    //add_filter( 'woocommerce_locate_template', 'smw_woocommerce_locate_template', 10, 3 );
    
    /*function smw_woocommerce_locate_template( $template, $template_name, $template_path ) 
    {
        global $woocommerce;
    
        $_template = $template;
    
        if ( ! $template_path ) $template_path = $woocommerce->template_url;
    
        $plugin_path  = myplugin_plugin_path() . '/woocommerce/';
    
        // Look within passed path within the theme - this is priority
        $template = locate_template(
            array(
                $template_path . $template_name,
                $template_name
            )
        );
    
        // Modification: Get the template from this plugin, if it exists
        if ( ! $template && file_exists( $plugin_path . $template_name ) )
            $template = $plugin_path . $template_name;
    
        // Use default template
        if ( ! $template )
            $template = $_template;
    
        // Return what we found
        return $template;
    }*/
}