<?php

/**
 * Stiles Media Widgets Cross Sell.
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

class stiles_wc_cross_sell extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-cross-sell';
    }
    
    public function get_title() 
    {
        return __( 'Product: Cross Sell', smw_slug );
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
        $this->start_controls_section(
            'section_cross_sells',
            [
                'label' => __( 'Cross Sells', smw_slug ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
            $this->add_control(
                'limit',
                [
                    'label' => __( 'Limit', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 2,
                    'min' => 1,
                    'max' => 16,
                ]
            );
            
            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'prefix_class' => 'elementor-products-columns%s-',
                    'default' => 2,
                    'min' => 1,
                    'max' => 16,
                ]
            );
            
            $this->add_control(
                'orderby',
                [
                    'label' => __( 'Orderby', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'rand',
                    'options' => [
                        'rand' => __( 'Random', smw_slug ),
                        'date' => __( 'Publish Date', smw_slug ),
                        'modified' => __( 'Modified Date', smw_slug ),
                        'title' => __( 'Alphabetic', smw_slug ),
                        'popularity' => __( 'Popularity', smw_slug ),
                        'rating' => __( 'Rate', smw_slug ),
                        'price' => __( 'Price', smw_slug ),
                    ],
                ]
            );
            
            $this->add_control(
                'order',
                [
                    'label' => __( 'Order', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'desc',
                    'options' => [
                        'desc' => __( 'DESC', smw_slug ),
                        'asc' => __( 'ASC', smw_slug ),
                    ],
                ]
            );
        
        $this->end_controls_section();

        // Heading
        $this->start_controls_section(
            'cross_sell_heading_style',
            array(
                'label' => __( 'Heading', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cross_sell_heading_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .cross-sells > h2',
                )
            );

            $this->add_control(
                'cross_sell_heading_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cross-sells > h2' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'cross_sell_heading_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .cross-sells > h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'cross_sell_heading_align',
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
                        '{{WRAPPER}} .cross-sells > h2' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    protected function render() 
    {
        $settings = $this->get_settings_for_display();
        woocommerce_cross_sell_display( $settings['limit'], $settings['columns'], $settings['orderby'], $settings['order'] );
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_cross_sell() );