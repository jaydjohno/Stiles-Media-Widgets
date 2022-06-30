<?php

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

class stiles_wc_rating extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-single-product-rating';
    }

    public function get_title() {
        return __( 'Product Rating', smw_slug );
    }

    public function get_icon() {
        return 'eicon-product-rating';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        // Product Rating Style
        $this->start_controls_section(
            'product_rating_style_section',
            array(
                'label' => __( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'product_rating_colour',
                [
                    'label'     => __( 'Star Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .star-rating' => 'color: {{VALUE}} !important;',
                        '{{WRAPPER}} .woocommerce-product-rating' => 'color: {{VALUE}} !important;',
                    ],
                ]
            );

            $this->add_control(
                'product_rating_text_colour',
                [
                    'label'     => __( 'Link Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} a.woocommerce-review-link' => 'color: {{VALUE}} !important;',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'product_rating_link_typography',
                    'label'     => __( 'Link Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} a.woocommerce-review-link',
                )
            );

            $this->add_control(
                'rating_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '.woocommerce {{WRAPPER}} .woocommerce-product-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                ]
            );
            
            $this->add_responsive_control(
				'rating_text_align',
				array(
					'label'      => __( 'Alignment', smw_slug ),
					'type'       => Controls_Manager::CHOOSE,
					'options'    => array(
						'flex-start' => array(
							'title' => __( 'Left', smw_slug ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => __( 'Center', smw_slug ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => __( 'Right', smw_slug ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'separator'  => 'before',
					'default'    => 'flex-left',
					'selectors'  => array(
						'{{WRAPPER}} .woocommerce-product-rating' => 'justify-content: {{VALUE}};',
					),
				)
			);

        $this->end_controls_section();
    }


    protected function render( $instance = [] ) 
    {
        $settings = $this->get_settings_for_display();
        global $product;
        $product = wc_get_product();
        $is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();

        if( $is_editor )
        { ?>
            <div class="woocommerce-product-rating">
		        <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
		            <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating</span>
		        </div>								
		        <a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<span class="count">1</span> customer review)</a>
			</div>
        <?php
        } else
        {
            if ( empty( $product ) ) 
            { 
                return; 
            }
            woocommerce_template_single_rating();
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_rating() );