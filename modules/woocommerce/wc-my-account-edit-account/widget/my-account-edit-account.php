<?php

/**
 * Stiles Media Widgets My Account: Edit Account.
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

class stiles_wc_my_account_edit_account extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-my-account-edit-account';
    }
    
    public function get_title() 
    {
        return __( 'My Account: Edit Account', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-edit';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function account_label()
    {
        // Label
        $this->start_controls_section(
            'myaccount_label_style',
            array(
                'label' => __( 'Label', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'myaccount_label_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .woocommerce-EditAccountForm label',
                )
            );
            $this->add_control(
                'myaccount_label_color',
                [
                    'label' => __( 'Label Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-EditAccountForm label' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'myaccount_label_required_color',
                [
                    'label' => __( 'Required Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-EditAccountForm label .required' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_responsive_control(
                'myaccount_label_align',
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
                        '{{WRAPPER}} .woocommerce-EditAccountForm label' => 'text-align: {{VALUE}}',
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
                'label' => __( 'Input Box', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'form_input_box_text_color',
                [
                    'label' => __( 'Text Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-EditAccountForm input' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'form_input_box_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .woocommerce-EditAccountForm input',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'form_input_box_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .woocommerce-EditAccountForm input',
                ]
            );

            $this->add_responsive_control(
                'form_input_box_border_radius',
                [
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-EditAccountForm input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                'form_input_box_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-EditAccountForm input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );
            
            $this->add_responsive_control(
                'form_input_box_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-EditAccountForm input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function button_style()
    {
        // Button
        $this->start_controls_section(
            'form_button_style',
            array(
                'label' => __( 'Button', smw_slug ),
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
                            'selector'  => '{{WRAPPER}} .woocommerce-EditAccountForm .woocommerce-Button',
                        )
                    );

                    $this->add_control(
                        'form_button_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-EditAccountForm .woocommerce-Button' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'form_button_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-EditAccountForm .woocommerce-Button' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'form_button_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-EditAccountForm .woocommerce-Button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'form_button_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .woocommerce-EditAccountForm .woocommerce-Button',
                        ]
                    );

                    $this->add_responsive_control(
                        'form_button_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%'],
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-EditAccountForm .woocommerce-Button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                                '{{WRAPPER}} .woocommerce-EditAccountForm .woocommerce-Button:hover' => 'color: {{VALUE}}; transition:0.4s;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'form_button_hover_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woocommerce-EditAccountForm .woocommerce-Button:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'form_button_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .woocommerce-EditAccountForm .woocommerce-Button:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function register_controls() 
    {
        $this->account_label();

        $this->input_box();

        $this->button_style();
    }
    
    protected function render() 
    {
        if ( Plugin::instance()->editor->is_edit_mode() ) 
        {
            do_action('woocommerce_account_edit-account_endpoint');
        }else
        {
            if ( ! is_user_logged_in() ) 
            { 
                return __('You need to be logged in to view this page', smw_slug); 
            }
            
            do_action('woocommerce_account_edit-account_endpoint');
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_my_account_edit_account() );