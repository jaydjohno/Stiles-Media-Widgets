<?php

/**
 * Stiles Media Widgets My Account: Account.
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
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Repeater;

class stiles_wc_my_account_account extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'my-account-account-style', plugin_dir_url( __FILE__ ) . '../css/my-account-account.css');
    }
    
    public function get_name() 
    {
        return 'stiles-my-account-account';
    }
    
    public function get_title() 
    {
        return __( 'My Account: Account Page', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-elementor';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'my-account-account-style' ];
    }
    
    protected function register_controls() 
    {
        $this->user_info_show();

        $this->my_account_user_style();
        
        $this->my_account_menu_style();

        $this->my_account_content_style();
    }
    
    protected function user_info_show()
    {
        $this->start_controls_section(
            'myaccount_content_setting',
            [
                'label' => esc_html__( 'Settings', smw_slug ),
            ]
        );
            
            $this->add_control(
                'user_info_show',
                [
                    'label' => esc_html__( 'User Info', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Yes', smw_slug ),
                    'label_off' => esc_html__( 'No', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'menu_items',
                [
                    'label' => esc_html__( 'Menu Items', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'dashboard',
                    'options' => [
                        'dashboard' => esc_html__( 'Dashboard', smw_slug ),
                        'orders' => esc_html__( 'Orders', smw_slug ),
                        'downloads' => esc_html__( 'Downloads', smw_slug ),
                        'edit-address' => esc_html__( 'Addresses', smw_slug ),
                        'edit-account' => esc_html__( 'Account details', smw_slug ),
                        'customer-logout' => esc_html__( 'Logout', smw_slug ),
                        'customadd' => esc_html__( 'Custom', smw_slug ),
                    ],
                ]
            );

            $repeater->add_control(
                'menu_title', 
                [
                    'label' => esc_html__( 'Menu Title', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'New Menu Item' , smw_slug ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'menu_key', 
                [
                    'label' => esc_html__( 'Menu Key', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'newmenuitem' , smw_slug ),
                    'label_block' => true,
                    'condition'=>[
                        'menu_items'=>'customadd',
                    ],
                ]
            );

            $repeater->add_control(
                'menu_url', 
                [
                    'label' => esc_html__( 'Menu URL', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( '#' , smw_slug ),
                    'label_block' => true,
                    'condition'=>[
                        'menu_items'=>'customadd',
                    ],
                ]
            );

            $this->add_control(
                'navigation_list',
                [
                    'label' => __( 'Navigation List', smw_slug ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'menu_items' => 'dashboard',
                            'menu_title' => esc_html__( 'Dashboard', smw_slug ),
                        ],
                        [
                            'menu_items' => 'orders',
                            'menu_title' => esc_html__( 'Orders', smw_slug ),
                        ],
                        [
                            'menu_items' => 'downloads',
                            'menu_title' => esc_html__( 'Downloads', smw_slug ),
                        ],
                        [
                            'menu_items' => 'edit-address',
                            'menu_title' => esc_html__( 'Addresses', smw_slug ),
                        ],
                        [
                            'menu_items' => 'edit-account',
                            'menu_title' => esc_html__( 'Account details', smw_slug ),
                        ],
                        [
                            'menu_items' => 'customer-logout',
                            'menu_title' => esc_html__( 'Logout', smw_slug ),
                        ],
                    ],
                    
                    'title_field' => '{{{ menu_title }}}',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function my_account_user_style()
    {
        // My Account User Info Style
        $this->start_controls_section(
            'myaccount_user_info_style',
            array(
                'label' => __( 'User Info', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'user_info_show'=>'yes'
                ]
            )
        );
                    
            $this->add_control(
                'myaccount_usermeta_text_color',
                [
                    'label' => __( 'Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .stiles-user-info' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'myaccount_usermeta_link_color',
                [
                    'label' => __( 'Logout Link', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .stiles-logout a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'myaccount_usermeta_link_hover_color',
                [
                    'label' => __( 'Logout Link Hover', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .stiles-logout a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'myaccount_usermeta_name_typography',
                    'label' => __( 'Name Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .stiles_my_account_page .stiles-username',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'myaccount_usermeta_logout_typography',
                    'label' => __( 'Logout Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .stiles_my_account_page .stiles-logout',
                ]
            );

            $this->add_responsive_control(
                'myaccount_usermeta_image_border_radius',
                [
                    'label' => __( 'Image Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .stiles-user-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'myaccount_usermeta_alignment',
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
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .stiles-user-area' => 'justify-content: {{VALUE}}',
                    ],
                ]
            );


        $this->end_controls_section();
    }
    
    protected function my_account_menu_style()
    {
        // My Account Menu Style
        $this->start_controls_section(
            'myaccount_menu_style',
            array(
                'label' => __( 'Menu', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_control(
                'myaccount_menu_type',
                [
                    'label'   => __( 'Menu Type', smw_slug ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'hleft' => [
                            'title' => __( 'Horizontal Left', smw_slug ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'hright' => [
                            'title' => __( 'Horizontal Right', smw_slug ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'vtop' => [
                            'title' => __( 'Vertical Top', smw_slug ),
                            'icon'  => 'eicon-v-align-top',
                        ],
                        'vbottom' => [
                            'title' => __( 'Vertical Bottom', smw_slug ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'     => is_rtl() ? 'hright' : 'hleft',
                    'toggle'      => false,
                ]
            );

            $this->add_responsive_control(
                'myaccount_menu_area_margin',
                [
                    'label' => __( 'Menu Area Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'myaccount_menu_alignment',
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
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->start_controls_tabs('myaccount_menu_style_tabs');

                $this->add_responsive_control(
                    'myaccount_menu_area_width',
                    [
                        'label' => __( 'Menu Area Width', smw_slug ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px', '%' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 1000,
                                'step' => 1,
                            ],
                            '%' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default' => [
                            'unit' => '%',
                            'size' => 30,
                        ],
                        'condition'=>[
                            'myaccount_menu_type' => array( 'hleft','hright' ),
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                // Menu Normal Color
                $this->start_controls_tab(
                    'myaccount_menu_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'myaccount_menu_text_color',
                        [
                            'label' => __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'myaccount_menu_text_typography',
                            'label' => __( 'Typography', smw_slug ),
                            'scheme' => Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li a',
                        ]
                    );

                    $this->add_responsive_control(
                        'myaccount_menu_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'myaccount_menu_margin',
                        [
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'myaccount_menu_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li',
                        ]
                    );

                $this->end_controls_tab();

                // Menu Hover
                $this->start_controls_tab(
                    'myaccount_menu_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'myaccount_menu_text_hover_color',
                        [
                            'label' => __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li a:hover' => 'color: {{VALUE}}',
                                '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li.is-active a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function my_account_content_style()
    {
        // Style
        $this->start_controls_section(
            'myaccount_content_style',
            array(
                'label' => __( 'Content', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_responsive_control(
                'myaccount_content_area_width',
                [
                    'label' => __( 'Content Area Width', smw_slug ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 68,
                    ],
                    'condition'=>[
                        'myaccount_menu_type' => array( 'hleft','hright' ),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'myaccount_text_color',
                [
                    'label' => __( 'Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'myaccount_link_color',
                [
                    'label' => __( 'Link Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'myaccount_text_typography',
                    'selector' => '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content',
                ]
            );

            $this->add_responsive_control(
                'myaccount_content_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'myaccount_content_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                'myaccount_alignment',
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
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function render() 
    {
        $settings = $this->get_settings_for_display();

        if ( Plugin::instance()->editor->is_edit_mode() ) 
        {
            $this->my_account_content( $settings['navigation_list'], $settings['user_info_show'], $settings['myaccount_menu_type'] );
        }else{
            if ( ! is_user_logged_in() ) 
            { 
                return __('You need to log in to view this page', smw_slug); 
            }
            
            $this->my_account_content( $settings['navigation_list'], $settings['user_info_show'], $settings['myaccount_menu_type'] );
        }
    }

    public function my_account_content( $settings, $userinfo, $menutype )
    {
        $items       = array();
        $item_url    = array();
        
        if( isset( $settings ) )
        {
            foreach ( $settings as $key => $navigation ) 
            {
                if( $navigation['menu_items'] == 'customadd' )
                {
                    $items[$navigation['menu_key']] = $navigation['menu_title'];
                    $item_url[$navigation['menu_key']] = $navigation['menu_url'];
                }else
                {
                   $items[$navigation['menu_items']] = $navigation['menu_title'];
               }
            }
        }else
        {
            $items = [
                'dashboard'       => esc_html__( 'Dashboard', smw_slug ),
                'orders'          => esc_html__( 'Orders', smw_slug ),
                'downloads'       => esc_html__( 'Downloads', smw_slug ),
                'edit-address'    => esc_html__( 'Addresses', smw_slug ),
                'edit-account'    => esc_html__( 'Account details', smw_slug ),
                'customer-logout' => esc_html__( 'Logout', smw_slug ),
            ];
        }
        
        new \Stiles_MyAccount( $items, $item_url, $userinfo );

        echo '<div class="stiles_my_account_page stiles_my_account_menu_pos_' . $menutype . '">';
        
            if( $menutype === 'vtop' || $menutype === 'hleft' )
            { 
                do_action( 'woocommerce_account_navigation' );
            }
            
            echo '<div class="woocommerce-MyAccount-content">';
                    do_action( 'woocommerce_account_content' );
            echo '</div>';
            
            if( $menutype === 'vbottom' || $menutype === 'hright' )
            { 
                do_action( 'woocommerce_account_navigation' ); 
            }
            
        echo '</div>';
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_my_account_account() );