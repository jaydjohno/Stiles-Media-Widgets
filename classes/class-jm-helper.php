<?php

namespace StilesMediaWidgets;

if ( ! class_exists( 'Stiles_JM_Helper' ) ) 
{
    class Stiles_JM_Helper
    {
        private static $instance;
        
        public static function get_instance() 
		{
			if(self::$instance === null) 
			{
				self::$instance = new self();
			}

			return self::$instance;
		}  
    }
    
    Stiles_JM_Helper::get_instance();
}