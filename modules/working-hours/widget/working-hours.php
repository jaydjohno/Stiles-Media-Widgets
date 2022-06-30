<?php

/**
 * Stiles Media Widgets Working Hours.
 *
 * @package SMW
 */
 
namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Repeater;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

class stiles_working_hours extends \Elementor\Widget_Base 
{

    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'working-hours-style', plugin_dir_url( __FILE__ ) . '../css/working-hours.css');
    }
  
  public function get_name()
    {
        return 'stiles-working-hours';
    }
    
    public function get_title()
    {
        return 'Working Hours';
    }
    
    public function get_icon()
    {
        return 'eicon-clock-o';
    }
    
    public function get_categories()
    {
        return ['stiles-media-category'];
    }

  public function get_style_depends() {
    return [ 'working-hours-style' ];
  }

    protected function get_days() 
    {
        return [
          'Monday'    => __( 'Monday', smw_slug ),
          'Tuesday'   => __( 'Tuesday', smw_slug ),
          'Wednesday' => __( 'Wednesday', smw_slug ),
          'Thursday'  => __( 'Thursday', smw_slug ),
          'Friday' => __( 'Friday', smw_slug ),
          'Saturday' => __( 'Saturday', smw_slug ),
          'Sunday' => __( 'Sunday', smw_slug ),
        ];
    }
  
    protected function get_hours()
    {
        $options = array();
    
        for( $i=0; $i<24; $i++ ) {
          $hour = $i;
     
          if ( $hour < 10 ) {
            $hour = '0' . $hour;
          }
          $options[ $hour . ':00' ] = $hour . ':00';
        }
        
        return $options;
    }
    
    protected function get_closed()
    {
        return [
          'Closed'    => __( 'Closed', smw_slug ),
          'Appointment Only'   => __( 'Appointment Only', smw_slug ),
        ];
    }

    protected function register_working_hours_control()
    {
        $this->start_controls_section(
			'section_business_days',
			array(
				'label' => __( 'Working Hours', smw_slug ),
			)
		);
		
		    $repeater = new Repeater();
		    
    		$repeater->add_control(
    			'business_closed',
    			array(
    				'label'        => __( 'Closed', smw_slug ),
    				'type'         => Controls_Manager::SWITCHER,
    				'label_on'     => __( 'YES', smw_slug ),
    				'label_off'    => __( 'NO', smw_slug ),
    				'return_value' => 'yes',
    				'default'      => 'no',
    				'separator'    => 'before',
    			)
    		);
    
    		$repeater->add_control(
    			'enter_day',
    			array(
    			    'label' => __( 'Enter Day', smw_slug ),
    				'type' => Controls_Manager::SELECT,
    				'options' => $this->get_days(),
    				'default' => 'Monday',
    				'label_block' => true,
    			)
    		);
    
    		$repeater->add_control(
    			'enter_start_time',
    			array(
    				'label'       => __( 'Enter Start Time', smw_slug ),
    				'type'        => Controls_Manager::SELECT,
    				'options' => $this->get_hours(),
    				'default' => '08:30',
    				'label_block' => true,
    				'condition' => array(
    					'business_closed!' => 'yes',
    				),
    			)
    		);
    		
    		$repeater->add_control(
    			'enter_closed_start_time',
    			array(
    				'label'       => __( 'Enter Start Time', smw_slug ),
    				'type'        => Controls_Manager::SELECT,
    				'options' => $this->get_closed(),
    				'default' => 'Closed',
    				'label_block' => true,
    				'condition' => array(
    					'business_closed' => 'yes',
    				),
    			)
    		);
    		
    		$repeater->add_control(
    			'enter_end_time',
    			array(
    				'label'       => __( 'Enter End Time', smw_slug ),
    				'type'        => Controls_Manager::SELECT,
    				'options' => $this->get_hours(),
    				'default' => '16:30',
    				'label_block' => true,
    				'condition' => array(
    					'business_closed!' => 'yes',
    				),
    			)
    		);
    		
    		$repeater->add_control(
    			'enter_closed_end_time',
    			array(
    				'label'       => __( 'Enter End Time', smw_slug ),
    				'type'        => Controls_Manager::SELECT,
    				'options' => $this->get_closed(),
    				'default' => 'Closed',
    				'label_block' => true,
    				'condition' => array(
    					'business_closed' => 'yes',
    				),
    			)
    		);
    		
    		$repeater->add_control(
    			'current_styling_heading',
    			array(
    				'label'     => __( 'Styling', smw_slug ),
    				'type'      => Controls_Manager::HEADING,
    				'separator' => 'before',
    			)
    		);
    
    		$repeater->add_control(
    			'style_days',
    			array(
    				'label'        => __( 'Style This Day', smw_slug ),
    				'type'         => Controls_Manager::SWITCHER,
    				'label_on'     => __( 'YES', smw_slug ),
    				'label_off'    => __( 'NO', smw_slug ),
    				'return_value' => 'yes',
    				'default'      => 'no',
    				'separator'    => 'before',
    			)
    		);
    
    		$repeater->add_control(
    			'single_business_day_colour',
    			array(
    				'label'     => __( 'Day Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'scheme'    => array(
    					'type'  => Color::get_type(),
    					'value' => Color::COLOR_2,
    				),
    				'default'   => '#db6159',
    				'selectors' => array(
    					'{{WRAPPER}} {{CURRENT_ITEM}} .smw-working-hours-highlight' => 'color: {{VALUE}}',
    				),
    				'condition' => array(
    					'style_days' => 'yes',
    				),
    				'separator' => 'before',
    			)
    		);
    
    		$repeater->add_control(
    			'single_business_timing_colour',
    			array(
    				'label'     => __( 'Time Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'scheme'    => array(
    					'type'  => Color::get_type(),
    					'value' => Color::COLOR_4,
    				),
    				'default'   => '#db6159',
    				'selectors' => array(
    					'{{WRAPPER}} {{CURRENT_ITEM}} .uael-business-timing-highlight' => 'color: {{VALUE}}',
    				),
    				'condition' => array(
    					'style_days' => 'yes',
    				),
    				'separator' => 'before',
    			)
    		);
    
    		$repeater->add_control(
    			'single_business_background_colour',
    			array(
    				'label'     => __( 'Background Colour', smw_slug ),
    				'type'      => Controls_Manager::COLOR,
    				'selectors' => array(
    					'{{WRAPPER}} .smw-days {{CURRENT_ITEM}}.top-border-divider' => 'background-color: {{VALUE}}',
    				),
    				'condition' => array(
    					'style_days' => 'yes',
    				),
    				'separator' => 'before',
    			)
    		);
    
    		$this->add_control(
    			'business_days_timings',
    			array(
    				'type'        => Controls_Manager::REPEATER,
    				'fields'      => array_values( $repeater->get_controls() ),
    				'default'     => array(
    					array(
    						'enter_day'  => __( 'Monday', smw_slug ),
    						'enter_start_time' => __( '08:00', smw_slug ),
    						'enter_end_time' => __( '19:00', smw_slug ),
    						'enter_closed_start_time' => __( 'Closed', smw_slug ),
    						'enter_closed_end_time' => __( 'Closed', smw_slug ),
    						'business_closed' => __( 'no', smw_slug ),
    					),
    					array(
    						'enter_day'  => __( 'Tuesday', smw_slug ),
    						'enter_start_time' => __( '08:00', smw_slug ),
    						'enter_end_time' => __( '19:00', smw_slug ),
    						'enter_closed_start_time' => __( 'Closed', smw_slug ),
    						'enter_closed_end_time' => __( 'Closed', smw_slug ),
    						'business_closed' => __( 'no', smw_slug ),
    					),
    					array(
    						'enter_day'  => __( 'Wednesday', smw_slug ),
    						'enter_start_time' => __( '08:00', smw_slug ),
    						'enter_end_time' => __( '19:00', smw_slug ),
    						'enter_closed_start_time' => __( 'Closed', smw_slug ),
    						'enter_closed_end_time' => __( 'Closed', smw_slug ),
    						'business_closed' => __( 'no', smw_slug ),
    					),
    					array(
    						'enter_day'  => __( 'Thursday', smw_slug ),
    						'enter_start_time' => __( '08:00', smw_slug ),
    						'enter_end_time' => __( '19:00', smw_slug ),
    						'enter_closed_start_time' => __( 'Closed', smw_slug ),
    						'enter_closed_end_time' => __( 'Closed', smw_slug ),
    						'business_closed' => __( 'no', smw_slug ),
    					),
    					array(
    						'enter_day'  => __( 'Friday', smw_slug ),
    						'enter_start_time' => __( '08:00', smw_slug ),
    						'enter_end_time' => __( '19:00', smw_slug ),
    						'enter_closed_start_time' => __( 'Closed', smw_slug ),
    						'enter_closed_end_time' => __( 'Closed', smw_slug ),
    						'business_closed' => __( 'no', smw_slug ),
    					),
    					array(
    						'enter_day'      => __( 'Saturday', smw_slug ),
    						'enter_start_time' => __( '08:00', smw_slug ),
    						'enter_end_time' => __( '19:00', smw_slug ),
    						'enter_closed_start_time' => __( 'Closed', smw_slug ),
    						'enter_closed_end_time' => __( 'Closed', smw_slug ),
    						'style_days' => __( 'yes', smw_slug ),
    						'business_closed' => __( 'yes', smw_slug ),
    					),
    					array(
    						'enter_day'      => __( 'Sunday', smw_slug ),
    						'enter_start_time' => __( '08:00', smw_slug ),
    						'enter_end_time' => __( '19:00', smw_slug ),
    						'enter_closed_start_time' => __( 'Closed', smw_slug ),
    						'enter_closed_end_time' => __( 'Closed', smw_slug ),
    						'style_days' => __( 'yes', smw_slug ),
    						'business_closed' => __( 'yes', smw_slug ),
    					),
    				),
    				'title_field' => '{{{ enter_day }}}',
    			)
    		);

		$this->end_controls_section();
    }
    
    protected function register_general_style_controls()
    {
		$this->start_controls_section(
			'section_bs_general',
			array(
				'label' => __( 'General', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'section_bs_list_padding',
			array(
				'label'      => __( 'Row Spacing', smw_slug ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} div.smw-days div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
    }
    
    protected function register_divider_style_controls()
    {
		$this->start_controls_section(
			'section_bs_divider',
			array(
				'label' => __( 'Divider', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'day_divider',
			array(
				'label'        => __( 'Divider', smw_slug ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'YES', smw_slug ),
				'label_off'    => __( 'NO', smw_slug ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'day_divider_style',
			array(
				'label'     => __( 'Style', smw_slug ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => __( 'Solid', smw_slug ),
					'dotted' => __( 'Dotted', smw_slug ),
					'dashed' => __( 'Dashed', smw_slug ),
				),
				'default'   => 'solid',
				'selectors' => array(
					'{{WRAPPER}} .smw-working-hours-box-wrapper div.smw-days div.top-border-divider:not(:first-child)' => 'border-top-style: {{VALUE}};',
				),
				'condition' => array(
					'day_divider' => 'yes',
				),
			)
		);

		$this->add_control(
			'day_divider_colour',
			array(
				'label'     => __( 'Colour', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d4d4d4',
				'selectors' => array(
					'{{WRAPPER}} .smw-working-hours-box-wrapper div.smw-days div.top-border-divider:not(:first-child)' => 'border-top-color: {{VALUE}};',
				),
				'condition' => array(
					'day_divider' => 'yes',
				),
			)
		);

		$this->add_control(
			'day_divider_weight',
			array(
				'label'     => __( 'Weight', smw_slug ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 1,
					'unit' => 'px',
				),
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .smw-working-hours-box-wrapper div.smw-days div.top-border-divider:not(:first-child)' => 'border-top-width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'day_divider' => 'yes',
				),
			)
		);

		$this->end_controls_section();
    }
    
    protected function register_business_style_control()
    {
        $this->start_controls_section(
			'section_business_day_style',
			array(
				'label' => __( 'Day and Time', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'business_hours_day_align',
			array(
				'label'     => __( 'Day Alignment', smw_slug ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', smw_slug ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', smw_slug ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', smw_slug ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} div.smw-days .heading-date' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'business_hours_time_align',
			array(
				'label'     => __( 'Time Alignment', smw_slug ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', smw_slug ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', smw_slug ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', smw_slug ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} div.smw-days .heading-time' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'business_day_colour',
			array(
				'label'     => __( 'Day Colour', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} .smw-business-day' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-widget-container' => 'overflow: hidden;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'    => __( 'Day Typography', smw_slug ),
				'name'     => 'business_day_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .smw-business-day',
			)
		);

		$this->add_control(
			'business_timing_colour',
			array(
				'label'     => __( 'Time Colour', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				),
				'selectors' => array(
					'{{WRAPPER}} .smw-business-time' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'    => __( 'Time Typography', smw_slug ),
				'name'     => 'business_timings_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .smw-business-time',
			)
		);

		$this->add_control(
			'striped_effect_feature',
			array(
				'label'        => __( 'Striped Effect', smw_slug ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'YES', smw_slug ),
				'label_off'    => __( 'NO', smw_slug ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'striped_effect_odd',
			array(
				'label'     => __( 'Striped Odd Rows Colour', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eaeaea',
				'selectors' => array(
					'{{WRAPPER}} .top-border-divider:nth-child(odd)' => 'background: {{VALUE}};',
				),
				'condition' => array(
					'striped_effect_feature' => 'yes',
				),
			)
		);

		$this->add_control(
			'striped_effect_even',
			array(
				'label'     => __( 'Striped Even Rows Colour', smw_slug ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .top-border-divider:nth-child(even)' => 'background: {{VALUE}};',
				),
				'condition' => array(
					'striped_effect_feature' => 'yes',
				),
			)
		);

		$this->end_controls_section();
    }
    
    protected function register_controls() 
    {
        $this->register_working_hours_control();
        
        $this->register_general_style_controls();
        
        $this->register_divider_style_controls();
        
        $this->register_business_style_control();
    }

    protected function render() 
    {
        $settings = $this->get_settings_for_display();
		$node_id  = $this->get_id();
		
		?>
    	<div class="smw-working-hours-box-wrapper">
    	<?php
    	if ( count( $settings['business_days_timings'] ) ) {
    		$count = 0;
    		?>
    		<div class="smw-days">
    			<?php
    			foreach ( $settings['business_days_timings'] as $item ) 
    			{
    			    //Get the current day
    				$repeater_setting__enter_day = $this->get_repeater_setting_key( 'enter_day', 'business_days_timings', $count );
    				$this->add_inline_editing_attributes( $repeater_setting__enter_day );
    				
    				//Get the start time
    				$repeater_setting__enter_start_time = $this->get_repeater_setting_key( 'enter_start_time', 'business_days_timings', $count );
    				$this->add_inline_editing_attributes( $repeater_setting__enter_start_time );
    				
    				//get the end time
    				$repeater_setting__enter_end_time = $this->get_repeater_setting_key( 'enter_end_time', 'business_days_timings', $count );
    				$this->add_inline_editing_attributes( $repeater_setting__enter_end_time );
    
    				$this->add_render_attribute( 'smw-inner-element', 'class', 'smw-inner' );
    				$this->add_render_attribute( 'smw-inner-heading-time', 'class', 'inner-heading-time' );
    				$this->add_render_attribute( 'smw-bs-background' . $item['_id'], 'class', 'elementor-repeater-item-' . $item['_id'] );
    				$this->add_render_attribute( 'smw-bs-background' . $item['_id'], 'class', 'top-border-divider' );
    				
    				if ( 'yes' === $item['highlight_this'] ) {
    					$this->add_render_attribute( 'smw-bs-background' . $item['_id'], 'class', 'smw-highlight-background' );
    				} elseif ( 'yes' === $settings['striped_effect_feature'] ) {
    					$this->add_render_attribute( 'smw-bs-background' . $item['_id'], 'class', 'stripes' );
    				} else {
    					$this->add_render_attribute( 'smw-bs-background' . $item['_id'], 'class', 'bs-background' );
    				}
    				$this->add_render_attribute( 'smw-highlight-day' . $item['_id'], 'class', 'heading-date' );
    				$this->add_render_attribute( 'smw-highlight-time' . $item['_id'], 'class', 'heading-time' );
    				if ( 'yes' === $item['highlight_this'] ) {
    					$this->add_render_attribute( 'smw-highlight-day' . $item['_id'], 'class', 'smw-business-day-highlight' );
    					$this->add_render_attribute( 'smw-highlight-time' . $item['_id'], 'class', 'smw-business-timing-highlight' );
    				} else {
    					$this->add_render_attribute( 'smw-highlight-day' . $item['_id'], 'class', 'smw-business-day' );
    					$this->add_render_attribute( 'smw-highlight-time' . $item['_id'], 'class', 'smw-business-time' );
    				}
    				?>
    				<!-- CURRENT_ITEM div -->
    				<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'smw-bs-background' . esc_attr( $item['_id'] ) ) ); ?>>
    					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'smw-inner-element' ) ); ?>>
    						<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'smw-highlight-day' . esc_attr( $item['_id'] ) ) ); ?>>
    							<span <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__enter_day ) ); ?>><?php echo wp_kses_post( $item['enter_day'] ); ?></span>
    						</span>
    
    						<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'smw-highlight-time' . esc_attr( $item['_id'] ) ) ); ?>>
    							<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'smw-inner-heading-time' ) ); ?>>
    								<?php if( 'yes' === $item["business_closed"] )
    							    { ?>
    							        <span <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__enter_start_time ) ); ?>><?php echo wp_kses_post( $item["enter_closed_start_time"] ); ?></span>
    							    <?php } 
    							    else
    							    { ?>
    							        <span <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__enter_start_time ) ); ?>><?php echo wp_kses_post( $item["enter_start_time"] ); ?></span>
    							    <?php }?>
    							</span>
    						</span>
    						<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'smw-highlight-time' . esc_attr( $item['_id'] ) ) ); ?>>
    							<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'smw-inner-heading-time' ) ); ?>>
    							    <?php echo $settings['business_closed']; ?>
    							    <?php if( 'yes' === $item["business_closed"] )
    							    { ?>
    							    <?php } 
    							    else
    							    { ?>
    							        <span <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting__enter_end_time ) ); ?>><?php echo wp_kses_post( $item["enter_end_time"] ); ?></span>
    							    <?php }?>
    							</span>
    						</span>
    					</div>
    				</div>
    				<?php
    				$count++;
    			}
    			?>
    		</div>
    	<?php	} ?>
    	</div>
    	<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_working_hours() );