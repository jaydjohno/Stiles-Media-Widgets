<?php

namespace StilesMediaWidgets\Elementor\Widgets\StilesWCUpsell;

require_once plugin_dir_path( __FILE__ ) . 'widget/upsell.php';

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

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
	}
}