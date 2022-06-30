<?php

/**
 * Stiles Media Widgets Product Description.
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

class stiles_wc_product_description extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-product-description';
    }
    
    public function get_title() 
    {
        return __( 'Product Description', smw_slug );
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
        // Product Style
        $this->start_controls_section(
            'product_style_section',
            array(
                'label' => __( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_responsive_control(
                'text_align',
                array(
                    'label' => __( 'Alignment', smw_slug ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => array(
                        'left' => array(
                            'title' => __( 'Left', smw_slug ),
                            'icon' => 'fa fa-align-left',
                        ),
                        'center' => array(
                            'title' => __( 'Center', smw_slug ),
                            'icon' => 'fa fa-align-center',
                        ),
                        'right' => array(
                            'title' => __( 'Right', smw_slug ),
                            'icon' => 'fa fa-align-right',
                        ),
                        'justify' => array(
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ),
                    ),
                    'selectors' => array(
                        '{{WRAPPER}}' => 'text-align: {{VALUE}}',
                    ),
                )
            );

            $this->add_control(
                'text_color',
                array(
                    'label' => __( 'Text Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .woocommerce_product_description' => 'color: {{VALUE}} !important',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'text_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} .woocommerce_product_description',
                )
            );

        $this->end_controls_section();

    }
    
    protected function render( $instance = [] ) {
       global $product, $post;
        $product = wc_get_product();
        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) 
        {
            $description = get_post_field( 'post_content', $product->get_id() );
            
            if ( empty( $description ) ) 
            { 
                return; 
            }
            
            echo $description;
        }else
        {
            if ( empty( $product ) ) 
            { 
                return; 
            }
            
            echo '<div class="woocommerce_product_description">' . $post->post_content . '</div>';
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_product_description() );