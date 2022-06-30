<?php

/**
 * Stiles Media Widgets Call For Price.
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

class stiles_wc_call_for_price extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'call-for-price-style', plugin_dir_url( __FILE__ ) . '../css/call-for-price.css');
    }
    
    public function get_name() 
    {
        return 'stiles-call-for-price';
    }
    
    public function get_title() 
    {
        return __( 'Call For Price', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-price';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'call-for-price-style' ];
    }
    
    protected function register_controls() 
    {
        $this->call_for_price_section();
        
        $this->button_style();
    }
    
    protected function call_for_price_section()
    {
        $this->start_controls_section(
            'button_call_price',
            array(
                'label' => esc_html__( 'Call For Price', smw_slug ),
            )
        );

            $this->add_control(
                'button_text',
                array(
                    'label' => __( 'Button Text', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Call For Price', smw_slug ),
                    'placeholder' => __( 'Call For Price', smw_slug ),
                    'label_block' => true,
                )
            );

            $this->add_control(
                'button_phone_number',
                array(
                    'label' => __( 'Button Phone Number', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( '123-456-7890', smw_slug ),
                    'placeholder' => __( '123-456-7890', smw_slug ),
                    'label_block' => true,
                )
            );

        $this->end_controls_section();
    }
    
    protected function button_style()
    {
        $this->start_controls_section(
            'button_style',
            array(
                'label' => __( 'Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->start_controls_tabs('button_normal_style_tabs');
                
                // Button Normal tab
                $this->start_controls_tab(
                    'button_normal_style_tab',
                    array(
                        'label' => __( 'Normal', smw_slug ),
                    )
                );
                    
                    $this->add_control(
                        'button_color',
                        array(
                            'label'     => __( 'Text Colour', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .smw-call-for-price a' => 'color: {{VALUE}};',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'button_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} .smw-call-for-price a',
                        )
                    );

                    $this->add_control(
                        'button_padding',
                        array(
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', 'em' ),
                            'selectors' => array(
                                '{{WRAPPER}} .smw-call-for-price a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                        )
                    );

                    $this->add_control(
                        'button_margin',
                        array(
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', 'em' ),
                            'selectors' => array(
                                '{{WRAPPER}} .smw-call-for-price a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        array(
                            'name' => 'button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .smw-call-for-price a',
                        )
                    );

                    $this->add_control(
                        'button_border_radius',
                        array(
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => array(
                                '{{WRAPPER}} .smw-call-for-price a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ),
                        )
                    );

                    $this->add_control(
                        'button_background_color',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .smw-call-for-price a' => 'background-color: {{VALUE}}',
                            ),
                        )
                    );

                $this->end_controls_tab();

                // Button Hover tab
                $this->start_controls_tab(
                    'button_hover_style_tab',
                    array(
                        'label' => __( 'Hover', smw_slug ),
                    )
                ); 
                    
                    $this->add_control(
                        'button_hover_color',
                        array(
                            'label'     => __( 'Text Colour', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .smw-call-for-price a:hover' => 'color: {{VALUE}};',
                            ),
                        )
                    );

                    $this->add_control(
                        'button_hover_background_color',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .smw-call-for-price a:hover' => 'background-color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_control(
                        'button_hover_border_color',
                        array(
                            'label' => __( 'Border Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .smw-call-for-price a:hover' => 'border-color: {{VALUE}}',
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

        $this->add_render_attribute( 'link_attr', 'href', 'tel:'.$settings['button_phone_number'] );
        ?>
            <div class="smw-call-for-price">
                <a <?php echo $this->get_render_attribute_string( 'link_attr' ); ?> ><?php echo esc_html__( $settings['button_text'], 'woolentor' ); ?></a>
            </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_call_for_price() );