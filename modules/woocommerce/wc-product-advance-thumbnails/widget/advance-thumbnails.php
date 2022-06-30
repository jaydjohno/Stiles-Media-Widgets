<?php

/**
 * Stiles Media Widgets Advance Thumbnails.
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

class stiles_wc_advance_thumbnails extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'advance-thumbnails-style', plugin_dir_url( __FILE__ ) . '../css/advance-thumbnails.css');
    }
    
    public function get_name() 
    {
        return 'stiles-advance-thumbnails';
    }
    
    public function get_title() 
    {
        return __( 'Product: Advance Thumbnails', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-images';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 
            'advance-thumbnails-style',
            'slick-css',
        ];
    }
    
    protected function register_controls() 
    {
        $this->product_image();
        
        $this->product_slider();

        $this->product_main_image();

        $this->product_badge();
        
        $this->product_thumbnails();

        $this->slider_button();
    }
    
    protected function product_image()
    {
        $this->start_controls_section(
            'product_thumbnails_content',
            array(
                'label' => __( 'Product Image', smw_slug ),
                'tab' => Controls_Manager::TAB_CONTENT,
            )
        );
            $this->add_control(
                'layout_style',
                [
                    'label' => __( 'Layout', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'tab',
                    'options' => [
                        'tab'       => __( 'Tab', smw_slug ),
                        'gallery'   => __( 'Gallery', smw_slug ),
                        'slider'    => __( 'Slider', smw_slug ),
                        'single'    => __( 'Single Thumbnails', smw_slug ),
                    ],
                ]
            );

            $this->add_control(
                'tab_thumbnails_position',
                [
                    'label'   => __( 'Thumbnails Position', smw_slug ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'top' => [
                            'title' => __( 'Top', smw_slug ),
                            'icon'  => 'eicon-v-align-top',
                        ],
                        'bottom' => [
                            'title' => __( 'Bottom', smw_slug ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'     => 'bottom',
                    'toggle'      => false,
                    'condition'=>[
                        'layout_style' => 'tab',
                    ],
                ]
            );

            $this->add_control(
                'hide_sale_badge',
                [
                    'label'     => __( 'Sale Badge Hide', smw_slug ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} span.onsale' => 'display: none;',
                    ],
                ]
            );

            $this->add_control(
                'hide_custom_badge',
                [
                    'label'     => __( 'Custom Badge Hide', smw_slug ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-product-gallery__image .ht-product-label.ht-product-label-left' => 'display: none;',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_slider()
    {
        // Product slider setting
        $this->start_controls_section(
            'stiles-thumbnails-slider',
            [
                'label' => __( 'Slider Option', smw_slug ),
                'condition' => [
                    'layout_style' => 'slider',
                ]
            ]
        );

            $this->add_control(
                'slitems',
                [
                    'label' => __( 'Slider Items', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default' => 3
                ]
            );

            $this->add_control(
                'slarrows',
                [
                    'label' => __( 'Slider Arrow', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'sldots',
                [
                    'label' => __( 'Slider dots', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no'
                ]
            );

            $this->add_control(
                'slpause_on_hover',
                [
                    'type' => Controls_Manager::SWITCHER,
                    'label_off' => __('No', smw_slug),
                    'label_on' => __('Yes', smw_slug),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'label' => __('Pause on Hover?', smw_slug),
                ]
            );

            $this->add_control(
                'slautoplay',
                [
                    'label' => __( 'Slider auto play', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'separator' => 'before',
                    'default' => 'no'
                ]
            );

            $this->add_control(
                'slautoplay_speed',
                [
                    'label' => __('Autoplay speed', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 3000,
                    'condition' => [
                        'slautoplay' => 'yes',
                    ]
                ]
            );


            $this->add_control(
                'slanimation_speed',
                [
                    'label' => __('Autoplay animation speed', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 300,
                    'condition' => [
                        'slautoplay' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slscroll_columns',
                [
                    'label' => __('Slider item to scroll', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default' => 3,
                ]
            );

            $this->add_control(
                'heading_tablet',
                [
                    'label' => __( 'Tablet', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_control(
                'sltablet_display_columns',
                [
                    'label' => __('Slider Items', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 2,
                ]
            );

            $this->add_control(
                'sltablet_scroll_columns',
                [
                    'label' => __('Slider item to scroll', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 2,
                ]
            );

            $this->add_control(
                'sltablet_width',
                [
                    'label' => __('Tablet Resolution', smw_slug),
                    'description' => __('The resolution to tablet.', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 750,
                ]
            );

            $this->add_control(
                'heading_mobile',
                [
                    'label' => __( 'Mobile Phone', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_control(
                'slmobile_display_columns',
                [
                    'label' => __('Slider Items', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                ]
            );

            $this->add_control(
                'slmobile_scroll_columns',
                [
                    'label' => __('Slider item to scroll', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                ]
            );

            $this->add_control(
                'slmobile_width',
                [
                    'label' => __('Mobile Resolution', smw_slug),
                    'description' => __('The resolution to mobile.', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 480,
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_main_image()
    {
        // Product Main Image Style
        $this->start_controls_section(
            'product_image_style_section',
            [
                'label' => __( 'Image', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'layout_style' => 'tab',
                ],
            ]
        );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_image_border',
                    'label' => __( 'Product image border', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} .sm-product-thumbnails .woocommerce-product-gallery__image',
                ]
            );

            $this->add_responsive_control(
                'product_image_border_radius',
                [
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .sm-product-thumbnails .woocommerce-product-gallery__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '.woocommerce {{WRAPPER}} .sm-product-thumbnails .woocommerce-product-gallery__image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .sm-product-thumbnails .woocommerce-product-gallery__image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_badge()
    {
        // Product Badge Style
        $this->start_controls_section(
            'product_badge_style_section',
            [
                'label' => __( 'Product Badge', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_badge_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_4,
                    'selector' => '.woocommerce {{WRAPPER}} span.onsale,{{WRAPPER}} .woocommerce-product-gallery__image .ht-product-label.ht-product-label-left',
                ]
            );

            $this->add_control(
                'product_badge_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' =>'#ffffff',
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} span.onsale' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .woocommerce-product-gallery__image .ht-product-label.ht-product-label-left' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_badge_bg_color',
                [
                    'label' => __( 'Background Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' =>'#23252a',
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} span.onsale' => 'background-color: {{VALUE}} !important;',
                        '{{WRAPPER}} .woocommerce-product-gallery__image .ht-product-label.ht-product-label-left' => 'background-color: {{VALUE}} !important;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_badge_border_radius',
                [
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .woocommerce-product-gallery__image .ht-product-label.ht-product-label-left' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_badge_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .woocommerce-product-gallery__image .ht-product-label.ht-product-label-left' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_thumbnails()
    {
        // Product Thumbnails Image Style
        $this->start_controls_section(
            'product_image_thumbnails_style_section',
            [
                'label' => __( 'Thumbnails Image', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_thumbnais_image_border',
                    'label' => __( 'Product image border', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} .sm-product-thumbnails ul.stiles-thumbanis-image li img, .woocommerce {{WRAPPER}} .sm-product-thumbnails .sm-single-gallery img, .woocommerce {{WRAPPER}} .sm-thumbnails-slider .sm-single-slider img,.woocommerce {{WRAPPER}} .woocommerce-product-gallery__image img',
                ]
            );

            $this->add_responsive_control(
                'product_thumbnais_image_border_radius',
                [
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .sm-product-thumbnails ul.stiles-thumbanis-image li img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '.woocommerce {{WRAPPER}} .sm-product-thumbnails .sm-single-gallery img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '.woocommerce {{WRAPPER}} .sm-thumbnails-slider .sm-single-slider img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '.woocommerce {{WRAPPER}} .woocommerce-product-gallery__image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_product_thumbnais_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .sm-product-thumbnails ul.stiles-thumbanis-image li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '.woocommerce {{WRAPPER}} .sm-product-thumbnails .sm-single-gallery' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '.woocommerce {{WRAPPER}} .sm-thumbnails-slider .sm-single-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '.woocommerce {{WRAPPER}} .woocommerce-product-gallery__image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function slider_button()
    {
        // Slider Button style
        $this->start_controls_section(
            'products-slider-controller-style',
            [
                'label' => __( 'Slider Controller Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_style' => 'slider',
                ]
            ]
        );

            $this->start_controls_tabs('product_sliderbtn_style_tabs');

                // Slider Button style Normal
                $this->start_controls_tab(
                    'product_sliderbtn_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );

                    $this->add_control(
                        'button_style_heading',
                        [
                            'label' => __( 'Navigation Arrow', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                    $this->add_control(
                        'button_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#333333',
                            'selectors' => [
                                '{{WRAPPER}} .sm-thumbnails-slider .slick-arrow' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .sm-thumbnails-slider .slick-arrow' => 'background-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .sm-thumbnails-slider .slick-arrow',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .sm-thumbnails-slider .slick-arrow' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'button_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-thumbnails-slider .slick-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_style_dots_heading',
                        [
                            'label' => __( 'Navigation Dots', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                        $this->add_control(
                            'dots_bg_color',
                            [
                                'label' => __( 'Background Colour', smw_slug ),
                                'type' => Controls_Manager::COLOR,
                                'scheme' => [
                                    'type' => Color::get_type(),
                                    'value' => Color::COLOR_1,
                                ],
                                'default' =>'#ffffff',
                                'selectors' => [
                                    '{{WRAPPER}} .sm-thumbnails-slider .slick-dots li button' => 'background-color: {{VALUE}} !important;',
                                ],
                            ]
                        );

                        $this->add_group_control(
                            Group_Control_Border::get_type(),
                            [
                                'name' => 'dots_border',
                                'label' => __( 'Border', smw_slug ),
                                'selector' => '{{WRAPPER}} .sm-thumbnails-slider .slick-dots li button',
                            ]
                        );

                        $this->add_responsive_control(
                            'dots_border_radius',
                            [
                                'label' => __( 'Border Radius', smw_slug ),
                                'type' => Controls_Manager::DIMENSIONS,
                                'selectors' => [
                                    '{{WRAPPER}} .sm-thumbnails-slider .slick-dots li button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                                ],
                            ]
                        );

                $this->end_controls_tab();// Normal button style end

                // Button style Hover
                $this->start_controls_tab(
                    'product_sliderbtn_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );

                    $this->add_control(
                        'button_style_arrow_heading',
                        [
                            'label' => __( 'Navigation', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                    $this->add_control(
                        'button_hover_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#23252a',
                            'selectors' => [
                                '{{WRAPPER}} .sm-thumbnails-slider .slick-arrow:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_hover_bg_color',
                        [
                            'label' => __( 'Background', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .sm-thumbnails-slider .slick-arrow:hover' => 'background-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .sm-thumbnails-slider .slick-arrow:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_hover_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .sm-thumbnails-slider .slick-arrow:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_style_dotshov_heading',
                        [
                            'label' => __( 'Navigation Dots', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                        $this->add_control(
                            'dots_hover_bg_color',
                            [
                                'label' => __( 'Background Colour', smw_slug ),
                                'type' => Controls_Manager::COLOR,
                                'scheme' => [
                                    'type' => Color::get_type(),
                                    'value' => Color::COLOR_1,
                                ],
                                'default' =>'#282828',
                                'selectors' => [
                                    '{{WRAPPER}} .sm-thumbnails-slider .slick-dots li button:hover' => 'background-color: {{VALUE}} !important;',
                                    '{{WRAPPER}} .sm-thumbnails-slider .slick-dots li.slick-active button' => 'background-color: {{VALUE}} !important;',
                                ],
                            ]
                        );

                        $this->add_group_control(
                            Group_Control_Border::get_type(),
                            [
                                'name' => 'dots_border_hover',
                                'label' => __( 'Border', smw_slug ),
                                'selector' => '{{WRAPPER}} .sm-thumbnails-slider .slick-dots li button:hover',
                            ]
                        );

                        $this->add_responsive_control(
                            'dots_border_radius_hover',
                            [
                                'label' => __( 'Border Radius', smw_slug ),
                                'type' => Controls_Manager::DIMENSIONS,
                                'selectors' => [
                                    '{{WRAPPER}} .sm-thumbnails-slider .slick-dots li button:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                                ],
                            ]
                        );

                $this->end_controls_tab();// Hover button style end

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function render() 
    {
        $settings  = $this->get_settings_for_display();

        $this->add_render_attribute( 'sm_product_thumbnails_attr', 'class', 'smpro-product-thumbnails images thumbnails-tab-position-'.$settings['tab_thumbnails_position'] );
        $this->add_render_attribute( 'sm_product_thumbnails_attr', 'class', 'thumbnails-layout-'.$settings['layout_style'] );

        // Slider Options
        $is_rtl = is_rtl();
        $direction = $is_rtl ? 'rtl' : 'ltr';
        $slider_settings = [
            'arrows' => ('yes' === $settings['slarrows']),
            'dots' => ('yes' === $settings['sldots']),
            'autoplay' => ('yes' === $settings['slautoplay']),
            'autoplay_speed' => absint($settings['slautoplay_speed']),
            'animation_speed' => absint($settings['slanimation_speed']),
            'pause_on_hover' => ('yes' === $settings['slpause_on_hover']),
            'rtl' => $is_rtl,
        ];

        $slider_responsive_settings = [
            'product_items' => $settings['slitems'],
            'scroll_columns' => $settings['slscroll_columns'],
            'tablet_width' => $settings['sltablet_width'],
            'tablet_display_columns' => $settings['sltablet_display_columns'],
            'tablet_scroll_columns' => $settings['sltablet_scroll_columns'],
            'mobile_width' => $settings['slmobile_width'],
            'mobile_display_columns' => $settings['slmobile_display_columns'],
            'mobile_scroll_columns' => $settings['slmobile_scroll_columns'],

        ];
        $slider_settings = array_merge( $slider_settings, $slider_responsive_settings );

        if( Plugin::instance()->editor->is_edit_mode() )
        {
            $product = wc_get_product( smw_get_last_product_id() );
        } else
        {
            global $product, $post;
        }
        if ( empty( $product ) ) 
        { 
            return; 
        }

        $gallery_images_ids = $product->get_gallery_image_ids() ? $product->get_gallery_image_ids() : array();
        
        if ( $product->get_image_id() )
        {
            $gallery_images_ids = array( 'smthumbnails_id' => $product->get_image_id() ) + $gallery_images_ids;
        }
        ?>

        <?php if( Plugin::instance()->editor->is_edit_mode() )
        { 
            echo '<div class="product">'; 
        } ?>
        
        <div <?php echo $this->get_render_attribute_string( 'sm_product_thumbnails_attr' ); ?>>
            <div class="sm-thumbnails-image-area">
                <?php if( $settings['layout_style'] == 'tab' ): ?>

                    <?php if( $settings['tab_thumbnails_position'] == 'left' || $settings['tab_thumbnails_position'] == 'top' ): ?>
                        <ul class="stiles-thumbanis-image">
                            <?php
                                foreach ( $gallery_images_ids as $thkey => $gallery_attachment_id ) 
                                {
                                    echo '<li data-smimage="'.wp_get_attachment_image_url( $gallery_attachment_id, 'woocommerce_single' ).'">' . wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' ) . '</li>';
                                }
                            ?>
                        </ul>
                    <?php endif; ?>
                    <div class="woocommerce-product-gallery__image">
                        <?php
                            if( Plugin::instance()->editor->is_edit_mode() )
                            {
                                if ( $product->is_on_sale() ) 
                                { 
                                    echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', smw_slug ) . '</span>', $post, $product ); 
                                }
                            }else{
                                woocommerce_show_product_sale_flash();
                            }

                            if( function_exists( 'stiles_custom_product_badge' ) )
                            {
                                stiles_custom_product_badge();
                            }
                            echo wp_get_attachment_image( reset( $gallery_images_ids ), 'woocommerce_single', '', array( 'class' => 'wp-post-image' ) );
                        ?>
                    </div>
                    <?php if( $settings['tab_thumbnails_position'] == 'right' || $settings['tab_thumbnails_position'] == 'bottom' ): ?>
                        <ul class="stiles-thumbanis-image">
                            <?php
                                foreach ( $gallery_images_ids as $gallery_attachment_id ) 
                                {
                                    echo '<li data-smimage="'.wp_get_attachment_image_url( $gallery_attachment_id, 'woocommerce_single' ).'">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' ).'</li>';
                                }
                            ?>
                        </ul>
                    <?php endif; ?>
                <?php elseif( $settings['layout_style'] == 'gallery' ): ?>
                    <div class="woocommerce-product-gallery__image sm-single-gallery">
                        <?php
                            if( Plugin::instance()->editor->is_edit_mode() )
                            {
                                if ( $product->is_on_sale() ) 
                                { 
                                    echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', smw_slug ) . '</span>', $post, $product ); 
                                }
                            }else
                            {
                                woocommerce_show_product_sale_flash();
                            }
                            if( function_exists( 'stiles_custom_product_badge' ) )
                            {
                                stiles_custom_product_badge();
                            }
                            echo wp_get_attachment_image( reset( $gallery_images_ids ), 'woocommerce_single', '', array( 'class' => 'wp-post-image' ) );
                        ?>
                    </div>
                    <?php
                        $imagecount = sizeof( $gallery_images_ids );
                        
                        foreach ( $gallery_images_ids as $thkey => $gallery_attachment_id ) 
                        {
                            if( $thkey === 'smthumbnails_id' || $imagecount == 1 )
                            {
                                continue;
                            }else{
                                echo '<div class="sm-single-gallery">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_single' ).'</div>';
                            }
                        }
                    ?>
                <?php elseif( $settings['layout_style'] == 'slider' ): ?>
                    <div class="sm-thumbnails-slider" data-settings='<?php echo wp_json_encode( $slider_settings );  ?>'>
                        <?php
                            foreach ( $gallery_images_ids as $gallery_attachment_id ) 
                            {
                                echo '<div class="sm-single-slider">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_single' ).'</div>';
                            }
                        ?>
                    </div>
                <?php else:?>
                    <div class="woocommerce-product-gallery__image">
                        <?php
                            if( Plugin::instance()->editor->is_edit_mode() )
                            {
                                if ( $product->is_on_sale() ) 
                                { 
                                    echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', smw_slug ) . '</span>', $post, $product ); 
                                }
                            }else{
                                woocommerce_show_product_sale_flash();
                            }
                            if( function_exists( 'stiles_custom_product_badge' ) )
                            {
                                stiles_custom_product_badge();
                            }
                            
                            echo wp_get_attachment_image( reset( $gallery_images_ids ), 'woocommerce_single', '', array( 'class' => 'wp-post-image' ) );
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if( Plugin::instance()->editor->is_edit_mode() )
        { 
            echo '</div>'; 
        } 
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_advance_thumbnails() );