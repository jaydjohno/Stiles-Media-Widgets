<?php

/**
 * Stiles Media Widgets Product Layout.
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
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

class stiles_wc_product_layout extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'universal-product-style', plugin_dir_url( __FILE__ ) . '../css/universal-product.css');
    }
    
    public function get_name() 
    {
        return 'stiles-universal-product';
    }
    
    public function get_title() 
    {
        return __( 'Product Layout', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-cart-light';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends(){
        return [
            'flex-box-grid',
            'font-awesome',
            'simple-line-icons',
            'slick-css',
            'product-quick-view',
            'universal-product-style',
        ];
    }
    
    public function get_script_depends()
    {
        return [
            'slick-js',
            'product-slider-js',
            'countdown',
            'product-image-thumbnail-js',
            'product-tooltip-js',
        ];
    }
    
    protected function register_controls() 
    {
        $this->product_layout_control();
        
        $this->product_grid_content_control();
        
        $this->product_content_control();
        
        $this->product_content_control();
        
        $this->product_action_button_control();
        
        $this->product_image_control();
        
        $this->product_countdown_control();
        
        $this->product_slider_control();
        
        $this->default_style_control();

        $this->action_button_style_control();

        $this->countdown_timer_style_control();
        
        $this->slider_button_style_control();
        
        $this->product_tab_style_control();
    }
    
    protected function product_layout_control()
    {
        // Product Content
        $this->start_controls_section(
            'stiles-products-layout-setting',
            [
                'label' => esc_html__( 'Layout Settings', smw_slug ),
            ]
        );
            $this->add_control(
                'product_layout_style',
                [
                    'label'   => __( 'Layout', smw_slug ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'default',
                    'options' => [
                        'slider'   => __( 'Slider', smw_slug ),
                        'tab'      => __( 'Tab', smw_slug ),
                        'default'  => __( 'Default', smw_slug ),
                    ]
                ]
            );

            $this->add_control(
                'stiles_product_grid_column',
                [
                    'label' => esc_html__( 'Columns', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '3',
                    'options' => [
                        '1' => esc_html__( '1', smw_slug ),
                        '2' => esc_html__( '2', smw_slug ),
                        '3' => esc_html__( '3', smw_slug ),
                        '4' => esc_html__( '4', smw_slug ),
                        '5' => esc_html__( '5', smw_slug ),
                        '6' => esc_html__( '6', smw_slug ),
                    ],
                    'condition' => [
                        'product_layout_style!' => 'slider',
                    ]
                ]
            );

            $this->add_control(
                'stiles_product_grid_column_tablet',
                [
                    'label' => esc_html__( 'Tablet Columns', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '2',
                    'options' => [
                        '1' => esc_html__( '1', smw_slug ),
                        '2' => esc_html__( '2', smw_slug ),
                        '3' => esc_html__( '3', smw_slug ),
                        '4' => esc_html__( '4', smw_slug ),
                        '5' => esc_html__( '5', smw_slug ),
                        '6' => esc_html__( '6', smw_slug ),
                    ],
                    'condition' => [
                        'product_layout_style!' => 'slider',
                    ]
                ]
            );

            $this->add_control(
                'stiles_product_grid_column_mobile',
                [
                    'label' => esc_html__( 'Mobile Columns', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1' => esc_html__( '1', smw_slug ),
                        '2' => esc_html__( '2', smw_slug ),
                        '3' => esc_html__( '3', smw_slug ),
                        '4' => esc_html__( '4', smw_slug ),
                        '5' => esc_html__( '5', smw_slug ),
                        '6' => esc_html__( '6', smw_slug ),
                    ],
                    'condition' => [
                        'product_layout_style!' => 'slider',
                    ]
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_grid_content_control()
    {
        $this->start_controls_section(
            'stiles-products',
            [
                'label' => esc_html__( 'Query Settings', smw_slug ),
            ]
        );

            $this->add_control(
                'stiles_product_grid_product_filter',
                [
                    'label' => esc_html__( 'Filter By', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'recent',
                    'options' => [
                        'recent' => esc_html__( 'Recent Products', smw_slug ),
                        'featured' => esc_html__( 'Featured Products', smw_slug ),
                        'best_selling' => esc_html__( 'Best Selling Products', smw_slug ),
                        'sale' => esc_html__( 'Sale Products', smw_slug ),
                        'top_rated' => esc_html__( 'Top Rated Products', smw_slug ),
                        'mixed_order' => esc_html__( 'Random Products', smw_slug ),
                        'show_byid' => esc_html__( 'Show By Id', smw_slug ),
                        'show_byid_manually' => esc_html__( 'Add ID Manually', smw_slug ),
                    ],
                ]
            );

            $this->add_control(
                'stiles_product_id',
                [
                    'label' => __( 'Select Product', smw_slug ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'options' => stiles_post_name( 'product' ),
                    'condition' => [
                        'stiles_product_grid_product_filter' => 'show_byid',
                    ]
                ]
            );

            $this->add_control(
                'stiles_product_ids_manually',
                [
                    'label' => __( 'Product IDs', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'condition' => [
                        'stiles_product_grid_product_filter' => 'show_byid_manually',
                    ]
                ]
            );

            $this->add_control(
              'stiles_product_grid_products_count',
                [
                    'label'   => __( 'Product Limit', smw_slug ),
                    'type'    => Controls_Manager::NUMBER,
                    'default' => 3,
                    'step'    => 1,
                ]
            );

            $this->add_control(
                'show_by_tagwise',
                [
                    'label' => __( 'Show Product By Tag Wise', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Yes', smw_slug ),
                    'label_off' => __( 'No', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'stiles_product_grid_categories',
                [
                    'label' => esc_html__( 'Product Categories', smw_slug ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'options' => smw_taxonomy_list(),
                    'condition' => [
                        'show_by_tagwise!' => 'yes',
                        'stiles_product_grid_product_filter!' => 'show_byid',
                    ]
                ]
            );

            $this->add_control(
                'stiles_product_grid_tags',
                [
                    'label' => esc_html__( 'Product Tags', smw_slug ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'options' => smw_taxonomy_list( 'product_tag' ),
                    'condition' => [
                        'show_by_tagwise' => 'yes',
                        'stiles_product_grid_product_filter!' => 'show_byid',
                    ]
                ]
            );

            $this->add_control(
                'stiles_custom_order',
                [
                    'label' => esc_html__( 'Custom order', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label' => esc_html__( 'Orderby', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'          => esc_html__('None',smw_slug),
                        'ID'            => esc_html__('ID',smw_slug),
                        'date'          => esc_html__('Date',smw_slug),
                        'name'          => esc_html__('Name',smw_slug),
                        'title'         => esc_html__('Title',smw_slug),
                        'comment_count' => esc_html__('Comment count',smw_slug),
                        'rand'          => esc_html__('Random',smw_slug),
                    ],
                    'condition' => [
                        'stiles_custom_order' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => esc_html__( 'order', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'DESC',
                    'options' => [
                        'DESC'  => esc_html__('Descending',smw_slug),
                        'ASC'   => esc_html__('Ascending',smw_slug),
                    ],
                    'condition' => [
                        'stiles_custom_order' => 'yes',
                    ]
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_content_control()
    {
        // Product Content
        $this->start_controls_section(
            'stiles-products-content-setting',
            [
                'label' => esc_html__( 'Content Settings', smw_slug ),
            ]
        );
            $this->add_control(
                'product_content_style',
                [
                    'label'   => __( 'Style', smw_slug ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1'  => __( 'Style One', smw_slug ),
                        '2'  => __( 'Style Two', smw_slug ),
                        '3'  => __( 'Style Three', smw_slug ),
                        '4'  => __( 'Style Four', smw_slug ),
                    ]
                ]
            );

            $this->add_control(
                'hide_product_title',
                [
                    'label'     => __( 'Title Hide', smw_slug ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .sm-product-inner .sm-product-title' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'hide_product_price',
                [
                    'label'     => __( 'Price Hide', smw_slug ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .sm-product-inner .sm-product-price' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'hide_product_category',
                [
                    'label'     => __( 'Category Hide', smw_slug ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .sm-product-inner .sm-product-categories' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'hide_product_ratting',
                [
                    'label'     => __( 'Ratting Hide', smw_slug ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .sm-product-inner .sm-product-ratting-wrap' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'show_product_excerpt',
                [
                    'label'     => __( 'Show Short Description', smw_slug ),
                    'type'      => Controls_Manager::SWITCHER,
                ]
            );

            $this->add_control(
                'title_length',
                [
                    'label' => __( 'Title Length', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1,
                    'default' => 3,
                    'condition' =>[
                        'hide_product_title!'=>'yes',
                    ]
                ]
            );

            $this->add_control(
                'excerpt_length',
                [
                    'label' => __( 'Description Length', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1,
                    'default' => 15,
                    'condition' =>[
                        'show_product_excerpt'=>'yes',
                    ]
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_action_button_control()
    {
        // Product Action Button
        $this->start_controls_section(
            'stiles-products-action-button',
            [
                'label' => esc_html__( 'Action Button Settings', smw_slug ),
            ]
        );
            
            $this->add_control(
                'show_action_button',
                [
                    'label' => __( 'Action Button', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', smw_slug ),
                    'label_off' => __( 'Hide', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_quickview_button',
                [
                    'label' => __( 'Quick View Button Hide', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-action ul li:nth-child(1)' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'show_wishlist_button',
                [
                    'label' => __( 'Wishlist Button Hide', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-action ul li:nth-child(2)' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'show_compare_button',
                [
                    'label' => __( 'Compare Button Hide', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-action ul li a.compare' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'show_addtocart_button',
                [
                    'label' => __( 'Shopping Cart Button Hide', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-action ul li.stiles-cart' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'action_button_style',
                [
                    'label'   => __( 'Style', smw_slug ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1'   => __( 'Style One', smw_slug ),
                        '2'   => __( 'Style Two', smw_slug ),
                        '3'   => __( 'Style Three', smw_slug ),
                    ],
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ]
                ]
            );

            $this->add_control(
                'action_button_show_on',
                [
                    'label'   => __( 'Show On', smw_slug ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'normal',
                    'options' => [
                        'hover'   => __( 'Hover', smw_slug ),
                        'normal'  => __( 'Normal', smw_slug ),
                    ],
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ]
                ]
            );

            $this->add_control(
                'action_button_position',
                [
                    'label'   => __( 'Position', smw_slug ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'middle' => [
                            'title' => __( 'Middle', smw_slug ),
                            'icon'  => 'eicon-v-align-middle',
                        ],
                        'bottom' => [
                            'title' => __( 'Bottom', smw_slug ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                        'contentbottom' => [
                            'title' => __( 'Content Bottom', smw_slug ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'     => is_rtl() ? 'left' : 'right',
                    'toggle'      => false,
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ]
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_image_control()
    {
        // Product Image Setting
        $this->start_controls_section(
            'stiles-products-thumbnails-setting',
            [
                'label' => esc_html__( 'Image Settings', smw_slug ),
            ]
        );

            $this->add_control(
                'thumbnails_style',
                [
                    'label'   => __( 'Thumbnails Style', smw_slug ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1'  => __( 'Single Image', smw_slug ),
                        '2'  => __( 'Image Slider', smw_slug ),
                        '3'  => __( 'Gallery Tab', smw_slug ),
                    ]
                ]
            );

            $this->add_control(
                'image_navigation_bg_color',
                [
                    'label' => __( 'Arrows Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' =>'#444444',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-image .sm-product-image-slider .slick-arrow' => 'color: {{VALUE}} !important;',
                    ],
                    'condition'=>[
                        'thumbnails_style'=>'2',
                    ]
                ]
            );

            $this->add_control(
                'image_dots_normal_bg_color',
                [
                    'label' => __( 'Dots Background Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' =>'#cccccc',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-image .sm-product-image-slider .slick-dots li button' => 'background-color: {{VALUE}} !important;',
                    ],
                    'condition'=>[
                        'thumbnails_style'=>'2',
                    ]
                ]
            );

            $this->add_control(
                'image_dots_hover_bg_color',
                [
                    'label' => __( 'Dots Active Background Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'condition'=>[
                        'thumbnails_style'=>'2',
                    ],
                    'default' =>'#666666',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-image .sm-product-image-slider .slick-dots li.slick-active button' => 'background-color: {{VALUE}} !important;',
                    ],
                ]
            );

            $this->add_control(
                'image_tab_menu_border_color',
                [
                    'label' => __( 'Border Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' =>'#737373',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-image .sm-product-cus-tab-links li a' => 'border-color: {{VALUE}};',
                    ],
                    'condition'=>[
                        'thumbnails_style'=>'3',
                    ]
                ]
            );

            $this->add_control(
                'image_tab_menu_active_border_color',
                [
                    'label' => __( 'Active Border Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' =>'#ECC87B',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-image .sm-product-cus-tab-links li a.smactive' => 'border-color: {{VALUE}} !important;',
                    ],
                    'condition'=>[
                        'thumbnails_style'=>'3',
                    ]
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_countdown_control()
    {
        // Product countdown
        $this->start_controls_section(
            'stiles-products-countdown-setting',
            [
                'label' => esc_html__( 'Offer Price Counter Settings', smw_slug ),
            ]
        );
            
            $this->add_control(
                'show_countdown',
                [
                    'label' => __( 'Show Countdown Timer', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', smw_slug ),
                    'label_off' => __( 'Hide', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'show_countdown_gutter',
                [
                    'label' => __( 'Gutter', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Yes', smw_slug ),
                    'label_off' => __( 'No', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' =>[
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'product_countdown_position',
                [
                    'label'   => __( 'Position', smw_slug ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'middle' => [
                            'title' => __( 'Middle', smw_slug ),
                            'icon'  => 'eicon-v-align-middle',
                        ],
                        'bottom' => [
                            'title' => __( 'Bottom', smw_slug ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                        'contentbottom' => [
                            'title' => __( 'Content Bottom', smw_slug ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'     => 'bottom',
                    'toggle'      => false,
                    'label_block' => true,
                    'condition' =>[
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'custom_labels',
                [
                    'label'        => __( 'Custom Label', smw_slug ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'condition'   => [
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'customlabel_days',
                [
                    'label'       => __( 'Days', smw_slug ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Days', smw_slug ),
                    'condition'   => [
                        'custom_labels!' => '',
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'customlabel_hours',
                [
                    'label'       => __( 'Hours', smw_slug ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Hours', smw_slug ),
                    'condition'   => [
                        'custom_labels!' => '',
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'customlabel_minutes',
                [
                    'label'       => __( 'Minutes', smw_slug ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Minutes', smw_slug ),
                    'condition'   => [
                        'custom_labels!' => '',
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'customlabel_seconds',
                [
                    'label'       => __( 'Seconds', smw_slug ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Seconds', smw_slug ),
                    'condition'   => [
                        'custom_labels!' => '',
                        'show_countdown' => 'yes',
                    ]
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_slider_control()
    {
        // Product slider setting
        $this->start_controls_section(
            'stiles-products-slider',
            [
                'label' => esc_html__( 'Slider Option', smw_slug ),
                'condition' => [
                    'product_layout_style' => 'slider',
                ]
            ]
        );

            $this->add_control(
                'slitems',
                [
                    'label' => esc_html__( 'Slider Items', smw_slug ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default' => 3
                ]
            );

            $this->add_control(
                'slarrows',
                [
                    'label' => esc_html__( 'Slider Arrow', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'sldots',
                [
                    'label' => esc_html__( 'Slider dots', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no'
                ]
            );

            $this->add_control(
                'slpause_on_hover',
                [
                    'type' => Controls_Manager::SWITCHER,
                    'label_off' => __('No', smw_slug),
                    'label_on' => __('Yes', smw_slug),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'label' => __('Pause on Hover?', smw_slug),
                ]
            );

            $this->add_control(
                'slautoplay',
                [
                    'label' => esc_html__( 'Slider auto play', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'separator' => 'before',
                    'default' => 'no'
                ]
            );

            $this->add_control(
                'slautoplay_speed',
                [
                    'label' => __('Autoplay speed', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 3000,
                    'condition' => [
                        'slautoplay' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slanimation_speed',
                [
                    'label' => __('Autoplay animation speed', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 300,
                    'condition' => [
                        'slautoplay' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'slscroll_columns',
                [
                    'label' => __('Slider item to scroll', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default' => 3,
                ]
            );

            $this->add_control(
                'heading_tablet',
                [
                    'label' => __( 'Tablet', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_control(
                'sltablet_display_columns',
                [
                    'label' => __('Slider Items', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 2,
                ]
            );

            $this->add_control(
                'sltablet_scroll_columns',
                [
                    'label' => __('Slider item to scroll', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 2,
                ]
            );

            $this->add_control(
                'sltablet_width',
                [
                    'label' => __('Tablet Resolution', smw_slug),
                    'description' => __('The resolution to tablet.', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 750,
                ]
            );

            $this->add_control(
                'heading_mobile',
                [
                    'label' => __( 'Mobile Phone', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_control(
                'slmobile_display_columns',
                [
                    'label' => __('Slider Items', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                ]
            );

            $this->add_control(
                'slmobile_scroll_columns',
                [
                    'label' => __('Slider item to scroll', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                ]
            );

            $this->add_control(
                'slmobile_width',
                [
                    'label' => __('Mobile Resolution', smw_slug),
                    'description' => __('The resolution to mobile.', smw_slug),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 480,
                ]
            );

        $this->end_controls_section(); // Slider Option end
    }
    
    protected function default_style_control()
    {
        // Style Default tab section
        $this->start_controls_section(
            'universal_product_style_section',
            [
                'label' => __( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'product_inner_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce div.product.mb-30' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_inner_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce div.product.mb-30' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_inner_border_color',
                [
                    'label' => __( 'Border Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#f1f1f1',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'product_inner_box_shadow',
                    'label' => __( 'Hover Box Shadow', smw_slug ),
                    'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner:hover',
                ]
            );

            $this->add_control(
                'product_content_area_heading',
                [
                    'label' => __( 'Content area', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'product_content_area_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_content_area_bg_color',
                [
                    'label' => __( 'Background Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_content_area_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content',
                ]
            );

            $this->add_control(
                'product_badge_heading',
                [
                    'label' => __( 'Product Badge', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_badge_color',
                [
                    'label' => __( 'Badge Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#444444',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-label' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_badge_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-label',
                ]
            );

            // Product Category
            $this->add_control(
                'product_category_heading',
                [
                    'label' => __( 'Product Category', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_category_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-categories a',
                ]
            );

            $this->add_control(
                'product_category_color',
                [
                    'label' => __( 'Category Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#444444',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-categories a' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-categories::before' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_category_hover_color',
                [
                    'label' => __( 'Category Hover Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#dc9a0e',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-categories a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_category_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-categories' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            // Product Title
            $this->add_control(
                'product_title_heading',
                [
                    'label' => __( 'Product Title', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_title_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-title a',
                ]
            );

            $this->add_control(
                'product_title_color',
                [
                    'label' => __( 'Title Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#444444',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-title a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_title_hover_color',
                [
                    'label' => __( 'Title Hover Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#dc9a0e',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-title a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_title_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            // Product Description
            $this->add_control(
                'product_description_heading',
                [
                    'label' => __( 'Product Description', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition'=>[
                        'show_product_excerpt'=>'yes'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_description_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .stiles-short-desc',
                    'condition'=>[
                        'show_product_excerpt'=>'yes'
                    ]
                ]
            );

            $this->add_control(
                'product_description_color',
                [
                    'label' => __( 'Description Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#444444',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .stiles-short-desc' => 'color: {{VALUE}};',
                    ],
                    'condition'=>[
                        'show_product_excerpt'=>'yes'
                    ]
                ]
            );

            $this->add_responsive_control(
                'product_description_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .stiles-short-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'=>[
                        'show_product_excerpt'=>'yes'
                    ]
                ]
            );

            // Product Price
            $this->add_control(
                'product_price_heading',
                [
                    'label' => __( 'Product Price', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_sale_price_color',
                [
                    'label' => __( 'Sale Price Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#444444',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-price span' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_sale_price_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-price span',
                ]
            );

            $this->add_control(
                'product_regular_price_color',
                [
                    'label' => __( 'Regular Price Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'separator' => 'before',
                    'default' => '#444444',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-price span del span,{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-price span del' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_regular_price_typography',
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-price span del span',
                ]
            );

            $this->add_responsive_control(
                'product_price_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            // Product Rating
            $this->add_control(
                'product_rating_heading',
                [
                    'label' => __( 'Product Rating', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_rating_color',
                [
                    'label' => __( 'Empty Rating Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#aaaaaa',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-ratting-wrap .sm-product-ratting i' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_rating_give_color',
                [
                    'label' => __( 'Rating Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#dc9a0e',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-ratting-wrap .sm-product-ratting .sm-product-user-ratting i' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_rating_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-content .sm-product-content-inner .sm-product-ratting-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section(); // Style Default End
    }
    
    protected function action_button_style_control()
    {
        // Style Action Button tab section
        $this->start_controls_section(
            'universal_product_action_button_style_section',
            [
                'label' => __( 'Action Button Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'product_action_button_background_color',
                    'label' => __( 'Background', smw_slug ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'product_action_button_box_shadow',
                    'label' => __( 'Box Shadow', smw_slug ),
                    'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul',
                ]
            );

            $this->add_control(
                'product_tooltip_heading',
                [
                    'label' => __( 'Tooltip', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

                $this->add_control(
                    'product_tooltip_color',
                    [
                        'label' => __( 'Tool Tip Color', smw_slug ),
                        'type' => Controls_Manager::COLOR,
                        'scheme' => [
                            'type' => Color::get_type(),
                            'value' => Color::COLOR_1,
                        ],
                        'default' => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul li a .sm-product-action-tooltip,{{WRAPPER}} span.stiles-tip' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'product_action_button_tooltip_background_color',
                        'label' => __( 'Background', smw_slug ),
                        'types' => [ 'classic', 'gradient' ],
                        'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul li a .sm-product-action-tooltip,{{WRAPPER}} span.stiles-tip',
                    ]
                );

            $this->start_controls_tabs('product_action_button_style_tabs');

                // Normal
                $this->start_controls_tab(
                    'product_action_button_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'product_action_button_normal_color',
                        [
                            'label'=> __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' => '#000000',
                            'selectors' => [
                                '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul li a' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_font_size',
                        [
                            'label' => __( 'Font Size', smw_slug ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 200,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 20,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-action ul li a i' => 'font-size: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .stiles-compare.compare::before,{{WRAPPER}} .sm-product-action ul li.stiles-cart a::before' => 'font-size: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_line_height',
                        [
                            'label' => __( 'Line Height', smw_slug ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 200,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 30,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-action ul li a i' => 'line-height: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .stiles-compare.compare::before,{{WRAPPER}} .sm-product-action ul li.stiles-cart a::before' => 'line-height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'product_action_button_normal_background_color',
                            'label' => __( 'Background', smw_slug ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul li',
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_normal_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_normal_margin',
                        [
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'product_action_button_normal_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul li',
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_width',
                        [
                            'label' => __( 'Width', smw_slug ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 200,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 30,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-action ul li a' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_height',
                        [
                            'label' => __( 'Height', smw_slug ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 200,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 30,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-action ul li a' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Hover
                $this->start_controls_tab(
                    'product_action_button_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'product_action_button_hover_color',
                        [
                            'label' => __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' => '#dc9a0e',
                            'selectors' => [
                                '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul li:hover a' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .sm-product-action .yith-wcwl-wishlistaddedbrowse a, .sm-product-action .yith-wcwl-wishlistexistsbrowse a' => 'color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'product_action_button_hover_background_color',
                            'label' => __( 'Background', smw_slug ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul li:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'product_action_button_hover_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-image-wrap .sm-product-action ul li:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function countdown_timer_style_control()
    {
        // Style Countdown tab section
        $this->start_controls_section(
            'universal_product_counter_style_section',
            [
                'label' => __( 'Offer Price Counter', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_countdown'=>'yes',
                ]
            ]
        );

            $this->add_control(
                'product_counter_color',
                [
                    'label' => __( 'Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-countdown-wrap .sm-product-countdown .cd-single .cd-single-inner h3' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-countdown-wrap .sm-product-countdown .cd-single .cd-single-inner p' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'product_counter_background_color',
                    'label' => __( 'Counter Background', smw_slug ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-countdown-wrap .sm-product-countdown .cd-single .cd-single-inner,{{WRAPPER}} .sm-products .sm-product.sm-product-countdown-fill .sm-product-inner .sm-product-countdown-wrap .sm-product-countdown',
                ]
            );

            $this->add_responsive_control(
                'product_counter_space_between',
                [
                    'label' => __( 'Space', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-products .sm-product .sm-product-inner .sm-product-countdown-wrap .sm-product-countdown .cd-single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
        $this->end_controls_section();
    }
    
    protected function slider_button_style_control()
    {
        // Slider Button style
        $this->start_controls_section(
            'products-slider-controller-style',
            [
                'label' => esc_html__( 'Slider Controller Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'product_layout_style' => 'slider',
                ]
            ]
        );

            $this->start_controls_tabs('product_sliderbtn_style_tabs');

                // Slider Button style Normal
                $this->start_controls_tab(
                    'product_sliderbtn_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );

                    $this->add_control(
                        'button_style_heading',
                        [
                            'label' => __( 'Navigation Arrow', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                    $this->add_responsive_control(
                        'nvigation_position',
                        [
                            'label' => __( 'Position', smw_slug ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                    'step' => 5,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => '%',
                                'size' => 50,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow' => 'top: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_color',
                        [
                            'label' => __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' => '#dddddd',
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_bg_color',
                        [
                            'label' => __( 'Background Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' => '#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow' => 'background-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .product-slider .slick-arrow',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'button_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_style_dots_heading',
                        [
                            'label' => __( 'Navigation Dots', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                        $this->add_responsive_control(
                            'dots_position',
                            [
                                'label' => __( 'Position', smw_slug ),
                                'type' => Controls_Manager::SLIDER,
                                'size_units' => [ 'px', '%' ],
                                'range' => [
                                    'px' => [
                                        'min' => 0,
                                        'max' => 1000,
                                        'step' => 5,
                                    ],
                                    '%' => [
                                        'min' => 0,
                                        'max' => 100,
                                    ],
                                ],
                                'default' => [
                                    'unit' => '%',
                                    'size' => 50,
                                ],
                                'selectors' => [
                                    '{{WRAPPER}} .product-slider .slick-dots' => 'left: {{SIZE}}{{UNIT}};',
                                ],
                            ]
                        );

                        $this->add_control(
                            'dots_bg_color',
                            [
                                'label' => __( 'Background Color', smw_slug ),
                                'type' => Controls_Manager::COLOR,
                                'scheme' => [
                                    'type' => Color::get_type(),
                                    'value' => Color::COLOR_1,
                                ],
                                'default' =>'#ffffff',
                                'selectors' => [
                                    '{{WRAPPER}} .product-slider .slick-dots li button' => 'background-color: {{VALUE}} !important;',
                                ],
                            ]
                        );

                        $this->add_group_control(
                            Group_Control_Border::get_type(),
                            [
                                'name' => 'dots_border',
                                'label' => __( 'Border', smw_slug ),
                                'selector' => '{{WRAPPER}} .product-slider .slick-dots li button',
                            ]
                        );

                        $this->add_responsive_control(
                            'dots_border_radius',
                            [
                                'label' => esc_html__( 'Border Radius', smw_slug ),
                                'type' => Controls_Manager::DIMENSIONS,
                                'selectors' => [
                                    '{{WRAPPER}} .product-slider .slick-dots li button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                                ],
                            ]
                        );

                $this->end_controls_tab();// Normal button style end

                // Button style Hover
                $this->start_controls_tab(
                    'product_sliderbtn_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );

                    $this->add_control(
                        'button_style_arrow_heading',
                        [
                            'label' => __( 'Navigation', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                    $this->add_control(
                        'button_hover_color',
                        [
                            'label' => __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#23252a',
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow:hover' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_hover_bg_color',
                        [
                            'label' => __( 'Background', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow:hover' => 'background-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'button_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .product-slider .slick-arrow:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'button_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .product-slider .slick-arrow:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'button_style_dotshov_heading',
                        [
                            'label' => __( 'Navigation Dots', smw_slug ),
                            'type' => Controls_Manager::HEADING,
                        ]
                    );

                        $this->add_control(
                            'dots_hover_bg_color',
                            [
                                'label' => __( 'Background Color', smw_slug ),
                                'type' => Controls_Manager::COLOR,
                                'scheme' => [
                                    'type' => Color::get_type(),
                                    'value' => Color::COLOR_1,
                                ],
                                'default' =>'#282828',
                                'selectors' => [
                                    '{{WRAPPER}} .product-slider .slick-dots li button:hover' => 'background-color: {{VALUE}} !important;',
                                    '{{WRAPPER}} .product-slider .slick-dots li.slick-active button' => 'background-color: {{VALUE}} !important;',
                                ],
                            ]
                        );

                        $this->add_group_control(
                            Group_Control_Border::get_type(),
                            [
                                'name' => 'dots_border_hover',
                                'label' => __( 'Border', smw_slug ),
                                'selector' => '{{WRAPPER}} .product-slider .slick-dots li button:hover',
                            ]
                        );

                        $this->add_responsive_control(
                            'dots_border_radius_hover',
                            [
                                'label' => esc_html__( 'Border Radius', smw_slug ),
                                'type' => Controls_Manager::DIMENSIONS,
                                'selectors' => [
                                    '{{WRAPPER}} .product-slider .slick-dots li button:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                                ],
                            ]
                        );

                $this->end_controls_tab();// Hover button style end

            $this->end_controls_tabs();

        $this->end_controls_section(); // Tab option end
    }
    
    protected function product_tab_style_control()
    {
        // Product Tab menu setting
        $this->start_controls_section(
            'stiles-products-tab-menu',
            [
                'label' => esc_html__( 'Tab Menu Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'product_layout_style' => 'tab',
                ]
            ]
        );

            $this->add_responsive_control(
                'stiles-tab-menu-align',
                [
                    'label' => __( 'Alignment', smw_slug ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', smw_slug ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .product-tab-list.sm-text-center' => 'text-align: {{VALUE}};',
                    ],
                    'default' => 'center',
                    'separator' =>'after',
                ]
            );

            $this->add_responsive_control(
                'product_tab_menu_area_margin',
                [
                    'label' => __( 'Tab Menu Area Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-tab-menus' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->start_controls_tabs('product_tab_style_tabs');

                // Tab menu style Normal
                $this->start_controls_tab(
                    'product_tab_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'tabmenutypography',
                            'scheme' => Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}} .sm-tab-menus li a',
                        ]
                    );

                    $this->add_control(
                        'tab_menu_color',
                        [
                            'label' => __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#23252a',
                            'selectors' => [
                                '{{WRAPPER}} .sm-tab-menus li a' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_tab_menu_bg_color',
                        [
                            'label' => __( 'Product tab menu background', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .sm-tab-menus li a' => 'background-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'tabmenu_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .sm-tab-menus li a',
                        ]
                    );

                    $this->add_responsive_control(
                        'tabmenu_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .sm-tab-menus li a' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_tab_menu_padding',
                        [
                            'label' => __( 'Tab Menu padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-tab-menus li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_tab_menu_margin',
                        [
                            'label' => __( 'Tab Menu margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .sm-tab-menus li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                            ],
                        ]
                    );

                $this->end_controls_tab();// Normal tab menu style end

                // Tab menu style Hover
                $this->start_controls_tab(
                    'product_tab_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );


                    $this->add_control(
                        'tab_menu_hover_color',
                        [
                            'label' => __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#23252a',
                            'selectors' => [
                                '{{WRAPPER}} .sm-tab-menus li a:hover' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .sm-tab-menus li a.smactive' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_tab_menu_hover_bg_color',
                        [
                            'label' => __( 'Product tab menu background', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'scheme' => [
                                'type' => Color::get_type(),
                                'value' => Color::COLOR_1,
                            ],
                            'default' =>'#ffffff',
                            'selectors' => [
                                '{{WRAPPER}} .sm-tab-menus li a:hover' => 'background-color: {{VALUE}} !important;',
                                '{{WRAPPER}} .sm-tab-menus li a.smactive' => 'background-color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'tabmenu_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .sm-tab-menus li a:hover',
                            'selector' => '{{WRAPPER}} .sm-tab-menus li a.smactive',
                        ]
                    );

                    $this->add_responsive_control(
                        'tabmenu_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .sm-tab-menus li a:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                                '{{WRAPPER}} .sm-tab-menus li a.smactive' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab();// Hover tab menu style end

            $this->end_controls_tabs();

        $this->end_controls_section(); // Tab option end
    }
    
    protected function render( $instance = [] ) 
    {
        $settings           = $this->get_settings_for_display();
        $product_type       = $this->get_settings_for_display('stiles_product_grid_product_filter');
        $per_page           = $this->get_settings_for_display('stiles_product_grid_products_count');
        $custom_order_ck    = $this->get_settings_for_display('stiles_custom_order');
        $orderby            = $this->get_settings_for_display('orderby');
        $order              = $this->get_settings_for_display('order');
        $tabuniqid          = $this->get_id();
        $columns            = $this->get_settings_for_display('stiles_product_grid_column');

        // Query Argument
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $per_page,
        );

        // Category Wise
        $get_product_categories = $settings['stiles_product_grid_categories'];
        $product_cats = str_replace(' ', '', $get_product_categories);
        if ( "0" != $get_product_categories) 
        {
            if( is_array($product_cats) && count($product_cats) > 0 )
            {
                $field_name = is_numeric($product_cats[0])?'term_id':'slug';
                $args['tax_query'][] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms' => $product_cats,
                        'field' => $field_name,
                        'include_children' => false
                    )
                );
            }
        }

        // Product tags Wise
        $get_product_tags = $settings['stiles_product_grid_tags'];
        $product_tags = str_replace(' ', '', $get_product_tags);
        if ( "0" != $get_product_tags) 
        {
            if( is_array($product_tags) && count($product_tags) > 0 )
            {
                $field_name = is_numeric($product_tags[0])?'term_id':'slug';
                $args['tax_query'][] = array(
                    array(
                        'taxonomy' => 'product_tag',
                        'terms' => $product_tags,
                        'field' => $field_name,
                        'include_children' => false
                    )
                );
            }
        }

        // Product Type Check
        switch( $product_type )
        {
            case 'sale':
                $args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
            break;

            case 'featured':
                $args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );
            break;

            case 'best_selling':
                $args['meta_key']   = 'total_sales';
                $args['orderby']    = 'meta_value_num';
                $args['order']      = 'desc';
            break;

            case 'top_rated': 
                $args['meta_key']   = '_wc_average_rating';
                $args['orderby']    = 'meta_value_num';
                $args['order']      = 'desc';          
            break;

            case 'mixed_order':
                $args['orderby']    = 'rand';
            break;

            case 'show_byid':
                $args['post__in'] = $settings['stiles_product_id'];
            break;

            case 'show_byid_manually':
                $args['post__in'] = explode( ',', $settings['stiles_product_ids_manually'] );
            break;

            default: /* Recent */
                $args['orderby']    = 'date';
                $args['order']      = 'desc';
            break;
        }

        // Custom Order
        if( $custom_order_ck == 'yes' )
        {
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }

        $products = new \WP_Query( $args );

        // Calculate Column
        $columnval = ( $settings['product_layout_style'] == 'slider' ) ? 'sm-product mb-30 product sm-col-xs-12' : 'sm-product sm-col-lg-4 sm-col-md-6 sm-col-sm-6 sm-col-xs-12 mb-30 product';
        if( $columns !='' )
        {
            $colwidthtablate = round( 12 / $settings['stiles_product_grid_column_tablet'] );
            $colwidthmobile = round( 12 / $settings['stiles_product_grid_column_mobile'] );
            if( $columns == 5 ){
                $columnval = 'sm-product cus-col-5 sm-col-md-'.$colwidthtablate.' sm-col-sm-'.$colwidthtablate.' sm-col-xs-'.$colwidthmobile.' mb-30 product';
            }else{
                $colwidth = round( 12 / $columns );
                $columnval = 'sm-product sm-col-lg-'.$colwidth.' sm-col-md-'.$colwidthtablate.' sm-col-sm-'.$colwidthtablate.' sm-col-xs-'.$colwidthmobile.' mb-30 product';
            }
        }

        // Action Button Style
        if( $settings['action_button_style'] == 2 )
        {
            $columnval .= ' sm-product-action-style-2';
        }elseif( $settings['action_button_style'] == 3 )
        {
            $columnval .= ' sm-product-action-style-2 sm-product-action-round';
        }else{
            $columnval = $columnval;
        }

        // Position Action Button
        if( $settings['action_button_position'] == 'right' )
        {
            $columnval .= ' sm-product-action-right';
        }elseif( $settings['action_button_position'] == 'bottom' )
        {
            $columnval .= ' sm-product-action-bottom';
        }elseif( $settings['action_button_position'] == 'middle' )
        {
            $columnval .= ' sm-product-action-middle';
        }elseif( $settings['action_button_position'] == 'contentbottom' )
        {
            $columnval .= ' sm-product-action-bottom-content';
        }else{
            $columnval = $columnval;
        }

        // Show Action
        if( $settings['action_button_show_on'] == 'hover' )
        {
            $columnval .= ' sm-product-action-on-hover';
        }

        // Content Style
        if( $settings['product_content_style'] == 2 )
        {
            $columnval .= ' sm-product-category-right-bottom';
        }elseif( $settings['product_content_style'] == 3 )
        {
            $columnval .= ' sm-product-ratting-top-right';
        }elseif( $settings['product_content_style'] == 4 )
        {
            $columnval .= ' sm-product-content-allcenter';
        }else{
            $columnval = $columnval;
        }

        // Position countdown
        if( $settings['product_countdown_position'] == 'left' )
        {
            $columnval .= ' sm-product-countdown-left';
        }elseif( $settings['product_countdown_position'] == 'right' )
        {
            $columnval .= ' sm-product-countdown-right';
        }elseif( $settings['product_countdown_position'] == 'middle' )
        {
            $columnval .= ' sm-product-countdown-middle';
        }elseif( $settings['product_countdown_position'] == 'bottom' )
        {
            $columnval .= ' sm-product-countdown-bottom';
        }elseif( $settings['product_countdown_position'] == 'contentbottom' )
        {
            $columnval .= ' sm-product-countdown-content-bottom';
        }else{
            $columnval = $columnval;
        }

        // Countdown Gutter 
        if( $settings['show_countdown_gutter'] != 'yes' )
        {
           $columnval .= ' sm-product-countdown-fill'; 
        }

        // Countdown Custom Label
        if( $settings['show_countdown'] == 'yes' )
        {
            $data_customlavel = [];
            $data_customlavel['daytxt'] = ! empty( $settings['customlabel_days'] ) ? $settings['customlabel_days'] : 'Days';
            $data_customlavel['hourtxt'] = ! empty( $settings['customlabel_hours'] ) ? $settings['customlabel_hours'] : 'Hours';
            $data_customlavel['minutestxt'] = ! empty( $settings['customlabel_minutes'] ) ? $settings['customlabel_minutes'] : 'Min';
            $data_customlavel['secondstxt'] = ! empty( $settings['customlabel_seconds'] ) ? $settings['customlabel_seconds'] : 'Sec';
        }

        // Slider Options
        $is_rtl = is_rtl();
        $direction = $is_rtl ? 'rtl' : 'ltr';
        $slider_settings = [
            'arrows' => ('yes' === $settings['slarrows']),
            'dots' => ('yes' === $settings['sldots']),
            'autoplay' => ('yes' === $settings['slautoplay']),
            'autoplay_speed' => absint($settings['slautoplay_speed']),
            'animation_speed' => absint($settings['slanimation_speed']),
            'pause_on_hover' => ('yes' === $settings['slpause_on_hover']),
            'rtl' => $is_rtl,
        ];

        $slider_responsive_settings = [
            'product_items' => $settings['slitems'],
            'scroll_columns' => $settings['slscroll_columns'],
            'tablet_width' => $settings['sltablet_width'],
            'tablet_display_columns' => $settings['sltablet_display_columns'],
            'tablet_scroll_columns' => $settings['sltablet_scroll_columns'],
            'mobile_width' => $settings['slmobile_width'],
            'mobile_display_columns' => $settings['slmobile_display_columns'],
            'mobile_scroll_columns' => $settings['slmobile_scroll_columns'],

        ];
        $slider_settings = array_merge( $slider_settings, $slider_responsive_settings );

        ?>
            <?php if ( $settings['product_layout_style'] == 'tab' ) { ?>
                <div class="product-tab-list sm-text-center">
                    <ul class="sm-tab-menus">
                        <?php
                            $m=0;
                            if( is_array( $product_cats ) && count( $product_cats ) > 0 ){

                                // Category retrive
                                $catargs = array(
                                    'orderby'    => 'name',
                                    'order'      => 'ASC',
                                    'hide_empty' => true,
                                    'slug'       => $product_cats,
                                );
                                $prod_categories = get_terms( 'product_cat', $catargs);

                                foreach( $prod_categories as $prod_cats ){
                                    $m++;
                                    $field_name = is_numeric( $product_cats[0] ) ? 'term_id' : 'slug';
                                    $args['tax_query'] = array(
                                        array(
                                            'taxonomy' => 'product_cat',
                                            'terms' => $prod_cats,
                                            'field' => $field_name,
                                            'include_children' => false
                                        ),
                                    );
                                    if( 'featured' == $product_type ){
                                        $args['tax_query'][] = array(
                                            'taxonomy' => 'product_visibility',
                                            'field'    => 'name',
                                            'terms'    => 'featured',
                                            'operator' => 'IN',
                                        );
                                    }
                                    $fetchproduct = new \WP_Query( $args );

                                    if( $fetchproduct->have_posts() )
                                    {
                                        ?>
                                            <li><a class="<?php if($m==1){ echo 'smactive';}?>" href="#stilestab<?php echo $tabuniqid.esc_attr($m);?>">
                                                <?php echo esc_attr( $prod_cats->name,smw_slug );?>
                                            </a></li>
                                        <?php
                                    }
                                }
                            }
                        ?>
                    </ul>
                </div>
            <?php }; ?>

            <?php if( is_array( $product_cats ) && (count( $product_cats ) > 0) && ( $settings['product_layout_style'] == 'tab' ) ): ?>
                <div class="sm-products woocommerce">
                    
                    <?php
                    $z=0;
                    $tabcatargs = array(
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                        'hide_empty' => true,
                        'slug'       => $product_cats,
                    );
                    $tabcat_fach = get_terms( 'product_cat', $tabcatargs );
                    foreach( $tabcat_fach as $cats ):
                        $z++;
                        $field_name = is_numeric( $product_cats[0] ) ? 'term_id' : 'slug';
                        $args['tax_query'] = array(
                            array(
                                'taxonomy' => 'product_cat',
                                'terms' => $cats,
                                'field' => $field_name,
                                'include_children' => false
                            )
                        );

                        $field_name = is_numeric( $product_cats[0] ) ? 'term_id' : 'slug';
                        $args['tax_query'] = array(
                            array(
                                'taxonomy' => 'product_cat',
                                'terms' => $cats,
                                'field' => $field_name,
                                'include_children' => false
                            ),
                        );
                        if( 'featured' == $product_type )
                        {
                            $args['tax_query'][] = array(
                                'taxonomy' => 'product_visibility',
                                'field'    => 'name',
                                'terms'    => 'featured',
                                'operator' => 'IN',
                            );
                        }

                        $products = new \WP_Query( $args );

                        if( $products->have_posts() ):
                    ?>
                        <div class="sm-tab-pane <?php if( $z==1 ){ echo 'smactive'; } ?>" id="<?php echo 'stilestab'.$tabuniqid.$z;?>">
                            <div class="sm-row">

                                <?php
                                while( $products->have_posts() ): $products->the_post();

                                    // Sale Schedule
                                    $offer_start_date_timestamp = get_post_meta( get_the_ID(), '_sale_price_dates_from', true );
                                    $offer_start_date = $offer_start_date_timestamp ? date_i18n( 'Y/m/d', $offer_start_date_timestamp ) : '';
                                    $offer_end_date_timestamp = get_post_meta( get_the_ID(), '_sale_price_dates_to', true );
                                    $offer_end_date = $offer_end_date_timestamp ? date_i18n( 'Y/m/d', $offer_end_date_timestamp ) : '';

                                    // Gallery Image
                                    global $product;
                                    $gallery_images_ids = $product->get_gallery_image_ids() ? $product->get_gallery_image_ids() : array();
                                    if ( has_post_thumbnail() )
                                    {
                                        array_unshift( $gallery_images_ids, $product->get_image_id() );
                                    }

                                ?>

                                    <!--Product Start-->
                                    <div <?php wc_product_class( $columnval ); ?>>
                                        <div class="sm-product-inner">

                                            <div class="sm-product-image-wrap">
                                                <?php
                                                    if( class_exists('WooCommerce') )
                                                    { 
                                                        stiles_custom_product_badge(); 
                                                        stiles_sale_flash();
                                                    }
                                                ?>
                                                <div class="sm-product-image">
                                                    <?php  if( $settings['thumbnails_style'] == 2 && $gallery_images_ids ): ?>
                                                        <div class="sm-product-image-slider sm-product-image-thumbnails-<?php echo $tabuniqid; ?>">
                                                            <?php
                                                                foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                                                    echo '<a href="'.esc_url( get_the_permalink() ).'" class="item">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_thumbnail' ).'</a>';
                                                                }
                                                            ?>
                                                        </div>

                                                    <?php elseif( $settings['thumbnails_style'] == 3 && $gallery_images_ids ) : $tabactive = ''; ?>
                                                        <div class="sm-product-cus-tab">
                                                            <?php
                                                                $i = 0;
                                                                foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                                                    $i++;
                                                                    if( $i == 1 ){ $tabactive = 'smactive'; }else{ $tabactive = ' '; }
                                                                    echo '<div class="sm-product-cus-tab-pane '.$tabactive.'" id="image-'.$i.get_the_ID().'"><a href="'.esc_url( get_the_permalink() ).'">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_thumbnail' ).'</a></div>';
                                                                }
                                                            ?>
                                                        </div>
                                                        <ul class="sm-product-cus-tab-links">
                                                            <?php
                                                                $j = 0;
                                                                foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                                                    $j++;
                                                                    if( $j == 1 ){ $tabactive = 'smactive'; }else{ $tabactive = ' '; }
                                                                    echo '<li><a href="#image-'.$j.get_the_ID().'" class="'.$tabactive.'">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' ).'</a></li>';
                                                                }
                                                            ?>
                                                        </ul>

                                                    <?php else: ?>
                                                        <a href="<?php the_permalink();?>"> 
                                                            <?php woocommerce_template_loop_product_thumbnail(); ?> 
                                                        </a>
                                                    <?php endif; ?>
                                                </div>

                                                <?php if( $settings['show_countdown'] == 'yes' && $settings['product_countdown_position'] != 'contentbottom' && $offer_end_date != '' ):

                                                    if( $offer_start_date_timestamp && $offer_end_date_timestamp && current_time( 'timestamp' ) > $offer_start_date_timestamp && current_time( 'timestamp' ) < $offer_end_date_timestamp
                                                    ): 
                                                ?>
                                                    <div class="sm-product-countdown-wrap">
                                                        <div class="sm-product-countdown" data-countdown="<?php echo esc_attr( $offer_end_date ); ?>" data-customlavel='<?php echo wp_json_encode( $data_customlavel ) ?>'></div>
                                                    </div>
                                                <?php endif; endif; ?>

                                                <?php if( $settings['show_action_button'] == 'yes' ){ if( $settings['action_button_position'] != 'contentbottom' ): ?>
                                                    <div class="sm-product-action">
                                                        <ul>
                                                            <li>
                                                                <a href="javascript:void(0);" class="stilesquickview" data-quick-id="<?php the_ID();?>" >
                                                                    <i class="sli sli-magnifier"></i>
                                                                    <span class="sm-product-action-tooltip"><?php esc_html_e('Quick View',smw_slug); ?></span>
                                                                </a>
                                                            </li>
                                                            <?php
                                                                if ( class_exists( 'YITH_WCWL' ) ) {
                                                                    echo '<li>'.stiles_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'yes').'</li>';
                                                                }
                                                                if( class_exists('TInvWL_Public_AddToWishlist') ){
                                                                    echo '<li>';
                                                                        \TInvWL_Public_AddToWishlist::instance()->htmloutput();
                                                                    echo '</li>';
                                                                }
                                                            ?>
                                                            <?php
                                                                if( function_exists('stiles_compare_button') && class_exists('YITH_Woocompare_Frontend') ){
                                                                    echo '<li>';
                                                                        stiles_compare_button(2);
                                                                    echo '</li>';
                                                                }
                                                            ?>
                                                            <li class="stiles-cart"><?php woocommerce_template_loop_add_to_cart(); ?></li>
                                                        </ul>
                                                    </div>
                                                <?php endif; } ?>

                                            </div>

                                            <div class="sm-product-content">
                                                <div class="sm-product-content-inner">
                                                    <div class="sm-product-categories"><?php stiles_get_product_category_list(); ?></div>
                                                    <h4 class="sm-product-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), $settings['title_length'], '' ); ?></a></h4>
                                                    <div class="sm-product-price"><?php woocommerce_template_loop_price();?></div>
                                                    <div class="sm-product-ratting-wrap"><?php echo stiles_wc_get_rating_html(); ?></div>

                                                    <?php if( $settings['show_action_button'] == 'yes' ){ if( $settings['action_button_position'] == 'contentbottom' ): ?>
                                                        <div class="sm-product-action">
                                                            <ul>
                                                                <li>
                                                                    <a href="javascript:void(0);" class="stilesquickview" data-quick-id="<?php the_ID();?>" >
                                                                        <i class="sli sli-magnifier"></i>
                                                                        <span class="sm-product-action-tooltip"><?php esc_html_e('Quick View',smw_slug); ?></span>
                                                                    </a>
                                                                </li>
                                                                <?php
                                                                    if ( class_exists( 'YITH_WCWL' ) ) {
                                                                        echo '<li>'.stiles_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'yes').'</li>';
                                                                    }
                                                                    if( class_exists('TInvWL_Public_AddToWishlist') ){
                                                                        echo '<li>';
                                                                            \TInvWL_Public_AddToWishlist::instance()->htmloutput();
                                                                        echo '</li>';
                                                                    }
                                                                ?>
                                                                <?php
                                                                    if( function_exists('stiles_compare_button') && class_exists('YITH_Woocompare_Frontend') ){
                                                                        echo '<li>';
                                                                            stiles_compare_button(2);
                                                                        echo '</li>';
                                                                    }
                                                                ?>
                                                                <li class="stiles-cart"><?php woocommerce_template_loop_add_to_cart(); ?></li>
                                                            </ul>
                                                        </div>
                                                    <?php endif; } ?>

                                                    <?php 
                                                        if( $settings['show_product_excerpt'] == 'yes' ){
                                                            echo '<div class="stiles-short-desc">'.wp_trim_words( get_the_excerpt(), $settings['excerpt_length'], '' ).'</div>';
                                                        }
                                                    ?>

                                                </div>
                                                <?php 
                                                    if( $settings['show_countdown'] == 'yes' && $settings['product_countdown_position'] == 'contentbottom' && $offer_end_date != ''  ):

                                                        if( $offer_start_date_timestamp && $offer_end_date_timestamp && current_time( 'timestamp' ) > $offer_start_date_timestamp && current_time( 'timestamp' ) < $offer_end_date_timestamp
                                                        ):
                                                ?>
                                                    <div class="sm-product-countdown-wrap">
                                                        <div class="sm-product-countdown" data-countdown="<?php echo esc_attr( $offer_end_date ); ?>" data-customlavel='<?php echo wp_json_encode( $data_customlavel ) ?>'></div>
                                                    </div>
                                                <?php endif; endif; ?>
                                            </div>

                                        </div>
                                    </div>
                                    <!--Product End-->

                                <?php endwhile; wp_reset_query(); wp_reset_postdata(); ?>

                            </div>
                        </div>
                    <?php endif; endforeach; ?>
                    
                </div>

            <?php else: ?>
                <?php if( $settings['product_layout_style'] == 'slider' ){ echo '<div class="sm-row">'; } ?>
                    <div class="sm-products woocommerce <?php if( $settings['product_layout_style'] == 'slider' ){ echo esc_attr( 'product-slider' ); } else{ echo 'sm-row'; } ?>" dir="<?php echo $direction; ?>" data-settings='<?php if( $settings['product_layout_style'] == 'slider' ){ echo wp_json_encode( $slider_settings ); } ?>'>

                        <?php
                            if( $products->have_posts() ):

                                while( $products->have_posts() ): $products->the_post();

                                    // Sale Schedule
                                    $offer_start_date_timestamp = get_post_meta( get_the_ID(), '_sale_price_dates_from', true );
                                    $offer_start_date = $offer_start_date_timestamp ? date_i18n( 'Y/m/d', $offer_start_date_timestamp ) : '';
                                    $offer_end_date_timestamp = get_post_meta( get_the_ID(), '_sale_price_dates_to', true );
                                    $offer_end_date = $offer_end_date_timestamp ? date_i18n( 'Y/m/d', $offer_end_date_timestamp ) : '';

                                    // Gallery Image
                                    global $product;
                                    $gallery_images_ids = $product->get_gallery_image_ids() ? $product->get_gallery_image_ids() : array();
                                    if ( has_post_thumbnail() )
                                    {
                                        array_unshift( $gallery_images_ids, $product->get_image_id() );
                                    }

                        ?>

                            <!--Product Start-->
                            <div class="<?php echo $columnval; ?>">
                                <div class="sm-product-inner">

                                    <div class="sm-product-image-wrap">
                                        <?php
                                            if( class_exists('WooCommerce') )
                                            { 
                                                stiles_custom_product_badge(); 
                                                stiles_sale_flash();
                                            }
                                        ?>
                                        <div class="sm-product-image">
                                            <?php  if( $settings['thumbnails_style'] == 2 && $gallery_images_ids ): ?>
                                                <div class="sm-product-image-slider sm-product-image-thumbnails-<?php echo $tabuniqid; ?>" data-slick='{"rtl":<?php if( is_rtl() ){ echo 'true'; }else{ echo 'false'; } ?> }'>
                                                    <?php
                                                        foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                                            echo '<a href="'.esc_url( get_the_permalink() ).'" class="item">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_thumbnail' ).'</a>';
                                                        }
                                                    ?>
                                                </div>

                                            <?php elseif( $settings['thumbnails_style'] == 3 && $gallery_images_ids ) : $tabactive = ''; ?>
                                                <div class="sm-product-cus-tab">
                                                    <?php
                                                        $i = 0;
                                                        foreach ( $gallery_images_ids as $gallery_attachment_id ) 
                                                        {
                                                            $i++;
                                                            if( $i == 1 ){ $tabactive = 'smactive'; }else{ $tabactive = ' '; }
                                                            echo '<div class="sm-product-cus-tab-pane '.$tabactive.'" id="image-'.$i.get_the_ID().'"><a href="#">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_thumbnail' ).'</a></div>';
                                                        }
                                                    ?>
                                                </div>
                                                <ul class="sm-product-cus-tab-links">
                                                    <?php
                                                        $j = 0;
                                                        foreach ( $gallery_images_ids as $gallery_attachment_id ) 
                                                        {
                                                            $j++;
                                                            if( $j == 1 ){ $tabactive = 'smactive'; }else{ $tabactive = ' '; }
                                                            echo '<li><a href="#image-'.$j.get_the_ID().'" class="'.$tabactive.'">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' ).'</a></li>';
                                                        }
                                                    ?>
                                                </ul>

                                            <?php else: ?>
                                                <a href="<?php the_permalink();?>"> 
                                                    <?php woocommerce_template_loop_product_thumbnail(); ?> 
                                                </a>
                                            <?php endif; ?>
                                        </div>

                                        <?php if( $settings['show_countdown'] == 'yes' && $settings['product_countdown_position'] != 'contentbottom' && $offer_end_date != '' ):

                                            if( $offer_start_date_timestamp && $offer_end_date_timestamp && current_time( 'timestamp' ) > $offer_start_date_timestamp && current_time( 'timestamp' ) < $offer_end_date_timestamp
                                            ): 
                                        ?>
                                            <div class="sm-product-countdown-wrap">
                                                <div class="sm-product-countdown" data-countdown="<?php echo esc_attr( $offer_end_date ); ?>" data-customlavel='<?php echo wp_json_encode( $data_customlavel ) ?>'></div>
                                            </div>
                                        <?php endif; endif; ?>

                                        <?php if( $settings['show_action_button'] == 'yes' ){ if( $settings['action_button_position'] != 'contentbottom' ): ?>
                                            <div class="sm-product-action">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0);" class="stilesquickview" data-quick-id="<?php the_ID();?>" >
                                                            <i class="sli sli-magnifier"></i>
                                                            <span class="sm-product-action-tooltip"><?php esc_html_e('Quick View',smw_slug); ?></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                        if ( class_exists( 'YITH_WCWL' ) ) 
                                                        {
                                                            echo '<li>'.stiles_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'yes').'</li>';
                                                        }
                                                        if( class_exists('TInvWL_Public_AddToWishlist') )
                                                        {
                                                            echo '<li>';
                                                                \TInvWL_Public_AddToWishlist::instance()->htmloutput();
                                                            echo '</li>';
                                                        }
                                                    ?>
                                                    <?php
                                                        if( function_exists('stiles_compare_button') && class_exists('YITH_Woocompare_Frontend') ){
                                                            echo '<li>';
                                                                stiles_compare_button(2);
                                                            echo '</li>';
                                                        }
                                                    ?>
                                                    <li class="stiles-cart"><?php woocommerce_template_loop_add_to_cart(); ?></li>
                                                </ul>
                                            </div>
                                        <?php endif; }?>

                                    </div>

                                    <div class="sm-product-content">
                                        <div class="sm-product-content-inner">
                                            <div class="sm-product-categories"><?php stiles_get_product_category_list(); ?></div>
                                            <h4 class="sm-product-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), $settings['title_length'], '' ); ?></a></h4>
                                            <div class="sm-product-price"><?php woocommerce_template_loop_price();?></div>
                                            <div class="sm-product-ratting-wrap"><?php echo stiles_wc_get_rating_html(); ?></div>

                                            <?php if( $settings['show_action_button'] == 'yes' ){ if( $settings['action_button_position'] == 'contentbottom' ): ?>
                                                <div class="sm-product-action">
                                                    <ul>
                                                        <li>
                                                            <a href="javascript:void(0);" class="stilesquickview" data-quick-id="<?php the_ID();?>" >
                                                                <i class="sli sli-magnifier"></i>
                                                                <span class="sm-product-action-tooltip"><?php esc_html_e('Quick View',smw_slug); ?></span>
                                                            </a>
                                                        </li>
                                                        <?php
                                                            if ( class_exists( 'YITH_WCWL' ) ) 
                                                            {
                                                                echo '<li>'.stiles_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'yes').'</li>';
                                                            }
                                                            if( class_exists('TInvWL_Public_AddToWishlist') )
                                                            {
                                                                echo '<li>';
                                                                    \TInvWL_Public_AddToWishlist::instance()->htmloutput();
                                                                echo '</li>';
                                                            }
                                                        ?>
                                                        <?php
                                                            if( function_exists('stiles_compare_button') && class_exists('YITH_Woocompare_Frontend') ){
                                                                echo '<li>';
                                                                    stiles_compare_button(2);
                                                                echo '</li>';
                                                            }
                                                        ?>
                                                        <li class="stiles-cart"><?php woocommerce_template_loop_add_to_cart(); ?></li>
                                                    </ul>
                                                </div>
                                            <?php endif; } ?>

                                            <?php 
                                                if( $settings['show_product_excerpt'] == 'yes' )
                                                {
                                                    echo '<div class="stiles-short-desc">'.wp_trim_words( get_the_excerpt(), $settings['excerpt_length'], '' ).'</div>';
                                                }
                                            ?>

                                        </div>
                                        <?php 
                                            if( $settings['show_countdown'] == 'yes' && $settings['product_countdown_position'] == 'contentbottom' && $offer_end_date != ''  ):

                                                if( $offer_start_date_timestamp && $offer_end_date_timestamp && current_time( 'timestamp' ) > $offer_start_date_timestamp && current_time( 'timestamp' ) < $offer_end_date_timestamp
                                                ):
                                        ?>
                                            <div class="sm-product-countdown-wrap">
                                                <div class="sm-product-countdown" data-countdown="<?php echo esc_attr( $offer_end_date ); ?>" data-customlavel='<?php echo wp_json_encode( $data_customlavel ) ?>'></div>
                                            </div>
                                        <?php endif; endif; ?>
                                    </div>

                                </div>
                            </div>
                            <!--Product End-->

                        <?php endwhile; wp_reset_query(); wp_reset_postdata(); endif; ?>
                    </div>
                <?php if( $settings['product_layout_style'] == 'slider' ){ echo '</div>'; } ?>
            <?php endif; ?>

            <?php if ( Plugin::instance()->editor->is_edit_mode() ) 
            { ?>
                <script>
                    jQuery(document).ready(function($) 
                    {
                        'use strict';
                        $(".sm-product-image-thumbnails-<?php echo $tabuniqid; ?>").slick({
                            dots: true,
                            arrows: true,
                            prevArrow: '<button class="slick-prev"><i class="sli sli-arrow-left"></i></button>',
                            nextArrow: '<button class="slick-next"><i class="sli sli-arrow-right"></i></button>',
                        });
                    });
                </script>
            <?php } ?>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_product_layout() );