<?php

/**
 * Stiles Media Widgets Cart Table.
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
use Elementor\Repeater;
use Elementor\Group_Control_Background;

class WC_cart_table extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'cart-table-style', plugin_dir_url( __FILE__ ) . '../css/cart-table.css');
    }
    
    public function get_name() 
    {
        return 'stiles-cart-table';
    }
    
    public function get_title() 
    {
        return __( 'WC Cart: Table', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-woocommerce';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'cart-table-style' ];
    }
    
    protected function register_controls() 
    {
        $this->table_rows();
        
        $this->table_actions();
        
        $this->table_style();
        
        $this->table_content();
        
        $this->product_image();
        
        $this->product_title();
        
        $this->product_price();

        $this->product_price_total();

        $this->update_cart();

        $this->continue_button();

        $this->apply_coupon();
    }
    
    protected function table_rows()
    {
        // Cart Table Row Content
        $this->start_controls_section(
            'cart_content',
            [
                'label' => esc_html__( 'Manage Table Row', smw_slug ),
            ]
        );
            
            $repeater = new Repeater();
            
            $repeater->add_control(
                'table_items',
                [
                    'label' => esc_html__( 'Table Item', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'remove',
                    'options' => [
                        'remove'    => esc_html__( 'Remove', smw_slug ),
                        'thumbnail' => esc_html__( 'Image', smw_slug ),
                        'name'      => esc_html__( 'Product Title', smw_slug ),
                        'price'     => esc_html__( 'Price', smw_slug ),
                        'quantity'  => esc_html__( 'Quantity', smw_slug ),
                        'subtotal'  => esc_html__( 'Total', smw_slug ),
                        'customadd' => esc_html__( 'Custom', smw_slug ),
                    ],
                ]
            );

            $repeater->add_control(
                'table_heading_title', 
                [
                    'label' => esc_html__( 'Heading Title', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Product tilte' , smw_slug ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'table_cell_width',
                [
                    'label' => esc_html__( 'Column Width', smw_slug ),
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
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.shop_table_responsive.cart tr td{{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .shop_table.shop_table_responsive.cart tr th{{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'table_item_list',
                [
                    'label' => __( 'Table Item List', smw_slug ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'table_items'           => 'remove',
                            'table_heading_title'   => esc_html__( 'Remove', smw_slug ),
                        ],
                        [
                            'table_items'           => 'thumbnail',
                            'table_heading_title'   => esc_html__( 'Image', smw_slug ),
                        ],
                        [
                            'table_items'           => 'name',
                            'table_heading_title'   => esc_html__( 'Product Title', smw_slug ),
                        ],
                        [
                            'table_items'           => 'price',
                            'table_heading_title'   => esc_html__( 'Price', smw_slug ),
                        ],
                        [
                            'table_items'           => 'quantity',
                            'table_heading_title'   => esc_html__( 'Quantity', smw_slug ),
                        ],
                        [
                            'table_items'           => 'subtotal',
                            'table_heading_title'   => esc_html__( 'Total', smw_slug ),
                        ],
                    ],
                    'title_field' => '{{{ table_heading_title }}}',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function table_actions()
    {
        // Cart table Action
        $this->start_controls_section(
            'cart_table_action',
            [
                'label' => esc_html__( 'Cart Table Action', smw_slug ),
            ]
        );
            
            $this->add_control(
                'show_update_button',
                [
                    'label'         => esc_html__( 'Update Cart', smw_slug ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Show', smw_slug ),
                    'label_off'     => esc_html__( 'Hide', smw_slug ),
                    'return_value'  => 'yes',
                    'default'       => 'yes',
                ]
            );

            $this->add_control(
                'update_cart_button_txt',
                [
                    'label' => __( 'Update cart button text', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Update cart', smw_slug ),
                    'placeholder' => __( 'Update cart button text', smw_slug ),
                    'condition'=>[
                        'show_update_button'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_responsive_control(
                'update_cart_button_align',
                [
                    'label'        => __( 'Cart Button Alignment', smw_slug ),
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
                    ],
                    'condition'=>[
                        'show_update_button'=>'yes',
                        'show_coupon_form!'=>'yes',
                    ],
                    'default'  => 'right',
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart.wl_cart_table .actions' => 'text-align: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'show_continue_button',
                [
                    'label'         => esc_html__( 'Continue Shopping', smw_slug ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Show', smw_slug ),
                    'label_off'     => esc_html__( 'Hide', smw_slug ),
                    'return_value'  => 'yes',
                    'default'       => 'no',
                    'separator'     => 'before',
                ]
            );

            $this->add_control(
                'continue_button_txt',
                [
                    'label' => __( 'Continue Shopping button text', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Continue Shopping', smw_slug ),
                    'placeholder' => __( 'Continue Shopping button text', smw_slug ),
                    'condition'=>[
                        'show_continue_button'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_responsive_control(
                'continue_button_align',
                [
                    'label'        => __( 'Continue Button Alignment', smw_slug ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'right'  => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'fa fa-align-right',
                        ],
                    ],
                    'condition'=>[
                        'show_continue_button'=>'yes',
                        'show_coupon_form!'=>'yes',
                    ],
                    'default'  => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'float: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'show_coupon_form',
                [
                    'label'         => esc_html__( 'Coupon Form', smw_slug ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Show', smw_slug ),
                    'label_off'     => esc_html__( 'Hide', smw_slug ),
                    'return_value'  => 'yes',
                    'default'       => 'yes',
                    'separator'     => 'before',
                ]
            );

            $this->add_control(
                'coupon_form_button_txt',
                [
                    'label' => __( 'Coupon form button text', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Apply coupon', smw_slug ),
                    'placeholder' => __( 'Apply coupon button text', smw_slug ),
                    'condition'=>[
                        'show_coupon_form'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_control(
                'coupon_form_pl_txt',
                [
                    'label' => __( 'Placeholder text', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Coupon code', smw_slug ),
                    'placeholder' => __( 'Coupon code', smw_slug ),
                    'condition'=>[
                        'show_coupon_form'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

        $this->end_controls_section();
    }
    
    protected function table_style()
    {
        // Style tab
        $this->start_controls_section(
            'cart_heading_style_section',
            [
                'label' => __( 'Heading', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_control(
                'heading_text_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart th' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'heading_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .shop_table.cart th',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'heading_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .shop_table.cart th',
                ]
            );

            $this->add_responsive_control(
                'heading_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'heading_text_align',
                [
                    'label'        => __( 'Text Alignment', smw_slug ),
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
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart thead th' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function table_content()
    {
        // Cart Table Content
        $this->start_controls_section(
            'cart_content_style_section',
            [
                'label' => __( 'Table Cell', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'table_cell_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .shop_table.cart tr.cart_item td',
                ]
            );

            $this->add_responsive_control(
                'table_cell_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'table_cell_text_align',
                [
                    'label'        => __( 'Text Alignment', smw_slug ),
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
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'cart_table_background',
                    'label' => __( 'Background', smw_slug ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .shop_table.cart',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_image()
    {
        // Product Image
        $this->start_controls_section(
            'cart_product_image_style',
            array(
                'label' => __( 'Product Image', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_image_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-thumbnail img',
                ]
            );

            $this->add_responsive_control(
                'product_image_border_radius',
                [
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_image_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-thumbnail img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_image_width',
                [
                    'label' => __( 'Image Width', smw_slug ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 200,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 32,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-thumbnail img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_title()
    {
        // Product Title
        $this->start_controls_section(
            'cart_product_title_style',
            array(
                'label' => __( 'Product Title', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->start_controls_tabs( 'cart_item_style_tabs' );

                // Product Title Normal Style
                $this->start_controls_tab( 
                    'product_title_normal',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_product_title_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-name' => 'color: {{VALUE}}',
                                '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-name a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'cart_product_title_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-name',
                        )
                    );

                $this->end_controls_tab();

                // Product Title Hover Style
                $this->start_controls_tab( 
                    'product_title_hover',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_product_title_hover_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-name:hover' => 'color: {{VALUE}}',
                                '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-name a:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function product_price()
    {
        // Product Price
        $this->start_controls_section(
            'cart_product_price_style',
            array(
                'label' => __( 'Product Price', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'cart_product_price_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-price' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_product_price_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-price',
                )
            );

        $this->end_controls_section();
    }
    
    protected function product_price_total()
    {
        // Product Price Total
        $this->start_controls_section(
            'cart_product_subtotal_price_style',
            array(
                'label' => __( 'Total Price', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'cart_product_subtotal_price_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-subtotal' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_product_subtotal_price_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-subtotal',
                )
            );

        $this->end_controls_section();
    }
    
    protected function update_cart()
    {
        // Update cart
        $this->start_controls_section(
            'cart_update_button_style',
            array(
                'label' => __( 'Update Cart Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_update_button'=>'yes',
                ],
            )
        );

            $this->start_controls_tabs( 'cart_update_style_tabs' );

                // Product Title Normal Style
                $this->start_controls_tab( 
                    'cart_update_button_normal',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_update_button_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'cart_update_button_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'cart_update_button_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button',
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'cart_update_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button',
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_update_button_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_update_button_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Update cart button hover style
                $this->start_controls_tab( 
                    'cart_update_button_hover',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_update_button_hover_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'cart_update_button_hover_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button:hover' => 'background-color: {{VALUE}}; transition:0.4s',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'cart_update_button_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .shop_table.cart td.actions > input.button:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_update_button_hover_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function continue_button()
    {
        // Continue Button Style
        $this->start_controls_section(
            'cart_continue_button_style',
            array(
                'label' => __( 'Continue Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_continue_button'=>'yes',
                ],
            )
        );

            $this->start_controls_tabs( 'cart_continue_style_tabs' );

                // Continue Button Normal Style
                $this->start_controls_tab( 
                    'cart_continue_button_normal',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_continue_button_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'cart_continue_button_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'cart_continue_button_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping',
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'cart_continue_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping',
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_continue_button_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_continue_button_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_continue_button_margin',
                        [
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Cart continue Button hover style
                $this->start_controls_tab( 
                    'cart_continue_button_hover',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_continue_button_hover_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'cart_continue_button_hover_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping:hover' => 'background-color: {{VALUE}}; transition:0.4s',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'cart_continue_button_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_continue_button_hover_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function apply_coupon()
    {
        // Apply coupon
        $this->start_controls_section(
            'cart_coupon_style',
            array(
                'label' => __( 'Apply coupon', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_coupon_form'=>'yes',
                ],
            )
        );

            $this->add_control(
                'cart_coupon_button_heading',
                [
                    'label' => __( 'Button', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_coupon_button_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .shop_table.cart td.actions .coupon .button',
                )
            );

            $this->add_control(
                'cart_coupon_button_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon .button' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'cart_coupon_button_bg_color',
                [
                    'label' => __( 'Background Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon .button' => 'background-color: {{VALUE}}; transition:0.4s',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'cart_coupon_button_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .shop_table.cart td.actions .coupon .button',
                ]
            );

            $this->add_responsive_control(
                'cart_coupon_button_border_radius',
                [
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );


            $this->add_control(
                'cart_coupon_button_hover_color',
                [
                    'label' => __( 'Hover Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon .button:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'cart_coupon_button_hover_bg_color',
                [
                    'label' => __( 'Hover Background Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon .button:hover' => 'background-color: {{VALUE}}; transition:0.4s',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'cart_coupon_hover_button_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .shop_table.cart td.actions .coupon .button:hover',
                ]
            );

            $this->add_control(
                'cart_coupon_inputbox_heading',
                [
                    'label' => __( 'Input Box', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_control(
                'cart_coupon_inputbox_color',
                [
                    'label' => __( 'Input Box Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_coupon_inputbox_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'cart_coupon_inputbox_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text',
                ]
            );

            $this->add_responsive_control(
                'cart_coupon_inputbox_border_radius',
                [
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'cart_coupon_inputbox_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'cart_coupon_inputbox_width',
                [
                    'label' => __( 'Input Box Width', smw_slug ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 200,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 100,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text' => 'width: {{SIZE}}{{UNIT}} !important;',
                    ],
                ]
            );

        $this->end_controls_section();
    }

    protected function render() 
    {
        $settings  = $this->get_settings_for_display();

        $table_items = ( isset( $settings['table_item_list'] ) ? $settings['table_item_list'] : array() );

        // Cart Option
        $cart_table_opt = array(
            'update_cart_button' => array(
                'enable'    => $settings['show_update_button'],
                'button_txt'=> $settings['update_cart_button_txt'],
            ),
            'continue_shop_button'=> array(
                'enable'    => $settings['show_continue_button'],
                'button_txt'=> $settings['continue_button_txt'],
            ),
            'coupon_form' => array(
                'enable'        => $settings['show_coupon_form'],
                'button_txt'    => $settings['coupon_form_button_txt'],
                'placeholder'   => $settings['coupon_form_pl_txt'],
            ),
        );

        Stiles_Shortcode_Cart::output( $atts = array(), $table_items, $cart_table_opt );
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new WC_cart_table() );

/**
 * Cart Shortcode
 *
 * Used on the cart page, the cart shortcode displays the cart contents and interface for coupon codes and other cart bits and pieces.
 *
 * @package WooCommerce/Shortcodes/Cart
 * @version 2.3.0
 */

