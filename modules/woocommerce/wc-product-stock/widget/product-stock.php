<?php

/**
 * Stiles Media Widgets Product Stock.
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

class stiles_wc_product_stock extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-product-stock';
    }
    
    public function get_title() 
    {
        return __( 'Product Stock', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-stock';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        // Product Price Style
        $this->start_controls_section(
            'product_stock_style_section',
            array(
                'label' => __( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'stock_text_color',
                array(
                    'label' => __( 'Text Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .stock' => 'color: {{VALUE}} !important',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'stock_text_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} .stock',
                )
            );

            $this->add_responsive_control(
                'stock_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', 'em' ),
                    'selectors' => array(
                        '{{WRAPPER}} .stock' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ),
                )
            );

        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings   = $this->get_settings_for_display();
        global $product;
        $product = wc_get_product();
        
        if( \Elementor\Plugin::instance()->editor->is_edit_mode() )
        {
            $availability = $product->get_availability();
            ?>
            <div class="product"><p class="stock <?php echo esc_attr( $availability['class'] ); ?>"><?php echo wp_kses_post( $availability['availability'] ); ?></p></div>
            <?php
        } else
        {
            if ( empty( $product ) ) 
            { 
                return; 
            }
            
            echo wc_get_stock_html( $product );
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_product_stock() );