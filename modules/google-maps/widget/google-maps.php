<?php

/**
 * SMW Google Maps.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Plugin;

use StilesMediaWidgets\SMW_Helper;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_google_maps extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'google-maps-css', plugin_dir_url( __FILE__ ) .  '../css/google-maps.css');
        
        //check Google Maps API key and then load API
        $map_key = smw_get_option_label_text( 'google_maps_key', 'smw_general_tabs', '' );
        
        if ( isset( $map_key ) && $map_key != '' ) 
        {
            wp_register_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . $map_key );
        
            //now GM API is Added, we can add the Google Maps JS
            wp_register_script( 'google-maps-js', plugin_dir_url( __FILE__ ) . '../js/google-maps.js' );
        }

    }
    
    public function get_name()
    {
        return 'stiles-google-maps';
    }
    
    public function get_title()
    {
        return 'Google Maps';
    }
    
    public function get_icon()
    {
        return 'eicon-google-maps';
    }
    
    public function get_categories()
    {
        return [ 'stiles-media-category' ];
    }
    
    public function get_style_depends() 
    {
        return [ 'google-maps-css' ];
    }
    
     public function get_script_depends() 
     {
        return [ 
            'google-maps-api',
            'google-maps-js'
        ];
    }
    
    protected function register_controls() 
    {
	    $this->start_controls_section(
	        'general',
            [
                'label' => __('General', smw_slug)
            ]
        );

	    $map_key = smw_get_option_label_text( 'google_maps_key', 'smw_general_tabs', '' );
	    
	    if(!isset($map_key) || $map_key == '')
	    {
		    $this->add_control(
			    'notice',
			    [
				    'type'  => Controls_Manager::RAW_HTML,
				    'raw'   => '<div class="smw-notice">
                                <a target="_blank" href="' . admin_url('admin.php?page=stiles') . '">Click Here</a> to add the Google Maps API key.
                            </div>'
			    ]
		    );
        }
        
        $repeater = new Repeater();

        $repeater->add_control(
	    	'lat',
		    [
		    	'label' => __('Latitude', smw_slug),
			    'type'  => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
			    'placeholder' => __('Enter latitude value here', smw_slug)
		    ]
	    );

		$repeater->add_control(
			'long',
			[
				'label' => __('Longitude', smw_slug),
				'type'  => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
				'placeholder' => __('Enter longitude value here', smw_slug)
			]
		);

		$repeater->add_control(
			'address',
			[
				'label' => __('Address', smw_slug),
				'type'  => Controls_Manager::WYSIWYG,
                'dynamic' => [
                    'active' => true,
                ],
				'placeholder' => __('Enter address', smw_slug)
			]
		);

		$repeater->add_control(
			'icon',
			[
				'label' => __('Icon', smw_slug),
				'type'  => Controls_Manager::MEDIA
			]
		);

		$repeater->add_control(
		    'icon_size',
            [
                'label' => __('Icon Size', smw_slug),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
	                'px' => [
		                'min' => 20,
		                'max' => 200,
	                ],
                ],
                'default' => [
	                'size' => 50,
	                'unit' => 'px',
                ]
            ]
        );

		$repeater->add_control(
			'info_window_onload',
			[
				'label' =>  __('Info Window On Load' , smw_slug),
				'type'  =>  Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => __( 'Open', smw_slug ),
				'label_off'    => __( 'Close', smw_slug ),
				'return_value' => 'yes',
			]
		);

		$this->add_control('markers',
			[
				'label' => __('Markers', smw_slug),
				'type'  => Controls_Manager::REPEATER,
				'fields' => array_values($repeater->get_controls()),
                'default' => [
                        [
                            'lat' => '51.5033',
                            'long' => '-0.119519',
                            'address' => __('Put Address Here', smw_slug)
                        ]
                ]
			]
		);
	    

		$this->add_responsive_control(
			'height',
			[
				'label' => __('Height',smw_slug),
				'type'  => Controls_Manager::NUMBER,
				'default' => 200,
				'selectors' => [
					'{{WRAPPER}} .smw-markers' => 'height:{{VALUE}}px'
				]
			]
		);
		$this->add_control(
			'zoom',
			[
				'label' => __('Zoom',smw_slug),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
			]
		);

		$this->add_control(
		        'animate',
                [
                        'label' =>  __('Animate Marker' , smw_slug),
                        'type'  =>  Controls_Manager::SWITCHER,
                        'default'      => '',
                        'label_on'     => __( 'Yes', smw_slug ),
                        'label_off'    => __( 'No', smw_slug ),
                        'return_value' => 'yes',
                ]
        );

		$this->add_control(
			'snazzy_style',
			[
				'label' => __( 'Snazzy Style', smw_slug ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => __('Add style from Snazzy Maps. Copy and Paste style array from here -> <a href="https://snazzymaps.com/explore" target="_blank">Snazzy Maps</a>')
			]
		);

	    $this->end_controls_section();
	}

	protected function render( )
	{
        $settings = $this->get_settings_for_display();

        $markers = $settings['markers'];

        $this->add_render_attribute('wrapper', 'data-zoom', $settings['zoom']['size']);

        $this->add_render_attribute('wrapper', 'data-style', $settings['snazzy_style']);

        $this->add_render_attribute('wrapper' , 'data-animate' , 'animate-'.$settings['animate']);

        //$this->add_render_attribute('wrapper' , 'data-show-info-window-onload' , $settings['open_info_window_onload']);

        if( count($markers) )
        {
        	?>
	        <div class="smw-markers" <?php echo $this->get_render_attribute_string('wrapper'); ?>>
			<?php
        	foreach($markers as $marker){
				?>
		        <div class="marker" data-lng="<?php echo $marker['long']; ?>" data-lat="<?php echo $marker['lat']; ?>" data-icon="<?php echo $marker['icon']['url']; ?>" data-icon-size="<?php echo $marker['icon_size']['size']; ?>" data-info-window="<?php echo $marker['info_window_onload']; ?>">
			        <?php echo $marker['address']; ?>
		        </div>
		        <?php
	        }
	        ?>
	        </div>
			<?php
        }
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_google_maps() );