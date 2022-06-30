<?php

/**
 * Stiles Media Widgets Product Archive.
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
use Elementor\Controls_Stack;
use Elementor\Group_Control_Box_Shadow;
use Products_Archive_Render;
use Elementor\Plugin;

class stiles_wc_product_archive extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-archive-product';
    }
    
    public function get_title() 
    {
        return __( 'Product Archive', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-products';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        $this->register_product_archive();
        
        $this->register_item_style();
        
        $this->register_product_title_style();
        
        $this->register_product_image_section();

        $this->register_price_style_section();
        
        $this->register_rating_style_section();
        
        $this->add_to_cart_style();

        $this->register_product_pagination_style();
        
        $this->register_onsale_style();
    }
    
    protected function register_product_archive()
    {
        $this->start_controls_section(
            'product-archive-content',
            array(
                'label' => __( 'Product Archive', smw_slug ),
            )
        );
            
            $this->add_responsive_control(
                'columns',
                array(
                    'label' => __( 'Columns', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'prefix_class' => 'smwproducts-columns%s-',
                    'min' => 1,
                    'max' => 12,
                    'default' => 4,
                    'required' => true,
                    'device_args' => array(
                        Controls_Stack::RESPONSIVE_TABLET => array(
                            'required' => false,
                        ),
                        Controls_Stack::RESPONSIVE_MOBILE => array(
                            'required' => false,
                        ),
                    ),
                    'min_affected_device' => array(
                        Controls_Stack::RESPONSIVE_DESKTOP => Controls_Stack::RESPONSIVE_TABLET,
                        Controls_Stack::RESPONSIVE_TABLET => Controls_Stack::RESPONSIVE_TABLET,
                    ),
                )
            );

            $this->add_control(
                'rows',
                array(
                    'label' => __( 'Rows', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 4,
                    'render_type' => 'template',
                    'range' => array(
                        'px' => array(
                            'max' => 20,
                        ),
                    ),
                )
            );

            $this->add_control(
                'paginate',
                array(
                    'label' => __( 'Pagination', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => '',
                )
            );

            $this->add_control(
                'allow_order',
                array(
                    'label' => __( 'Allow Order', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => '',
                    'condition' => array(
                        'paginate' => 'yes',
                    ),
                )
            );

            $this->add_control(
                'show_result_count',
                array(
                    'label' => __( 'Show Result Count', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => '',
                    'condition' => array(
                        'paginate' => 'yes',
                    ),
                )
            );

            $this->add_control(
                'orderby',
                array(
                    'label' => __( 'Order by', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'date',
                    'options' => array(
                        'date' => __( 'Date', smw_slug ),
                        'title' => __( 'Title', smw_slug ),
                        'price' => __( 'Price', smw_slug ),
                        'popularity' => __( 'Popularity', smw_slug ),
                        'rating' => __( 'Rating', smw_slug ),
                        'rand' => __( 'Random', smw_slug ),
                        'menu_order' => __( 'Menu Order', smw_slug ),
                    ),
                    'condition' => array(
                        'paginate!' => 'yes',
                    ),
                )
            );

            $this->add_control(
                'order',
                array(
                    'label' => __( 'Order', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'desc',
                    'options' => array(
                        'asc' => __( 'ASC', smw_slug ),
                        'desc' => __( 'DESC', smw_slug ),
                    ),
                    'condition' => array(
                        'paginate!' => 'yes',
                    ),
                )
            );

            $this->add_control(
                'query_post_type',
                array(
                    'type' => 'hidden',
                    'default' => 'current_query',
                )
            );

        $this->end_controls_section();
    }
    
    protected function register_item_style()
    {
        // Item Style Section
        $this->start_controls_section(
            'product-item-section',
            array(
                'label' => esc_html__( 'Item', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                array(
                    'name' => 'item_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product',
                )
            );

            $this->add_responsive_control(
                'item_border_radius',
                array(
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ),
                )
            );

            $this->add_responsive_control(
                'item_padding',
                array(
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ),
                )
            );

            $this->add_responsive_control(
                'item_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                array(
                    'name' => 'item_box_shadow',
                    'label' => __( 'Box Shadow', smw_slug ),
                    'selector' => '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product',
                )
            );

            $this->add_responsive_control(
                'item_alignment',
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
                    'prefix_class' => 'woolentor-product-loop-item-align-',
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product' => 'text-align: {{VALUE}}',
                    ),
                )
            );

        $this->end_controls_section();
    }
    
    protected function register_product_title_style()
    {
        // Title Style Section
        $this->start_controls_section(
            'product-title-section',
            array(
                'label' => esc_html__( 'Title', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->start_controls_tabs('product_title_style_tabs');

                // Title Normal Style
                $this->start_controls_tab(
                    'product_title_style_normal_tab',
                    array(
                        'label' => __( 'Normal', smw_slug ),
                    )
                );
                    $this->add_control(
                        'product_title_color',
                        array(
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => array(
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ),
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .woocommerce-loop-product__title' => 'color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product .woocommerce-loop-product__title' => 'color: {{VALUE}} !important',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name' => 'product_title_typography',
                            'scheme' => Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .woocommerce-loop-product__title',
                            'selector' => '{{WRAPPER}}.elementor-widget-stiles-archive-product .woocommerce-loop-product__title',
                        )
                    );

                    $this->add_responsive_control(
                        'product_title_padding',
                        array(
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', '%' ),
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .woocommerce-loop-product__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product .woocommerce-loop-product__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                            ),
                        )
                    );

                    $this->add_responsive_control(
                        'product_title_margin',
                        array(
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', '%' ),
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product .woocommerce-loop-product__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                            ),
                        )
                    );

                $this->end_controls_tab();

                // Title Hover Style
                $this->start_controls_tab(
                    'product_title_style_hover_tab',
                    array(
                        'label' => __( 'Normal', smw_slug ),
                    )
                );
                    
                    $this->add_control(
                        'product_title_hover_color',
                        array(
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => array(
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ),
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .woocommerce-loop-product__title:hover' => 'color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product .woocommerce-loop-product__title:hover' => 'color: {{VALUE}} !important',
                            ),
                        )
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function register_product_image_section()
    {
        // image Style Section
        $this->start_controls_section(
            'product-image-section',
            array(
                'label' => esc_html__( 'Image', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                array(
                    'name' => 'image_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}}.elementor-widget-stiles-archive-product .attachment-woocommerce_thumbnail',
                )
            );

            $this->add_responsive_control(
                'image_border_radius',
                array(
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product .attachment-woocommerce_thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ),
                )
            );

            $this->add_responsive_control(
                'image_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product .attachment-woocommerce_thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ),
                )
            );

        $this->end_controls_section();
    }
    
    protected function register_price_style_section()
    {
        // Price Style Section
        $this->start_controls_section(
            'product-price-section',
            array(
                'label' => esc_html__( 'Price', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'sell_price_heading',
                array(
                    'label' => __( 'Sale Price', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                )
            );

            $this->add_control(
                'product_price_color',
                array(
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => array(
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .price' => 'color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product .price' => 'color: {{VALUE}} !important',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .price ins' => 'color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product .price ins' => 'color: {{VALUE}} !important',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .price ins .amount' => 'color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product .price ins .amount' => 'color: {{VALUE}} !important',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'product_price_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .price,{{WRAPPER}}.elementor-widget-stiles-archive-product .price',
                )
            );

            // Regular Price
            $this->add_control(
                'regular_price_heading',
                array(
                    'label' => __( 'Regular Price', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                )
            );

            $this->add_control(
                'product_regular_price_color',
                array(
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => array(
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .price del' => 'color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product .price del' => 'color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .price del .amount' => 'color: {{VALUE}} !important',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product .price del .amount' => 'color: {{VALUE}} !important',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'product_regular_price_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .price del .amount, {{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .price del, {{WRAPPER}}.elementor-widget-stiles-archive-product .price del',
                )
            );

        $this->end_controls_section();
    }
    
    protected function register_rating_style_section()
    {
        // Rating Style Section
        $this->start_controls_section(
            'product-rating-section',
            array(
                'label' => esc_html__( 'Rating', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_control(
                'product_rating_color',
                array(
                    'label' => __( 'Rating Start Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .star-rating' => 'color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product .star-rating' => 'color: {{VALUE}} !important',
                    ),
                )
            );

            $this->add_control(
                'product_empty_rating_color',
                array(
                    'label' => __( 'Empty Rating Start Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .star-rating::before' => 'color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product .star-rating::before' => 'color: {{VALUE}} !important',
                    ),
                )
            );

            $this->add_control(
                'product_rating_star_size',
                array(
                    'label' => __( 'Star Size', smw_slug ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => array( 'px', 'em', '%'),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product .star-rating' => 'font-size: {{SIZE}}{{UNIT}} !important',
                    ),
                )
            );

            $this->add_responsive_control(
                'product_rating_start_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .star-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product .star-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                    ),
                )
            );

        $this->end_controls_section();
    }
    
    protected function add_to_cart_style()
    {
        // Add to Cart Button Style Section
        $this->start_controls_section(
            'product-addtocartbutton-section',
            array(
                'label' => esc_html__( 'Add To Cart Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->start_controls_tabs('product_addtocartbutton_style_tabs');

                // Add to cart normal style
                $this->start_controls_tab(
                    'product_addtocartbutton_style_normal_tab',
                    array(
                        'label' => __( 'Normal', smw_slug ),
                    )
                );
                    $this->add_control(
                        'atc_button_text_color',
                        array(
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'default' => '',
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .button' => 'color: {{VALUE}};',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product .button' => 'color: {{VALUE}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'atc_button_background_color',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .button' => 'background-color: {{VALUE}};',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product .button' => 'background-color: {{VALUE}} !important;',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        array(
                            'name' => 'atc_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .button,{{WRAPPER}}.elementor-widget-stiles-archive-product .button',
                        )
                    );

                    $this->add_responsive_control(
                        'atc_button_border_radius',
                        array(
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', '%' ),
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name' => 'atc_button_typography',
                            'scheme' => Typography::TYPOGRAPHY_4,
                            'selector' => '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .button,{{WRAPPER}}.elementor-widget-stiles-archive-product .button',
                        )
                    );

                    $this->add_responsive_control(
                        'atc_button_margin',
                        array(
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', '%' ),
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product .button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                            ),
                        )
                    );

                    $this->add_responsive_control(
                        'atc_button_padding',
                        array(
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', '%' ),
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                            ),
                        )
                    );

                $this->end_controls_tab();

                // Add to cart hover style
                $this->start_controls_tab(
                    'product_addtocartbutton_style_hover_tab',
                    array(
                        'label' => __( 'Hover', smw_slug ),
                    )
                );
                    $this->add_control(
                        'atc_button_hover_color',
                        array(
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .button:hover' => 'color: {{VALUE}};',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product .button:hover' => 'color: {{VALUE}} !important;',
                            ),
                        )
                    );

                    $this->add_control(
                        'atc_button_hover_background_color',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .button:hover' => 'background-color: {{VALUE}};',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product .button:hover' => 'background-color: {{VALUE}} !important;',
                            ),
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        array(
                            'name' => 'atc_button_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product .button:hover,{{WRAPPER}}.elementor-widget-stiles-archive-product .button:hover',
                        )
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function register_product_pagination_style()
    {
        // Pagination Style Section
        $this->start_controls_section(
            'product-pagination-section',
            array(
                'label' => esc_html__( 'Pagination', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'paginate' => 'yes',
                ),
            )
        );
            $this->start_controls_tabs('product_pagination_style_tabs');

                // Pagination normal style
                $this->start_controls_tab(
                    'product_pagination_style_normal_tab',
                    array(
                        'label' => __( 'Normal', smw_slug ),
                    )
                );
                    
                    $this->add_control(
                        'product_pagination_border_color',
                        array(
                            'label' => __( 'Border Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product nav.woocommerce-pagination ul' => 'border-color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product nav.woocommerce-pagination ul li' => 'border-right-color: {{VALUE}}; border-left-color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_responsive_control(
                        'product_pagination_padding',
                        array(
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => array( 'px', '%' ),
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product nav.woocommerce-pagination ul li a, {{WRAPPER}}.elementor-widget-stiles-archive-product nav.woocommerce-pagination ul li span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                            ),
                        )
                    );

                    $this->add_control(
                        'product_pagination_link_color',
                        array(
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product nav.woocommerce-pagination ul li a' => 'color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_control(
                        'product_pagination_link_bg_color',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product nav.woocommerce-pagination ul li a' => 'background-color: {{VALUE}}',
                            ),
                        )
                    );

                $this->end_controls_tab();

                // Pagination Active style
                $this->start_controls_tab(
                    'product_pagination_style_active_tab',
                    array(
                        'label' => __( 'Active', smw_slug ),
                    )
                );
                    
                    $this->add_control(
                        'product_pagination_link_color_hover',
                        array(
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product nav.woocommerce-pagination ul li a:hover' => 'color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product nav.woocommerce-pagination ul li span.current' => 'color: {{VALUE}}',
                            ),
                        )
                    );

                    $this->add_control(
                        'product_pagination_link_bg_color_hover',
                        array(
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => array(
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product nav.woocommerce-pagination ul li a:hover' => 'background-color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-stiles-archive-product nav.woocommerce-pagination ul li span.current' => 'background-color: {{VALUE}}',
                            ),
                        )
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function register_onsale_style()
    {
        // Sale Flash Style Section
        $this->start_controls_section(
            'product-saleflash-style-section',
            array(
                'label' => esc_html__( 'Sale Tag', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_control(
                'product_show_onsale_flash',
                array(
                    'label' => __( 'Sale Flash', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_off' => __( 'Hide', smw_slug ),
                    'label_on' => __( 'Show', smw_slug ),
                    'separator' => 'before',
                    'default' => 'yes',
                    'return_value' => 'yes',
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product span.onsale' => 'display: block',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product span.onsale' => 'display: block !important',
                    ),
                )
            );

            $this->add_control(
                'product_onsale_text_color',
                array(
                    'label' => __( 'Text Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product span.onsale' => 'color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product span.onsale' => 'color: {{VALUE}} !important',
                    ),
                    'condition' => array(
                        'product_show_onsale_flash' => 'yes',
                    ),
                )
            );

            $this->add_control(
                'product_onsale_background_color',
                array(
                    'label' => __( 'Background Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product span.onsale' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product span.onsale' => 'background-color: {{VALUE}} !important',
                    ),
                    'condition' => array(
                        'product_show_onsale_flash' => 'yes',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'product_onsale_typography',
                    'selector' => '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product span.onsale,{{WRAPPER}}.elementor-widget-stiles-archive-product span.onsale',
                    'condition' => array(
                        'product_show_onsale_flash' => 'yes',
                    ),
                )
            );

            $this->add_responsive_control(
                'product_onsale_padding',
                array(
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product span.onsale' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                    ),
                    'condition' => array(
                        'product_show_onsale_flash' => 'yes',
                    ),
                )
            );

            $this->add_responsive_control(
                'product_onsale_border_radius',
                array(
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product span.onsale' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                    ),
                    'condition' => array(
                        'product_show_onsale_flash' => 'yes',
                    ),
                )
            );

            $this->add_control(
                'product_onsale_position',
                array(
                    'label' => __( 'Position', smw_slug ),
                    'type' => Controls_Manager::CHOOSE,
                    'label_block' => false,
                    'options' => array(
                        'left' => array(
                            'title' => __( 'Left', smw_slug ),
                            'icon' => 'eicon-h-align-left',
                        ),
                        'right' => array(
                            'title' => __( 'Right', smw_slug ),
                            'icon' => 'eicon-h-align-right',
                        ),
                    ),
                    'selectors' => array(
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product ul.products li.product span.onsale' => '{{VALUE}}',
                        '{{WRAPPER}}.elementor-widget-stiles-archive-product span.onsale' => '{{VALUE}} !important',
                    ),
                    'selectors_dictionary' => array(
                        'left' => 'right: auto; left: 0',
                        'right' => 'left: auto; right: 0',
                    ),
                    'condition' => array(
                        'product_show_onsale_flash' => 'yes',
                    ),
                )
            );

        $this->end_controls_section();
    }
    
    public function stiles_custom_product_limit( $limit = 3 ) 
    {
        $limit = ( $this->get_settings_for_display( 'columns' ) * $this->get_settings_for_display( 'row' ) );
        return $limit;
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
       
        if ( WC()->session ) 
        {
            wc_print_notices();
        }

        if ( ! isset( $GLOBALS['post'] ) ) {
            $GLOBALS['post'] = null;
        }

        $settings = $this->get_settings();
        $settings['editor_mode'] = \Elementor\Plugin::instance()->editor->is_edit_mode();
        add_filter( 'product_custom_limit', array( $this, 'stiles_custom_product_limit' ) );
        $shortcode = new Products_Archive_Render( '10' );

        $content = $shortcode->get_content();
        if ( $content ) 
        {
            echo $content;
        } else
        {
            echo '<div class="products-not-found">' . esc_html__( 'Product Not Available' , smw_slug ) . '</div>';
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_product_archive() );