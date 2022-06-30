<?php

/**
 * SMW Dual Headings.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_dual_headings extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'dual-headings-css', plugin_dir_url( __FILE__ ) . '../css/dual-headings.css');
    }
    
    public function get_name()
    {
        return 'stiles-dual-headings';
    }
    
    public function get_title()
    {
        return 'Dual Headings';
    }
    
    public function get_icon()
    {
        return 'eicon-heading';
    }
    
    public function get_categories()
    {
        return ['stiles-media-headers'];
    }
    
    public function get_style_depends() 
    {
        return [ 'dual-headings-css' ];
    }
    
    protected function register_controls() 
    { 
	    $this->register_heading_content_controls();
	    
		$this->register_general_content_controls();
		
		$this->register_style_content_controls();
	}
	
	protected function register_heading_content_controls() 
    {
		$this->start_controls_section(
			'section_headings_field',
			array(
				'label' => __( 'Heading Text', 'uael' ),
			)
		);
		$this->add_control(
			'before_heading_text',
			array(

				'label'    => __( 'Before Text', 'uael' ),
				'type'     => Controls_Manager::TEXT,
				'selector' => '{{WRAPPER}} .uael-heading-text',
				'dynamic'  => array(
					'active' => true,
				),
				'default'  => __( 'I love', 'uael' ),
			)
		);
		$this->add_control(
			'second_heading_text',
			array(
				'label'    => __( 'Highlighted Text', 'uael' ),
				'type'     => Controls_Manager::TEXT,
				'selector' => '{{WRAPPER}} .uael-highlight-text',
				'dynamic'  => array(
					'active' => true,
				),
				'default'  => __( 'this website', 'uael' ),
			)
		);
		$this->add_control(
			'after_heading_text',
			array(
				'label'    => __( 'After Text', 'uael' ),
				'type'     => Controls_Manager::TEXT,
				'dynamic'  => array(
					'active' => true,
				),
				'selector' => '{{WRAPPER}} .uael-dual-heading-text',
			)
		);
		$this->add_control(
			'heading_link',
			array(
				'label'       => __( 'Link', 'uael' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'uael' ),
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => array(
					'url' => '',
				),
			)
		);
		$this->end_controls_section();
	}
	
	protected function register_general_content_controls() 
    {

		$this->start_controls_section(
			'section_style_field',
			array(
				'label' => __( 'General', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'dual_tag_selection',
			array(
				'label'   => __( 'Select Tag', 'uael' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1'   => __( 'H1', 'uael' ),
					'h2'   => __( 'H2', 'uael' ),
					'h3'   => __( 'H3', 'uael' ),
					'h4'   => __( 'H4', 'uael' ),
					'h5'   => __( 'H5', 'uael' ),
					'h6'   => __( 'H6', 'uael' ),
					'div'  => __( 'div', 'uael' ),
					'span' => __( 'span', 'uael' ),
					'p'    => __( 'p', 'uael' ),
				),
				'default' => 'h3',
			)
		);

		$this->add_responsive_control(
			'dual_colour_alignment',
			array(
				'label'     => __( 'Alignment', 'uael' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'uael' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'uael' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'uael' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .uael-dual-colour-heading' => 'text-align: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'heading_layout',
			array(
				'label'        => __( 'Layout', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Stack', 'uael' ),
				'label_off'    => __( 'Inline', 'uael' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'prefix_class' => 'uael-stack-desktop-',
			)
		);
		$this->add_control(
			'heading_stack_on',
			array(
				'label'        => __( 'Responsive Support', 'uael' ),
				'description'  => __( 'Choose on what breakpoint the heading will stack.', 'uael' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => array(
					'none'   => __( 'No', 'uael' ),
					'tablet' => __( 'For Tablet & Mobile', 'uael' ),
					'mobile' => __( 'For Mobile Only', 'uael' ),
				),
				'condition'    => array(
					'heading_layout!' => 'yes',
				),
				'prefix_class' => 'uael-heading-stack-',
			)
		);

		$this->add_responsive_control(
			'heading_margin',
			array(
				'label'      => __( 'Spacing Between Headings', 'uael' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'default'    => array(
					'size' => '0',
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .uael-before-heading' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .uael-after-heading'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.uael-stack-desktop-yes .uael-before-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px; display: inline-block;',
					'{{WRAPPER}}.uael-stack-desktop-yes .uael-after-heading' => 'margin-top: {{SIZE}}{{UNIT}}; margin-left: 0px; display: inline-block;',
					'(tablet){{WRAPPER}}.uael-heading-stack-tablet .uael-before-heading ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px; display: inline-block;',
					'(tablet){{WRAPPER}}.uael-heading-stack-tablet .uael-after-heading ' => 'margin-top: {{SIZE}}{{UNIT}}; margin-left: 0px; display: inline-block;',
					'(mobile){{WRAPPER}}.uael-heading-stack-mobile .uael-before-heading ' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0px; display: inline-block;',
					'(mobile){{WRAPPER}}.uael-heading-stack-mobile .uael-after-heading ' => 'margin-top: {{SIZE}}{{UNIT}}; margin-left: 0px; display: inline-block;',
				),
			)
		);
		$this->end_controls_section();
	}
	
	protected function register_style_content_controls() {
		$this->start_controls_section(
			'heading_style_fields',
			array(
				'label' => __( 'Heading Style', 'uael' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_heading' );

		$this->start_controls_tab(
			'tab_heading',
			array(
				'label' => __( 'Normal', 'uael' ),
			)
		);

		$this->add_control(
			'first_heading_colour',
			array(
				'label'     => __( 'Text Colour', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .uael-dual-heading-text' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'before_heading_text_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .uael-dual-heading-text',
			)
		);
		$this->add_control(
			'heading_adv_options',
			array(
				'label'        => __( 'Advanced', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'heading_bg_colour',
				'label'     => __( 'Background colour', 'uael' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .uael-dual-heading-text',
				'condition' => array(
					'heading_adv_options' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'heading_padding',
			array(
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .uael-dual-heading-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => 0,
					'bottom' => 0,
					'left'   => 0,
					'right'  => 0,
					'unit'   => 'px',
				),
				'condition'  => array(
					'heading_adv_options' => 'yes',
				),

			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'heading_text_border',
				'label'       => __( 'Border', 'uael' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .uael-dual-heading-text',
				'condition'   => array(
					'heading_adv_options' => 'yes',
				),
			)
		);
		$this->add_control(
			'heading_border_radius',
			array(
				'label'      => __( 'Border Radius', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .uael-dual-heading-text, {{WRAPPER}} .uael-dual-heading-text.uael-highlight-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'heading_adv_options' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'      => 'dual_text_shadow',
				'selector'  => '{{WRAPPER}} .uael-dual-heading-text',
				'condition' => array(
					'heading_adv_options' => 'yes',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_highlight',
			array(
				'label' => __( 'Highlight', 'uael' ),
			)
		);

		$this->add_control(
			'second_heading_colour',
			array(
				'label'     => __( 'Highlight colour', 'uael' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .uael-dual-heading-text.uael-highlight-text' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'second_heading_text_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .uael-dual-heading-text.uael-highlight-text',
			)
		);
		$this->add_control(
			'highlight_adv_options',
			array(
				'label'        => __( 'Advanced', 'uael' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'uael' ),
				'label_off'    => __( 'No', 'uael' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'highlight_bg_colour',
				'label'     => __( 'Background colour', 'uael' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .uael-dual-heading-text.uael-highlight-text',
				'condition' => array(
					'highlight_adv_options' => 'yes',
				),
			)
		);
		$this->add_responsive_control(
			'heading_highlight_padding',
			array(
				'label'      => __( 'Padding', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => array(
					'top'    => 0,
					'bottom' => 0,
					'left'   => 0,
					'right'  => 0,
					'unit'   => 'px',
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .uael-dual-heading-text.uael-highlight-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'highlight_adv_options' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'highlight_text_border',
				'label'       => __( 'Border', 'uael' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .uael-dual-heading-text.uael-highlight-text',
				'condition'   => array(
					'highlight_adv_options' => 'yes',
				),
			)
		);
		$this->add_control(
			'heading_highlight_radius',
			array(
				'label'      => __( 'Border Radius', 'uael' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .uael-dual-heading-text.uael-highlight-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'highlight_adv_options' => 'yes',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'      => 'dual_highlight_shadow',
				'selector'  => '{{WRAPPER}} .uael-dual-heading-text.uael-highlight-text',
				'condition' => array(
					'highlight_adv_options' => 'yes',
				),
			)
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
	
    protected function render() 
    {
		$settings     = $this->get_settings_for_display();
		$first_title  = $settings['before_heading_text'];
		$second_title = $settings['second_heading_text'];
		$third_title  = $settings['after_heading_text'];
		ob_start();
		?>
		<?php
		$link = '';
		if ( ! empty( $settings['heading_link']['url'] ) ) {
			$this->add_render_attribute( 'url', 'href', $settings['heading_link']['url'] );

			if ( $settings['heading_link']['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $settings['heading_link']['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}
			$link = $this->get_render_attribute_string( 'url' );
		}
		?>
		<div class="uael-module-content uael-dual-colour-heading">
			<<?php echo esc_attr( $settings['dual_tag_selection'] ); ?>>
				<?php if ( ! empty( $settings['heading_link']['url'] ) ) { ?>
					<a <?php echo wp_kses_post( $link ); ?> >
				<?php } ?>
						<?php
						?>
						<span class="uael-before-heading"><span class="elementor-inline-editing uael-dual-heading-text uael-first-text" data-elementor-setting-key="before_heading_text" data-elementor-inline-editing-toolbar="basic"><?php echo $this->get_settings_for_display( 'before_heading_text'); ?></span></span><span class="uael-adv-heading-stack"><span class="elementor-inline-editing uael-dual-heading-text uael-highlight-text" data-elementor-setting-key="second_heading_text" data-elementor-inline-editing-toolbar="basic"><?php echo $this->get_settings_for_display( 'second_heading_text'); ?></span></span><?php if ( ! empty( $settings['after_heading_text'] ) ) { ?><span class="uael-after-heading"><span class="elementor-inline-editing uael-dual-heading-text uael-third-text" data-elementor-setting-key="after_heading_text" data-elementor-inline-editing-toolbar="basic"><?php echo $this->get_settings_for_display( 'after_heading_text'); ?></span></span><?php } ?>
						<?php  ?>
				<?php if ( ! empty( $settings['heading_link']['url'] ) ) { ?>
					</a>
				<?php } ?>
			</<?php echo esc_attr( $settings['dual_tag_selection'] ); ?>>
		</div>
		<?php
		$html = ob_get_clean();
		echo wp_kses_post( $html );
	}

	protected function content_template() 
	{
		?>
		<div class="uael-module-content uael-dual-colour-heading">
			<{{ settings.dual_tag_selection }}>
				<# if ( '' != settings.heading_link.url ) { #>
					<a href= {{ settings.heading_link.url }}>
				<# } #>
				<span class="uael-before-heading"><span class="elementor-inline-editing uael-dual-heading-text uael-first-text" data-elementor-setting-key="before_heading_text" data-elementor-inline-editing-toolbar="basic">{{ settings.before_heading_text }}</span></span><span class="uael-adv-heading-stack"><span class="elementor-inline-editing uael-dual-heading-text uael-highlight-text" data-elementor-setting-key="second_heading_text" data-elementor-inline-editing-toolbar="basic">{{ settings.second_heading_text }}</span></span><# if ( '' != settings.after_heading_text ) { #><span class="uael-after-heading"><span class="elementor-inline-editing uael-dual-heading-text uael-third-text" data-elementor-setting-key="after_heading_text" data-elementor-inline-editing-toolbar="basic">{{ settings.after_heading_text }}</span></span>
				<# } #>
				<# if ( '' !== settings.heading_link.url ) { #>
					</a>
				<# } #>
			</{{ settings.dual_tag_selection }}>
		</div>
		<?php
	}

	protected function _content_template() 
	{ 
		$this->content_template();
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_dual_headings() );