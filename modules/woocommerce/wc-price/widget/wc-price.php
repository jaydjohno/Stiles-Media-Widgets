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

class stiles_wc_price extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'wc-price-style', plugin_dir_url( __FILE__ ) . '../css/wc-price.css');
    }
    
    public function get_name() 
    {
        return 'stiles-single-product-price';
    }

    public function get_title() {
        return __( 'Product Price', smw_slug );
    }

    public function get_icon() {
        return 'eicon-product-price';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'wc-price-style'];
    }

    protected function register_controls() 
    {
        $this->price_options();
        
        $this->register_price_style();
        
        $this->register_sale_style();
        
        $this->price_background_style();
    }
    
    protected function price_options()
    {
        $this->start_controls_section(
			'preview_section',
			array(
				'label' => __( 'Preview', smw_slug ),
			)
		);
		
		    $this->add_responsive_control(
				'price_text_align',
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
						'{{WRAPPER}} .price' => 'justify-content: {{VALUE}};',
					),
				)
			);
			
    		$this->add_control(
    			'preview_price',
    			array(
    				'label' => __( 'Border Style', smw_slug ),
    				'type' => \Elementor\Controls_Manager::SELECT,
    				'default' => 'normal',
    				'options' => array(
    					'normal'  => __( 'Normal Price', smw_slug ),
    					'sale' => __( 'Sale Price', smw_slug ),
    				),
    			)
    		);
    		
        	$this->add_control(
    			'normal_price',
    			array(
    				'label' => __( 'Normal Price', smw_slug ),
    				'type' => \Elementor\Controls_Manager::TEXT,
    				'default' => __( '29.95', smw_slug ),
    				'placeholder' => __( 'Enter normal price', smw_slug ),
    			)
    		);
    		
    		$this->add_control(
    			'sale_price',
    			array(
    				'label' => __( 'Normal Price', smw_slug ),
    				'type' => \Elementor\Controls_Manager::TEXT,
    				'default' => __( '25.95', smw_slug ),
    				'placeholder' => __( 'Enter sale price', smw_slug ),
    				'condition'   => array(
                        'preview_price' => 'sale',
                    ),
    			)
    		);
    		
		
		$this->end_controls_section();
    }
    
    protected function register_price_style()
    {
        // Product Price Style
        $this->start_controls_section(
            'product_price_regular_style_section',
            array(
                'label' => __( 'Regular Price', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'product_price_colour',
                array(
                    'label'     => __( 'Price Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .price ' => 'color: {{VALUE}} !important;',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'product_price_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .price , {{WRAPPER}} .price .amount',
                )
            );

            $this->add_control(
                'price_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', 'em' ),
                    'selectors' => array(
                        '{{WRAPPER}} .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ),
                )
            );

        $this->end_controls_section();
    }
    
    protected function register_sale_style()
    {
        $this->start_controls_section(
            'product_price_sale_style_section',
            array(
                'label' => __( 'Sale Price', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'product_sale_price_colour',
                array(
                    'label'     => __( 'Price Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .price del' => 'color: {{VALUE}} !important;',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'product_sale_price_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .price del, {{WRAPPER}} .price del .amount',
                )
            );
            
             $this->add_control(
                'sale_price_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', 'em' ),
                    'selectors' => array(
                        '{{WRAPPER}} .price del' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ),
                )
            );

        $this->end_controls_section();
    }
    
    protected function price_background_style()
    {
        $this->start_controls_section(
			'price_background_section',
			array(
				'label' => __( 'Background', smw_slug ),
				'tab' => Controls_Manager::TAB_STYLE,
			)
		);
			
			$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name' => 'background',
				'label' => __( 'Background', smw_slug ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .price',
			)
		);
		
		$this->end_controls_section();
    }

    protected function render( $instance = [] ) 
    {
        $settings   = $this->get_settings_for_display();
        $is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();

        global $product;
        $product = wc_get_product();

        if( $is_editor )
        {
            if( $settings['preview_price'] === 'normal' )
            {
                echo '<p class="price"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>' . $settings['normal_price'] . '</span></p>';
            }
            else
            {
                echo '<p class="price"><del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>' . $settings['normal_price'] . '</span></del> <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">£</span>' . $settings['sale_price'] . '</span></ins></p>';
            }

        }else
        {
            if ( empty( $product ) ) 
            { 
                return;
            }
            
            woocommerce_template_single_price();
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_price() );