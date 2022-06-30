<?php

/**
 * SMW Advanced Tabs.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use \Elementor\Controls_Manager;
use \Elementor\Plugin;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Background;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_advanced_tabs extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'advanced-tabs-css', plugin_dir_url( __FILE__ )  .  '../css/advanced-tabs.css');
        
        wp_register_script( 'advanced-tabs-js', plugin_dir_url( __FILE__ ) . '../js/advanced-tabs.js');
    }
    
    public function get_name()
    {
        return 'stiles-advanced-tabs';
    }
    
    public function get_title()
    {
        return 'Advanced Tabs';
    }
    
    public function get_icon()
    {
        return 'eicon-product-tabs';
    }
    
    public function get_categories()
    {
        return array('stiles-media-category');
    }
    
    public function get_style_depends() 
    {
        return [ 'advanced-tabs-css' ];
    }
    
    public function get_script_depends() 
    {
        return [ 'advanced-tabs-js' ];
    }
    
    public function smw_get_page_templates($type = null)
    {
        $args = [
            'post_type' => 'elementor_library',
            'posts_per_page' => -1,
        ];

        if ($type) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'elementor_library_type',
                    'field' => 'slug',
                    'terms' => $type,
                ],
            ];
        }

        $page_templates = get_posts($args);
        $options = array();

        if (!empty($page_templates) && !is_wp_error($page_templates)) {
            foreach ($page_templates as $post) {
                $options[$post->ID] = $post->post_title;
            }
        }
        return $options;
    }
    
    protected function register_controls()
    { 
	    $this->register_general_settings();
	    
	    $this->register_content_settings();

        $this->register_general_styles();
        
        $this->register_tab_title_style();
        
        $this->register_content_style();
        
        $this->register_caret_style();
	}
	
	protected function register_general_settings()
	{
	    $this->start_controls_section(
            'smw_section_adv_tabs_settings',
            array(
                'label' => esc_html__('General Settings', smw_slug),
            )
        );
        $this->add_control(
            'smw_adv_tab_layout',
            array(
                'label' => esc_html__('Layout', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'smw-tabs-horizontal',
                'label_block' => false,
                'options' => array(
                    'smw-tabs-horizontal' => esc_html__('Horizontal', smw_slug),
                    'smw-tabs-vertical' => esc_html__('Vertical', smw_slug),
                ),
            )
        );
        $this->add_control(
            'smw_adv_tabs_icon_show',
            array(
                'label' => esc_html__('Enable Icon', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            )
        );
        $this->add_control(
            'smw_adv_tab_icon_position',
            array(
                'label' => esc_html__('Icon Position', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'smw-tab-inline-icon',
                'label_block' => false,
                'options' => array(
                    'smw-tab-top-icon' => esc_html__('Stacked', smw_slug),
                    'smw-tab-inline-icon' => esc_html__('Inline', smw_slug),
                ),
                'condition' => array(
                    'smw_adv_tabs_icon_show' => 'yes',
                ),
            )
        );
        $this->end_controls_section();
	}
	
	protected function register_content_settings()
	{
	    $this->start_controls_section(
            'smw_section_adv_tabs_content_settings',
            array(
                'label' => esc_html__('Tab Content', smw_slug),
            )
        );
        $this->add_control(
            'smw_adv_tabs_tab',
            array(
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => array(
                    array('smw_adv_tabs_tab_title' => esc_html__('Tab Title 1', smw_slug)),
                    array('smw_adv_tabs_tab_title' => esc_html__('Tab Title 2', smw_slug)),
                    array('smw_adv_tabs_tab_title' => esc_html__('Tab Title 3', smw_slug)),
                ),
                'fields' => array(
                    array(
                        'name' => 'smw_adv_tabs_tab_show_as_default',
                        'label' => __('Set as Default', smw_slug),
                        'type' => Controls_Manager::SWITCHER,
                        'default' => 'inactive',
                        'return_value' => 'active-default',
                    ),
                    array(
                        'name' => 'smw_adv_tabs_icon_type',
                        'label' => esc_html__('Icon Type', smw_slug),
                        'type' => Controls_Manager::CHOOSE,
                        'label_block' => false,
                        'options' => array(
                            'none' => array(
                                'title' => esc_html__('None', smw_slug),
                                'icon' => 'fa fa-ban',
                            ),
                            'icon' => array(
                                'title' => esc_html__('Icon', smw_slug),
                                'icon' => 'fa fa-gear',
                            ),
                            'image' => array(
                                'title' => esc_html__('Image', smw_slug),
                                'icon' => 'fa fa-picture-o',
                            ),
                        ),
                        'default' => 'icon',
                    ),
                    array(
                        'name' => 'smw_adv_tabs_tab_title_icon_new',
                        'label' => esc_html__('Icon', smw_slug),
                        'type' => Controls_Manager::ICONS,
                        'fa4compatibility' => 'smw_adv_tabs_tab_title_icon',
                        'default' => array(
                            'value' => 'fas fa-home',
                            'library' => 'fa-solid',
                        ),
                        'condition' => array(
                            'smw_adv_tabs_icon_type' => 'icon',
                        ),
                    ),
                    array(
                        'name' => 'smw_adv_tabs_tab_title_image',
                        'label' => esc_html__('Image', smw_slug),
                        'type' => Controls_Manager::MEDIA,
                        'default' => array(
                            'url' => Utils::get_placeholder_image_src(),
                        ),
                        'condition' => array(
                            'smw_adv_tabs_icon_type' => 'image',
                        ),
                    ),
                    array(
                        'name' => 'smw_adv_tabs_tab_title',
                        'label' => esc_html__('Tab Title', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Tab Title', smw_slug),
                        'dynamic' => array('active' => true),
                    ),
                    array(
                        'name' => 'smw_adv_tabs_text_type',
                        'label' => __('Content Type', smw_slug),
                        'type' => Controls_Manager::SELECT,
                        'options' => array(
                            'content' => __('Content', smw_slug),
                            'template' => __('Saved Templates', smw_slug),
                        ),
                        'default' => 'content',
                    ),
                    array(
                        'name' => 'smw_primary_templates',
                        'label' => __('Choose Template', smw_slug),
                        'type' => Controls_Manager::SELECT,
                        'options' => $this->smw_get_page_templates(),
                        'condition' => array(
                            'smw_adv_tabs_text_type' => 'template',
                        ),
                    ),
                    array(
                        'name' => 'smw_adv_tabs_tab_content',
                        'label' => esc_html__('Tab Content', smw_slug),
                        'type' => Controls_Manager::WYSIWYG,
                        'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', smw_slug),
                        'dynamic' => array('active' => true),
                        'condition' => array(
                            'smw_adv_tabs_text_type' => 'content',
                        ),
                    ),
                ),
                'title_field' => '{{smw_adv_tabs_tab_title}}',
            )
        );
        $this->end_controls_section();
	}
	
	protected function register_general_styles()
	{
	     $this->start_controls_section(
            'smw_section_adv_tabs_style_settings',
            array(
                'label' => esc_html__('General', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        
        $this->add_responsive_control(
            'smw_adv_tabs_padding',
            array(
                'label' => esc_html__('Padding', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_margin',
            array(
                'label' => esc_html__('Margin', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => 'smw_adv_tabs_border',
                'label' => esc_html__('Border', smw_slug),
                'selector' => '{{WRAPPER}} .smw-advance-tabs',
            )
        );

        $this->add_responsive_control(
            'smw_adv_tabs_border_radius',
            array(
                'label' => esc_html__('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name' => 'smw_adv_tabs_box_shadow',
                'selector' => '{{WRAPPER}} .smw-advance-tabs',
            )
        );
        $this->end_controls_section();
	}
	
	protected function register_tab_title_style()
	{
	    $this->start_controls_section(
            'smw_section_adv_tabs_tab_style_settings',
            array(
                'label' => esc_html__('Tab Title', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'smw_adv_tabs_tab_title_typography',
                'selector' => '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li',
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_title_width',
            array(
                'label' => __('Title Min Width', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'size_units' => array('px', 'em'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ),
                    'em' => array(
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs.smw-tabs-vertical .smw-tabs-nav > ul' => 'min-width: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'smw_adv_tab_layout' => 'smw-tabs-vertical',
                ),
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_tab_icon_size',
            array(
                'label' => __('Icon Size', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 16,
                    'unit' => 'px',
                ),
                'size_units' => array('px'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li img' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_tab_icon_gap',
            array(
                'label' => __('Icon Gap', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 10,
                    'unit' => 'px',
                ),
                'size_units' => array('px'),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .smw-tab-inline-icon li i, {{WRAPPER}} .smw-tab-inline-icon li img' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .smw-tab-top-icon li i, {{WRAPPER}} .smw-tab-top-icon li img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_tab_padding',
            array(
                'label' => esc_html__('Padding', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_tab_margin',
            array(
                'label' => esc_html__('Margin', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );


        $this->start_controls_tabs('smw_adv_tabs_header_tabs');
        // Normal State Tab
        $this->start_controls_tab('smw_adv_tabs_header_normal', array('label' => esc_html__('Normal', smw_slug)));
        $this->add_control(
            'smw_adv_tabs_tab_colour',
            array(
                'label' => esc_html__('Background Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '#f1f1f1',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li' => 'background-color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'smw_adv_tabs_tab_bgtype',
                'types' => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li'
            )
        );
        $this->add_control(
            'smw_adv_tabs_tab_text_colour',
            array(
                'label' => esc_html__('Text Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_control(
            'smw_adv_tabs_tab_icon_colour',
            array(
                'label' => esc_html__('Icon Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li i' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'smw_adv_tabs_icon_show' => 'yes',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => 'smw_adv_tabs_tab_border',
                'label' => esc_html__('Border', smw_slug),
                'selector' => '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li',
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_tab_border_radius',
            array(
                'label' => esc_html__('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->end_controls_tab();
        
        // Hover State Tab
        $this->start_controls_tab('smw_adv_tabs_header_hover', array('label' => esc_html__('Hover', smw_slug)));
        $this->add_control(
            'smw_adv_tabs_tab_colour_hover',
            array(
                'label' => esc_html__('Tab Background Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li:hover' => 'background-color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'smw_adv_tabs_tab_bgtype_hover',
                'types' => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li:hover'
            )
        );
        $this->add_control(
            'smw_adv_tabs_tab_text_colour_hover',
            array(
                'label' => esc_html__('Text Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li:hover' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_control(
            'smw_adv_tabs_tab_icon_colour_hover',
            array(
                'label' => esc_html__('Icon Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li:hover > i' => 'color: {{VALUE}};'
                ),
                'condition' => array(
                    'smw_adv_tabs_icon_show' => 'yes',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => 'smw_adv_tabs_tab_border_hover',
                'label' => esc_html__('Border', smw_slug),
                'selector' => '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li:hover',
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_tab_border_radius_hover',
            array(
                'label' => esc_html__('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->end_controls_tab();
        // Active State Tab
        $this->start_controls_tab('smw_adv_tabs_header_active', array('label' => esc_html__('Active', smw_slug)));
        $this->add_control(
            'smw_adv_tabs_tab_colour_active',
            array(
                'label' => esc_html__('Tab Background Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '#444',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li.active' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li.active-default' => 'background-color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'smw_adv_tabs_tab_bgtype_active',
                'types' => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li.active,{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li.active-default'
            )
        );
        $this->add_control(
            'smw_adv_tabs_tab_text_colour_active',
            array(
                'label' => esc_html__('Text Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li.active' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul .active-default .smw-tab-title' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_control(
            'smw_adv_tabs_tab_icon_colour_active',
            array(
                'label' => esc_html__('Icon Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li.active > i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li.active-default > i' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'smw_adv_tabs_icon_show' => 'yes',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => 'smw_adv_tabs_tab_border_active',
                'label' => esc_html__('Border', smw_slug),
                'selector' => '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li.active, {{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li.active-default',
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_tab_border_radius_active',
            array(
                'label' => esc_html__('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li.active-default' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
	}
	
	protected function register_content_style()
	{
	    $this->start_controls_section(
            'smw_section_adv_tabs_tab_content_style_settings',
            array(
                'label' => esc_html__('Content', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_control(
            'adv_tabs_content_bg_colour',
            array(
                'label' => esc_html__('Background Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-content > div' => 'background-color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'adv_tabs_content_bgtype',
                'types' => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .smw-advance-tabs .smw-tabs-content > div'
            )
        );
        $this->add_control(
            'adv_tabs_content_text_colour',
            array(
                'label' => esc_html__('Text Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-content > div' => 'color: {{VALUE}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'smw_adv_tabs_content_typography',
                'selector' => '{{WRAPPER}} .smw-advance-tabs .smw-tabs-content > div',
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_content_padding',
            array(
                'label' => esc_html__('Padding', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-content > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_content_margin',
            array(
                'label' => esc_html__('Margin', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-content > div' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => 'smw_adv_tabs_content_border',
                'label' => esc_html__('Border', smw_slug),
                'selector' => '{{WRAPPER}} .smw-advance-tabs .smw-tabs-content > div',
            )
        );
        $this->add_responsive_control(
            'smw_adv_tabs_content_border_radius',
            array(
                'label' => esc_html__('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .smw-tabs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name' => 'smw_adv_tabs_content_shadow',
                'selector' => '{{WRAPPER}} .smw-advance-tabs .smw-tabs-content > div',
                'separator' => 'before',
            )
        );
        $this->end_controls_section();
	}
	
	protected function register_caret_style()
	{
	    $this->start_controls_section(
            'smw_section_adv_tabs_tab_caret_style_settings',
            array(
                'label' => esc_html__('Caret', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_control(
            'smw_adv_tabs_tab_caret_show',
            array(
                'label' => esc_html__('Show Caret on Active Tab', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            )
        );
        $this->add_control(
            'smw_adv_tabs_tab_caret_size',
            array(
                'label' => esc_html__('Caret Size', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 10,
                ),
                'range' => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li:after' => 'border-width: {{SIZE}}px; bottom: -{{SIZE}}px',
                    '{{WRAPPER}} .smw-advance-tabs.smw-tabs-vertical .smw-tabs-nav > ul li:after' => 'right: -{{SIZE}}px; top: calc(50% - {{SIZE}}px) !important;',
                ),
                'condition' => array(
                    'smw_adv_tabs_tab_caret_show' => 'yes',
                ),
            )
        );
        $this->add_control(
            'smw_adv_tabs_tab_caret_colour',
            array(
                'label' => esc_html__('Caret Colour', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '#444',
                'selectors' => array(
                    '{{WRAPPER}} .smw-advance-tabs .smw-tabs-nav > ul li:after' => 'border-top-color: {{VALUE}};',
                    '{{WRAPPER}} .smw-advance-tabs.smw-tabs-vertical .smw-tabs-nav > ul li:after' => 'border-top-color: transparent; border-left-color: {{VALUE}};',
                ),
                'condition' => array(
                    'smw_adv_tabs_tab_caret_show' => 'yes',
                ),
            )
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
            'smw_ad_responsive_controls',
            array(
                'label' => esc_html__('Responsive Controls', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
			'responsive_vertical_layout',
			array(
				'label'     => __( 'Vertical Layout', smw_slug ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', smw_slug ),
				'label_off' => __( 'No', smw_slug ),
				'return_value' => 'yes',
				'default' => 'yes',
			)
        );
        
        $this->end_controls_section();
	}
	
	protected function render()
    {
        $settings = $this->get_settings_for_display();
        $smw_find_default_tab = array();
        $smw_adv_tab_id = 1;
        $smw_adv_tab_content_id = 1;
        $tab_icon_migrated = isset($settings['__fa4_migrated']['smw_adv_tabs_tab_title_icon_new']);
        $tab_icon_is_new = empty($settings['smw_adv_tabs_tab_title_icon']);

        $this->add_render_attribute(
            'smw_tab_wrapper',
            [
                'id' => "smw-advance-tabs-{$this->get_id()}",
                'class' => ['smw-advance-tabs', $settings['smw_adv_tab_layout']],
                'data-tabid' => $this->get_id(),
            ]
        );
        if ($settings['smw_adv_tabs_tab_caret_show'] != 'yes') {
            $this->add_render_attribute('smw_tab_wrapper', 'class', 'active-caret-on');
        }

        if($settings['responsive_vertical_layout'] != 'yes') {
            $this->add_render_attribute('smw_tab_wrapper', 'class', 'responsive-vertical-layout');
        }

        $this->add_render_attribute('smw_tab_icon_position', 'class', esc_attr($settings['smw_adv_tab_icon_position']));
        ?>
    	<div <?php echo $this->get_render_attribute_string('smw_tab_wrapper'); ?>>
      		<div class="smw-tabs-nav">
    		  <ul <?php echo $this->get_render_attribute_string('smw_tab_icon_position'); ?>>
    	    	<?php foreach ($settings['smw_adv_tabs_tab'] as $tab): ?>
    	      		<li class="<?php echo esc_attr($tab['smw_adv_tabs_tab_show_as_default']); ?>"><?php if ($settings['smw_adv_tabs_icon_show'] === 'yes'):
                        if ($tab['smw_adv_tabs_icon_type'] === 'icon'): ?>
                                <?php if ($tab_icon_is_new || $tab_icon_migrated) {
                                    if(isset($tab['smw_adv_tabs_tab_title_icon_new']['value']['url'])) {
                                        echo '<img src="' . $tab['smw_adv_tabs_tab_title_icon_new']['value']['url'] . '"/>';
                                    }else {
                                        echo '<i class="' . $tab['smw_adv_tabs_tab_title_icon_new']['value'] . '"></i>';
                                    }
                                } else {
                                    echo '<i class="' . $tab['smw_adv_tabs_tab_title_icon'] . '"></i>';
                                } ?>
                                <?php elseif ($tab['smw_adv_tabs_icon_type'] === 'image'): ?>
                            <img src="<?php echo esc_attr($tab['smw_adv_tabs_tab_title_image']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($tab['smw_adv_tabs_tab_title_image']['id'], '_wp_attachment_image_alt', true)); ?>">
                        <?php endif;?>
    	      		<?php endif;?> <span class="smw-tab-title"><?php echo $tab['smw_adv_tabs_tab_title']; ?></span></li>
    	      	<?php endforeach;?>
        		</ul>
      		</div>
      		<div class="smw-tabs-content">
      			<?php foreach ($settings['smw_adv_tabs_tab'] as $tab): $smw_find_default_tab[] = $tab['smw_adv_tabs_tab_show_as_default'];?>
    		    			<div class="clearfix <?php echo esc_attr($tab['smw_adv_tabs_tab_show_as_default']); ?>">
    		      				<?php if ('content' == $tab['smw_adv_tabs_text_type']): ?>
    								<?php echo do_shortcode($tab['smw_adv_tabs_tab_content']); ?>
    							<?php elseif ('template' == $tab['smw_adv_tabs_text_type']): ?>
    						<?php if (!empty($tab['smw_primary_templates'])) {
                                echo Plugin::$instance->frontend->get_builder_content($tab['smw_primary_templates'], true);
                            } ?>
    					<?php endif;?>
        			</div>
    			<?php endforeach;?>
      		</div>
    	</div>
    	<?php
    }

    protected function content_template(){}
    
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_advanced_tabs() );