<?php

/**
 * SMW Off Canvas.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_off_canvas extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'off-canvas-css', plugin_dir_url( __FILE__ ) .  '../css/off-canvas.css');
        
        wp_register_script( 'off-canvas-js', plugin_dir_url( __FILE__ ) . '../js/off-canvas.js' );
        wp_register_script( 'off-canvas-handler', plugin_dir_url( __FILE__ ) . '../js/off-canvas-handler.js' );
    }
    
    public function get_name()
    {
        return 'stiles-off-canvas';
    }
    
    public function get_title()
    {
        return 'Off Canvas';
    }
    
    public function get_icon()
    {
        return 'eicon-menu-bar';
    }
    
    public function get_categories()
    {
        return ['stiles-media-category'];
    }
    
    public function get_script_depends() 
    {
        return [ 
            'off-canvas-js',
            'off-canvas-handler'
        ];
    }
    
    public function get_style_depends() 
    {
        return [ 'off-canvas-css' ];
    }
    
    protected function register_controls()
    {

        /*--------------------------------------*/
        ##  CONTENT TAB    ##
        /*--------------------------------------*/

        /**
         * Content Tab: Offcanvas
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_content_offcanvas',
            [
                'label' => __('Offcanvas Content', smw_slug),
            ]
        );

        $this->add_control(
            'smw_offcanvas_title',
            [
                'label'                 => __( 'Title', smw_slug ),
                'type'                  => Controls_Manager::TEXT,
                'dynamic'               => [
                    'active'   => true,
                ],
                'default'               => '',
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'content_type',
            [
                'label' => __('Content Type', smw_slug),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'sidebar' => __('Sidebar', smw_slug),
                    'custom' => __('Custom Content', smw_slug),
                    'section' => __('Saved Section', smw_slug),
                    'widget' => __('Saved Widget', smw_slug),
                    'template' => __('Saved Page Template', smw_slug),
                ],
                'default' => 'custom',
            ]
        );

        $registered_sidebars = SMW_Helper::get_registered_sidebars();
        
        $this->add_control(
            'sidebar',
            [
                'label' => __('Choose Sidebar', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => array_shift($registered_sidebars),
                'options' => $registered_sidebars,
                'condition' => [
                    'content_type' => 'sidebar',
                ],
            ]
        );

        $this->add_control(
            'saved_widget',
            [
                'label' => __('Choose Widget', smw_slug),
                'type' => Controls_Manager::SELECT,
                'options' => SMW_Helper::get_saved_data('widget'),
                'default' => '-1',
                'condition' => [
                    'content_type' => 'widget',
                ],
            ]
        );

        $this->add_control(
            'saved_section',
            [
                'label' => __('Choose Section', smw_slug),
                'type' => Controls_Manager::SELECT,
                'options' => SMW_Helper::get_saved_data('section'),
                'default' => '-1',
                'condition' => [
                    'content_type' => 'section',
                ],
            ]
        );

        $this->add_control(
            'templates',
            [
                'label' => __('Choose Template', smw_slug),
                'type' => Controls_Manager::SELECT,
                'options' => SMW_Helper::get_saved_data('page'),
                'default' => '-1',
                'condition' => [
                    'content_type' => 'template',
                ],
            ]
        );

        $this->add_control(
            'custom_content',
            [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'title' => __('Box 1', smw_slug),
                        'description' => __('Text box description goes here', smw_slug),
                    ],
                    [
                        'title' => __('Box 2', smw_slug),
                        'description' => __('Text box description goes here', smw_slug),
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => __('Title', smw_slug),
                        'type' => Controls_Manager::TEXT,
                        'dynamic' => [
                            'active' => true,
                        ],
                        'default' => __('Title', smw_slug),
                    ],
                    [
                        'name' => 'description',
                        'label' => __('Description', smw_slug),
                        'type' => Controls_Manager::WYSIWYG,
                        'dynamic' => [
                            'active' => true,
                        ],
                        'default' => '',
                    ],
                ],
                'title_field' => '{{{ title }}}',
                'condition' => [
                    'content_type' => 'custom',
                ],
            ]
        );

        $this->end_controls_section(); #section_content_offcanvas

        /**
         * Content Tab: Toggle Button
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_button_settings',
            [
                'label' => __('Toggle Button', smw_slug),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', smw_slug),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __('Click Here', smw_slug),
            ]
        );

        $this->add_control(
            'button_icon_new',
            [
                'label' => __('Button Icon', smw_slug),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'button_icon',
            ]
        );

        $this->add_control(
            'button_icon_position',
            [
                'label' => __('Icon Position', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'before',
                'options' => [
                    'before' => __('Before', smw_slug),
                    'after' => __('After', smw_slug),
                ],
                'prefix_class' => 'smw-offcanvas-icon-',
                'condition' => [
                    'button_icon!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_icon_spacing',
            [
                'label' => __('Icon Spacing', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '5',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}}.smw-offcanvas-icon-before .smw-offcanvas-toggle-icon' => 'margin-right: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.smw-offcanvas-icon-after .smw-offcanvas-toggle-icon' => 'margin-left: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'button_icon!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Settings
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Settings', smw_slug),
            ]
        );

        $this->add_control(
            'direction',
            [
                'label' => __('Direction', smw_slug),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'toggle' => false,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => __('Left', smw_slug),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', smw_slug),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'content_transition',
            [
                'label' => __('Content Transition', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => __('Slide', smw_slug),
                    'reveal' => __('Reveal', smw_slug),
                    'push' => __('Push', smw_slug),
                    'slide-along' => __('Slide Along', smw_slug),
                ],
                'frontend_available' => true,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'open_offcanvas_default',
            [
                'label' => __('Open OffCanvas by Default', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __('Yes', smw_slug),
                'label_off' => __('No', smw_slug),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'close_button',
            [
                'label' => __('Show Close Button', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', smw_slug),
                'label_off' => __('No', smw_slug),
                'return_value' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'esc_close',
            [
                'label' => __('Esc to Close', smw_slug),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', smw_slug),
                'label_off' => __('No', smw_slug),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'body_click_close',
            [
                'label' => __('Click anywhere to Close', smw_slug),
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
         * Style Tab: Offcanvas Bar
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_offcanvas_bar_style',
            [
                'label' => __('Offcanvas Bar', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
			'offcanvas_width',
			[
				'label' => __( 'Width', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 700,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors' => [
                    '.smw-offcanvas-content-{{ID}}' => 'width: {{SIZE}}{{UNIT}};',
                    '.smw-offcanvas-content-open.smw-offcanvas-content-left .smw-offcanvas-container-{{ID}}'  => 'transform: translate3d({{SIZE}}{{UNIT}}, 0, 0);',
                    '.smw-offcanvas-content-open.smw-offcanvas-content-right .smw-offcanvas-container-{{ID}}'  => 'transform: translate3d(-{{SIZE}}{{UNIT}}, 0, 0);'
				],
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'offcanvas_bar_bg',
                'label' => __('Background', smw_slug),
                'types' => ['classic', 'gradient'],
                'selector' => '.smw-offcanvas-content-{{ID}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'offcanvas_bar_border',
                'label' => __('Border', smw_slug),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '.smw-offcanvas-content-{{ID}}',
            ]
        );

        $this->add_control(
            'offcanvas_bar_border_radius',
            [
                'label' => __('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'offcanvas_bar_padding',
            [
                'label' => __('Padding', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'offcanvas_bar_box_shadow',
                'selector' => '.smw-offcanvas-content-{{ID}}',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Content
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_popup_content_style',
            [
                'label' => __('Content', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_responsive_control(
            'content_align',
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
                    'justify' => [
                        'title' => __('Justified', smw_slug),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-body' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'widget_heading',
            [
                'label' => __('Box', smw_slug),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_control(
            'widgets_bg_color',
            [
                'label' => __('Background Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-custom-widget, .smw-offcanvas-content-{{ID}} .widget' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'widgets_border',
                'label' => __('Border', smw_slug),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '.smw-offcanvas-content-{{ID}} .smw-offcanvas-custom-widget, .smw-offcanvas-content-{{ID}} .widget',
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_control(
            'widgets_border_radius',
            [
                'label' => __('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-custom-widget, .smw-offcanvas-content-{{ID}} .widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_responsive_control(
            'widgets_bottom_spacing',
            [
                'label' => __('Bottom Spacing', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '20',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-custom-widget, .smw-offcanvas-content-{{ID}} .widget' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_responsive_control(
            'widgets_padding',
            [
                'label' => __('Padding', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-custom-widget, .smw-offcanvas-content-{{ID}} .widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_control(
            'text_heading',
            [
                'label' => __('Text', smw_slug),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_control(
            'content_text_color',
            [
                'label' => __('Text Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-body, .smw-offcanvas-content-{{ID}} .smw-offcanvas-body *:not(.fas):not(.eicon):not(.fab):not(.far):not(.fa)' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => __('Typography', smw_slug),
                'scheme' => Typography::TYPOGRAPHY_4,
                'selector' => '.smw-offcanvas-content-{{ID}} .smw-offcanvas-body, .smw-offcanvas-content-{{ID}} .smw-offcanvas-body *:not(.fas):not(.eicon):not(.fab):not(.far):not(.fa)',
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_control(
            'links_heading',
            [
                'label' => __('Links', smw_slug),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->start_controls_tabs('tabs_links_style');

        $this->start_controls_tab(
            'tab_links_normal',
            [
                'label' => __('Normal', smw_slug),
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_control(
            'content_links_color',
            [
                'label' => __('Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-body a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'links_typography',
                'label' => __('Typography', smw_slug),
                'scheme' => Typography::TYPOGRAPHY_4,
                'selector' => '.smw-offcanvas-content-{{ID}} .smw-offcanvas-body a',
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_links_hover',
            [
                'label' => __('Hover', smw_slug),
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->add_control(
            'content_links_color_hover',
            [
                'label' => __('Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-body a:hover' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'content_type' => ['sidebar', 'custom'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Offcanvas Title
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_offcanvas_title_style',
            [
                'label' => __('Offcanvas Title', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'offcanvas_title_color',
            [
                'label' => __('Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-title h3' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'smw_offcanvas_title_typography',
                'label' => __('Typography', smw_slug),
                'scheme' => Typography::TYPOGRAPHY_4,
                'selector' => '.smw-offcanvas-content-{{ID}} .smw-offcanvas-title h3',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Icon
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => __('Icon', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'trigger' => 'on-click',
                    'trigger_type!' => 'button',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-trigger-icon' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'trigger' => 'on-click',
                    'trigger_type' => 'icon',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Size', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '28',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .smw-trigger-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'trigger' => 'on-click',
                    'trigger_type' => 'icon',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_image_width',
            [
                'label' => __('Width', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1200,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .smw-trigger-image' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'trigger' => 'on-click',
                    'trigger_type' => 'image',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Toggle Button
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_toggle_button_style',
            [
                'label' => __('Toggle Button', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'button_align',
            [
                'label' => __('Alignment', smw_slug),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => __('Left', smw_slug),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', smw_slug),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', smw_slug),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .smw-offcanvas-toggle-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => __('Size', smw_slug),
                'type' => Controls_Manager::SELECT,
                'default' => 'md',
                'options' => [
                    'xs' => __('Extra Small', smw_slug),
                    'sm' => __('Small', smw_slug),
                    'md' => __('Medium', smw_slug),
                    'lg' => __('Large', smw_slug),
                    'xl' => __('Extra Large', smw_slug),
                ],
            ]
        );

        $this->add_responsive_control(
            'toggle_button_icon_size',
            [
                'label' => __('Icon Size', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '28',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .smw-offcanvas-toggle-wrap .smw-offcanvas-toggle-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .smw-offcanvas-toggle-wrap .smw-offcanvas-toggle-icon.smw-offcanvas-toggle-svg-icon' => 'width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'toggle_button_icon_space',
            [
                'label' => __('Icon Space', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '10',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .smw-offcanvas-toggle-wrap .smw-offcanvas-toggle-icon' => 'margin-right: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .smw-offcanvas-toggle-wrap .smw-offcanvas-toggle-icon.smw-offcanvas-toggle-svg-icon' => 'right: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __('Normal', smw_slug),
            ]
        );

        $this->add_control(
            'button_bg_color_normal',
            [
                'label' => __('Background Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-offcanvas-toggle' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_normal',
            [
                'label' => __('Text Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-offcanvas-toggle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_normal',
                'label' => __('Border', smw_slug),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .smw-offcanvas-toggle',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .smw-offcanvas-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Typography', smw_slug),
                'scheme' => Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .smw-offcanvas-toggle',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', smw_slug),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .smw-offcanvas-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .smw-offcanvas-toggle',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __('Hover', smw_slug),
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => __('Background Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-offcanvas-toggle:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => __('Text Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-offcanvas-toggle:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label' => __('Border Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .smw-offcanvas-toggle:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_animation',
            [
                'label' => __('Animation', smw_slug),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow_hover',
                'selector' => '{{WRAPPER}} .smw-offcanvas-toggle:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Close Button
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_close_button_style',
            [
                'label' => __('Close Button', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'close_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'close_button_icon_new',
            [
                'label' => __('Button Icon', smw_slug),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'close_button_icon',
                'default' => [
                    'value' => 'fas fa-times',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'close_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'close_button_text_color',
            [
                'label' => __('Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '.smw-offcanvas-close-{{ID}}' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'close_button' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'close_button_size',
            [
                'label' => __('Size', smw_slug),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '28',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-close-{{ID}}' => 'font-size: {{SIZE}}{{UNIT}}',
                    '.smw-offcanvas-content-{{ID}} .smw-offcanvas-close-{{ID}} .smw-offcanvas-close-svg-icon'    => 'width: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'close_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Overlay
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_overlay_style',
            [
                'label' => __('Overlay', smw_slug),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'overlay_bg_color',
            [
                'label' => __('Color', smw_slug),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}}-open .smw-offcanvas-container:after' => 'background: {{VALUE}}',
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
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '.smw-offcanvas-content-{{ID}}-open .smw-offcanvas-container:after' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render_close_button()
    {
        $settings = $this->get_settings_for_display();

        if ($settings['close_button'] != 'yes') {
            return;
        }

        $this->add_render_attribute(
            'close-button', 'class',
            [
                'smw-offcanvas-close',
                'smw-offcanvas-close-' . esc_attr($this->get_id()),
            ]
        );

        $this->add_render_attribute('close-button', 'role', 'button');
        ?>
        <div class="smw-offcanvas-header">
            <div class="smw-offcanvas-title">
                <h3><?php echo esc_html($settings['smw_offcanvas_title']); ?></h3>
            </div>
            <div <?php echo $this->get_render_attribute_string('close-button'); ?>>
                <?php if (isset($settings['__fa4_migrated']['close_button_icon_new']) || empty($settings['close_button_icon'])) {?>
                    <?php if( isset($settings['close_button_icon_new']['value']['url']) ) : ?>
                        <img class="smw-offcanvas-close-svg-icon" src="<?php echo esc_url($settings['close_button_icon_new']['value']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($settings['close_button_icon_new']['value']['id'], '_wp_attachment_image_alt', true)); ?>">
                    <?php else : ?>
                        <span class="<?php echo esc_attr($settings['close_button_icon_new']['value']); ?>"></span>
                    <?php endif; ?>
                <?php } else { ?>
                    <span class="<?php echo esc_attr($settings['close_button_icon']); ?>"></span>
                <?php } ?>
            </div>
        </div>
        <?php
    }

    protected function render_sidebar()
    {
        $settings = $this->get_settings_for_display();
        $sidebar = $settings['sidebar'];

        if (empty($sidebar)) {
            return;
        }

        dynamic_sidebar($sidebar);
    }

    protected function render_custom_content()
    {
        $settings = $this->get_settings_for_display();

        if (count($settings['custom_content'])) 
        {
            foreach ($settings['custom_content'] as $key => $item) 
            {
                ?>
                <div class="smw-offcanvas-custom-widget">
                    <h3 class="smw-offcanvas-widget-title"><?php echo $item['title']; ?></h3>
                    <div class="smw-offcanvas-widget-content">
                        <?php echo $item['description']; ?>
                    </div>
                </div>
                <?php
            }
        }
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $setting_attr = [
            'content_id'       => esc_attr($this->get_id()),
            'direction'        => esc_attr($settings['direction']),
            'transition'       => esc_attr($settings['content_transition']),
            'esc_close'        => esc_attr($settings['esc_close']),
            'body_click_close' => esc_attr($settings['body_click_close']),
            'open_offcanvas'   => esc_attr($settings['open_offcanvas_default']),
        ];

        $this->add_render_attribute(
            'content-wrap',
            [
                'class' => 'smw-offcanvas-content-wrap',
                'data-settings' => htmlspecialchars(json_encode($setting_attr)),
            ]
        );

        $this->add_render_attribute(
            'content',
            [
                'class' => [
                    'smw-offcanvas-content',
                    'smw-offcanvas-content-' . esc_attr($this->get_id()),
                    'smw-offcanvas-' . $setting_attr['transition'],
                    'elementor-element-' . $this->get_id(),
                    'smw-offcanvas-content-' . $setting_attr['direction'],
                ],
            ]
        );

        $this->add_render_attribute(
            'toggle-button',
            [
                'class' => [
                    'smw-offcanvas-toggle',
                    'smw-offcanvas-toogle-' . esc_attr($this->get_id()),
                    'elementor-button',
                    'elementor-size-' . esc_attr($settings['button_size']),
                ],
            ]
        );

        if ($settings['button_animation']) {
            $this->add_render_attribute('toggle-button', 'class', 'elementor-animation-' . esc_attr($settings['button_animation']));
        }

        ?>
        <div <?php echo $this->get_render_attribute_string('content-wrap'); ?>>

            <?php if ($settings['button_text'] != '' || $settings['button_text'] != ''): ?>
            <div class="smw-offcanvas-toggle-wrap">
                <div <?php echo $this->get_render_attribute_string('toggle-button'); ?>>
                    <?php if (isset($settings['__fa4_migrated']['button_icon_new']) || empty($settings['button_icon'])) {?>
                        <?php if( isset($settings['button_icon_new']['value']['url']) ) : ?>
                            <img class="smw-offcanvas-toggle-icon smw-offcanvas-toggle-svg-icon" src="<?php echo esc_url($settings['button_icon_new']['value']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($settings['button_icon_new']['value']['id'], '_wp_attachment_image_alt', true)); ?>">
                        <?php else : ?>
                            <span class="smw-offcanvas-toggle-icon <?php echo esc_attr($settings['button_icon_new']['value']); ?>"></span>
                        <?php endif; ?>
                    <?php } else { ?>
                        <span class="smw-offcanvas-toggle-icon <?php echo esc_attr($settings['button_icon']); ?>"></span>
                    <?php } ?>
                    <span class="smw-toggle-text">
                        <?php echo $settings['button_text']; ?>
                    </span>
                </div>
            </div>
            <?php endif; // end of if( $settings['button_text'] != '' || $settings['button_text'] != '' ) ?>

            <div <?php echo $this->get_render_attribute_string('content'); ?>>
                <?php $this->render_close_button();?>
                <div class="smw-offcanvas-body">
                    <?php
                        if ('sidebar' == $settings['content_type']) {

                            $this->render_sidebar();

                        } else if ('custom' == $settings['content_type']) {

                            $this->render_custom_content();

                        } else if ('section' == $settings['content_type'] && !empty($settings['saved_section'])) {

                            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($settings['saved_section']);

                        } elseif ('template' == $settings['content_type'] && !empty($settings['templates'])) {

                            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($settings['templates']);

                        } elseif ('widget' == $settings['content_type'] && !empty($settings['saved_widget'])) {

                            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($settings['saved_widget']);

                        }
                    ?>
                </div><!-- /.smw-offcanvas-body -->
            </div>
        </div>
        <?php

    }

    protected function content_template()
    {}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_off_canvas() );