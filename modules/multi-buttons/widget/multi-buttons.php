<?php

/**
 * SMW Multi Buttons.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Repeater;
use Elementor\Widget_Button;
use Elementor\Group_Control_Background;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_multi_buttons extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'multi-buttons-css', plugin_dir_url( __FILE__ ) .  '../css/multi-buttons.css');
    }
    
    public function get_name()
    {
        return 'stiles-multi-buttons';
    }
    
    public function get_title()
    {
        return 'Multi Buttons';
    }
    
    public function get_icon()
    {
        return 'eicon-dual-button';
    }
    
    public function get_categories()
    {
        return array('stiles-media-category');
    }
    
    public function get_style_depends() 
    {
        return [ 'multi-buttons-css' ];
    }
    
    public static function get_new_icon_name( $control_name ) 
    {
		if ( class_exists( 'Elementor\Icons_Manager' ) ) {
			return 'new_' . $control_name . '[value]';
		} else {
			return $control_name;
		}
	}
	
	public static function get_button_sizes() 
    {
		return Widget_Button::get_button_sizes();
	}
    
    protected function register_controls() 
    { 
		$this->register_buttons_content_controls();

		$this->register_styling_style_controls();
		
		$this->register_colour_content_controls();
		
		$this->register_spacing_content_controls();
	}
	
    protected function register_buttons_content_controls() 
    {
		$this->start_controls_section(
			'section_buttons',
			array(
				'label' => __( 'Button', smw_slug ),
			)
		);

			$repeater = new Repeater();

				$repeater->start_controls_tabs( 'button_repeater' );

					$repeater->start_controls_tab(
						'button_general',
						array(
							'label' => __( 'General', smw_slug ),
						)
					);

					$repeater->add_control(
						'text',
						array(
							'label'       => __( 'Text', smw_slug ),
							'type'        => Controls_Manager::TEXT,
							'default'     => __( 'Click Me', smw_slug ),
							'placeholder' => __( 'Click Me', smw_slug ),
							'dynamic'     => array(
								'active' => true,
							),
						)
					);

					$repeater->add_control(
						'link',
						array(
							'label'    => __( 'Link', smw_slug ),
							'type'     => Controls_Manager::URL,
							'default'  => array(
								'url'         => '#',
								'is_external' => '',
							),
							'dynamic'  => array(
								'active' => true,
							),
							'selector' => '',
						)
					);

		if ( class_exists( 'Elementor\Icons_Manager' ) ) 
		{
			$repeater->add_control(
				'new_icon',
				array(
					'label'            => __( 'Icon', smw_slug ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'label_block'      => true,
				)
			);
		} else {
			$repeater->add_control(
				'icon',
				array(
					'label'       => __( 'Icon', smw_slug ),
					'type'        => Controls_Manager::ICON,
					'label_block' => true,
				)
			);
		}
					$repeater->add_control(
						'icon_align',
						array(
							'label'      => __( 'Icon Position', smw_slug ),
							'type'       => Controls_Manager::SELECT,
							'default'    => 'left',
							'options'    => array(
								'left'  => __( 'Before', smw_slug ),
								'right' => __( 'After', smw_slug ),
							),
							'conditions' => array(
								'relation' => 'or',
								'terms'    => array(
									array(
										'name'     => $this->get_new_icon_name( 'icon' ),
										'operator' => '!=',
										'value'    => '',
									),
								),
							),
						)
					);

					$repeater->add_control(
						'icon_indent',
						array(
							'label'      => __( 'Icon Spacing', smw_slug ),
							'type'       => Controls_Manager::SLIDER,
							'range'      => array(
								'px' => array(
									'max' => 50,
								),
							),
							'conditions' => array(
								'relation' => 'or',
								'terms'    => array(
									array(
										'name'     => $this->get_new_icon_name( 'icon' ),
										'operator' => '!=',
										'value'    => '',
									),
								),
							),
							'selectors'  => array(
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
							),
						)
					);

					$repeater->add_control(
						'css_id',
						array(
							'label'       => __( 'CSS ID', smw_slug ),
							'type'        => Controls_Manager::TEXT,
							'default'     => '',
							'label_block' => true,
							'title'       => __( 'Add your custom id WITHOUT the # key.', smw_slug ),
						)
					);

					$repeater->add_control(
						'css_classes',
						array(
							'label'       => __( 'CSS Classes', smw_slug ),
							'type'        => Controls_Manager::TEXT,
							'default'     => '',
							'label_block' => true,
							'title'       => __( 'Add space separated custom classes WITHOUT the dot.', smw_slug ),
						)
					);

				$repeater->end_controls_tab();

				$repeater->start_controls_tab(
					'button_design',
					array(
						'label' => __( 'Design', smw_slug ),
					)
				);

					$repeater->add_control(
						'html_message',
						array(
							'type'            => Controls_Manager::RAW_HTML,
							'raw'             => __( 'Set custom styles that will only affect this specific button.', smw_slug ),
							'content_classes' => 'elementor-control-field-description',
						)
					);

					$repeater->add_control(
						'colour_options',
						array(
							'label'     => __( 'Normal', smw_slug ),
							'type'      => Controls_Manager::HEADING,
							'separator' => 'before',
						)
					);

					$repeater->add_control(
						'btn_text_colour',
						array(
							'label'     => __( 'Text colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button' => 'color: {{VALUE}};',
							),
						)
					);

					$repeater->add_control(
						'btn_background_colour',
						array(
							'label'     => __( 'Background colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => array(
								'type'  => Color::get_type(),
								'value' => Color::COLOR_4,
							),
							'selectors' => array(
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button' => 'background-color: {{VALUE}};',
							),
						)
					);

					$repeater->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'      => 'btn_border',
							'label'     => __( 'Border', smw_slug ),
							'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button',
							'separator' => 'before',
						)
					);

					$repeater->add_control(
						'btn_border_radius',
						array(
							'label'      => __( 'Border Radius', smw_slug ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', '%' ),
							'selectors'  => array(
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$repeater->add_control(
						'hover_options',
						array(
							'label' => __( 'Hover', smw_slug ),
							'type'  => Controls_Manager::HEADING,
						)
					);

					$repeater->add_control(
						'btn_text_hover_colour',
						array(
							'label'     => __( 'Text colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$repeater->add_control(
						'btn_background_hover_colour',
						array(
							'label'     => __( 'Background colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => array(
								'type'  => Color::get_type(),
								'value' => Color::COLOR_4,
							),
							'selectors' => array(
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$repeater->add_control(
						'btn_border_hover_colour',
						array(
							'label'     => __( 'Border Hover colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => array(
								'type'  => Color::get_type(),
								'value' => Color::COLOR_4,
							),
							'selectors' => array(
								'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-button:hover' => 'border-color: {{VALUE}};',
							),
						)
					);

					$repeater->add_group_control(
						Group_Control_Typography::get_type(),
						array(
							'name'     => 'btn_typography',
							'scheme'   => Typography::TYPOGRAPHY_4,
							'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} a.elementor-button, {{WRAPPER}} {{CURRENT_ITEM}} a.elementor-button .elementor-button-icon i,{{WRAPPER}} {{CURRENT_ITEM}} a.elementor-button .elementor-button-icon svg',
						)
					);

				$repeater->end_controls_tab();

			$repeater->end_controls_tabs();

			$this->add_control(
				'buttons',
				array(
					'label'       => __( 'Buttons', smw_slug ),
					'type'        => Controls_Manager::REPEATER,
					'show_label'  => true,
					'fields'      => array_values( $repeater->get_controls() ),
					'title_field' => '{{{ text }}}',
					'default'     => array(
						array(
							'text' => __( 'Click Me #1', smw_slug ),
						),
						array(
							'text' => __( 'Click Me #2', smw_slug ),
						),
					),
				)
			);

		$this->end_controls_section();
	}

	protected function register_spacing_content_controls() 
	{
		$this->start_controls_section(
			'general_spacing',
			array(
				'label' => __( 'Spacing', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'gap',
				array(
					'label'      => __( 'Space between buttons', smw_slug ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', 'em', 'rem' ),
					'range'      => array(
						'px' => array(
							'min' => 1,
							'max' => 1000,
						),
					),
					'default'    => array(
						'size' => 10,
						'unit' => 'px',
					),
					'selectors'  => array(
						'{{WRAPPER}} .smw-dual-button-wrap .smw-button-wrapper' => 'margin-right: calc( {{SIZE}}{{UNIT}} / 2) ; margin-left: calc( {{SIZE}}{{UNIT}} / 2);',
						'{{WRAPPER}}.smw-button-stack-none .smw-dual-button-wrap' => 'margin-right: calc( -{{SIZE}}{{UNIT}} / 2) ; margin-left: calc( -{{SIZE}}{{UNIT}} / 2);',
						'(desktop){{WRAPPER}}.smw-button-stack-desktop .smw-dual-button-wrap .smw-button-wrapper'  => 'margin-bottom: calc( {{SIZE}}{{UNIT}} / 2 ); margin-top: calc( {{SIZE}}{{UNIT}} / 2 ); margin-right: 0; margin-left: 0;',
						'(desktop){{WRAPPER}}.smw-button-stack-desktop .smw-dual-button-wrap .smw-button-wrapper:last-child' => 'margin-bottom: 0;',
						'(desktop){{WRAPPER}}.smw-button-stack-desktop .smw-dual-button-wrap .smw-button-wrapper:first-child' => 'margin-top: 0;',
						'(tablet){{WRAPPER}}.smw-button-stack-tablet .smw-dual-button-wrap .smw-button-wrapper'        => 'margin-bottom: calc( {{SIZE}}{{UNIT}} / 2 ); margin-top: calc( {{SIZE}}{{UNIT}} / 2 ); margin-right: 0; margin-left: 0;',
						'(tablet){{WRAPPER}}.smw-button-stack-tablet .smw-dual-button-wrap .smw-button-wrapper:last-child' => 'margin-bottom: 0;',
						'(tablet){{WRAPPER}}.smw-button-stack-tablet .smw-dual-button-wrap .smw-button-wrapper:first-child' => 'margin-top: 0;',
						'(mobile){{WRAPPER}}.smw-button-stack-mobile .smw-dual-button-wrap .smw-button-wrapper'        => 'margin-bottom: calc( {{SIZE}}{{UNIT}} / 2 ); margin-top: calc( {{SIZE}}{{UNIT}} / 2 ); margin-right: 0; margin-left: 0;',
						'(mobile){{WRAPPER}}.smw-button-stack-mobile .smw-dual-button-wrap .smw-button-wrapper:last-child' => 'margin-bottom: 0;',
						'(mobile){{WRAPPER}}.smw-button-stack-mobile .smw-dual-button-wrap .smw-button-wrapper:first-child' => 'margin-top: 0;',
					),
				)
			);

			$this->add_control(
				'stack_on',
				array(
					'label'        => __( 'Stack on', smw_slug ),
					'description'  => __( 'Choose on what breakpoint where the buttons will stack.', smw_slug ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'none',
					'options'      => array(
						'none'    => __( 'None', smw_slug ),
						'desktop' => __( 'Desktop', smw_slug ),
						'tablet'  => __( 'Tablet', smw_slug ),
						'mobile'  => __( 'Mobile', smw_slug ),
					),
					'prefix_class' => 'smw-button-stack-',
				)
			);

		$this->end_controls_section();
	}

	protected function register_colour_content_controls() 
	{

		$this->start_controls_section(
			'general_colours',
			array(
				'label' => __( 'Styling', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->start_controls_tabs( '_button_style' );

				$this->start_controls_tab(
					'_button_normal',
					array(
						'label' => __( 'Normal', smw_slug ),
					)
				);

					$this->add_control(
						'all_text_colour',
						array(
							'label'     => __( 'Text colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'{{WRAPPER}} a.elementor-button' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'all_background_colour',
						array(
							'label'     => __( 'Background colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => array(
								'type'  => Color::get_type(),
								'value' => Color::COLOR_4,
							),
							'selectors' => array(
								'{{WRAPPER}} a.elementor-button' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'all_border',
							'label'    => __( 'Border', smw_slug ),
							'selector' => '{{WRAPPER}} .elementor-button',
						)
					);

					$this->add_control(
						'all_border_radius',
						array(
							'label'      => __( 'Border Radius', smw_slug ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', '%' ),
							'selectors'  => array(
								'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						array(
							'name'     => 'all_button_box_shadow',
							'selector' => '{{WRAPPER}} .elementor-button',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'all_button_hover',
					array(
						'label' => __( 'Hover', smw_slug ),
					)
				);

					$this->add_control(
						'all_hover_colour',
						array(
							'label'     => __( 'Text colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} a.elementor-button:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'all_background_hover_colour',
						array(
							'label'     => __( 'Background colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => array(
								'type'  => Color::get_type(),
								'value' => Color::COLOR_4,
							),
							'selectors' => array(
								'{{WRAPPER}} a.elementor-button:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'all_border_hover_colour',
						array(
							'label'     => __( 'Border Hover colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'{{WRAPPER}} a.elementor-button:hover' => 'border-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						array(
							'name'      => 'all_button_hover_box_shadow',
							'selector'  => '{{WRAPPER}} .elementor-button:hover',
							'separator' => 'after',
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_styling_style_controls() 
	{
		$this->start_controls_section(
			'section_styling',
			array(
				'label' => __( 'Design', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'size',
				array(
					'label'       => __( 'Size', smw_slug ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'sm',
					'label_block' => true,
					'options'     => self::get_button_sizes(),
				)
			);

			$this->add_responsive_control(
				'padding',
				array(
					'label'      => __( 'Padding', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'all_typography',
					'scheme'   => Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} a.elementor-button,{{WRAPPER}} a.elementor-button svg',
				)
			);

			$this->add_responsive_control(
				'align',
				array(
					'label'        => __( 'Alignment', smw_slug ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => array(
						'left'    => array(
							'title' => __( 'Left', smw_slug ),
							'icon'  => 'fa fa-align-left',
						),
						'center'  => array(
							'title' => __( 'Center', smw_slug ),
							'icon'  => 'fa fa-align-center',
						),
						'right'   => array(
							'title' => __( 'Right', smw_slug ),
							'icon'  => 'fa fa-align-right',
						),
						'justify' => array(
							'title' => __( 'Justify', smw_slug ),
							'icon'  => 'fa fa-align-justify',
						),
					),
					'default'      => 'center',
					'toggle'       => false,
					'prefix_class' => 'smw%s-button-halign-',
				)
			);

			$this->add_control(
				'hover_animation',
				array(
					'label' => __( 'Hover Animation', smw_slug ),
					'type'  => Controls_Manager::HOVER_ANIMATION,
				)
			);

		$this->end_controls_section();
	}


	protected function render_button_text( $button, $i ) 
	{

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );
		$this->add_render_attribute( 'content-wrapper', 'class', 'smw-buttons-icon-' . $button['icon_align'] );

		$this->add_render_attribute( 'icon-align_' . $i, 'class', 'elementor-align-icon-' . $button['icon_align'] );
		$this->add_render_attribute( 'icon-align_' . $i, 'class', 'elementor-button-icon' );

		$this->add_render_attribute( 'btn-text_' . $i, 'class', 'elementor-button-text' );
		$this->add_render_attribute( 'btn-text_' . $i, 'class', 'elementor-inline-editing' );

		$text_key = $this->get_repeater_setting_key( 'text', 'buttons', $i );
		$this->add_inline_editing_attributes( $text_key, 'none' );
		?>
		<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'content-wrapper' ) ); ?>>
			<?php if ( class_exists( 'Elementor\Icons_Manager' ) ) { ?>
				<?php if ( ! empty( $button['icon'] ) || ! empty( $button['new_icon'] ) ) : ?>
					<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'icon-align_' . esc_attr( $i ) ) ); ?>>
						<?php
						$migrated = isset( $button['__fa4_migrated']['new_icon'] );
						$is_new   = ! isset( $button['icon'] ) && \Elementor\Icons_Manager::is_migration_allowed();
						if ( $is_new || $migrated ) {

							\Elementor\Icons_Manager::render_icon( $button['new_icon'], array( 'aria-hidden' => 'true' ) );
						} elseif ( ! empty( $button['icon'] ) ) {
							?>
							<i class="<?php echo esc_attr( $button['icon'] ); ?>" aria-hidden="true"></i>
						<?php } ?>
					</span>
				<?php endif; ?>
			<?php } elseif ( ! empty( $button['icon'] ) ) { ?>
				<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'icon-align_' . esc_attr( $i ) ) ); ?>>
					<i class="<?php echo esc_attr( $button['icon'] ); ?>" aria-hidden="true"></i>
				</span>
			<?php } ?>
			<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'btn-text_' . esc_attr( $i ) ) ); ?> data-elementor-setting-key="<?php echo esc_attr( $text_key ); ?>" data-elementor-inline-editing-toolbar="none"><?php echo wp_kses_post( $button['text'] ); ?></span>
		</span>
		<?php
	}
	
	protected function render() 
	{

		$settings = $this->get_settings_for_display();
		$node_id  = $this->get_id();
		$count    = count( $settings['buttons'] );
		ob_start();
		?>
		<div class="smw-dual-button-outer-wrap">
			<div class="smw-dual-button-wrap">
				<?php
				for ( $i = 0; $i < $count; $i++ ) :
					if ( ! is_array( $settings['buttons'][ $i ] ) ) {
						continue;
					}
					$button = $settings['buttons'][ $i ];

					$this->add_render_attribute( 'button_wrap_' . $i, 'class', 'smw-button-wrapper elementor-button-wrapper smw-dual-button' );
					$this->add_render_attribute( 'button_wrap_' . $i, 'class', 'elementor-repeater-item-' . $button['_id'] );
					$this->add_render_attribute( 'button_wrap_' . $i, 'class', 'smw-dual-button-' . $i );

					$this->add_render_attribute( 'button_' . $i, 'class', 'elementor-button-link elementor-button' );

					if ( '' !== $button['css_classes'] ) {
						$this->add_render_attribute( 'button_' . $i, 'class', $button['css_classes'] );
					}

					if ( '' !== $settings['size'] ) {
						$this->add_render_attribute( 'button_' . $i, 'class', 'elementor-size-' . $settings['size'] );
					}

					if ( '' !== $button['css_id'] ) {
						$this->add_render_attribute( 'button_' . $i, 'id', $button['css_id'] );
					}

					if ( ! empty( $button['link']['url'] ) ) {
						$this->add_render_attribute( 'button_' . $i, 'href', $button['link']['url'] );
						$this->add_render_attribute( 'button_' . $i, 'class', 'elementor-button-link' );

						if ( $button['link']['is_external'] ) {
							$this->add_render_attribute( 'button_' . $i, 'target', '_blank' );
						}

						if ( $button['link']['nofollow'] ) {
							$this->add_render_attribute( 'button_' . $i, 'rel', 'nofollow' );
						}
					}

					if ( $settings['hover_animation'] ) {
						$this->add_render_attribute( 'button_' . $i, 'class', 'elementor-animation-' . $settings['hover_animation'] );
					}
					?>
				<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'button_wrap_' . esc_attr( $i ) ) ); ?>>
					<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'button_' . esc_attr( $i ) ) ); ?>>
						<?php $this->render_button_text( $button, $i ); ?>
					</a>
				</div>
				<?php endfor; ?>
			</div>
		</div>
		<?php
		$html = ob_get_clean();
		echo wp_kses_post( $html );
	}

	protected function content_template() {
		?>
		<div class="smw-dual-button-outer-wrap">
			<div class="smw-dual-button-wrap">
				<#
					var iconsHTML = {};
					if ( settings.buttons ) {
						var counter = 1;
						_.each( settings.buttons, function( item, index ) {

							var button_wrap = 'elementor-repeater-item-' + item._id + ' smw-dual-button-' + counter;

							var button_class = 'elementor-size-' + settings.size + ' ' + item.css_classes;

						var buttonContentKey = view.getRepeaterSettingKey( 'text', 'buttons', index );
						view.addRenderAttribute(buttonContentKey, 'class', 'elementor-button-text' );
						view.addInlineEditingAttributes( buttonContentKey, 'advanced' );

							button_wrap += ' elementor-animation-' + settings.hover_animation;
							var new_icon_align = '';
							var icon_align = '';	
				#>
				<div class="smw-button-wrapper elementor-button-wrapper smw-dual-button {{ button_wrap }}">
					<a id="{{ item.css_id }}" href="{{ item.link.url }}" class="elementor-button-link elementor-button {{ button_class }}">
						<# new_icon_align = ' smw-buttons-icon-' + item.icon_align; #>
						<span class="elementor-button-content-wrapper{{ new_icon_align }}">
							<?php if ( class_exists( 'Elementor\Icons_Manager' ) ) { ?>
								<#
								if ( item.icon || item.new_icon ) {
									icon_align = 'elementor-align-icon-' + item.icon_align;
								#>
									<span class="elementor-button-icon {{ icon_align }}">
										<# 	
											iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.new_icon, { 'aria-hidden': true }, 'i' , 'object' );
											migrated = elementor.helpers.isIconMigrated( item, 'new_icon' );
										#>
										<# 
											if ( ( ! item.icon || migrated ) && iconsHTML[ index ] && iconsHTML[ index ].rendered ) {
										#>
												{{{ iconsHTML[ index ].value }}}
											<# } else { #>

												<i class="{{ item.icon }}" aria-hidden="true"></i>
											<# } #>
									</span>
								<# } #>
							<?php } else { ?>
								<# if ( item.icon ) {
									icon_align = 'elementor-align-icon-' + item.icon_align;
									#>
									<span class="elementor-button-icon {{ icon_align }}">
										<i class="{{ item.icon }}" aria-hidden="true"></i>
									</span>
								<# } #>
							<?php } ?>	
							<span {{{ view.getRenderAttributeString( buttonContentKey ) }}} >{{ item.text }}</span>
						</span>
					</a>
				</div>
				<#
					counter++;
					});
				}
				#>
			</div>
		</div>
		<?php
	}
	
	protected function _content_template() 
	{ 
		$this->content_template();
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_multi_buttons() );