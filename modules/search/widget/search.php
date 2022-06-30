<?php

/**
 * SMW Advanced Search Form.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_search extends Widget_Base 
{
	public function get_name() 
	{
		return 'stiles-search';
	}

    public function get_title() 
    {
        return 'Search Form';
    }

    public function get_icon() {
        return 'eicon-search';
    }

    public function get_categories() 
    {
        return ['stiles-media-category'];
    }
    
    public function get_style_depends() 
    {
		if ( Icons_Manager::is_migration_allowed() ) 
		{
			return [ 'elementor-icons-fa-solid' ];
		}
		
		return array();
	}
    
    protected function register_layout_control()
    {
        $this->start_controls_section(
			'search_content',
			array(
				'label' => __( 'Search Form', smw_slug ),
			)
		);

		$this->add_control(
			'skin',
			array(
				'label' => __( 'Skin', smw_slug ),
				'type' => Controls_Manager::SELECT,
				'default' => 'classic',
				'options' => array(
					'classic' => __( 'Classic', smw_slug ),
					'minimal' => __( 'Minimal', smw_slug ),
				),
				'prefix_class' => 'elementor-search-form--skin-',
				'render_type' => 'template',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'placeholder',
			array(
				'label' => __( 'Placeholder', smw_slug ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
				'default' => __( 'Search', smw_slug ) . '...',
			)
		);
		
		$this->add_control(
			'search_options',
			array(
				'label' => __( 'Search For', smw_slug ),
				'type' => Controls_Manager::SELECT,
				'default' => 'keyword',
				'options' => array(
					'keyword' => __( 'Keyword', smw_slug ),
					'post_type' => __( 'Post Type', smw_slug ),
					'product' => __( 'Product', smw_slug ),
				),
			)
		);
		
		$this->add_control(
			'post_types',
			array(
				'label' => __( 'Choose Post Type', smw_slug ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => get_post_types( '', 'names' ),
				'render_type' => 'none',
				'label_block' => true,
				'description' => __( 'Choose the Post Types You want to search', smw_slug ),
				'condition' => array(
					'search_options' => 'post_type',
				),
			)
		);

		$this->add_control(
			'heading_button_content',
			array(
				'label' => __( 'Button', smw_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'skin' => 'classic',
				),
			)
		);

		$this->add_control(
			'button_type',
			array(
				'label' => __( 'Type', smw_slug ),
				'type' => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => array(
					'icon' => __( 'Icon', smw_slug ),
					'text' => __( 'Text', smw_slug ),
				),
				'prefix_class' => 'elementor-search-form--button-type-',
				'render_type' => 'template',
				'condition' => array(
					'skin' => 'classic',
				),
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label' => __( 'Text', smw_slug ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Search', smw_slug ),
				'separator' => 'after',
				'condition' => array(
					'button_type' => 'text',
					'skin' => 'classic',
				),
			)
		);

		$this->add_control(
			'icon',
			array(
				'label' => __( 'Icon', smw_slug ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'search',
				'options' => array(
					'search' => array(
						'title' => __( 'Search', smw_slug ),
						'icon' => 'eicon-search',
					),
					'arrow' => array(
						'title' => __( 'Arrow', smw_slug ),
						'icon' => 'eicon-arrow-right',
					),
				),
				'render_type' => 'template',
				'prefix_class' => 'elementor-search-form--icon-',
				'condition' => array(
					'button_type' => 'icon',
					'skin' => 'classic',
				),
			)
		);

		$this->add_control(
			'size',
			array(
				'label' => __( 'Size', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 50,
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__container' => 'min-height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-search-form__submit' => 'min-width: {{SIZE}}{{UNIT}}',
					'body:not(.rtl) {{WRAPPER}} .elementor-search-form__icon' => 'padding-left: calc({{SIZE}}{{UNIT}} / 3)',
					'body.rtl {{WRAPPER}} .elementor-search-form__icon' => 'padding-right: calc({{SIZE}}{{UNIT}} / 3)',
					'{{WRAPPER}} .elementor-search-form__input, {{WRAPPER}}.elementor-search-form--button-type-text .elementor-search-form__submit' => 'padding-left: calc({{SIZE}}{{UNIT}} / 3); padding-right: calc({{SIZE}}{{UNIT}} / 3)',
				),
				'condition' => array(
					'skin!' => 'full_screen',
				),
			)
		);

		$this->add_control(
			'toggle_button_content',
			array(
				'label' => __( 'Toggle', smw_slug ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'skin' => 'full_screen',
				),
			)
		);

		$this->add_control(
			'toggle_align',
			array(
				'label' => __( 'Alignment', smw_slug ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left' => array(
						'title' => __( 'Left', smw_slug ),
						'icon' => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', smw_slug ),
						'icon' => 'eicon-h-align-center',
					),
					'right' => array(
						'title' => __( 'Right', smw_slug ),
						'icon' => 'eicon-h-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form' => 'text-align: {{VALUE}}',
				),
				'condition' => array(
					'skin' => 'full_screen',
				),
			)
		);

		$this->add_control(
			'toggle_size',
			array(
				'label' => __( 'Size', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 33,
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__toggle i' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
				'condition' => array(
					'skin' => 'full_screen',
				),
			)
		);

		$this->end_controls_section();
    }
    
    protected function register_section_input_controls()
    {
        $this->start_controls_section(
			'section_input_style',
			array(
				'label' => __( 'Input', smw_slug ),
				'tab' => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'icon_size_minimal',
			array(
				'label' => __( 'Icon Size', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__icon' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'condition' => array(
					'skin' => 'minimal',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'overlay_background_color',
			array(
				'label' => __( 'Overlay Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}.elementor-search-form--skin-full_screen .elementor-search-form__container' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'skin' => 'full_screen',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'input_typography',
				'selector' => '{{WRAPPER}} inputtype="search").elementor-search-form__input',
				'scheme' => Schemes\Typography::TYPOGRAPHY_3,
			)
		);

		$this->start_controls_tabs( 'tabs_input_colors' );

		$this->start_controls_tab(
			'tab_input_normal',
			array(
				'label' => __( 'Normal', smw_slug ),
			)
		);

		$this->add_control(
			'input_text_color',
			array(
				'label' => __( 'Text Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__input,
					{{WRAPPER}} .elementor-search-form__icon,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button:hover,
					{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'input_background_color',
			array(
				'label' => __( 'Background Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form__container' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'skin!' => 'full_screen',
				),
			)
		);

		$this->add_control(
			'input_border_color',
			array(
				'label' => __( 'Border Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form__container' => 'border-color: {{VALUE}}',
					'{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'input_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-search-form__container',
				'fields_options' => array(
					'box_shadow_type' => array(
						'separator' => 'default',
					),
				),
				'condition' => array(
					'skin!' => 'full_screen',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_focus',
			array(
				'label' => __( 'Focus', smw_slug ),
			)
		);

		$this->add_control(
			'input_text_color_focus',
			array(
				'label' => __( 'Text Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form--focus .elementor-search-form__input,
					{{WRAPPER}} .elementor-search-form--focus .elementor-search-form__icon,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button:hover,
					{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input:focus' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'input_background_color_focus',
			array(
				'label' => __( 'Background Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form--focus .elementor-search-form__container' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input:focus' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'skin!' => 'full_screen',
				),
			)
		);

		$this->add_control(
			'input_border_color_focus',
			array(
				'label' => __( 'Border Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form--focus .elementor-search-form__container' => 'border-color: {{VALUE}}',
					'{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input:focus' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'input_box_shadow_focus',
				'selector' => '{{WRAPPER}} .elementor-search-form--focus .elementor-search-form__container',
				'fields_options' => array(
					'box_shadow_type' => array(
						'separator' => 'default',
					),
				),
				'condition' => array(
					'skin!' => 'full_screen',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'button_border_width',
			array(
				'label' => __( 'Border Size', smw_slug ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => array(
					'{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form__container' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'border_radius',
			array(
				'label' => __( 'Border Radius', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'default' => array(
					'size' => 3,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form__container' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label' => __( 'Button', smw_slug ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'skin' => 'classic',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .elementor-search-form__submit',
				'scheme' => Schemes\Typography::TYPOGRAPHY_3,
				'condition' => array(
					'button_type' => 'text',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button_colors' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => __( 'Normal', smw_slug ),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label' => __( 'Text Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__submit' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label' => __( 'Background Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__submit' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => __( 'Hover', smw_slug ),
			)
		);

		$this->add_control(
			'button_text_color_hover',
			array(
				'label' => __( 'Text Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__submit:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_background_color_hover',
			array(
				'label' => __( 'Background Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__submit:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'icon_size',
			array(
				'label' => __( 'Icon Size', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__submit' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'condition' => array(
					'button_type' => 'icon',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'button_width',
			array(
				'label' => __( 'Width', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__submit' => 'min-width: calc( {{SIZE}} * {{size.SIZE}}{{size.UNIT}} )',
				),
			)
		);

		$this->end_controls_section();
    }
    
    protected function register_toggle_section_controls()
    {
        $this->start_controls_section(
			'section_toggle_style',
			array(
				'label' => __( 'Toggle', smw_slug ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'skin' => 'full_screen',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_toggle_color' );

		$this->start_controls_tab(
			'tab_toggle_normal',
			array(
				'label' => __( 'Normal', smw_slug ),
			)
		);

		$this->add_control(
			'toggle_color',
			array(
				'label' => __( 'Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__toggle' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'toggle_background_color',
			array(
				'label' => __( 'Background Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__toggle i' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_toggle_hover',
			array(
				'label' => __( 'Hover', smw_slug ),
			)
		);

		$this->add_control(
			'toggle_color_hover',
			array(
				'label' => __( 'Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__toggle:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'toggle_background_color_hover',
			array(
				'label' => __( 'Background Color', smw_slug ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__toggle i:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'toggle_icon_size',
			array(
				'label' => __( 'Icon Size', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__toggle i:before' => 'font-size: calc({{SIZE}}em / 100)',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'toggle_border_width',
			array(
				'label' => __( 'Border Width', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'max' => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__toggle i' => 'border-width: {{SIZE}}{{UNIT}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'toggle_border_radius',
			array(
				'label' => __( 'Border Radius', smw_slug ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'selectors' => array(
					'{{WRAPPER}} .elementor-search-form__toggle i' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
    }
    
    protected function register_controls() 
    {
        $this->register_layout_control();
        
        $this->register_section_input_controls();
        
        $this->register_toggle_section_controls();
    }
    
    protected function render() 
	{
		$settings = $this->get_settings();
		
    		$this->add_render_attribute(
    			'input', [
    				'placeholder' => $settings['placeholder'],
    				'class' => 'elementor-search-form__input',
    				'type' => 'search',
    				'name' => 's',
    				'title' => __( 'Search', smw_slug ),
    				'value' => get_search_query(),
    			]
    		);

		// Set the selected icon.
		$icon_class = '';
		if ( 'icon' == $settings['button_type'] ) {
			$icon_class = 'search';

			if ( 'arrow' == $settings['icon'] ) {
				$icon_class = is_rtl() ? 'arrow-left' : 'arrow-right';
			}

			$this->add_render_attribute( 'icon', [
				'class' => 'fa fa-' . $icon_class,
			] );
		}

		$migration_allowed = Icons_Manager::is_migration_allowed();
		$icon = [
			'value' => 'fas fa-' . $icon_class,
			'library' => 'fa-solid',
		];
		?>
		<form class="elementor-search-form" role="search" action="<?php echo home_url(); ?>" method="get">
			<?php do_action( 'elementor_pro/search_form/before_input', $this ); ?> 
			<div class="elementor-search-form__container">
				<?php if ( 'minimal' === $settings['skin'] ) : ?>
					<div class="elementor-search-form__icon">
						<i class="fa fa-search" aria-hidden="true"></i>
						<span class="elementor-screen-only"><?php esc_html_e( 'Search', smw_slug ); ?></span>
					</div>
				<?php endif; ?>
				    <input <?php echo $this->get_render_attribute_string( 'input' ); ?>>
				<?php if ( 'product' === $settings['search_options'] ) : ?>
                    <input type="hidden" name="post_type" value="product" />
                <?php elseif ( 'post_type' === $settings['search_options'] ) :
                    foreach ( $settings['post_types'] as $element ) 
                    {
			            echo '<input type="hidden" name="post_type" value="' . $element . '" />';
		            }
				endif; ?>
				<?php do_action( 'elementor_pro/search_form/after_input', $this ); ?>
				<?php if ( 'classic' === $settings['skin'] ) : ?>
					<button class="elementor-search-form__submit" type="submit" title="<?php esc_attr_e( 'Search', smw_slug ); ?>" aria-label="<?php esc_attr_e( 'Search', smw_slug ); ?>">
						<?php if ( 'icon' === $settings['button_type'] ) : ?>
							<i <?php echo $this->get_render_attribute_string( 'icon' ); ?> aria-hidden="true"></i>
							<span class="elementor-screen-only"><?php esc_html_e( 'Search', smw_slug ); ?></span>
						<?php elseif ( ! empty( $settings['button_text'] ) ) : ?>
							<?php echo $settings['button_text']; ?>
						<?php endif; ?>
					</button>
				<?php endif; ?>
			</div>
		</form>
		<?php
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_search() );