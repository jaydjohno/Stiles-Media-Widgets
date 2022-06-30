<?php

/**
 * SMW Fancy Headings.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_fancy_headings extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'fancy-headings-css', plugin_dir_url( __FILE__ ) . '../css/fancy-headings.css');
        
        wp_register_script( 'fancy-type', plugin_dir_url( __FILE__ ) . '../js/fancy-type.js');
        wp_register_script( 'fancy-slide', plugin_dir_url( __FILE__ ) . '../js/fancy-slide.js');
        wp_register_script( 'fancy-headings-js', plugin_dir_url( __FILE__ ) . '../js/fancy-headings.js');
    }
    
    public function get_name()
    {
        return 'stiles-fancy-headings';
    }
    
    public function get_title()
    {
        return 'Fancy Heading';
    }
    
    public function get_icon()
    {
        return 'eicon-heading';
    }
    
    public function get_categories()
    {
        return ['stiles-media-headers'];
    }
    
    public function get_style_depends() 
    {
        return [ 'fancy-headings-css' ];
    }
    
    public function get_script_depends() 
    {
        return [ 
            'fancy-type',
            'fancy-slide',
            'fancy-headings-js',
        ];
    }
    
    protected function register_controls() 
    { 
	    $this->register_heading_text_content_controls();
	    
		$this->register_effect_content_controls();
		
		$this->register_general_content_controls();
		
		$this->register_style_content_controls();
	}
	
	protected function register_heading_text_content_controls() 
    {
		$this->start_controls_section(
			'section_general_field',
			array(
				'label' => __( 'Heading Text', smw_slug ),
			)
		);

		$this->add_control(
			'fancytext_prefix',
			array(
				'label'    => __( 'Before Text', smw_slug ),
				'type'     => Controls_Manager::TEXT,
				'selector' => '{{WRAPPER}} .smw-fancy-text-prefix',
				'dynamic'  => array(
					'active' => true,
				),
				'default'  => __( 'I am', smw_slug ),
			)
		);

		$this->add_control(
			'fancytext',
			array(
				'label'       => __( 'Fancy Text', smw_slug ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter each word in a separate line', smw_slug ),
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => "Creative\nAmazing\nPassionate",
			)
		);
		$this->add_control(
			'fancytext_suffix',
			array(
				'label'    => __( 'After Text', smw_slug ),
				'type'     => Controls_Manager::TEXT,
				'selector' => '{{WRAPPER}} .smw-fancy-text-suffix',
				'dynamic'  => array(
					'active' => true,
				),
				'default'  => __( 'Designer', smw_slug ),
			)
		);

		$this->end_controls_section();
	}
	
	protected function register_effect_content_controls() 
    {
		$this->start_controls_section(
			'section_effect_field',
			array(
				'label' => __( 'Effect', smw_slug ),
			)
		);
		$this->add_control(
			'fancytext_effect_type',
			array(
				'label'       => __( 'Select Effect', smw_slug ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type'  => __( 'Type', smw_slug ),
					'slide' => __( 'Slide', smw_slug ),
				),
				'default'     => 'type',
				'label_block' => false,
			)
		);
		$this->add_control(
			'fancytext_type_loop',
			array(
				'label'        => __( 'Enable Loop', smw_slug ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', smw_slug ),
				'label_off'    => __( 'No', smw_slug ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'fancytext_effect_type' => 'type',
				),
			)
		);
		$this->add_control(
			'fancytext_type_show_cursor',
			array(
				'label'        => __( 'Show Cursor', smw_slug ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', smw_slug ),
				'label_off'    => __( 'No', smw_slug ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'fancytext_effect_type' => 'type',
				),
			)
		);
		$this->add_control(
			'fancytext_type_cursor_text',
			array(
				'label'     => __( 'Cursor Text', smw_slug ),
				'type'      => Controls_Manager::TEXT,
				'selector'  => '{{WRAPPER}}',
				'default'   => __( '|', smw_slug ),
				'condition' => array(
					'fancytext_effect_type'      => 'type',
					'fancytext_type_show_cursor' => 'yes',
				),
				'selector'  => '{{WRAPPER}} .typed-cursor',
			)
		);
		$this->add_control(
			'fancytext_type_cursor_blink',
			array(
				'label'        => __( 'Cursor Blink Effect', smw_slug ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', smw_slug ),
				'label_off'    => __( 'No', smw_slug ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'fancytext_effect_type'      => 'type',
					'fancytext_type_show_cursor' => 'yes',
				),
				'prefix_class' => 'smw-show-cursor-',
			)
		);
		$this->add_control(
			'fancytext_type_fields',
			array(
				'label'        => __( 'Advanced Settings', smw_slug ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', smw_slug ),
				'label_off'    => __( 'No', smw_slug ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'fancytext_effect_type' => 'type',
				),
			)
		);

		$this->add_control(
			'fancytext_slide_pause_hover',
			array(
				'label'        => __( 'Pause on Hover', smw_slug ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', smw_slug ),
				'label_off'    => __( 'No', smw_slug ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'fancytext_effect_type' => 'slide',
				),
			)
		);
		$this->add_control(
			'fancytext_slide_anim_speed',
			array(
				'label'       => __( 'Animation Speed (ms)', smw_slug ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'ms' ),
				'range'       => array(
					'ms' => array(
						'min' => 1,
						'max' => 5000,
					),
				),
				'default'     => array(
					'size' => '500',
					'unit' => 'ms',
				),
				'label_block' => true,
				'condition'   => array(
					'fancytext_effect_type' => 'slide',
				),
			)
		);
		$this->add_control(
			'fancytext_slide_pause_time',
			array(
				'label'       => __( 'Pause Time (ms)', smw_slug ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'ms' ),
				'range'       => array(
					'ms' => array(
						'min' => 1,
						'max' => 5000,
					),
				),
				'default'     => array(
					'size' => '2000',
					'unit' => 'ms',
				),
				'label_block' => true,
				'condition'   => array(
					'fancytext_effect_type' => 'slide',
				),
			)
		);
		$this->add_control(
			'fancytext_type_speed',
			array(
				'label'       => __( 'Typing Speed (ms)', smw_slug ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'ms' ),
				'range'       => array(
					'ms' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'default'     => array(
					'size' => '120',
					'unit' => 'ms',
				),
				'label_block' => true,
				'condition'   => array(
					'fancytext_effect_type' => 'type',
					'fancytext_type_fields' => 'yes',
				),
			)
		);
		$this->add_control(
			'fancytext_type_backspeed',
			array(
				'label'       => __( 'Backspeed (ms)', smw_slug ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'ms' ),
				'range'       => array(
					'ms' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'default'     => array(
					'size' => '60',
					'unit' => 'ms',
				),
				'label_block' => true,
				'condition'   => array(
					'fancytext_effect_type' => 'type',
					'fancytext_type_fields' => 'yes',
				),
			)
		);

		$this->add_control(
			'fancytext_type_start_delay',
			array(
				'label'       => __( 'Start Delay (ms)', smw_slug ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'ms' ),
				'range'       => array(
					'ms' => array(
						'min' => 0,
						'max' => 5000,
					),
				),
				'default'     => array(
					'size' => '0',
					'unit' => 'ms',
				),
				'label_block' => true,
				'condition'   => array(
					'fancytext_effect_type' => 'type',
					'fancytext_type_fields' => 'yes',
				),
			)
		);
		$this->add_control(
			'fancytext_type_back_delay',
			array(
				'label'       => __( 'Back Delay (ms)', smw_slug ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'ms' ),
				'range'       => array(
					'ms' => array(
						'min' => 0,
						'max' => 5000,
					),
				),
				'default'     => array(
					'size' => '1200',
					'unit' => 'ms',
				),
				'label_block' => true,
				'condition'   => array(
					'fancytext_effect_type' => 'type',
					'fancytext_type_fields' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}
	
	protected function register_general_content_controls() 
    {
		$this->start_controls_section(
			'section_structure_field',
			array(
				'label' => __( 'General', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'fancytext_title_tag',
			array(
				'label'   => __( 'Title Tag', smw_slug ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1'  => __( 'H1', smw_slug ),
					'h2'  => __( 'H2', smw_slug ),
					'h3'  => __( 'H3', smw_slug ),
					'h4'  => __( 'H4', smw_slug ),
					'h5'  => __( 'H5', smw_slug ),
					'h6'  => __( 'H6', smw_slug ),
					'div' => __( 'div', smw_slug ),
					'p'   => __( 'p', smw_slug ),
				),
				'default' => 'h3',
			)
		);
		$this->add_responsive_control(
			'fancytext_align',
			array(
				'label'     => __( 'Alignment', smw_slug ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', smw_slug ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', smw_slug ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', smw_slug ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .smw-fancy-text-wrap ' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'fancytext_layout',
			array(
				'label'        => __( 'Layout', smw_slug ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Stack', smw_slug ),
				'label_off'    => __( 'Inline', smw_slug ),
				'return_value' => 'yes',
				'default'      => 'no',
				'prefix_class' => 'smw-fancytext-stack-',
			)
		);
		$this->add_responsive_control(
			'fancytext_space_prefix',
			array(
				'label'      => __( 'Before Spacing', smw_slug ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'default'    => array(
					'size' => '0',
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}}.smw-fancytext-stack-yes .smw-fancy-stack ' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.smw-fancytext-stack-yes .smw-fancy-stack .smw-fancy-heading.smw-fancy-text-main' => ' margin-left: 0px;',
					'{{WRAPPER}} .smw-fancy-text-main' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'fancytext_space_suffix',
			array(
				'label'      => __( 'After Spacing', smw_slug ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'default'    => array(
					'size' => '0',
					'unit' => 'px',
				),
				'condition'  => array(
					'fancytext_suffix!' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} .smw-fancy-text-main' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.smw-fancytext-stack-yes .smw-fancy-stack ' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.smw-fancytext-stack-yes .smw-fancy-stack .smw-fancy-heading.smw-fancy-text-main' => ' margin-right: 0px;',
				),
			)
		);
		$this->add_responsive_control(
			'fancytext_min_height',
			array(
				'label'      => __( 'Minimum Height', smw_slug ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .smw-fancy-text-wrap' => 'min-height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'fancytext_effect_type' => 'type',
				),
			)
		);

		$this->end_controls_section();
	}
	
	protected function register_style_content_controls() 
    {
		$this->start_controls_section(
			'section_typography_field',
			array(
				'label' => __( 'Style', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->start_controls_tabs( 'tabs_fancytext' );

			$this->start_controls_tab(
				'tab_heading',
				array(
					'label' => __( 'Heading Text', smw_slug ),
				)
			);
			$this->add_control(
				'prefix_suffix_colour',
				array(
					'label'     => __( 'Text Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_1,
					),
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .smw-fancy-heading' => 'color: {{VALUE}};',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'prefix_suffix_typography',
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .smw-fancy-heading, {{WRAPPER}} .smw-fancy-heading .smw-slide_text',
				)
			);
			$this->add_control(
				'text_adv_options',
				array(
					'label'        => __( 'Advanced', smw_slug ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', smw_slug ),
					'label_off'    => __( 'No', smw_slug ),
					'return_value' => 'yes',
					'default'      => '',
				)
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				array(
					'name'      => 'text_bg_colour',
					'label'     => __( 'Background Colour', smw_slug ),
					'types'     => array( 'classic', 'gradient' ),
					'selector'  => '{{WRAPPER}} .smw-fancy-heading',
					'condition' => array(
						'text_adv_options' => 'yes',
					),
				)
			);
			$this->add_responsive_control(
				'text_padding',
				array(
					'label'      => __( 'Padding', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .smw-fancy-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition'  => array(
						'text_adv_options' => 'yes',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'        => 'text_border',
					'label'       => __( 'Border', smw_slug ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .smw-fancy-heading',
					'condition'   => array(
						'text_adv_options' => 'yes',
					),
				)
			);
			$this->add_control(
				'text_border_radius',
				array(
					'label'      => __( 'Border Radius', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .smw-fancy-heading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition'  => array(
						'text_adv_options' => 'yes',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				array(
					'name'      => 'text_shadow',
					'selector'  => '{{WRAPPER}} .smw-fancy-heading',
					'condition' => array(
						'text_adv_options' => 'yes',
					),
				)
			);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_fancy',
				array(
					'label' => __( 'Fancy Text', smw_slug ),
				)
			);
			$this->add_control(
				'fancytext_colour',
				array(
					'label'     => __( 'Fancy Text Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_2,
					),
					'selectors' => array(
						'{{WRAPPER}} .smw-fancy-heading.smw-fancy-text-main' => 'color: {{VALUE}};',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'fancytext_typography',
					'scheme'   => Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .smw-fancy-heading.smw-fancy-text-main, {{WRAPPER}} .smw-fancy-heading.smw-fancy-text-main .smw-slide_text',
				)
			);
			$this->add_control(
				'fancy_adv_options',
				array(
					'label'        => __( 'Advanced', smw_slug ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', smw_slug ),
					'label_off'    => __( 'No', smw_slug ),
					'return_value' => 'yes',
					'default'      => '',
				)
			);
			$this->add_control(
				'fancytext_bg_colour',
				array(
					'label'     => __( 'Background Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .smw-fancy-heading.smw-fancy-text-main' => 'background-color: {{VALUE}};',
					),
					'condition' => array(
						'fancy_adv_options' => 'yes',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				array(
					'name'      => 'fancytext_bg_colour',
					'label'     => __( 'Background Colour', smw_slug ),
					'types'     => array( 'classic', 'gradient' ),
					'selector'  => '{{WRAPPER}} .smw-fancy-heading.smw-fancy-text-main',
					'condition' => array(
						'fancy_adv_options' => 'yes',
					),
				)
			);
			$this->add_responsive_control(
				'fancytext_padding',
				array(
					'label'      => __( 'Padding', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .smw-fancy-heading.smw-fancy-text-main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition'  => array(
						'fancy_adv_options' => 'yes',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'        => 'fancytext_border',
					'label'       => __( 'Border', smw_slug ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .smw-fancy-heading.smw-fancy-text-main',
					'condition'   => array(
						'fancy_adv_options' => 'yes',
					),
				)
			);
			$this->add_control(
				'fancytext_border_radius',
				array(
					'label'      => __( 'Border Radius', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .smw-fancy-heading.smw-fancy-text-main' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
					'condition'  => array(
						'fancy_adv_options' => 'yes',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				array(
					'name'      => 'fancytext_shadow',
					'selector'  => '{{WRAPPER}} .smw-fancy-heading.smw-fancy-text-main',
					'condition' => array(
						'fancy_adv_options' => 'yes',
					),
				)
			);
			$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->end_controls_section();
	}
	
	protected function get_fancytext_data()
    {
		$settings = $this->get_settings_for_display();

		$fancy_text   = $this->get_settings_for_display( 'fancytext' );
		$fancy_text   = preg_replace( '/[\n\r]/', '|', $fancy_text );
		$data_strings = explode( '|', $fancy_text );

		return $data_strings;
	}
	
    protected function render() 
    {
		$html             = '';
		$settings         = $this->get_settings();
		$dynamic_settings = $this->get_settings_for_display();

		// Get Data Attributes.
		$effect_type  = $settings['fancytext_effect_type'];
		$data_strings = $this->get_fancytext_data();
		$fancy_data   = wp_json_encode( $data_strings );

		if ( 'type' === $settings['fancytext_effect_type'] ) {
			$type_speed  = ( '' !== $settings['fancytext_type_speed']['size'] ) ? $settings['fancytext_type_speed']['size'] : 120;
			$back_speed  = ( '' !== $settings['fancytext_type_backspeed']['size'] ) ? $settings['fancytext_type_backspeed']['size'] : 60;
			$start_delay = ( '' !== $settings['fancytext_type_start_delay']['size'] ) ? $settings['fancytext_type_start_delay']['size'] : 0;
			$back_delay  = ( '' !== $settings['fancytext_type_back_delay']['size'] ) ? $settings['fancytext_type_back_delay']['size'] : 1200;
			$loop        = ( 'yes' === $settings['fancytext_type_loop'] ) ? 'true' : 'false';

			if ( 'yes' === $settings['fancytext_type_show_cursor'] ) {
				$show_cursor = 'true';
				$cursor_char = ( '' !== $settings['fancytext_type_cursor_text'] ) ? $settings['fancytext_type_cursor_text'] : '|';
			} else {
				$show_cursor = 'false';
				$cursor_char = '';
			}

			$this->add_render_attribute(
				'fancy-text',
				array(
					'data-type-speed'  => $type_speed,
					'data-animation'   => $effect_type,
					'data-back-speed'  => $back_speed,
					'data-start-delay' => $start_delay,
					'data-back-delay'  => $back_delay,
					'data-loop'        => $loop,
					'data-show-cursor' => $show_cursor,
					'data-cursor-char' => $cursor_char,
					'data-strings'     => $fancy_data,
				)
			);

		} elseif ( 'slide' === $settings['fancytext_effect_type'] ) {
			$speed = ( '' !== $settings['fancytext_slide_anim_speed']['size'] ) ? $settings['fancytext_slide_anim_speed']['size'] : 35;

			$pause = ( '' !== $settings['fancytext_slide_pause_time']['size'] ) ? $settings['fancytext_slide_pause_time']['size'] : 3000;

			$mousepause = ( 'yes' === $settings['fancytext_slide_pause_hover'] ) ? true : false;

			$this->add_render_attribute(
				'fancy-text',
				array(
					'data-animation'  => $effect_type,
					'data-speed'      => $speed,
					'data-pause'      => $pause,
					'data-mousepause' => $mousepause,
					'data-strings'    => $fancy_data,
				)
			);
		}

		$node_id = $this->get_id(); ?>
		<div class="smw-module-content smw-fancy-text-node" <?php echo wp_kses_post( $this->get_render_attribute_string( 'fancy-text' ) ); ?>>
			<?php if ( ! empty( $settings['fancytext_effect_type'] ) ) { ?> 
				<?php echo '<' . esc_attr( $settings['fancytext_title_tag'] ); ?> class="smw-fancy-text-wrap smw-fancy-text-<?php echo esc_attr( $settings['fancytext_effect_type'] ); ?>">
					<?php if ( '' !== $dynamic_settings['fancytext_prefix'] ) { ?>
						<span class="smw-fancy-heading smw-fancy-text-prefix"><?php echo wp_kses_post( $this->get_settings_for_display( 'fancytext_prefix' ) ); ?></span>
					<?php } ?>
						<span class="smw-fancy-stack">
					<?php
					if ( 'type' === $settings['fancytext_effect_type'] ) {
						?>
						<span class="smw-fancy-heading smw-fancy-text-main smw-typed-main-wrap "><span class="smw-typed-main"></span><span class="smw-text-holder">.</span></span>
						<?php
					} elseif ( 'slide' === $settings['fancytext_effect_type'] ) {
							$order       = array( "\r\n", "\n", "\r", '<br/>', '<br>' );
							$replace     = '|';
							$str         = str_replace( $order, $replace, trim( $settings['fancytext'] ) );
							$lines       = explode( '|', $str );
							$count_lines = count( $lines );
							$output      = '';
						?>
							<span class="smw-fancy-heading smw-fancy-text-main smw-slide-main smw-adjust-width">
								<span class="smw-slide-main_ul">
									<?php foreach ( $lines as $key => $line ) { ?>
											<span class="smw-slide-block"><span class="smw-slide_text"><?php echo esc_attr( wp_strip_all_tags( $line ) ); ?></span>
											</span>
											<?php if ( 1 === $count_lines ) { ?>
												<span class="smw-slide-block"><span class="smw-slide_text"><?php echo esc_attr( wp_strip_all_tags( $line ) ); ?></span></span>
											<?php } ?>
										<?php } ?>
								</span>
							</span>
						<?php } ?>
						</span>
					<?php if ( '' !== $dynamic_settings['fancytext_suffix'] ) { ?>
						<span class="smw-fancy-heading smw-fancy-text-suffix"><?php echo wp_kses_post( $this->get_settings_for_display( 'fancytext_suffix' ) ); ?></span>
					<?php } ?>
				<?php echo '</' . esc_attr( $settings['fancytext_title_tag'] ) . '>'; ?>
			<?php } ?>
		</div>
		<?php
	}
	
	protected function content_template() 
	{
		?>
		<#
		function get_fancytext_data(){
			var ipstr 		= settings.fancytext;
			var strs        = ipstr.split( "\n" );
			return strs;
		}
		var effect_type = settings.fancytext_effect_type;

		if ( 'type' == settings.fancytext_effect_type ) {
			var type_speed  = ( '' != settings.fancytext_type_speed.size ) ? settings.fancytext_type_speed.size : 120;
			var back_speed  = ( '' != settings.fancytext_type_backspeed.size ) ? settings.fancytext_type_backspeed.size : 60;
			var start_delay = ( '' != settings.fancytext_type_start_delay.size ) ? settings.fancytext_type_start_delay.size : 0;
			var back_delay  = ( '' != settings.fancytext_type_back_delay.size ) ? settings.fancytext_type_back_delay.size : 1200;
			var loop        = ( 'yes' == settings.fancytext_type_loop ) ? 'true' : 'false';

			if ( 'yes' == settings.fancytext_type_show_cursor ) {
				var show_cursor = 'true';
				var cursor_char = ( '' != settings.fancytext_type_cursor_text ) ? settings.fancytext_type_cursor_text : '|';
			} else {
				var show_cursor = 'false';
				var cursor_char = '';
			}

			var data_strings = get_fancytext_data();
			var fancy_data = JSON.stringify( data_strings );

			view.addRenderAttribute(
				'fancy-text',
				{
					'data-type-speed'  		: type_speed,
					'data-animation'   		: effect_type,
					'data-back-speed'  		: back_speed,
					'data-start-delay'     	: start_delay,
					'data-back-delay'     	: back_delay,
					'data-loop'   			: loop,
					'data-show-cursor'   	: show_cursor,
					'data-cursor-char'     	: cursor_char,
					'data-strings'     		: fancy_data,
				}
			);
		}
		else if ( 'slide' == settings.fancytext_effect_type ) {

			var speed = ( '' != settings.fancytext_slide_anim_speed.size ) ? settings.fancytext_slide_anim_speed.size : 35;

			var pause = ( '' != settings.fancytext_slide_pause_time.size ) ? settings.fancytext_slide_pause_time.size : 3000;

			var mousepause = ( 'yes' == settings.fancytext_slide_pause_hover ) ? true : false;

			view.addRenderAttribute(
				'fancy-text',
				{
					'data-animation'  		: effect_type,
					'data-speed'   			: speed,
					'data-pause'  			: pause,
					'data-mousepause'     	: mousepause,
					'data-strings'     		: fancy_data,
				}
			);
		}
		#>
			<div class="smw-module-content smw-fancy-text-node" {{{ view.getRenderAttributeString( 'fancy-text' ) }}}>
				<# if ( '' != settings.fancytext_effect_type ) { #>
					<{{{ settings.fancytext_title_tag }}} class="smw-fancy-text-wrap smw-fancy-text-{{{ settings.fancytext_effect_type }}}" >

						<# if ( '' != settings.fancytext_prefix ) { #>
							<span class="smw-fancy-heading smw-fancy-text-prefix">{{{ settings.fancytext_prefix }}}</span>
						<# } #>
						<span class="smw-fancy-stack">
							<# if ( 'type' == settings.fancytext_effect_type ) { #>
								<span class="smw-fancy-heading smw-fancy-text-main smw-typed-main-wrap"><span class="smw-typed-main"></span><span class="smw-text-holder">.</span></span>
							<# }
							else if ( 'slide' == settings.fancytext_effect_type ) { #>
								<#
								var str 	= settings.fancytext;
								str 		= str.trim();
								str 		= str.replace( /\r?\n|\r/g, "|" );
								var lines 	= str.split("|");
								var count_lines = lines.length;
								var output      = '';
								#>
								<span class="smw-fancy-heading smw-fancy-text-main smw-slide-main smw-adjust-width">
									<span class="smw-slide-main_ul">
										<#
										lines.forEach(function(line){ #>
											<span class="smw-slide-block"><span class="smw-slide_text">{{ line }}</span></span>

											<# if ( 1 == count_lines ) { #>
												<span class="smw-slide-block"><span class="smw-slide_text">{{ line }}</span></span>
											<# }
										});
										#>
									</span>
								</span>
							<# } #>
						</span>
						<# if ( '' != settings.fancytext_suffix ) { #>
							<span class="smw-fancy-heading smw-fancy-text-suffix">{{{ settings.fancytext_suffix }}}</span>
						<# } #>

					</{{{ settings.fancytext_title_tag }}}>
				<# } #>
			</div>
			<# elementorFrontend.hooks.doAction( 'frontend/element_ready/stiles_fancy_headings.default' ); #>
		<?php
	}

	protected function _content_template() 
	{ 
		$this->content_template();
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_fancy_headings() );