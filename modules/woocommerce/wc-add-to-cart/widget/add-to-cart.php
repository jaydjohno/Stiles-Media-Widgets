<?php

/**
 * Stiles Media Widgets Add to Cart.
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

class stiles_wc_add_to_cart extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-add-to-cart';
    }
    
    public function get_title() 
    {
        return __( 'Add To cart', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-add-to-cart';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        $this->start_controls_section(
            'add_to_cart_button_style',
            array(
                'label' => __( 'Button', 'woolentor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->start_controls_tabs('button_normal_style_tabs');
                
                // Button Normal tab
                $this->start_controls_tab(
                    'button_normal_style_tab',
                    array(
                        'label' => __( 'Normal', 'woolentor' ),
                    )
                );
                    
                    $this->add_control(
                        'button_color',
                        array(
                            'label'     => __( 'Text Color', 'woolentor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .cart button' => 'color: {{VALUE}} !important;',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'button_typography',
                            'label'     => __( 'Typography', 'woolentor' ),
                            'selector'  => '{{WRAPPER}} .cart button',
                        )
                    );

                    $this->add_control(
                        'button_padding',
                        array(
                            'label' => __( 'Padding', 'woolentor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', 'em' ),
                            'selectors' => array(
                                '{{WRAPPER}} .cart button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'button_margin',
                        array(
                            'label' => __( 'Margin', 'woolentor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', 'em' ),
                            'selectors' => array(
                                '.woocommerce {{WRAPPER}} form.cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        array(
                            'name' => 'button_border',
                            'label' => __( 'Border', 'woolentor' ),
                            'selector' => '{{WRAPPER}} .cart button',
                        )
                    );

                    $this->add_control(
                        'button_border_radius',
                        array(
                            'label' => __( 'Border Radius', 'woolentor' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => array(
                                '{{WRAPPER}} .cart button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'button_background_color',
                        array(
                            'label' => __( 'Background Color', 'woolentor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .cart button' => 'background-color: {{VALUE}} !important',
                            ),
                        )
                    );

                $this->end_controls_tab();

                // Button Hover tab
                $this->start_controls_tab(
                    'button_hover_style_tab',
                    array(
                        'label' => __( 'Hover', 'woolentor' ),
                    )
                ); 
                    
                    $this->add_control(
                        'button_hover_color',
                        array(
                            'label'     => __( 'Text Color', 'woolentor' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .cart button:hover' => 'color: {{VALUE}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'button_hover_background_color',
                        array(
                            'label' => __( 'Background Color', 'woolentor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .cart button:hover' => 'background-color: {{VALUE}} !important',
                            ),
                        )
                    );

                    $this->add_control(
                        'button_hover_border_color',
                        array(
                            'label' => __( 'Border Color', 'woolentor' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .cart button:hover' => 'border-color: {{VALUE}} !important',
                            ),
                        )
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();
            
        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings = $this->get_settings();
        global $product;
        $product = wc_get_product();
        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) 
        {
            echo '<div class="product">';
            do_action( 'woocommerce_' . $product->get_type() . '_add_to_cart' );
            echo '</div>';
        }else
        {
            if ( empty( $product ) ) 
            { 
                return; 
            }
            ?>
                <div class="<?php echo esc_attr( wc_get_product()->get_type() ); ?>">
                    <?php woocommerce_template_single_add_to_cart(); ?>
                </div>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_add_to_cart() );