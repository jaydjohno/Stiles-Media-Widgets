<?php

/**
 * Stiles Media Widgets Checkout: Payment.
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
use Elementor\Widget_Base;

class stiles_wc_checkout_payment extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-checkout-payment';
    }
    
    public function get_title() 
    {
        return __( 'Checkout: Payment', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-woocommerce';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    protected function checkout_payment()
    {
        // Payment
        $this->start_controls_section(
            'checkout_payment_style',
            array(
                'label' => __( 'Payment', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'checkout_payment_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} #payment',
                )
            );

            $this->add_control(
                'checkout_payment_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} #payment' => 'color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function checkout_payment_heading()
    {
        // Payment Method Heading
        $this->start_controls_section(
            'checkout_heading_style',
            array(
                'label' => __( 'Payment Heading', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'checkout_payment_heading_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} #payment .wc_payment_method label',
                )
            );

            $this->add_control(
                'checkout_payment_heading_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} #payment .wc_payment_method label' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'checkout_payment_heading_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} #payment ul.payment_methods.methods li',
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_heading_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} #payment ul.payment_methods.methods li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_heading_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} #payment ul.payment_methods.methods li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_heading_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} #payment ul.payment_methods.methods li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} #payment .wc_payment_method label' => 'margin: 0;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_heading_align',
                [
                    'label'        => __( 'Alignment', smw_slug ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'default'   => 'left',
                    'selectors' => [
                        '{{WRAPPER}} #payment ul.payment_methods.methods li' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'checkout_payment_heading_background_color',
                [
                    'label' => __( 'Background Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} #payment ul.payment_methods.methods li' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function checkout_payment_content()
    {
        // Payment Content
        $this->start_controls_section(
            'checkout_payment_content_style',
            array(
                'label' => __( 'Content', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'checkout_payment_content_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} #payment .payment_box',
                )
            );

            $this->add_control(
                'checkout_payment_content_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} #payment .payment_box' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_content_padding',
                [
                    'label' => esc_html__( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} #payment .payment_box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'checkout_payment_content_bg_color',
                [
                    'label' => __( 'Background Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} #payment .payment_box' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} #payment div.payment_box::before, {{WRAPPER}} #payment div.payment_box::before' => 'border-color:transparent transparent {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'checkout_payment_content_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} #payment .payment_box',
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_content_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} #payment .payment_box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function payment_place_order_button()
    {
        // Payment Place Order Button
        $this->start_controls_section(
            'checkout_payment_place_order_style',
            array(
                'label' => __( 'Place Order Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->start_controls_tabs('checkout_payment_place_order_style_tabs');
                
                // Plece order button normal
                $this->start_controls_tab(
                    'checkout_payment_place_order_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'checkout_payment_place_order_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} #payment #place_order',
                        )
                    );

                    $this->add_control(
                        'checkout_payment_place_order_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'checkout_payment_place_order_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'checkout_payment_place_order_padding',
                        [
                            'label' => esc_html__( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'checkout_payment_place_order_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} #payment #place_order',
                        ]
                    );

                    $this->add_responsive_control(
                        'checkout_payment_place_order_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%'],
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();
                
                // Place order button hover
                $this->start_controls_tab(
                    'checkout_payment_place_order_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'checkout_payment_place_order_hover_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order:hover' => 'color: {{VALUE}}; transition:0.4s;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'checkout_payment_place_order_hover_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'checkout_payment_place_order_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} #payment #place_order:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function register_controls() 
    {
        $this->checkout_payment();
        
        $this->checkout_payment_heading();
        
        $this->checkout_payment_content();
        
        $this->payment_place_order_button();
    }
    
    protected function render() 
    {
        $settings = $this->get_settings_for_display();
        
        if ( Plugin::instance()->editor->is_edit_mode() ) 
        {
            if ( ! is_ajax() )
            { 
                do_action( 'woocommerce_review_order_before_payment' ); 
            }
                woocommerce_checkout_payment();
                
            if ( ! is_ajax() )
            {
                do_action( 'woocommerce_review_order_after_payment' ); 
            }
        }else{
            if( is_checkout() )
            {
                if ( ! is_ajax() )
                { 
                    do_action( 'woocommerce_review_order_before_payment' ); 
                }
                    woocommerce_checkout_payment();
                    
                if ( ! is_ajax() )
                { 
                    do_action( 'woocommerce_review_order_after_payment' ); 
                }
            }
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_checkout_payment() );