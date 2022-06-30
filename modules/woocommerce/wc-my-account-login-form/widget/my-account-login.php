<?php

/**
 * Stiles Media Widgets My Account: Login.
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
use Elementor\Widget_Base;

class stiles_wc_my_account_login extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-my-account-login';
    }
    
    public function get_title() 
    {
        return __( 'My Account: Login', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-form-horizontal';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        $this->heading_style();

        $this->form_label();
        
        $this->input_box();
        
        $this->button_control();

        $this->lost_password();

        $this->form_ara();
    }
    
    protected function heading_style()
    {
        // Heading
        $this->start_controls_section(
            'form_heading_style',
            array(
                'label' => __( 'Heading', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'form_heading_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .stiles-my-account-form-login h2',
                )
            );

            $this->add_control(
                'form_heading_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login h2' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'form_heading_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'form_heading_align',
                [
                    'label'        => __( 'Alignment', smw_slug ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'default'   => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login h2' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function form_label()
    {
        // Form label
        $this->start_controls_section(
            'form_label_style',
            array(
                'label' => __( 'Label', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'form_label_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login .form-row label',
                )
            );

            $this->add_control(
                'form_label_color',
                [
                    'label' => __( 'Label Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login .form-row label' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'form_label_required_color',
                [
                    'label' => __( 'Required Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login .form-row label span.required' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'form_label_padding',
                [
                    'label' => esc_html__( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login .form-row label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'form_label_align',
                [
                    'label'        => __( 'Alignment', smw_slug ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login .form-row label' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function input_box()
    {
        // Input box
        $this->start_controls_section(
            'form_input_box_style',
            array(
                'label' => esc_html__( 'Input Box', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'form_input_box_text_color',
                [
                    'label' => __( 'Text Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login input.input-text' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'form_input_box_typography',
                    'label'     => esc_html__( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login input.input-text',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'form_input_box_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login input.input-text',
                ]
            );

            $this->add_responsive_control(
                'form_input_box_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login input.input-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                'form_input_box_padding',
                [
                    'label' => esc_html__( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login input.input-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );
            
            $this->add_responsive_control(
                'form_input_box_margin',
                [
                    'label' => esc_html__( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login input.input-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function button_control()
    {
        // Button
        $this->start_controls_section(
            'form_button_style',
            array(
                'label' => esc_html__( 'Button', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->start_controls_tabs('form_button_style_tabs');
                
                $this->start_controls_tab(
                    'form_button_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'form_button_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} .stiles-my-account-form-login button',
                        )
                    );

                    $this->add_control(
                        'form_button_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles-my-account-form-login button' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'form_button_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles-my-account-form-login button' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'form_button_padding',
                        [
                            'label' => esc_html__( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles-my-account-form-login button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'form_button_margin',
                        [
                            'label' => esc_html__( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%'],
                            'selectors' => [
                                '{{WRAPPER}} .stiles-my-account-form-login button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'form_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .stiles-my-account-form-login button',
                        ]
                    );

                    $this->add_responsive_control(
                        'form_button_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%'],
                            'selectors' => [
                                '{{WRAPPER}} .stiles-my-account-form-login button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();
                
                // Hover
                $this->start_controls_tab(
                    'form_button_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'form_button_hover_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles-my-account-form-login button:hover' => 'color: {{VALUE}}; transition:0.4s;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'form_button_hover_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles-my-account-form-login button:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'form_button_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .stiles-my-account-form-login button:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function lost_password()
    {
        // Lost Password
        $this->start_controls_section(
            'form_lostpass_style',
            array(
                'label' => esc_html__( 'Lost Password', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->start_controls_tabs('form_lostpass_style_tabs');
                
                $this->start_controls_tab(
                    'form_lostpass_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'form_lostpass_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} .stiles-my-account-form-login .lost_password a',
                        )
                    );

                    $this->add_control(
                        'form_lostpass_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles-my-account-form-login .lost_password a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'form_lostpass_margin',
                        [
                            'label' => esc_html__( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%'],
                            'selectors' => [
                                '{{WRAPPER}} .stiles-my-account-form-login .lost_password a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();
                
                // Lost Password Hover
                $this->start_controls_tab(
                    'form_lostpass_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'form_lostpass_hover_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles-my-account-form-login .lost_password a:hover' => 'color: {{VALUE}}; transition:0.4s;',
                            ],
                        ]
                    );
                
                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function form_ara()
    {
        // Form area
        $this->start_controls_section(
            'form_area_style',
            array(
                'label' => esc_html__( 'Form Area', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'form_area_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login',
                ]
            );

            $this->add_responsive_control(
                'form_area_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'form_area_margin',
                [
                    'label' => esc_html__( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator'=>'before',
                ]
            );

            $this->add_responsive_control(
                'form_area_padding',
                [
                    'label' => esc_html__( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-my-account-form-login form.woocommerce-form-login' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],                ]
            );

        $this->end_controls_section();
    }
    
    protected function render() 
    {
        if ( Plugin::instance()->editor->is_edit_mode() ) 
        {
            ?>
            <div class="stiles-my-account-form-login">

                <h2><?php esc_html_e( 'Login', smw_slug ); ?></h2>
            
                <form class="woocommerce-form woocommerce-form-login login" method="post">
            
                    <?php do_action( 'woocommerce_login_form_start' ); ?>
            
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="username"><?php esc_html_e( 'Username or email address', smw_slug ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="password"><?php esc_html_e( 'Password', smw_slug ); ?>&nbsp;<span class="required">*</span></label>
                        <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
                    </p>
            
                    <?php do_action( 'woocommerce_login_form' ); ?>
            
                    <p class="form-row">
                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Log in', smw_slug ); ?>"><?php esc_html_e( 'Log in', smw_slug ); ?></button>
                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', smw_slug ); ?></span>
                        </label>
                    </p>

                    <p class="woocommerce-LostPassword lost_password">
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', smw_slug ); ?></a>
                    </p>
            
                    <?php do_action( 'woocommerce_login_form_end' ); ?>
            
                </form>
            </div>
            <?php
        }else{

            if( ! is_account_page() )
            { 
                do_action( 'woocommerce_before_customer_login_form' ); 
            }

            ?>
            <div class="stiles-my-account-form-login">

                <h2><?php esc_html_e( 'Login', smw_slug ); ?></h2>
            
                <form class="woocommerce-form woocommerce-form-login login" method="post">
            
                    <?php do_action( 'woocommerce_login_form_start' ); ?>
            
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="username"><?php esc_html_e( 'Username or email address', smw_slug ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="password"><?php esc_html_e( 'Password', smw_slug ); ?>&nbsp;<span class="required">*</span></label>
                        <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
                    </p>
            
                    <?php do_action( 'woocommerce_login_form' ); ?>
            
                    <p class="form-row">
                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Log in', smw_slug ); ?>"><?php esc_html_e( 'Log in', smw_slug ); ?></button>
                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', smw_slug ); ?></span>
                        </label>
                    </p>

                    <p class="woocommerce-LostPassword lost_password">
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', smw_slug ); ?></a>
                    </p>
            
                    <?php do_action( 'woocommerce_login_form_end' ); ?>
            
                </form>
            </div>
            <?php
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_my_account_login() );