<?php

/**
 * SMW FAQ.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\repeater;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Controls_Manager\DIVIDER;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_faq extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'faq-css', plugin_dir_url( __FILE__ ) .  '../css/faq.css');
        
        wp_register_script( 'faq-js', plugin_dir_url( __FILE__ ) .  '../js/faq.js');
    }
    
    public function get_name()
    {
        return 'stiles-faq';
    }
    
    public function get_title()
    {
        return 'FAQ';
    }
    
    public function get_icon()
    {
        return 'eicon-help-o';
    }
    
    public function get_categories()
    {
        return array('stiles-media-category');
    }
    
    public function get_style_depends() 
    {
        return [ 'faq-css' ];
    }
    
    public function get_script_depends() 
    {
        return [ 'faq-js' ];
    }
    
    protected function register_controls() 
    { 
	    $this->register_content();
	    
		$this->register_layout();
		
		$this->register_icon_content();
		
		$this->register_accordion();
		
		$this->register_question_style();
		
		$this->register_answer_style();
		
		$this->register_icon_style();
	}
	
	public function get_content_type() 
	{
		$content_type = array(
			'content'              => __( 'Content', smw_slug ),
			'saved_rows'           => __( 'Saved Section', smw_slug ),
			'saved_page_templates' => __( 'Saved Page', smw_slug ),
		);

		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$content_type['saved_modules'] = __( 'Saved Widget', smw_slug );
		}

		return $content_type;
	}

	protected function register_content() 
	{
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Content', smw_slug ),
			)
		);
				$repeater = new Repeater();

				$repeater->add_control(
					'question',
					array(
						'label'       => __( 'Title', smw_slug ),
						'type'        => Controls_Manager::TEXT,
						'label_block' => true,
						'default'     => __( 'What is FAQ?', smw_slug ),
						'dynamic'     => array(
							'active' => true,
						),
					)
				);

				$repeater->add_control(
					'faq_content_type',
					array(
						'label'   => __( 'Content Type', smw_slug ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'content',
						'options' => $this->get_content_type(),
					)
				);

			$repeater->add_control(
				'ct_saved_rows',
				array(
					'label'     => __( 'Select Section', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'options'   => SMW_Helper::get_saved_data( 'section' ),
					'default'   => '-1',
					'condition' => array(
						'faq_content_type' => 'saved_rows',
					),
				)
			);

			$repeater->add_control(
				'ct_saved_modules',
				array(
					'label'     => __( 'Select Widget', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'options'   => SMW_Helper::get_saved_data( 'widget' ),
					'default'   => '-1',
					'condition' => array(
						'faq_content_type' => 'saved_modules',
					),
				)
			);

			$repeater->add_control(
				'ct_page_templates',
				array(
					'label'     => __( 'Select Page', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'options'   => SMW_Helper::get_saved_data( 'page' ),
					'default'   => '-1',
					'condition' => array(
						'faq_content_type' => 'saved_page_templates',
					),
				)
			);

				$repeater->add_control(
					'answer',
					array(
						'label'      => __( 'Content', smw_slug ),
						'type'       => Controls_Manager::WYSIWYG,
						'default'    => __( 'Accordion Content', smw_slug ),
						'show_label' => true,
						'dynamic'    => array(
							'active' => true,
						),
						'default'    => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', smw_slug ),

						'condition'  => array(
							'faq_content_type' => 'content',
						),
					)
				);

				$this->add_control(
					'tabs',
					array(
						'type'        => Controls_Manager::REPEATER,
						'fields'      => $repeater->get_controls(),
						'default'     => array(
							array(
								'question' => __( 'What is FAQ?', smw_slug ),
								'answer'   => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', smw_slug ),
							),
							array(
								'question' => __( 'What is FAQ?', smw_slug ),
								'answer'   => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', smw_slug ),
							),
						),
						'title_field' => '{{{ question }}}',
					)
				);

				$this->add_control(
					'hr',
					array(
						'type' => Controls_Manager::DIVIDER,
					)
				);

				$this->add_control(
					'schema_support',
					array(
						'label'     => __( 'Enable Schema Support', smw_slug ),
						'type'      => Controls_Manager::SWITCHER,
						'label_on'  => __( 'Yes', smw_slug ),
						'label_off' => __( 'No', smw_slug ),
						'default'   => 'no',
					)
				);

				$this->end_controls_section();
	}

	protected function register_icon_content() 
	{
			$this->start_controls_section(
				'smw_icon_content',
				array(
					'label'     => __( 'Icon', smw_slug ),
					'condition' => array(
						'faq_layout!' => 'grid',
					),
				)
			);

			$this->add_control(
				'selected_icon',
				array(
					'label'            => __( 'Icon', smw_slug ),
					'type'             => Controls_Manager::ICONS,
					'separator'        => 'before',
					'fa4compatibility' => 'icon',
					'default'          => array(
						'value'   => 'fas fa-angle-right',
						'library' => 'fa-solid',
					),
				)
			);

			$this->add_control(
				'selected_active_icon',
				array(
					'label'     => __( 'Active Icon', smw_slug ),
					'type'      => Controls_Manager::ICONS,
					'default'   => array(
						'value'   => 'fas fa-angle-up',
						'library' => 'fa-solid',
					),
					'condition' => array(
						'selected_icon[value]!' => '',
					),
				)
			);

			$this->add_control(
				'icon_align',
				array(
					'label'       => __( 'Alignment', smw_slug ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => array(
						'left'  => array(
							'title' => __( 'Start', smw_slug ),
							'icon'  => 'eicon-h-align-left',
						),
						'right' => array(
							'title' => __( 'End', smw_slug ),
							'icon'  => 'eicon-h-align-right',
						),
					),
					'default'     => is_rtl() ? 'right' : 'left',
					'toggle'      => false,
					'label_block' => false,
				)
			);

			$this->end_controls_section();
	}

	protected function register_layout() 
	{
			$this->start_controls_section(
				'section_layout',
				array(
					'label' => __( 'Layout', smw_slug ),
				)
			);
			$this->add_control(
				'faq_layout',
				array(
					'label'   => __( 'Layout', smw_slug ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'accordion' => __( 'Accordion', smw_slug ),
						'grid'      => __( 'Grid', smw_slug ),
					),
					'default' => 'accordion',
				)
			);

			$this->add_control(
				'enable_toggle_layout',
				array(
					'label'     => __( 'Toggle', smw_slug ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Enable', smw_slug ),
					'label_off' => __( 'Disable', smw_slug ),
					'default'   => 'Disable',
					'condition' => array(
						'faq_layout' => 'accordion',

					),
				)
			);

			$this->add_control(
				'faq_layout_style',
				array(
					'label'        => __( 'Enable Box Style', smw_slug ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', smw_slug ),
					'label_off'    => __( 'no', smw_slug ),
					'default'      => 'yes',
					'condition'    => array(
						'faq_layout' => 'accordion',
					),
					'prefix_class' => 'smw-faq-box-layout-',
				)
			);

			$this->add_responsive_control(
				'row_gap',
				array(
					'label'     => __( 'Rows Gap', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 10,
					),
					'condition' => array(
						'faq_layout_style' => 'yes',
						'faq_layout'       => 'accordion',

					),
					'selectors' => array(
						'{{WRAPPER}} .smw-faq-container > .smw-faq-accordion:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$this->add_responsive_control(
				'columns',
				array(
					'label'           => __( 'Columns', smw_slug ),
					'type'            => Controls_Manager::SELECT,
					'desktop_default' => 2,
					'tablet_default'  => 2,
					'mobile_default'  => 1,
					'options'         => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					),
					'prefix_class'    => 'elementor-grid%s-',
					'condition'       => array(
						'faq_layout' => 'grid',
					),
				)
			);

			$this->add_responsive_control(
				'grid_column_gap',
				array(
					'label'     => __( 'Columns Gap', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 10,
					),
					'condition' => array(
						'faq_layout' => 'grid',
						'columns!'   => '1',
					),
					'selectors' => array(
						'{{WRAPPER}}:not(.elementor-grid-0) .elementor-grid' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.elementor-grid-0 .smw-faq-accordion' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2)',
						'{{WRAPPER}}.elementor-grid-0 .elementor-grid' => 'margin-right: calc(-{{SIZE}}{{UNIT}} / 2); margin-left: calc(-{{SIZE}}{{UNIT}} / 2)',
					),

				)
			);

			$this->add_responsive_control(
				'grid_row_gap',
				array(
					'label'     => __( 'Rows Gap', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 10,
					),
					'condition' => array(
						'faq_layout' => 'grid',
					),
					'selectors' => array(
						'{{WRAPPER}}:not(.elementor-grid-0) .elementor-grid' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.elementor-grid-0 .smw-faq-accordion' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'(tablet) {{WRAPPER}}.elementor-grid-tablet-0 .elementor-share-btn' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'(mobile) {{WRAPPER}}.elementor-grid-mobile-0 .elementor-share-btn' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					),
				)
			);

			$this->add_responsive_control(
				'smw_grid_align',
				array(
					'label'     => __( 'Alignment', smw_slug ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => array(
						'left'    => array(
							'title' => __( 'Left', smw_slug ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'  => array(
							'title' => __( 'Center', smw_slug ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'   => array(
							'title' => __( 'Right', smw_slug ),
							'icon'  => 'eicon-text-align-right',
						),
						'justify' => array(
							'title' => __( 'Justified', smw_slug ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'default'   => '',
					'condition' => array(
						'faq_layout' => 'grid',
					),
					'selectors' => array(
						'{{WRAPPER}} .smw-faq-accordion.elementor-grid-item' => 'text-align: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'enable_seperator',
				array(
					'label'     => __( 'Enable Separator', smw_slug ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', smw_slug ),
					'label_off' => __( 'No', smw_slug ),
					'default'   => 'no',
					'separator' => 'before',
				)
			);

			$this->end_controls_section();
	}

	protected function register_accordion() 
	{
		$this->start_controls_section(
			'section_title_style',
			array(
				'label' => __( 'Box', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'faq_border_style',
			array(
				'label'       => __( 'Border Style', smw_slug ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'solid',
				'label_block' => false,
				'options'     => array(
					'none'   => __( 'None', smw_slug ),
					'solid'  => __( 'Solid', smw_slug ),
					'dashed' => __( 'Dashed', smw_slug ),
					'dotted' => __( 'Dotted', smw_slug ),
					'double' => __( 'Double', smw_slug ),
				),
				'selectors'   => array(
					'{{WRAPPER}} .smw-faq-container .smw-faq-accordion' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .smw-faq-box-layout-yes .smw-faq-container .smw-faq-accordion' => 'border-style: {{VALUE}}; ',
					'{{WRAPPER}} .smw-faq-container .smw-faq-accordion.elementor-grid-item' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .smw-faq-container:last-child' => 'border-bottom-style: {{VALUE}};',
					'{{WRAPPER}} .smw-faq-container.smw-faq-container:last-child' => 'border-bottom-style: {{VALUE}};',
					'{{WRAPPER}} .smw-faq-container.smw-faq-layout-grid:last-child' => 'border-bottom-style: none ;',
				),
				'condition'   => array(
					'faq_layout_style!' => 'yes',
				),
			)
		);

		$this->add_control(
			'smw_border_width',
			array(
				'label'     => __( 'Width', smw_slug ),
				'type'      => Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'      => 1,
					'right'    => 1,
					'bottom'   => 1,
					'left'     => 1,
					'isLinked' => true,
				),
				'selectors' => array(

					'{{WRAPPER}} .smw-faq-container .smw-faq-accordion' => 'border-width:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0px {{LEFT}}{{UNIT}} ;',
					'{{WRAPPER}} .smw-faq-container .smw-faq-accordion.elementor-grid-item' => 'border-width:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} ;',
					'{{WRAPPER}} .smw-faq-container:last-child' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} ;',
					'{{WRAPPER}}.smw-faq-layout-grid .smw-faq-container:last-child' => 'border-bottom: 0px;',
				),
				'condition' => array(
					'faq_border_style!' => 'none',
					'faq_layout_style!' => 'yes',
				),
			)
		);

		$this->add_control(
			'smw_border_color',
			array(
				'label'     => __( 'Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-container .smw-faq-accordion' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-content' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .smw-faq-container:last-child' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-content' => 'border-top-color: {{VALUE}};',
				),
				'default'   => '#D4D4D4',
				'condition' => array(
					'faq_border_style!' => 'none',
					'faq_layout_style!' => 'yes',
				),
			)
		);

		$this->add_control(
			'faq_box_border_style',
			array(
				'label'       => __( 'Border Style', smw_slug ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'solid',
				'label_block' => false,
				'options'     => array(
					'none'   => __( 'None', smw_slug ),
					'solid'  => __( 'Solid', smw_slug ),
					'dashed' => __( 'Dashed', smw_slug ),
					'dotted' => __( 'Dotted', smw_slug ),
					'double' => __( 'Double', smw_slug ),
				),
				'selectors'   => array(
					'{{WRAPPER}} .smw-faq-wrapper .smw-faq-container .smw-faq-accordion' => 'border-style: {{VALUE}};',
				),
				'condition'   => array(
					'faq_layout_style' => 'yes',
				),
			)
		);

		$this->add_control(
			'smw_box_border_width',
			array(
				'label'     => __( 'Width', smw_slug ),
				'type'      => Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'      => 1,
					'right'    => 1,
					'bottom'   => 1,
					'left'     => 1,
					'isLinked' => true,
				),
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-wrapper .smw-faq-container .smw-faq-accordion' => 'border-width:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} ;',

				),
				'condition' => array(
					'faq_box_border_style!' => 'none',
					'faq_layout_style'      => 'yes',
				),
			)
		);

		$this->add_control(
			'smw_box_border_color',
			array(
				'label'     => __( 'Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-wrapper .smw-faq-container .smw-faq-accordion' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .smw-faq-container .smw-faq-accordion .smw-accordion-content' => 'border-top-color: {{VALUE}};',
				),
				'default'   => '#D4D4D4',
				'condition' => array(
					'faq_box_border_style!' => 'none',
					'faq_layout_style'      => 'yes',
				),
			)
		);

		$this->add_control(
			'smw_border_radius',
			array(
				'label'     => __( 'Border radius', smw_slug ),
				'type'      => Controls_Manager::DIMENSIONS,
				'default'   => array(
					'top'      => 1,
					'right'    => 1,
					'bottom'   => 1,
					'left'     => 1,
					'isLinked' => true,
				),
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-container .smw-faq-accordion' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
					'faq_box_border_style!' => 'none',
					'faq_layout_style'      => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'box_layout_shadow',
				'label'     => __( 'Box Shadow', smw_slug ),
				'selector'  => '{{WRAPPER}} .smw-faq-accordion',
				'condition' => array(
					'faq_border_style!' => 'none',
					'faq_layout_style'  => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'box_normal_layout_shadow',
				'label'     => __( 'Box Shadow', smw_slug ),
				'selector'  => '{{WRAPPER}} .smw-faq-wrapper',
				'condition' => array(
					'faq_border_style!' => 'none',
					'faq_layout_style!' => 'yes',
				),
			)
		);

		$this->add_control(
			'enable_separator_heading',
			array(
				'label'     => __( 'Separator', smw_slug ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'enable_seperator' => 'yes',
				),
			)
		);

			$this->add_control(
				'faq_separator_style',
				array(
					'label'       => __( 'Style', smw_slug ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'solid',
					'label_block' => false,
					'options'     => array(
						'none'   => __( 'None', smw_slug ),
						'solid'  => __( 'Solid', smw_slug ),
						'dashed' => __( 'Dashed', smw_slug ),
						'dotted' => __( 'Dotted', smw_slug ),
						'double' => __( 'Double', smw_slug ),
					),
					'selectors'   => array(
						'{{WRAPPER}} .smw-faq-container .smw-faq-accordion .smw-accordion-content' => 'border-style: {{VALUE}};',
					),
					'condition'   => array(
						'enable_seperator' => 'yes',
					),
				)
			);

		$this->add_control(
			'smw_separator_width',
			array(
				'label'     => __( 'Width', smw_slug ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 10,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 1,
				),
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-container .smw-faq-accordion .smw-accordion-content' => 'border-top-width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'enable_seperator'     => 'yes',
					'faq_separator_style!' => 'none',

				),
			)
		);

		$this->add_control(
			'smw_separator_border_color',
			array(
				'label'     => __( 'Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-container .smw-faq-accordion .smw-accordion-content' => 'border-top-color: {{VALUE}};',
				),
				'default'   => '#D4D4D4',
				'condition' => array(
					'enable_seperator'     => 'yes',
					'faq_separator_style!' => 'none',
				),

			)
		);

		$this->end_controls_section();
	}

	protected function register_question_style() 
	{
		$this->start_controls_section(
			'smw_title_style',
			array(
				'label' => __( 'Title', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .smw-faq-accordion .smw-accordion-title',
				'scheme'   => Typography::TYPOGRAPHY_1,

			)
		);

		$this->start_controls_tabs( 'smw_title_colors' );

		$this->start_controls_tab(
			'smw_colors_normal',
			array(
				'label' => __( 'Normal', smw_slug ),
			)
		);

			$this->add_control(
				'smw_title_background',
				array(
					'label'     => __( 'Background Color', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .smw-faq-accordion .smw-accordion-title' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'smw_active_title_background',
				array(
					'label'     => __( 'Active Background Color', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .smw-faq-accordion .smw-accordion-title.smw-title-active' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'smw_title_color',
				array(
					'label'     => __( 'Text Color', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .smw-faq-accordion .smw-accordion-title span.smw-question-span,
						{{WRAPPER}}  .smw-accordion-icon-closed, {{WRAPPER}} span.smw-accordion-icon-opened' => 'color: {{VALUE}};',
						'{{WRAPPER}} .smw-accordion-icon-closed, {{WRAPPER}} span.smw-accordion-icon-opened' => 'fill: {{VALUE}};',
					),
					'scheme'    => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_1,
					),
				)
			);

			$this->add_control(
				'smw_title_active_color',
				array(
					'label'     => __( 'Active Text Color', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .smw-faq-accordion .smw-accordion-title.smw-title-active span.smw-question-span,
						{{WRAPPER}} span.smw-accordion-icon-opened' => 'color: {{VALUE}};',
					),
					'scheme'    => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_1,
					),
					'condition' => array(
						'faq_layout' => 'accordion',
					),
				)
			);

		$this->end_controls_tab();
				$this->start_controls_tab(
					'icon_colors_hover',
					array(
						'label' => __( 'Hover', smw_slug ),
					)
				);

		$this->add_control(
			'smw_title_background_hover',
			array(
				'label'     => __( 'Background Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-title:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'smw_active_title_hover_background',
			array(
				'label'     => __( 'Active Background Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-title.smw-title-active:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'smw_title_hover_color',
			array(
				'label'     => __( 'Text Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-title span.smw-question-span:hover,
					{{WRAPPER}}  .smw-accordion-icon-closed:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .smw-accordion-icon-closed:hover' => 'fill: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				),
			)
		);

		$this->add_control(
			'smw_title_active_hover_color',
			array(
				'label'     => __( 'Active Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-title.smw-title-active:hover span.smw-question-span,
					{{WRAPPER}} span.smw-accordion-icon-opened:hover' => 'color: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'condition' => array(
					'faq_layout' => 'accordion',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => __( 'Padding', smw_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => 10,
					'right'    => 10,
					'bottom'   => 10,
					'left'     => 10,
					'isLinked' => true,
				),
				'separator'  => 'after',
				'selectors'  => array(
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function register_answer_style() 
	{
		$this->start_controls_section(
			'smw_content_style',
			array(
				'label' => __( 'Content', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .smw-faq-accordion .smw-accordion-content',
				'scheme'   => Typography::TYPOGRAPHY_3,
			)
		);

		$this->start_controls_tabs( 'smw_content_colors' );

		$this->start_controls_tab(
			'smw_content_colors_normal',
			array(
				'label' => __( 'Normal', smw_slug ),
			)
		);

		$this->add_control(
			'smw_content_background',
			array(
				'label'     => __( 'Background Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-content' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .smw-faq-accordion.elementor-grid-item' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'smw_content_color',
			array(
				'label'     => __( 'Text Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-content' => 'color: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				),
			)
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'smw_content_colors_hover',
			array(
				'label' => __( 'Hover', smw_slug ),
			)
		);

		$this->add_control(
			'smw_content_hover_background',
			array(
				'label'     => __( 'Background Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-content:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'smw_content_hover_color',
			array(
				'label'     => __( 'Text Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-content:hover' => 'color: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'smw_content_padding',
			array(
				'label'      => __( 'Padding', smw_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => 10,
					'right'    => 10,
					'bottom'   => 10,
					'left'     => 10,
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .smw-faq-accordion .smw-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Registers all controls for Icon Styling.
	 *
	 * @since 1.22.0
	 * @access protected
	 */
	protected function register_icon_style() {
		$this->start_controls_section(
			'smw_icon_style',
			array(
				'label'     => __( 'Icon', smw_slug ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array( 'faq_layout!' => 'grid' ),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => __( 'Icon Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'
				{{WRAPPER}}  .smw-accordion-icon-closed' => 'color: {{VALUE}};',
					'{{WRAPPER}} .smw-accordion-icon-closed' => 'fill: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				),
			)
		);

		$this->add_control(
			'smw_icon_active_color',
			array(
				'label'     => __( 'Active Icon Color', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} span.smw-accordion-icon-opened'  => 'color: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				),
			)
		);

		$this->add_responsive_control(
			'smw_icon_space',
			array(
				'label'     => __( 'Spacing', smw_slug ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 15,
				),
				'selectors' => array(
					'{{WRAPPER}} .smw-accordion-icon.smw-accordion-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .smw-accordion-icon.smw-accordion-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
	}

	public function get_modal_content( $key ) 
	{
		$dynamic_settings = $this->get_settings_for_display();
		$content_type     = $key['faq_content_type'];
		$output           = '';
		switch ( $content_type ) {
			case 'content':
				global $wp_embed;
				$output = '<span>' . wpautop( $wp_embed->autoembed( $key['answer'] ) ) . '</span>';
				break;
			case 'saved_rows':
				$output = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( apply_filters( 'wpml_object_id', $key['ct_saved_rows'], 'page' ) );
				break;
			case 'saved_modules':
				$output = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $key['ct_saved_modules'] );
				break;
			case 'saved_page_templates':
				$output = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $key['ct_page_templates'] );
				break;
			default:
				return;
		}
		return $output;
	}


	protected function render() 
	{
		$settings               = $this->get_settings_for_display();
		$is_editor              = \Elementor\Plugin::instance()->editor->is_edit_mode();
		$id_int                 = substr( $this->get_id_int(), 0, 3 );
		$content_schema_warning = '0';

		foreach ( $settings['tabs'] as $key ) 
		{
			if ( 'content' !== $key['faq_content_type'] ) {
				$content_schema_warning = '1';
			}
		}

		if ( ( '1' === $content_schema_warning ) && ( true === $is_editor ) && ( 'yes' === $settings['schema_support'] ) ) {
			?><span>
				<?php
				echo '<div class="elementor-alert elementor-alert-warning smw-warning">';
				echo esc_attr_e( 'The FAQ Schema is not supported in the case of Saved Section / Saved Page.', smw_slug );
				echo '</div>';
				?>
			</span>
			<?php
		}

		$this->add_render_attribute( 'smw-faq-container', 'class', 'smw-faq-container smw-faq-layout-' . $settings['faq_layout'] );

		if ( 'grid' === $settings['faq_layout'] ) {
			$this->add_render_attribute( 'smw-faq-container', 'class', 'elementor-grid' );
		} elseif ( 'accordion' === $settings['faq_layout'] ) {
			if ( 'yes' === $settings['enable_toggle_layout'] ) {
				$this->add_render_attribute( 'smw-faq-container', 'data-layout', 'toggle' );
			} else {
				$this->add_render_attribute( 'smw-faq-container', 'data-layout', 'accordion' );
			}
		}
		?>
		
		<?php echo stiles_get_template_type( get_the_ID() ); ?>

			<div id='smw-faq-wrapper-<?php echo esc_attr( $id_int ); ?>' class="smw-faq-wrapper"> 
				<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'smw-faq-container' ) ); ?> >
					<?php

					foreach ( $settings['tabs'] as $key ) {
						if ( ( '' === $key['question'] || '' === $key['answer'] ) && 'yes' === $settings['schema_support'] && ( true === $is_editor ) ) {
							?>
							<span>
								<?php
								echo '<div class="elementor-alert elementor-alert-warning smw-warning">';
								echo esc_attr_e( 'Please fill out the empty fields in content', smw_slug );
								echo '</div>';
								?>
							</span>
							<?php
						}
						if ( 'grid' === $settings['faq_layout'] ) {
							$this->add_render_attribute(
								'smw_faq_accordion_' . $key['_id'],
								array(
									'id'    => 'smw-accordion-' . $key['_id'],
									'class' => array( 'smw-faq-accordion', 'elementor-grid-item' ),
								)
							);
						} else {
							$this->add_render_attribute(
								'smw_faq_accordion_' . $key['_id'],
								array(
									'id'    => 'smw-accordion-' . $key['_id'],
									'class' => 'smw-faq-accordion',
								)
							);
						}

						if ( ! ( '' === $key['question'] || '' === $key['answer'] ) ) {
							?>
							<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'smw_faq_accordion_' . $key['_id'] ) ); ?>>
								<div class="smw-accordion-title" aria-expanded="false">                    
									<span class="smw-accordion-icon smw-accordion-icon-<?php echo esc_attr( $settings['icon_align'] ); ?>">
										<span class="smw-accordion-icon-closed"><?php Icons_Manager::render_icon( $settings['selected_icon'] ); ?></span>
										<span class="smw-accordion-icon-opened"><?php Icons_Manager::render_icon( $settings['selected_active_icon'] ); ?></span>
									</span>
									<span class="smw-question-<?php echo esc_attr( $key['_id'] ); ?> smw-question-span" tabindex="0" ><?php echo wp_kses_post( $key['question'] ); ?></span>
								</div>
								<div class="smw-accordion-content">
									<span>
									<?php
									echo $this->get_modal_content( $key ); // phpcs:ignore
									?>
									</span>
								</div>
							</div>
							<?php
						} else {
							$content_schema_warning = '1';
						}
					}
					?>
				</div>
			</div>
			<?php
			// schema logic.

			if ( 'yes' === $settings['schema_support'] && ( '0' === $content_schema_warning ) ) {
				$object_data = array();
				$json_data   = array(
					'@context' => 'https://schema.org',
					'@type'    => 'FAQPage',
				);
				foreach ( $settings['tabs'] as $key ) {
					$new_data = array(
						'@type'          => 'Question',
						'name'           => $key['question'],
						'acceptedAnswer' =>
						array(
							'@type' => 'Answer',
							'text'  => $key['answer'],
						),
					);
					array_push( $object_data, $new_data );
				}
				$json_data['mainEntity'] = $object_data;
				$encoded_data            = wp_json_encode( $json_data );
				?>
				<script type="application/ld+json">
					<?php print_r( $encoded_data );  // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r ?>
				</script>
				<?php
			}
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_faq() );