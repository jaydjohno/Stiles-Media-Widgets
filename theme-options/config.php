<?php
 
if ( ! class_exists('Redux') )
{
    return;
}

$opt_name = "sm-theme";

$theme = wp_get_theme();

$args = array(
    'opt_name' => $opt_name,
    'display_name' => $theme->get('Name') ,
    'display_version' => $theme->get('Version') ,
    'menu_type' => 'submenu',
    'allow_sub_menu' => true,
    'menu_title' => esc_html__('Theme Options', smw_slug ) , 'page_title'           => esc_html__('Theme Options', smw_slug ) ,
    'google_api_key' => '',
    'google_update_weekly' => false,
    'async_typography' => true,
    'admin_bar' => true,
    'admin_bar_icon' => '',
    'admin_bar_priority' => 50,
    'global_variable' => $opt_name,
    'dev_mode' => false,
    'update_notice' => false,
    'customizer' => true,
    'page_priority' => null,
    'page_parent' => 'smw_page',
    'page_permissions' => 'manage_options',
    'menu_icon' => '',
    'last_tab' => '',
    'page_icon' => 'icon-themes',
    'page_slug' => 'themeoptions',
    'save_defaults' => true,
    'default_show' => false,
    'default_mark' => '',
    'show_import_export' => true,
    'footer_credit' => 'Theme Options provided by <a href="https://www.stiles.media" target="_blank">Stiles Media</a>',
);

Redux::setArgs( $opt_name, $args );