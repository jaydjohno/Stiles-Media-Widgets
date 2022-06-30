<?php

/**
 * Stiles Media Widgets Product Title.
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

class stiles_wc_product_title extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-product-title';
    }
    
    public function get_title() 
    {
        return __( 'Product Title', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-title';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        $this->button_style();
        
        $this->product_style();
    }
    
    protected function button_style()
    {
        // Slider Button style
        $this->start_controls_section(
            'product_title_content',
            array(
                'label' => __( 'Product Title', smw_slug ),
            )
        );
            $this->add_control(
                'product_title_html_tag',
                array(
                    'label'   => __( 'Title HTML Tag', smw_slug ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => [
    					'h1'   => __( 'H1', smw_slug ),
                        'h2'   => __( 'H2', smw_slug ),
                        'h3'   => __( 'H3', smw_slug ),
                        'h4'   => __( 'H4', smw_slug ),
                        'h5'   => __( 'H5', smw_slug ),
                        'h6'   => __( 'H6', smw_slug ),
                        'p'    => __( 'p', smw_slug ),
                        'div'  => __( 'div', smw_slug ),
                        'span' => __( 'span', smw_slug ),
    				],
                    'default' => 'h1',
                )
            );

        $this->end_controls_section();
    }
    
    protected function product_style()
    {
        // Product Style
        $this->start_controls_section(
            'product_style_section',
            array(
                'label' => __( 'Product Title', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_control(
                'product_title_color',
                array(
                    'label'     => __( 'Title Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .product_title' => 'color: {{VALUE}} !important;',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'product_title_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .product_title',
                )
            );

            $this->add_responsive_control(
                'product_title_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%', 'em' ),
                    'selectors' => array(
                        '{{WRAPPER}} .product_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ),
                    'separator' => 'before',
                )
            );

            $this->add_responsive_control(
                'product_title_align',
                array(
                    'label'        => __( 'Alignment', smw_slug ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => array(
                        'left'   => array(
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'fa fa-align-left',
                        ),
                        'center' => array(
                            'title' => __( 'Center', smw_slug ),
                            'icon'  => 'fa fa-align-center',
                        ),
                        'right'  => array(
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'fa fa-align-right',
                        ),
                    ),
                    'prefix_class' => 'elementor-align-%s',
                    'default'      => 'left',
                )
            );

        $this->end_controls_section();
    }
    
    protected function render()
    {
        global $product;
        $settings   = $this->get_settings_for_display();
        
        if( \Elementor\Plugin::instance()->editor->is_edit_mode() )
        {
            $title = get_the_title( $product->get_id() );
            echo sprintf( '<%1$s class="product_title entry-title">' . __( $title, smw_slug ). '</%1$s>', $settings['product_title_html_tag'] );
        }else
        {
            echo sprintf( the_title( '<%1$s class="product_title entry-title">', '</%1s>', false ), $settings['product_title_html_tag']  );
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_product_title() );