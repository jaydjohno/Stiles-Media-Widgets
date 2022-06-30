<?php
/**
 * SMW Advanced Button.
 *
 * @package StilesMediaWidgets
 */

namespace StilesMediaWidgets\Elementor\Widgets\StilesAdvancedButton;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once plugin_dir_path( __FILE__ ) . 'widget/advanced-button.php';

class Module
{

	/**
	 * Module should load or not.
	 *
	 * @since 1.20.0
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
	{ // phpcs:ignore Generic.CodeAnalysis.UselessOverridingMethod.Found
		parent::__construct();
	}
}