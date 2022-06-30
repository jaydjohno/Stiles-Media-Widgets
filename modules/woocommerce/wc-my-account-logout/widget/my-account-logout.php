<?php

/**
 * Stiles Media Widgets My Account: Logout.
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

class stiles_wc_my_account_logout extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-my-account-logout';
    }
    
    public function get_title() 
    {
        return __( 'My Account: Logout', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-sign-out';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        // Style
        $this->start_controls_section(
            'logout_content_style',
            array(
                'label' => __( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->start_controls_tabs('logout_style_tabs');

                $this->start_controls_tab(
                    'logout_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );

                    $this->add_control(
                        'logout_content_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles-customer-logout a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'logout_content_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles-customer-logout a' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'logout_content_typography',
                            'label'     => __( 'Typography', smw_slug ),
                            'selector'  => '{{WRAPPER}} .stiles-customer-logout a',
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'logout_content_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .stiles-customer-logout a',
                        ]
                    );

                    $this->add_responsive_control(
                        'logout_content_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%'],
                            'selectors' => [
                                '{{WRAPPER}} .stiles-customer-logout a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'logout_content_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%'],
                            'selectors' => [
                                '{{WRAPPER}} .stiles-customer-logout a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; display:inline-block;',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'alignment',
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
                            'prefix_class' => 'elementor%s-align-',
                            'default'      => 'left',
                            'selectors' => [
                                '{{WRAPPER}} .stiles-customer-logout' => 'text-align: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Logout Hover
                $this->start_controls_tab(
                    'logout_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    $this->add_control(
                        'logout_content_text_hover_color',
                        [
                            'label' => __( 'Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles-customer-logout a:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'logout_content_hover_bg_color',
                        [
                            'label' => __( 'Background Colour', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles-customer-logout a:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'logout_content_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .stiles-customer-logout a:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function render() 
    {
        if ( Plugin::instance()->editor->is_edit_mode() ) 
        {
            foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
                if( $endpoint == 'customer-logout' ):
                    ?>
                        <div class="woolentor-customer-logout">
                            <a href="<?php echo esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>"><?php echo esc_html( $label ); ?></a>
                        </div>
                    <?php
                endif;
            endforeach;
        }else
        {
            if ( ! is_user_logged_in() ) 
            { 
                return __('You need to be logged in to view this page', smw_slug); 
            }
            
            foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
                if( $endpoint == 'customer-logout' ):
                    ?>
                        <div class="woolentor-customer-logout">
                            <a href="<?php echo esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>"><?php echo esc_html( $label ); ?></a>
                        </div>
                    <?php
                endif;
            endforeach;
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_my_account_logout() );