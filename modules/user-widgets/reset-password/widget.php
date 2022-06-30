<?php
/**
 * SMW Forgot Password Form Module.
 *
 * @package StilesMediaWidgets
 */

namespace StilesMediaWidgets\Elementor\Widgets\StilesForgotPassword;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once plugin_dir_path( __FILE__ ) . 'widget/reset-password.php';

/**
 * Class Module.
 */
class Module
{
    /**
	 * Module should load or not.
	 *
	 * @since 1.18.0
	 * @access public
	 *
	 * @return bool true|false.
	 */
	public static function is_enabled() 
	{
		return true;
	}
	
	/**
	 * Constructor.
	 */
	public function __construct() 
	{
		parent::__construct();

		add_action( 'wp_ajax_smw_forgot_password', array( $this, 'get_form_data' ) );
		add_action( 'wp_ajax_nopriv_smw_forgot_password', array( $this, 'get_form_data' ) );
		add_action( 'login_form_lostpassword', array( $this, 'redirect_to_custom_lostpassword' ) );
		add_action( 'login_form_lostpassword', array( $this, 'get_form_data' ) );
	}
	
	public function get_form_data() 
	{
	    
	}
	
	public function redirect_to_custom_lostpassword() 
	{
        if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) 
        {
            if ( is_user_logged_in() ) {
                $this->redirect_logged_in_user();
                exit;
            }
     
            wp_redirect( home_url( 'member-password-lost' ) );
            exit;
        }
    }
    
    
    
}