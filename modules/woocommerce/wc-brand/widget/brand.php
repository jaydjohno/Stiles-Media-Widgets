<?php

/**
 * Stiles Media Widgets Brand Logo.
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
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;

class stiles_wc_brand_logo extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'brand-logo-style', plugin_dir_url( __FILE__ ) . '../css/brand-logo.css');
    }
    
    public function get_name() 
    {
        return 'stiles-product-brand';
    }
    
    public function get_title() 
    {
        return __( 'Product: Brand Logo', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-logo';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [
            'slick-css',
            'brand-logo-style',
        ];
    }
    
    public function get_script_depends()
    {
        return [
            'slick-js',
            'product-slider-js',
        ];
    }
    
    protected function register_controls() 
    {
        $this->brand_logo_control();
        
        $this->brand_option_control();
        
        $this->brand_slider_controls();
        
        $this->brand_style_controls();
        
        $this->brand_image_style();
        
        $this->brand_button_style();
    }
    
    protected function brand_logo_control()
    {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__( 'Brand Logo', smw_slug ),
            )
        );
            
            $this->add_control(
                'layout',
                [
                    'label' => esc_html__( 'Select Layout', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'default',
                    'options' => [
                        'default' => esc_html__('Default',smw_slug),
                        'slider' => esc_html__('Slider',smw_slug),
                    ],
                    'label_block' => true,
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'brand_title',
                [
                    'label' => esc_html__( 'Brand Title', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Default title', smw_slug ),
                    'placeholder' => esc_html__( 'Type your title here', smw_slug ),
                ]
            );

            $repeater->add_control(
                'brand_logo',
                [
                    'label' => esc_html__( 'Choose Image', smw_slug ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => smw_url . 'assets/images/brand.png',
                    ],
                ]
            );

            $repeater->add_control(
                'brand_link',
                [
                    'label' => esc_html__( 'Brand Link', smw_slug ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => esc_html__( 'https://your-link.com', smw_slug ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
            );

            $this->add_control(
                'brand_list',
                [
                    'type'    => Controls_Manager::REPEATER,
                    'fields'  => array_values( $repeater->get_controls() ),
                    'default' => [
                        [
                            'brand_title' => esc_html__( 'Brand Title', smw_slug ),
                            'brand_link' => '',
                        ]
                    ],
                    'title_field' => '{{{ brand_title }}}',
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'brandsize',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function brand_option_control()
    {
        /* Brand Options */
        $this->start_controls_section(
            'brand_option',
            array(
                'label' => esc_html__( 'Brand Option', smw_slug ),
                'condition'=>[
                    'layout!'=>'slider',
                ],
            )
        );
            
            $this->add_responsive_control(
                'column',
                [
                    'label' => esc_html__( 'Columns', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '6',
                    'options' => [
                        '1' => esc_html__( 'One', smw_slug ),
                        '2' => esc_html__( 'Two', smw_slug ),
                        '3' => esc_html__( 'Three', smw_slug ),
                        '4' => esc_html__( 'Four', smw_slug ),
                        '5' => esc_html__( 'Five', smw_slug ),
                        '6' => esc_html__( 'Six', smw_slug ),
                        '7' => esc_html__( 'Seven', smw_slug ),
                        '8' => esc_html__( 'Eight', smw_slug ),
                        '9' => esc_html__( 'Nine', smw_slug ),
                        '10'=> esc_html__( 'Ten', smw_slug ),
                    ],
                    'label_block' => true,
                    'prefix_class' => 'sm-columns%s-',
                ]
            );

            $this->add_control(
                'no_gutters',
                [
                    'label' => esc_html__( 'No Gutters', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Yes', smw_slug ),
                    'label_off' => esc_html__( 'No', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_responsive_control(
                'item_space',
                [
                    'label' => esc_html__( 'Space', smw_slug ),
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
                        'size' => 15,
                    ],
                    'condition'=>[
                        'no_gutters!'=>'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-row > [class*="col-"]' => 'padding: 0  {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function brand_slider_controls()
    {
        // Slider setting
        $this->start_controls_section(
            'brand_slider',
            [
                'label' => esc_html__( 'Slider Option', smw_slug ),
                'condition' => [
                    'layout' => 'slider',
                ]
            ]
        );

            $this->add_control(
                'slitems',
                [
                    'label' => esc_html__( 'Slider Items', smw_slug ),
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
                    'label' => esc_html__( 'Slider Arrow', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'sldots',
                [
                    'label' => esc_html__( 'Slider dots', smw_slug ),
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
                    'label' => esc_html__( 'Slider auto play', smw_slug ),
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
    
    protected function brand_style_controls()
    {
        // Brand Style Section
        $this->start_controls_section(
            'brand_style',
            [
                'label' => esc_html__( 'Brand', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'brand_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .sm-single-brand',
                ]
            );

            $this->add_responsive_control(
                'brand_border_radius',
                [
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-brand' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'brand_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-brand' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'brand_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-brand' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'brand_align',
                [
                    'label'   => __( 'Alignment', smw_slug ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left'    => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'fa fa-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-brand'   => 'text-align: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function brand_image_style()
    {
        $this->start_controls_section(
            'brand_image_style',
            [
                'label' => esc_html__( 'Brand Image', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'brand_img_border',
                    'label' => esc_html__( 'Image Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .sm-single-brand img',
                ]
            );

            $this->add_responsive_control(
                'brand_img_border_radius',
                [
                    'label' => esc_html__( 'Image Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-single-brand img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function brand_button_style()
    {
        $this->start_controls_section(
            'slider_controller_style',
            [
                'label' => esc_html__( 'Slider Controller Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout' => 'slider',
                ]
            ]
        );

            $this->start_controls_tabs('product_sliderbtn_style_tabs');

                // Slider Button style Normal
                $this->start_controls_tab(
                    'product_sliderbtn_style_normal_tab',
                    [
                        'label' => esc_html__( 'Normal', smw_slug ),
                    ]
                );

                    $this->add_control(
                        'button_style_heading',
                        [
                            'label' => esc_html__( 'Navigation Arrow', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                    $this->add_responsive_control(
                        'nvigation_position',
                        [
                            'label' => esc_html__( 'Position', smw_slug ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 5,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => '%',
                                'size' => 50,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow' => 'top: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_color',
                        [
                            'label' => esc_html__( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' => '#dddddd',
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_bg_color',
                        [
                            'label' => esc_html__( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow' => 'background-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_border',
                            'label' => esc_html__( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .product-slider .slick-arrow',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'button_padding',
                        [
                            'label' => esc_html__( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_style_dots_heading',
                        [
                            'label' => esc_html__( 'Navigation Dots', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                        $this->add_responsive_control(
                            'dots_position',
                            [
                                'label' => esc_html__( 'Position', smw_slug ),
                                'type' => Controls_Manager::SLIDER,
                                'size_units' => [ 'px', '%' ],
                                'range' => [
                                    'px' => [
                                        'min' => 0,
                                        'max' => 1000,
                                        'step' => 5,
                                    ],
                                    '%' => [
                                        'min' => 0,
                                        'max' => 100,
                                    ],
                                ],
                                'default' => [
                                    'unit' => '%',
                                    'size' => 50,
                                ],
                                'selectors' => [
                                    '{{WRAPPER}} .product-slider .slick-dots' => 'left: {{SIZE}}{{UNIT}};',
                                ],
                            ]
                        );

                        $this->add_control(
                            'dots_bg_color',
                            [
                                'label' => esc_html__( 'Background Colour', smw_slug ),
                                'type' => Controls_Manager::COLOR,
                                'scheme' => [
                                    'type' => Color::get_type(),
                                    'value' => Color::COLOR_1,
                                ],
                                'default' =>'#ffffff',
                                'selectors' => [
                                    '{{WRAPPER}} .product-slider .slick-dots li button' => 'background-color: {{VALUE}} !important;',
                                ],
                            ]
                        );

                        $this->add_group_control(
                            Group_Control_Border::get_type(),
                            [
                                'name' => 'dots_border',
                                'label' => esc_html__( 'Border', smw_slug ),
                                'selector' => '{{WRAPPER}} .product-slider .slick-dots li button',
                            ]
                        );

                        $this->add_responsive_control(
                            'dots_border_radius',
                            [
                                'label' => esc_html__( 'Border Radius', smw_slug ),
                                'type' => Controls_Manager::DIMENSIONS,
                                'selectors' => [
                                    '{{WRAPPER}} .product-slider .slick-dots li button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                                ],
                            ]
                        );

                $this->end_controls_tab();// Normal button style end

                // Button style Hover
                $this->start_controls_tab(
                    'product_sliderbtn_style_hover_tab',
                    [
                        'label' => esc_html__( 'Hover', smw_slug ),
                    ]
                );


                    $this->add_control(
                        'button_style_arrow_heading',
                        [
                            'label' => esc_html__( 'Navigation', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                    $this->add_control(
                        'button_hover_color',
                        [
                            'label' => esc_html__( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#23252a',
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_hover_bg_color',
                        [
                            'label' => esc_html__( 'Background', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow:hover' => 'background-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_hover_border',
                            'label' => esc_html__( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .product-slider .slick-arrow:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );


                    $this->add_control(
                        'button_style_dotshov_heading',
                        [
                            'label' => esc_html__( 'Navigation Dots', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                        $this->add_control(
                            'dots_hover_bg_color',
                            [
                                'label' => esc_html__( 'Background Colour', smw_slug ),
                                'type' => Controls_Manager::COLOR,
                                'scheme' => [
                                    'type' => Color::get_type(),
                                    'value' => Color::COLOR_1,
                                ],
                                'default' =>'#282828',
                                'selectors' => [
                                    '{{WRAPPER}} .product-slider .slick-dots li button:hover' => 'background-color: {{VALUE}} !important;',
                                    '{{WRAPPER}} .product-slider .slick-dots li.slick-active button' => 'background-color: {{VALUE}} !important;',
                                ],
                            ]
                        );

                        $this->add_group_control(
                            Group_Control_Border::get_type(),
                            [
                                'name' => 'dots_border_hover',
                                'label' => esc_html__( 'Border', smw_slug ),
                                'selector' => '{{WRAPPER}} .product-slider .slick-dots li button:hover',
                            ]
                        );

                        $this->add_responsive_control(
                            'dots_border_radius_hover',
                            [
                                'label' => esc_html__( 'Border Radius', smw_slug ),
                                'type' => Controls_Manager::DIMENSIONS,
                                'selectors' => [
                                    '{{WRAPPER}} .product-slider .slick-dots li button:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                                ],
                            ]
                        );

                $this->end_controls_tab();// Hover button style end

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function render( $instance = [] ) 
    {
        $settings  = $this->get_settings_for_display();
        $column    = $this->get_settings_for_display('column');
        $brands    = $this->get_settings_for_display('brand_list');

        $columnval = 'sm-col-6';
        
        if( $column !='' )
        {
            $columnval = 'sm-col-'.$column;
        }

        $size = $settings['brandsize_size'];
        $image_size = Null;
        if( $size === 'custom' )
        {
            $image_size = [
                $settings['brandsize_custom_dimension']['width'],
                $settings['brandsize_custom_dimension']['height']
            ];
        }else
        {
            $image_size = $size;
        }
        
        $default_img = '<img src="' . smw_url . 'assets/images/brand.png'.'" alt="">';

        // Slider Options
        if( $settings['layout'] === 'slider' )
        {
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
        }

        if( is_array( $brands ) )
        {
            echo '<div class="wl-row '.( $settings['no_gutters'] === 'yes' ? 'wlno-gutters' : '' ).( $settings['layout'] === 'slider' ? 'product-slider' : '' ).'" data-settings=\''.( $settings['layout'] === 'slider' ? wp_json_encode( $slider_settings ) : '' ). '\'>';
            foreach ( $brands as $key => $brand ) 
            {
                if( !empty( $brand['brand_link']['url'] ) )
                {
                    $target = $brand['brand_link']['is_external'] ? ' target="_blank"' : '';
                    $nofollow = $brand['brand_link']['nofollow'] ? ' rel="nofollow"' : '';
                    $link = '<a href="'.esc_url( $brand['brand_link']['url'] ).'" '.$target.$nofollow.'>';
                }
                if( !empty( $brand['brand_logo']['id'] ) )
                {
                    $logo = wp_get_attachment_image( $brand['brand_logo']['id'], $image_size );
                }else
                {
                    $logo = $default_img;
                }
                ?>
                <div class="<?php echo esc_attr( esc_attr( $columnval ) ); ?>">
                    <?php if( !empty( $brand['brand_link']['url'] ) ) echo $link; ?>
                    <div class="sm-single-brand">
                        <?php echo $logo; ?>
                    </div>
                    <?php if( !empty( $brand['brand_link']['url'] ) ) echo '</a>'; ?>
                </div>
                <?php
            }
            echo '</div>';
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_brand_logo() );