<?php

/**
 * Stiles Media Widgets Short Description.
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

class stiles_wc_short_description extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-short-description';
    }
    
    public function get_title() 
    {
        return __( 'Product Short Description', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-description';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        // Style
        $this->start_controls_section(
            'product_content_style_section',
            array(
                'label' => __( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_responsive_control(
                'text_align',
                [
                    'label' => __( 'Alignment', smw_slug ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', smw_slug ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}}' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'text_color',
                [
                    'label' => __( 'Text Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .woocommerce-product-details__short-description' => 'color: {{VALUE}}',
                        '.woocommerce {{WRAPPER}} .woocommerce-product-details__short-description p' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'text_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} .woocommerce-product-details__short-description,.woocommerce {{WRAPPER}} .woocommerce-product-details__short-description p',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function render()
    {
        global $product;
        $product = wc_get_product();
        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) 
        {
            $short_description = get_the_excerpt( $product->get_id() );
            $short_description = apply_filters( 'woocommerce_short_description', $short_description );
            if ( empty( $short_description ) ) 
            { 
                return;
            }
            ?>
                <div class="woocommerce-product-details__short-description"><?php echo wp_kses_post( $short_description ); ?></div>
            <?php
        }else{
            if ( empty( $product ) ) 
            {
                return;
            }
            wc_get_template( 'single-product/short-description.php' );
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_short_description() );