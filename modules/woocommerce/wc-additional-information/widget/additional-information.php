<?php

/**
 * Stiles Media Widgets Additional Information.
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

class stiles_wc_additional_information extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-product-additional-information';
    }
    
    public function get_title() 
    {
        return __( 'Product: Additional Information', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-info';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        $this->register_slider_button();
        
        $this->register_heading_style();
        
        $this->register_content_style();
    }
    
    protected function register_slider_button()
    {
        // Slider Button style
        $this->start_controls_section(
            'addition_info_content',
            array(
                'label' => __( 'Heading', smw_slug ),
            )
        );
            
            $this->add_control(
                'sm_show_heading',
                array(
                    'label' => __( 'Heading', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', smw_slug ),
                    'label_off' => __( 'Hide', smw_slug ),
                    'render_type' => 'ui',
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'prefix_class' => 'wl-show-heading-',
                )
            );

        $this->end_controls_section();
    }
    
    protected function register_heading_style()
    {
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
                array(
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} h2' => 'color: {{VALUE}}',
                    ),
                    'condition' => array(
                        'sm_show_heading!' => '',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'heading_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} h2',
                    'condition' => array(
                        'sm_show_heading!' => '',
                    ),
                )
            );

            $this->add_responsive_control(
                'heading_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%', 'em' ),
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                )
            );

        $this->end_controls_section();
    }

    protected function register_content_style()
    {
        // Content Style
        $this->start_controls_section(
            'content_style_section',
            array(
                'label' => __( 'Content', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'content_color',
                array(
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .shop_attributes' => 'color: {{VALUE}}',
                    ),
                    'separator' => 'before',
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'content_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} .shop_attributes',
                )
            ); 

        $this->end_controls_section();
    }
    
    protected function render( $instance = [] ) 
    {
        $settings   = $this->get_settings_for_display();
        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) 
        {
                ob_start();
                wc_get_template( 'single-product/tabs/additional-information.php' );
                echo ob_get_clean();
        } else
        {
            global $product;
            $product = wc_get_product();
            if ( empty( $product ) ) 
            {
                return;
            }
            
            wc_get_template( 'single-product/tabs/additional-information.php' );
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_additional_information() );