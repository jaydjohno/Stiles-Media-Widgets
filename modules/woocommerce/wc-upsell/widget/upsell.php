<?php

/**
 * Stiles Media Widgets Product Upsell.
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

class stiles_wc_product_upsell extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-product-upsell';
    }
    
    public function get_title() 
    {
        return __( 'Product Upsell', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-upsell';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        $this->start_controls_section(
            'product_upsell_content',
            [
                'label' => __( 'Upsells', smw_slug ),
            ]
        );

            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 4,
                    'min' => 1,
                    'max' => 12,
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label' => __( 'Order By', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'date',
                    'options' => [
                        'date'          => __( 'Date', smw_slug ),
                        'title'         => __( 'Title', smw_slug ),
                        'price'         => __( 'Price', smw_slug ),
                        'popularity'    => __( 'Popularity', smw_slug ),
                        'rating'        => __( 'Rating', smw_slug ),
                        'rand'          => __( 'Random', smw_slug ),
                        'menu_order'    => __( 'Menu Order', smw_slug ),
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
                        'asc'   => __( 'ASC', smw_slug ),
                        'desc'  => __( 'DESC', smw_slug ),
                    ],
                ]
            );

            $this->add_control(
                'sm_show_heading',
                [
                    'label' => __( 'Heading', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', smw_slug ),
                    'label_off' => __( 'Hide', smw_slug ),
                    'render_type' => 'ui',
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'prefix_class' => 'sm-show-heading-',
                ]
            );

        $this->end_controls_section();

        // Heading Style
        $this->start_controls_section(
            'heading_style_section',
            array(
                'label' => __( 'Heading', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'heading_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .up-sells > h2' => 'color: {{VALUE}} !important',
                    ],
                    'condition' => [
                        'sm_show_heading!' => '',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'heading_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} .up-sells > h2',
                    'condition' => [
                        'sm_show_heading!' => '',
                    ],
                ]
            );

            $this->add_responsive_control(
                'heading_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .up-sells > h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                    'condition' => [
                        'sm_show_heading!' => '',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $product_per_page   = '-1';
        $columns            = 4;
        $orderby            = 'rand';
        $order              = 'desc';
        
        if ( ! empty( $settings['columns'] ) ) 
        {
            $columns = $settings['columns'];
        }
        if ( ! empty( $settings['orderby'] ) ) 
        {
            $orderby = $settings['orderby'];
        }
        if ( ! empty( $settings['order'] ) ) 
        {
            $order = $settings['order'];
        }
        if( \Elementor\Plugin::instance()->editor->is_edit_mode() )
        {
            woocommerce_upsell_display( $product_per_page, $columns, $orderby, $order );
        }else{
            woocommerce_upsell_display( $product_per_page, $columns, $orderby, $order );
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_product_upsell() );