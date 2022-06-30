<?php

/**
 * pp Advanced Menu.
 *
 * @package pp
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use StilesMediaWidgets\smw_Helper;
use Elementor\Plugin;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_advanced_menu extends Widget_Base 
{
    protected $nav_menu_index = 1;
    
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'advanced-menu-css', plugin_dir_url( __FILE__ ) .  '../css/advanced-menu.css');
        
        wp_register_script( 'advanced-menu-js', plugin_dir_url( __FILE__ ) . '../js/advanced-menu.js' );
        wp_register_script( 'jquery-smartmenu', plugin_dir_url( __FILE__ ) . '../js/jquery-smartmenu.js' );
        wp_register_script( 'advanced-menu-handler', plugin_dir_url( __FILE__ ) . '../js/advanced-menu-handler.js' );
   }

    public function get_name()
    {
        return 'stiles-advanced-menu';
    }
    
    public function get_title()
    {
        return 'Advanced Menu';
    }
    
    public function get_icon()
    {
        return 'eicon-nav-menu';
    }
    
    public function get_categories()
    {
        return array('stiles-media-category');
    }
    
    public function get_script_depends() 
    {
        return [ 
            'advanced-menu-js',
            'jquery-smartmenu',
            'advanced-menu-handler'
        ];
    }
    
    public function get_style_depends() 
    {
        return [ 'advanced-menu-css' ];
    }
    
    public function on_export( $element ) 
    {
		unset( $element['settings']['menu'] );

		return $element;
	}
    
    protected function get_nav_menu_index() 
    {
		return $this->nav_menu_index++;
	}
	
	private function get_available_menus() 
	{
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}
    
    protected function register_controls() 
    { 
	    $this->register_content_layout_controls();
	    
	    $this->register_style_menu_controls();
	}
	
	protected function register_content_layout_controls() 
    {	
    $this->start_controls_section(
        'section_layout',
        array(
            'label'                 => __( 'Menu Layout', smw_slug ),
        )
    );

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				array(
					'label'   => __( 'Menu', smw_slug ),
					'type'    => Controls_Manager::SELECT,
					'options'               => $menus,
					'default'               => array_keys( $menus )[0],
					'separator'             => 'after',
					'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', smw_slug ), admin_url( 'nav-menus.php' ) ),
				)
			);
		} else {
			$this->add_control(
				'menu',
				array(
					'type'                  => Controls_Manager::RAW_HTML,
					'raw' => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', smw_slug ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator'             => 'after',
					'content_classes' => 'smw-editor-info',
				)
			);
		}

		$this->add_control(
			'layout',
			array(
				'label'                 => __( 'Layout', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'horizontal',
				'options'               => array(
					'horizontal' => __( 'Horizontal', smw_slug ),
					'vertical' => __( 'Vertical', smw_slug ),
				),
				'frontend_available'    => true,
			)
		);

		$this->add_control(
			'align_items',
			array(
				'label'                 => __( 'Align', smw_slug ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'options'               => array(
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
					'justify' => array(
						'title' => __( 'Stretch', smw_slug ),
						'icon' => 'eicon-h-align-stretch',
					),
				),
				'condition'             => array(
					'layout!' => 'dropdown',
				),
			)
		);

		$this->add_control(
			'pointer',
			array(
				'label'                 => __( 'Pointer', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'underline',
				'options'               => array(
					'none'					=> __( 'None', smw_slug ),
					'underline'				=> __( 'Underline', smw_slug ),
					'overline'				=> __( 'Overline', smw_slug ),
					'double-line'			=> __( 'Double Line', smw_slug ),
					'framed'				=> __( 'Framed', smw_slug ),
					'background'			=> __( 'Background', smw_slug ),
					'brackets'				=> __( 'Brackets', smw_slug ),
					'right-angle-slides'	=> __( 'Right Angle Slides Down Over Title', smw_slug ),
					'text'					=> __( 'Text', smw_slug ),
				),
				'condition'             => array(
					'layout!' => 'dropdown',
				),
			)
		);

		$this->add_control(
			'animation_line',
			array(
				'label'                 => __( 'Animation', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'fade',
				'options'               => array(
					'fade'		=> 'Fade',
					'slide'		=> 'Slide',
					'grow'		=> 'Grow',
					'drop-in'	=> 'Drop In',
					'drop-out'	=> 'Drop Out',
					'none'		=> 'None',
				),
				'condition'             => array(
					'layout!' => 'dropdown',
					'pointer' => array( 'underline', 'overline', 'double-line' ),
				),
			)
		);

		$this->add_control(
			'animation_framed',
			array(
				'label'                 => __( 'Animation', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'fade',
				'options'               => array(
					'fade'		=> 'Fade',
					'grow'		=> 'Grow',
					'shrink'	=> 'Shrink',
					'draw'		=> 'Draw',
					'corners'	=> 'Corners',
					'none'		=> 'None',
				),
				'condition'             => array(
					'layout!' => 'dropdown',
					'pointer' => 'framed',
				),
			)
		);

		$this->add_control(
			'animation_background',
			array(
				'label'                 => __( 'Animation', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'fade',
				'options'               => array(
					'fade'						=> 'Fade',
					'grow'						=> 'Grow',
					'shrink'					=> 'Shrink',
					'sweep-left'				=> 'Sweep Left',
					'sweep-right'				=> 'Sweep Right',
					'sweep-up'					=> 'Sweep Up',
					'sweep-down'				=> 'Sweep Down',
					'shutter-in-vertical'		=> 'Shutter In Vertical',
					'shutter-out-vertical'		=> 'Shutter Out Vertical',
					'shutter-in-horizontal'		=> 'Shutter In Horizontal',
					'shutter-out-horizontal'	=> 'Shutter Out Horizontal',
					'none' => 'None',
				),
				'condition'             => array(
					'layout!' => 'dropdown',
					'pointer' => 'background',
				),
			)
		);

		$this->add_control(
			'animation_text',
			array(
				'label'                 => __( 'Animation', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'grow',
				'options'               => array(
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'sink' => 'Sink',
					'float' => 'Float',
					'skew' => 'Skew',
					'rotate' => 'Rotate',
					'none' => 'None',
				),
				'condition'             => array(
					'layout!' => 'dropdown',
					'pointer' => 'text',
				),
			)
		);

		$this->add_control(
			'indicator',
			array(
				'label'                 => __( 'Submenu Indicator', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'classic',
				'options'               => array(
					'none' => __( 'None', smw_slug ),
					'classic' => __( 'Classic', smw_slug ),
					'chevron' => __( 'Chevron', smw_slug ),
					'angle' => __( 'Angle', smw_slug ),
					'plus' => __( 'Plus', smw_slug ),
				),
			)
		);

		$this->add_control(
			'heading_mobile_dropdown',
			array(
				'label'                 => __( 'Responsive', smw_slug ),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'condition'             => array(
					'layout!' => 'dropdown',
				),
			)
		);

		$this->add_control(
			'dropdown',
			array(
				'label'                 => __( 'Breakpoint', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'tablet',
				'options'               => array(
					'all'	=> __('Always', smw_slug),
					'mobile' => __( 'Mobile (767px >)', smw_slug ),
					'tablet' => __( 'Tablet (1023px >)', smw_slug ),
					'none' => __( 'None', smw_slug ),
				),
			)
		);

		$this->add_control(
			'menu_type',
			array(
				'label'                 => __( 'Menu Type', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'default',
				'options'               => array(
					'default' 		=> __( 'Default', smw_slug ),
					'off-canvas' 	=> __( 'Off Canvas', smw_slug ),
					'full-screen' 	=> __( 'Full Screen', smw_slug ),
				),
				'condition'             => array(
					'toggle!' 				=> '',
					'dropdown!'				=> 'none'
				),
			)
		);

		$this->add_control(
			'onepage_menu',
			array(
				'label'                 => __( 'One Page Menu', smw_slug ),
				'description'			=> __( 'Set this option to \'Yes\' to close menu when user clicks on same page links.', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'no',
				'options'               => array(
					'yes' => __( 'Yes', smw_slug ),
					'no' => __( 'No', smw_slug ),
				),
				'condition'             => array(
					'dropdown!'		=> 'none',
					'menu_type!'	=> 'default',
				),
			)
		);

		$this->add_control(
			'full_width',
			array(
				'label'                 => __( 'Full Width', smw_slug ),
				'type'                  => Controls_Manager::SWITCHER,
				'description' => __( 'Stretch the dropdown of the menu to full width.', smw_slug ),
				'prefix_class' => 'smw-advanced-menu--',
				'return_value' => 'stretch',
				'frontend_available'    => true,
				'condition'             => array(
					'dropdown!'				=> 'none',
					'menu_type' => 'default',
				),
			)
		);

		$this->add_control(
			'toggle',
			array(
				'label'                 => __( 'Toggle Button', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'icon',
				'options'               => array(
					'icon'         => __( 'Icon', smw_slug ),
					'icon-label'   => __( 'Icon + Label', smw_slug ),
					'button'       => __( 'Label', smw_slug ),
				),
				'render_type'           => 'template',
				'frontend_available'    => true,
				'condition'			=> array(
					'dropdown!'			=> 'none'
				)
			)
		);
        
        $this->add_control(
			'toggle_label',
			array(
				'label'                 => __( 'Toggle Label', smw_slug ),
				'type'                  => Controls_Manager::TEXT,
				'default'               => __( 'Menu', smw_slug ),
				'condition'             => array(
					'toggle' 				=> array('icon-label', 'button'),
					'dropdown!'				=> 'none'
				),
			)
		);

		$this->add_control(
			'label_align',
			array(
				'label'                 => __( 'Label Align', smw_slug ),
				'type'                  => Controls_Manager::CHOOSE,
				'default'               => 'right',
				'options'               => array(
					'left' => array(
						'title' => __( 'Left', smw_slug ),
						'icon' => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => __( 'Right', smw_slug ),
						'icon' => 'eicon-h-align-right',
					),
				),
				'condition'             => array(
					'toggle' 				=> array('icon-label'),
					'dropdown!'				=> 'none'
				),
				'label_block'           => false,
				'toggle'                => false,
			)
		);

		$this->add_control(
			'toggle_align',
			array(
				'label'                 => __( 'Toggle Align', smw_slug ),
				'type'                  => Controls_Manager::CHOOSE,
				'default'               => 'center',
				'options'               => array(
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
				'selectors_dictionary'  => array(
					'left' => 'justify-content: flex-start;',
					'center' => 'justify-content: center',
					'right' => 'justify-content: flex-end;',
				),
				'selectors'             => array(
					'{{WRAPPER}} .smw-menu-toggle' => '{{VALUE}}',
				),
				'condition'             => array(
					'toggle!' 				=> '',
					'dropdown!'				=> 'none'
				),
				'label_block'           => false,
			)
		);

		$this->add_control(
			'text_align',
			array(
				'label'                 => __( 'Align', smw_slug ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'aside',
				'options'               => array(
					'aside' => __( 'Aside', smw_slug ),
					'center' => __( 'Center', smw_slug ),
				),
				'condition'             => array(
					'dropdown!'			=> 'none',
					'menu_type!' 		=> array('off-canvas', 'full-screen')
				)
			)
		);

		$this->end_controls_section();
	}
	
	protected function register_style_menu_controls() 
    {
		$this->start_controls_section(
			'section_style_main_menu',
			array(
				'label'                 => __( 'Main Menu', smw_slug ),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => array(
					'dropdown!' => 'all',
				),

			)
		);

    		$this->add_control(
    			'heading_menu_item',
    			array(
    				'type'                  => Controls_Manager::HEADING,
    				'label'                 => __( 'Menu Item', smw_slug ),
    			)
    		);
    
    		$this->start_controls_tabs( 'tabs_menu_item_style' );
    
    		$this->start_controls_tab(
    			'tab_menu_item_normal',
    			array(
    				'label'                 => __( 'Normal', smw_slug ),
    			)
    		);
    
    		$this->add_control(
    			'colour_menu_item',
    			array(
    				'label'                 => __( 'Text Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'scheme'                => array(
    					'type'     => Color::get_type(),
    					'value'    => Color::COLOR_3,
    				),
    				'default'               => '',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item' => 'color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->end_controls_tab();
    
    		$this->start_controls_tab(
    			'tab_menu_item_hover',
    			array(
    				'label'                 => __( 'Hover', smw_slug ),
    			)
    		);
    
    		$this->add_control(
    			'colour_menu_item_hover',
    			array(
    				'label'                 => __( 'Text Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'scheme'                => array(
    					'type'     => Color::get_type(),
    					'value'    => Color::COLOR_4,
    				),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item:hover,
    					{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item.smw-menu-item-active,
    					{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item.highlighted,
    					{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item:focus' => 'color: {{VALUE}}',
    				),
    				'condition'             => array(
    					'pointer!' => 'background',
    				),
    			)
    		);
    
    		$this->add_control(
    			'colour_menu_item_hover_pointer_bg',
    			array(
    				'label'                 => __( 'Text Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'default'               => '#fff',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item:hover,
    					{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item.smw-menu-item-active,
    					{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item.highlighted,
    					{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item:focus' => 'color: {{VALUE}}',
    				),
    				'condition'             => array(
    					'pointer' => 'background',
    				),
    			)
    		);
    
    		$this->add_control(
    			'pointer_colour_menu_item_hover',
    			array(
    				'label'                 => __( 'Pointer Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'scheme'                => array(
    					'type'     => Color::get_type(),
    					'value'    => Color::COLOR_4,
    				),
    				'default'               => '',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main:not(.smw--pointer-framed) .smw-menu-item:before,
    					{{WRAPPER}} .smw-advanced-menu--main:not(.smw--pointer-framed) .smw-menu-item:after' => 'background-color: {{VALUE}}',
    					'{{WRAPPER}} .smw--pointer-framed .smw-menu-item:before,
    					{{WRAPPER}} .smw--pointer-framed .smw-menu-item:after' => 'border-color: {{VALUE}}',
    					'{{WRAPPER}} .smw--pointer-brackets .smw-menu-item:before,
    					{{WRAPPER}} .smw--pointer-brackets .smw-menu-item:after' => 'color: {{VALUE}}',
    				),
    				'condition'             => array(
    					'pointer!' => array( 'none', 'text' ),
    				),
    			)
    		);
    
    		$this->end_controls_tab();
    
    		$this->start_controls_tab(
    			'tab_menu_item_active',
    			array(
    				'label'                 => __( 'Active', smw_slug ),
    			)
    		);
    
    		$this->add_control(
    			'colour_menu_item_active',
    			array(
    				'label'                 => __( 'Text Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'default'               => '',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item.smw-menu-item-active' => 'color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->add_control(
    			'pointer_colour_menu_item_active',
    			array(
    				'label'                 => __( 'Pointer Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'default'               => '',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main:not(.smw--pointer-framed) .smw-menu-item.smw-menu-item-active:before,
    					{{WRAPPER}} .smw-advanced-menu--main:not(.smw--pointer-framed) .smw-menu-item.smw-menu-item-active:after' => 'background-color: {{VALUE}}',
    					'{{WRAPPER}} .smw--pointer-framed .smw-menu-item.smw-menu-item-active:before,
    					{{WRAPPER}} .smw--pointer-framed .smw-menu-item.smw-menu-item-active:after' => 'border-color: {{VALUE}}',
    					'{{WRAPPER}} .smw--pointer-brackets .smw-menu-item.smw-menu-item-active:before,
    					{{WRAPPER}} .smw--pointer-brackets .smw-menu-item.smw-menu-item-active:after' => 'color: {{VALUE}}',
    				),
    				'condition'             => array(
    					'pointer!' => array( 'none', 'text' ),
    				),
    			)
    		);
    
    		$this->end_controls_tab();
    
    		$this->end_controls_tabs();
    
    		$this->add_responsive_control(
    			'padding_horizontal_menu_item',
    			array(
    				'label'                 => __( 'Horizontal Padding', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'range'                 => array(
    					'px' => array(
    						'max' => 50,
    					),
    				),
    				'devices'               => array( 'desktop', 'tablet', 'mobile' ),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
    				),
    			)
    		);
    
    		$this->add_responsive_control(
    			'padding_vertical_menu_item',
    			array(
    				'label'                 => __( 'Vertical Padding', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'range'                 => array(
    					'px' => array(
    						'max' => 50,
    					),
    				),
    				'devices'               => array( 'desktop', 'tablet', 'mobile' ),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
    				),
    			)
    		);
    
    		$this->add_responsive_control(
    			'menu_space_between',
    			array(
    				'label'                 => __( 'Space Between', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'range'                 => array(
    					'px' => array(
    						'max' => 100,
    					),
    				),
    				'devices'               => array( 'desktop', 'tablet', 'mobile' ),
    				'selectors'             => array(
    					'body:not(.rtl) {{WRAPPER}} .smw-advanced-menu--layout-horizontal .smw-advanced-menu > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
    					'body.rtl {{WRAPPER}} .smw-advanced-menu--layout-horizontal .smw-advanced-menu > li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
    					'{{WRAPPER}} .smw-advanced-menu--main:not(.smw-advanced-menu--layout-horizontal) .smw-advanced-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
    				),
    			)
    		);
    
    		$this->add_control(
    			'pointer_width',
    			array(
    				'label'                 => __( 'Pointer Width', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'devices'               => array( self::RESPONSIVE_DESKTOP, self::RESPONSIVE_TABLET ),
    				'range'                 => array(
    					'px' => array(
    						'max' => 30,
    					),
    				),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw--pointer-framed .smw-menu-item:before' => 'border-width: {{SIZE}}{{UNIT}}',
    					'{{WRAPPER}} .smw--pointer-framed.e--animation-draw .smw-menu-item:before' => 'border-width: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
    					'{{WRAPPER}} .smw--pointer-framed.e--animation-draw .smw-menu-item:after' => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
    					'{{WRAPPER}} .smw--pointer-framed.e--animation-corners .smw-menu-item:before' => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
    					'{{WRAPPER}} .smw--pointer-framed.e--animation-corners .smw-menu-item:after' => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
    					'{{WRAPPER}} .smw--pointer-underline .smw-menu-item:after,
    					 {{WRAPPER}} .smw--pointer-overline .smw-menu-item:before,
    					 {{WRAPPER}} .smw--pointer-double-line .smw-menu-item:before,
    					 {{WRAPPER}} .smw--pointer-double-line .smw-menu-item:after' => 'height: {{SIZE}}{{UNIT}}',
    				),
    				'condition'             => array(
    					'pointer' => array( 'underline', 'overline', 'double-line', 'framed' ),
    				),
    			)
    		);
    
    		$this->add_responsive_control(
    			'border_radius_menu_item',
    			array(
    				'label'                 => __( 'Border Radius', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'size_units'            => array( 'px', 'em', '%' ),
    				'devices'               => array( 'desktop', 'tablet' ),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-menu-item:before' => 'border-radius: {{SIZE}}{{UNIT}}',
    					'{{WRAPPER}} .e--animation-shutter-in-horizontal .smw-menu-item:before' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
    					'{{WRAPPER}} .e--animation-shutter-in-horizontal .smw-menu-item:after' => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
    					'{{WRAPPER}} .e--animation-shutter-in-vertical .smw-menu-item:before' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
    					'{{WRAPPER}} .e--animation-shutter-in-vertical .smw-menu-item:after' => 'border-radius: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
    				),
    				'condition'             => array(
    					'pointer' => 'background',
    				),
    			)
    		);
    
    		$this->end_controls_section();
    
    		$this->start_controls_section(
    			'section_style_dropdown',
    			array(
    				'label'                 => __( 'Dropdown', smw_slug ),
    				'tab'                   => Controls_Manager::TAB_STYLE,
    				'conditions' => array(
    					'relation' => 'or',
    					'terms' => array(
    						array(
    							'name' => 'dropdown',
    							'operator' => '!==',
    							'value' => 'all',
    						),
    						array(
    							'relation' => 'and',
    							'terms' => array(
    								array(
    									'name' => 'dropdown',
    									'operator' => '==',
    									'value' => 'all',
    								),
    								array(
    									'name' => 'menu_type',
    									'operator' => '==',
    									'value' => 'default',
    								),
    							),
    						),
    					),
    				),
    			)
    		);
    
    		$this->add_control(
    			'dropdown_description',
    			array(
    				'raw'                   => __( 'On desktop, this will affect the submenu. On mobile, this will affect the entire menu.', smw_slug ),
    				'type'                  => Controls_Manager::RAW_HTML,
    				'content_classes'       => 'smw-editor-info',
    			)
    		);
    
    		$this->start_controls_tabs( 'tabs_dropdown_item_style' );
    
    		$this->start_controls_tab(
    			'tab_dropdown_item_normal',
    			array(
    				'label'                 => __( 'Normal', smw_slug ),
    			)
    		);
    
    		$this->add_control(
    			'color_dropdown_item',
    			array(
    				'label'                 => __( 'Text Color', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'default'               => '',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown a, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default a, {{WRAPPER}} .smw-menu-toggle' => 'color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->add_control(
    			'background_colour_dropdown_item',
    			array(
    				'label'                 => __( 'Background Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'default'               => '',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default' => 'background-color: {{VALUE}}',
    				),
    				'separator'             => 'none',
    			)
    		);
    
    		$this->end_controls_tab();
    
    		$this->start_controls_tab(
    			'tab_dropdown_item_hover',
    			array(
    				'label'                 => __( 'Hover', smw_slug ),
    			)
    		);
    
    		$this->add_control(
    			'colour_dropdown_item_hover',
    			array(
    				'label'                 => __( 'Text Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'default'               => '',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown a:hover, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default a:hover, {{WRAPPER}} .smw-menu-toggle:hover' => 'color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->add_control(
    			'background_colour_dropdown_item_hover',
    			array(
    				'label'                 => __( 'Background Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'default'               => '',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown a:hover,
    					{{WRAPPER}} .smw-advanced-menu--main:not(.smw-advanced-menu--layout-expanded) .smw-advanced-menu--dropdown a.highlighted, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default a:hover,
    					{{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default a.highlighted' => 'background-color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->end_controls_tab();
    
    		$this->start_controls_tab(
    			'tab_dropdown_item_active',
    			array(
    				'label'                 => __( 'Active', smw_slug ),
    			)
    		);
    
    		$this->add_control(
    			'colour_dropdown_item_active',
    			array(
    				'label'                 => __( 'Text Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'default'               => '',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown a.smw-menu-item-active, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default a.smw-menu-item-active' => 'color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->add_control(
    			'background_colour_dropdown_item_active',
    			array(
    				'label'                 => __( 'Background Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'default'               => '',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown a.smw-menu-item-active, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default a.smw-menu-item-active' => 'background-color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->end_controls_tab();
    
    		$this->end_controls_tabs();
    
    		$this->add_group_control(
    			Group_Control_Border::get_type(),
    			array(
    				'name'                  => 'dropdown_border',
    				'selector'              => '{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default',
    				'separator'             => 'before',
    			)
    		);
    
    		$this->add_responsive_control(
    			'dropdown_border_radius',
    			array(
    				'label'                 => __( 'Border Radius', smw_slug ),
    				'type'                  => Controls_Manager::DIMENSIONS,
    				'size_units'            => array( 'px', '%' ),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown li:first-child a, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default li:first-child a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown li:last-child a, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default li:last-child a' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
    				),
    			)
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			array(
    				'name'                  => 'dropdown_box_shadow',
    				'exclude'               => array(
    					'box_shadow_position',
    				),
    				'selector'              => '{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu__container.smw-advanced-menu--dropdown',
    			)
    		);
    
    		$this->add_responsive_control(
    			'dropdown_min_width',
    			array(
    				'label'                 => __( 'Minimum Width', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'default'                 => array(
    					'size' => 200,
    				),
    				'range'                 => array(
    					'px' => array(
    						'min' => 50,
    						'max' => 400,
    					),
    				),
    				'devices'               => array( 'desktop', 'tablet', 'mobile' ),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown' => 'min-width: {{SIZE}}{{UNIT}};',
    				),
    				'separator'             => 'before',
    			)
    		);
    
    		$this->add_responsive_control(
    			'padding_horizontal_dropdown_item',
    			array(
    				'label'                 => __( 'Horizontal Padding', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown a, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
    				),
    
    			)
    		);
    
    		$this->add_responsive_control(
    			'padding_vertical_dropdown_item',
    			array(
    				'label'                 => __( 'Vertical Padding', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'range'                 => array(
    					'px' => array(
    						'max' => 50,
    					),
    				),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown a, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
    				),
    			)
    		);
    
    		$this->add_control(
    			'heading_dropdown_divider',
    			array(
    				'label'                 => __( 'Divider', smw_slug ),
    				'type'                  => Controls_Manager::HEADING,
    				'separator'             => 'before',
    			)
    		);
    
    		$this->add_group_control(
    			Group_Control_Border::get_type(),
    			array(
    				'name'                  => 'dropdown_divider',
    				'selector'              => '{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown li:not(:last-child), {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default li:not(:last-child)',
    				'exclude'               => array( 'width' ),
    			)
    		);
    
    		$this->add_control(
    			'dropdown_divider_width',
    			array(
    				'label'                 => __( 'Border Width', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'range'                 => array(
    					'px' => array(
    						'max' => 50,
    					),
    				),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main .smw-advanced-menu--dropdown li:not(:last-child), {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu--dropdown.smw-menu-default li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
    				),
    				'condition'             => array(
    					'dropdown_divider_border!' => '',
    				),
    			)
    		);
    
    		$this->add_responsive_control(
    			'dropdown_top_distance',
    			array(
    				'label'                 => __( 'Distance', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'range'                 => array(
    					'px' => array(
    						'min' => -100,
    						'max' => 100,
    					),
    				),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--main > .smw-advanced-menu > li > .smw-advanced-menu--dropdown, {{WRAPPER}} .smw-advanced-menu--type-default .smw-advanced-menu__container.smw-advanced-menu--dropdown' => 'margin-top: {{SIZE}}{{UNIT}} !important',
    				),
    				'separator'             => 'before',
    			)
    		);
    
    		$this->end_controls_section();
    
    		/**
             * Content Tab: Toggle Button
             */
    		$this->start_controls_section( 'style_toggle',
    			array(
    				'label'                 => __( 'Toggle Button', smw_slug ),
    				'tab'                   => Controls_Manager::TAB_STYLE,
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'toggle!'		=> '',
    				),
    			)
    		);
    
    		$this->start_controls_tabs( 'tabs_toggle_style' );
    
    		$this->start_controls_tab(
    			'tab_toggle_style_normal',
    			array(
    				'label'                 => __( 'Normal', smw_slug ),
    			)
    		);
    
    		$this->add_control(
    			'toggle_colour',
    			array(
    				'label'                 => __( 'Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-menu-toggle .smw-hamburger .smw-hamburger-box .smw-hamburger-inner,
    					{{WRAPPER}} .smw-menu-toggle .smw-hamburger .smw-hamburger-box .smw-hamburger-inner:before,
    					{{WRAPPER}} .smw-menu-toggle .smw-hamburger .smw-hamburger-box .smw-hamburger-inner:after' => 'background-color: {{VALUE}}',
    					'{{WRAPPER}} .smw-menu-toggle .smw-menu-toggle-label'	=> 'color: {{VALUE}}' // Harder selector to override text color control
    				),
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    				),
    			)
    		);
    
    		$this->add_control(
    			'toggle_background_colour',
    			array(
    				'label'                 => __( 'Background Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-menu-toggle' => 'background-color: {{VALUE}}',
    				),
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    				),
    			)
    		);
            
            $this->add_group_control(
    			Group_Control_Border::get_type(),
    			array(
    				'name'                  => 'toggle_border',
    				'label'                 => __( 'Border', smw_slug ),
                    'selector'              => '{{WRAPPER}} .smw-menu-toggle',
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    				),
    			)
    		);
    
    		$this->add_control(
    			'toggle_border_radius',
    			array(
    				'label'                 => __( 'Border Radius', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'size_units'            => array( 'px', '%' ),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-menu-toggle' => 'border-radius: {{SIZE}}{{UNIT}}',
    				),
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    				),
    			)
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			array(
    				'name'                  => 'toggle_box_shadow',
    				'selector' 				=> '{{WRAPPER}} .smw-menu-toggle',
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    				),
    			)
    		);
    
    		$this->end_controls_tab();
    
    		$this->start_controls_tab(
    			'tab_toggle_style_hover',
    			array(
    				'label'                 => __( 'Hover', smw_slug ),
    			)
    		);
    
    		$this->add_control(
    			'toggle_color_hover',
    			array(
    				'label'                 => __( 'Color', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-menu-toggle:hover .smw-hamburger .smw-hamburger-box .smw-hamburger-inner,
    					{{WRAPPER}} .smw-menu-toggle:hover .smw-hamburger .smw-hamburger-box .smw-hamburger-inner:before,
    					{{WRAPPER}} .smw-menu-toggle:hover .smw-hamburger .smw-hamburger-box .smw-hamburger-inner:after' => 'background-color: {{VALUE}}',
    					'{{WRAPPER}} .smw-menu-toggle:hover .smw-menu-toggle-label'	=> 'color: {{VALUE}}' // Harder selector to override text color control
    				),
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    				),
    			)
    		);
    
    		$this->add_control(
    			'toggle_background_colour_hover',
    			array(
    				'label'                 => __( 'Background Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-menu-toggle:hover' => 'background-color: {{VALUE}}',
    				),
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    				),
    			)
    		);
    
    		$this->add_control(
    			'toggle_baorder_colour_hover',
    			array(
    				'label'                 => __( 'Border Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-menu-toggle:hover' => 'border-color: {{VALUE}}',
    				),
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    				),
    			)
    		);
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			array(
    				'name'                  => 'toggle_box_shadow_hover',
    				'selector' 				=> '{{WRAPPER}} .smw-menu-toggle:hover',
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    				),
    			)
    		);
    
    		$this->end_controls_tab();
    
    		$this->end_controls_tabs();
    
    		$this->add_responsive_control(
    			'toggle_size',
    			array(
    				'label'                 => __( 'Size', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'range'                 => array(
    					'px' => array(
    						'min' => 15,
    					),
    				),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-menu-toggle .smw-hamburger .smw-hamburger-box' => 'font-size: {{SIZE}}{{UNIT}}',
    				),
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'toggle'		=> array('icon', 'icon-label'),
    				),
    				'separator'             => 'before',
    			)
    		);
    
    		$this->add_control(
    			'toggle_thickness',
    			array(
    				'label'                 => __( 'Thickness', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'range'                 => array(
    					'px' => array(
    						'min' => 1,
    						'max' => 16,
    					),
    				),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-menu-toggle .smw-hamburger .smw-hamburger-box .smw-hamburger-inner,
    					{{WRAPPER}} .smw-menu-toggle .smw-hamburger .smw-hamburger-box .smw-hamburger-inner:before,
    					{{WRAPPER}} .smw-menu-toggle .smw-hamburger .smw-hamburger-box .smw-hamburger-inner:after' => 'height: {{SIZE}}{{UNIT}}',
    				),
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'toggle'		=> array('icon', 'icon-label'),
    				),
    			)
    		);
    		
    		$this->add_responsive_control(
    			'toggle_padding',
    			array(
    				'label'					=> __( 'Padding', smw_slug ),
    				'type'					=> Controls_Manager::DIMENSIONS,
    				'size_units'			=> array( 'px', 'em' ),
    				'selectors'				=> array(
    					'{{WRAPPER}} .smw-menu-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    				),
    			)
    		);
    
    		$this->add_control(
    			'heading_toggle_label_style',
    			array(
    				'label'                 => __( 'Label', smw_slug ),
    				'type'                  => Controls_Manager::HEADING,
    				'separator'             => 'before',
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'toggle'		=> array('icon-label','button'),
    				),
    			)
    		);
    
    		$this->add_group_control(
    			Group_Control_Typography::get_type(),
    			array(
    				'name'                  => 'toggle_label_typography',
    				'scheme'                => Typography::TYPOGRAPHY_1,
    				'selector'              => '{{WRAPPER}} .smw-menu-toggle .smw-menu-toggle-label',
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'toggle'		=> array('icon-label','button'),
    				),
    			)
    		);
    
    		$this->end_controls_section();
    
    		/**
             * Content Tab: Off Canvas/Full Screen
             */
    		$this->start_controls_section( 'style_responsive',
    			array(
    				'label'                 => __( 'Off Canvas/Full Screen', smw_slug ),
    				'tab'                   => Controls_Manager::TAB_STYLE,
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'menu_type'		=> array('off-canvas', 'full-screen'),
    				),
    			)
    		);
    
    		$this->add_control(
    			'offcanvas_position',
    			array(
    				'label'                 => __( 'Position', smw_slug ),
    				'type'                  => Controls_Manager::SELECT,
    				'default'               => 'left',
    				'options'               => array(
    					'left' => __( 'Left', smw_slug ),
    					'right' => __( 'Right', smw_slug ),
    				),
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'menu_type'		=> 'off-canvas',
    				),
    			)
    		);
    
    		$this->add_control(
    			'responsive_menu_alignment',
    			array(
    				'label'                 => __( 'Alignment', smw_slug ),
    				'type'                  => Controls_Manager::SELECT,
    				'default'               => 'space-between',
    				'options'               => array(
    					'space-between' => __( 'Left', smw_slug ),
    					'center'        => __( 'Center', smw_slug ),
    					'flex-end'      => __( 'Right', smw_slug ),
    				),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--dropdown a, .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} a'  => 'justify-content: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->add_responsive_control(
    			'offcanvas_menu_width',
    			array(
    				'label'                 => __( 'Off Canvas Width', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'size_units'            => array( 'px', '%', 'vw' ),
    				'range'                 => array(
    					'px' => array(
    						'min' => 100,
    						'max' => 1000,
    					),
    				),
    				'selectors'             => array(
    					'body.smw-menu--off-canvas .smw-menu-off-canvas.smw-menu-{{ID}}' => 'width: {{SIZE}}{{UNIT}};',
    				),
    				'condition'             => array(
    					'menu_type' 		=> 'off-canvas'
    				)
    
    			)
    		);
    
    		$this->add_control(
    			'overlay_bg_colour',
    			array(
    				'label'                 => __( 'Menu Background Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'default'               => 'rgba(0,0,0,0.8)',
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}}'  => 'background-color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->start_controls_tabs( 'tabs_responsive_style' );
    
    		$this->start_controls_tab(
    			'tab_responsive_normal',
    			array(
    				'label'                 => __( 'Normal', smw_slug ),
    			)
    		);
    
    		$this->add_control(
    			'mobile_link_colour',
    			array(
    				'label'                 => __( 'Link Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-item,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .smw-menu-item' => 'color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->add_control(
    			'mobile_sub_link_bg_colour',
    			array(
    				'label'                 => __( 'Sub Menu Link Background Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container a.smw-sub-item,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} a.smw-sub-item, .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .sub-menu' => 'background-color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->add_control(
    			'mobile_sub_link_colour',
    			array(
    				'label'                 => __( 'Sub Menu Link Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container a.smw-sub-item, .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} a.smw-sub-item' => 'color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->end_controls_tab();
    
    		$this->start_controls_tab(
    			'tab_responsive_hover',
    			array(
    				'label'                 => __( 'Hover', smw_slug ),
    			)
    		);
    
    		$this->add_control(
    			'mobile_link_hover',
    			array(
    				'label'                 => __( 'Link Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-item:hover,
    					{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-item:focus,
    					{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-item.smw-menu-item-active,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .smw-menu-item:hover,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .smw-menu-item:focus,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .smw-menu-item.smw-menu-item-active' => 'color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->add_control(
    			'mobile_link_bg_hover',
    			array(
    				'label'                 => __( 'Link Background Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-item:hover,
    					{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-item:focus,
    					{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-item.smw-menu-item-active,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .smw-menu-item:hover,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .smw-menu-item:focus,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .smw-menu-item.smw-menu-item-active' => 'background-color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->add_control(
    			'mobile_sub_link_bg_hover',
    			array(
    				'label'                 => __( 'Sub Menu Link Background Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container a.smw-sub-item:hover,
    					{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container a.smw-sub-item:focus,
    					{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container a.smw-sub-item:active,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} a.smw-sub-item:hover,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} a.smw-sub-item:focus,
    					.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} a.smw-sub-item:active' => 'background-color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->add_control(
    			'mobile_sub_link_hover',
    			array(
    				'label'                 => __( 'Sub Menu Link Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container a.smw-sub-item:hover, .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} a.smw-sub-item:hover' => 'color: {{VALUE}}',
    				),
    			)
    		);
    
    		$this->end_controls_tab();
    		$this->end_controls_tabs();
    
    		$this->add_control(
    			'mobile_submenu_indent',
    			array(
    				'label'                 => __( 'Submenu Indent', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'selectors'             => array(
    					'.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .sub-menu' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
    				),
    				'separator'             => 'before',
    
    			)
    		);
    
    		$this->add_control(
    			'padding_horizontal_mobile_link_item',
    			array(
    				'label'                 => __( 'Horizontal Padding', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-item, {{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container a.smw-sub-item, .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .smw-menu-item, .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} a.smw-sub-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
    				),
    				'separator'             => 'before',
    
    			)
    		);
    
    		$this->add_control(
    			'padding_vertical_mobile_link_item',
    			array(
    				'label'                 => __( 'Vertical Padding', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'range'                 => array(
    					'px' => array(
    						'max' => 50,
    					),
    				),
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-item, {{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container a.smw-sub-item, .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .smw-menu-item, .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} a.smw-sub-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
    				),
    			)
    		);
    
    		$this->add_group_control(
    			Group_Control_Border::get_type(),
    			array(
    				'name'                  => 'mobile_menu_border',
    				'selector'              => '{{WRAPPER}} .smw-advanced-menu--dropdown li:not(:last-child), .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} li:not(:last-child)',
    				'separator'             => 'before',
    			)
    		);
    
    		$this->add_control(
                'hr',
                array(
                    'type'                  => Controls_Manager::DIVIDER,
                    'style'                 => 'thick',
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'menu_type'		=> 'off-canvas',
    				),
                )
            );
    
    		$this->add_group_control(
    			Group_Control_Box_Shadow::get_type(),
    			array(
    				'name'                  => 'mobile_menu_box_shadow',
    				'selector' 				=> '{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container, .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}}',
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'menu_type'		=> 'off-canvas',
    				),
    				'separator'             => 'before',
    			)
    		);
    
    		$this->add_control(
    			'heading_close_icon_style',
    			array(
    				'label'                 => __( 'Close Icon', smw_slug ),
    				'type'                  => Controls_Manager::HEADING,
    				'separator'             => 'before',
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'menu_type'		=> array('off-canvas', 'full-screen'),
    				),
    			)
    		);
    
    		$this->add_control(
    			'close_icon_size',
    			array(
    				'label'                 => __( 'Close Icon Size', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'range'                 => array(
    					'px' => array(
    						'min' => 15,
    					),
    				),
    				'selectors'             => array(
    					'body.smw-menu--off-canvas .smw-advanced-menu--dropdown.smw-menu-{{ID}} .smw-menu-close, {{WRAPPER}} .smw-advanced-menu--type-full-screen .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-close' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
    					'body.smw-menu--off-canvas .smw-advanced-menu--dropdown.smw-menu-{{ID}} .smw-menu-close:before, {{WRAPPER}} .smw-advanced-menu--type-full-screen .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-close:before,
    					body.smw-menu--off-canvas .smw-advanced-menu--dropdown.smw-menu-{{ID}} .smw-menu-close:after, {{WRAPPER}} .smw-advanced-menu--type-full-screen .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-close:after' => 'height: {{SIZE}}{{UNIT}}',
    				),
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'menu_type'		=> array('off-canvas', 'full-screen'),
    				),
    			)
    		);
    
    		$this->add_control(
    			'close_icon_colour',
    			array(
    				'label'                 => __( 'Close Icon Colour', smw_slug ),
    				'type'                  => Controls_Manager::COLOR,
    				'selectors'             => array(
    					'body.smw-menu--off-canvas .smw-advanced-menu--dropdown.smw-menu-{{ID}} .smw-menu-close:before, {{WRAPPER}} .smw-advanced-menu--type-full-screen .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-close:before,
    					body.smw-menu--off-canvas .smw-advanced-menu--dropdown.smw-menu-{{ID}} .smw-menu-close:after, {{WRAPPER}} .smw-advanced-menu--type-full-screen .smw-advanced-menu--dropdown.smw-advanced-menu__container .smw-menu-close:after' => 'background-color: {{VALUE}}',
    				),
    				'condition'             => array(
    					'dropdown!'		=> 'none',
    					'menu_type'		=> array('off-canvas', 'full-screen'),
    				),
    			)
    		);
    
    		$this->end_controls_section();
    
    		/**
             * Content Tab: Typography
             */
    		$this->start_controls_section( 'style_typography',
    			array(
    				'label'                 => __( 'Typography', smw_slug ),
    				'tab'                   => Controls_Manager::TAB_STYLE,
    			)
    		);
    
    		$this->add_control(
    			'main_typography_heading',
    			array(
    				'label'                 => __( 'Main Menu/Off Canvas/Full Screen', smw_slug ),
    				'type'                  => Controls_Manager::HEADING,
    			)
    		);
    
    		$this->add_group_control(
    			Group_Control_Typography::get_type(),
    			array(
    				'name'                  => 'menu_typography',
    				'separator'             => 'before',
    				'selector'              => '{{WRAPPER}} .smw-advanced-menu--main, {{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container, {{WRAPPER}} .smw-advanced-menu-main-wrapper.smw-advanced-menu--type-full-screen .smw-advanced-menu--dropdown, .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}}',
    			)
    		);
    
    		$this->add_control(
    			'dropdown_typography_heading',
    			array(
    				'label'                 => __( 'Dropdown/Submenu', smw_slug ),
    				'type'                  => Controls_Manager::HEADING,
    				'separator'             => 'before',
    			)
    		);
    
    		$this->add_group_control(
    			Group_Control_Typography::get_type(),
    			array(
    				'name'                  => 'dropdown_typography',
    				'scheme'                => Typography::TYPOGRAPHY_4,
    				'exclude'               => array( 'line_height' ),
    				'selector'              => '{{WRAPPER}} .smw-advanced-menu-main-wrapper .smw-advanced-menu--dropdown, 
    				{{WRAPPER}} .smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-open .sub-menu,
    				.smw-advanced-menu--dropdown.smw-advanced-menu__container.smw-menu-{{ID}} .sub-menu',
    				'separator'             => 'before',
    			)
    		);
    		
    		$this->end_controls_section();
    
    		$this->start_controls_section(
    			'section_style_indicator',
    			array(
    				'label'                 => __( 'Submenu Indicator', smw_slug ),
    				'tab'                   => Controls_Manager::TAB_STYLE,
    				'condition'             => array(
    					'indicator!' => 'none',
    				),
    			)
    		);
    
    		$this->add_responsive_control(
    			'indicator_size',
    			array(
    				'label'                 => __( 'Size', smw_slug ),
    				'type'                  => Controls_Manager::SLIDER,
    				'selectors'             => array(
    					'{{WRAPPER}} .smw-advanced-menu .sub-arrow, .smw-advanced-menu__container.smw-menu-{{ID}} .sub-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
    				),
    				'condition'             => array(
    					'indicator!' => 'none',
    				),
    			)
    		);

		$this->end_controls_section();
	}
	
    protected function render() 
    {
		$available_menus = $this->get_available_menus();

		if ( ! $available_menus ) {
			return;
		}

		$settings = $this->get_settings();

		$settings_attr = array(
			'menu_type'		=> $settings['menu_type'],
			'menu_id'		=> esc_attr( $this->get_id() ),
			'breakpoint'	=> $settings['dropdown'],
			'menu_layout'	=> $settings['layout'],
			'onepage_menu'	=> $settings['onepage_menu'],
		);
		
		if ( $settings['dropdown'] != 'none' ) {
			$settings_attr['full_width'] = ( ! $settings['full_width'] || empty( $settings['full_width'] ) ) ? false : true;
		}

		$args = [
			'echo' => false,
			'menu' => $settings['menu'],
			'menu_class' => 'smw-advanced-menu',
			'fallback_cb' => '__return_empty_string',
			'container' => '',
		];

		if ( 'vertical' === $settings['layout'] ) {
			$args['menu_class'] .= ' sm-vertical';
		}

		add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ], 10, 4 );
		add_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_classes' ] );
		add_filter( 'nav_menu_item_id', '__return_empty_string' );

		$menu_html = wp_nav_menu( $args );

		$dropdown_menu_html = wp_nav_menu( $args );

		remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ] );
		remove_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_classes' ] );
		remove_filter( 'nav_menu_item_id', '__return_empty_string' );

		if ( empty( $menu_html ) ) {
			return;
		}

		$menu_toggle_classes = [
			'smw-menu-toggle',
		];

		if ( $settings['layout'] !== 'dropdown' ) {
			$menu_toggle_classes[] = 'smw-menu-toggle-on-' . $settings['dropdown'];
		} else {
			$menu_toggle_classes[] = 'smw-menu-toggle-on-all';
		}
        
        if ( $settings['toggle'] == 'icon-label' ) {
            $menu_toggle_classes[] = 'smw-menu-toggle-label-' . $settings['label_align'];
        }

		$this->add_render_attribute( 'menu-toggle', 'class', $menu_toggle_classes);

		$menu_wrapper_classes = 'smw-advanced-menu__align-' . $settings['align_items'];
		$menu_wrapper_classes .= ' smw-advanced-menu--indicator-' . $settings['indicator'];
		$menu_wrapper_classes .= ' smw-advanced-menu--dropdown-' . $settings['dropdown'];
		$menu_wrapper_classes .= ' smw-advanced-menu--type-' . $settings['menu_type'];
		$menu_wrapper_classes .= ' smw-advanced-menu__text-align-' . $settings['text_align'];
		$menu_wrapper_classes .= ' smw-advanced-menu--toggle smw-advanced-menu--' . $settings['toggle'];
		?>

		<?php do_action( 'smw_before_advanced_menu_wrapper' ); ?>
		<div class="smw-advanced-menu-main-wrapper <?php echo $menu_wrapper_classes; ?>">
		<?php
		if ( 'all' != $settings['dropdown'] ) :
			$this->add_render_attribute( 'main-menu', 'class', [
				'smw-advanced-menu--main',
				'smw-advanced-menu__container',
				'smw-advanced-menu--layout-' . $settings['layout'],
			] );

			if ( $settings['pointer'] ) :
				$this->add_render_attribute( 'main-menu', 'class', 'smw--pointer-' . $settings['pointer'] );

				foreach ( $settings as $key => $value ) :
					if ( 0 === strpos( $key, 'animation' ) && $value ) :
						$this->add_render_attribute( 'main-menu', 'class', 'e--animation-' . $value );

						break;
					endif;
				endforeach;
			endif; ?>

			<?php do_action( 'smw_before_advanced_menu' ); ?>
			<nav id="smw-menu-<?php echo $this->get_id(); ?>" <?php echo $this->get_render_attribute_string( 'main-menu' ); ?> data-settings="<?php echo htmlspecialchars(json_encode($settings_attr)); ?>"><?php echo $menu_html; ?></nav>
			<?php do_action( 'smw_after_advanced_menu' ); ?>
			<?php
		endif;
		?>
		<?php if ( 'none' != $settings['dropdown'] ) { ?>
			<?php if ( $settings['toggle'] != '' ) { ?>
				<div <?php echo $this->get_render_attribute_string( 'menu-toggle' ); ?>>
					<?php if ( $settings['toggle'] == 'icon-label' || $settings['toggle'] == 'icon' ) { ?>
						<div class="smw-hamburger">
							<div class="smw-hamburger-box">
								<div class="smw-hamburger-inner"></div>
							</div>
						</div>
					<?php } ?>
					<?php if ( $settings['toggle'] == 'icon-label' || $settings['toggle'] == 'button' ) { ?>
						<?php if ( $settings['toggle_label'] != '' ) { ?>
							<span class="smw-menu-toggle-label">
								<?php echo $settings['toggle_label']; ?>
							</span>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
			<?php
				$offcanvas_pos = '';
				if( $settings['menu_type'] == 'off-canvas' ) {
					$offcanvas_pos = ' smw-menu-off-canvas-' . $settings['offcanvas_position'];
				}
			?>
			<?php do_action( 'smw_before_advanced_menu_responsive' ); ?>
			<nav class="smw-advanced-menu--dropdown smw-menu-style-toggle smw-advanced-menu__container smw-menu-<?php echo $this->get_id(); ?><?php if( 'default' != $settings['menu_type']) { ?> smw-advanced-menu--indicator-<?php echo $settings['indicator']; ?><?php } ?> smw-menu-<?php echo $settings['menu_type']; ?><?php echo $offcanvas_pos; ?>" data-settings="<?php echo htmlspecialchars(json_encode($settings_attr)); ?>">
				<?php if( $settings['menu_type'] == 'full-screen' || $settings['menu_type'] == 'off-canvas' ) { ?>
					<div class="smw-menu-close">
					</div>
				<?php } ?>
				<?php echo $dropdown_menu_html; ?>
			</nav>
			<?php do_action( 'smw_after_advanced_menu_responsive' ); ?>
		<?php } ?>
        </div>
		<?php do_action( 'smw_after_advanced_menu_WRAPPER' ); ?>
        <?php
	}

	public function handle_link_classes( $atts, $item, $args, $depth ) {
		$settings = $this->get_settings();
		
		$classes = $depth ? 'smw-sub-item' : 'smw-menu-item';

		if ( in_array( 'current-menu-item', $item->classes ) ) {
			$classes .= '  smw-menu-item-active';
		}

		if ( empty( $atts['class'] ) ) {
			$atts['class'] = $classes;
		} else {
			$atts['class'] .= ' ' . $classes;
		}

		return $atts;
	}

	public function handle_sub_menu_classes( $classes ) {
		$classes[] = 'smw-advanced-menu--dropdown';

		return $classes;
	}

	public function render_plain_content() {}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_advanced_menu() );