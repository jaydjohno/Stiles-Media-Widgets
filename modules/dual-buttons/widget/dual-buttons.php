<?php

/**
 * SMW Dual Buttons.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Repeater;
use Elementor\Widget_Button;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use Elementor\Core\Schemes;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_dual_buttons extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'dual-buttons-css', plugin_dir_url( __FILE__ ) .  '../css/dual-buttons.css');
    }
    
    public function get_name()
    {
        return 'stiles-dual-buttons';
    }
    
    public function get_title()
    {
        return 'Dual Buttons';
    }
    
    public function get_icon()
    {
        return 'eicon-dual-button';
    }
    
    public function get_categories()
    {
        return array('stiles-media-category');
    }
    
    public function get_style_depends() 
    {
        return [ 'dual-buttons-css' ];
    }
    
    public static function get_new_icon_name( $control_name ) 
    {
		if ( class_exists( 'Elementor\Icons_Manager' ) ) 
		{
			return 'new_' . $control_name . '[value]';
		} else {
			return $control_name;
		}
	}
	
	public static function get_button_sizes() 
    {
		return Widget_Button::get_button_sizes();
	}
	
	protected function register_controls() 
    { 
	    $this->button_controls();
    
    	$this->button_a();
    
    	$this->button_b();
    
    	$this->button_style();
    	
    	$this->button_a_style();
    
        $this->button_b_style();
        
        $this->button_a_icon();
    		
        $this->button_b_icon();
    		
        $this->middle_text();
	}
	
	protected function button_controls()
	{
	    $this->start_controls_section(
			'section_content_button',
			[
				'label' => __( 'Button', smw_slug ),
			]
		);

    		$this->add_control(
    			'dual_button_size',
    			[
    				'label'   => __( 'Button Size', smw_slug ),
    				'type'    => Controls_Manager::SELECT,
    				'default' => 'md',
    				'options' => [
    					'xs' => __( 'Extra Small', smw_slug ),
    					'sm' => __( 'Small', smw_slug ),
    					'md' => __( 'Medium', smw_slug ),
    					'lg' => __( 'Large', smw_slug ),
    					'xl' => __( 'Extra Large', smw_slug ),
    				],
    			]
    		);
    
    		$this->add_responsive_control(
    			'align',
    			[
    				'label' => __( 'Alignment', smw_slug ),
    				'type' => Controls_Manager::CHOOSE,
    				'options' => [
    					'start' => [
    						'title' => __( 'Left', smw_slug ),
    						'icon' => 'fas fa-align-left',
    					],
    					'center' => [
    						'title' => __( 'Center', smw_slug ),
    						'icon' => 'fas fa-align-center',
    					],
    					'end' => [
    						'title' => __( 'Right', smw_slug ),
    						'icon' => 'fas fa-align-right',
    					],
    				],
    				'prefix_class' => 'sm-element-align%s-',
    			]
    		);
    
    		$this->add_responsive_control(
    			'button_width',
    			[
    				'label' => __( 'Button Width', smw_slug ),
    				'type'  => Controls_Manager::SLIDER,
    				'range' => [
    					'%' => [
    						'max' => 100,
    						'min' => 20,
    					],
    					'px' => [
    						'max' => 1200,
    						'min' => 300,
    					],
    				],
    				'size_units' => ['%', 'px'],
    				'default' => [
    					'size' => 40,
    					'unit' => '%',
    				],
    				'tablet_default' => [
    					'size' => 80,
    					'unit' => '%',
    				],
    				'mobile_default' => [
    					'size' => 100,
    					'unit' => '%',
    				],
    				'selectors' => [
    					'{{WRAPPER}} .sm-dual-button'  => 'width: {{SIZE}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_control(
    			'show_middle_text',
    			[
    				'label' => __( 'Middle Text', smw_slug ),
    				'type'  => Controls_Manager::SWITCHER,
    			]
    		);
    
    		$this->add_control(
    			'middle_text',
    			[
    				'label'       => __( 'Text', smw_slug ),
    				'type'        => Controls_Manager::TEXT,
    				'dynamic'     => [ 'active' => true ],
    				'default'     => __( 'or', smw_slug ),
    				'placeholder' => __( 'or', smw_slug ),
    				'condition'   => [
    					'show_middle_text' => 'yes',
    				],
    			]
    		);
    
    		$this->add_control(
    			'dual_button_gap',
    			[
    				'label'   => __( 'Button Gap', smw_slug ),
    				'type'    => Controls_Manager::SLIDER,
    				'default' => [
    					'size' => 5,
    				],
    				'range' => [
    					'px' => [
    						'min' => 0,
    						'max' => 50,
    					],
    				],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a' => 'margin-right: {{SIZE}}px;',
    				],
    				'condition' => [
    					'show_middle_text!' => 'yes',
    				],
    			]
    		);
    
    	$this->end_controls_section();
	}
	
	protected function button_a()
	{
	    $this->start_controls_section(
    			'section_content_button_a',
    			[
    				'label' => __( 'Button A', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_a_text',
    			[
    				'label'       => __( 'Text', smw_slug ),
    				'type'        => Controls_Manager::TEXT,
    				'dynamic'     => [ 'active' => true ],
    				'default'     => __( 'Click Me', smw_slug ),
    				'placeholder' => __( 'Click Me', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_a_link',
    			[
    				'label'       => __( 'Link', smw_slug ),
    				'type'        => Controls_Manager::URL,
    				'dynamic'     => [ 'active' => true ],
    				'placeholder' => __( 'https://your-link.com', smw_slug ),
    				'default'     => [
    					'url' => '#',
    				],
    			]
    		);
    
    		$this->add_control(
    			'add_custom_a_attributes',
    			[
    				'label'     => __( 'Add Custom Attributes', smw_slug ),
    				'type'      => Controls_Manager::SWITCHER,
    			]
    		);
    
    		$this->add_control(
    			'custom_a_attributes',
    			[
    				'label' => __( 'Custom Attributes', smw_slug ),
    				'type' => Controls_Manager::TEXTAREA,
    				'dynamic' => [
    					'active' => true,
    				],
    				'placeholder' => __( 'key|value', smw_slug ),
    				'description' => sprintf( __( 'Set custom attributes for the price table button tag. Each attribute in a separate line. Separate attribute key from the value using %s character.', smw_slug ), '<code>|</code>' ),
    				'classes' => 'elementor-control-direction-ltr',
    				'condition' => ['add_custom_a_attributes' => 'yes']
    			]
    		);
    
    		$this->add_control(
    			'button_a_onclick',
    			[
    				'label' => esc_html__( 'OnClick', smw_slug ),
    				'type'  => Controls_Manager::SWITCHER,
    			]
    		);
    
    		$this->add_control(
    			'button_a_onclick_event',
    			[
    				'label'       => __( 'OnClick Event', smw_slug ),
    				'type'        => Controls_Manager::TEXT,
    				'placeholder' => 'myFunction()',
    				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
    				'condition' => [
    					'button_a_onclick' => 'yes'
    				]
    			]
    		);
    
    		$this->add_responsive_control(
    			'button_a_align',
    			[
    				'label'   => esc_html__( 'Alignment', smw_slug ),
    				'type'    => Controls_Manager::CHOOSE,
    				'options' => [
    					'left' => [
    						'title' => esc_html__( 'Left', smw_slug ),
    						'icon'  => 'fas fa-align-left',
    					],
    					'center' => [
    						'title' => esc_html__( 'Center', smw_slug ),
    						'icon'  => 'fas fa-align-center',
    					],
    					'right' => [
    						'title' => esc_html__( 'Right', smw_slug ),
    						'icon'  => 'fas fa-align-right',
    					],
    				],
    			]
    		);
    
    		$this->add_control(
    			'button_a_select_icon',
    			[
    				'label'       => __( 'Icon', smw_slug ),
    				'type'        => Controls_Manager::ICONS,
    				'fa4compatibility' => 'button_a_icon',
    			]
    		);
    
    		$this->add_control(
    			'button_a_icon_align',
    			[
    				'label'   => __( 'Icon Position', smw_slug ),
    				'type'    => Controls_Manager::SELECT,
    				'default' => 'right',
    				'options' => [
    					'left'   => __( 'Left', smw_slug ),
    					'right'  => __( 'Right', smw_slug ),
    					'top'    => __( 'Top', smw_slug ),
    					'bottom' => __( 'Bottom', smw_slug ),
    				],
    				'condition' => [
    					'button_a_select_icon[value]!' => '',
    				],
    			]
    		);
    
    		$this->add_control(
    			'button_a_icon_indent',
    			[
    				'label' => __( 'Icon Spacing', smw_slug ),
    				'type'  => Controls_Manager::SLIDER,
    				'range' => [
    					'px' => [
    						'max' => 100,
    					],
    				],
    					'default' => [
    						'size' => 8,
    					],
    				'condition' => [
    					'button_a_select_icon[value]!' => '',
    				],
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a .sm-flex-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a .sm-flex-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a .sm-flex-align-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a .sm-flex-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
    				],
    			]
    		);
    
    	$this->end_controls_section();
	}
	
	protected function button_b()
	{
	    $this->start_controls_section(
    			'section_content_button_b',
    			[
    				'label' => __( 'Button B', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_b_text',
    			[
    				'label'       => __( 'Text', smw_slug ),
    				'type'        => Controls_Manager::TEXT,
    				'dynamic'     => [ 'active' => true ],
    				'default'     => __( 'Read More', smw_slug ),
    				'placeholder' => __( 'Read More', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_b_link',
    			[
    				'label'       => __( 'Link', smw_slug ),
    				'type'        => Controls_Manager::URL,
    				'dynamic'     => [ 'active' => true ],
    				'placeholder' => __( 'https://your-link.com', smw_slug ),
    				'default'     => [
    					'url' => '#',
    				],
    			]
    		);
    
    		$this->add_control(
    			'add_custom_b_attributes',
    			[
    				'label'     => __( 'Add Custom Attributes', smw_slug ),
    				'type'      => Controls_Manager::SWITCHER,
    			]
    		);
    
    		$this->add_control(
    			'custom_b_attributes',
    			[
    				'label' => __( 'Custom Attributes', smw_slug ),
    				'type' => Controls_Manager::TEXTAREA,
    				'dynamic' => [
    					'active' => true,
    				],
    				'placeholder' => __( 'key|value', smw_slug ),
    				'description' => sprintf( __( 'Set custom attributes for the price table button tag. Each attribute in a separate line. Separate attribute key from the value using %s character.', smw_slug ), '<code>|</code>' ),
    				'classes' => 'elementor-control-direction-ltr',
    				'condition' => ['add_custom_b_attributes' => 'yes']
    			]
    		);
    
    		$this->add_control(
    			'button_b_onclick',
    			[
    				'label' => esc_html__( 'OnClick', smw_slug ),
    				'type'  => Controls_Manager::SWITCHER,
    			]
    		);
    
    		$this->add_control(
    			'button_b_onclick_event',
    			[
    				'label'       => __( 'OnClick Event', smw_slug ),
    				'type'        => Controls_Manager::TEXT,
    				'placeholder' => 'myFunction()',
    				'description' => sprintf( __('For details please look <a href="%s" target="_blank">here</a>'), 'https://www.w3schools.com/jsref/event_onclick.asp' ),
    				'condition' => [
    					'button_b_onclick' => 'yes'
    				]
    			]
    		);
    
    		$this->add_responsive_control(
    			'button_b_align',
    			[
    				'label'   => esc_html__( 'Alignment', smw_slug ),
    				'type'    => Controls_Manager::CHOOSE,
    				'options' => [
    					'left' => [
    						'title' => esc_html__( 'Left', smw_slug ),
    						'icon'  => 'fas fa-align-left',
    					],
    					'center' => [
    						'title' => esc_html__( 'Center', smw_slug ),
    						'icon'  => 'fas fa-align-center',
    					],
    					'right' => [
    						'title' => esc_html__( 'Right', smw_slug ),
    						'icon'  => 'fas fa-align-right',
    					],
    				],
    			]
    		);
    
    		$this->add_control(
    			'button_b_select_icon',
    			[
    				'label'       => __( 'Icon', smw_slug ),
    				'type'        => Controls_Manager::ICONS,
    				'fa4compatibility' => 'button_b_icon',
    			]
    		);
    
    		$this->add_control(
    			'button_b_icon_align',
    			[
    				'label'   => __( 'Icon Position', smw_slug ),
    				'type'    => Controls_Manager::SELECT,
    				'default' => 'right',
    				'options' => [
    					'left'   => __( 'Left', smw_slug ),
    					'right'  => __( 'Right', smw_slug ),
    					'top'    => __( 'Top', smw_slug ),
    					'bottom' => __( 'Bottom', smw_slug ),
    				],
    				'condition' => [
    					'button_b_select_icon[value]!' => '',
    				],
    			]
    		);
    
    		$this->add_control(
    			'button_b_icon_indent',
    			[
    				'label' => __( 'Icon Spacing', smw_slug ),
    				'type'  => Controls_Manager::SLIDER,
    				'range' => [
    					'px' => [
    						'max' => 100,
    					],
    				],
    					'default' => [
    						'size' => 8,
    					],
    				'condition' => [
    					'button_b_select_icon[value]!' => '',
    				],
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b .sm-flex-align-right'  => 'margin-left: {{SIZE}}{{UNIT}};',
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b .sm-flex-align-left'   => 'margin-right: {{SIZE}}{{UNIT}};',
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b .sm-flex-align-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b .sm-flex-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
    				],
    			]
    		);
    
    	$this->end_controls_section();
	}
	
	protected function button_style()
	{
	    $this->start_controls_section(
    			'section_content_style',
    			[
    				'label' => __( 'Button', smw_slug ),
    				'tab'   => Controls_Manager::TAB_STYLE,
    			]
    		);
    
    		$this->start_controls_tabs( 'tabs_dual_button_style' );
    
    		$this->start_controls_tab(
    			'tab_dual_button_normal',
    			[
    				'label' => __( 'Normal', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_border_style',
    			[
    				'label'   => __( 'Border Style', smw_slug ),
    				'type'    => Controls_Manager::SELECT,
    				'default' => 'none',
    				'options' => [
    					'none'   => __( 'None', smw_slug ),
    					'solid'  => __( 'Solid', smw_slug ),
    					'dotted' => __( 'Dotted', smw_slug ),
    					'dashed' => __( 'Dashed', smw_slug ),
    					'groove' => __( 'Groove', smw_slug ),
    				],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-dual-button a' => 'border-style: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->add_responsive_control(
    			'button_border_width',
    			[
    				'label'      => __( 'Border Width', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', '%' ],
    				'default'    => [
    					'top'    => 3,
    					'right'  => 3,
    					'bottom' => 3,
    					'left'   => 3,
    				],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-dual-button a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    				'condition' => [
    					'button_border_style!' => 'none'
    				]
    			]
    		);
    
    		$this->add_responsive_control(
    			'dual_button_radius',
    			[
    				'label'      => __( 'Radius', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-dual-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			[
    				'name'     => 'dual_button_shadow',
    				'selector' => '{{WRAPPER}} .sm-dual-button a',
    			]
    		);
    
    		$this->add_responsive_control(
    			'dual_button_padding',
    			[
    				'label'      => __( 'Padding', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', 'em', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-dual-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Typography::get_type(),
    			[
    				'name'     => 'dual_button_typography',
    				'scheme'   => Typography::TYPOGRAPHY_4,
    				'selector' => '{{WRAPPER}} .sm-dual-button a',
    			]
    		);
    
    		$this->end_controls_tab();
    
    		$this->start_controls_tab(
    			'tab_dual_button_hover',
    			[
    				'label' => __( 'Hover', smw_slug ),
    			]
    		);
    
    		$this->add_responsive_control(
    			'dual_button_hover_radius',
    			[
    				'label'      => __( 'Radius', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-dual-button a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			[
    				'name'     => 'dual_button_hover_shadow',
    				'selector' => '{{WRAPPER}} .sm-dual-button a:hover',
    			]
    		);
    
    		$this->end_controls_tab();
    
    		$this->end_controls_tabs();
    
    	$this->end_controls_section();
	}
	
	protected function button_a_style()
	{
	    $this->start_controls_section(
    			'section_content_style_a',
    			[
    				'label' => __( 'Button A', smw_slug ),
    				'tab'   => Controls_Manager::TAB_STYLE,
    			]
    		);
    
    		$this->add_control(
    			'button_a_effect',
    			[
    				'label'   => __( 'Effect', smw_slug ),
    				'type'    => Controls_Manager::SELECT,
    				'default' => 'a',
    				'options' => [
    					'a' => __( 'Effect A', smw_slug ),
    					'b' => __( 'Effect B', smw_slug ),
    					'c' => __( 'Effect C', smw_slug ),
    					'd' => __( 'Effect D', smw_slug ),
    					'e' => __( 'Effect E', smw_slug ),
    					'f' => __( 'Effect F', smw_slug ),
    					'g' => __( 'Effect G', smw_slug ),
    					'h' => __( 'Effect H', smw_slug ),
    					'i' => __( 'Effect I', smw_slug ),
    				],
    			]
    		);
    
    		$this->start_controls_tabs( 'tabs_button_a_style' );
    
    		$this->start_controls_tab(
    			'tab_button_a_normal',
    			[
    				'label' => __( 'Normal', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_a_color',
    			[
    				'label'     => __( 'Text Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a' => 'color: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Background::get_type(),
    			[
    				'name'      => 'button_a_background',
    				'types'     => [ 'classic', 'gradient' ],
    				'selector'  => '{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a, 
    								{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a.sm-button-effect-i .sm-button-content-wrapper:after,
    								{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a.sm-button-effect-i .sm-button-content-wrapper:before',
    				'separator' => 'after',
    			]
    		);
    
    		$this->add_responsive_control(
    			'button_a_border_radius',
    			[
    				'label'      => __( 'Radius', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_control(
    			'button_a_border_color',
    			[
    				'label'     => __( 'Border Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'default'   => '#666',
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a' => 'border-color: {{VALUE}};',
    				],
    				'condition' => [
    					'button_border_style!' => 'none'
    				]
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			[
    				'name'     => 'button_a_shadow',
    				'selector' => '{{WRAPPER}} .sm-dual-button a.sm-dual-button-a',
    			]
    		);
    
    		$this->end_controls_tab();
    
    		$this->start_controls_tab(
    			'tab_button_a_hover',
    			[
    				'label' => __( 'Hover', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_a_hover_color',
    			[
    				'label'     => __( 'Text Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a:hover' => 'color: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Background::get_type(),
    			[
    				'name'      => 'button_a_hover_background',
    				'types'     => [ 'classic', 'gradient' ],
    				'selector'  => '{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a:after, 
    								{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a:hover,
    								{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a.sm-button-effect-i,
    								{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a.sm-button-effect-h:after',
    				'separator' => 'after',
    			]
    		);
    
    		$this->add_responsive_control(
    			'button_a_hover_border_radius',
    			[
    				'label'      => __( 'Radius', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_control(
    			'button_a_hover_border_color',
    			[
    				'label'     => __( 'Border Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a:hover' => 'border-color: {{VALUE}};',
    				],
    				'condition' => [
    					'button_border_style!' => 'none'
    				]
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			[
    				'name'     => 'button_a_hover_shadow',
    				'selector' => '{{WRAPPER}} .sm-dual-button a.sm-dual-button-a:hover',
    			]
    		);
    
    		$this->end_controls_tab();
    
    		$this->end_controls_tabs();
    
    	$this->end_controls_section();
	}
	
	protected function button_b_style()
	{
	    $this->start_controls_section(
    			'section_content_style_b',
    			[
    				'label' => __( 'Button B', smw_slug ),
    				'tab'   => Controls_Manager::TAB_STYLE,
    			]
    		);
    
    		$this->add_control(
    			'button_b_effect',
    			[
    				'label'   => __( 'Effect', smw_slug ),
    				'type'    => Controls_Manager::SELECT,
    				'default' => 'a',
    				'options' => [
    					'a' => __( 'Effect A', smw_slug ),
    					'b' => __( 'Effect B', smw_slug ),
    					'c' => __( 'Effect C', smw_slug ),
    					'd' => __( 'Effect D', smw_slug ),
    					'e' => __( 'Effect E', smw_slug ),
    					'f' => __( 'Effect F', smw_slug ),
    					'g' => __( 'Effect G', smw_slug ),
    					'h' => __( 'Effect H', smw_slug ),
    					'i' => __( 'Effect I', smw_slug ),
    				],
    			]
    		);
    
    		$this->start_controls_tabs( 'tabs_button_b_style' );
    
    		$this->start_controls_tab(
    			'tab_button_b_normal',
    			[
    				'label' => __( 'Normal', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_b_color',
    			[
    				'label'     => __( 'Text Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b' => 'color: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Background::get_type(),
    			[
    				'name'     => 'button_b_background',
    				'types'    => [ 'classic', 'gradient' ],
    				'selector' => '{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b, 
    							   {{WRAPPER}} .sm-button-wrapper .sm-dual-button-b.sm-button-effect-i .sm-button-content-wrapper:after, 
    							   {{WRAPPER}} .sm-button-wrapper .sm-dual-button-b.sm-button-effect-i .sm-button-content-wrapper:before',
    				'separator' => 'after',
    			]
    		);
    
    		$this->add_responsive_control(
    			'button_b_border_radius',
    			[
    				'label'      => __( 'Radius', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_control(
    			'button_b_border_color',
    			[
    				'label'     => __( 'Border Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'default'   => '#666',
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b' => 'border-color: {{VALUE}};',
    				],
    				'condition' => [
    					'button_border_style!' => 'none'
    				]
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			[
    				'name'     => 'button_b_shadow',
    				'selector' => '{{WRAPPER}} .sm-dual-button a.sm-dual-button-b',
    			]
    		);
    
    		$this->end_controls_tab();
    
    		$this->start_controls_tab(
    			'tab_button_b_hover',
    			[
    				'label' => __( 'Hover', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_b_hover_color',
    			[
    				'label'     => __( 'Text Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b:hover' => 'color: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Background::get_type(),
    			[
    				'name'      => 'button_b_hover_background',
    				'types'     => [ 'classic', 'gradient' ],
    				'selector'  => '{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b:after,
    								{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b:hover, 
    								{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b.sm-button-effect-i,
    								{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b.sm-button-effect-h:after
    								',
    				'separator' => 'after',
    			]
    		);
    
    		$this->add_responsive_control(
    			'button_b__hover_border_radius',
    			[
    				'label'      => __( 'Radius', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_control(
    			'button_b_hover_border_color',
    			[
    				'label'     => __( 'Border Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b:hover' => 'border-color: {{VALUE}};',
    				],
    				'condition' => [
    					'button_border_style!' => 'none'
    				]
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			[
    				'name'     => 'button_b_hover_shadow',
    				'selector' => '{{WRAPPER}} .sm-dual-button a.sm-dual-button-b:hover',
    			]
    		);
    
    		$this->end_controls_tab();
    
    		$this->end_controls_tabs();
    
    	$this->end_controls_section();
	}
	
	protected function button_a_icon()
	{
	    $this->start_controls_section(
    			'section_style_button_a_icon',
    			[
    				'label'     => __( 'Button A Icon', smw_slug ),
    				'tab'       => Controls_Manager::TAB_STYLE,
    				'condition' => [
    					'button_a_select_icon[value]!' => '',
    				],
    			]
    		);
    
    		$this->start_controls_tabs( 'tabs_button_a_icon_style' );
    
    		$this->start_controls_tab(
    			'tab_button_a_icon_normal',
    			[
    				'label' => __( 'Normal', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_a_icon_color',
    			[
    				'label'     => __( 'Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a .sm-dual-button-a-icon i' => 'color: {{VALUE}};',
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a .sm-dual-button-a-icon svg' => 'fill: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Background::get_type(),
    			[
    				'name'      => 'button_a_icon_background',
    				'types'     => [ 'classic', 'gradient' ],
    				'selector'  => '{{WRAPPER}} .sm-button .sm-dual-button-a-icon .sm-button-a-icon-inner',
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Border::get_type(),
    			[
    				'name'        => 'button_a_icon_border',
    				'placeholder' => '1px',
    				'default'     => '1px',
    				'selector'    => '{{WRAPPER}} .sm-button .sm-dual-button-a-icon .sm-button-a-icon-inner',
    			]
    		);
    
    		$this->add_control(
    			'button_a_icon_padding',
    			[
    				'label'      => __( 'Padding', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', 'em', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-button .sm-dual-button-a-icon .sm-button-a-icon-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_control(
    			'button_a_icon_radius',
    			[
    				'label'      => __( 'Radius', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-button .sm-dual-button-a-icon .sm-button-a-icon-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			[
    				'name'     => 'button_a_icon_shadow',
    				'selector' => '{{WRAPPER}} .sm-button .sm-dual-button-a-icon .sm-button-a-icon-inner',
    			]
    		);
    
    		$this->add_responsive_control(
    			'button_a_icon_size',
    			[
    				'label' => __( 'Icon Size', smw_slug ),
    				'type'  => Controls_Manager::SLIDER,
    				'range' => [
    					'px' => [
    						'min'  => 10,
    						'max'  => 100,
    					],
    				],				
    				'selectors' => [
    					'{{WRAPPER}} .sm-button .sm-dual-button-a-icon .sm-button-a-icon-inner' => 'font-size: {{SIZE}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->end_controls_tab();
    
    		$this->start_controls_tab(
    			'tab_button_a_icon_hover',
    			[
    				'label' => __( 'Hover', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_a_icon_hover_color',
    			[
    				'label'     => __( 'Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a:hover .sm-dual-button-a-icon i' => 'color: {{VALUE}};',
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-a:hover .sm-dual-button-a-icon svg' => 'fill: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Background::get_type(),
    			[
    				'name'      => 'button_a_icon_hover_background',
    				'types'     => [ 'classic', 'gradient' ],
    				'selector'  => '{{WRAPPER}} .sm-button:hover .sm-dual-button-a-icon .sm-button-a-icon-inner',
    				'separator' => 'after',
    			]
    		);
    
    		$this->add_control(
    			'button_a_icon_hover_border_color',
    			[
    				'label'     => __( 'Border Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'condition' => [
    					'button_a_icon_border_border!' => '',
    				],
    				'selectors' => [
    					'{{WRAPPER}} .sm-button:hover .sm-dual-button-a-icon .sm-button-a-icon-inner' => 'border-color: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->end_controls_tab();
    
    		$this->end_controls_tabs();
    
    	$this->end_controls_section();
	}
	
	protected function button_b_icon()
	{
	    $this->start_controls_section(
    			'section_style_button_b_icon',
    			[
    				'label'     => __( 'Button B Icon', smw_slug ),
    				'tab'       => Controls_Manager::TAB_STYLE,
    				'condition' => [
    					'button_b_select_icon[value]!' => '',
    				],
    			]
    		);
    
    		$this->start_controls_tabs( 'tabs_button_b_icon_style' );
    
    		$this->start_controls_tab(
    			'tab_button_b_icon_normal',
    			[
    				'label' => __( 'Normal', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_b_icon_color',
    			[
    				'label'     => __( 'Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b .sm-dual-button-b-icon i' => 'color: {{VALUE}};',
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b .sm-dual-button-b-icon svg' => 'fill: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Background::get_type(),
    			[
    				'name'      => 'button_b_icon_background',
    				'types'     => [ 'classic', 'gradient' ],
    				'selector'  => '{{WRAPPER}} .sm-button .sm-dual-button-b-icon .sm-button-b-icon-inner',
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Border::get_type(),
    			[
    				'name'        => 'button_b_icon_border',
    				'placeholder' => '1px',
    				'default'     => '1px',
    				'selector'    => '{{WRAPPER}} .sm-button .sm-dual-button-b-icon .sm-button-b-icon-inner',
    			]
    		);
    
    		$this->add_control(
    			'button_b_icon_padding',
    			[
    				'label'      => __( 'Padding', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', 'em', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-button .sm-dual-button-b-icon .sm-button-b-icon-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_control(
    			'button_b_icon_radius',
    			[
    				'label'      => __( 'Radius', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-button .sm-dual-button-b-icon .sm-button-b-icon-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			[
    				'name'     => 'button_b_icon_shadow',
    				'selector' => '{{WRAPPER}} .sm-button .sm-dual-button-b-icon .sm-button-b-icon-inner',
    			]
    		);
    
    		$this->add_responsive_control(
    			'button_b_icon_size',
    			[
    				'label' => __( 'Icon Size', smw_slug ),
    				'type'  => Controls_Manager::SLIDER,
    				'range' => [
    					'px' => [
    						'min'  => 10,
    						'max'  => 100,
    					],
    				],				
    				'selectors' => [
    					'{{WRAPPER}} .sm-button .sm-dual-button-b-icon .sm-button-b-icon-inner' => 'font-size: {{SIZE}}{{UNIT}};',
    				],
    			]
    		);
    
    	$this->end_controls_tab();
    	
    	$this->start_controls_tab(
    			'tab_button_b_icon_hover',
    			[
    				'label' => __( 'Hover', smw_slug ),
    			]
    		);
    
    		$this->add_control(
    			'button_b_icon_hover_color',
    			[
    				'label'     => __( 'Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => [
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b:hover .sm-dual-button-b-icon i' => 'color: {{VALUE}};',
    					'{{WRAPPER}} .sm-button-wrapper .sm-dual-button-b:hover .sm-dual-button-b-icon svg' => 'fill: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Background::get_type(),
    			[
    				'name'      => 'button_b_icon_hover_background',
    				'types'     => [ 'classic', 'gradient' ],
    				'selector'  => '{{WRAPPER}} .sm-button:hover .sm-dual-button-b-icon .sm-button-b-icon-inner',
    				'separator' => 'after',
    			]
    		);
    
    		$this->add_control(
    			'button_b_icon_hover_border_color',
    			[
    				'label'     => __( 'Border Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'condition' => [
    					'button_b_icon_border_border!' => '',
    				],
    				'selectors' => [
    					'{{WRAPPER}} .sm-button:hover .sm-dual-button-b-icon .sm-button-b-icon-inner' => 'border-color: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->end_controls_tab();
    
    		$this->end_controls_tabs();
    
    	$this->end_controls_section();
	}
	
	protected function middle_text()
	{
	    $this->start_controls_section(
    			'section_style_middle_text',
    			[
    				'label'      => __( 'Middle Text', smw_slug ),
    				'tab'        => Controls_Manager::TAB_STYLE,
    				'conditions' => [
    					'terms' => [
    						[
    							'name'     => 'show_middle_text',
    							'value'    => 'yes',
    						],
    						[
    							'name'     => 'middle_text',
    							'operator' => '!=',
    							'value'    => '',
    						],
    					],
    				],
    			]
    
    		);
    
    		$this->add_control(
    			'middle_text_color',
    			[
    				'label'     => __( 'Text Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => [
    					'{{WRAPPER}} .sm-dual-button span' => 'color: {{VALUE}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Background::get_type(),
    			[
    				'name'     => 'middle_text_background',
    				'types'    => [ 'classic', 'gradient' ],
    				'selector' => '{{WRAPPER}} .sm-dual-button span',
    				'separator' => 'after',
    			]
    		);
    
    		$this->add_responsive_control(
    			'middle_text_radius',
    			[
    				'label'      => __( 'Radius', smw_slug ),
    				'type'       => Controls_Manager::DIMENSIONS,
    				'size_units' => [ 'px', '%' ],
    				'selectors'  => [
    					'{{WRAPPER}} .sm-dual-button span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				],
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			[
    				'name'     => 'middle_text_shadow',
    				'selector' => '{{WRAPPER}} .sm-dual-button span',
    			]
    		);
    
    		$this->add_group_control(
    			Group_Control_Typography::get_type(),
    			[
    				'name'     => 'middle_text_typography',
    				'scheme'   => Typography::TYPOGRAPHY_4,
    				'selector' => '{{WRAPPER}} .sm-dual-button span',
    			]
    		);
    
    	$this->end_controls_section();
	}
	
    public function render_text_a($settings) 
    {
		$this->add_render_attribute( 'content-wrapper-a', 'class', 'sm-button-content-wrapper' );

		if ( 'left' == $settings['button_a_icon_align'] or 'right' == $settings['button_a_icon_align'] ) 
		{
			$this->add_render_attribute( 'content-wrapper-a', 'class', 'sm-flex sm-flex-middle' );
		}
		
		$this->add_render_attribute( 'content-wrapper-a', 'class', 'sm-flex-' . $settings['button_a_align'] );

		$this->add_render_attribute( 'content-wrapper-a', 'class', ( 'top' == $settings['button_a_icon_align'] ) ? 'sm-flex sm-flex-column' : '' );
		$this->add_render_attribute( 'content-wrapper-a', 'class', ( 'bottom' == $settings['button_a_icon_align'] ) ? 'sm-flex sm-flex-column-reverse' : '' );
		$this->add_render_attribute( 'content-wrapper-a', 'data-text', esc_attr($settings['button_a_text']));

		$this->add_render_attribute( 'button-a-text', 'class', 'sm-button-text' );

		if ( ! isset( $settings['button_a_icon'] ) && ! Icons_Manager::is_migration_allowed() ) 
		{
			// add old default
			$settings['button_a_icon'] = 'fas fa-arrow-left';
		}

		$migrated  = isset( $settings['__fa4_migrated']['button_a_select_icon'] );
		$is_new    = empty( $settings['button_a_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php echo $this->get_render_attribute_string( 'content-wrapper-a' ); ?>>
			<?php if ( ! empty( $settings['button_a_select_icon']['value'] ) ) : ?>
				<div class="sm-button-icon sm-dual-button-a-icon sm-flex-align-<?php echo esc_attr($settings['button_a_icon_align']); ?>">
					<div class="sm-button-a-icon-inner">
					
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['button_a_select_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['button_a_icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

					</div>
				</div>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'button-a-text' ); ?>><?php echo wp_kses( $settings['button_a_text'], stiles_media_allow_tags('title') ); ?></div>
		</div>
		<?php
	}

	public function render_text_b($settings) 
	{
		$this->add_render_attribute( 'content-wrapper-b', 'class', 'sm-button-content-wrapper' );

		if ( 'left' == $settings['button_b_icon_align'] or 'right' == $settings['button_b_icon_align'] ) 
		{
			$this->add_render_attribute( 'content-wrapper-b', 'class', 'sm-flex sm-flex-middle' );
		}
		
		$this->add_render_attribute( 'content-wrapper-b', 'class', 'sm-flex-' . $settings['button_b_align'] );

		$this->add_render_attribute( 'content-wrapper-b', 'class', ( 'top' == $settings['button_b_icon_align'] ) ? 'sm-flex sm-flex-column' : '' );
		$this->add_render_attribute( 'content-wrapper-b', 'class', ( 'bottom' == $settings['button_b_icon_align'] ) ? 'sm-flex sm-flex-column-reverse' : '' );
		$this->add_render_attribute( 'content-wrapper-b', 'data-text', esc_attr($settings['button_b_text']));

		$this->add_render_attribute( 'button-b-text', 'class', 'sm-button-text' );

		if ( ! isset( $settings['button_b_icon'] ) && ! Icons_Manager::is_migration_allowed() ) 
		{
			// add old default
			$settings['button_b_icon'] = 'fas fa-arrow-right';
		}

		$migrated  = isset( $settings['__fa4_migrated']['button_b_select_icon'] );
		$is_new    = empty( $settings['button_b_icon'] ) && Icons_Manager::is_migration_allowed();

		?>
		<div <?php echo $this->get_render_attribute_string( 'content-wrapper-b' ); ?>>
			<?php if ( ! empty( $settings['button_b_select_icon']['value'] ) ) : ?>
				<div class="sm-button-icon sm-dual-button-b-icon sm-flex-align-<?php echo esc_attr($settings['button_b_icon_align']); ?>">
					<div class="sm-button-b-icon-inner">
					
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['button_b_select_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['button_b_icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>

					</div>
				</div>
			<?php endif; ?>
			<div <?php echo $this->get_render_attribute_string( 'button-b-text' ); ?>><?php echo wp_kses( $settings['button_b_text'], stiles_media_allow_tags('title') ); ?></div>
		</div>
		<?php
	}

	protected function render() 
	{
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'sm-dual-button sm-button-wrapper sm-element' );

		if ( ! empty( $settings['button_a_link']['url'] ) ) 
		{
			$this->add_render_attribute( 'button_a', 'href', $settings['button_a_link']['url'] );

			if ( $settings['button_a_link']['is_external'] ) 
			{
				$this->add_render_attribute( 'button_a', 'target', '_blank' );
			}

			if ( $settings['button_a_link']['nofollow'] ) 
			{
				$this->add_render_attribute( 'button_a', 'rel', 'nofollow' );
			}
		}

		if ( ! empty( $settings['button_b_link']['url'] ) ) 
		{
			$this->add_render_attribute( 'button_b', 'href', $settings['button_b_link']['url'] );

			if ( $settings['button_b_link']['is_external'] ) 
			{
				$this->add_render_attribute( 'button_b', 'target', '_blank' );
			}

			if ( $settings['button_b_link']['nofollow'] ) 
			{
				$this->add_render_attribute( 'button_b', 'rel', 'nofollow' );
			}
		}

		if ( $settings['button_a_link']['nofollow'] ) 
		{
			$this->add_render_attribute( 'button_a', 'rel', 'nofollow' );
		}

		if ( $settings['button_b_link']['nofollow'] ) 
		{
			$this->add_render_attribute( 'button_b', 'rel', 'nofollow' );
		}

		if ( 'yes' === $settings['button_a_onclick'] ) 
		{
			$this->add_render_attribute( 'button_a', 'onclick', $settings['button_a_onclick_event'] );
		}

		if ( 'yes' === $settings['button_b_onclick'] ) 
		{
			$this->add_render_attribute( 'button_b', 'onclick', $settings['button_b_onclick_event'] );
		}

		$this->add_render_attribute( 'button_a', 'class', 'sm-dual-button-a sm-button' );		
		$this->add_render_attribute( 'button_a', 'class', 'sm-button-effect-' . esc_attr($settings['button_a_effect']) );
		$this->add_render_attribute( 'button_a', 'class', 'sm-button-size-' . esc_attr($settings['dual_button_size']) );

		if ( $settings['add_custom_a_attributes'] and ! empty( $settings['custom_a_attributes'] ) ) 
		{
			$attributes = explode( "\n", $settings['custom_a_attributes'] );

			$reserved_attr = [ 'href', 'target' ];

			foreach ( $attributes as $attribute ) 
			{
				if ( ! empty( $attribute ) ) 
				{
					$attr = explode( '|', $attribute, 2 );
					if ( ! isset( $attr[1] ) ) {
						$attr[1] = '';
					}

					if ( ! in_array( strtolower( $attr[0] ), $reserved_attr ) ) 
					{
						$this->add_render_attribute( 'button_a', trim( $attr[0] ), trim( $attr[1] ) );
					}
				}
			}
		}

		$this->add_render_attribute( 'button_b', 'class', 'sm-dual-button-b sm-button' );		
		$this->add_render_attribute( 'button_b', 'class', 'sm-button-effect-' . esc_attr($settings['button_b_effect']) );
		$this->add_render_attribute( 'button_b', 'class', 'sm-button-size-' . esc_attr($settings['dual_button_size']) );	

		if ( $settings['add_custom_b_attributes'] and ! empty( $settings['custom_b_attributes'] ) ) 
		{
			$attributes = explode( "\n", $settings['custom_b_attributes'] );

			$reserved_attr = [ 'href', 'target' ];

			foreach ( $attributes as $attribute ) 
			{
				if ( ! empty( $attribute ) ) 
				{
					$attr = explode( '|', $attribute, 2 );
					if ( ! isset( $attr[1] ) ) 
					{
						$attr[1] = '';
					}

					if ( ! in_array( strtolower( $attr[0] ), $reserved_attr ) ) 
					{
						$this->add_render_attribute( 'button_b', trim( $attr[0] ), trim( $attr[1] ) );
					}
				}
			}
		}

		?>
		<div class="sm-element-align-wrapper">
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<a <?php echo $this->get_render_attribute_string( 'button_a' ); ?>>
					<?php $this->render_text_a($settings); ?>
				</a>

				<?php if ( 'yes' === $settings['show_middle_text'] ) : ?>
					<span><?php echo esc_attr($settings['middle_text']); ?></span>
				<?php endif; ?>

				<a <?php echo $this->get_render_attribute_string( 'button_b' ); ?>>
					<?php $this->render_text_b($settings); ?>
				</a>
			</div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_dual_buttons() );