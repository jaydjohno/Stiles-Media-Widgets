<?php

/**
 * Stiles Media Widgets Product Data Tabs.
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

class stiles_wc_data_tabs extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-product-data-tabs';
    }
    
    public function get_title() 
    {
        return __( 'Product: Data Tabs', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-tabs';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    public function product_content( $content )
    {
        global $product;
        
        $product_content = get_post( $product->get_id() );
        $content = $product_content->post_content;
        return $content;
    }
    
    protected function register_controls() 
    {
        $this->product_tabs_style();
        
        $this->content_style();
    }
    
    protected function product_tabs_style()
    {
        // Product Style
        $this->start_controls_section(
            'product_tabs_style_section',
            array(
                'label' => __( 'Tab Menu', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->start_controls_tabs( 'data_tabs_style' );

                $this->start_controls_tab( 'normal_data_tab_style',
                    array(
                        'label' => __( 'Normal', smw_slug ),
                    )
                );

                    $this->add_control(
                        'tab_text_color',
                        array(
                            'label' => __( 'Text Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a' => 'color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_control(
                        'tab_background_color',
                        array(
                            'label' => __( 'Background Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'background-color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_control(
                        'tab_border_color',
                        array(
                            'label' => __( 'Border Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-color: {{VALUE}}',
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name' => 'tab_typography',
                            'label' => __( 'Typography', smw_slug ),
                            'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a',
                        )
                    );

                    $this->add_control(
                        'tab_border_radius',
                        array(
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::SLIDER,
                            'selectors' => array(
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
                            ),
                        )
                    );

                    $this->add_responsive_control(
                        'tab_text_align',
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
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs' => 'text-align: {{VALUE}}',
                            ),
                        )
                    );

                $this->end_controls_tab();
                
                // Active Tab style
                $this->start_controls_tab( 'active_data_tab_style',
                    array(
                        'label' => __( 'Active', smw_slug ),
                    )
                );

                    $this->add_control(
                        'active_tab_text_color',
                        array(
                            'label' => __( 'Text Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active a' => 'color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_control(
                        'active_tab_background_color',
                        array(
                            'label' => __( 'Background Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel, .woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'background-color: {{VALUE}}',
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-bottom-color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_control(
                        'active_tab_border_color',
                        array(
                            'label' => __( 'Border Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-color: {{VALUE}}',
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-color: {{VALUE}} {{VALUE}} {{active_tab_bg_color.VALUE}} {{VALUE}}',
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li:not(.active)' => 'border-bottom-color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name' => 'active_tab_typography',
                            'label' => __( 'Typography', smw_slug ),
                            'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active a',
                        )
                    );

                    $this->add_control(
                        'active_tab_border_radius',
                        array(
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::SLIDER,
                            'selectors' => array(
                                '.woocommerce {{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
                            ),
                        )
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function content_style()
    {
        // Content Style
        $this->start_controls_section(
            'product_data_tab_content_style',
            array(
                'label' => __( 'Content', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'tab_description_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel',
                )
            );

            $this->add_control(
                'tab_content_description_color',
                array(
                    'label' => __( 'Text Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel' => 'color: {{VALUE}}',
                    ),
                    'separator' => 'after',
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'content_heading_typography',
                    'label' => __( 'Heading Typography', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel h2',
                )
            );

            $this->add_control(
                'content_heading_color',
                array(
                    'label' => __( 'Heading Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel h2' => 'color: {{VALUE}}',
                    ),
                )
            );

            $this->add_control(
                'content_heading_margin',
                array(
                    'label' => __( 'Heading Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .woocommerce-Tabs-panel h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ),
                )
            );

        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings   = $this->get_settings_for_display();
        global $product;

        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) 
        {
            setup_postdata( $product->get_id() );

            if( get_post_type() == 'elementor_library' )
            {
                add_filter( 'the_content', [ $this, 'product_content' ] );
            }
            echo wc_get_template( 'single-product/tabs/tabs.php' );
        }else
        {
            if ( empty( $product ) ) 
            {
                return;
            }
            
            setup_postdata( $product->get_id() );
            
            wc_get_template( 'single-product/tabs/tabs.php' );
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_data_tabs() );