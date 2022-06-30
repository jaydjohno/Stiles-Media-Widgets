<?php

/**
 * SMW Countdown Timer.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_countdown_timer extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'countdown-timer-css', plugin_dir_url( __FILE__ ) .  '../css/countdown-timer.css');
        
        wp_register_script( 'countdown-timer-js', plugin_dir_url( __FILE__ ) . '../js/countdown-timer.js' );
        wp_register_script( 'countdown-handler-js', plugin_dir_url( __FILE__ ) . '../js/countdown-handler.js' );
    }
    
    public function get_name()
    {
        return 'stiles-countdown-timer';
    }
    
    public function get_title()
    {
        return 'Countdown Timer';
    }
    
    public function get_icon()
    {
        return 'eicon-countdown';
    }
    
    public function get_categories()
    {
        return [ 'stiles-media-category' ];
    }
    
    public function get_style_depends() 
    {
        return [ 'countdown-timer-css' ];
    }
    
    public function get_script_depends() 
    {
		return [ 
		    'countdown-timer-js' ,
		    'countdown-handler-js'
		];
	}
    
    protected function register_controls() {
		$this->start_controls_section(
			'countdown_timer_global_settings',
			[
				'label'		=> __( 'Countdown', smw_slug )
			]
		);

		$this->add_control(
			'countdown_timer_style',
		  	[
		     	'label'			=> __( 'Style', smw_slug ),
		     	'type' 			=> Controls_Manager::SELECT,
		     	'options' 		=> [
		     		'd-u-s' => __( 'Inline', smw_slug ),
		     		'd-u-u' => __( 'Block', smw_slug ),
		     	],
		     	'default'		=> 'd-u-u'
		  	]
		);

		$this->add_control(
			'countdown_timer_date_time',
		  	[
		     	'label'			=> __( 'Due Date', smw_slug ),
		     	'type' 			=> Controls_Manager::DATE_TIME,
		     	'picker_options'	=> [
		     		'format' => 'Ym/d H:m:s'
		     	],
		     	'default' => date( "Y/m/d H:m:s", strtotime("+ 1 Day") ),
				'description' => __( 'Date format is (yyyy/mm/dd). Time format is (hh:mm:ss). Example: 2020-01-01 09:30.', smw_slug )
		  	]
		);

		$this->add_control(
			'countdown_timer_s_u_time',
			[
				'label' 		=> __( 'Time Zone', smw_slug ),
				'type' 			=> Controls_Manager::SELECT,
				'options' 		=> [
					'wp-time'			=> __('WordPress Default', smw_slug ),
					'user-time'			=> __('User Local Time', smw_slug )
				],
				'default'		=> 'wp-time',
				'description'	=> __('This will set the current time of the option that you will choose.', smw_slug)
			]
		);

		$this->add_control(
			'countdown_timer_units',
		  	[
		     	'label'			=> __( 'Time Units', smw_slug ),
		     	'type' 			=> Controls_Manager::SELECT2,
				'description' => __('Select the time units that you want to display in countdown timer.', smw_slug ),
				'options'		=> [
					'Y'     => __( 'Years', smw_slug ),
					'O'     => __( 'Month', smw_slug ),
					'W'     => __( 'Week', smw_slug ),
					'D'     => __( 'Day', smw_slug ),
					'H'     => __( 'Hours', smw_slug ),
					'M'     => __( 'Minutes', smw_slug ),
					'S' 	=> __( 'Second', smw_slug ),
				],
				'default' 		=> [ 'O', 'D', 'H', 'M', 'S' ],
				'multiple'		=> true,
				'separator'		=> 'after'
		  	]
		);
        
        $this->add_control('countdown_timer_separator',
            [
                'label'         => __('Digits Separator', smw_slug),
                'description'   => __('Enable or disable digits separator',smw_slug),
                'type'          => Controls_Manager::SWITCHER,
                'condition'     => [
                    'countdown_timer_style'   => 'd-u-u'
                ]
            ]
        );
        
        $this->add_control(
			'countdown_timer_separator_text',
			[
				'label'			=> __('Separator Text', smw_slug),
				'type'			=> Controls_Manager::TEXT,
				'condition'		=> [
                    'countdown_timer_style'   => 'd-u-u',
					'countdown_timer_separator' => 'yes'
				],
				'default'		=> ':'
			]
		);
        
        $this->add_responsive_control(
            'countdown_timer_align',
                [
                    'label'         => __( 'Alignment', smw_slug ),
                    'type'          => Controls_Manager::CHOOSE,
                    'options'       => [
                        'left'      => [
                            'title'=> __( 'Left', smw_slug ),
                            'icon' => 'fa fa-align-left',
                            ],
                        'center'    => [
                            'title'=> __( 'Center', smw_slug ),
                            'icon' => 'fa fa-align-center',
                            ],
                        'right'     => [
                            'title'=> __( 'Right', smw_slug ),
                            'icon' => 'fa fa-align-right',
                            ],
                        ],
                    'toggle'        => false,
                    'default'       => 'center',
                    'selectors'     => [
                        '{{WRAPPER}} .countdown-timer' => 'justify-content: {{VALUE}};',
                        ],
                    ]
                );

		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_timer_on_expire_settings',
			[
				'label' => __( 'Expire' , smw_slug )
			]
		);

		$this->add_control(
			'countdown_timer_expire_text_url',
			[
				'label'			=> __('Expire Type', smw_slug),
				'label_block'	=> false,
				'type'			=> Controls_Manager::SELECT,
                'description'   => __('Choose whether if you want to set a message or a redirect link', smw_slug),
				'options'		=> [
					'text'		=> __('Message', smw_slug),
					'url'		=> __('Redirection Link', smw_slug)
				],
				'default'		=> 'text'
			]
		);

		$this->add_control(
			'countdown_timer_expiry_text_',
			[
				'label'			=> __('On expiry Text', smw_slug),
				'type'			=> Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
				'default'		=> __('Countdown is finished!','prmeium_elementor'),
				'condition'		=> [
					'countdown_timer_expire_text_url' => 'text'
				]
			]
		);

		$this->add_control(
			'countdown_timer_expiry_redirection_',
			[
				'label'			=> __('Redirect To', smw_slug),
				'type'			=> Controls_Manager::TEXT,
                'dynamic'       => [
                    'active' => true,
                    'categories' => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ]
                ],
				'condition'		=> [
					'countdown_timer_expire_text_url' => 'url'
				],
				'default'		=> get_permalink( 1 )
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_timer_transaltion',
			[
				'label' => __( 'Strings Translation' , smw_slug )
			]
		);

		$this->add_control(
			'countdown_timer_day_singular',
		  	[
		     	'label'			=> __( 'Day (Singular)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Day'
		  	]
		);

		$this->add_control(
			'countdown_timer_day_plural',
		  	[
		     	'label'			=> __( 'Day (Plural)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Days'
		  	]
		);

		$this->add_control(
			'countdown_timer_week_singular',
		  	[
		     	'label'			=> __( 'Week (Singular)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Week'
		  	]
		);

		$this->add_control(
			'countdown_timer_week_plural',
		  	[
		     	'label'			=> __( 'Weeks (Plural)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Weeks'
		  	]
		);


		$this->add_control(
			'countdown_timer_month_singular',
		  	[
		     	'label'			=> __( 'Month (Singular)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Month'
		  	]
		);


		$this->add_control(
			'countdown_timer_month_plural',
		  	[
		     	'label'			=> __( 'Months (Plural)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Months'
		  	]
		);


		$this->add_control(
			'countdown_timer_year_singular',
		  	[
		     	'label'			=> __( 'Year (Singular)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Year'
		  	]
		);


		$this->add_control(
			'countdown_timer_year_plural',
		  	[
		     	'label'			=> __( 'Years (Plural)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Years'
		  	]
		);


		$this->add_control(
			'countdown_timer_hour_singular',
		  	[
		     	'label'			=> __( 'Hour (Singular)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Hour'
		  	]
		);


		$this->add_control(
			'countdown_timer_hour_plural',
		  	[
		     	'label'			=> __( 'Hours (Plural)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Hours'
		  	]
		);


		$this->add_control(
			'countdown_timer_minute_singular',
		  	[
		     	'label'			=> __( 'Minute (Singular)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Minute'
		  	]
		);

		$this->add_control(
			'countdown_timer_minute_plural',
		  	[
		     	'label'			=> __( 'Minutes (Plural)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Minutes'
		  	]
		);

        $this->add_control(
			'countdown_timer_second_singular',
		  	[
		     	'label'			=> __( 'Second (Singular)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Second',
		  	]
		);
        
		$this->add_control(
			'countdown_timer_second_plural',
		  	[
		     	'label'			=> __( 'Seconds (Plural)', smw_slug ),
		     	'type' 			=> Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
		     	'default'		=> 'Seconds'
		  	]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_timer_typhography',
			[
				'label' => __( 'Digits' , smw_slug ),
				'tab' 			=> Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'countdown_timer_digit_color',
			[
				'label' 		=> __( 'Colour', smw_slug ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Color::get_type(),
				    'value' => Color::COLOR_2,
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'countdown_timer_digit_typo',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount',
				'separator'		=> 'after'
			]
		);
        
        
        $this->add_control(
			'countdown_timer_timer_digit_bg_color',
			[
				'label' 		=> __( 'Background Colour', smw_slug ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Color::get_type(),
				    'value' => Color::COLOR_1,
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount' => 'background-color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'countdown_timer_units_shadow',
                'selector'      => '{{WRAPPER}} .countdown .pre_countdown-section',
            ]
        );
        
        $this->add_responsive_control(
			'countdown_timer_digit_bg_size',
		  	[
		     	'label'			=> __( 'Background Size', smw_slug ),
		     	'type' 			=> Controls_Manager::SLIDER,
                'default'       => [
                    'size'  => 30
                ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 400,
					]
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount' => 'padding: {{SIZE}}px;'
				]
		  	]
		);
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'          => 'countdown_timer_digits_border',
                    'selector'      => '{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount',
                ]);

        $this->add_control('countdown_timer_digit_border_radius',
                [
                    'label'         => __('Border Radius', smw_slug),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', '%', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-amount' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );
        
        $this->end_controls_section();
        
        $this->start_controls_section('countdown_timer_unit_style', 
            [
                'label'         => __('Units', smw_slug),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
            );

        $this->add_control(
			'countdown_timer_unit_color',
			[
				'label' 		=> __( 'Colour', smw_slug ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Color::get_type(),
				    'value' => Color::COLOR_2,
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-period' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'countdown_timer_unit_typo',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-period',
			]
		);
        
        $this->add_control(
			'countdown_timer_unit_backcolor',
			[
				'label' 		=> __( 'Background Colour', smw_slug ),
				'type' 			=> Controls_Manager::COLOR,
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section .pre_countdown-period' => 'background-color: {{VALUE}};'
				]
			]
		);

        $this->add_responsive_control(
			'countdown_timer_separator_width',
			[
				'label'			=> __( 'Spacing in Between', smw_slug ),
				'type' 			=> Controls_Manager::SLIDER,
				'default' 		=> [
					'size' => 40,
				],
				'range' 		=> [
					'px' 	=> [
						'min' => 0,
						'max' => 200,
					]
				],
				'selectors'		=> [
					'{{WRAPPER}} .countdown .pre_countdown-section' => 'margin-right: calc( {{SIZE}}{{UNIT}} / 2 ); margin-left: calc( {{SIZE}}{{UNIT}} / 2 );'
				],
                'condition'		=> [
					'countdown_timer_separator!' => 'yes'
				],
			]
		);

		$this->end_controls_section();
        
        $this->start_controls_section('countdown_timer_separator_style', 
            [
                'label'         => __('Separator', smw_slug),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'		=> [
                    'countdown_timer_style'   => 'd-u-u',
					'countdown_timer_separator' => 'yes'
				],
            ]
            );
        
        $this->add_responsive_control(
			'countdown_timer_separator_size',
		  	[
		     	'label'			=> __( 'Size', smw_slug ),
		     	'type' 			=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					]
				],
				'selectors'		=> [
					'{{WRAPPER}} .pre-countdown_separator' => 'font-size: {{SIZE}}px;'
				]
		  	]
		);

        $this->add_control(
			'countdown_timer_separator_color',
			[
				'label' 		=> __( 'Colour', smw_slug ),
				'type' 			=> Controls_Manager::COLOR,
				'scheme' 		=> [
				    'type' 	=> Color::get_type(),
				    'value' => Color::COLOR_2,
				],
				'selectors'		=> [
					'{{WRAPPER}} .pre-countdown_separator' => 'color: {{VALUE}};'
				]
			]
		);
        
        $this->add_responsive_control('countdown_timer_separator_margin',
                [
                    'label'         => __('Margin', smw_slug),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em'],
                    'selectors'     => [
                        '{{WRAPPER}} .pre-countdown_separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );
        
        $this->end_controls_section();
        
	}

	protected function render( ) {
		
      	$settings = $this->get_settings_for_display();

      	$target_date = str_replace('-', '/', $settings['countdown_timer_date_time'] );
        
      	$formats = $settings['countdown_timer_units'];
      	$format = implode('', $formats );
      	$time = str_replace('-', '/', current_time('mysql') );
      	
      	if( $settings['countdown_timer_s_u_time'] == 'wp-time' ) : 
			$sent_time = $time;
        else:
            $sent_time = '';
        endif;

		$redirect = !empty( $settings['countdown_timer_expiry_redirection_'] ) ? esc_url($settings['countdown_timer_expiry_redirection_']) : '';
        
      	// Singular labels set up
      	$y = !empty( $settings['countdown_timer_year_singular'] ) ? $settings['countdown_timer_year_singular'] : 'Year';
      	$m = !empty( $settings['countdown_timer_month_singular'] ) ? $settings['countdown_timer_month_singular'] : 'Month';
      	$w = !empty( $settings['countdown_timer_week_singular'] ) ? $settings['countdown_timer_week_singular'] : 'Week';
      	$d = !empty( $settings['countdown_timer_day_singular'] ) ? $settings['countdown_timer_day_singular'] : 'Day';
      	$h = !empty( $settings['countdown_timer_hour_singular'] ) ? $settings['countdown_timer_hour_singular'] : 'Hour';
      	$mi = !empty( $settings['countdown_timer_minute_singular'] ) ? $settings['countdown_timer_minute_singular'] : 'Minute';
      	$s = !empty( $settings['countdown_timer_second_singular'] ) ? $settings['countdown_timer_second_singular'] : 'Second';
      	$label = $y."," . $m ."," . $w ."," . $d ."," . $h ."," . $mi ."," . $s;

      	// Plural labels set up
      	$ys = !empty( $settings['countdown_timer_year_plural'] ) ? $settings['countdown_timer_year_plural'] : 'Years';
      	$ms = !empty( $settings['countdown_timer_month_plural'] ) ? $settings['countdown_timer_month_plural'] : 'Months';
      	$ws = !empty( $settings['countdown_timer_week_plural'] ) ? $settings['countdown_timer_week_plural'] : 'Weeks';
      	$ds = !empty( $settings['countdown_timer_day_plural'] ) ? $settings['countdown_timer_day_plural'] : 'Days';
      	$hs = !empty( $settings['countdown_timer_hour_plural'] ) ? $settings['countdown_timer_hour_plural'] : 'Hours';
      	$mis = !empty( $settings['countdown_timer_minute_plural'] ) ? $settings['countdown_timer_minute_plural'] : 'Minutes';
      	$ss = !empty( $settings['countdown_timer_second_plural'] ) ? $settings['countdown_timer_second_plural'] : 'Seconds';
      	$labels1 = $ys."," . $ms ."," . $ws ."," . $ds ."," . $hs ."," . $mis ."," . $ss;
      	
        $expire_text = $settings['countdown_timer_expiry_text_'];
        
      	$pcdt_style = $settings['countdown_timer_style'] == 'd-u-s' ? ' side' : ' down';
        
        if( $settings['countdown_timer_expire_text_url'] == 'text' ){
            $event = 'onExpiry';
            $text = $expire_text;
        }
        
        if( $settings['countdown_timer_expire_text_url'] == 'url' ){
            $event = 'expiryUrl';
            $text = $redirect;
        }
        
        $separator_text = ! empty ( $settings['countdown_timer_separator_text'] ) ? $settings['countdown_timer_separator_text'] : '';
        
        $countdown_settings = [
            'label1'    => $label,
            'label2'    => $labels1,
            'until'     => $target_date,
            'format'    => $format,
            'event'     => $event,
            'text'      => $text,
            'serverSync'=> $sent_time,
            'separator' => $separator_text
        ];
        
      	?>
        <div id="countDownContainer-<?php echo esc_attr($this->get_id()); ?>" class="countdown-timer countdown-timer-separator-<?php  echo $settings['countdown_timer_separator']; ?>" data-settings='<?php echo wp_json_encode( $countdown_settings ); ?>'>
            <div id="countdown-<?php echo esc_attr( $this->get_id() ); ?>" class="countdown-timer-init countdown<?php echo $pcdt_style; ?>"></div>
        </div>
      	<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_countdown_timer() );