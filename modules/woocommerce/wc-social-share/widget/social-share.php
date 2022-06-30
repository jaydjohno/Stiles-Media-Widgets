<?php

/**
 * Stiles Media Widgets Social Share.
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

class stiles_wc_social_share extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'social-share-style', plugin_dir_url( __FILE__ ) . '../css/social-share.css');
    }
    
    public function get_name() 
    {
        return 'stiles-social-share';
    }
    
    public function get_title() 
    {
        return __( 'Product: Social Share', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-social-icons';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 
            'social-share-style',
            'font-awesome',
        ];
    }
    
    protected function register_controls() 
    {
        $this->product_social_share();
        
        $this->social_share_style();
        
        $this->social_icons();
    }
    
    protected function product_social_share()
    {
        $this->start_controls_section(
            'product_social_share',
            array(
                'label' => __( 'Social Share', smw_slug ),
                'tab' => Controls_Manager::TAB_CONTENT,
            )
        );
            $this->add_control(
                'product_social_title',
                [
                    'label' => __( 'Title', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( 'Social Share', smw_slug ),
                ]
            );

        $this->end_controls_section();
    }
    
    protected function social_share_style()
    {
        // Social Share Style
        $this->start_controls_section(
            'product_social_area_style',
            array(
                'label' => __( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_responsive_control(
                'product_social_area_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_product_social_share' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_social_area_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_product_social_share' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_social_area_title',
                [
                    'label' => __( 'Title', 'plugin-name' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_social_area_title_color',
                [
                    'label' => __( 'Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_product_social_share h2' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'product_social_area_title_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .stiles_product_social_share h2',
                )
            );

            $this->add_responsive_control(
                'product_social_area_title_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_product_social_share h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function social_icons()
    {
        // Social Share icon
        $this->start_controls_section(
            'product_social_icon_style',
            array(
                'label' => __( 'Share Icons', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->start_controls_tabs('product_social_icon_style_tabs');

                $this->start_controls_tab(
                    'product_social_icon_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );

                    $this->add_control(
                        'product_social_icon_color',
                        [
                            'label' => __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_product_social_share ul li a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_social_icon_bg_color',
                        [
                            'label' => __( 'Background Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_product_social_share ul li a' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_social_icon_size',
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
                                'size' => 14,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles_product_social_share ul li a' => 'font-size: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'product_social_icon_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .stiles_product_social_share ul li a',
                        ]
                    );
                    
                    $this->add_responsive_control(
                        'product_social_icon_border_radius',
                        [
                            'label' => __( 'Border Radius', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles_product_social_share ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator'=>'after',
                        ]
                    );

                    $this->add_responsive_control(
                        'product_social_icon_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles_product_social_share ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_social_icon_width',
                        [
                            'label' => __( 'Width', smw_slug ),
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
                                'unit' => 'px',
                                'size' => 30,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles_product_social_share ul li a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_social_icon_margin',
                        [
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles_product_social_share ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Hover Tab
                $this->start_controls_tab(
                    'product_social_icon_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'product_social_icon_hover_color',
                        [
                            'label' => __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_product_social_share ul li a:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_social_icon_hover_bg_color',
                        [
                            'label' => __( 'Background Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_product_social_share ul li a:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'product_social_icon_hover_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .stiles_product_social_share ul li a:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function render() {

        $settings = $this->get_settings_for_display();

        if( Plugin::instance()->editor->is_edit_mode() )
        {
            $product = wc_get_product( smw_get_last_product_id() );
        } else
        {
            global $product;
            $product = wc_get_product();
        }

        if ( empty( $product ) ) 
        {
            return; 
        }

        $product_title  = get_the_title();
        $product_url    = get_permalink();
        $product_img    = wp_get_attachment_url( get_post_thumbnail_id() );

        $facebook_url   = 'https://www.facebook.com/sharer/sharer.php?u=' . $product_url;
        $twitter_url    = 'http://twitter.com/intent/tweet?status=' . rawurlencode( $product_title ) . '+' . $product_url;
        $pinterest_url  = 'http://pinterest.com/pin/create/bookmarklet/?media=' . $product_img . '&url=' . $product_url . '&is_video=false&description=' . rawurlencode( $product_title );
        $gplus_url      = 'https://plus.google.com/share?url='. $product_url;
        $reddit_url     = 'https://reddit.com/submit?url={'.  $product_url .'}&title={'. $product_title .'}';

        ?>
            <div class="stiles_product_social_share">
                <?php
                    if( !empty( $settings['product_social_title'] ) )
                    {
                        echo '<h2>'.esc_html( $settings['product_social_title'] ).'</h2>';
                    }
                ?>
                <ul>
                    <li><a href="<?php echo esc_url($facebook_url); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="<?php echo esc_url($gplus_url); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="<?php echo esc_url($pinterest_url); ?>" target="_blank"><i class="fa fa-pinterest-p"></i></a></li>
                    <li><a href="<?php echo esc_url($twitter_url); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="<?php echo esc_url($reddit_url); ?>" target="_blank"><i class="fa fa-reddit"></i></a></li>
                </ul>
            </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_social_share() );