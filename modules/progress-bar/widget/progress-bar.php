<?php

/**
 * SMW Progress Bar.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_progress_bar extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'progress-bar-css', plugin_dir_url( __FILE__ ) .  '../css/progress-bar.css');
        
        wp_register_script( 'progress-bar-js', plugin_dir_url( __FILE__ ) . '../js/progress-bar.js' );
    }
    
    public function get_name()
    {
        return 'stiles-progress-bar';
    }
    
    public function get_title()
    {
        return 'Progress Bar';
    }
    
    public function get_icon()
    {
        return 'eicon-skill-bar';
    }
    
    public function get_categories()
    {
        return [ 'stiles-media-category' ];
    }
    
    public function get_style_depends() 
    {
        return [ 'progress-bar-css' ];
    }
    
    public function get_script_depends() {
        return [
            'elementor-waypoints',
            'lottie-js',
            'progress-bar-js'
        ];
    }
    
    protected function register_controls() 
    {
        $this->start_controls_section('progress_bar_labels',
            [
                'label'         => __('Progress Bar Settings', smw_slug),
            ]
        );

        $this->add_control('layout_type', 
            [
                'label'         => __('Type', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'line'          => __('Line', smw_slug),
                    'circle'        => __('Circle', smw_slug),
                    'dots'          => __('Dots', smw_slug),
                ],
                'default'       =>'line',
                'label_block'   => true,
            ]
        );

        $this->add_responsive_control('dot_size', 
            [
                'label'     => __('Dot Size', smw_slug),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 60,
                    ],
                ],
                'default'     => [
                    'size' => 25,
                    'unit' => 'px',
                ],
                'condition'     => [
                    'layout_type'   => 'dots'
                ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .progress-segment' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control('dot_spacing', 
            [
                'label'     => __('Spacing', smw_slug),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px'    => [
                        'min'   => 1,
                        'max'   => 10,
                    ],
                ],
                'default'     => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'condition'     => [
                    'layout_type'   => 'dots'
                ],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .progress-segment:not(:first-child):not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 ); margin-left: calc( {{SIZE}}{{UNIT}}/2 )',
                    '{{WRAPPER}} .progress-segment:first-child' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 )',
                    '{{WRAPPER}} .progress-segment:last-child' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 )',
                ],
            ]
        );

        $this->add_control('circle_size',
            [
                'label' => __('Size', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 200,
                ],
                'selectors' => [
                    '{{WRAPPER}} .progress-bar-circle-wrap' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                ],
                'condition'     => [
                    'layout_type'   => 'circle'
                ]
            ]
        );
        
        $this->add_control('progress_bar_select_label', 
            [
                'label'         => __('Labels', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'default'       =>'left_right_labels',
                'options'       => [
                    'left_right_labels'    => __('Left & Right Labels', smw_slug),
                    'more_labels'          => __('Multiple Labels', smw_slug),
                ],
                'label_block'   => true,
                'condition'     => [
                    'layout_type!'   => 'circle'
                ]
            ]
        );
        
        $this->add_control('progress_bar_left_label',
            [
                'label'         => __('Title', smw_slug),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('My Skill',smw_slug),
                'label_block'   => true,
                'condition'     =>[
                    'progress_bar_select_label' => 'left_right_labels'
                ]
            ]
        );

        $this->add_control('progress_bar_right_label',
            [
                'label'         => __('Percentage', smw_slug),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('50%',smw_slug),
                'label_block'   => true,
                'condition'     =>[
                    'progress_bar_select_label' => 'left_right_labels',
                    'layout_type!'   => 'circle'
                ]
            ]
        );

        $this->add_control('icon_type',
		  	[
		     	'label'			=> __( 'Icon Type', smw_slug ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'options'		=> [
		     		'icon'  => __('Font Awesome', smw_slug),
                    'image'=> __( 'Custom Image', smw_slug),
                    'animation'     => __('Lottie Animation', smw_slug),
		     	],
                 'default'		=> 'icon',
                 'condition'    =>[
                    'layout_type'   => 'circle'
                ]
		  	]
		);

		$this->add_control('icon_select',
		  	[
		     	'label'			=> __( 'Select an Icon', smw_slug ),
		     	'type'              => Controls_Manager::ICONS,
                'condition'     =>[
                    'icon_type' => 'icon',
                    'layout_type'   => 'circle'
                ]
		  	]
		);

		$this->add_control('image_upload',
		  	[
		     	'label'			=> __( 'Upload Image', smw_slug ),
		     	'type' 			=> Controls_Manager::MEDIA,
			  	'default'		=> [
			  		'url' => Utils::get_placeholder_image_src(),
                ],
                'condition'     => [
                    'icon_type' => 'image',
                    'layout_type'   => 'circle'
                ]
		  	]
        );

        $this->add_control('lottie_url', 
            [
                'label'             => __( 'Animation JSON URL', smw_slug ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'description'       => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
                'label_block'       => true,
                'condition'     => [
                    'layout_type'   => 'circle',
                    'icon_type'   => 'animation',
                ]
            ]
        );

        $this->add_control('lottie_loop',
            [
                'label'         => __('Loop',smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
                'condition'     => [
                    'layout_type'   => 'circle',
                    'icon_type'   => 'animation',
                ]
            ]
        );

        $this->add_control('lottie_reverse',
            [
                'label'         => __('Reverse',smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'     => [
                    'layout_type'   => 'circle',
                    'icon_type'   => 'animation',
                ]
            ]
        );
        
        $this->add_responsive_control('icon_size',
            [
                'label'         => __('Icon Size', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'condition'     => [
                    'layout_type'   => 'circle'
                ],
                'default'       => [
                    'unit'  => 'px',
                    'size'  => 30,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .progress-bar-circle-content i' => 'font-size: {{SIZE}}px',
                    '{{WRAPPER}} .progress-bar-circle-content svg, {{WRAPPER}} .progress-bar-circle-content img' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                ]
            ]
        );

        $this->add_control('show_percentage_value',
            [
                'label'      => __('Show Percentage Value', smw_slug),
                'type'       => Controls_Manager::SWITCHER,
                'default'     => 'yes',
                'condition'   => [
                    'layout_type'   => 'circle'
                ]
            ]
        );
        
        $repeater = new REPEATER();
        
        $repeater->add_control('text',
            [
                'label'             => __( 'Label',smw_slug ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'label_block'       => true,
                'placeholder'       => __( 'label',smw_slug ),
                'default'           => __( 'label', smw_slug ),
            ]
        );
        
        $repeater->add_control('number',
            [
                'label'             => __( 'Percentage', smw_slug ),
                'dynamic'           => [ 'active' => true ],
                'type'              => Controls_Manager::TEXT,
                'default'           => 50,
            ]
        );
        
        $this->add_control('progress_bar_multiple_label',
            [
                'label'     => __('Label',smw_slug),
                'type'      => Controls_Manager::REPEATER,
                'default'   => [
                    [
                        'text' => __( 'Label',smw_slug ),
                        'number' => 50
                    ]
                    ],
                'fields'    => array_values( $repeater->get_controls() ),
                'condition' => [
                    'progress_bar_select_label'  => 'more_labels',
                    'layout_type!'   => 'circle'
                ]
            ]
        );
        
        $this->add_control('progress_bar_space_percentage_switcher',
            [
                'label'      => __('Enable Percentage', smw_slug),
                'type'       => Controls_Manager::SWITCHER,
                'default'     => 'yes',
                'description' => __('Enable percentage for labels',smw_slug),
                'condition'   => [
                    'progress_bar_select_label'=>'more_labels',
                    'layout_type!'   => 'circle'
                ]
            ]
        );
        
        $this->add_control('progress_bar_select_label_icon', 
            [
                'label'         => __('Labels Indicator', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'default'       =>'line_pin',
                'options'       => [
                    ''            => __('None',smw_slug),
                    'line_pin'    => __('Pin', smw_slug),
                    'arrow'       => __('Arrow',smw_slug),
                ],
                'condition'     =>[
                    'progress_bar_select_label' => 'more_labels',
                    'layout_type!'   => 'circle'
                ]
            ]
        );
        
        $this->add_control('progress_bar_more_labels_align',
            [
                'label'         => __('Labels Alignment','premuim-addons-for-elementor'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title'=> __( 'Left', smw_slug ),
                        'icon' => 'fa fa-align-left',   
                    ],
                    'center'     => [
                        'title'=> __( 'Center', smw_slug ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', smw_slug ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'center',
                'condition'     =>[
                    'progress_bar_select_label' => 'more_labels',
                    'layout_type!'   => 'circle'
                ]
            ]
        );
    
        $this->add_control('progress_bar_progress_percentage',
            [
                'label'             => __('Value', smw_slug),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'default'           => 50
            ]
        );
        
        $this->add_control('progress_bar_progress_style', 
            [
                'label'         => __('Style', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'solid',
                'options'       => [
                    'solid'    => __('Solid', smw_slug),
                    'stripped' => __('Striped', smw_slug),
                    'gradient' => __('Animated Gradient', smw_slug),
                ],
                'condition'     => [
                    'layout_type'   => 'line'
                ]
            ]
        );
        
        $this->add_control('progress_bar_speed',
            [
                'label'             => __('Speed (milliseconds)', smw_slug),
                'type'              => Controls_Manager::NUMBER
            ]
        );
        
        $this->add_control('progress_bar_progress_animation', 
            [
                'label'         => __('Animated', smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'progress_bar_progress_style'    => 'stripped',
                    'layout_type'   => 'line'
                ]
            ]
        );

        $this->add_control('gradient_colors',
            [
                'label'         => __('Gradient Colours', smw_slug),
                'type'          => Controls_Manager::TEXT,
                'description'   => __('Enter Colours separated with \' , \'.',smw_slug),
                'default'       => '#6EC1E4,#54595F',
                'label_block'   => true,
                'condition'     => [
                    'layout_type'   => 'line',
                    'progress_bar_progress_style' => 'gradient'
                ]
            ]
        );
        
        $this->end_controls_section();

        
        $this->start_controls_section('progress_bar_progress_bar_settings',
            [
                'label'             => __('Progress Bar', smw_slug),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control('progress_bar_progress_bar_height',
            [
                'label'         => __('Height', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'  => 25,
                ],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .progress-bar-bar-wrap, {{WRAPPER}} .progress-bar-bar' => 'height: {{SIZE}}px;',   
                ],
                'condition'     => [
                    'layout_type'   => 'line'
                ]
            ]
        );

        $this->add_control('progress_bar_progress_bar_radius',
            [
                'label'         => __('Border Radius', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'em'],
                'range'         => [
                    'px'  => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .progress-bar-bar-wrap, {{WRAPPER}} .progress-bar-bar, {{WRAPPER}} .progress-segment' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'layout_type!'   => 'circle'
                ]
            ]
        );

        $this->add_control('circle_border_width',
            [
                'label' => __('Border Width', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .progress-bar-circle-base' => 'border-width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .progress-bar-circle div' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
                'condition'     => [
                    'layout_type'   => 'circle'
                ]
            ]
        );

        $this->add_control('circle_base_border_color',
            [
                'label'         => __('Border Colour', smw_slug),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .progress-bar-circle-base' => 'border-color: {{VALUE}};',
                ],
                'condition'     => [
                    'layout_type'   => 'circle'
                ]
            ]
        );

        $this->add_control('fill_colors_title',
            [
                'label'             =>  __('Fill', smw_slug),
                'type'              => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'progress_bar_progress_color',
                'types'             => [ 'classic' , 'gradient' ],
                'selector'          => '{{WRAPPER}} .progress-bar-bar, {{WRAPPER}} .segment-inner',
                'condition'     => [
                    'layout_type!'   => 'circle'
                ]
            ]
        );

        $this->add_control('circle_fill_color',
            [
                'label'         => __('Select Colour', smw_slug),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_2,
                ],
                'condition'     => [
                    'layout_type'   => 'circle'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .progress-bar-circle div' => 'border-color: {{VALUE}};',
                ],                
            ]
        );

        $this->add_control('base_colors_title',
            [
                'label'             =>  __('Base', smw_slug),
                'type'              => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'progress_bar_background',
                'types'             => [ 'classic' , 'gradient' ],
                'selector'          => '{{WRAPPER}} .progress-bar-bar-wrap:not(.progress-bar-dots), {{WRAPPER}} .progress-bar-circle-base, {{WRAPPER}} .progress-segment',
            ]
        );

        $this->add_responsive_control('progress_bar_container_margin',
            [
                'label'             => __('Margin', smw_slug),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .progress-bar-bar-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'layout_type!'   => 'circle'
                ]
            ]      
        );
        
        $this->end_controls_section();

        $this->start_controls_section('progress_bar_labels_section',
            [
                'label'         => __('Labels', smw_slug),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'progress_bar_select_label'  => 'left_right_labels'
                ]
            ]
        );
        
        $this->add_control('progress_bar_left_label_hint',
            [
                'label'             =>  __('Title', smw_slug),
                'type'              => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_control('progress_bar_left_label_color',
                [
                    'label'         => __('Colour', smw_slug),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'selectors'     => [
                    '{{WRAPPER}} .progress-bar-left-label' => 'color: {{VALUE}};',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'left_label_typography',
                'scheme'        => Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .progress-bar-left-label',
            ]
        );
        
        $this->add_responsive_control('progress_bar_left_label_margin',
            [
                'label'             => __('Margin', smw_slug),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .progress-bar-left-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        $this->add_control('progress_bar_right_label_hint',
            [
                'label'             =>  __('Percentage', smw_slug),
                'type'              => Controls_Manager::HEADING,
                'separator'         => 'before'
            ]
        );
        
        $this->add_control('progress_bar_right_label_color',
             [
                'label'             => __('Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                 'scheme'        => [
                        'type'  => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                'selectors'        => [
                    '{{WRAPPER}} .progress-bar-right-label' => 'color: {{VALUE}};',
                ]
            ]
         );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'right_label_typography',
                'scheme'        => Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .progress-bar-right-label',
            ]
        );
        
        $this->add_responsive_control('progress_bar_right_label_margin',
            [
                'label'             => __('Margin', smw_slug),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .progress-bar-right-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]      
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('progress_bar_multiple_labels_section',
            [
                'label'         => __('Multiple Labels', smw_slug),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     =>[
                    'progress_bar_select_label'  => 'more_labels'
                ]
            ]
        );

        $this->add_control('progress_bar_multiple_label_color',
             [
                'label'             => __('Labels\' Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                 'scheme'        => [
                        'type'  => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                'selectors'        => [
                    '{{WRAPPER}} .progress-bar-center-label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [   
                'label'         => __('Labels\' Typography', smw_slug),
                'name'          => 'more_label_typography',
                'scheme'        => Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .progress-bar-center-label',
            ]
        );

        $this->add_control('progress_bar_value_label_color',
            [
                'label'             => __('Percentage Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                 'scheme'        => [
                        'type'  => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                 'condition'       =>[
                     'progress_bar_space_percentage_switcher'=>'yes'
                 ],
                'selectors'        => [
                    '{{WRAPPER}} .progress-bar-percentage' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [   
                'label'         => __('Percentage Typography',smw_slug),
                'name'          => 'percentage_typography',
                'condition'       =>[
                        'progress_bar_space_percentage_switcher'=>'yes'
                ],
                'scheme'        => Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .progress-bar-percentage',
            ]
        );

         $this->end_controls_section();

         $this->start_controls_section('progress_bar_multiple_labels_arrow_section',
            [
                'label'         => __('Arrow', smw_slug),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     =>[
                    'progress_bar_select_label'  => 'more_labels',
                    'progress_bar_select_label_icon' => 'arrow'
                ]
            ]
        );
        
        $this->add_control('progress_bar_arrow_color',
            [
                'label'         => __('Colour', smw_slug),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'          => Color::get_type(),
                    'value'         => Color::COLOR_1,
                ],
                'condition'     =>[
                    'progress_bar_select_label_icon' => 'arrow'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .progress-bar-arrow' => 'color: {{VALUE}};'
                ]
            ]
        );
        
	 $this->add_responsive_control('progress_bar_arrow_size',
        [
            'label'	       => __('Size',smw_slug),
            'type'             =>Controls_Manager::SLIDER,
            'size_units'       => ['px', "em"],
            'condition'        =>[
                'progress_bar_select_label_icon' => 'arrow'
            ],
            'selectors'          => [
                '{{WRAPPER}} .progress-bar-arrow' => 'border-width: {{SIZE}}{{UNIT}};'
            ]
        ]
    );

       $this->end_controls_section();

       $this->start_controls_section('progress_bar_multiple_labels_pin_section',
            [
                'label'         => __('Indicator', smw_slug),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     =>[
                    'progress_bar_select_label'  => 'more_labels',
                    'progress_bar_select_label_icon' => 'line_pin'
                ]
            ]
        );
        
       $this->add_control('progress_bar_line_pin_color',
                [
                    'label'             => __('Colour', smw_slug),
                    'type'              => Controls_Manager::COLOR,
                    'scheme'            => [
                        'type'               => Color::get_type(),
                        'value'              => Color::COLOR_2,
                    ],
                    'condition'         =>[
                        'progress_bar_select_label_icon' =>'line_pin'
                    ],
                     'selectors'        => [
                    '{{WRAPPER}} .progress-bar-pin' => 'border-color: {{VALUE}};'
                ]
            ]
         );

        $this->add_responsive_control('progress_bar_pin_size',
            [
                    'label'	       => __('Size',smw_slug),
                    'type'             =>Controls_Manager::SLIDER,
                    'size_units'       => ['px', "em"],
                    'condition'        =>[
                        'progress_bar_select_label_icon' => 'line_pin'
                    ],
                    'selectors'         => [
                        '{{WRAPPER}} .progress-bar-pin' => 'border-left-width: {{SIZE}}{{UNIT}};'
                        ]
            ]
        );

        $this->add_responsive_control('progress_bar_pin_height',
            [
                    'label'	       => __('Height',smw_slug),
                    'type'             =>Controls_Manager::SLIDER,
                    'size_units'       => ['px', "em"],
                    'condition'        =>[
                        'progress_bar_select_label_icon' => 'line_pin'
                    ],
                    'selectors'         => [
                        '{{WRAPPER}} .progress-bar-pin' => 'height: {{SIZE}}{{UNIT}};'
                        ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section('icon_style',
            [
                'label'             => __('Icon', smw_slug),
                'tab'               => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'layout_type'     => 'circle'
                ]
            ]
        );

        $this->add_control('icon_color',
            [
                'label'         => __('Colour', smw_slug),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .progress-bar-circle-icon' => 'color: {{VALUE}};',
                ],
                'condition'     => [
                    'icon_type'     => 'icon'
                ]
            ]
        );

        $this->add_control('icon_background_color',
            [
                'label'         => __('Background Colour', smw_slug),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .progress-bar-circle-icon' => 'background-color: {{VALUE}};',
                ],
                'condition'     => [
                    'icon_type!'     => 'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'icon_border',
                'selector'      => '{{WRAPPER}} .progress-bar-circle-icon',
            ]
        );
        
        $this->add_responsive_control('icon_border_radius',
            [
                'label'         => __('Border Radius', smw_slug),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .progress-bar-circle-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control('icon_padding',
            [
                'label'         => __('Padding', smw_slug),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .progress-bar-circle-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('progress_bar_left_label');
        $this->add_inline_editing_attributes('progress_bar_right_label');
        
        $length = isset ( $settings['progress_bar_progress_percentage']['size'] ) ? $settings['progress_bar_progress_percentage']['size'] : $settings['progress_bar_progress_percentage'];
        
        $style = $settings['progress_bar_progress_style'];
        $type  = $settings['layout_type'];

        $progress_bar_settings = [
            'progress_length'   => $length,
            'speed'             => !empty( $settings['progress_bar_speed'] ) ? $settings['progress_bar_speed'] : 1000,
            'type'              => $type,
        ];

        if( 'dots' === $type ) {
            $progress_bar_settings['dot'] = $settings['dot_size']['size'];
            $progress_bar_settings['spacing'] = $settings['dot_spacing']['size'];
        }

        $this->add_render_attribute( 'progress-bar', 'class', 'progress-bar-container' );

        if( 'stripped' === $style ) {
            $this->add_render_attribute( 'progress-bar', 'class', 'progress-bar-striped' );
        } elseif( 'gradient' === $style ) {
            $this->add_render_attribute( 'progress-bar', 'class', 'progress-bar-gradient' );
            $progress_bar_settings['gradient'] = $settings['gradient_colors'];
        }
        
        if( 'yes' === $settings['progress_bar_progress_animation'] ) {
            $this->add_render_attribute( 'progress-bar', 'class', 'progress-bar-active' );
        }

        $this->add_render_attribute( 'progress-bar', 'data-settings', wp_json_encode($progress_bar_settings) );
        
        if( 'circle' !== $type ) {
            $this->add_render_attribute( 'wrap', 'class', 'progress-bar-bar-wrap' );

            if( 'dots' === $type ) {
                $this->add_render_attribute( 'wrap', 'class', 'progress-bar-dots' );
            }

        } else {
            $this->add_render_attribute( 'wrap', 'class', 'progress-bar-circle-wrap' );

            $icon_type = $settings['icon_type'];

            if( 'animation' === $icon_type ) {
                $this->add_render_attribute( 'progress_lottie', [
                    'class' => [
                        'progress-bar-circle-icon',
                        'smw-lottie-animation'
                    ],
                    'data-lottie-url' => $settings['lottie_url'],
                    'data-lottie-loop' => $settings['lottie_loop'],
                    'data-lottie-reverse' => $settings['lottie_reverse']
                ]);
            }

        }

    ?>

   <div <?php echo $this->get_render_attribute_string( 'progress-bar' ); ?>>

        <?php if ($settings['progress_bar_select_label'] === 'left_right_labels') :?>
            <p class="progress-bar-left-label"><span <?php echo $this->get_render_attribute_string('progress_bar_left_label'); ?>><?php echo $settings['progress_bar_left_label'];?></span></p>
            <p class="progress-bar-right-label"><span <?php echo $this->get_render_attribute_string('progress_bar_right_label'); ?>><?php echo $settings['progress_bar_right_label'];?></span></p>
        <?php endif;?>

        <?php if ($settings['progress_bar_select_label'] === 'more_labels') : ?>
            <div class="progress-bar-container-label" style="position:relative;">
            <?php foreach($settings['progress_bar_multiple_label'] as $item){
                if( $this->get_settings('progress_bar_more_labels_align') === 'center' ) {
                    if($settings['progress_bar_space_percentage_switcher'] === 'yes'){
                       if( $settings['progress_bar_select_label_icon'] === 'arrow' ) { 
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-45%);">'.$item['text'].' <span class="progress-bar-percentage">'.$item['number'].'%</span></p><p class="progress-bar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif($settings['progress_bar_select_label_icon'] === 'line_pin') {
                           echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-45%);">'.$item['text'].' <span class="progress-bar-percentage">'.$item['number'].'%</span></p><p class="progress-bar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-45%);">'.$item['text'].' <span class="progress-bar-percentage">'.$item['number'].'%</span></p></div>';
                        }
                    } else{
                        if($settings['progress_bar_select_label_icon'] === 'arrow') { 
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-45%);">'.$item['text'].'</p><p class="progress-bar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif( $settings['progress_bar_select_label_icon'] === 'line_pin') {
                           echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-45%)">'.$item['text'].'</p><p class="progress-bar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-45%);">'.$item['text'].'</p></div>';
                        }
                    }
                } elseif($this->get_settings('progress_bar_more_labels_align') === 'left' ) {
                    if($settings['progress_bar_space_percentage_switcher'] === 'yes'){
                       if($settings['progress_bar_select_label_icon'] === 'arrow') { 
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-10%);">'.$item['text'].' <span class="progress-bar-percentage">'.$item['number'].'%</span></p><p class="progress-bar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif($settings['progress_bar_select_label_icon'] === 'line_pin'){
                           echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-2%);">'.$item['text'].' <span class="progress-bar-percentage">'.$item['number'].'%</span></p><p class="progress-bar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-2%);">'.$item['text'].' <span class="progress-bar-percentage">'.$item['number'].'%</span></p></div>';
                        }
                    } else{
                        if($settings['progress_bar_select_label_icon'] === 'arrow') { 
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-10%);">'.$item['text'].'</p><p class="progress-bar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif($settings['progress_bar_select_label_icon'] === 'line_pin'){
                           echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-2%);">'.$item['text'].'</p><p class="progress-bar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-2%);">'.$item['text'].'</p></div>';
                        }
                    }
                } else {
                    if($settings['progress_bar_space_percentage_switcher'] === 'yes'){
                       if($settings['progress_bar_select_label_icon'] === 'arrow') { 
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-82%);">'.$item['text'].' <span class="progress-bar-percentage">'.$item['number'].'%</span></p><p class="progress-bar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif($settings['progress_bar_select_label_icon'] === 'line_pin'){
                           echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-95%);">'.$item['text'].' <span class="progress-bar-percentage">'.$item['number'].'%</span></p><p class="progress-bar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-96%);">'.$item['text'].' <span class="progress-bar-percentage">'.$item['number'].'%</span></p></div>';
                        }
                    } else{
                        if($settings['progress_bar_select_label_icon'] === 'arrow') { 
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-71%);">'.$item['text'].'</p><p class="progress-bar-arrow" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } elseif($settings['progress_bar_select_label_icon'] === 'line_pin'){
                           echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-97%);">'.$item['text'].'</p><p class="progress-bar-pin" style="left:'.$item['number'].'%; transform:translateX(50%);"></p></div>';
                        } else {
                            echo '<div class ="progress-bar-multiple-label" style="left:'.$item['number'].'%;"><p class = "progress-bar-center-label" style="transform:translateX(-96%);">'.$item['text'].'</p></div>';
                        }
                    }
                }

               } ?>
            </div>
        <?php endif; ?>

        <div class="clearfix"></div>
        <div <?php echo $this->get_render_attribute_string( 'wrap' ); ?>>
            <?php if( 'line' === $type ) : ?>
                <div class="progress-bar-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
            <?php elseif( 'circle' === $type ): ?>
                <div class="progress-bar-circle-base"></div>
                <div class="progress-bar-circle">
                    <div class="progress-bar-circle-left"></div>
                    <div class="progress-bar-circle-right"></div>
                </div>
                <div class="progress-bar-circle-content">
                    <?php if( !empty( $settings['icon_select']['value'] ) || ! empty( $settings['image_upload']['url'] ) || !empty( $settings['lottie_url'] )  ) : ?>
                        <?php if('icon' === $icon_type ):
                            Icons_Manager::render_icon( $settings['icon_select'], [ 'class'=> 'progress-bar-circle-icon', 'aria-hidden' => 'true' ] );
                        elseif( 'image' === $icon_type ) : ?>
                            <img class="progress-bar-circle-icon" src="<?php echo $settings['image_upload']['url']; ?>">
                        <?php else: ?>
                            <div <?php echo $this->get_render_attribute_string( 'progress_lottie' ); ?>></div>
                        <?php endif;?>
                    <?php endif; ?>
                <p class="progress-bar-left-label">
                    <span <?php echo $this->get_render_attribute_string('progress_bar_left_label'); ?>>
                        <?php echo $settings['progress_bar_left_label'];?>
                    </span>
                </p>
                <?php if( 'yes' === $settings['show_percentage_value'] ) : ?>
                    <p class="progress-bar-right-label">
                        <span <?php echo $this->get_render_attribute_string('progress_bar_right_label'); ?>>0%</span>
                    </p>
                <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_progress_bar() );