<?php

/**
 * Stiles Media Widgets Stock Progress.
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

class stiles_wc_stock_progress extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'stock-progress-style', plugin_dir_url( __FILE__ ) . '../css/stock-progress.css');
    }
    
    public function get_name() 
    {
        return 'stiles-stock-progress';
    }
    
    public function get_title() 
    {
        return __( 'Product: Stock Progress', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-skill-bar';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'stock-progress-style' ];
    }
    
    protected function register_controls() 
    {
        $this->progress_bar();

        $this->progress_bar_style();
        
        $this->availability_style();
    }
    
    protected function progress_bar()
    {
        $this->start_controls_section(
            'section_stock_progress_bar',
            [
                'label' => __( 'Stock Progress Bar', smw_slug ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            
            $this->add_control(
                'hide_order_counter',
                [
                    'label'     => __( 'Hide Order Counter', smw_slug ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .smtotal-sold' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'hide_available_counter',
                [
                    'label'     => __( 'Hide Available Counter', smw_slug ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .smcurrent-stock' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'order_custom_text',
                [
                    'label' => __( 'Ordered Custom Text', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( 'Ordered', smw_slug ),
                    'condition' => [
                        'hide_order_counter!' => 'yes',
                    ],
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'available_custom_text',
                [
                    'label' => __( 'Available Custom Text', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( 'Items available', smw_slug ),
                    'condition' => [
                        'hide_available_counter!' => 'yes',
                    ],
                    'label_block' => true,
                ]
            );

        $this->end_controls_section();
    }
    
    protected function progress_bar_style()
    {
        // Style
        $this->start_controls_section(
            'section_stock_progress_bar_style',
            [
                'label' => __( 'Stock Progress Bar', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'progress_bar_height',
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
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-stock-progress-bar .smprogress-area' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'progress_bar_bg_color',
                [
                    'label' => __( 'Background Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-stock-progress-bar .smprogress-area' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'progress_bar_active_bg_color',
                [
                    'label' => __( 'Sales Progress Background Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-stock-progress-bar .smprogress-bar' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'progress_bar_area',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-stock-progress-bar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function availability_style()
    {
        // Order and availability Style
        $this->start_controls_section(
            'section_stock_order_availability_style',
            [
                'label' => __( 'Order & Availability Counter', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'order_availability_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .stiles-stock-progress-bar .smstock-info',
                ]
            );

            $this->add_control(
                'order_availability_color',
                [
                    'label' => __( 'Label Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-stock-progress-bar .smstock-info' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'counter_number_color',
                [
                    'label' => __( 'Counter Number Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-stock-progress-bar .smstock-info span' => 'color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $order_text     = $settings['order_custom_text'] ? $settings['order_custom_text'] : 'Ordered:';
        $available_text = $settings['available_custom_text'] ? $settings['available_custom_text'] : 'Items available:';

        if( Plugin::instance()->editor->is_edit_mode() )
        {
            $product_id = smw_get_last_product_id();
        } else
        {
            $product_id = get_the_ID();
        }
        
        $this->manage_stock_status( $order_text, $available_text, $product_id );
    }

    protected function manage_stock_status( $order_text, $available_text, $product_id )
    {
        $product_id  = $product_id;
        
        if ( get_post_meta( $product_id, '_manage_stock', true ) == 'yes' ) 
        {
            $total_stock = get_post_meta( $product_id, 'stiles_total_stock_quantity', true );

            if ( ! $total_stock ) 
            { 
                echo '<div class="stock-management-progress-bar">'.__('You need to set stock amount in order to use the progress bar',smw_slug).'</div>'; 
                return;
            }

            $current_stock = round( get_post_meta( $product_id, '_stock', true ) );

            $total_sold = $total_stock > $current_stock ? $total_stock - $current_stock : 0;
            $percentage = $total_sold > 0 ? round( $total_sold / $total_stock * 100 ) : 0;

            if ( $current_stock > 0 ) 
            {
                echo '<div class="stiles-stock-progress-bar">';
                    echo '<div class="smstock-info">';
                        echo '<div class="smtotal-sold">' . __( $order_text, smw_slug ) . '<span>' . esc_html( $total_sold ) . '</span></div>';
                        echo '<div class="smcurrent-stock">' . __( $available_text, smw_slug ) . '<span>' . esc_html( $current_stock ) . '</span></div>';
                    echo '</div>';
                    echo '<div class="smprogress-area" title="' . __( 'Sold', smw_slug ) . ' ' . esc_attr( $percentage ) . '%">';
                        echo '<div class="smprogress-bar"style="width:' . esc_attr( $percentage ) . '%;"></div>';
                    echo '</div>';
                echo '</div>';
            }else{
                echo '<div class="stock-management-progress-bar">'.__('You need to set stock amount in order to use the progress bar',smw_slug).'</div>';
            }

        }

    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_stock_progress() );