class Stiles_Shortcode_Cart extends \WC_Shortcode_Cart
{
    /**
     * Output the cart shortcode.
     */
    public static function output( $atts = '', $cartitem = [], $cartopt = [] ) 
    {
        // Constants.
        wc_maybe_define_constant( 'WOOCOMMERCE_CART', true );

        $atts        = shortcode_atts( array(), $atts, 'woocommerce_cart' );
        $nonce_value = wc_get_var( $_REQUEST['woocommerce-shipping-calculator-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.

        // Update Shipping. Nonce check uses new value and old value (woocommerce-cart). @todo remove in 4.0.
        if ( ! empty( $_POST['calc_shipping'] ) && ( wp_verify_nonce( $nonce_value, 'woocommerce-shipping-calculator' ) || wp_verify_nonce( $nonce_value, 'woocommerce-cart' ) ) ) 
        { // WPCS: input var ok.
            self::calculate_shipping();

            // Also calc totals before we check items so subtotals etc are up to date.
            \WC()->cart->calculate_totals();
        }

        // Check cart items are valid.
        do_action( 'woocommerce_check_cart_items' );

        // Calc totals.
        \WC()->cart->calculate_totals();

        if ( \WC()->cart->is_empty() ) 
        {
            wc_get_template( 'cart/cart-empty.php');
        } else 
        {
            if( file_exists( smw_dir . 'woocommerce/templates/cart/cart-table.php' ) )
            {
                include smw_dir . 'woocommerce/templates/cart/cart-table.php';
            }
        }
    }
}