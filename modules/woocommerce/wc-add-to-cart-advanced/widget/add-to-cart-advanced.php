<?php

/**
 * Stiles Media Widgets Add to Cart Advanced.
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

class stiles_wc_add_to_cart_advanced extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'add-to-cart-advanced-style', plugin_dir_url( __FILE__ ) . '../css/add-to-cart-advanced.css');
    }
    
    public function get_name() 
    {
        return 'stiles-add-to-cart-advanced';
    }
    
    public function get_title() 
    {
        return __( 'Add To cart: Advanced', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-add-to-cart';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'add-to-cart-advanced-style' ];
    }
    
    /**
     * Filter the variable template path to use our variable1.php template instead of the theme's
     */
    public function smw_locate_template1( $template, $template_name, $template_path ) 
    {
        $basename = basename( $template );
        if( $basename == 'variable.php' ) 
        {
            $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/templates/variable1.php';
        }
        return $template;
    }
    
    //template1 with no stock option
    public function smw_locate_template1_nostock( $template, $template_name, $template_path ) 
    {
        $basename = basename( $template );
        if( $basename == 'variable.php' ) 
        {
            $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/templates/variable1-nostock.php';
        }
        return $template;
    }
    
    /**
     * Filter the variable template path to use our variable2.php template instead of the theme's
     */
    public function smw_locate_template2( $template, $template_name, $template_path ) 
    {
        $basename = basename( $template );
        if( $basename == 'variable.php' ) 
        {
            $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/templates/variable2.php';
        }
        return $template;
    }
    
    //template 2 with no stock
    public function smw_locate_template2_nostock( $template, $template_name, $template_path ) 
    {
        $basename = basename( $template );
        if( $basename == 'variable.php' ) 
        {
            $template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'woocommerce/templates/variable2-nostock.php';
        }
        return $template;
    }
    
    protected function register_controls() 
    {
        $this->register_template_options();
        
        $this->register_cart_options();
        
        $this->register_spacing_controls();
        
        $this->register_alignment_controls();
        
        $this->register_stock_style();
        
        $this->register_plus_minus_button_style();
        
        $this->register_quantity_input_style();
        
        $this->register_cart_button_style();
    }
    
    protected function register_template_options()
    {
        $this->start_controls_section(
			'template_section',
			array(
				'label' => __( 'Templates', smw_slug ),
			)
		);
		
		    $this->add_control(
			'template_selection',
			array(
				'label' => __( 'Choose Your Template', smw_slug ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'template1',
				'options' => array(
					'template1'  => __( 'Template 1', smw_slug ),
					'template2' => __( 'Template 2', smw_slug ),
				),
			)
		);
		
		$this->end_controls_section();
    }
    
    protected function register_cart_options()
    {
        
        $this->start_controls_section(
			'options_section',
			array(
				'label' => __( 'Additional Options', smw_slug ),
			)
		);
		
    	    $this->add_control(
    		'show_stock',
        		array(
        			'label' => __( 'Show Stock', smw_slug ),
        			'type' => \Elementor\Controls_Manager::SWITCHER,
        			'label_on' => __( 'Show', smw_slug ),
        			'label_off' => __( 'Hide', smw_slug ),
        			'return_value' => 'yes',
        			'default' => 'yes',
        		)
    	    );
		 
		
		$this->end_controls_section();
    }
    
    protected function register_spacing_controls()
    {
        $this->start_controls_section(
			'spacing_section',
			array(
				'label' => __( 'Spacing', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
			)
		);
		
        $this->add_responsive_control(
				'rows_gap',
				array(
					'label'     => __( 'Rows Gap', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 20,
					),
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 60,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .spacing' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);
		
		$this->end_controls_section();
    }
    
    protected function register_alignment_controls()
    {
        $this->start_controls_section(
			'align_section',
			array(
				'label' => __( 'Alignment', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_responsive_control(
				'remaining_text_align',
				array(
					'label'      => __( 'Stock Alignment', smw_slug ),
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
					'condition'   => array(
                    'show_stock' => 'yes',
                    ),
					'selectors'  => array(
						'{{WRAPPER}} .stock-container' => 'justify-content: {{VALUE}};',
					),
				)
			);
			
			$this->add_responsive_control(
				'quantity_section_align',
				array(
					'label'      => __( 'Quantity Alignment', smw_slug ),
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
						'{{WRAPPER}} .quantity-container' => 'justify-content: {{VALUE}};',
					),
				)
			);
			
			$this->add_responsive_control(
				'add_to_cart_text_align',
				array(
					'label'      => __( 'Add to Cart Alignment', smw_slug ),
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
						'{{WRAPPER}} .button-container' => 'justify-content: {{VALUE}};',
					),
				)
			);
		
        $this->end_controls_section();
    }
    
    protected function register_stock_style()
    {
        $this->start_controls_section(
			'stock_section',
			array(
				'label' => __( 'Stock Level', smw_slug ),
				'condition'   => array(
                    'show_stock' => 'yes',
                 ),
                'tab' => Controls_Manager::TAB_STYLE,
			)
		);
		
            $this->add_control(
                'stock_colour',
                array(
                    'label'     => __( 'Stock Level Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .remaining' => 'color: {{VALUE}} !important;',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'stock_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .remaining',
                )
            );

            $this->add_control(
                'stock_padding',
                array(
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', 'em' ),
                    'selectors' => array(
                        '{{WRAPPER}} .remaining' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ),
                )
            );

            $this->add_control(
                'stock_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', 'em' ),
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .remaining' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                array(
                    'name' => 'stock_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .remaining',
                )
            );

            $this->add_control(
                'stock_border_radius',
                array(
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => array(
                        '{{WRAPPER}} .remaining' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ),
                )
            );

            $this->add_control(
                'stock_background_colour',
                array(
                    'label' => __( 'Background Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .remaining' => 'background-color: {{VALUE}} !important',
                    ),
                )
            );
        
		$this->end_controls_section();
    }
    
    protected function register_plus_minus_button_style()
    {
        $this->start_controls_section(
            'plus_minus_button_style',
            array(
                'label' => __( 'Plus / Minus Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        
            $this->start_controls_tabs('plus_minus_button_normal_style_tabs');
                
                // Button Normal tab
                $this->start_controls_tab(
                    'plus_minus_button_normal_style_tab',
                    array(
                        'label' => __( 'Normal', smw_slug ),
                    )
                );
                    
                    $this->add_control(
                        'plus_minus_button_colour',
                        array(
                            'label'     => __( 'Text Colour', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .plus' => 'color: {{VALUE}} !important;',
                                '{{WRAPPER}} .minus' => 'color: {{VALUE}} !important;',
                            ),
                        )
                    );
                    
                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'plus_minus_button_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} .typo',
                        )
                    );

                    $this->add_control(
                        'plus_minus_button_padding',
                        array(
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', 'em' ),
                            'selectors' => array(
                                '{{WRAPPER}} .plus' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                                '{{WRAPPER}} .minus' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'plus_minus_button_margin',
                        array(
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', 'em' ),
                            'selectors' => array(
                                '.woocommerce {{WRAPPER}} .plus' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                                '.woocommerce {{WRAPPER}} .minus' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        array(
                            'name' => 'plus_minus_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .typo',
                        )
                    );

                    $this->add_control(
                        'plus_minus_button_border_radius',
                        array(
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => array(
                                '{{WRAPPER}} .plus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                                '{{WRAPPER}} .minus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'plus_minus_button_background_colour',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .plus' => 'background-color: {{VALUE}} !important',
                                '{{WRAPPER}} .minus' => 'background-color: {{VALUE}} !important',
                            ),
                        )
                    );

                $this->end_controls_tab();
                
                // Button Hover tab
                $this->start_controls_tab(
                    'plus_minus_button_hover_style_tab',
                    array(
                        'label' => __( 'Hover', smw_slug ),
                    )
                ); 
                    
                    $this->add_control(
                        'plus_minus_button_hover_colour',
                        array(
                            'label'     => __( 'Text Color', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .plus:hover' => 'color: {{VALUE}} !important;',
                                '{{WRAPPER}} .minus:hover' => 'color: {{VALUE}} !important;',

                            ),
                        )
                    );

                    $this->add_control(
                        'plus_minus_button_hover_background_colour',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .plus:hover' => 'background-color: {{VALUE}} !important',
                                '{{WRAPPER}} .minus:hover' => 'background-color: {{VALUE}} !important',
                            ),
                        )
                    );

                    $this->add_control(
                        'plus_minus_button_hover_border_colour',
                        array(
                            'label' => __( 'Border Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .plus:hover' => 'border-color: {{VALUE}} !important',
                                '{{WRAPPER}} .minus:hover' => 'border-color: {{VALUE}} !important',
                            ),
                        )
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();
            
        $this->end_controls_section();
    }
    
    protected function register_quantity_input_style()
    {
        $this->start_controls_section(
            'quantity_input_style',
            array(
                'label' => __( 'Quantity Input', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        
            $this->add_control(
                'quantity_colour',
                array(
                    'label'     => __( 'Quantity Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .qty' => 'color: {{VALUE}} !important;',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'quantity_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .qty',
                )
            );

            $this->add_control(
                'quantity_padding',
                array(
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', 'em' ),
                    'selectors' => array(
                        '{{WRAPPER}} .qty' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ),
                )
            );

            $this->add_control(
                'quantity_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', 'em' ),
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .qty' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                array(
                    'name' => 'quantity_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .qty',
                )
            );

            $this->add_control(
                'quantity_border_radius',
                array(
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => array(
                        '{{WRAPPER}} .qty' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ),
                )
            );

            $this->add_control(
                'quantity_background_colour',
                array(
                    'label' => __( 'Background Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}} .qty' => 'background-color: {{VALUE}} !important',
                    ),
                )
            );
        
        $this->end_controls_section();
    }
    
    protected function register_cart_button_style()
    {
        $this->start_controls_section(
            'button_style',
            array(
                'label' => __( 'Add to Cart Button', smw_slug ),
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
                        'button_colour',
                        array(
                            'label'     => __( 'Text Colour', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .add_to_cart_button' => 'color: {{VALUE}} !important;',
                                '{{WRAPPER}} .cart button.single_add_to_cart_button' => 'color: {{VALUE}} !important;',
                            ),
                        )
                    );
                    
                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'button_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  =>  '{{WRAPPER}} .cart button.single_add_to_cart_button',
                        )
                    );

                    $this->add_control(
                        'button_padding',
                        array(
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', 'em' ),
                            'selectors' => array(
                                '{{WRAPPER}} .add_to_cart_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                                '{{WRAPPER}} .cart button.single_add_to_cart_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
                                '.woocommerce {{WRAPPER}} .add_to_cart_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                                '.woocommerce {{WRAPPER}} .cart button.single_add_to_cart_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        array(
                            'name' => 'button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .cart button.single_add_to_cart_button',
                        )
                    );

                    $this->add_control(
                        'button_border_radius',
                        array(
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => array(
                                '{{WRAPPER}} .add_to_cart_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                                '{{WRAPPER}} .cart button.single_add_to_cart_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'button_background_colour',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .add_to_cart_button' => 'background-color: {{VALUE}} !important',
                                '{{WRAPPER}} .cart button.single_add_to_cart_button' => 'background-color: {{VALUE}} !important',
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
                        'button_hover_colour',
                        array(
                            'label'     => __( 'Text Color', smw_slug ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .add_to_cart_button:hover' => 'color: {{VALUE}} !important;',
                                '{{WRAPPER}} .cart button.single_add_to_cart_button:hover' => 'color: {{VALUE}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'button_hover_background_colour',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .add_to_cart_button:hover' => 'background-color: {{VALUE}} !important',
                                '{{WRAPPER}} .cart button.single_add_to_cart_button:hover' => 'background-color: {{VALUE}} !important',
                            ),
                        )
                    );

                    $this->add_control(
                        'button_hover_border_colour',
                        array(
                            'label' => __( 'Border Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}} .add_to_cart_button:hover' => 'border-color: {{VALUE}} !important',
                                '{{WRAPPER}} .cart button.single_add_to_cart_button:hover' => 'border-color: {{VALUE}} !important',
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
        $is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();

        global $product;
        global $post;
        global $woocommerce;
        
        //remove all hidden divs
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($)
            {   
                $("div:empty").hide();
            });
        </script>
        <?php

        if ( $is_editor ) 
        {  
            if ( $product->get_type() == 'simple' ) 
            {
                if( $settings['template_selection'] == 'template1' )
                {
                ?>
                    <div class="simple">
                        <form action="?add-to-cart=751" class="cart stiles-add-cart" method="post" enctype="multipart/form-data">
                            <?php if( $settings['show_stock'] == 'yes' )
                            { ?>
                                <div class="stock-contaiiner spacing">
                                    <div class="remaining">20 left in stock</div>
                                </div>
                            <?php } ?>
                            <div class="quantity_container spacing">
                                <div class="minus-button"><button type="button" class="minus typo">-</button></div>	
                                <div class="quantity">
        				            <label class="screen-reader-text" for="quantity_5edf992dad261">Farm in a Box "Immune Boost" quantity</label>
        		                    <input id="quantity_5edf992dad261" class="input-text qty text" step="1" min="0" max="" name="quantity" value="1" title="Qty" size="4" placeholder="" inputmode="numeric">
        			            </div>
        	                    <div class="plus-button"><button type="button" class="plus typo">+</button></div>
        	                </div>
        	                <div class="button-container spacing">
        	                    <div class="wc-add-button"> 
        	                        <button type="submit" data-product_id="751" data-product_sku="TG_FIAB_IB" data-quantity="1" class="add_to_cart_button button product_type_simple single_add_to_cart_button">Add to basket</button>
        	                   </div>
        	               </div>                    
        	            </form>
                    
                    </div>
                <?php }
                if( $settings['template_selection'] == 'template2' )
                {
                ?>
                    <div class="simple">
                        <?php if( $settings['show_stock'] == 'yes' )
                        { ?>
                            <p class="stock in-stock">5 in stock</p>
                        <?php } ?>
                        <form class="cart" action="http://new-theme.stilestesting.com/product/test/" method="post" enctype="multipart/form-data">
                            <div class="quantity">
                                <label class="screen-reader-text" for="quantity_5ee621035a6c0">test quantity</label>
                                <input id="quantity_5ee621035a6c0" class="input-text qty text" step="1" min="1" max="5" name="quantity" value="1" title="Qty" size="4" placeholder="" inputmode="numeric">
                            </div>
                        	<button type="submit" name="add-to-cart" value="531" class="single_add_to_cart_button button alt">Add to basket</button>
                        </form>
                    </div>
                <?php }
            }
            elseif ( $product->get_type() == 'variable' ) 
            {
                
                if( $settings['template_selection'] == 'template1' )
                {
                    if( $settings['show_stock'] == 'yes' )
                    {
                        add_filter( 'woocommerce_locate_template', array( $this, 'smw_locate_template1' ), 10, 3 );
                    }
                    else
                    {
                        add_filter( 'woocommerce_locate_template', array( $this, 'smw_locate_template1_nostock' ), 10, 3 );
                    }
                    
                    ?>

                    <div class="<?php echo esc_attr( wc_get_product()->get_type() ); ?>">
                        <?php woocommerce_template_single_add_to_cart(); ?>
                    </div>
                    <?php
                }
                if( $settings['template_selection'] == 'template2' )
                {
                    if( $settings['show_stock'] == 'yes' )
                    {
                        add_filter( 'woocommerce_locate_template', array( $this, 'smw_locate_template2' ), 10, 3 );
                    }
                    else
                    {
                        add_filter( 'woocommerce_locate_template', array( $this, 'smw_locate_template2_nostock' ), 10, 3 );
                    }
                    
                    ?>
                    <div class="<?php echo esc_attr( wc_get_product()->get_type() ); ?>">
                        <?php woocommerce_template_single_add_to_cart(); ?>
                    </div>
                    <?php
                }
            }
        }elseif ( ! $is_editor )
        {
            if( is_product() )
            {
                if ( ! $product->is_in_stock() )
                { ?>
                    <a href="<?php echo apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->get_id() ) ); ?>" class="button"><?php echo apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', 'woocommerce' ) ); ?></a>
                <?php }
                else
                {
                    $link = array(
                        'url'   => '',
                        'label' => '',
                        'class' => ''
                    );
        
                    switch ( $product->get_type() ) 
                    {
                        case "variable" :
                            $link['url']    = apply_filters( 'variable_add_to_cart_url', get_permalink( $product->get_id() ) );
                            $link['label']  = apply_filters( 'variable_add_to_cart_text', __( 'Select options', 'woocommerce' ) );
                        break;
                        case "grouped" :
                            $link['url']    = apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->get_id() ) );
                            $link['label']  = apply_filters( 'grouped_add_to_cart_text', __( 'View options', 'woocommerce' ) );
                        break;
                        case "external" :
                            $link['url']    = apply_filters( 'external_add_to_cart_url', get_permalink( $product->get_id() ) );
                            $link['label']  = apply_filters( 'external_add_to_cart_text', __( 'Read More', 'woocommerce' ) );
                        break;
                        default :
                            if ( $product->is_purchasable() ) 
                            {
                                $link['url']    = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
                                $link['label']  = apply_filters( 'add_to_cart_text', __( 'Add to cart', 'woocommerce' ) );
                                $link['class']  = apply_filters( 'add_to_cart_class', 'add_to_cart_button, single_add_to_cart_button' );
                            } else {
                                $link['url']    = apply_filters( 'not_purchasable_url', get_permalink( $product->get_id() ) );
                                $link['label']  = apply_filters( 'not_purchasable_text', __( 'Read More', 'woocommerce' ) );
                            }
                        break;
                    }
                }
    
                if ( empty( $product ) ) 
                { 
                    return; 
                }
                
                // If there is a simple product.
                if ( $product->get_type() == 'simple' ) 
                {
                ?>
                
                <div class="<?php echo esc_attr( wc_get_product()->get_type() ); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'widget-wrap' ) ); ?>>

                 <?php if ( $product->managing_stock() && $product->is_in_stock() && ! $product->backorders_allowed() )
                    {
                        $this->add_render_attribute(
                            array(
                                'widget-wrap'  => array(
            							'data-page-id'         => $page_id,
            							'data-max-stock' => number_format($product->get_stock_quantity(),0,'',''),
            						),
            					)
    					);
                    }
                    if( $settings['template_selection'] == 'template1' )
                    {
                        echo '<div class="before-cart-form spacing">';
                            
                            do_action( 'woocommerce_before_add_to_cart_form' );
                                
                        echo '</div>';
                        
                        ?>
                        <form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="cart stiles-add-cart" method="post" enctype="multipart/form-data">
                        <?php
                            if( $settings['show_stock'] == 'yes' )
                            {
                                if ( $product->get_stock_quantity() ) 
                                { // if manage stock is enabled 
                                    echo '<div class="stock-container spacing">';
                                    if ( number_format($product->get_stock_quantity(),0,'','') < 3 ) 
                                    { // if stock is low
                                        echo '<div class="remaining">Only ' . number_format($product->get_stock_quantity(),0,'','') . ' left in stock!</div>';
                                    } else {
                                        echo '<div class="remaining">' . number_format($product->get_stock_quantity(),0,'','') . ' left in stock</div>'; 
                                    }
                                    echo '</div>';
                                }
                            }
                            
                            echo '<div class="before-cart-quantity spacing">';
                            
                                do_action( 'woocommerce_before_add_to_cart_quantity' );
                                
                            echo '</div>';
    
                            echo '<div class="quantity-container spacing">';
    
                                echo '<div class="minus-button"><button type="button" class="minus typo" >-</button></div>';
    
                                // Displays the quantity box.
                                woocommerce_quantity_input(
                            		array(
                            			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                            			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                            			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                            		)
                            	);
    
                                echo '<div class="plus-button"><button type="button" class="plus typo" >+</button></div>';
    
                            echo '</div>';
                            
                            echo '<div class="after-cart-quantity spacing">';
                            
                                do_action( 'woocommerce_after_add_to_cart_quantity' );
                                
                            echo '</div>';
                            
                            echo '<div class="before-cart-button spacing">';
                            
                                do_action( 'woocommerce_before_add_to_cart_button' );
                                
                            echo '</div>';
    
                            echo '<div class="button-container spacing">';
                                // Display the submit button.
                                echo sprintf( '<div class="wc-add-button"> <button type="submit" data-product_id="%s" data-product_sku="%s" data-quantity="1" class="%s button product_type_simple">%s</button></div>', esc_attr( $product->get_id() ), esc_attr( $product->get_sku() ), esc_attr( $link['class'] ), esc_html( $link['label'] ) );
                            echo '</div>';
                            
                            echo '<div class="after-cart-button spacing">';
                            
                                do_action( 'woocommerce_after_add_to_cart_button' );
                                
                            echo '</div>';
                         ?>   
                        </form>
                        
                        <?php echo '<div class="after-cart-form spacing">';
                            
                            do_action( 'woocommerce_after_add_to_cart_form' );
                                
                        echo '</div>';
                        
                    } ?>
                    <?php if( $settings['template_selection'] == 'template2' )
                     {
                     ?>
                        <div class="<?php echo esc_attr( wc_get_product()->get_type() ); ?>">
                            <?php woocommerce_template_single_add_to_cart(); ?>
                        </div>
                        <?php if( $settings['show_stock'] != 'yes' )
                        { ?>
                            <script>
                            jQuery( document ).ready(function() 
                            {
                                jQuery(".stock").hide();
                            });
                            </script>
                        <?php } ?>
                     <?php } ?>
                <?php
                }
                elseif ( $product->get_type() == 'variable' ) 
                {  ?>
                    <div class="<?php echo esc_attr( wc_get_product()->get_type() ); ?>" <?php echo wp_kses_post( $this->get_render_attribute_string( 'widget-wrap' ) ); ?>>
                    
                    <?php 
                    
                    if( $settings['template_selection'] == 'template1' )
                    {
                        if( $settings['show_stock'] == 'yes' )
                        {
                            add_filter( 'woocommerce_locate_template', array( $this, 'smw_locate_template1' ), 10, 3 );
                        }
                        else
                        {
                            add_filter( 'woocommerce_locate_template', array( $this, 'smw_locate_template1_nostock' ), 10, 3 );
                        }
                        ?>

                        <div class="<?php echo esc_attr( wc_get_product()->get_type() ); ?>">
                            <?php woocommerce_template_single_add_to_cart(); ?>
                        </div>
                        <?php
                    }
                    if( $settings['template_selection'] == 'template2' )
                    {
                        if( $settings['show_stock'] == 'yes' )
                        {
                            add_filter( 'woocommerce_locate_template', array( $this, 'smw_locate_template2' ), 10, 3 );
                        }
                        else
                        {
                            add_filter( 'woocommerce_locate_template', array( $this, 'smw_locate_template2_nostock' ), 10, 3 );
                        }
                        ?>
                        <div class="<?php echo esc_attr( wc_get_product()->get_type() ); ?>">
                            <?php woocommerce_template_single_add_to_cart(); ?>
                        </div>
                    <?php }
               } ?>
               </div>
            <?php
            }
            ?>
            
            <script type="text/javascript">
           
              jQuery(document).ready(function($)
              {   
                  $( ".quantity" ).find( "input" ).removeAttr( "type" );
                  //$(".single_add_to_cart_button").wrap("<div class='add_to_cart'></div>");
                   
                 $('form.cart').on( 'click', 'button.plus, button.minus', function() {
          
                    // Get current quantity values
                    var qty = $( this ).closest( 'form.cart' ).find( '.qty' );
                    var val   = parseFloat(qty.val());
                    var max = parseFloat(qty.attr( 'max' ));
                    var min = parseFloat(qty.attr( 'min' ));
                    var step = parseFloat(qty.attr( 'step' ));
          
                    // Change the value if plus or minus
                    if ( $( this ).is( '.plus' ) ) {
                       if ( max && ( max <= val ) ) {
                          qty.val( max );
                       } else {
                          qty.val( val + step );
                       }
                    } else {
                       if ( min && ( min >= val ) ) {
                          qty.val( min );
                       } else if ( val > 1 ) {
                          qty.val( val - step );
                       }
                    }
                      
                 });
                   
              });
                   
            </script>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_add_to_cart_advanced() );