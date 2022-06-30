<?php

/**
 * SMW Team Member Carousel.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Modules\DynamicTags\Module as TagsModule;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_team_member_carousel extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'team-member-carousel-css', plugin_dir_url( __FILE__ ) .  '../css/team-member-carousel.css');
    
        wp_register_script( 'team-member-carousel-js', plugin_dir_url( __FILE__ ) . '../js/team-member-carousel.js' );
    }
    
    public function get_name()
    {
        return 'stiles-team-member-carousel';
    }
    
    public function get_title()
    {
        return 'Team Members Carousel';
    }
    
    public function get_icon()
    {
        return 'eicon-person';
    }
    
    public function get_categories()
    {
        return [ 'stiles-media-category' ];
    }
    
    public function get_style_depends() 
    {
        return [ 'team-member-carousel-css' ];
    }
    
    public function get_script_depends() 
    {
        return [ 'team-member-carousel-js' ];
    }
    
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_team_member',
            [
                'label' => __('Team Members', smw_slug),
            ]
        );

        $this->add_control(
            'team_member_details',
            [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'team_member_name' => 'Team Member #1',
                        'team_member_position' => 'WordPress Developer',
                        'facebook_url' => '#',
                        'twitter_url' => '#',
                        'google_plus_url' => '#',
                    ],
                    [
                        'team_member_name' => 'Team Member #2',
                        'team_member_position' => 'Web Designer',
                        'facebook_url' => '#',
                        'twitter_url' => '#',
                        'google_plus_url' => '#',
                    ],
                    [
                        'team_member_name' => 'Team Member #3',
                        'team_member_position' => 'Testing Engineer',
                        'facebook_url' => '#',
                        'twitter_url' => '#',
                        'google_plus_url' => '#',
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'team_member_name',
                        'label' => __('Name', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'dynamic' => [
                            'active' => true,
                        ],
                        'default' => __('John Doe', smw_slug),
                    ],
                    [
                        'name' => 'team_member_position',
                        'label' => __('Position', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'dynamic' => [
                            'active' => true,
                        ],
                        'default' => __('WordPress Developer', smw_slug),
                    ],
                    [
                        'name' => 'team_member_description',
                        'label' => __('Description', smw_slug),
                        'type' => Controls_Manager::TEXTAREA,
                        'dynamic' => [
                            'active' => true,
                        ],
                        'default' => __('Enter member description here which describes the position of member in company', smw_slug),
                    ],
                    [
                        'name' => 'team_member_image',
                        'label' => __('Image', smw_slug),
                        'type' => Controls_Manager::MEDIA,
                        'dynamic' => [
                            'active' => true,
                        ],
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'name' => 'social_links_heading',
                        'label' => __('Social Links', smw_slug),
                        'type' => Controls_Manager::HEADING,
                        'separator' => 'before',
                    ],
                    [
                        'name' => 'facebook_url',
                        'label' => __('Facebook', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'dynamic' => [
                            'active' => true,
                            'categories' => [
                                TagsModule::POST_META_CATEGORY,
                            ],
                        ],
                        'description' => __('Enter Facebook page or profile URL of team member', smw_slug),
                    ],
                    [
                        'name' => 'twitter_url',
                        'label' => __('Twitter', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'dynamic' => [
                            'active' => true,
                            'categories' => [
                                TagsModule::POST_META_CATEGORY,
                            ],
                        ],
                        'description' => __('Enter Twitter profile URL of team member', smw_slug),
                    ],
                    [
                        'name' => 'google_plus_url',
                        'label' => __('Google+', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'dynamic' => [
                            'active' => true,
                            'categories' => [
                                TagsModule::POST_META_CATEGORY,
                            ],
                        ],
                        'description' => __('Enter Google+ profile URL of team member', smw_slug),
                    ],
                    [
                        'name' => 'linkedin_url',
                        'label' => __('Linkedin', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'dynamic' => [
                            'active' => true,
                            'categories' => [
                                TagsModule::POST_META_CATEGORY,
                            ],
                        ],
                        'description' => __('Enter Linkedin profile URL of team member', smw_slug),
                    ],
                    [
                        'name' => 'instagram_url',
                        'label' => __('Instagram', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'dynamic' => [
                            'active' => true,
                            'categories' => [
                                TagsModule::POST_META_CATEGORY,
                            ],
                        ],
                        'description' => __('Enter Instagram profile URL of team member', smw_slug),
                    ],
                    [
                        'name' => 'youtube_url',
                        'label' => __('YouTube', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'dynamic' => [
                            'active' => true,
                            'categories' => [
                                TagsModule::POST_META_CATEGORY,
                            ],
                        ],
                        'description' => __('Enter YouTube profile URL of team member', smw_slug),
                    ],
                    [
                        'name' => 'pinterest_url',
                        'label' => __('Pinterest', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'dynamic' => [
                            'active' => true,
                            'categories' => [
                                TagsModule::POST_META_CATEGORY,
                            ],
                        ],
                        'description' => __('Enter Pinterest profile URL of team member', smw_slug),
                    ],
                    [
                        'name' => 'dribbble_url',
                        'label' => __('Dribbble', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'dynamic' => [
                            'active' => true,
                            'categories' => [
                                TagsModule::POST_META_CATEGORY,
                            ],
                        ],
                        'description' => __('Enter Dribbble profile URL of team member', smw_slug),
                    ],
                ],
                'title_field' => '{{{ team_member_name }}}',
            ]
        );

        $this->add_control(
            'member_social_links',
            [
                'label' => __('Show Social Icons', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', smw_slug),
                'label_off' => __('No', smw_slug),
                'return_value' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_member_box_settings',
            [
                'label' => __('Team Member Settings', smw_slug),
            ]
        );

        $this->add_control(
            'name_html_tag',
            [
                'label' => __('Name HTML Tag', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'h4',
                'options' => [
                    'h1' => __('H1', smw_slug),
                    'h2' => __('H2', smw_slug),
                    'h3' => __('H3', smw_slug),
                    'h4' => __('H4', smw_slug),
                    'h5' => __('H5', smw_slug),
                    'h6' => __('H6', smw_slug),
                    'div' => __('div', smw_slug),
                    'span' => __('span', smw_slug),
                    'p' => __('p', smw_slug),
                ],
            ]
        );

        $this->add_control(
            'position_html_tag',
            [
                'label' => __('Position HTML Tag', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'div',
                'options' => [
                    'h1' => __('H1', smw_slug),
                    'h2' => __('H2', smw_slug),
                    'h3' => __('H3', smw_slug),
                    'h4' => __('H4', smw_slug),
                    'h5' => __('H5', smw_slug),
                    'h6' => __('H6', smw_slug),
                    'div' => __('div', smw_slug),
                    'span' => __('span', smw_slug),
                    'p' => __('p', smw_slug),
                ],
            ]
        );

        $this->add_control(
            'social_links_position',
            [
                'label' => __('Social Icons Position', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'after_desc',
                'options' => [
                    'before_desc' => __('Before Description', smw_slug),
                    'after_desc' => __('After Description', smw_slug),
                ],
                'condition' => [
                    'member_social_links' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'overlay_content',
            [
                'label' => __('Overlay Content', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __('None', smw_slug),
                    'social_icons' => __('Social Icons', smw_slug),
                    'all_content' => __('Content + Social Icons', smw_slug),
                ],
            ]
        );

        $this->add_control(
            'member_title_divider',
            [
                'label' => __('Divider after Name', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __('Show', smw_slug),
                'label_off' => __('Hide', smw_slug),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'member_position_divider',
            [
                'label' => __('Divider after Position', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'hide',
                'label_on' => __('Show', smw_slug),
                'label_off' => __('Hide', smw_slug),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'member_description_divider',
            [
                'label' => __('Divider after Description', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'hide',
                'label_on' => __('Show', smw_slug),
                'label_off' => __('Hide', smw_slug),
                'return_value' => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Slider Settings
         */
        $this->start_controls_section(
            'section_slider_settings',
            [
                'label' => __('Slider Settings', smw_slug),
            ]
        );

        $this->add_responsive_control(
            'items',
            [
                'label' => __('Visible Items', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 3],
                'tablet_default' => ['size' => 2],
                'mobile_default' => ['size' => 1],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => __('Margin', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 10],
                'tablet_default' => ['size' => 10],
                'mobile_default' => ['size' => 10],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', smw_slug),
                'label_off' => __('No', smw_slug),
                'return_value' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Autoplay Speed', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 2000],
                'range' => [
                    'px' => [
                        'min' => 500,
                        'max' => 5000,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => __('Pause On Hover', smw_slug),
                'description' => __('Pause slider when hover on slider area.', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Pause', smw_slug),
                'label_off' => __('Play', smw_slug),
                'return_value' => 'yes',
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label' => __('Infinite Loop', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', smw_slug),
                'label_off' => __('No', smw_slug),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'grab_cursor',
            [
                'label' => __('Grab Cursor', smw_slug),
                'description' => __('Shows grab cursor when you hover over the slider', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Show', smw_slug),
                'label_off' => __('Hide', smw_slug),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'name_navigation_heading',
            [
                'label' => __('Navigation', smw_slug),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'arrows',
            [
                'label' => __('Arrows', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', smw_slug),
                'label_off' => __('No', smw_slug),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'dots',
            [
                'label' => __('Dots', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', smw_slug),
                'label_off' => __('No', smw_slug),
                'return_value' => 'yes',
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*    STYLE TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Style Tab: Box Style
         */
        $this->start_controls_section(
            'section_member_box_style',
            [
                'label' => __('Box Style', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'member_box_alignment',
            [
                'label' => __('Alignment', smw_slug),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', smw_slug),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', smw_slug),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', smw_slug),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Content
         */
        $this->start_controls_section(
            'section_member_content_style',
            [
                'label' => __('Content', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'member_box_heightttt',
			[
				'label' => esc_html__( 'Height', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'size_units'	=> [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'em'	=> [
						'min'	=> 0,
						'max'	=> 200
					]
                ],
				'selectors' => [
					'{{WRAPPER}} .smw-tm-content.smw-tm-content-normal' => 'min-height: {{SIZE}}{{UNIT}};'
				],
			]
		);

        $this->add_control(
            'member_box_bg_color',
            [
                'label' => __('Background Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-content-normal' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'member_box_border',
                'label' => __('Border', smw_slug),
                'placeholder' => '1px',
                'default' => '1px',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .smw-tm-content-normal',
            ]
        );

        $this->add_control(
            'member_box_border_radius',
            [
                'label' => __('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-content-normal' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'member_box_padding',
            [
                'label' => __('Padding', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-content-normal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'pa_member_box_shadow',
                'selector' => '{{WRAPPER}} .smw-tm-content-normal',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Overlay
         */
        $this->start_controls_section(
            'section_member_overlay_style',
            [
                'label' => __('Overlay', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'overlay_content!' => 'none',
                ],
            ]
        );

        $this->add_responsive_control(
            'overlay_alignment',
            [
                'label' => __('Alignment', smw_slug),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', smw_slug),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', smw_slug),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', smw_slug),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-overlay-content-wrap' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'overlay_content!' => 'none',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .smw-tm-overlay-content-wrap:before',
                'condition' => [
                    'overlay_content!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'overlay_opacity',
            [
                'label' => __('Opacity', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-overlay-content-wrap:before' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'overlay_content!' => 'none',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Image
         */
        $this->start_controls_section(
            'section_member_image_style',
            [
                'label' => __('Image', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'member_image_width',
            [
                'label' => __('Image Width', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    'px' => [
                        'max' => 1200,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'member_image_border',
                'label' => __('Border', smw_slug),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .smw-tm-image img',
            ]
        );

        $this->add_control(
            'member_image_border_radius',
            [
                'label' => __('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-image img, {{WRAPPER}} .smw-tm-overlay-content-wrap:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'member_image_margin',
            [
                'label' => __('Margin Bottom', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Name
         */
        $this->start_controls_section(
            'section_member_name_style',
            [
                'label' => __('Name', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'member_name_typography',
                'label' => __('Typography', smw_slug),
                'scheme' => Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .smw-tm-name',
            ]
        );

        $this->add_control(
            'member_name_text_color',
            [
                'label' => __('Text Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'member_name_margin',
            [
                'label' => __('Margin Bottom', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'name_divider_heading',
            [
                'label' => __('Divider', smw_slug),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'member_title_divider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'name_divider_color',
            [
                'label' => __('Divider Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-title-divider' => 'border-bottom-color: {{VALUE}}',
                ],
                'condition' => [
                    'member_title_divider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'name_divider_style',
            [
                'label' => __('Divider Style', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'solid' => __('Solid', smw_slug),
                    'dotted' => __('Dotted', smw_slug),
                    'dashed' => __('Dashed', smw_slug),
                    'double' => __('Double', smw_slug),
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-title-divider' => 'border-bottom-style: {{VALUE}}',
                ],
                'condition' => [
                    'member_title_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'name_divider_width',
            [
                'label' => __('Divider Width', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 800,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-title-divider' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'member_title_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'name_divider_height',
            [
                'label' => __('Divider Height', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 4,
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 20,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-title-divider' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'member_title_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'name_divider_margin',
            [
                'label' => __('Margin Bottom', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-title-divider-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'member_title_divider' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Position
         */
        $this->start_controls_section(
            'section_member_position_style',
            [
                'label' => __('Position', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'member_position_typography',
                'label' => __('Typography', smw_slug),
                'scheme' => Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .smw-tm-position',
            ]
        );

        $this->add_control(
            'member_position_text_color',
            [
                'label' => __('Text Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-position' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'member_position_margin',
            [
                'label' => __('Margin Bottom', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-position' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'position_divider_heading',
            [
                'label' => __('Divider', smw_slug),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'member_position_divider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'position_divider_color',
            [
                'label' => __('Divider Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-position-divider' => 'border-bottom-color: {{VALUE}}',
                ],
                'condition' => [
                    'member_position_divider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'position_divider_style',
            [
                'label' => __('Divider Style', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'solid' => __('Solid', smw_slug),
                    'dotted' => __('Dotted', smw_slug),
                    'dashed' => __('Dashed', smw_slug),
                    'double' => __('Double', smw_slug),
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-position-divider' => 'border-bottom-style: {{VALUE}}',
                ],
                'condition' => [
                    'member_position_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'position_divider_width',
            [
                'label' => __('Divider Width', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 800,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-position-divider' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'member_position_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'position_divider_height',
            [
                'label' => __('Divider Height', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 4,
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 20,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-position-divider' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'member_position_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'position_divider_margin',
            [
                'label' => __('Margin Bottom', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-position-divider-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'member_position_divider' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Description
         */
        $this->start_controls_section(
            'section_member_description_style',
            [
                'label' => __('Description', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'member_description_typography',
                'label' => __('Typography', smw_slug),
                'scheme' => Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .smw-tm-description',
            ]
        );

        $this->add_control(
            'member_description_text_color',
            [
                'label' => __('Text Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-description' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'member_description_margin',
            [
                'label' => __('Margin Bottom', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'description_divider_heading',
            [
                'label' => __('Divider', smw_slug),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'member_description_divider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'description_divider_color',
            [
                'label' => __('Divider Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'scheme' => [
                    'type' => \Elementor\Core\Schemes\Color::get_type(),
                    'value' => \Elementor\Core\Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-description-divider' => 'border-bottom-color: {{VALUE}}',
                ],
                'condition' => [
                    'member_description_divider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'description_divider_style',
            [
                'label' => __('Divider Style', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'solid' => __('Solid', smw_slug),
                    'dotted' => __('Dotted', smw_slug),
                    'dashed' => __('Dashed', smw_slug),
                    'double' => __('Double', smw_slug),
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-description-divider' => 'border-bottom-style: {{VALUE}}',
                ],
                'condition' => [
                    'member_description_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_divider_width',
            [
                'label' => __('Divider Width', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 800,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-description-divider' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'member_description_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_divider_height',
            [
                'label' => __('Divider Height', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 4,
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 20,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-description-divider' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'member_description_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_divider_margin',
            [
                'label' => __('Margin Bottom', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-description-divider-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'member_description_divider' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Social Icons
         */
        $this->start_controls_section(
            'section_member_social_links_style',
            [
                'label' => __('Social Icons', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'member_icons_gap',
            [
                'label' => __('Icons Gap', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 10],
                'size_units' => ['%', 'px'],
                'range' => [
                    'px' => [
                        'max' => 60,
                    ],
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-social-links li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'member_icon_size',
            [
                'label' => __('Icon Size', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 30,
                    ],
                ],
                'default' => [
                    'size' => '14',
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-social-links .smw-tm-social-icon' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_links_style');

        $this->start_controls_tab(
            'tab_links_normal',
            [
                'label' => __('Normal', smw_slug),
            ]
        );

        $this->add_control(
            'member_links_icons_color',
            [
                'label' => __('Icons Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-social-links .smw-tm-social-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'member_links_bg_color',
            [
                'label' => __('Background Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-social-links .smw-tm-social-icon-wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'member_links_border',
                'label' => __('Border', smw_slug),
                'placeholder' => '1px',
                'default' => '1px',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .smw-tm-social-links .smw-tm-social-icon-wrap',
            ]
        );

        $this->add_control(
            'member_links_border_radius',
            [
                'label' => __('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-social-links .smw-tm-social-icon-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'member_links_padding',
            [
                'label' => __('Padding', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-social-links .smw-tm-social-icon-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_links_hover',
            [
                'label' => __('Hover', smw_slug),
            ]
        );

        $this->add_control(
            'member_links_icons_color_hover',
            [
                'label' => __('Icons Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-social-links .smw-tm-social-icon-wrap:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'member_links_bg_color_hover',
            [
                'label' => __('Background Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-social-links .smw-tm-social-icon-wrap:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'member_links_border_color_hover',
            [
                'label' => __('Border Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-tm-social-links .smw-tm-social-icon-wrap:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Arrows
         */
        $this->start_controls_section(
            'section_arrows_style',
            [
                'label' => __('Arrows', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'arrows' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrow',
            [
                'label' => __('Choose Arrow', smw_slug),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'fa fa-angle-right',
                'options' => [
                    'fa fa-angle-right' => __('Angle', smw_slug),
                    'fa fa-angle-double-right' => __('Double Angle', smw_slug),
                    'fa fa-chevron-right' => __('Chevron', smw_slug),
                    'fa fa-chevron-circle-right' => __('Chevron Circle', smw_slug),
                    'fa fa-arrow-right' => __('Arrow', smw_slug),
                    'fa fa-long-arrow-right' => __('Long Arrow', smw_slug),
                    'fa fa-caret-right' => __('Caret', smw_slug),
                    'fa fa-caret-square-o-right' => __('Caret Square', smw_slug),
                    'fa fa-arrow-circle-right' => __('Arrow Circle', smw_slug),
                    'fa fa-arrow-circle-o-right' => __('Arrow Circle O', smw_slug),
                    'fa fa-toggle-right' => __('Toggle', smw_slug),
                    'fa fa-hand-o-right' => __('Hand', smw_slug),
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_size',
            [
                'label' => __('Arrows Size', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => '22'],
                'range' => [
                    'px' => [
                        'min' => 15,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'left_arrow_position',
            [
                'label' => __('Align Left Arrow', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 40,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'right_arrow_position',
            [
                'label' => __('Align Right Arrow', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 40,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_arrows_style');

        $this->start_controls_tab(
            'tab_arrows_normal',
            [
                'label' => __('Normal', smw_slug),
            ]
        );

        $this->add_control(
            'arrows_bg_color_normal',
            [
                'label' => __('Background Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_normal',
            [
                'label' => __('Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'arrows_border_normal',
                'label' => __('Border', smw_slug),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev',
            ]
        );

        $this->add_control(
            'arrows_border_radius_normal',
            [
                'label' => __('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_arrows_hover',
            [
                'label' => __('Hover', smw_slug),
            ]
        );

        $this->add_control(
            'arrows_bg_color_hover',
            [
                'label' => __('Background Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label' => __('Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_border_color_hover',
            [
                'label' => __('Border Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next:hover, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'arrows_padding',
            [
                'label' => __('Padding', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-button-next, {{WRAPPER}} .swiper-container-wrap .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Dots
         */
        $this->start_controls_section(
            'section_dots_style',
            [
                'label' => __('Dots', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'dots' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label' => __('Position', smw_slug),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'inside' => __('Inside', smw_slug),
                    'outside' => __('Outside', smw_slug),
                ],
                'default' => 'outside',
            ]
        );

        $this->add_responsive_control(
            'dots_size',
            [
                'label' => __('Size', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 40,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_spacing',
            [
                'label' => __('Spacing', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_dots_style');

        $this->start_controls_tab(
            'tab_dots_normal',
            [
                'label' => __('Normal', smw_slug),
            ]
        );

        $this->add_control(
            'dots_color_normal',
            [
                'label' => __('Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_dot_color_normal',
            [
                'label' => __('Active Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_border_normal',
                'label' => __('Border', smw_slug),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet',
            ]
        );

        $this->add_control(
            'dots_border_radius_normal',
            [
                'label' => __('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_margin',
            [
                'label' => __('Margin', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'allowed_dimensions' => 'vertical',
                'placeholder' => [
                    'top' => '',
                    'right' => 'auto',
                    'bottom' => '',
                    'left' => 'auto',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullets' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_hover',
            [
                'label' => __('Hover', smw_slug),
            ]
        );

        $this->add_control(
            'dots_color_hover',
            [
                'label' => __('Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_border_color_hover',
            [
                'label' => __('Border Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $image = $this->get_settings('member_image');

        $this->add_render_attribute(
            'team-member-carousel-wrap',
            [
                'class' => ['swiper-container-wrap', 'smw-team-member-carousel-wrap'],
            ]
        );

        if ($settings['dots_position']) {
            $this->add_render_attribute('team-member-carousel-wrap', 'class', 'swiper-container-wrap-dots-' . $settings['dots_position']);
        }

        $this->add_render_attribute(
            'team-member-carousel',
            [
                'class' => ['swiper-container', 'smw-tm-wrapper', 'smw-tm-carousel'],
                'id' => 'swiper-container-' . esc_attr($this->get_id()),
                'data-pagination' => '.swiper-pagination-' . esc_attr($this->get_id()),
                'data-arrow-next' => '.swiper-button-next-' . esc_attr($this->get_id()),
                'data-arrow-prev' => '.swiper-button-prev-' . esc_attr($this->get_id()),
            ]
        );

        $this->add_render_attribute('team-member-carousel', 'data-id', 'swiper-container-' . esc_attr($this->get_id()));

        if (!empty($settings['items']['size'])) {
            $this->add_render_attribute('team-member-carousel', 'data-items', $settings['items']['size']);
        }

        if (!empty($settings['items_tablet']['size'])) {
            $this->add_render_attribute('team-member-carousel', 'data-items-tablet', $settings['items_tablet']['size']);
        }

        if (!empty($settings['items_mobile']['size'])) {
            $this->add_render_attribute('team-member-carousel', 'data-items-mobile', $settings['items_mobile']['size']);
        }

        if (!empty($settings['margin']['size'])) {
            $this->add_render_attribute('team-member-carousel', 'data-margin', $settings['margin']['size']);
        }

        if (!empty($settings['margin_tablet']['size'])) {
            $this->add_render_attribute('team-member-carousel', 'data-margin-tablet', $settings['margin_tablet']['size']);
        }

        if (!empty($settings['margin_mobile']['size'])) {
            $this->add_render_attribute('team-member-carousel', 'data-margin-mobile', $settings['margin_mobile']['size']);
        }

        if (!empty($settings['slider_speed']['size'])) {
            $this->add_render_attribute('team-member-carousel', 'data-speed', $settings['slider_speed']['size']);
        }

        if ($settings['autoplay'] == 'yes' && !empty($settings['autoplay_speed']['size'])) {
            $this->add_render_attribute('team-member-carousel', 'data-autoplay', $settings['autoplay_speed']['size']);
        } else {
            $this->add_render_attribute('team-member-carousel', 'data-autoplay', "0");
        }

        if ($settings['infinite_loop'] == 'yes') {
            $this->add_render_attribute('team-member-carousel', 'data-loop', "1");
        }

        if ($settings['grab_cursor'] == 'yes') {
            $this->add_render_attribute('team-member-carousel', 'data-grab-cursor', "1");
        }

        if ($settings['arrows'] == 'yes') {
            $this->add_render_attribute('team-member-carousel', 'data-arrows', "1");
        }

        if ($settings['dots'] == 'yes') {
            $this->add_render_attribute('team-member-carousel', 'data-dots', "1");
        }

        if ($settings['pause_on_hover'] == 'yes') {
            $this->add_render_attribute('team-member-carousel', 'data-pause-on-hover', "1");
        }

        if ($settings['dots_position']) {
            $this->add_render_attribute('team-member-carousel', 'class', 'smw-tm-carousel-dots-' . $settings['dots_position']);
        }

        ?>
        <div <?php echo $this->get_render_attribute_string('team-member-carousel-wrap'); ?>>
            <div <?php echo $this->get_render_attribute_string('team-member-carousel'); ?>>
                    <div class="swiper-wrapper">
                    <?php foreach ($settings['team_member_details'] as $index => $item): ?>
                    <div class="swiper-slide">
                        <div class="smw-tm">
                            <div class="smw-tm-image">
                                <?php echo '<img src="' . $item['team_member_image']['url'] . '" alt="'.esc_attr(get_post_meta($item['team_member_image']['id'], '_wp_attachment_image_alt', true)).'">'; ?>

                                <?php if ($settings['overlay_content'] == 'social_icons') {?>
                                    <div class="smw-tm-overlay-content-wrap">
                                        <div class="smw-tm-content">
                                            <?php
                                                if ($settings['member_social_links'] == 'yes') {
                                                    $this->member_social_links($item);
                                                }
                                            ?>
                                        </div>
                                    </div>
                                <?php }?>

                                <?php if ($settings['overlay_content'] == 'all_content') {?>
                                    <div class="smw-tm-overlay-content-wrap">
                                        <div class="smw-tm-content">
                                            <?php
                                                if ($settings['member_social_links'] == 'yes') {
                                                    if ($settings['social_links_position'] == 'before_desc') {
                                                        $this->member_social_links($item);
                                                    }
                                                }
                                            ?>
                                            <?php $this->render_description($item);?>
                                            <?php
                                                if ($settings['member_social_links'] == 'yes') {
                                                    if ($settings['social_links_position'] == 'after_desc') {
                                                        $this->member_social_links($item);
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                            <?php if ($settings['overlay_content'] == 'all_content') {?>
                                <div class="smw-tm-content smw-tm-content-normal">
                                    <?php
                                        // Name
                                        $this->render_name($item);

                                        // Position
                                        $this->render_position($item);
                                    ?>
                                </div>
                            <?php }?>
                            <?php if ($settings['overlay_content'] != 'all_content') {?>
                                <div class="smw-tm-content smw-tm-content-normal">
                                    <?php $this->render_name($item); ?>
                                    <?php $this->render_position($item);?>
                                    <?php
                                        if ($settings['member_social_links'] == 'yes' && $settings['overlay_content'] == 'none') {
                                            if ($settings['social_links_position'] == 'before_desc') {
                                                $this->member_social_links($item);
                                            }
                                        }
                                    ?>
                                    <?php $this->render_description($item);?>
                                    <?php
                                        if ($settings['member_social_links'] == 'yes' && $settings['overlay_content'] == 'none') {
                                            if ($settings['social_links_position'] == 'after_desc') {
                                                $this->member_social_links($item);
                                            }
                                        }
                                    ?>
                                </div><!-- .smw-tm-content -->
                            <?php }?>
                        </div><!-- .smw-tm -->
                    </div><!-- .swiper-slide -->
                <?php endforeach;?>
                </div>
            </div>
            <?php
$this->render_dots();

        $this->render_arrows();
        ?>
        </div>
        <?php
}

    protected function render_name($item)
    {
        $settings = $this->get_settings_for_display();

        if ($item['team_member_name'] != '') {
            printf('<%1$s class="smw-tm-name">%2$s</%1$s>', $settings['name_html_tag'], $item['team_member_name']);
        }
        ?>
        <?php if ($settings['member_title_divider'] == 'yes') {?>
            <div class="smw-tm-title-divider-wrap">
                <div class="smw-tm-divider smw-tm-title-divider"></div>
            </div>
        <?php }
    }

    protected function render_position($item)
    {
        $settings = $this->get_settings_for_display();

        if ($item['team_member_position'] != '') {
            printf('<%1$s class="smw-tm-position">%2$s</%1$s>', $settings['position_html_tag'], $item['team_member_position']);
        }
        ?>
        <?php if ($settings['member_position_divider'] == 'yes') {?>
            <div class="smw-tm-position-divider-wrap">
                <div class="smw-tm-divider smw-tm-position-divider"></div>
            </div>
        <?php }
    }

    protected function render_description($item)
    {
        $settings = $this->get_settings_for_display();
        if ($item['team_member_description'] != '') {?>
            <div class="smw-tm-description">
                <?php echo $this->parse_text_editor($item['team_member_description']); ?>
            </div>
        <?php }?>
        <?php if ($settings['member_description_divider'] == 'yes') {?>
            <div class="smw-tm-description-divider-wrap">
                <div class="smw-tm-divider smw-tm-description-divider"></div>
            </div>
        <?php }
    }

    private function member_social_links($item)
    {

        $facebook_url = $item['facebook_url'];
        $twitter_url = $item['twitter_url'];
        $google_plus_url = $item['google_plus_url'];
        $linkedin_url = $item['linkedin_url'];
        $instagram_url = $item['instagram_url'];
        $youtube_url = $item['youtube_url'];
        $pinterest_url = $item['pinterest_url'];
        $dribbble_url = $item['dribbble_url'];
        ?>
        <div class="smw-tm-social-links-wrap">
            <ul class="smw-tm-social-links">
                <?php
        if ($facebook_url) {
            printf('<li><a href="%1$s" target="_blank"><span class="smw-tm-social-icon-wrap"><span class="smw-tm-social-icon fa fa-facebook"></span></span></a></li>', esc_url($facebook_url));
        }
        if ($twitter_url) {
            printf('<li><a href="%1$s" target="_blank"><span class="smw-tm-social-icon-wrap"><span class="smw-tm-social-icon fa fa-twitter"></span></span></a></li>', esc_url($twitter_url));
        }
        if ($google_plus_url) {
            printf('<li><a href="%1$s" target="_blank"><span class="smw-tm-social-icon-wrap"><span class="smw-tm-social-icon fa fa-google-plus"></span></span></a></li>', esc_url($google_plus_url));
        }
        if ($linkedin_url) {
            printf('<li><a href="%1$s" target="_blank"><span class="smw-tm-social-icon-wrap"><span class="smw-tm-social-icon fa fa-linkedin"></span></span></a></li>', esc_url($linkedin_url));
        }
        if ($instagram_url) {
            printf('<li><a href="%1$s" target="_blank"><span class="smw-tm-social-icon-wrap"><span class="smw-tm-social-icon fa fa-instagram"></span></span></a></li>', esc_url($instagram_url));
        }
        if ($youtube_url) {
            printf('<li><a href="%1$s" target="_blank"><span class="smw-tm-social-icon-wrap"><span class="smw-tm-social-icon fa fa-youtube"></span></span></a></li>', esc_url($youtube_url));
        }
        if ($pinterest_url) {
            printf('<li><a href="%1$s" target="_blank"><span class="smw-tm-social-icon-wrap"><span class="smw-tm-social-icon fa fa-pinterest"></span></span></a></li>', esc_url($pinterest_url));
        }
        if ($dribbble_url) {
            printf('<li><a href="%1$s" target="_blank"><span class="smw-tm-social-icon-wrap"><span class="smw-tm-social-icon fa fa-dribbble"></span></span></a></li>', esc_url($dribbble_url));
        }
        ?>
            </ul>
        </div>
        <?php
}

    /**
     * Render team member carousel dots output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render_dots()
    {
        $settings = $this->get_settings_for_display();

        if ($settings['dots'] == 'yes') {?>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-<?php echo esc_attr($this->get_id()); ?>"></div>
        <?php }
    }

    /**
     * Render team member carousel arrows output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render_arrows()
    {
        $settings = $this->get_settings_for_display();

        if ($settings['arrows'] == 'yes') {?>
            <?php
if ($settings['arrow']) {
            $pa_next_arrow = $settings['arrow'];
            $pa_prev_arrow = str_replace("right", "left", $settings['arrow']);
        } else {
            $pa_next_arrow = 'fa fa-angle-right';
            $pa_prev_arrow = 'fa fa-angle-left';
        }
            ?>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-next-<?php echo esc_attr($this->get_id()); ?>">
                <i class="<?php echo esc_attr($pa_next_arrow); ?>"></i>
            </div>
            <div class="swiper-button-prev swiper-button-prev-<?php echo esc_attr($this->get_id()); ?>">
                <i class="<?php echo esc_attr($pa_prev_arrow); ?>"></i>
            </div>
        <?php }
    }

    protected function _content_template()
    {}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_team_member_carousel() );