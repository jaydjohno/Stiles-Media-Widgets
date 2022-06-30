<?php
 
if ( ! class_exists('ReduxFramework') && file_exists( smw_dir . '/theme-options/framework.php') )
{
    require_once( smw_dir . 'theme-options/framework.php' );
}
 
if (! isset($redux_demo) && file_exists( smw_dir . '/theme-options/config.php') )
{
    require_once( smw_dir . 'theme-options/config.php' );
}