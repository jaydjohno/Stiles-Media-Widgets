<?php

/**
 * SMW Image Button.
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
use Elementor\Group_Control_Background;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_image_button extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'image-button-css', plugin_dir_url( __FILE__ ) .  '../css/image-button.css');
    }
    
    public function get_name()
    {
        return 'stiles-image-button';
    }
    
    public function get_title()
    {
        return 'Image Button';
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
        return [ 'image-button-css' ];
    }
    
    public function get_script_depends() 
    {
        return [ 'lottie-js' ];
    }
    
    protected function register_controls() {

        $this->start_controls_section('image_button_general_section',
                [
                    'label'         => __('Button', smw_slug),
                    ]
                );
        
        $this->add_control('image_button_text',
                [
                    'label'         => __('Text', smw_slug),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [ 'active' => true ],
                    'default'       => __('Click Me',smw_slug),
                    'label_block'   => true,
                ]
                );
        
        $this->add_control('image_button_link_selection', 
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
        
        $this->add_control('image_button_link',
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
                        'image_button_link_selection' => 'url'
                    ]
                ]
                );
        
        $this->add_control('image_button_existing_link',
                [
                    'label'         => __('Existing Page', smw_slug),
                    'type'          => Controls_Manager::SELECT2,
                    'options'       => $this->getTemplateInstance()->get_all_posts(),
                    'condition'     => [
                        'image_button_link_selection'     => 'link',
                    ],
                    'multiple'      => false,
                    'separator'     => 'after',
                    'label_block'   => true,
                ]
                );
        
        $this->add_control('image_button_hover_effect', 
                [
                    'label'         => __('Hover Effect', smw_slug),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'none',
                    'options'       => [
                        'none'          => __('None',smw_slug),
                        'style1'        => __('Background Slide',smw_slug),
                        'style3'        => __('Diagonal Slide',smw_slug),
                        'style4'        => __('Icon Slide',smw_slug),
                        'style5'        => __('Overlap',smw_slug),
                        ],
                    'label_block'   => true,
                    ]
                );
        
        $this->add_control('image_button_style1_dir', 
            [
                'label'         => __('Slide Direction', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'bottom',
                'options'       => [
                    'bottom'       => __('Top to Bottom',smw_slug),
                    'top'          => __('Bottom to Top',smw_slug),
                    'left'         => __('Right to Left',smw_slug),
                    'right'        => __('Left to Right',smw_slug),
                ],
                'label_block'   => true,
                'condition'     => [
                    'image_button_hover_effect' => 'style1',
                ],
            ]
        );
        
        $this->add_control('image_button_style3_dir', 
                [
                    'label'         => __('Slide Direction', smw_slug),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'bottom',
                    'options'       => [
                        'top'          => __('Bottom Left to Top Right',smw_slug),
                        'bottom'       => __('Top Right to Bottom Left',smw_slug),
                        'left'         => __('Top Left to Bottom Right',smw_slug),
                        'right'        => __('Bottom Right to Top Left',smw_slug),
                        ],
                    'condition'     => [
                        'image_button_hover_effect' => 'style3',
                        ],
                    'label_block'   => true,
                    ]
                );

        $this->add_control('image_button_style4_dir', 
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
                    'image_button_hover_effect' => 'style4',
                ],
            ]
        );
    
        $this->add_control('image_button_style5_dir', 
            [
                'label'         => __('Overlap Direction', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'horizontal',
                'options'       => [
                    'horizontal'          => __('Horizontal',smw_slug),
                    'vertical'       => __('Vertical',smw_slug),
                ],
                'label_block'   => true,
                'condition'     => [
                    'image_button_hover_effect' => 'style5',
                ],
            ]
        );
        
        $this->add_control('image_button_icon_switcher',
            [
                'label'         => __('Icon', smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('Enable or disable button icon',smw_slug),
                'condition'     => [
                    'image_button_hover_effect!'  => 'style4'
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
                    'image_button_hover_effect!'  => 'style4',
                    'image_button_icon_switcher' => 'yes',
                ],
            ]
        );

        $this->add_control('image_button_icon_selection_updated',
            [
                'label'         => __('Icon', smw_slug),
                'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'image_button_icon_selection',
                'default' => [
                    'value'     => 'fas fa-bars',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'image_button_icon_switcher'    => 'yes',
                    'image_button_hover_effect!'    =>  'style4',
                    'icon_type'                             => 'icon'
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
                    'image_button_icon_switcher'  => 'yes',
                    'image_button_hover_effect!'  => 'style4',
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
                    'image_button_icon_switcher'  => 'yes',
                    'image_button_hover_effect!'  => 'style4',
                    'icon_type'                     => 'animation'
                ],
            ]
        );

        $this->add_control('lottie_reverse',
            [
                'label'         => __('Reverse',smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'         => [
                    'image_button_icon_switcher'  => 'yes',
                    'image_button_hover_effect!'  => 'style4',
                    'icon_type'                         => 'animation'
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
                    'image_button_hover_effect'  => 'style4'
                ],
            ]
        );
        
        $this->add_control('image_button_style4_icon_selection_updated',
            [
                'label'         => __('Icon', smw_slug),
                'type'              => Controls_Manager::ICONS,
                'fa4compatibility'  => 'image_button_style4_icon_selection',
                'default' => [
                    'value'     => 'fas fa-bars',
                    'library'   => 'fa-solid',
                ],
                'label_block'   => true,
                'condition'     => [
                    'slide_icon_type'   => 'icon',
                    'image_button_hover_effect'  => 'style4'
                ],
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
                    'image_button_hover_effect'  => 'style4'
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
                    'image_button_hover_effect'  => 'style4'
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
                    'image_button_hover_effect'  => 'style4'
                ]
            ]
        );
        
        $this->add_control('image_button_icon_position', 
            [
                'label'         => __('Icon Position', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'before',
                'options'       => [
                    'before'        => __('Before',smw_slug),
                    'after'         => __('After',smw_slug),
                ],
                'label_block'   => true,
                'condition'     => [
                    'image_button_icon_switcher' => 'yes',
                    'image_button_hover_effect!'  =>  'style4'
                ],
            ]
        );
        
        $this->add_responsive_control('image_button_icon_before_size',
            [
                'label'         => __('Icon Size', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'condition'     => [
                    'image_button_icon_switcher' => 'yes',
                    'image_button_hover_effect!'  => 'style4'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .image-button-text-icon-wrapper i' => 'font-size: {{SIZE}}px',
                    '{{WRAPPER}} .image-button-text-icon-wrapper svg' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                ]
            ]
        );
        
        $this->add_responsive_control('image_button_icon_style4_size',
            [
                'label'         => __('Icon Size', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'condition'     => [
                    'image_button_hover_effect'  => 'style4'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .image-button-style4-icon-wrapper i' => 'font-size: {{SIZE}}px',
                    '{{WRAPPER}} .image-button-style4-icon-wrapper svg' => 'width: {{SIZE}}px; height: {{SIZE}}px',
                ]
            ]
        );
        
        $this->add_responsive_control('image_button_icon_before_spacing',
            [
                'label'         => __('Icon Spacing', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'  => 15
                ],
                'selectors'     => [
                    '{{WRAPPER}} .image-button-text-icon-wrapper i, {{WRAPPER}} .image-button-text-icon-wrapper svg' => 'margin-right: {{SIZE}}px',
                ],
                'separator'     => 'after',
                'condition'     => [
                    'image_button_icon_switcher' => 'yes',
                    'image_button_icon_position' => 'before',
                    'image_button_hover_effect!' => 'style4'
                ],
            ]
        );
        
        $this->add_responsive_control('image_button_icon_after_spacing',
            [
                'label'         => __('Icon Spacing', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'size'  => 15
                ],
                'selectors'     => [
                    '{{WRAPPER}} .image-button-text-icon-wrapper i, {{WRAPPER}} .image-button-text-icon-wrapper svg' => 'margin-left: {{SIZE}}px',
                ],
                'separator'     => 'after',
                'condition'     => [
                    'image_button_icon_switcher' => 'yes',
                    'image_button_icon_position' => 'after',
                    'image_button_hover_effect!' => 'style4'
                ],
            ]
        );
        
        $this->add_control('image_button_size', 
            [
                'label'         => __('Size', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'lg',
                'options'       => [
                    'sm'            => __('Small',smw_slug),
                    'md'            => __('Medium',smw_slug),
                    'lg'            => __('Large',smw_slug),
                    'block'         => __('Block',smw_slug),
                ],
                'label_block'   => true,
                'separator'     => 'before',
            ]
        );
        
        $this->add_responsive_control('image_button_align',
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
                    '{{WRAPPER}} .image-button-container' => 'text-align: {{VALUE}}',
                ],
				'default' => 'center',
			]
		);
        
        $this->add_control('image_button_event_switcher', 
            [
                'label'         => __('onclick Event', smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'separator'     => 'before',
            ]
        );
        
        $this->add_control('image_button_event_function', 
            [
                'label'         => __('Example: myFunction();', smw_slug),
                'type'          => Controls_Manager::TEXTAREA,
                'dynamic'       => [ 'active' => true ],
                'condition'     => [
                    'image_button_event_switcher' => 'yes',
                ],
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section('image_button_style_section',
            [
                'label'             => __('Button', smw_slug),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'image_button_typo',
                'scheme'            => Typography::TYPOGRAPHY_1,
                'selector'          => '{{WRAPPER}} .image-button',
            ]
            );
        
        $this->start_controls_tabs('image_button_style_tabs');
        
        $this->start_controls_tab('image_button_style_normal',
            [
                'label'             => __('Normal', smw_slug),
            ]
            );

        $this->add_control('image_button_text_color_normal',
            [
                'label'             => __('Text Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .image-button .image-button-text-icon-wrapper'   => 'color: {{VALUE}};',
                ]
            ]);
        
        $this->add_control('image_button_icon_color_normal',
            [
                'label'             => __('Icon Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_2,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .image-button-text-icon-wrapper i'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'image_button_icon_switcher'    => 'yes',
                    'icon_type'                             => 'icon',
                    'image_button_hover_effect!'    => 'style4'
                ]
            ]);
        
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'image_button_background',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .image-button',
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'image_button_border_normal',
                    'selector'      => '{{WRAPPER}} .image-button',
                ]
                );
        
        $this->add_control('image_button_border_radius_normal',
                [
                    'label'         => __('Border Radius', smw_slug),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .image-button' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Icon Shadow',smw_slug),
                'name'          => 'image_button_icon_shadow_normal',
                'selector'      => '{{WRAPPER}} .image-button-text-icon-wrapper i',
                'condition'         => [
                    'image_button_icon_switcher'    => 'yes',
                    'icon_type'                             => 'icon',
                    'image_button_hover_effect!'    => 'style4'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
                [
                    'label'         => __('Text Shadow',smw_slug),
                    'name'          => 'image_button_text_shadow_normal',
                    'selector'      => '{{WRAPPER}} .image-button-text-icon-wrapper span',
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => __('Button Shadow',smw_slug),
                    'name'          => 'image_button_box_shadow_normal',
                    'selector'      => '{{WRAPPER}} .image-button',
                ]
                );
        
        $this->add_responsive_control('image_button_margin_normal',
                [
                    'label'         => __('Margin', smw_slug),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .image-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->add_responsive_control('image_button_padding_normal',
                [
                    'label'         => __('Padding', smw_slug),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .image-button, {{WRAPPER}} .image-button-effect-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();
        
        $this->start_controls_tab('image_button_style_hover',
            [
                'label'             => __('Hover', smw_slug),
            ]
            );

        $this->add_control('image_button_text_color_hover',
            [
                'label'             => __('Text Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .image-button:hover .image-button-text-icon-wrapper'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'image_button_hover_effect!'   => 'style4'
                ]
            ]);
        
        $this->add_control('image_button_icon_color_hover',
            [
                'label'             => __('Icon Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .image-button:hover .image-button-text-icon-wrapper i'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'image_button_icon_switcher'    => 'yes',
                    'icon_type'                             => 'icon',
                    'image_button_hover_effect!'    => 'style4'
                ]
            ]
        );

        $this->add_control('image_button_style4_icon_color',
            [
                'label'             => __('Icon Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .image-button:hover .image-button-style4-icon-wrapper'   => 'color: {{VALUE}};',
                ],
                'condition'         => [
                    'image_button_hover_effect'  => 'style4',
                    'slide_icon_type'   => 'icon'
                ]
            ]
        );

        $this->add_control('image_button_diagonal_overlay_color',
            [
                'label'             => __('Overlay Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .image-button-diagonal-effect-top:before, {{WRAPPER}} .image-button-diagonal-effect-bottom:before, {{WRAPPER}} .image-button-diagonal-effect-left:before, {{WRAPPER}} .image-button-diagonal-effect-right:before'   => 'background-color: {{VALUE}};',
                ],
                'condition'         => [
                    'image_button_hover_effect'  => 'style3'
                ]
            ]
        );

        $this->add_control('image_button_overlap_overlay_color',
            [
                'label'             => __('Overlay Colour', smw_slug),
                'type'              => Controls_Manager::COLOR,
                'scheme'            => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .image-button-overlap-effect-horizontal:before, {{WRAPPER}} .image-button-overlap-effect-vertical:before'   => 'background-color: {{VALUE}};',
                ],
                'condition'         => [
                    'image_button_hover_effect'  => 'style5'
                ]
            ]
        );
            
        $this->add_group_control(
            Group_Control_Background::get_type(),
                [
                    'name'              => 'image_button_background_hover',
                    'types'             => [ 'classic' , 'gradient' ],
                    'selector'          => '{{WRAPPER}} .image-button-none:hover, {{WRAPPER}} .image-button-style4-icon-wrapper,{{WRAPPER}} .image-button-style1-top:before,{{WRAPPER}} .image-button-style1-bottom:before,{{WRAPPER}} .image-button-style1-left:before,{{WRAPPER}} .image-button-style1-right:before,{{WRAPPER}} .image-button-diagonal-effect-right:hover, {{WRAPPER}} .image-button-diagonal-effect-top:hover, {{WRAPPER}} .image-button-diagonal-effect-left:hover, {{WRAPPER}} .image-button-diagonal-effect-bottom:hover,{{WRAPPER}} .image-button-overlap-effect-horizontal:hover, {{WRAPPER}} .image-button-overlap-effect-vertical:hover',
                    ]
                );
        
        $this->add_control('image_button_overlay_color',
                [
                    'label'         => __('Overlay Colour', smw_slug),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'condition'     => [
                        'image_button_overlay_switcher' => 'yes'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .image-button-squares-effect:before, {{WRAPPER}} .image-button-squares-effect:after,{{WRAPPER}} .image-button-squares-square-container:before, {{WRAPPER}} .image-button-squares-square-container:after' => 'background-color: {{VALUE}};',
                        ]
                    ]
                );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
                [
                    'name'          => 'image_button_border_hover',
                    'selector'      => '{{WRAPPER}} .image-button:hover',
                ]
                );
        
        $this->add_control('image_button_border_radius_hover',
                [
                    'label'         => __('Border Radius', smw_slug),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px', '%' ,'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .image-button:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
                    ]
                ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Icon Shadow',smw_slug),
                'name'          => 'image_button_icon_shadow_hover',
                'selector'      => '{{WRAPPER}} .image-button:hover .image-button-text-icon-wrapper i',
                'condition'         => [
                    'image_button_icon_switcher'    => 'yes',
                    'icon_type'                             => 'icon',
                    'image_button_hover_effect!'    => 'style4'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Icon Shadow',smw_slug),
                'name'          => 'image_button_style4_icon_shadow_hover',
                'selector'      => '{{WRAPPER}} .image-button:hover .image-button-style4-icon-wrapper i',
                'condition'         => [
                    'image_button_hover_effect'     => 'style4',
                    'slide_icon_type'   => 'icon'
                ]
            ]
        );
    
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'         => __('Text Shadow',smw_slug),
                'name'          => 'image_button_text_shadow_hover',
                'selector'      => '{{WRAPPER}}  .image-button:hover .image-button-text-icon-wrapper span',
                'condition'         => [
                    'image_button_hover_effect!'   => 'style4'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
                [
                    'label'         => __('Button Shadow',smw_slug),
                    'name'          => 'image_button_box_shadow_hover',
                    'selector'      => '{{WRAPPER}} .image-button:hover',
                ]
                );
        
        $this->add_responsive_control('image_button_margin_hover',
                [
                    'label'         => __('Margin', smw_slug),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .image-button:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->add_responsive_control('image_button_padding_hover',
                [
                    'label'         => __('Padding', smw_slug),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em', '%'],
                    'selectors'     => [
                        '{{WRAPPER}} .image-button:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        
        $settings = $this->get_settings_for_display();
        
        $this->add_inline_editing_attributes( 'image_button_text' );
        
        if($settings['image_button_link_selection'] == 'url'){
            $image_link = $settings['image_button_link']['url'];
        } else {
            $image_link = get_permalink($settings['image_button_existing_link']);
        }
        
        $button_text = $settings['image_button_text'];
        
        $button_size = 'image-button-' . $settings['image_button_size'];
        
        $image_event = $settings['image_button_event_function'];
        
        if ( ! empty ( $settings['image_button_icon_selection'] ) ) {
            $this->add_render_attribute( 'icon', 'class', $settings['image_button_icon_selection'] );
            $this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
        }
        
        $icon_type = $settings['icon_type'];

        if( 'icon' === $icon_type ) {
            $migrated = isset( $settings['__fa4_migrated']['image_button_icon_selection_updated'] );
            $is_new = empty( $settings['image_button_icon_selection'] ) && Icons_Manager::is_migration_allowed();
        } else {
            $this->add_render_attribute( 'lottie', [
                    'class' => 'smw-lottie-animation',
                    'data-lottie-url' => $settings['lottie_url'],
                    'data-lottie-loop' => $settings['lottie_loop'],
                    'data-lottie-reverse' => $settings['lottie_reverse'],
                ]
            );
        }
        
        if ($settings['image_button_hover_effect'] == 'none'){
            $style_dir = 'image-button-none';
        }    elseif($settings['image_button_hover_effect'] == 'style1'){
            $style_dir = 'image-button-style1-' . $settings['image_button_style1_dir'];
        }   elseif($settings['image_button_hover_effect'] == 'style3'){
            $style_dir = 'image-button-diagonal-effect-' . $settings['image_button_style3_dir'];
        }   elseif($settings['image_button_hover_effect'] == 'style4'){
            $style_dir = 'image-button-style4-' . $settings['image_button_style4_dir'];
            
            $slide_icon_type = $settings['slide_icon_type'];

            if( 'icon' === $slide_icon_type ) {
                
                if ( ! empty ( $settings['image_button_style4_icon_selection'] ) ) {
                    $this->add_render_attribute( 'slide_icon', 'class', $settings['image_button_style4_icon_selection'] );
                    $this->add_render_attribute( 'slide_icon', 'aria-hidden', 'true' );
                }
                
                $slide_migrated = isset( $settings['__fa4_migrated']['image_button_style4_icon_selection_updated'] );
                $slide_is_new = empty( $settings['image_button_style4_icon_selection'] ) && Icons_Manager::is_migration_allowed();

            } else {

                $this->add_render_attribute( 'slide_lottie', [
                        'class' => 'smw-lottie-animation',
                        'data-lottie-url' => $settings['slide_lottie_url'],
                        'data-lottie-loop' => $settings['slide_lottie_loop'],
                        'data-lottie-reverse' => $settings['slide_lottie_reverse'],
                    ]
                );

            }
            
            
        }   elseif($settings['image_button_hover_effect'] == 'style5'){
            $style_dir = 'image-button-overlap-effect-' . $settings['image_button_style5_dir'];
        }
        
        $this->add_render_attribute( 'button', 'class', array(
            'image-button',
            $button_size,
            $style_dir
        ));
        
        if( ! empty( $image_link ) ) {
        
            $this->add_render_attribute( 'button', 'href', $image_link );
            
            if( ! empty( $settings['image_button_link']['is_external'] ) )
                $this->add_render_attribute( 'button', 'target', '_blank' );
            
            if( ! empty( $settings['image_button_link']['nofollow'] ) )
                $this->add_render_attribute( 'button', 'rel', 'nofollow' );
        }
        
        if( 'yes' === $settings['image_button_event_switcher'] && ! empty( $image_event ) ) {
            $this->add_render_attribute( 'button', 'onclick', $image_event );
        }

    ?>
    <div class="image-button-container">
        <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
            <div class="image-button-text-icon-wrapper">
            <?php if('yes' === $settings['image_button_icon_switcher'] ) : ?>
                <?php if( $settings['image_button_hover_effect'] !== 'style4' && $settings['image_button_icon_position'] === 'before' ) : ?>
                    <?php if( 'icon' === $icon_type ) : ?>
                        <?php if ( $is_new || $migrated ) :
                            Icons_Manager::render_icon( $settings['image_button_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
                        else: ?>
                            <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                        <?php endif; ?>
                    <?php else: ?>
                        <div <?php echo $this->get_render_attribute_string( 'lottie' ); ?>></div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
            
            <span <?php echo $this->get_render_attribute_string( 'image_button_text' ); ?>>
                <?php echo $button_text; ?>
            </span>
            <?php if('yes' === $settings['image_button_icon_switcher'] ) : ?>
                <?php if( $settings['image_button_hover_effect'] !== 'style4' &&  $settings['image_button_icon_position'] == 'after' ) : ?>
                    <?php if( 'icon' === $icon_type ) : ?>
                    <?php if ( $is_new || $migrated ) :
                        Icons_Manager::render_icon( $settings['image_button_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
                    else: ?>
                        <i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
                    <?php endif; ?>
                    <?php else: ?>
                        <div <?php echo $this->get_render_attribute_string( 'lottie' ); ?>></div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php if( $settings['image_button_hover_effect'] == 'style4') : ?>
            <div class="image-button-style4-icon-wrapper <?php echo esc_attr( $settings['image_button_style4_dir'] ); ?>">
                <?php if( 'icon' === $slide_icon_type ) : ?>
                    <?php if ( $slide_is_new || $slide_migrated ) :
                        Icons_Manager::render_icon( $settings['image_button_style4_icon_selection_updated'], [ 'aria-hidden' => 'true' ] );
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
    
    protected function _content_template() {
        ?>
        <#
        
        view.addInlineEditingAttributes( 'image_button_text' );
        
        var buttonText = settings.image_button_text,
            buttonUrl,
            styleDir,
            slideIcon,
            buttonSize = 'image-button-' + settings.image_button_size,
            buttonEvent = settings.image_button_event_function,
            buttonIcon = settings.image_button_icon_selection;
        
        if( 'url' == settings.image_button_link_selection ) {
            buttonUrl = settings.image_button_link.url;
        } else {
            buttonUrl = settings.image_button_existing_link;
        }
        
        if ( 'none' == settings.image_button_hover_effect ) {
            styleDir = 'button-none';
        } else if( 'style1' == settings.image_button_hover_effect ) {
            styleDir = 'image-button-style1-' + settings.image_button_style1_dir;
        } else if ( 'style3' == settings.image_button_hover_effect ) {
            styleDir = 'image-button-diagonal-effect-' + settings.image_button_style3_dir;
        } else if ( 'style4' == settings.image_button_hover_effect ) {
            styleDir = 'image-button-style4-' + settings.image_button_style4_dir;

            var slideIconType = settings.slide_icon_type;

            if( 'icon' === slideIconType ) {
                slideIcon = settings.image_button_style4_icon_selection;
            
                var slideIconHTML = elementor.helpers.renderIcon( view, settings.image_button_style4_icon_selection_updated, { 'aria-hidden': true }, 'i' , 'object' ),
                    slideMigrated = elementor.helpers.isIconMigrated( settings, 'image_button_style4_icon_selection_updated' );

            } else {

                view.addRenderAttribute( 'slide_lottie', {
                    'class': 'smw-lottie-animation',
                    'data-lottie-url': settings.slide_lottie_url,
                    'data-lottie-loop': settings.slide_lottie_loop,
                    'data-lottie-reverse': settings.slide_lottie_reverse
                });
            
            }
            
        } else if ( 'style5' == settings.image_button_hover_effect ){
            styleDir = 'image-button-overlap-effect-' + settings.image_button_style5_dir;
        }
        
        var iconType = settings.icon_type;

        if( 'icon' === iconType ) {
            var iconHTML = elementor.helpers.renderIcon( view, settings.image_button_icon_selection_updated, { 'aria-hidden': true }, 'i' , 'object' ),
                migrated = elementor.helpers.isIconMigrated( settings, 'image_button_icon_selection_updated' );
        } else {

            view.addRenderAttribute( 'slide_lottie', {
                'class': 'smw-lottie-animation',
                'data-lottie-url': settings.lottie_url,
                'data-lottie-loop': settings.lottie_loop,
                'data-lottie-reverse': settings.lottie_reverse
            });
            
        }
        
        #>
        
        <div class="image-button-container">
            <a class="image-button  {{ buttonSize }} {{ styleDir }}" href="{{ buttonUrl }}" onclick="{{ buttonEvent }}">
                <div class="image-button-text-icon-wrapper">
                    <# if ('yes' === settings.image_button_icon_switcher) { #>
                        <# if( 'before' === settings.image_button_icon_position &&  'style4' !== settings.image_button_hover_effect ) { #>
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
                    
                    <span {{{ view.getRenderAttributeString('image_button_text') }}}>{{{ buttonText }}}</span>
                    <# if ('yes' === settings.image_button_icon_switcher) { #>
                        <# if( 'after' === settings.image_button_icon_position && 'style4' !== settings.image_button_hover_effect ) { #>
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
                <# if( 'style4' == settings.image_button_hover_effect ) { #>
                    <div class="image-button-style4-icon-wrapper {{ settings.image_button_style4_dir }}">
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

Plugin::instance()->widgets_manager->register_widget_type( new stiles_image_button() );