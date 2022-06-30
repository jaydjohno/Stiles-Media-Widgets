<?php

/**
 * SMW Template Selector.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_template_selector extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);
    }
    
    public function get_name()
    {
        return 'stiles-template-selector';
    }
    
    public function get_title()
    {
        return 'Template Selector';
    }
    
    public function get_icon()
    {
        return 'eicon-t-letter';
    }
    
    public function get_categories()
    {
        return [ 'stiles-media-category' ];
    }
    
    protected function register_controls() 
	{
	    // Content
        $this->start_controls_section(
            'template_selector_content',
            [
                'label' => esc_html__( 'Template', smw_slug ),
            ]
        );
            
            $this->add_control(
                'template_id',
                [
                    'label' => __( 'Select Your template', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '0',
                    'options' => smw_elementor_template(),
                ]
            );

        $this->end_controls_section();
	}
	
	protected function render()
	{
	    $settings = $this->get_settings_for_display();

        if ( ! empty( $settings['template_id'] )) 
        {
            echo Plugin::instance()->frontend->get_builder_content_for_display( $settings['template_id'] );
        }else
        {
            echo '<div class="smw_error">'.esc_html__( 'No template has been selected', smw_slug ).'<div/>';
        }
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_template_selector() );