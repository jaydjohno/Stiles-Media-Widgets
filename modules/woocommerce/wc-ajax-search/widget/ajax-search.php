<?php

/**
 * SMW WC Ajax Search.
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

class stiles_wc_ajax_search extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);
    }
    
    public function get_name()
    {
        return 'stiles-wc-ajax-search';
    }
    
    public function get_title()
    {
        return 'WC Ajax Search';
    }
    
    public function get_icon()
    {
        return 'eicon-site-search';
    }
    
    public function get_categories()
    {
        return [ 'stiles-media-category' ];
    }
    
    public function get_style_depends() 
    {
        return [ 'stiles-ajax-search' ];
    }
    
    public function get_script_depends() 
    {
        return [ 'stiles-ajax-search' ];
    }
    
    protected function search_form_content()
    {
        // Content Start
        $this->start_controls_section(
            'stiles-ajax-search-form',
            [
                'label' => esc_html__( 'Search Form', smw_slug ),
            ]
        );
            
            $this->add_control(
                'limit',
                [
                    'label' => __( 'Show Number of Products', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                    'default' => 10,
                ]
            );

            $this->add_control(
                'placeholder_text',
                [
                    'label'     => __( 'Placeholder Text', smw_slug ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => __( 'Search Products', smw_slug ),
                ]
            );

        $this->end_controls_section();
    }
    
    protected function search_form_style()
    {
        // Style tab section
        $this->start_controls_section(
            'search_form_input',
            [
                'label' => __( 'Input Box', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'search_form_input_text_color',
                [
                    'label'     => __( 'Text Color', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_widget_psa input[type="search"]'   => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'search_form_input_placeholder_color',
                [
                    'label'     => __( 'Placeholder Color', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_widget_psa input[type*="search"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .stiles_widget_psa input[type*="search"]::-moz-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .stiles_widget_psa input[type*="search"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'search_form_input_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .stiles_widget_psa input[type="search"]',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'search_form_input_background',
                    'label' => __( 'Background', smw_slug ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .stiles_widget_psa input[type="search"]',
                ]
            );

            $this->add_responsive_control(
                'search_form_input_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_widget_psa' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'search_form_input_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_widget_psa input[type="search"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'search_form_input_height',
                [
                    'label' => __( 'Height', smw_slug ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 43,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_widget_psa input[type="search"]' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'search_form_input_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .stiles_widget_psa input[type="search"]',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'search_form_input_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_widget_psa input[type="search"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function search_button()
    {
        // Submit Button
        $this->start_controls_section(
            'search_form_style_submit_button',
            [
                'label' => __( 'Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            // Button Tabs Start
            $this->start_controls_tabs('search_form_style_submit_tabs');

                // Start Normal Submit button tab
                $this->start_controls_tab(
                    'search_form_style_submit_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'search_form_submitbutton_text_color',
                        [
                            'label'     => __( 'Color', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_widget_psa button'   => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'search_form_submitbutton_typography',
                            'scheme' => Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}} .stiles_widget_psa button',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'search_form_submitbutton_background',
                            'label' => __( 'Background', smw_slug ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .stiles_widget_psa button',
                        ]
                    );

                    $this->add_responsive_control(
                        'search_form_submitbutton_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles_widget_psa button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'search_form_submitbutton_height',
                        [
                            'label' => __( 'Height', smw_slug ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 40,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles_widget_psa button' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'search_form_submitbutton_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .stiles_widget_psa button',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'search_form_submitbutton_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_widget_psa button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Normal submit Button tab end

                // Start Hover Submit button tab
                $this->start_controls_tab(
                    'search_form_style_submit_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'search_form_submitbutton_hover_text_color',
                        [
                            'label'     => __( 'Color', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_widget_psa button:hover'   => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'search_form_submitbutton_hover_background',
                            'label' => __( 'Background', smw_slug ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .stiles_widget_psa button:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'search_form_submitbutton_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .stiles_widget_psa button:hover',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'search_form_submitbutton_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_widget_psa button:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover Submit Button tab End

            $this->end_controls_tabs(); // Button Tabs End

        $this->end_controls_section();
    }
    
    protected function register_controls() 
    {
        $this->search_form_content();
        
        $this->search_form_style();

        $this->search_button();
    }
    
    protected function render() 
    {
        $settings  = $this->get_settings_for_display();
        
        $shortcode_atts = [
            'limit'         => 'limit="'.$settings[ 'limit' ].'"',
            'placeholder'   => 'placeholder="'.$settings[ 'placeholder_text' ].'"',
        ];
        
        echo do_shortcode( sprintf( '[stilessearch %s]', implode(' ', $shortcode_atts ) ) );
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_ajax_search() );