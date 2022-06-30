<?php

/**
 * SMW Advanced Banner.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_advanced_banner extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'advanced-banner-css', plugin_dir_url( __FILE__ ) .  '../css/advanced-banner.css');
        
        wp_register_script( 'tilt-js', plugin_dir_url( __FILE__ ) . '../js/tilt.js' );
        wp_register_script( 'advanced-banner-js', plugin_dir_url( __FILE__ ) . '../js/advanced-banner.js' );
    }
    
    public function get_name()
    {
        return 'stiles-advanced-banner';
    }
    
    public function get_title()
    {
        return 'Advanced Banner';
    }
    
    public function get_icon()
    {
        return 'eicon-banner';
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
        return [ 'advanced-banner-css' ];
    }
    
     public function get_script_depends() 
     {
        return [
            'tilt-js',
            'advanced-banner-js'
        ];
    }
    
    protected function register_controls() 
    {
		$this->start_controls_section('advanced_banner_global_settings',
			[
				'label'         => __( 'Image', smw_slug )
			]
		);
        
        $this->add_control('advanced_banner_image',
			[
				'label'			=> __( 'Upload Image', smw_slug ),
				'description'	=> __( 'Select an image for the Banner', smw_slug ),
				'type'			=> Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
				'default'		=> [
					'url'	=> Utils::get_placeholder_image_src()
				],
				'show_external'	=> true
			]
		);
        
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'          => 'thumbnail',
				'default'       => 'full',
				'separator'     => 'none',
			]
		);
        
        $this->add_control('advanced_banner_link_url_switch',
            [
                'label'         => __('Link', smw_slug),
                'type'          => Controls_Manager::SWITCHER
            ]
        );

		$this->add_control('advanced_banner_image_link_switcher',
			[
				'label'			=> __( 'Custom Link', smw_slug ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __( 'Add a custom link to the banner', smw_slug ),
                'condition'     => [
                    'advanced_banner_link_url_switch'    => 'yes',
                ],
			]
		);
        
        $this->add_control('advanced_banner_image_custom_link',
			[
				'label'			=> __( 'Set custom Link', smw_slug ),
				'type'			=> Controls_Manager::URL,
                'dynamic'       => [ 'active' => true ],
				'description'	=> __( 'What custom link you want to set to banner?', smw_slug ),
				'condition'		=> [
					'advanced_banner_image_link_switcher' => 'yes',
                    'advanced_banner_link_url_switch'    => 'yes'
				],
				'show_external' => false
			]
		);

		$this->add_control('advanced_banner_image_existing_page_link',
			[
				'label'			=> __( 'Existing Page', smw_slug ),
				'type'			=> Controls_Manager::SELECT2,
				'condition'		=> [
					'advanced_banner_image_link_switcher!' => 'yes',
                    'advanced_banner_link_url_switch'    => 'yes'
				],
                'label_block'   => true,
                'multiple'      => false,
				'options'		=> $this->getTemplateInstance()->get_all_posts()
			]
		);
        
        $this->add_control('advanced_banner_link_title',
			[
				'label'			=> __( 'Link Title', smw_slug ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'condition'     => [
                    'advanced_banner_link_url_switch'    => 'yes'
                ]
			]
		);
        

		$this->add_control('advanced_banner_image_link_open_new_tab',
			[
				'label'			=> __( 'New Tab', smw_slug ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __( 'Choose if you want the link be opened in a new tab or not', smw_slug ),
                'condition'     => [
                    'advanced_banner_link_url_switch'    => 'yes'
                ]
			]
		);

		$this->add_control('advanced_banner_image_link_add_nofollow',
			[
				'label'			=> __( 'Nofollow Option', smw_slug ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __('if you choose yes, the link will not be counted in search engines', smw_slug ),
                'condition'     => [
                    'advanced_banner_link_url_switch'    => 'yes'
                ]
			]
		);
        
        $this->add_control('advanced_banner_image_animation',
			[
				'label'			=> __( 'Effect', smw_slug ),
				'type'			=> Controls_Manager::SELECT,
				'default'		=> 'animation1',
				'description'	=> __( 'Choose a hover effect for the banner', smw_slug ),
				'options'		=> [
					'animation1'		=> __('Effect 1', smw_slug),
					'animation5'		=> __('Effect 2', smw_slug),
					'animation13'       => __('Effect 3', smw_slug),
					'animation2'		=> __('Effect 4', smw_slug),
					'animation4'		=> __('Effect 5', smw_slug),
					'animation6'		=> __('Effect 6', smw_slug)
				]
			]
		);
        
        $this->add_control('advanced_banner_active',
			[
				'label'			=> __( 'Always Hovered', smw_slug ),
				'type'			=> Controls_Manager::SWITCHER,
				'description'	=> __( 'Choose if you want the effect to be always triggered', smw_slug )
			]
		);
        
        $this->add_control('advanced_banner_hover_effect',
            [
                'label'         => __('Hover Effect', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'none'          => __('None', smw_slug),
                    'zoomin'        => __('Zoom In', smw_slug),
                    'zoomout'       => __('Zoom Out', smw_slug),
                    'scale'         => __('Scale', smw_slug),
                    'grayscale'     => __('Grayscale', smw_slug),
                    'blur'          => __('Blur', smw_slug),
                    'bright'        => __('Bright', smw_slug),
                    'sepia'         => __('Sepia', smw_slug),
                ],
                'default'       => 'none',
            ]
        );
        
        $this->add_control('advanced_banner_height',
			[
				'label'			=> __( 'Height', smw_slug ),
				'type'			=> Controls_Manager::SELECT,
                'options'		=> [
					'default'		=> __('Default', smw_slug),
					'custom'		=> __('Custom', smw_slug)
				],
				'default'		=> 'default',
				'description'	=> __( 'Choose if you want to set a custom height for the banner or keep it as it is', smw_slug )
			]
		);
        
		$this->add_responsive_control('advanced_banner_custom_height',
			[
				'label'			=> __( 'Min Height', smw_slug ),
				'type'			=> Controls_Manager::NUMBER,
				'description'	=> __( 'Set a minimum height value in pixels', smw_slug ),
				'condition'		=> [
					'advanced_banner_height' => 'custom'
				],
				'selectors'		=> [
					'{{WRAPPER}} .advanced-banner-ib' => 'height: {{VALUE}}px;'
				]
			]
		);
        
        $this->add_responsive_control('advanced_banner_img_vertical_align',
			[
				'label'			=> __( 'Vertical Align', smw_slug ),
				'type'			=> Controls_Manager::SELECT,
				'condition'		=> [
					'advanced_banner_height' => 'custom'
				],
                'options'		=> [
					'flex-start'	=> __('Top', smw_slug),
                    'center'		=> __('Middle', smw_slug),
					'flex-end'		=> __('Bottom', smw_slug),
                    'inherit'		=> __('Full', smw_slug)
				],
                'default'       => 'flex-start',
				'selectors'		=> [
					'{{WRAPPER}} .advanced-banner-img-wrap' => 'align-items: {{VALUE}}; -webkit-align-items: {{VALUE}};'
				]
			]
		);
        
        $this->add_control('mouse_tilt',
            [
                'label'         => __('Enable Mouse Tilt', smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true'
            ]
        );
        
        $this->add_control('mouse_tilt_rev',
            [
                'label'         => __('Reverse', smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
                'condition'     => [
                    'mouse_tilt'    => 'true'
                ]
            ]
        );
     
		$this->add_control('advanced_banner_extra_class',
			[
				'label'			=> __( 'Extra Class', smw_slug ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'description'	=> __( 'Add extra class name that will be applied to the banner, and you can use this class for your customizations.', smw_slug )
			]
		);

		
		$this->end_controls_section();

		$this->start_controls_section('advanced_banner_image_section',
  			[
  				'label' => __( 'Content', smw_slug )
  			]
  		);
        
        $this->add_control('advanced_banner_title',
			[
				'label'			=> __( 'Title', smw_slug ),
				'placeholder'	=> __( 'Give a title to this banner', smw_slug ),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
				'default'		=> __( 'Advanced Banner', smw_slug ),
				'label_block'	=> false
			]
		);
        
        $this->add_control('advanced_banner_title_tag',
			[
				'label'			=> __( 'HTML Tag', smw_slug ),
				'description'	=> __( 'Select a heading tag for the title. Headings are defined with H1 to H6 tags', smw_slug ),
				'type'			=> Controls_Manager::SELECT,
				'default'		=> 'h3',
				'options'       => [
                    'h1'    => 'H1',
                    'h2'    => 'H2',
                    'h3'    => 'H3',
                    'h4'    => 'H4',
                    'h5'    => 'H5',
                    'h6'    => 'H6',
                    'div'   => 'div',
                    'span'  => 'span',
                    'p'     => 'p',
                ],
				'label_block'	=> true,
			]
		);
        
        
        $this->add_control('advanced_banner_description_hint',
			[
				'label'			=> __( 'Description', smw_slug ),
				'type'			=> Controls_Manager::HEADING,
			]
		);
        
        $this->add_control('advanced_banner_description',
			[
				'label'			=> __( 'Description', smw_slug ),
				'description'	=> __( 'Give the description to this banner', smw_slug ),
				'type'			=> Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
				'default'		=> __( 'Advanced Banner gives you a wide range of styles and options that you will definitely fall in love with', smw_slug ),
				'label_block'	=> true
			]
		);
        
        $this->add_control('advanced_banner_link_switcher',
            [
                'label'         => __('Button', smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'advanced_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );

        
        $this->add_control('advanced_banner_more_text', 
            [
                'label'         => __('Text',smw_slug),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => 'Click Here',
                'condition'     => [
                    'advanced_banner_link_switcher'    => 'yes',
                    'advanced_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );
        
        $this->add_control('advanced_banner_link_selection',
            [
                'label'         => __('Link Type', smw_slug),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'url'   => __('URL', smw_slug),
                    'link'  => __('Existing Page', smw_slug),
                ],
                'default'       => 'url',
                'label_block'   => true,
                'condition'     => [
                    'advanced_banner_link_switcher'    => 'yes',
                    'advanced_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );

        $this->add_control('advanced_banner_link',
            [
                'label'         => __('Link', smw_slug),
                'type'          => Controls_Manager::URL,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'   => '#',
                ],
                'placeholder'   => 'https://stiles.media/',
                'label_block'   => true,
                'condition'     => [
                    'advanced_banner_link_selection' => 'url',
                    'advanced_banner_link_switcher'    => 'yes',
                    'advanced_banner_link_url_switch!'   => 'yes'
                ]
            ]
        );
        
        $this->add_control('advanced_banner_existing_link',
            [
                'label'         => __('Existing Page', smw_slug),
                'type'          => Controls_Manager::SELECT2,
                'options'       => $this->getTemplateInstance()->get_all_posts(),
                'multiple'      => false,
                'condition'     => [
                    'advanced_banner_link_selection'     => 'link',
                    'advanced_banner_link_switcher'    => 'yes',
                    'advanced_banner_link_url_switch!'   => 'yes'
                ],
                'label_block'   => true
            ]
        );
        
        
        $this->add_control('advanced_banner_title_text_align', 
            [
                'label'         => __('Alignment', smw_slug),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'  => [
                        'title'     => __('Left', smw_slug),
                        'icon'      => 'fa fa-align-left'
                    ],
                    'center'  => [
                        'title'     => __('Center', smw_slug),
                        'icon'      => 'fa fa-align-center'
                    ],
                    'right'  => [
                        'title'     => __('Right', smw_slug),
                        'icon'      => 'fa fa-align-right'
                    ],
                ],
                'default'       => 'left',
                'toggle'        => false,
                'selectors'     => [
                    '{{WRAPPER}} .advanced-banner-ib-title, {{WRAPPER}} .advanced-banner-ib-content, {{WRAPPER}} .advanced-banner-read-more'   => 'text-align: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('advanced_banner_responsive_section',
            [
                'label'         => __('Responsive', smw_slug),
            ]
        );
        
        $this->add_control('advanced_banner_responsive_switcher',
            [
                'label'         => __('Responsive Controls', smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'description'   => __('If the description text is not suiting well on specific screen sizes, you may enable this option which will hide the description text.', smw_slug)
            ]
        );
        
        $this->add_control('advanced_banner_min_range', 
            [
                'label'     => __('Minimum Size', smw_slug),
                'type'      => Controls_Manager::NUMBER,
                'description'=> __('Note: minimum size for extra small screens is 1px.',smw_slug),
                'default'   => 1,
                'condition' => [
                    'advanced_banner_responsive_switcher'    => 'yes'
                ],
            ]
        );

        $this->add_control('advanced_banner_max_range', 
            [
                'label'     => __('Maximum Size', smw_slug),
                'type'      => Controls_Manager::NUMBER,
                'description'=> __('Note: maximum size for extra small screens is 767px.',smw_slug),
                'default'   => 767,
                'condition' => [
                    'advanced_banner_responsive_switcher'    => 'yes'
                ],
            ]
        );

		$this->end_controls_section();
        
        $this->start_controls_section('advanced_banner_opacity_style',
			[
				'label' 		=> __( 'Image', smw_slug ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);
        
        $this->add_control('advanced_banner_image_bg_color',
			[
				'label' 		=> __( 'Background Color', smw_slug ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors' 	=> [
					'{{WRAPPER}} .advanced-banner-ib' => 'background: {{VALUE}};'
				]
			]
		);
        
		$this->add_control('advanced_banner_image_opacity',
			[
				'label' => __( 'Image Opacity', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1
				],
				'range' => [
					'px' => [
		                'min' => 0,
		                'max' => 1,
		                'step' => .1
		            ]
				],
				'selectors' => [
		            '{{WRAPPER}} .advanced-banner-ib img' => 'opacity: {{SIZE}};'
		        ]
			]
		);

		$this->add_control('advanced_banner_image_hover_opacity',
			[
				'label' => __( 'Hover Opacity', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1
				],
				'range' => [
					'px' => [
		                'min' => 0,
		                'max' => 1,
		                'step' => .1
		            ]
				],
				'selectors' => [
		            '{{WRAPPER}} .advanced-banner-ib img.active' => 'opacity: {{SIZE}};'
		        ]
			]
		);
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .advanced-banner-ib img',
			]
		);
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'hover_css_filters',
                'label'     => __('Hover CSS Filters', smw_slug),
				'selector'  => '{{WRAPPER}} .advanced-banner-ib img.active'
			]
		);

		$this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'advanced_banner_image_border',
                'selector'      => '{{WRAPPER}} .advanced-banner-ib'
            ]
        );

		$this->add_responsive_control(
			'advanced_banner_image_border_radius',
			[
				'label' => __( 'Border Radius', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'size_units'    => ['px', '%' ,'em'],
				'selectors' => [
		            '{{WRAPPER}} .advanced-banner-ib' => 'border-radius: {{SIZE}}{{UNIT}};'
		        ]
			]
		);
        
        $this->add_control('blend_mode',
			[
				'label'     => __( 'Blend Mode', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''              => __( 'Normal', 'elementor' ),
					'multiply'      => 'Multiply',
					'screen'        => 'Screen',
					'overlay'       => 'Overlay',
					'darken'        => 'Darken',
					'lighten'       => 'Lighten',
					'color-dodge'   => 'Color Dodge',
					'saturation'    => 'Saturation',
					'color'         => 'Color',
					'luminosity'    => 'Luminosity',
				],
                'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .advanced-banner-ib' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('advanced_banner_title_style',
			[
				'label' 		=> __( 'Title', smw_slug ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control('advanced_banner_color_of_title',
			[
				'label' => __( 'Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1
				],
				'selectors' => [
					'{{WRAPPER}} .advanced-banner-ib-desc .advanced_banner_title' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'advanced_banner_title_typography',
				'selector' => '{{WRAPPER}} .advanced-banner-ib-desc .advanced_banner_title',
				'scheme' => Typography::TYPOGRAPHY_1
			]
		);
        
        $this->add_control('advanced_banner_style2_title_bg',
			[
				'label'			=> __( 'Background', smw_slug ),
				'type'			=> Controls_Manager::COLOR,
				'default'       => '#f2f2f2',
				'description'	=> __( 'Choose a background color for the title', smw_slug ),
				'condition'		=> [
					'advanced_banner_image_animation' => 'animation5'
				],
				'selectors'     => [
				    '{{WRAPPER}} .advanced-banner-animation5 .advanced-banner-ib-desc'    => 'background: {{VALUE}};',
			    ]
			]
		);

		$this->add_control('advanced_banner_style3_title_border',
			[
				'label'			=> __( 'Title Border Color', smw_slug ),
				'type'			=> Controls_Manager::COLOR,
				'condition'		=> [
					'advanced_banner_image_animation' => 'animation13'
				],
				'selectors'     => [
				    '{{WRAPPER}} .advanced-banner-animation13 .advanced-banner-ib-title::after'    => 'background: {{VALUE}};',
			    ]
			]
		);

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => __('Shadow',smw_slug),
                'name'              => 'advanced_banner_title_shadow',
                'selector'          => '{{WRAPPER}} .advanced-banner-ib-desc .advanced_banner_title'
            ]
        );
        
        $this->add_responsive_control('advanced_banner_title_margin',
            [
                'label'         => __('Margin', smw_slug),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-banner-ib-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section('advanced_banner_styles_of_content',
			[
				'label' 		=> __( 'Description', smw_slug ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control('advanced_banner_color_of_content',
			[
				'label' => __( 'Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_3
				],
				'selectors' => [
					'{{WRAPPER}} .advanced-banner .advanced_banner_content' => 'color: {{VALUE}};'
				],
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'advanced_banner_content_typhography',
				'selector'      => '{{WRAPPER}} .advanced-banner .advanced_banner_content',
				'scheme'        => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control('advanced_banner_scaled_border_color',
			[
				'label' => __( 'Inner Border Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'condition'		=> [
					'advanced_banner_image_animation' => ['animation4', 'animation6']
				],
				'selectors' => [
					'{{WRAPPER}} .advanced-banner-animation4 .advanced-banner-ib-desc::after, {{WRAPPER}} .advanced-banner-animation4 .advanced-banner-ib-desc::before, {{WRAPPER}} .advanced-banner-animation6 .advanced-banner-ib-desc::before' => 'border-color: {{VALUE}};'
				],
			]
		);

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => __('Shadow',smw_slug),
                'name'              => 'advanced_banner_description_shadow',
                'selector'          => '{{WRAPPER}} .advanced-banner .advanced_banner_content',
            ]
        );
        
        $this->add_responsive_control('advanced_banner_desc_margin',
            [
                'label'         => __('Margin', smw_slug),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-banner-ib-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
		$this->end_controls_section();
        
        $this->start_controls_section('advanced_banner_styles_of_button',
			[
				'label' 		=> __( 'Button', smw_slug ),
				'tab' 			=> Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'advanced_banner_link_switcher'   => 'yes',
                    'advanced_banner_link_url_switch!'   => 'yes'
                ]
			]
		);

		$this->add_control('advanced_banner_color_of_button',
			[
				'label' => __( 'Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_3
				],
				'selectors' => [
					'{{WRAPPER}} .advanced-banner .advanced-banner-link' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_control('advanced_banner_hover_color_of_button',
			[
				'label' => __( 'Hover Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .advanced-banner .advanced-banner-link:hover' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'advanced_banner_button_typhography',
                'scheme'        => Typography::TYPOGRAPHY_3,
				'selector'      => '{{WRAPPER}} .advanced-banner-link',
			]
		);
        
        $this->add_control('advanced_banner_backcolor_of_button',
			[
				'label' => __( 'Background Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .advanced-banner .advanced-banner-link' => 'background-color: {{VALUE}};'
				],
			]
		);
        
        $this->add_control('advanced_banner_hover_backcolor_of_button',
			[
				'label' => __( 'Hover Background Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .advanced-banner .advanced-banner-link:hover' => 'background-color: {{VALUE}};'
				]
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'advanced_banner_button_border',
                'selector'      => '{{WRAPPER}} .advanced-banner .advanced-banner-link'
            ]
        );
        
        $this->add_control('advanced_banner_button_border_radius',
            [
                'label'         => __('Border Radius', smw_slug),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-banner-link' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'             => __('Shadow',smw_slug),
                'name'              => 'advanced_banner_button_shadow',
                'selector'          => '{{WRAPPER}} .advanced-banner .advanced-banner-link',
            ]
        );
        
        $this->add_responsive_control('advanced_banner_button_margin',
            [
                'label'         => __('Margin', smw_slug),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-banner-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('advanced_banner_button_padding',
            [
                'label'         => __('Padding', smw_slug),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-banner-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->end_controls_section();
        
        $this->start_controls_section('advanced_banner_container_style',
			[
				'label' 		=> __( 'Container', smw_slug ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'advanced_banner_border',
                'selector'      => '{{WRAPPER}} .advanced-banner'
            ]
        );
        
        $this->add_control('advanced_banner_border_radius',
            [
                'label'         => __('Border Radius', smw_slug),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .advanced-banner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'advanced_banner_shadow',
                'selector'      => '{{WRAPPER}} .advanced-banner',
            ]
        );
        
        $this->end_controls_section();

	}


	protected function render() 
	{
        
			$settings 	= $this->get_settings_for_display();
            
            $this->add_render_attribute( 'banner', 'id', 'advanced-banner-' . $this->get_id() );
            $this->add_render_attribute( 'banner', 'class', 'advanced-banner' );
            
            if( 'true' === $settings['mouse_tilt'] ) {
                $this->add_render_attribute( 'banner', 'data-box-tilt', 'true' );
                if( 'true' === $settings['mouse_tilt_rev'] ) {
                    $this->add_render_attribute( 'banner', 'data-box-tilt-reverse', 'true' );
                }
            }
            
           
            $this->add_inline_editing_attributes('advanced_banner_title');
            $this->add_render_attribute('advanced_banner_title', 'class', array(
                'advanced-banner-ib-title',
                'advanced_banner_title'
            ));
            
            $this->add_inline_editing_attributes('advanced_banner_description', 'advanced');

			$title_tag 	= $settings[ 'advanced_banner_title_tag' ];
			$title 		= $settings[ 'advanced_banner_title' ];
			$full_title = '<div class="advanced-banner-title-wrap"><'. $title_tag . ' ' . $this->get_render_attribute_string('advanced_banner_title') .'>' .$title. '</'.$title_tag.'></div>';

			$link = 'yes' == $settings['advanced_banner_image_link_switcher'] ? $settings['advanced_banner_image_custom_link']['url'] : get_permalink( $settings['advanced_banner_image_existing_page_link'] );

			$link_title = $settings['advanced_banner_link_url_switch'] === 'yes' ? $settings['advanced_banner_link_title'] : '';
            
			$open_new_tab = $settings['advanced_banner_image_link_open_new_tab'] == 'yes' ? ' target="_blank"' : '';
            $nofollow_link = $settings['advanced_banner_image_link_add_nofollow'] == 'yes' ? ' rel="nofollow"' : '';
			$full_link = '<a class="advanced-banner-ib-link" href="'. $link .'" title="'. $link_title .'"'. $open_new_tab . $nofollow_link . '></a>';
			$animation_class = 'advanced-banner-' . $settings['advanced_banner_image_animation'];
            $hover_class = ' ' . $settings['advanced_banner_hover_effect'];
			$extra_class = ! empty( $settings['advanced_banner_extra_class'] ) ? ' '. $settings['advanced_banner_extra_class'] : '';
			$active = $settings['advanced_banner_active'] == 'yes' ? ' active' : '';
			$full_class = $animation_class.$hover_class.$extra_class.$active;
            $min_size = $settings['advanced_banner_min_range'] .'px';
            $max_size = $settings['advanced_banner_max_range'] .'px';


            $banner_url = 'url' == $settings['advanced_banner_link_selection'] ? $settings['advanced_banner_link']['url'] : get_permalink( $settings['advanced_banner_existing_link'] );
            
            $image_html = '';
            if ( ! empty( $settings['advanced_banner_image']['url'] ) ) {
                
                $this->add_render_attribute( 'image', 'src', $settings['advanced_banner_image']['url'] );
                $this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $settings['advanced_banner_image'] ) );
                
                $this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $settings['advanced_banner_image'] ) );

                $image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'advanced_banner_image' );
                
            }
            
        ?>
            <div <?php echo $this->get_render_attribute_string('banner'); ?>>
				<div class="advanced-banner-ib <?php echo $full_class; ?> advanced-banner-min-height">
					<?php if( ! empty(  $settings['advanced_banner_image']['url'] ) ) : ?>
                        <?php if( $settings['advanced_banner_height'] == 'custom' ) : ?>
                            <div class="advanced-banner-img-wrap">
                        <?php endif;
                            echo $image_html;
                        if( $settings['advanced_banner_height'] == 'custom' ): ?>
                            </div>
                        <?php endif;
					endif; ?>
					<div class="advanced-banner-ib-desc">
						<?php echo $full_title;
                        if( ! empty( $settings['advanced_banner_description'] ) ) : ?>
                            <div class="advanced-banner-ib-content advanced_banner_content">
                                <div <?php echo $this->get_render_attribute_string('advanced_banner_description'); ?>><?php echo $settings[ 'advanced_banner_description' ]; ?></div>
                            </div>
                        <?php endif;
                    if( 'yes' == $settings['advanced_banner_link_switcher'] && !empty( $settings['advanced_banner_more_text'] ) ) : ?>
                        
                            <div class ="advanced-banner-read-more">
                                <a class = "advanced-banner-link" <?php if( !empty( $banner_url ) ) : ?> href="<?php echo $banner_url; ?>"<?php endif;?><?php if( !empty( $settings['advanced_banner_link']['is_external'] ) ) : ?> target="_blank" <?php endif; ?><?php if( !empty($settings['advanced_banner_link']['nofollow'] ) ) : ?> rel="nofollow" <?php endif; ?>><?php echo esc_html( $settings['advanced_banner_more_text'] ); ?></a>
                            </div>
                        
                    <?php endif; ?>
					</div>
					<?php 
						if( $settings['advanced_banner_link_url_switch'] === 'yes' && ( ! empty( $settings['advanced_banner_image_custom_link']['url'] ) || !empty( $settings['advanced_banner_image_existing_page_link'] ) ) ) {
							echo $full_link;
						}
					 ?>
				</div>
                <?php if($settings['advanced_banner_responsive_switcher'] == 'yes' ) : ?>
                <style>
                    @media( min-width: <?php echo $min_size; ?> ) and (max-width:<?php echo $max_size; ?> ) {
                    #advanced-banner-<?php echo esc_attr( $this->get_id() ); ?> .advanced-banner-ib-content {
                        display: none;
                        }  
                    }
                </style>
                <?php endif; ?>
			</div>
		<?php
	}

	protected function _content_template() {
        ?>
        <#

            view.addRenderAttribute( 'banner', 'id', 'advanced-banner-' + view.getID() );
            view.addRenderAttribute( 'banner', 'class', 'advanced-banner' );
            
            if( 'true' === settings.mouse_tilt ) {
                view.addRenderAttribute( 'banner', 'data-box-tilt', 'true' );
                if( 'true' === settings.mouse_tilt_rev ) {
                    view.addRenderAttribute( 'banner', 'data-box-tilt-reverse', 'true' );
                }
            }
            
            var active = 'yes' === settings.advanced_banner_active ? 'active' : '';
            
            view.addRenderAttribute( 'banner_inner', 'class', [
                'advanced-banner-ib',
                'advanced-banner-min-height',
                'advanced-banner-' + settings.advanced_banner_image_animation,
                settings.advanced_banner_hover_effect,
                settings.advanced_banner_extra_class,
                active
            ] );
            
            var titleTag = settings.advanced_banner_title_tag,
                title    = settings.advanced_banner_title;
                
            view.addRenderAttribute( 'advanced_banner_title', 'class', [
                'advanced-banner-ib-title',
                'advanced_banner_title'
            ] );
            
            view.addInlineEditingAttributes( 'advanced_banner_title' );
            
            var description = settings.advanced_banner_description;
            
            view.addInlineEditingAttributes( 'description', 'advanced' );
            
            var linkSwitcher = settings.advanced_banner_link_switcher,
                readMore     = settings.advanced_banner_more_text,
                bannerUrl    = 'url' === settings.advanced_banner_link_selection ? settings.advanced_banner_link.url : settings.advanced_banner_existing_link;
                
            var bannerLink = 'yes' === settings.advanced_banner_image_link_switcher ? settings.advanced_banner_image_custom_link.url : settings.advanced_banner_image_existing_page_link,
                linkTitle = 'yes' === settings.advanced_banner_link_url_switch ? settings.advanced_banner_link_title : '';
                
            var minSize = settings.advanced_banner_min_range + 'px',
                maxSize = settings.advanced_banner_max_range + 'px';
                
            var imageHtml = '';
            if ( settings.advanced_banner_image.url ) {
                var image = {
                    id: settings.advanced_banner_image.id,
                    url: settings.advanced_banner_image.url,
                    size: settings.thumbnail_size,
                    dimension: settings.thumbnail_custom_dimension,
                    model: view.getEditModel()
                };

                var image_url = elementor.imagesManager.getImageUrl( image );

                imageHtml = '<img src="' + image_url + '"/>';

            }
        #>
        
            <div {{{ view.getRenderAttributeString( 'banner' ) }}}>
				<div {{{ view.getRenderAttributeString( 'banner_inner' ) }}}>
					<# if( '' !== settings.advanced_banner_image.url ) { #>
                        <# if( 'custom' === settings.advanced_banner_height ) { #>
                            <div class="advanced-banner-img-wrap">
                        <# } #>
                            {{{imageHtml}}}
                        <# if( 'custom' === settings.advanced_banner_height ) { #>
                            </div>
                        <# } #>
                    <# } #>
					<div class="advanced-banner-ib-desc">
                        <# if( '' !== title ) { #>
                            <div class="advanced-banner-title-wrap">
                                <{{{titleTag}}} {{{ view.getRenderAttributeString('advanced_banner_title') }}}>{{{ title }}}</{{{titleTag}}}>
                            </div>
                        <# } #>
                        <# if( '' !== description ) { #>
                            <div class="advanced-banner-ib-content advanced_banner_content">
                                <div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ description }}}</div>
                            </div>
                        <# } #>
                    <# if( 'yes' === linkSwitcher && '' !== readMore ) { #>
                        <div class ="advanced-banner-read-more">
                            <a class = "advanced-banner-link" href="{{ bannerUrl }}">{{{ readMore }}}</a>
                        </div>
                    <# } #>
					</div>
					<# if( 'yes' === settings.advanced_banner_link_url_switch  && ( '' !== settings.advanced_banner_image_custom_link.url || '' !== settings.advanced_banner_image_existing_page_link ) ) { #>
							<a class="advanced-banner-ib-link" href="{{ bannerLink }}" title="{{ linkTitle }}"></a>
                    <# } #>
				</div>
                <# if( 'yes' === settings.advanced_banner_responsive_switcher ) { #>
                <style>
                    @media( min-width: {{minSize}} ) and ( max-width: {{maxSize}} ) {
                        #advanced-banner-{{ view.getID() }} .advanced-banner-ib-content {
                            display: none;
                        }  
                    }
                </style>
                <# } #>
            </div>
        
        
        <?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_advanced_banner() );