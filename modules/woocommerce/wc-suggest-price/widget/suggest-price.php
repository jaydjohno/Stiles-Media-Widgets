<?php

/**
 * Stiles Media Widgets Suggest Price.
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
use Elementor\Group_Control_Background;
use Elementor\Plugin;

class stiles_wc_suggest_price extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'suggest-price-style', plugin_dir_url( __FILE__ ) . '../css/suggest-price.css');
    }
    
    public function get_name() 
    {
        return 'stiles-suggest-price';
    }
    
    public function get_title() 
    {
        return __( 'Suggest Price', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-form-horizontal';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'suggest-price-style' ];
    }
    
    protected function register_controls() 
    {
        $this->start_controls_section(
            'product_suggest_price',
            [
                'label' => esc_html__( 'Suggest Price', smw_slug ),
            ]
        );

            // input field plceholder text
            $this->add_control(
                'open_close_btn_text',
                [
                    'label' => __( 'Button Text', smw_slug ),
                    'type' => Controls_Manager::POPOVER_TOGGLE,
                ]
            );

            $this->start_popover();

                $this->add_control(
                    'open_button_text',
                    [
                        'label' => __( 'Open Button Text', smw_slug ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Suggest Price', smw_slug ),
                        'placeholder' => __( 'Suggest Price', smw_slug ),
                        'label_block'=>true,
                    ]
                );

                $this->add_control(
                    'close_button_text',
                    [
                        'label' => __( 'Close Button Text', smw_slug ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Close', smw_slug ),
                        'placeholder' => __( 'Close', smw_slug ),
                        'label_block'=>true,
                    ]
                );

            $this->end_popover();

            $this->add_control(
                'send_to_mail',
                [
                    'label' => __( 'Send To Mail', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'admin@domain.com', smw_slug ),
                    'placeholder' => __( 'admin@domain.com', smw_slug ),
                    'label_block'=>true,
                    'separator'=>'before',
                ]
            );

            $this->add_control(
                'submit_button_txt',
                [
                    'label' => __( 'Submit Button Text', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Submit', smw_slug ),
                    'placeholder' => __( 'Submit', smw_slug ),
                    'label_block'=>true,
                ]
            );

            // input field plceholder text
            $this->add_control(
                'input_placeholder_text',
                [
                    'label' => __( 'Input Field Placeholder', smw_slug ),
                    'type' => Controls_Manager::POPOVER_TOGGLE,
                ]
            );

            $this->start_popover();

                $this->add_control(
                    'name_placeholder_text',
                    [
                        'label' => __( 'Name Field Placeholder', smw_slug ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Please Enter your name', smw_slug ),
                        'placeholder' => __( 'Please Enter your name', smw_slug ),
                        'label_block'=>true,
                    ]
                );

                $this->add_control(
                    'email_placeholder_text',
                    [
                        'label' => __( 'Email Field Placeholder', smw_slug ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Please Enter your email', smw_slug ),
                        'placeholder' => __( 'Please Enter your email', smw_slug ),
                        'label_block'=>true,
                    ]
                );

                $this->add_control(
                    'message_placeholder_text',
                    [
                        'label' => __( 'Message Field Placeholder', smw_slug ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Write your message', smw_slug ),
                        'placeholder' => __( 'Write your message', smw_slug ),
                        'label_block'=>true,
                    ]
                );

            $this->end_popover();

            // Message
            $this->add_control(
                'mail_send_message',
                [
                    'label' => __( 'Message', smw_slug ),
                    'type' => Controls_Manager::POPOVER_TOGGLE,
                ]
            );

            $this->start_popover();

                $this->add_control(
                    'message_success',
                    [
                        'label' => __( 'Success Message', smw_slug ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Thank you contacting with us', smw_slug ),
                        'placeholder' => __( 'Thank you contacting with us', smw_slug ),
                        'label_block'=>true,
                        'separator'=>'before',
                    ]
                );

                $this->add_control(
                    'message_error',
                    [
                        'label' => __( 'Error Message', smw_slug ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Something is wrong ! try again', smw_slug ),
                        'placeholder' => __( 'Something is wrong ! try again', smw_slug ),
                        'label_block'=>true,
                    ]
                );

            $this->end_popover();

        $this->end_controls_section();

        $this->start_controls_section(
            'input_style',
            [
                'label' => __( 'Input', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'input_text_color',
                [
                    'label'     => __( 'Text Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wc-suggest-form-input input'   => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'input_placeholder_color',
                [
                    'label'     => __( 'Placeholder Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wc-suggest-form-input input[type*="text"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .wc-suggest-form-input input[type*="text"]::-moz-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .wc-suggest-form-input input[type*="text"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
                         '{{WRAPPER}} .wc-suggest-form-input input[type*="email"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .wc-suggest-form-input input[type*="email"]::-moz-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .wc-suggest-form-input input[type*="email"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'input_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .wc-suggest-form-input input',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'input_background',
                    'label' => __( 'Background', smw_slug ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .wc-suggest-form-input input',
                ]
            );

            $this->add_responsive_control(
                'input_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .wc-suggest-form-input input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'input_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .wc-suggest-form-input input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'input_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .wc-suggest-form-input input',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'input_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .wc-suggest-form-input input' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

        $this->end_controls_section();

        // Style tab Textarea section
        $this->start_controls_section(
            'style_textarea',
            [
                'label' => __( 'Textarea', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'textarea_text_color',
                [
                    'label'     => __( 'Text Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wc-suggest-form-input textarea'   => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'textarea_placeholder_color',
                [
                    'label'     => __( 'Placeholder Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .wc-suggest-form-input textarea::-webkit-input-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .wc-suggest-form-input textarea::-moz-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .wc-suggest-form-input textarea:-ms-input-placeholder'  => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'textarea_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .wc-suggest-form-input textarea',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'textarea_background',
                    'label' => __( 'Background', smw_slug ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .wc-suggest-form-input textarea',
                ]
            );

            $this->add_responsive_control(
                'textarea_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .wc-suggest-form-input textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'textarea_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .wc-suggest-form-input textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'textarea_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .wc-suggest-form-input textarea',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'textarea_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .wc-suggest-form-input textarea' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

        $this->end_controls_section();

        // Submit Button
        $this->start_controls_section(
            'style_submit_button',
            [
                'label' => __( 'Submit Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            // Button Tabs Start
            $this->start_controls_tabs('style_submit_tabs');

                // Start Normal Submit button tab
                $this->start_controls_tab(
                    'style_submit_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'submitbutton_text_color',
                        [
                            'label'     => __( 'Colour', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'default'=>'#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-form-input input[type="submit"]'   => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'submitbutton_typography',
                            'scheme' => Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}} .wc-suggest-form-input input[type="submit"]',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'submitbutton_background',
                            'label' => __( 'Background', smw_slug ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .wc-suggest-form-input input[type="submit"]',
                        ]
                    );

                    $this->add_responsive_control(
                        'submitbutton_margin',
                        [
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-form-input input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'submitbutton_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-form-input input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'submitbutton_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .wc-suggest-form-input input[type="submit"]',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'submitbutton_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-form-input input[type="submit"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Normal submit Button tab end

                // Start Hover Submit button tab
                $this->start_controls_tab(
                    'style_submit_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'submitbutton_hover_text_color',
                        [
                            'label'     => __( 'Colour', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-form-input input[type="submit"]:hover'   => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'submitbutton_hover_background',
                            'label' => __( 'Background', smw_slug ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .wc-suggest-form-input input[type="submit"]:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'submitbutton_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .wc-suggest-form-input input[type="submit"]:hover',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'submitbutton_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-form-input input[type="submit"]:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover Submit Button tab End

            $this->end_controls_tabs(); // Button Tabs End

        $this->end_controls_section();

        // Open button
        $this->start_controls_section(
            'open_button_style',
            [
                'label' => __( 'Open Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->start_controls_tabs('open_button_normal_style_tabs');
                
                // Button Normal tab
                $this->start_controls_tab(
                    'open_button_normal_style_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'open_button_color',
                        [
                            'label'     => __( 'Text Colour', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcopen' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'open_button_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} .wc-suggest-button.wcopen',
                        )
                    );

                    $this->add_control(
                        'open_button_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcopen' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'open_button_margin',
                        [
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcopen' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'open_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .wc-suggest-button.wcopen',
                        ]
                    );

                    $this->add_control(
                        'open_button_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcopen' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'open_button_background_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcopen' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Button Hover tab
                $this->start_controls_tab(
                    'open_button_hover_style_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                ); 
                    
                    $this->add_control(
                        'open_button_hover_color',
                        [
                            'label'     => __( 'Text Colour', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcopen:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'open_button_hover_background_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcopen:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'open_button_hover_border_color',
                        [
                            'label' => __( 'Border Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcopen:hover' => 'border-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Close button
        $this->start_controls_section(
            'close_button_style',
            [
                'label' => __( 'Close Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->start_controls_tabs('close_button_normal_style_tabs');
                
                // Button Normal tab
                $this->start_controls_tab(
                    'close_button_normal_style_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'close_button_color',
                        [
                            'label'     => __( 'Text Colour', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcclose' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'close_button_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} .wc-suggest-button.wcclose',
                        )
                    );

                    $this->add_control(
                        'close_button_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcclose' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'close_button_margin',
                        [
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcclose' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'close_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .wc-suggest-button.wcclose',
                        ]
                    );

                    $this->add_control(
                        'close_button_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcclose' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'close_button_background_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcclose' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Button Hover tab
                $this->start_controls_tab(
                    'close_button_hover_style_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                ); 
                    
                    $this->add_control(
                        'close_button_hover_color',
                        [
                            'label'     => __( 'Text Colour', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcclose:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'close_button_hover_background_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcclose:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'close_button_hover_border_color',
                        [
                            'label' => __( 'Border Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-suggest-button.wcclose:hover' => 'border-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings();
        $id = $this->get_id();

        $this->add_render_attribute(
            [

                'user_name' => [
                    'type'        => 'text',
                    'name'        => 'wcname',
                    'id'          => 'wcname-' . esc_attr( $id ),
                    'placeholder' => $settings['name_placeholder_text'],
                ],

                'user_email' => [
                    'type'        => 'email',
                    'name'        => 'wcemail',
                    'id'          => 'wcemail-' . esc_attr( $id ),
                    'placeholder' => $settings['email_placeholder_text'],
                ],

                'user_message' => [
                    'name'        => 'wcmessage',
                    'id'          => 'wcmessage-' . esc_attr( $id ),
                    'rows'          => '4',
                    'cols'          => '50',
                    'placeholder' => $settings['message_placeholder_text'],
                ],

                'user_submit' => [
                    'type'        => 'submit',
                    'name'        => 'wcsubmit-' . esc_attr( $id ),
                    'id'          => 'wcemail-' . esc_attr( $id ),
                    'value'       => $settings['submit_button_txt'],
                ],
                
            ]
        );

        ?>
            <div class="wc-suggest-price">
                <?php
                    if( isset( $_REQUEST['wcsubmit-'.$id] ) ){
                        $name       = $_POST['wcname'];
                        $email      = $_POST['wcemail'];
                        $message    = $_POST['wcmessage'];

                        //php mailer variables
                        $sentto  = $settings['send_to_mail'];
                        $subject = "Suggest For Price";
                        $headers = 'From: '. $email . "\r\n" .
                        'Reply-To: ' . $email . "\r\n";

                        //Here put your Validation and send mail
                        $sent = wp_mail( $sentto, $subject, strip_tags($message), $headers );

                        if( $sent ) {
                            echo '<p class="wcsendmessage">'.$settings['message_success'].'</p>';
                        }
                        else{
                            echo '<p class="wcsendmessage">'.$settings['message_error'].'</p>';
                        }
                    }
                ?>
                <button id="wcopenform-<?php echo esc_attr( $id ); ?>" class="wc-suggest-button wcopen"><?php echo esc_html__( $settings['open_button_text'], smw_slug ); ?></button>
                <button id="wccloseform-<?php echo esc_attr( $id ); ?>" class="wc-suggest-button wcclose" style="display: none;"><?php echo esc_html__( $settings['close_button_text'], smw_slug ); ?></button>
                <form id="wcsuggestform-<?php echo esc_attr( $id ); ?>" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
                    <div class="wc-suggest-form-input">
                        <input <?php echo $this->get_render_attribute_string( 'user_name' ); ?> >
                    </div>
                    <div class="wc-suggest-form-input">
                        <input <?php echo $this->get_render_attribute_string( 'user_email' ); ?>>
                    </div>
                    <div class="wc-suggest-form-input">
                        <textarea <?php echo $this->get_render_attribute_string( 'user_message' ); ?>></textarea>
                    </div>
                    <div class="wc-suggest-form-input">
                        <input <?php echo $this->get_render_attribute_string( 'user_submit' ); ?> >
                    </div>
                </form>

            </div>

            <script type="text/javascript">
                jQuery(document).ready(function($) {
                "use strict";

                    var open_formbtn = '#wcopenform-<?php echo esc_attr($id); ?>';
                    var close_formbtn = '#wccloseform-<?php echo esc_attr($id); ?>';
                    var terget_form = 'form#wcsuggestform-<?php echo esc_attr($id); ?>';
                    $( open_formbtn ).on('click', function(){
                        $(this).hide();
                        $(this).siblings( close_formbtn ).show();
                        $(this).siblings( terget_form ).slideDown('slow');
                    });

                    // Close Button
                    $( close_formbtn ).on('click', function(){
                        $(this).hide();
                        $(this).siblings( open_formbtn ).show();
                        $(this).siblings( terget_form ).slideUp('slow');
                    });

                });
            </script>

        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_suggest_price() );