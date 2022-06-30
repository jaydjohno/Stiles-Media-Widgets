<?php

/**
 * The base class for the Stiles EDD plugin
 *
 * @author 	Stiles Media
 * @version 1.0.0
 * @package stiles-edd-plugin
 * @subpackage stiles-edd-plugin/inc
 */

namespace StilesMediaWidgets;

defined( 'ABSPATH' ) or die( 'Direct Access Not Allowed!' );

if(!class_exists('SMW_Base')) :

	class SMW_Base 
	{
		/**
	     * Class instance variable
	     *
	     * @since 1.0.0
	     *
	     * @type object ::self
	     */
		private static $instance;

		/**
		 * Define class & plugin variables
		 *
		 * @return 	null
		 * @since   1.0.0
		 */
		public function __construct() 
		{
			// Get self instance
			self::$instance = $this;
			
			$this->init();
		}
		
		public function init()
		{
		    
		}

		/**
		 * Return instance of base class
		 *
		 * @return 	null
		 * @since   1.0.0
		 */
		public static function get_instance() 
		{
			if(self::$instance === null) 
			{
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
	
	SMW_Base::get_instance();

endif;