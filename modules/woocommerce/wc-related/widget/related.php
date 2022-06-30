<?php

/**
 * Stiles Media Widgets Related Products.
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
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class stiles_wc_related_products extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'product-related-style', plugin_dir_url( __FILE__ ) . '../css/related.css');
    }
    
    public function get_name() 
    {
        return 'stiles-product-related';
    }
    
    public function get_title() 
    {
        return __( 'Related Products', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-related';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'product-related-style' ];
    }
    
    protected function register_controls()
    {
        $this->start_controls_section(
            'product_related_content',
            [
                'label' => __( 'Related Product', smw_slug ),
            ]
        );
            $this->add_control(
                'posts_per_page',
                [
                    'label' => __( 'Products Per Page', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 4,
                    'range' => [
                        'px' => [
                            'max' => 20,
                        ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'prefix_class' => 'elementor-products-columns%s-',
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
                        'date' => __( 'Date', smw_slug ),
                        'title' => __( 'Title', smw_slug ),
                        'price' => __( 'Price', smw_slug ),
                        'popularity' => __( 'Popularity', smw_slug ),
                        'rating' => __( 'Rating', smw_slug ),
                        'rand' => __( 'Random', smw_slug ),
                        'menu_order' => __( 'Menu Order', smw_slug ),
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
                        'asc' => __( 'ASC', smw_slug ),
                        'desc' => __( 'DESC', smw_slug ),
                    ],
                ]
            );

            $this->add_control(
                'show_heading',
                [
                    'label' => __( 'Heading', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_off' => __( 'Hide', smw_slug ),
                    'label_on' => __( 'Show', smw_slug ),
                    'default' => 'yes',
                    'return_value' => 'yes',
                    'prefix_class' => 'smshow-heading-',
                ]
            );

        $this->end_controls_section();

        // Product Style
        $this->start_controls_section(
            'related_heading_style_section',
            array(
                'label' => __( 'Heading', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_control(
                'related_heading_color',
                [
                    'label'     => __( 'Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-sm-product-related .products > h2' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'related_heading_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}}.elementor-widget-sm-product-related .products > h2',
                )
            );

            $this->add_responsive_control(
                'related_heading_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-sm-product-related .products > h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'related_heading_align',
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
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-sm-product-related .products > h2'   => 'text-align: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }

    protected function render( $instance = [] ) 
    {
        $settings = $this->get_settings_for_display();

        global $product;
        $product = wc_get_product();

        if( Plugin::instance()->editor->is_edit_mode() )
        {
            if ( ! $product ) 
            { 
                return; 
            }
                $args = [
                    'posts_per_page' => 4,
                    'columns' => 4,
                    'orderby' => $settings['orderby'],
                    'order' => $settings['order'],
                ];
                
                if ( ! empty( $settings['posts_per_page'] ) ) 
                {
                    $args['posts_per_page'] = $settings['posts_per_page'];
                }
                
                if ( ! empty( $settings['columns'] ) ) 
                {
                    $args['columns'] = $settings['columns'];
                }

                $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), 
                    $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );

                $args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

                wc_get_template( 'single-product/related.php', $args );
        } else
        {
            if ( ! $product ) 
            { 
                return; 
            }
            
            $args = [
                'posts_per_page' => 4,
                'columns' => 4,
                'orderby' => $settings['orderby'],
                'order' => $settings['order'],
            ];
            if ( ! empty( $settings['posts_per_page'] ) ) 
            {
                $args['posts_per_page'] = $settings['posts_per_page'];
            }
            if ( ! empty( $settings['columns'] ) ) 
            {
                $args['columns'] = $settings['columns'];
            }

            // Get related Product
            $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), 
            $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
            $args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );
            
            wc_get_template( 'single-product/related.php', $args );
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_related_products() );