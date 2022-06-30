<?php

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

class smw_Admin_Setting
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        $this->smw_admin_settings_page();
    }

    /*
    *  Setting Page
    */
    public function smw_admin_settings_page() 
    {
        require_once('include/class.settings-api.php');
        require_once('include/admin-setting.php');
        require_once('include/template-library.php');
    }

    /*
    *  Enqueue admin scripts / styles
    */
    public function enqueue_scripts( $hook )
    {
        if( $hook === 'stiles-media_page_stiles' )
        {
            //register our admin CSS
            wp_register_style( 'admin_css', smw_url . 'inc/admin/assets/css/admin_options_panel.css', false, '2.1.0' );
            wp_enqueue_style( 'admin_css' );
            
            //register our Admin JS file
            wp_register_script( 'smw-admin-js', smw_url . 'inc/admin/assets/js/smw-admin.js' );
            
            $datalocalize = array(
                    'contenttype' => smw_get_option( 'notification_content_type','smw_sales_notification_tabs', 'actual' ),
                );
                
            wp_localize_script( 'smw-admin-js', 'admin_smlocalize_data', $datalocalize );
            wp_enqueue_script( 'smw-admin-js' );
        }
    }
}

new smw_Admin_Setting();