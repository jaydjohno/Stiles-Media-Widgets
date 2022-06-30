<?php

/**
 * Stiles Media Widgets Cart Total.
 *
 * @package SMW
 */
 
namespace StilesMediaWidgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Base;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class WC_cart_total extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-cart-total';
    }
    
    public function get_title() 
    {
        return __( 'WC Cart: Total', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-woocommerce';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function cart_total_content()
    {
        // Cart Total Content
        $this->start_controls_section(
            'cart_total_content',
            [
                'label' => esc_html__( 'Cart Total', smw_slug ),
            ]
        );
            
            $this->add_control(
                'default_layout',
                [
                    'label' => esc_html__( 'Default', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Yes', smw_slug ),
                    'label_off' => esc_html__( 'No', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'description'=>esc_html__('If you choose yes then the WooCommerce default layout will be used',smw_slug),
                ]
            );

            $this->add_control(
                'section_title',
                [
                    'label' => esc_html__( 'Title', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Cart totals', smw_slug ),
                    'placeholder' => esc_html__( 'Cart totals', smw_slug ),
                    'condition'=>[
                        'default_layout!'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_control(
                'subtotal_heading',
                [
                    'label' => esc_html__( 'Sub tolal heading', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Subtotal', smw_slug ),
                    'placeholder' => esc_html__( 'Subtotal', smw_slug ),
                    'condition'=>[
                        'default_layout!'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_control(
                'shipping_heading',
                [
                    'label' => esc_html__( 'Shipping heading', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Shipping', smw_slug ),
                    'placeholder' => esc_html__( 'Shipping', smw_slug ),
                    'condition'=>[
                        'default_layout!'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_control(
                'total_heading',
                [
                    'label' => esc_html__( 'Tolal heading', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Total', smw_slug ),
                    'placeholder' => esc_html__( 'Total', smw_slug ),
                    'condition'=>[
                        'default_layout!'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_control(
                'proceed_to_checkout',
                [
                    'label' => esc_html__( 'Proceed To Checkout Button Text', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Proceed to checkout', smw_slug ),
                    'placeholder' => esc_html__( 'Proceed to checkout', smw_slug ),
                    'condition'=>[
                        'default_layout!'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

        $this->end_controls_section();
    }
    
    protected function cart_total_headings()
    {
        // Heading
        $this->start_controls_section(
            'cart_total_heading_style',
            array(
                'label' => __( 'Heading', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_total_heading_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .cart_totals > h2',
                )
            );
            $this->add_control(
                'cart_total_heading_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cart_totals > h2' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'cart_total_heading_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .cart_totals > h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'cart_total_heading_align',
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
                    'prefix_class' => 'elementor%s-align-',
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .cart_totals > h2' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function cart_total_table()
    {
        // Cart Total Table
        $this->start_controls_section(
            'cart_total_table_style',
            array(
                'label' => __( 'Table Cell', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'cart_total_table_border',
                    'selector' => '{{WRAPPER}} .cart_totals .shop_table tr th, {{WRAPPER}} .cart_totals .shop_table tr td',
                ]
            );
        
            $this->add_responsive_control(
                'cart_total_table_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} {{WRAPPER}} .cart_totals .shop_table tr th, {{WRAPPER}} .cart_totals .shop_table tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
        
            $this->add_responsive_control(
                'cart_total_table_align',
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
                    'prefix_class' => 'elementor%s-align-',
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .cart_totals .shop_table tr th, {{WRAPPER}} .cart_totals .shop_table tr td' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'cart_total_table_background',
                    'label' => __( 'Background', smw_slug ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .cart_totals .shop_table',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function cart_total_table_heading()
    {
        // Cart Total Table heading
        $this->start_controls_section(
            'cart_total_table_heading_style',
            array(
                'label' => __( 'Table Heading', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_control(
                'cart_total_table_heading_text_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cart_totals .shop_table tr th' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_total_table_heading_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .cart_totals .shop_table tr th',
                )
            );

        $this->end_controls_section();
    }
    
    protected function cart_total_table_price()
    {
        // Cart Total Price
        $this->start_controls_section(
            'cart_total_table_price_style',
            array(
                'label' => __( 'Price', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'cart_total_table_heading',
                [
                    'label' => __( 'Price', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_total_table_subtotal_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .cart_totals .shop_table tr.cart-subtotal td',
                )
            );

            $this->add_control(
                'cart_total_table_subtotal_color',
                [
                    'label' => __( 'Subtotal Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cart_totals .shop_table tr.cart-subtotal td' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'cart_total_table_totalprice_heading',
                [
                    'label' => __( 'Total Price', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_total_table_total_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .cart_totals .shop_table tr.order-total th, {{WRAPPER}} .cart_totals .shop_table tr.order-total td .amount',
                )
            );

            $this->add_control(
                'cart_total_table_total_color',
                [
                    'label' => __( 'Total Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cart_totals .shop_table tr.order-total th' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .cart_totals .shop_table tr.order-total td .amount' => 'color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function cart_table_checkout()
    {
        // Checkout button
        $this->start_controls_section(
            'cart_total_checkout_button_style',
            array(
                'label' => __( 'Checkout Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->start_controls_tabs( 'cart_total_checkout_button_style_tabs' );
        
                $this->start_controls_tab( 
                    'cart_total_checkout_button_style_normal',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'cart_total_checkout_button_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button',
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'cart_total_checkout_button_border',
                            'label' => __( 'Button Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button',
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_total_checkout_button_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                
                    $this->add_control(
                        'cart_total_checkout_button_text_color',
                        [
                            'label' => __( 'Text Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button' => 'color: {{VALUE}}',
                            ],
                        ]
                    );
                
                    $this->add_control(
                        'cart_total_checkout_button_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'cart_total_checkout_button_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'cart_total_checkout_button_box_shadow',
                            'selector' => '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button',
                        ]
                    );
            
                $this->end_controls_tab();
        
                $this->start_controls_tab( 
                    'cart_total_checkout_button_style_hover',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                
                    $this->add_control(
                        'cart_total_checkout_button_hover_text_color',
                        [
                            'label' => __( 'Text Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );
                
                    $this->add_control(
                        'cart_total_checkout_button_hover_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );
                
                    $this->add_control(
                        'cart_total_checkout_button_hover_border_color',
                        [
                            'label' => __( 'Border Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button:hover' => 'border-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'cart_total_checkout_button_hover_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'cart_total_checkout_button_hover_box_shadow',
                            'selector' => '{{WRAPPER}} .wc-proceed-to-checkout .button.checkout-button:hover',
                        ]
                    );
                
                $this->end_controls_tab();
        
            $this->end_controls_tabs();
        
        $this->end_controls_section();
    }
    
    protected function register_controls() 
    {
        $this->cart_total_content();
        
        $this->cart_total_headings();

        $this->cart_total_table();

        $this->cart_total_table_heading();

        $this->cart_total_table_price();
        
        $this->cart_table_checkout();
    }
    
    protected function render() 
    {
        $settings  = $this->get_settings_for_display();

        $cartotalopt = array(
            'section_title'         => $settings['section_title'],
            'subtotal_heading'      => $settings['subtotal_heading'],
            'shipping_heading'      => $settings['shipping_heading'],
            'total_heading'         => $settings['total_heading'],
            'proceed_to_checkout'   => $settings['proceed_to_checkout'],
        );

        if( $settings['default_layout'] === 'yes' ){
            woocommerce_cart_totals();
        }else{
            $this->cart_total_layout( $cartotalopt );
        }

    }

    // Cart Total layout
    public function cart_total_layout( $customopt = [] )
    {
        if( file_exists( smw_dir . 'woocommerce/templates/cart/cart-total.php' ) )
        {
            include smw_dir . 'woocommerce/templates/cart/cart-total.php';
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new WC_cart_total() );