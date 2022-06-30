<?php

/**
 * Stiles Media Widgets Special Offer.
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
use Elementor\Utils;
use Elementor\Group_Control_Background;

class stiles_wc_special_offer extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'special-offer-style', plugin_dir_url( __FILE__ ) . '../css/special-offer.css');
    }
    
    public function get_name() 
    {
        return 'stiles-special-offer';
    }
    
    public function get_title() 
    {
        return __( 'Special Offer', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-image';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'special-offer-style' ];
    }
    
    protected function register_controls() 
    {
        $this->banner_content_control();
        
        $this->add_banner_style_control();
        
        $this->title_style_control();
        
        $this->banner_subtitle_control();
        
        $this->style_description_control();
        
        $this->offer_style_tab_control();
        
        $this->button_style_control();
        
        $this->style_offer_tag_control();
    }
    
    protected function banner_content_control()
    {
        $this->start_controls_section(
            'add_banner_content',
            [
                'label' => __( 'Banner', smw_slug ),
            ]
        );

            $this->add_control(
                'banner_content_pos',
                [
                    'label' => __( 'Content Position', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'center',
                    'options' => [
                        'top'   => __( 'Top', smw_slug ),
                        'center' => __( 'Center', smw_slug ),
                        'bottom' => __( 'Bottom', smw_slug ),
                        'left'   => __( 'Left', smw_slug ),
                        'right'  => __( 'Right', smw_slug ),
                    ],
                ]
            );

            $this->add_control(
                'banner_image',
                [
                    'label' => __( 'Image', smw_slug ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'banner_image_size',
                    'default' => 'large',
                    'separator' => 'none',
                ]
            );

            $this->add_control(
                'banner_title',
                [
                    'label' => __( 'Title', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( 'Banner Title', smw_slug ),
                ]
            );

            $this->add_control(
                'banner_sub_title',
                [
                    'label' => __( 'Sub Title', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( 'Banner Sub Title', smw_slug ),
                ]
            );

            $this->add_control(
                'banner_description',
                [
                    'label' => __( 'Description', smw_slug ),
                    'type' => Controls_Manager::TEXTAREA,
                    'placeholder' => __( 'Banner Description', smw_slug ),
                ]
            );

            $this->add_control(
                'banner_offer',
                [
                    'label' => __( 'Offer Amount', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( '50%', smw_slug ),
                ]
            );

            $this->add_control(
                'banner_offer_tag_line',
                [
                    'label' => __( 'Offer Tag Line', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( 'Off', smw_slug ),
                ]
            );

            $this->add_control(
                'banner_link',
                [
                    'label' => __( 'Banner Link', smw_slug ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', smw_slug ),
                    'show_external' => true,
                    'default' => [
                        'url' => '#',
                        'is_external' => false,
                        'nofollow' => false,
                    ],
                ]
            );

            $this->add_control(
                'banner_button_txt',
                [
                    'label' => __( 'Button Text', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( 'Button Text', smw_slug ),
                ]
            );

            $this->add_control(
                'banner_badge_toggle',
                [
                    'label' => __( 'Banner Badge', smw_slug ),
                    'type' => Controls_Manager::POPOVER_TOGGLE,
                ]
            );

            $this->start_popover();

                $this->add_control(
                    'banner_badge_image',
                    [
                        'label' => __( 'Badge Image', smw_slug ),
                        'type' => Controls_Manager::MEDIA,
                    ]
                );

                $this->add_responsive_control(
                    'badge_width',
                    [
                        'label' => __( 'Width', smw_slug ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px', '%' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 1000,
                            ],
                            '%' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'condition'=>[
                            'banner_badge_image[url]!'=>'',
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .sm-special-banner .sm-banner-badge-image' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'badge_x_position',
                    [
                        'label' => __( 'Horizontal Postion', smw_slug ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px', '%' ],
                        'default' => [
                            'size' => 25,
                            'unit' => '%',
                        ],
                        'range' => [
                            'px' => [
                                'min' => -1000,
                                'max' => 1000,
                            ],
                            '%' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'condition'=>[
                            'banner_badge_image[url]!'=>'',
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .sm-special-banner .sm-banner-badge-image' => 'left: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                $this->add_responsive_control(
                    'badge_y_position',
                    [
                        'label' => __( 'Vertical Postion', smw_slug ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px', '%' ],
                        'default' => [
                            'size' => 0,
                            'unit' => '%',
                        ],
                        'range' => [
                             'px' => [
                                'min' => -1000,
                                'max' => 1000,
                            ],
                            '%' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'condition'=>[
                            'banner_badge_image[url]!'=>'',
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .sm-special-banner .sm-banner-badge-image' => 'top: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

            $this->end_popover();
            
        $this->end_controls_section();
    }
    
    protected function add_banner_style_control()
    {
                // Style tab section
        $this->start_controls_section(
            'add_banner_style_section',
            [
                'label' => __( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'add_banner_section_align',
                [
                    'label' => __( 'Alignment', smw_slug ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', smw_slug ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'add_banner_section_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'add_banner_section_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
        $this->end_controls_section();
    }
    
    protected function title_style_control()
    {
        // Style Title tab section
        $this->start_controls_section(
            'banner_title_style_section',
            [
                'label' => __( 'Title', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'banner_title!'=>'',
                ]
            ]
        );

            $this->add_control(
                'banner_title_color',
                [
                    'label' => __( 'Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h2' => 'color: {{VALUE}};',
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'banner_title_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sm-special-banner .banner-content h2',
                ]
            );

            $this->add_responsive_control(
                'banner_title_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'banner_title_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
        $this->end_controls_section();
    }
    
    protected function banner_subtitle_control()
    {
        // Style Sub Title tab section
        $this->start_controls_section(
            'banner_sub_title_style_section',
            [
                'label' => __( 'Sub Title', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'banner_sub_title!'=>'',
                ]
            ]
        );

            $this->add_control(
                'banner_sub_title_color',
                [
                    'label' => __( 'Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h6' => 'color: {{VALUE}};',
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'banner_sub_title_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sm-special-banner .banner-content h6',
                ]
            );

            $this->add_responsive_control(
                'banner_sub_title_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h6' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'banner_sub_title_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
        $this->end_controls_section();
    }
    
    protected function style_description_control()
    {
        // Style Description tab section
        $this->start_controls_section(
            'banner_description_style_section',
            [
                'label' => __( 'Description', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'banner_description!'=>'',
                ]
            ]
        );

            $this->add_control(
                'banner_description_color',
                [
                    'label' => __( 'Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content p' => 'color: {{VALUE}};',
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'banner_description_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sm-special-banner .banner-content p',
                ]
            );

            $this->add_responsive_control(
                'banner_description_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'banner_description_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
        $this->end_controls_section();
    }
    
    protected function offer_style_tab_control()
    {
        // Style Offer tab section
        $this->start_controls_section(
            'banner_offer_style_section',
            [
                'label' => __( 'Offer Amount', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'banner_offer!'=>'',
                ]
            ]
        );

            $this->add_control(
                'banner_offer_color',
                [
                    'label' => __( 'Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h5' => 'color: {{VALUE}};',
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'banner_offer_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sm-special-banner .banner-content h5',
                ]
            );

            $this->add_responsive_control(
                'banner_offer_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h5' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'banner_offer_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h5' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
        $this->end_controls_section();
    }
    
    protected function style_offer_tag_control()
    {
        // Style Offer Tag section
        $this->start_controls_section(
            'banner_offer_tag_style_section',
            [
                'label' => __( 'Offer Tag Line', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'banner_offer!'=>'',
                ]
            ]
        );

            $this->add_control(
                'banner_offer_tag_color',
                [
                    'label' => __( 'Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h5 span' => 'color: {{VALUE}};',
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'banner_offer_tag_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_4,
                    'selector' => '{{WRAPPER}} .sm-special-banner .banner-content h5 span',
                ]
            );

            $this->add_responsive_control(
                'banner_offer_tag_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h5 span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'banner_offer_tag_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-special-banner .banner-content h5 span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
        $this->end_controls_section();
    }
    
    protected function button_style_control()
    {
        // Style Button tab section
        $this->start_controls_section(
            'banner_button_style_section',
            [
                'label' => __( 'Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'banner_button_txt!'=>'',
                ]
            ]
        );

            $this->start_controls_tabs('button_style_tabs');

                $this->start_controls_tab(
                    'button_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    $this->add_control(
                        'button_text_color',
                        [
                            'label'     => __( 'Color', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'default'   =>'#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .sm-special-banner .banner-content a' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'button_typography',
                            'label' => __( 'Typography', smw_slug ),
                            'scheme' => Typography::TYPOGRAPHY_4,
                            'selector' => '{{WRAPPER}} .sm-special-banner .banner-content a',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .sm-special-banner .banner-content a',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .sm-special-banner .banner-content a' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_background',
                            'label' => __( 'Background', smw_slug ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .sm-special-banner .banner-content a',
                            'separator' => 'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-special-banner .banner-content a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_margin',
                        [
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-special-banner .banner-content a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                $this->end_controls_tab(); // Button Normal tab end

                // Button Hover tab start
                $this->start_controls_tab(
                    'button_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'button_hover_text_color',
                        [
                            'label'     => __( 'Color', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'default'   =>'#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .sm-special-banner .banner-content a:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .sm-special-banner .banner-content a:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_hover_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .sm-special-banner .banner-content a:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'button_hover_background',
                            'label' => __( 'Background', smw_slug ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .sm-special-banner .banner-content a:hover',
                            'separator' => 'before',
                        ]
                    );

                $this->end_controls_tab(); // Button Hover tab end

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function render( $instance = [] ) 
    {
        $settings   = $this->get_settings_for_display();

        $this->add_render_attribute( 'stiles_banner', 'class', 'sm-special-banner stiles-banner-content-pos-'.$settings['banner_content_pos'] );

        // URL Generate
        if ( ! empty( $settings['banner_link']['url'] ) ) 
        {
            $this->add_render_attribute( 'url', 'href', $settings['banner_link']['url'] );
            if ( $settings['banner_link']['is_external'] ) 
            {
                $this->add_render_attribute( 'url', 'target', '_blank' );
            }

            if ( ! empty( $settings['banner_link']['nofollow'] ) ) 
            {
                $this->add_render_attribute( 'url', 'rel', 'nofollow' );
            }
        }
       
        ?>
            <div <?php echo $this->get_render_attribute_string( 'stiles_banner' ); ?>>
                <div class="banner-thumb">
                    <a <?php echo $this->get_render_attribute_string( 'url' ); ?>>
                        <?php
                            echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'banner_image_size', 'banner_image' );
                        ?>
                    </a>
                </div>
                <?php
                    if( !empty($settings['banner_badge_image']['url']) )
                    {
                        echo '<div class="sm-banner-badge-image"><img src="' . $settings['banner_badge_image']['url'] . '"></div>';
                    }
                ?>
                <div class="banner-content">
                    <?php
                        if( !empty( $settings['banner_title'] ) )
                        {
                            echo '<h2>'.$settings['banner_title'].'</h2>';
                        }
                        if( !empty( $settings['banner_sub_title'] ) )
                        {
                            echo '<h6>'.$settings['banner_sub_title'].'</h6>';
                        }
                        if( !empty( $settings['banner_offer'] ) )
                        {
                            echo '<h5>'.$settings['banner_offer'].'<span>'.$settings['banner_offer_tag_line'].'</span></h5>';
                        }
                        if( !empty( $settings['banner_description'] ) )
                        {
                            echo '<p>'.$settings['banner_description'].'</p>';
                        }

                        if( !empty( $settings['banner_button_txt'] ) )
                        {
                            echo '<a '.$this->get_render_attribute_string( 'url' ).'>'.esc_html__( $settings['banner_button_txt'],smw_slug ).'</a>';
                        }
                    ?>
                </div>
            </div>

        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_special_offer() );