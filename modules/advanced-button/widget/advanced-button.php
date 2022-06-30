<?php

/**
 * SMW Advanced Button.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_advanced_button extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'advanced-button-css', plugin_dir_url( __FILE__ ) .  '../css/advanced-button.css');
    }
    
    public function get_name()
    {
        return 'stiles-advanced-button';
    }
    
    public function get_title()
    {
        return 'Advanced Button';
    }
    
    public function get_icon()
    {
        return 'eicon-button';
    }
    
    public function get_categories()
    {
        return [ 'stiles-media-category' ];
    }
    
    public function check_rtl() 
    {
        return is_rtl();
    }
    
    public function getTemplateInstance() 
    {
		return $this->templateInstance = SMW_Helper::get_instance();
	}
    
    public function get_style_depends() 
    {
        return [ 'advanced-button-css' ];
    }
    
    public function get_script_depends() 
    {
        return [ 'lottie-js' ];
    }
    
    protected function register_controls() 
    {
        $this->start_controls_section('advanced_button_general_section',
        [
            'label'         => __('Button', smw_slug),
            ]
        );
        
            $this->add_control('advanced_button_text',
                [
                    'label'         => __('Text', smw_slug),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => __('Click Me',smw_slug),
                    'label_block'   => true,
                ]
            );
        
                $this->add_control('advanced_button_link_selection', 
                [
                    'label'         => __('Link Type', smw_slug),
                    'type'          => Controls_Manager::SELECT,
                    'options'       => [
                        'url'   => __('URL', smw_slug),
                        'link'  => __('Existing Page', smw_slug),
                    ],
                    'default'       => 'url',
                    'label_block'   => true,
                ]
            );
            
            $this->add_control('advanced_button_link',
                [
                    'label'         => __('Link', smw_slug),
                    'type'          => Controls_Manager::URL,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => [
                        'url'   => '#',
                    ],
                    'placeholder'   => 'https://stiles.media/',
                    'label_block'   => true,
                    'separator'     => 'after',
                    'condition'     => [
                        'advanced_button_link_selection' => 'url'
                    ]
                ]
            );
        
            $this->add_control('advanced_button_existing_link',
                [
                    'label'         => __('Existing Page', smw_slug),
                    'type'          => Controls_Manager::SELECT2,
                    'options'       => $this->getTemplateInstance()->get_all_posts(),
                    'condition'     => [
                        'advanced_button_link_selection'     => 'link',
                    ],
                    'multiple'      => false,
                    'separator'     => 'after',
                    'label_block'   => true,
                ]
            );
            
            $this->add_control('advanced_button_hover_effect', 
                [
                    'label'         => __('Hover Effect', smw_slug),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'none',
                    'options'       => [
                        'none'          => __('None', smw_slug),
                        'style1'        => __('Slide', smw_slug),
                        'style2'        => __('Shutter', smw_slug),
                        'style3'        => __('Icon Fade', smw_slug),
                        'style4'        => __('Icon Slide', smw_slug),
                        'style5'        => __('In & Out', smw_slug),
                    ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('advanced_button_style1_dir', 
            [
                'label'         => __('Slide Direction', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'bottom',
                'options'       => [
                    'bottom'       => __('Top to Bottom', smw_slug),
                    'top'          => __('Bottom to Top', smw_slug),
                    'left'         => __('Right to Left', smw_slug),
                    'right'        => __('Left to Right', smw_slug),
                ],
                'condition'     => [
                    'advanced_button_hover_effect' => 'style1',
                ],
                'label_block'   => true,
                ]
            );
        
        $this->add_control('advanced_button_style2_dir', 
            [
                'label'         => __('Shutter Direction', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'shutouthor',
                'options'       => [
                    'shutinhor'     => __('Shutter in Horizontal', smw_slug),
                    'shutinver'     => __('Shutter in Vertical', smw_slug),
                    'shutoutver'    => __('Shutter out Horizontal', smw_slug),
                    'shutouthor'    => __('Shutter out Vertical', smw_slug),
                    'scshutoutver'  => __('Scaled Shutter Vertical', smw_slug),
                    'scshutouthor'  => __('Scaled Shutter Horizontal', smw_slug),
                    'dshutinver'   => __('Tilted Left'),
                    'dshutinhor'   => __('Tilted Right'),
                ],
                'condition'     => [
                    'advanced_button_hover_effect' => 'style2',
                ],
                'label_block'   => true,
            ]
        );
        
        $this->add_control('advanced_button_style4_dir', 
            [
                'label'         => __('Slide Direction', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'bottom',
                'options'       => [
                    'top'          => __('Bottom to Top',smw_slug),
                    'bottom'       => __('Top to Bottom',smw_slug),
                    'left'         => __('Left to Right',smw_slug),
                    'right'        => __('Right to Left',smw_slug),
                ],
                'label_block'   => true,
                'condition'     => [
                    'advanced_button_hover_effect' => 'style4',
                ],
            ]
        );
        
        $this->add_control('advanced_button_style5_dir', 
                [
                    'label'         => __('Style', smw_slug),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'radialin',
                    'options'       => [
                        'radialin'          => __('Radial In', smw_slug),
                        'radialout'         => __('Radial Out', smw_slug),
                        'rectin'            => __('Rectangle In', smw_slug),
                        'rectout'           => __('Rectangle Out', smw_slug),
                        ],
                    'condition'     => [
                        'advanced_button_hover_effect' => 'style5',
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('advanced_button_icon_switcher',
            [
                'label'         => __('Icon', smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Enable or disable button icon',smw_slug),
                'condition'     => [
                    'advanced_button_hover_effect!'  => 'style4'
                ],
            ]
        );

        $this->add_control('icon_type', 
            [
                'label'         => __('Icon Type', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'icon'          => __('Font Awesome', smw_slug),
                    'animation'     => __('Lottie Animation', smw_slug),
                ],
                'default'       => 'icon',
                'label_block'   => true,
                'condition'     => [
                    'advanced_button_hover_effect!'  => 'style4',
                    'advanced_button_icon_switcher' => 'yes',
                ],
            ]
        );

        $this->add_control('advanced_button_icon_selection_updated',
            [
                'label'             => __('Icon', smw_slug),
                'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'advanced_button_icon_selection',
                'default' => [
                    'value'     => 'fas fa-bars',
                    'library'   => 'fa-solid',
                ],
                'condition'         => [
                    'advanced_button_icon_switcher'  => 'yes',
                    'advanced_button_hover_effect!'  => 'style4',
                    'icon_type'                     => 'icon'
                ],
                'label_block'   => true,
            ]
        );

        $this->add_control('lottie_url', 
            [
                'label'             => __( 'Animation JSON URL', smw_slug ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'description'       => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
                'label_block'       => true,
                'condition'         => [
                    'advanced_button_icon_switcher'  => 'yes',
                    'advanced_button_hover_effect!'  => 'style4',
                    'icon_type'                     => 'animation'
                ],
            ]
        );

        $this->add_control('lottie_loop',
            [
                'label'         => __('Loop',smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
                'condition'         => [
                    'advanced_button_icon_switcher'  => 'yes',
                    'advanced_button_hover_effect!'  => 'style4',
                    'icon_type'                     => 'animation'
                ],
            ]
        );

        $this->add_control('lottie_reverse',
            [
                'label'         => __('Reverse',smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'     => [
                    'advanced_button_icon_switcher'  => 'yes',
                    'advanced_button_hover_effect!'  => 'style4',
                    'icon_type'                     => 'animation'
                ],
            ]
        );

        $this->add_control('slide_icon_type', 
            [
                'label'         => __('Icon Type', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'icon'          => __('Font Awesome', smw_slug),
                    'animation'     => __('Lottie Animation', smw_slug),
                ],
                'default'       => 'icon',
                'label_block'   => true,
                'condition'     => [
                    'advanced_button_hover_effect'  => 'style4'
                ],
            ]
        );

        $this->add_control('advanced_button_style4_icon_selection_updated',
            [
                'label'         => __('Icon', smw_slug),
                'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'advanced_button_style4_icon_selection',
                'default' => [
                    'value'     => 'fas fa-bars',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'slide_icon_type'   => 'icon',
                    'advanced_button_hover_effect'  => 'style4'
                ],
                'label_block'   => true,
            ]
        );

        $this->add_control('slide_lottie_url', 
            [
                'label'             => __( 'Animation JSON URL', smw_slug ),
                'type'              => Controls_Manager::TEXT,
                'dynamic'           => [ 'active' => true ],
                'description'       => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
                'label_block'       => true,
                'condition'     => [
                    'slide_icon_type'   => 'animation',
                    'advanced_button_hover_effect'  => 'style4'
                ],
            ]
        );

        $this->add_control('slide_lottie_loop',
            [
                'label'         => __('Loop',smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'default'       => 'true',
                'condition'     => [
                    'slide_icon_type'   => 'animation',
                    'advanced_button_hover_effect'  => 'style4'
                ]
            ]
        );

        $this->add_control('slide_lottie_reverse',
            [
                'label'         => __('Reverse',smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'     => [
                    'slide_icon_type'   => 'animation',
                    'advanced_button_hover_effect'  => 'style4'
                ]
            ]
        );
        
        $this->add_control('advanced_button_icon_position', 
            [
                'label'         => __('Icon Position', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'before',
                'options'       => [
                    'before'        => __('Before', smw_slug),
                    'after'         => __('After', smw_slug),
                ],
                'label_block'   => true,
                'condition'     => [
                    'advanced_button_icon_switcher' => 'yes',
                    'advanced_button_hover_effect!' => 'style4',
                ],
            ]
        );
        
        $this->add_responsive_control('advanced_button_icon_before_size',
            [
                'label'         => __('Icon Size', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'condition'     => [
                    'advanced_button_icon_switcher' => 'yes',
                    'advanced_button_hover_effect!'  => 'style4'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-button-text-icon-wrapper i' => 'font-size: {{SIZE}}px',
                    '{{WRAPPER}} .advanced-button-text-icon-wrapper svg' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                ]
            ]
        );
        
        $this->add_responsive_control('advanced_button_icon_style4_size',
            [
                'label'         => __('Icon Size', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'condition'     => [
                    'advanced_button_hover_effect'  => 'style4'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-button-style4-icon-wrapper i' => 'font-size: {{SIZE}}px',
                    '{{WRAPPER}} .advanced-button-style4-icon-wrapper svg' => 'width: {{SIZE}}px; height: {{SIZE}}px'
                ]
            ]
        );
        
        if( ! $this->check_rtl() ) {
            $this->add_responsive_control('advanced_button_icon_before_spacing',
                [
                    'label'         => __('Icon Spacing', smw_slug),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'advanced_button_icon_switcher' => 'yes',
                        'advanced_button_icon_position' => 'before',
                        'advanced_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-button-text-icon-wrapper i, {{WRAPPER}} .advanced-button-text-icon-wrapper svg' => 'margin-right: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        
        $this->add_responsive_control('advanced_button_icon_after_spacing',
                [
                    'label'         => __('Icon Spacing', smw_slug),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'advanced_button_icon_switcher' => 'yes',
                        'advanced_button_icon_position' => 'after',
                        'advanced_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-button-text-icon-wrapper i, {{WRAPPER}} .advanced-button-text-icon-wrapper svg' => 'margin-left: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        }
        
        if( $this->check_rtl() ) {
            $this->add_responsive_control('advanced_button_icon_rtl_before_spacing',
                [
                    'label'         => __('Icon Spacing', smw_slug),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'advanced_button_icon_switcher' => 'yes',
                        'advanced_button_icon_position' => 'before',
                        'advanced_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-button-text-icon-wrapper i, {{WRAPPER}} .advanced-button-text-icon-wrapper svg' => 'margin-left: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        
        $this->add_responsive_control('advanced_button_icon_rtl_after_spacing',
                [
                    'label'         => __('Icon Spacing', smw_slug),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'advanced_button_icon_switcher' => 'yes',
                        'advanced_button_icon_position' => 'after',
                        'advanced_button_hover_effect!'  => ['style3', 'style4']
                    ],
                    'default'       => [
                        'size'  => 15
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-button-text-icon-wrapper i, {{WRAPPER}} .advanced-button-text-icon-wrapper svg' => 'margin-right: {{SIZE}}px',
                    ],
                    'separator'     => 'after',
                ]
            );
        }
        
        $this->add_responsive_control('advanced_button_icon_style3_before_transition',
                [
                    'label'         => __('Icon Spacing', smw_slug),
                    'type'          => Controls_Manager::SLIDER,
                    'condition'     => [
                        'advanced_button_icon_switcher' => 'yes',
                        'advanced_button_icon_position' => 'before',
                        'advanced_button_hover_effect'  => 'style3'
                    ],
                    'range'         => [
                        'px'    => [
                            'min'   => -50,
                            'max'   => 50,
                        ]
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-button-style3-before:hover i, {{WRAPPER}} .advanced-button-style3-before:hover svg' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}})',
                    ],
                ]
                );
        
        $this->add_responsive_control('advanced_button_icon_style3_after_transition',
            [
                'label'         => __('Icon Spacing', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'condition'     => [
                    'advanced_button_icon_switcher' => 'yes',
                    'advanced_button_icon_position!'=> 'before',
                    'advanced_button_hover_effect'  => 'style3'
                ],
                'range'         => [
                    'px'    => [
                        'min'   => -50,
                        'max'   => 50,
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-button-style3-after:hover i, {{WRAPPER}} .advanced-button-style3-after:hover svg' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}})',
                ],
            ]
        );

        $this->add_control('advanced_button_size', 
                [
                    'label'         => __('Size', smw_slug),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'lg',
                    'options'       => [
                            'sm'          => __('Small', smw_slug),
                            'md'            => __('Medium', smw_slug),
                            'lg'            => __('Large', smw_slug),
                            'block'         => __('Block', smw_slug),
                        ],
                    'label_block'   => true,
                    'separator'     => 'before',
                    ]
                );
        
        $this->add_responsive_control('advanced_button_align',
			[
				'label'             => __( 'Alignment', smw_slug ),
				'type'              => Controls_Manager::CHOOSE,
				'options'           => [
					'left'    => [
						'title' => __( 'Left', smw_slug ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', smw_slug ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', smw_slug ),
						'icon'  => 'fa fa-align-right',
					],
				],
                'selectors'         => [
                    '{{WRAPPER}} .advanced-button-container' => 'text-align: {{VALUE}}',
                ],
				'default' => 'center',
			]
		);
        
        $this->add_control('advanced_button_event_switcher', 
                [
                    'label'         => __('onclick Event', smw_slug),
                    'type'          => Controls_Manager::SWITCHER,
                    'separator'     => 'before',
                    ]
                );

        $this->add_control('advanced_button_event_function', 
                [
                    'label'         => __('Example: myFunction();', smw_slug),
                    'type'          => Controls_Manager::TEXTAREA,
                    'dynamic'       => [ 'active' => true ],
                    'condition'     => [
                        'advanced_button_event_switcher' => 'yes',
                        ],
                    ]
                );
            
            
            
        $this->end_controls_section();
        
        $this->start_controls_section('advanced_button_style_section',
            [
                'label'             => __('Button', smw_slug),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'advanced_button_typo',
                'scheme'            => Typography::TYPOGRAPHY_1,
                'selector'          => '{{WRAPPER}} .advanced-button',
            ]
        );
        
        $this->start_controls_tabs('advanced_button_style_tabs');
        
        $this->start_controls_tab('advanced_button_style_normal',
            [
                'label'             => __('Normal', smw_slug),
            ]
        );
        
        $this->add_control('advanced_button_text_color_normal',
            [
                'label'             => __('Text Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .advanced-button .advanced-button-text-icon-wrapper span'   => 'color: {{VALUE}};',
                ]
            ]);
        
        $this->add_control('advanced_button_icon_color_normal',
            [
                'label'             => __('Icon Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .advanced-button-text-icon-wrapper i'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'advanced_button_icon_switcher'  => 'yes',
                    'icon_type'                     => 'icon',
                    'advanced_button_hover_effect!'  => ['style3','style4']
                ]
            ]
        );
        
        $this->add_control('advanced_button_background_normal',
                [
                    'label'             => __('Background Colour', smw_slug),
                    'type'              => Controls_Manager::COLOR,
                    'scheme'            => [
                        'type'  => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'selectors'      => [
                        '{{WRAPPER}} .advanced-button, {{WRAPPER}} .advanced-button.advanced-button-style2-shutinhor:before , {{WRAPPER}} .advanced-button.advanced-button-style2-shutinver:before , {{WRAPPER}} .advanced-button-style5-radialin:before , {{WRAPPER}} .advanced-button-style5-rectin:before'  => 'background-color: {{VALUE}};',
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'advanced_button_border_normal',
                    'selector'      => '{{WRAPPER}} .advanced-button',
                ]
                );
        
        $this->add_control('advanced_button_border_radius_normal',
                [
                    'label'         => __('Border Radius', smw_slug),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .advanced-button' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Icon Shadow',smw_slug),
                'name'          => 'advanced_button_icon_shadow_normal',
                'selector'      => '{{WRAPPER}} .advanced-button-text-icon-wrapper i',
                'condition'         => [
                    'advanced_button_icon_switcher'  => 'yes',
                    'icon_type'                     => 'icon',
                    'advanced_button_hover_effect!'  => ['style3', 'style4']
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Text Shadow',smw_slug),
                'name'          => 'advanced_button_text_shadow_normal',
                'selector'      => '{{WRAPPER}} .advanced-button-text-icon-wrapper span',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'         => __('Button Shadow',smw_slug),
                'name'          => 'advanced_button_box_shadow_normal',
                'selector'      => '{{WRAPPER}} .advanced-button',
            ]
        );
        
        $this->add_responsive_control('advanced_button_margin_normal',
            [
                'label'         => __('Margin', smw_slug),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('advanced_button_padding_normal',
            [
                'label'         => __('Padding', smw_slug),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('advanced_button_style_hover',
            [
                'label'             => __('Hover', smw_slug),
            ]
        );
        
        $this->add_control('advanced_button_text_color_hover',
            [
                'label'             => __('Text Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .advanced-button:hover .advanced-button-text-icon-wrapper span'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'advanced_button_hover_effect!'   => 'style4'
                ]
            ]
        );
        
        $this->add_control('advanced_button_icon_color_hover',
            [
                'label'             => __('Icon Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .advanced-button:hover .advanced-button-text-icon-wrapper i'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'advanced_button_icon_switcher'  => 'yes',
                    'icon_type'                     => 'icon',
                    'advanced_button_hover_effect!'  => 'style4',
                ]
            ]
        );
        
        $this->add_control('advanced_button_style4_icon_color',
            [
                'label'             => __('Icon Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .advanced-button:hover .advanced-button-style4-icon-wrapper'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'advanced_button_hover_effect'  => 'style4',
                    'slide_icon_type'              => 'icon'
                ]
            ]
        );
        
        $this->add_control('advanced_button_background_hover',
            [
                'label'             => __('Background Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_3
                ],
                'selectors'          => [
                    '{{WRAPPER}} .advanced-button-none:hover ,{{WRAPPER}} .advanced-button-style1-bottom:before, {{WRAPPER}} .advanced-button-style1-top:before, {{WRAPPER}} .advanced-button-style1-right:before, {{WRAPPER}} .advanced-button-style1-left:before, {{WRAPPER}} .advanced-button-style2-shutouthor:before, {{WRAPPER}} .advanced-button-style2-shutoutver:before, {{WRAPPER}} .advanced-button-style2-shutinhor, {{WRAPPER}} .advanced-button-style2-shutinver , {{WRAPPER}} .advanced-button-style2-dshutinhor:before , {{WRAPPER}} .advanced-button-style2-dshutinver:before , {{WRAPPER}} .advanced-button-style2-scshutouthor:before , {{WRAPPER}} .advanced-button-style2-scshutoutver:before, {{WRAPPER}} .advanced-button-style3-after:hover , {{WRAPPER}} .advanced-button-style3-before:hover,{{WRAPPER}} .advanced-button-style4-icon-wrapper , {{WRAPPER}} .advanced-button-style5-radialin , {{WRAPPER}} .advanced-button-style5-radialout:before, {{WRAPPER}} .advanced-button-style5-rectin , {{WRAPPER}} .advanced-button-style5-rectout:before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'advanced_button_border_hover',
                'selector'      => '{{WRAPPER}} .advanced-button:hover',
            ]
        );
        
        $this->add_control('advanced_button_border_radius_hover',
            [
                'label'         => __('Border Radius', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-button:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Icon Shadow',smw_slug),
                'name'          => 'advanced_button_icon_shadow_hover',
                'selector'      => '{{WRAPPER}} .advanced-button:hover .advanced-button-text-icon-wrapper i',
                'condition'         => [
                    'advanced_button_icon_switcher'  => 'yes',
                    'icon_type'                     => 'icon',
                    'advanced_button_hover_effect!'   => 'style4',
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Icon Shadow',smw_slug),
                'name'          => 'advanced_button_style4_icon_shadow_hover',
                'selector'      => '{{WRAPPER}} .advanced-button:hover .advanced-button-style4-icon-wrapper',
                'condition'         => [
                    'advanced_button_hover_effect'   => 'style4',
                    'slide_icon_type'   => 'icon'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Text Shadow',smw_slug),
                'name'          => 'advanced_button_text_shadow_hover',
                'selector'      => '{{WRAPPER}} .advanced-button:hover .advanced-button-text-icon-wrapper span',
                'condition'         => [
                    'advanced_button_hover_effect!'   => 'style4'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label'         => __('Button Shadow',smw_slug),
                'name'          => 'advanced_button_box_shadow_hover',
                'selector'      => '{{WRAPPER}} .advanced-button:hover',
            ]
        );
        
        $this->add_responsive_control('advanced_button_margin_hover',
            [
                'label'         => __('Margin', smw_slug),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-button:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('advanced_button_padding_hover',
            [
                'label'         => __('Padding', smw_slug),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-button:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();
    }
   
    protected function render() 
    {
        
        $settings = $this->get_settings_for_display();
        
        $this->add_inline_editing_attributes( 'advanced_button_text');
        
        $button_text = $settings['advanced_button_text'];
        
        if( $settings['advanced_button_link_selection'] === 'url' ){
            $button_url = $settings['advanced_button_link']['url'];
        } else {
            $button_url = get_permalink( $settings['advanced_button_existing_link'] );
        }
        
        $button_size = 'advanced-button-' . $settings['advanced_button_size'];
        
        $button_event = $settings['advanced_button_event_function'];
        
        if ( ! empty ( $settings['advanced_button_icon_selection'] ) ) {
            $this->add_render_attribute( 'icon', 'class', $settings['advanced_button_icon_selection'] );
            $this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
        }
        
        $icon_type = $settings['icon_type'];

        if( 'icon' === $icon_type ) {
            $migrated = isset( $settings['__fa4_migrated']['advanced_button_icon_selection_updated'] );
            $is_new = empty( $settings['advanced_button_icon_selection'] ) && Icons_Manager::is_migration_allowed();
        } else {
            $this->add_render_attribute( 'lottie', [
                'class' => 'smw-lottie-animation',
                'data-lottie-url' => $settings['lottie_url'],
                'data-lottie-loop' => $settings['lottie_loop'],
                'data-lottie-reverse' => $settings['lottie_reverse'],
            ]);
        }
        
        
        if ( $settings['advanced_button_hover_effect'] == 'none' ) {
            $style_dir = 'advanced-button-none';
        } elseif( $settings['advanced_button_hover_effect'] == 'style1' ) {
            $style_dir = 'advanced-button-style1-' . $settings['advanced_button_style1_dir'];
        } elseif ( $settings['advanced_button_hover_effect'] == 'style2' ) {
            $style_dir = 'advanced-button-style2-' . $settings['advanced_button_style2_dir'];
        } elseif ( $settings['advanced_button_hover_effect'] == 'style3' ) {
            $style_dir = 'advanced-button-style3-' . $settings['advanced_button_icon_position'];
        } elseif ( $settings['advanced_button_hover_effect'] == 'style4' ) {
            $style_dir = 'advanced-button-style4-' . $settings['advanced_button_style4_dir'];
            
            $slide_icon_type = $settings['slide_icon_type'];

            if( 'icon' === $slide_icon_type ) {
                if ( ! empty ( $settings['advanced_button_style4_icon_selection'] ) ) {
                    $this->add_render_attribute( 'slide_icon', 'class', $settings['advanced_button_style4_icon_selection'] );
                    $this->add_render_attribute( 'slide_icon', 'aria-hidden', 'true' );
                }
                
                $slide_migrated = isset( $settings['__fa4_migrated']['advanced_button_style4_icon_selection_updated'] );
                $slide_is_new = empty( $settings['advanced_button_style4_icon_selection'] ) && Icons_Manager::is_migration_allowed();

            } else {

                $this->add_render_attribute( 'slide_lottie', [
                        'class' => 'smw-lottie-animation',
                        'data-lottie-url' => $settings['slide_lottie_url'],
                        'data-lottie-loop' => $settings['slide_lottie_loop'],
                        'data-lottie-reverse' => $settings['slide_lottie_reverse'],
                    ]
                );

            }
            
        } elseif ( $settings['advanced_button_hover_effect'] == 'style5' ) {
            $style_dir = 'advanced-button-style5-' . $settings['advanced_button_style5_dir'];
        }
        
        $this->add_render_attribute( 'button', 'class', array(
            'advanced-button',
            $button_size,
            $style_dir
        ));
        
        if( ! empty( $button_url ) ) {
        
            $this->add_render_attribute( 'button', 'href', $button_url );
            
            if( ! empty( $settings['advanced_button_link']['is_external'] ) )
                $this->add_render_attribute( 'button', 'target', '_blank' );
            
            if( ! empty( $settings['advanced_button_link']['nofollow'] ) )
                $this->add_render_attribute( 'button', 'rel', 'nofollow' );
        }
        
        if( 'yes' === $settings['advanced_button_event_switcher'] && ! empty( $button_event ) ) {
            $this->add_render_attribute( 'button', 'onclick', $button_event );
        }
        
    ?>

    <div class="advanced-button-container">
        <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
            <div class="advanced-button-text-icon-wrapper">
                <?php if ('yes' === $settings['advanced_button_icon_switcher'] ) : ?>
                    <?php if( $settings['advanced_button_icon_position'] === 'before' && $settings['advanced_button_hover_effect'] !== 'style4' ) : ?>
                        <?php if( 'icon' === $icon_type ) : ?>
                            <?php if ( $is_new || $migrated ) :
                                Icons_Manager::render_icon( $settings['advanced_button_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
                            else: ?>
                                <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                            <?php endif; ?>
                        <?php else: ?>
                            <div <?php echo $this->get_render_attribute_string( 'lottie' ); ?>></div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <span <?php echo $this->get_render_attribute_string( 'advanced_button_text' ); ?>><?php echo $button_text; ?></span>
                <?php if ('yes' === $settings['advanced_button_icon_switcher'] ) : ?>
                    <?php if( $settings['advanced_button_icon_position'] === 'after' && $settings['advanced_button_hover_effect'] !== 'style4' ) : ?>
                        <?php if( 'icon' === $icon_type ) : ?>
                            <?php if ( $is_new || $migrated ) :
                                Icons_Manager::render_icon( $settings['advanced_button_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
                            else: ?>
                                <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                            <?php endif; ?>
                        <?php else: ?>
                            <div <?php echo $this->get_render_attribute_string( 'lottie' ); ?>></div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if( $settings['advanced_button_hover_effect'] === 'style4' ) : ?>
                <div class="advanced-button-style4-icon-wrapper <?php echo esc_attr( $settings['advanced_button_style4_dir'] ); ?>">
                    <?php if( 'icon' === $slide_icon_type ) : ?>
                        <?php if ( $slide_is_new || $slide_migrated ) :
                            Icons_Manager::render_icon( $settings['advanced_button_style4_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
                        else: ?>
                            <i <?php echo $this->get_render_attribute_string( 'slide_icon' ); ?>></i>
                        <?php endif; ?>
                    <?php else: ?>
                        <div <?php echo $this->get_render_attribute_string( 'slide_lottie' ); ?>></div>
                    <?php endif;?>
                </div>
            <?php endif; ?>
        </a>
    </div>

    <?php
    }
    
    protected function _content_template() 
    {
        ?>
        <#
        
        view.addInlineEditingAttributes( 'advanced_button_text' );
        
        var buttonText = settings.advanced_button_text,
            buttonUrl,
            styleDir,
            slideIcon,
            buttonSize = 'advanced-button-' + settings.advanced_button_size,
            buttonEvent = settings.advanced_button_event_function,
            buttonIcon = settings.advanced_button_icon_selection;
        
        if( 'url' == settings.advanced_button_link_selection ) {
            buttonUrl = settings.advanced_button_link.url;
        } else {
            buttonUrl = settings.advanced_button_existing_link;
        }
        
        if ( 'none' == settings.advanced_button_hover_effect ) {
            styleDir = 'advanced-button-none';
        } else if( 'style1' == settings.advanced_button_hover_effect ) {
            styleDir = 'advanced-button-style1-' + settings.advanced_button_style1_dir;
        } else if ( 'style2' == settings.advanced_button_hover_effect ){
            styleDir = 'advanced-button-style2-' + settings.advanced_button_style2_dir;
        } else if ( 'style3' == settings.advanced_button_hover_effect ) {
            styleDir = 'advanced-button-style3-' + settings.advanced_button_icon_position;
        } else if ( 'style4' == settings.advanced_button_hover_effect ) {
            styleDir = 'advanced-button-style4-' + settings.advanced_button_style4_dir;

            var slideIconType = settings.slide_icon_type;

            if( 'icon' === slideIconType ) {

                slideIcon = settings.advanced_button_style4_icon_selection;
            
                var slideIconHTML = elementor.helpers.renderIcon( view, settings.advanced_button_style4_icon_selection_updated, { 'aria-hidden': true }, 'i' , 'object' ),
                    slideMigrated = elementor.helpers.isIconMigrated( settings, 'advanced_button_style4_icon_selection_updated' );

            } else {

                view.addRenderAttribute( 'slide_lottie', {
                    'class': 'smw-lottie-animation',
                    'data-lottie-url': settings.slide_lottie_url,
                    'data-lottie-loop': settings.slide_lottie_loop,
                    'data-lottie-reverse': settings.slide_lottie_reverse
                });
                
            }
            
            
        } else if ( 'style5' == settings.advanced_button_hover_effect ){
            styleDir = 'advanced-button-style5-' + settings.advanced_button_style5_dir;
        }
        
        var iconType = settings.icon_type;

        if( 'icon' === iconType ) {
            var iconHTML = elementor.helpers.renderIcon( view, settings.advanced_button_icon_selection_updated, { 'aria-hidden': true }, 'i' , 'object' ),
                migrated = elementor.helpers.isIconMigrated( settings, 'advanced_button_icon_selection_updated' );
        } else {

            view.addRenderAttribute( 'lottie', {
                'class': 'smw-lottie-animation',
                'data-lottie-url': settings.lottie_url,
                'data-lottie-loop': settings.lottie_loop,
                'data-lottie-reverse': settings.lottie_reverse
            });

        }
        
        #>
        
        <div class="advanced-button-container">
            <a class="advanced-button {{ buttonSize }} {{ styleDir }}" href="{{ buttonUrl }}" onclick="{{ buttonEvent }}">
                <div class="advanced-button-text-icon-wrapper">
                    <# if ('yes' === settings.advanced_button_icon_switcher) { #>
                        <# if( 'before' === settings.advanced_button_icon_position &&  'style4' != settings.advanced_button_hover_effect ) { #>
                            <# if( 'icon' === iconType ) {
                                if ( iconHTML && iconHTML.rendered && ( ! buttonIcon || migrated ) ) { #>
                                    {{{ iconHTML.value }}}
                                <# } else { #>
                                    <i class="{{ buttonIcon }}" aria-hidden="true"></i>
                                <# } #>
                            <# } else { #>
                                <div {{{ view.getRenderAttributeString('lottie') }}}></div>
                            <# } #>
                        <# } #>
                    <# } #>
                    <span {{{ view.getRenderAttributeString('advanced_button_text') }}}>{{{ buttonText }}}</span>
                    <# if ('yes' === settings.advanced_button_icon_switcher) { #>
                        <# if( 'after' == settings.advanced_button_icon_position && 'style4' != settings.advanced_button_hover_effect ) { #>
                            <# if( 'icon' === iconType ) {
                                if ( iconHTML && iconHTML.rendered && ( ! buttonIcon || migrated ) ) { #>
                                    {{{ iconHTML.value }}}
                                <# } else { #>
                                    <i class="{{ buttonIcon }}" aria-hidden="true"></i>
                                <# } #>
                            <# } else { #>
                                <div {{{ view.getRenderAttributeString('lottie') }}}></div>
                            <# } #>
                        <# } #>
                    <# } #>
                </div>
                <# if( 'style4' == settings.advanced_button_hover_effect ) { #>
                    <div class="advanced-button-style4-icon-wrapper {{ settings.advanced_button_style4_dir }}">
                        <# if ( 'icon' === slideIconType ) { #>
                            <# if ( slideIconHTML && slideIconHTML.rendered && ( ! slideIcon || slideMigrated ) ) { #>
                                {{{ slideIconHTML.value }}}
                            <# } else { #>
                                <i class="{{ slideIcon }}" aria-hidden="true"></i>
                            <# } #>
                        <# } else { #>
                            <div {{{ view.getRenderAttributeString('slide_lottie') }}}></div>
                        <# } #>
                    </div>
                <# } #>
            </a>
        </div>
        
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_advanced_button() );