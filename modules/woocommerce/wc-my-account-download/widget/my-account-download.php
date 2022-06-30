<?php

/**
 * Stiles Media Widgets My Account: Downloads.
 *
 * @package SMW
 */
 
namespace StilesMediaWidgets;

if ( ! defined( 'ABSPATH' ) ) 
{
	exit;   // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Base;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Widget_Base;

class stiles_wc_my_account_download extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-my-account-download';
    }
    
    public function get_title() 
    {
        return __( 'My Account: Downloads', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-download-button';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => __( 'My Account Download', smw_slug ),
            )
        );

            $this->add_control(
                'html_notice',
                array(
                    'label' => __( 'Element Information', smw_slug ),
                    'show_label' => false,
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => __( 'My Account Download', smw_slug ),
                )
            );

        $this->end_controls_section();
    }
    
    protected function render() 
    {
        if ( Plugin::instance()->editor->is_edit_mode() ) 
        {
            do_action('woocommerce_account_downloads_endpoint');
        }else
        {
            if ( ! is_user_logged_in() ) 
            { 
                return __('You need to be logged in to view this page', smw_slug); 
            }
            
            if ( is_account_page() ) 
            {
                do_action('woocommerce_account_downloads_endpoint');
            }
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_my_account_download() );