<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Base;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WC_Product_Empty_Cart_Message extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-empty-cart-message';
    }
    
    public function get_title() 
    {
        return __( 'Empty Cart: Message', smw_slug );
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
        // Product Content
        $this->start_controls_section(
            'empty_cart_content',
            [
                'label' => esc_html__( 'Content', smw_slug ),
            ]
        );
            
            $this->add_control(
                'cart_custom_message',
                [
                    'label' => __( 'Custom Message', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( 'Enter your custom message', smw_slug ),
                    'label_block'=>true,
                ]
            );

        $this->end_controls_section();
        
        // Style
        $this->start_controls_section(
            'cart_custom_message_style',
            array(
                'label' => __( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_control(
                'cart_custom_message_color',
                [
                    'label' => __( 'Text Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-info' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'cart_custom_message_border_color',
                [
                    'label' => __( 'Border Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-info' => 'border-top-color: {{VALUE}};',
                        '{{WRAPPER}} .woocommerce-info::before' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'cart_custom_message_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }

    protected function render() 
    {
        add_filter( 'wc_empty_cart_message', [ $this, 'custom_empty_cart_text' ], 1 );
        /*
         * @hooked wc_empty_cart_message - 10
         */
        do_action( 'woocommerce_cart_is_empty' );
    }

    public function custom_empty_cart_text( $text )
    {
        $settings  = $this->get_settings_for_display();
        
        if( !empty( $settings['cart_custom_message'] ) )
        {
            return $settings['cart_custom_message'];
        }else
        {
            return $text;
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new WC_Product_Empty_Cart_Message() );