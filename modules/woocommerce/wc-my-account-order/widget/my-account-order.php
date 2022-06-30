<?php

/**
 * Stiles Media Widgets My Account: Order.
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

class stiles_wc_my_account_order extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-my-account-order';
    }
    
    public function get_title() 
    {
        return __( 'My Account: Order', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-woocommerce';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        $this->order_heading();

        $this->order_table();
        
        $this->order_numbers_table();
         
        $this->orders_button();
    }
    
    protected function order_heading()
    {
        $this->start_controls_section(
            'order_heading_style',
            array(
                'label' => __( 'Headings', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_control(
                'order_heading_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table thead th' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'order_heading_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .shop_table thead th',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'order_heading_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .shop_table thead th',
                ]
            );
            
            $this->add_responsive_control(
                'order_heading_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                'order_heading_text_align',
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
                        '{{WRAPPER}} .shop_table thead th' => 'text-align: {{VALUE}}',
                    ],
                ]
            );
        
        $this->end_controls_section();
    }
    
    protected function order_table()
    {
        // Order Table
        $this->start_controls_section(
            'order_table_cell_style',
            [
                'label' => __( 'Table Cell', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'order_table_cell_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'order_table_cell_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'order_table_cell_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell',
                ]
            );

            $this->add_responsive_control(
                'order_table_cell_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} {{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'order_table_cell_text_align',
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
                    'prefix_class' => 'elementor%s-align-',
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function order_numbers_table()
    {
        // Order Number Table
        $this->start_controls_section(
            'order_number_style',
            [
                'label' => __( 'Order Number', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->start_controls_tabs('order_number_style_tabs');

                $this->start_controls_tab(
                    'order_number_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );  
                    $this->add_control(
                        'order_table_cell_order_number_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Order Number Hover
                $this->start_controls_tab(
                    'order_number_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    $this->add_control(
                        'order_table_cell_order_number_hover_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell a:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function orders_button()
    {
        // View Button
        $this->start_controls_section(
            'order_view_button_style',
            [
                'label' => __( 'View Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->start_controls_tabs('order_view_button_style_tabs');

                $this->start_controls_tab(
                    'order_view_button_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );  
                    
                    $this->add_control(
                        'order_table_cell_order_view_button_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell a.woocommerce-button' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'order_table_cell_order_view_button_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell a.woocommerce-button' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'order_table_view_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell a.woocommerce-button',
                        ]
                    );

                    $this->add_responsive_control(
                        'order_table_view_button_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell a.woocommerce-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'order_table_view_button_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell a.woocommerce-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Order Number Hover
                $this->start_controls_tab(
                    'order_view_button_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    $this->add_control(
                        'order_table_cell_order_view_button_hover_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell a.woocommerce-button:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'order_table_cell_order_number_hover_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell a.woocommerce-button:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                     $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'order_table_view_button_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .woocommerce-orders-table tr.woocommerce-orders-table__row td.woocommerce-orders-table__cell a.woocommerce-button:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function render() 
    {
        global $wp;
        
        if ( Plugin::instance()->editor->is_edit_mode() ) 
        {
            if( isset($wp->query_vars['orders']) )
            {
                $value = $wp->query_vars['orders'];
                do_action( 'woocommerce_account_orders_endpoint', $value );
                    
            }elseif( isset($wp->query_vars['view-order']) )
            {
                $myaccount_url = get_permalink();
                $value = $wp->query_vars['view-order'];
                do_action( 'woocommerce_account_view-order_endpoint', $value );
                
            }else
            {
                $value = '';
                do_action( 'woocommerce_account_orders_endpoint', $value );
            }
        }else
        {
            if ( ! is_user_logged_in() ) 
            { 
                return __('You need to be logged in to view this page', smw_slug); 
            }
            
            if( isset($wp->query_vars['orders']) )
            {
                $value = $wp->query_vars['orders'];
                do_action( 'woocommerce_account_orders_endpoint', $value );
                    
            }elseif( isset($wp->query_vars['view-order']) )
            {
                $myaccount_url = get_permalink();
                $value = $wp->query_vars['view-order'];
                do_action( 'woocommerce_account_view-order_endpoint', $value );
                
            }else
            {
                $value = '';
                do_action( 'woocommerce_account_orders_endpoint', $value );
            }
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_my_account_order() );