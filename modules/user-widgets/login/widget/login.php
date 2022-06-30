<?php

/**
 * SMW Login Form.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Widget_Button;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_login extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'login-css', plugin_dir_url( __FILE__ ) . '../css/login.css');
    }
    
    public function get_name()
    {
        return 'stiles-login';
    }
    
    public function get_title()
    {
        return 'Login';
    }
    
    public function get_icon()
    {
        return 'eicon-lock-user';
    }
    
    public function get_categories()
    {
        return ['stiles-media-users'];
    }
    
    public function get_style_depends() 
    {
        return [ 'login-css' ];
    }
    
    public static function get_button_sizes() 
    {
		return Widget_Button::get_button_sizes();
	}
    
    protected function register_controls() 
    {
        $this->register_form_fields_controls();
        
        $this->register_button_controls();
        
        $this->register_additional_options_controls();
        
        $this->register_success_error_controls();
        
        $this->register_spacing_controls();
        
        $this->register_form_fields_style_controls();
        
        $this->register_button_style_controls();
        
        $this->register_validation_controls();
        
        $this->register_error_style_controls();
	} 
	
	protected function register_form_fields_controls() 
	{
    	$this->start_controls_section(
    		'section_general_field',
    		array(
    			'label' => __( 'Form Fields', smw_slug ),
    		)
    	);
    	
    	$this->add_control(
            'show_labels',
            array(
                'label'   => __( 'Field Label', smw_slug ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'default' => __( 'Show', smw_slug ),
                    'custom'  => __( 'Custom Labels', smw_slug ),
                    'none'    => __( 'None', smw_slug ),
                ),
                'default' => 'default',
            )
        );

        $this->add_control(
            'user_label',
            array(
                'label'       => __( 'Username Label', smw_slug ),
                'default'     => __( 'Username or Email Address', smw_slug ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => array(
                    'active' => true,
                ),
                'label_block' => true,
                'condition'   => array(
                    'show_labels' => 'custom',
                ),
            )
        );
        
        $this->add_control(
            'user_placeholder',
            array(
                'label'       => __( 'Username Placeholder', smw_slug ),
                'default'     => __( 'Username or Email Address', smw_slug ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => array(
                    'active' => true,
                ),
                'label_block' => true,
                'condition'   => array(
                    'show_labels' => 'custom',
                ),
            )
        );
        
        $this->add_control(
            'password_label',
            array(
                'label'       => __( 'Password Label', smw_slug ),
                'default'     => __( 'Password', smw_slug ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => array(
                    'active' => true,
                ),
                'label_block' => true,
                'condition'   => array(
                    'show_labels' => 'custom',
                ),
            )
        );
        
        $this->add_control(
            'password_placeholder',
            array(
                'label'       => __( 'Password Placeholder', smw_slug ),
                'default'     => __( 'Password', smw_slug ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => array(
                    'active' => true,
                ),
                'label_block' => true,
                'condition'   => array(
                    'show_labels' => 'custom',
                ),
            )
        );
        
        $this->add_control(
            'input_size',
            array(
                'label'   => __( 'Input Size', smw_slug ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'xs' => __( 'Extra Small', smw_slug ),
                    'sm' => __( 'Small', smw_slug ),
                    'md' => __( 'Medium', smw_slug ),
                    'lg' => __( 'Large', smw_slug ),
                    'xl' => __( 'Extra Large', smw_slug ),
                ),
                'default' => 'sm',
            )
        );
        
        $this->add_control(
            'show_remember_me',
            array(
                'label'     => __( 'Remember Me', smw_slug ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_off' => __( 'Hide', smw_slug ),
                'label_on'  => __( 'Show', smw_slug ),
            )
        );
        
        $this->add_control(
            'enable_ajax',
            array(
                'label'     => __( 'Enable AJAX Form Submission', smw_slug ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => __( 'Yes', smw_slug ),
                'label_off' => __( 'No', smw_slug ),
            )
        );
        
        $this->add_control(
            'block_admin',
            array(
                'label'     => __( 'Redirect WP Admin', smw_slug ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'label_on'  => __( 'Yes', smw_slug ),
                'label_off' => __( 'No', smw_slug ),
            )
        );

	
		$this->end_controls_section();
	}
	
	protected function register_button_controls() 
	{
		$this->start_controls_section(
			'section_button_field',
			array(
				'label' => __( 'Login Button', smw_slug ),
			)
		);

			$this->add_control(
				'button_text',
				array(
					'label'       => __( 'Text', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Log In', smw_slug ),
					'placeholder' => __( 'Log In', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$this->add_control(
				'button_size',
				array(
					'label'   => __( 'Size', smw_slug ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'sm',
					'options' => $this->get_button_sizes(),
				)
			);

			$this->add_responsive_control(
				'button_width',
				array(
					'label'   => __( 'Button Width', smw_slug ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						''    => __( 'Default', smw_slug ),
						'100' => '100%',
						'80'  => '80%',
						'75'  => '75%',
						'66'  => '66%',
						'60'  => '60%',
						'50'  => '50%',
						'40'  => '40%',
						'33'  => '33%',
						'25'  => '25%',
						'20'  => '20%',
					),
					'default' => '100',
				)
			);

			$this->add_responsive_control(
				'button_align',
				array(
					'label'        => __( 'Alignment', smw_slug ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => array(
						'start'   => array(
							'title' => __( 'Left', smw_slug ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'  => array(
							'title' => __( 'Center', smw_slug ),
							'icon'  => 'eicon-text-align-center',
						),
						'end'     => array(
							'title' => __( 'Right', smw_slug ),
							'icon'  => 'eicon-text-align-right',
						),
						'stretch' => array(
							'title' => __( 'Justified', smw_slug ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'default'      => 'start',
					'prefix_class' => 'elementor%s-button-align-',
				)
			);

		if ( class_exists( 'Elementor\Icons_Manager' ) ) {
			$this->add_control(
				'button_icon',
				array(
					'label'       => __( 'Icon', smw_slug ),
					'type'        => Controls_Manager::ICONS,
					'label_block' => true,
				)
			);
		} else {
			$this->add_control(
				'button_icon',
				array(
					'label'       => __( 'Icon', smw_slug ),
					'type'        => Controls_Manager::ICON,
					'label_block' => true,
				)
			);
		}

			$this->add_control(
				'button_icon_align',
				array(
					'label'     => __( 'Icon Position', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => array(
						'left'  => __( 'Before', smw_slug ),
						'right' => __( 'After', smw_slug ),
					),
					'condition' => array(
						'button_icon[value]!' => '',
					),
				)
			);

			$this->add_control(
				'button_icon_indent',
				array(
					'label'     => __( 'Icon Spacing', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'max' => 50,
						),
					),
					'condition' => array(
						'button_icon[value]!' => '',
					),
					'selectors' => array(
						'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_additional_options_controls() 
	{
		$this->start_controls_section(
			'section_additional_options',
			array(
				'label' => __( 'Additional Options', smw_slug ),
			)
		);

			$this->add_control(
				'redirect_after_login',
				array(
					'label'     => __( 'Redirect After Login', smw_slug ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => '',
					'label_off' => __( 'Off', smw_slug ),
					'label_on'  => __( 'On', smw_slug ),
				)
			);

			$this->add_control(
				'redirect_url',
				array(
					'type'          => Controls_Manager::URL,
					'show_label'    => false,
					'show_external' => false,
					'separator'     => false,
					'placeholder'   => __( 'https://your-link.com', smw_slug ),
					'description'   => __( 'Note: We do not allow external links, please use your domain only', smw_slug ),
					'condition'     => array(
						'redirect_after_login' => 'yes',
					),
					'separator'     => 'after',
				)
			);

			$this->add_control(
				'redirect_after_logout',
				array(
					'label'     => __( 'Redirect After Logout', smw_slug ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => '',
					'label_off' => __( 'Off', smw_slug ),
					'label_on'  => __( 'On', smw_slug ),
				)
			);

			$this->add_control(
				'redirect_logout_url',
				array(
					'type'          => Controls_Manager::URL,
					'show_label'    => false,
					'show_external' => false,
					'separator'     => false,
					'placeholder'   => __( 'https://your-link.com', smw_slug ),
					'description'   => __( 'Note: We do not allow external links, please use your domain only', smw_slug ),
					'condition'     => array(
						'redirect_after_logout' => 'yes',
					),
					'separator'     => 'after',
				)
			);

		if ( get_option( 'users_can_register' ) ) {
			$this->add_control(
				'show_register',
				array(
					'label'     => __( 'Register', smw_slug ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_off' => __( 'Hide', smw_slug ),
					'label_on'  => __( 'Show', smw_slug ),
				)
			);

			$this->add_control(
				'show_register_text',
				array(
					'label'     => __( 'Text', smw_slug ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => array(
						'active' => true,
					),
					'default'   => __( 'Register', smw_slug ),
					'condition' => array(
						'show_register' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_register_select',
				array(
					'label'     => __( 'Link to', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'default' => __( 'Default Register Page', smw_slug ),
						'custom'  => __( 'Custom URL', smw_slug ),
					),
					'default'   => 'default',
					'condition' => array(
						'show_register' => 'yes',
					),
				)
			);

			$this->add_control(
				'show_register_url',
				array(
					'label'     => __( 'Enter URL', smw_slug ),
					'type'      => Controls_Manager::URL,
					'description'   => __( 'Note: Ensure that you have a register page with the register widget inside.', smw_slug ),
					'dynamic'   => array(
						'active' => true,
					),
					'condition' => array(
						'show_register_select' => 'custom',
						'show_register'        => 'yes',
					),
					'separator' => 'after',
				)
			);
		}

			$this->add_control(
				'show_lost_password',
				array(
					'label'     => __( 'Lost your password?', smw_slug ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_off' => __( 'Hide', smw_slug ),
					'label_on'  => __( 'Show', smw_slug ),
				)
			);

			$this->add_control(
				'show_lost_password_text',
				array(
					'label'     => __( 'Text', smw_slug ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => array(
						'active' => true,
					),
					'default'   => __( 'Lost your password?', smw_slug ),
					'condition' => array(
						'show_lost_password' => 'yes',
					),
				)
			);

			$this->add_control(
				'lost_password_select',
				array(
					'label'     => __( 'Link to', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'default' => __( 'Default Forgot Password Page', smw_slug ),
						'custom'  => __( 'Custom URL', smw_slug ),
					),
					'description'   => __( 'Note: Ensure that you have a forgot password page with the forgot password widget inside.', smw_slug ),
					'default'   => 'default',
					'condition' => array(
						'show_lost_password' => 'yes',
					),
				)
			);

			$this->add_control(
				'lost_password_url',
				array(
					'label'     => __( 'Enter URL', smw_slug ),
					'type'      => Controls_Manager::URL,
					'dynamic'   => array(
						'active' => true,
					),
					'condition' => array(
						'lost_password_select' => 'custom',
						'show_lost_password'   => 'yes',
					),
				)
			);

			$this->add_control(
				'footer_divider',
				array(
					'label'      => __( 'Divider', smw_slug ),
					'type'       => Controls_Manager::TEXT,
					'default'    => '|',
					'selectors'  => array(
						'{{WRAPPER}} .smw-login-form-footer a.smw-login-form-footer-link:not(:last-child) span:after' => 'content: "{{VALUE}}"; margin: 0 0.4em;',
					),
					'separator'  => 'after',
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'show_lost_password',
								'operator' => '==',
								'value'    => 'yes',
							),
							array(
								'name'     => 'show_register',
								'operator' => '==',
								'value'    => 'yes',
							),
						),
					),
				)
			);

			$this->add_responsive_control(
				'footer_text_align',
				array(
					'label'      => __( 'Alignment', smw_slug ),
					'type'       => Controls_Manager::CHOOSE,
					'options'    => array(
						'flex-start' => array(
							'title' => __( 'Left', smw_slug ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'     => array(
							'title' => __( 'Center', smw_slug ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'   => array(
							'title' => __( 'Right', smw_slug ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'separator'  => 'before',
					'default'    => 'flex-left',
					'selectors'  => array(
						'{{WRAPPER}} .smw-login-form-footer' => 'justify-content: {{VALUE}};',
					),
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'show_lost_password',
								'operator' => '==',
								'value'    => 'yes',
							),
							array(
								'name'     => 'show_register',
								'operator' => '==',
								'value'    => 'yes',
							),
						),
					),
				)
			);

			$this->add_control(
				'footer_text_color',
				array(
					'label'      => __( 'Text Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_4,
					),
					'selectors'  => array(
						'{{WRAPPER}} .smw-login-form-footer, {{WRAPPER}} .smw-login-form-footer a' => 'color: {{VALUE}};',
					),
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'show_lost_password',
								'operator' => '==',
								'value'    => 'yes',
							),
							array(
								'name'     => 'show_register',
								'operator' => '==',
								'value'    => 'yes',
							),
						),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'       => 'footer_text_typography',
					'selector'   => '{{WRAPPER}} .smw-login-form-footer',
					'scheme'     => Typography::TYPOGRAPHY_4,
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'show_lost_password',
								'operator' => '==',
								'value'    => 'yes',
							),
							array(
								'name'     => 'show_register',
								'operator' => '==',
								'value'    => 'yes',
							),
						),
					),
				)
			);
			
			$this->add_control(
				'show_logged_in_message',
				array(
					'label'     => __( 'Logged in Message', smw_slug ),
					'description'  => __( 'If this option is disabled, there will be no message when this page is visited by a logged in user.', smw_slug ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'label_off' => __( 'Hide', smw_slug ),
					'label_on'  => __( 'Show', smw_slug ),
				)
			);
			
			$this->add_control(
				'custom_login_text',
				array(
					'label'        => __( 'Custom Login Message', smw_slug ),
					'description'  => __( 'Enable this option if you want to change the default logged in text', smw_slug ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', smw_slug ),
					'label_off'    => __( 'No', smw_slug ),
					'default'      => 'no',
					'condition' => array(
						'show_logged_in_message'  => 'yes',
					),
				)
			);
			
			$this->add_control(
				'logged_in_text',
				array(
					'label'       => __( 'Message For Logged In Users', smw_slug ),
					'description' => __( 'Enter the message to display at the frontend for Logged in users.', smw_slug ),
					'type'        => Controls_Manager::WYSIWYG,
					'dynamic'     => array(
						'active' => true,
					),
					'condition'   => array(
						'custom_login_text' => 'yes',
					),
				)
			);
			
			$this->add_control(
				'loggedin_message_color',
				array(
					'label'     => __( 'Text Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'selectors' => array(
						'{{WRAPPER}} .smw-custom-login-message' => 'color: {{VALUE}};',
					),
					'condition' => array(
						'logged_in_text!' => '',
						'custom_login_text' => 'yes',
					),
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_success_error_controls()
	{
	    $this->start_controls_section(
    		'section_error_field',
    		array(
    			'label' => __( 'Success / Error Messages', smw_slug ),
    		)
    	);
    	
    	$this->add_control(
				'login_validation_success_message',
				array(
					'label'       => __( 'Login Form Success Message', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Logged In Successfully, redirecting now ..', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
					'label_block' => true,
				)
			);

			$this->add_control(
				'login_validation_error_message',
				array(
					'label'       => __( 'Login Form Error Message', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Error: There has been an error, please try again!', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
					'label_block' => true,
				)
			);
    	
    	$this->end_controls_section();
	}
	
	protected function register_spacing_controls() 
	{
		$this->start_controls_section(
			'section_spacing_fields',
			array(
				'label' => __( 'Spacing', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'row_gap',
				array(
					'label'     => __( 'Rows Gap', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 20,
					),
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 60,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .elementor-field-group:not( .elementor-field-type-submit ):not( .smw-form-footer ):not( .smw-recaptcha-align-bottomright ):not( .smw-recaptcha-align-bottomleft )' => 'margin-top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'label_spacing',
				array(
					'label'     => __( 'Label Bottom Spacing', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .elementor-field-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
					'condition' => array(
						'show_labels!'      => 'none',
					),
				)
			);

			$this->add_responsive_control(
				'separator_top_spacing',
				array(
					'label'      => __( 'Separator Top Spacing', smw_slug ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => array(
						'px' => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} .smw-separator-parent' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: 0{{UNIT}};',
					),
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'enable_separator',
								'operator' => '==',
								'value'    => 'yes',
							),
							array(
								'name'     => 'social_position',
								'operator' => '==',
								'value'    => 'bottom',
							),
							array(
								'name'     => 'hide_custom_form',
								'operator' => '!==',
								'value'    => 'yes',
							),
						),
					),
				)
			);

			$this->add_responsive_control(
				'separator_bottom_spacing',
				array(
					'label'      => __( 'Separator Bottom Spacing', smw_slug ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => array(
						'px' => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} .smw-separator-parent' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-top: 0{{UNIT}};',
					),
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'enable_separator',
								'operator' => '==',
								'value'    => 'yes',
							),
							array(
								'name'     => 'social_position',
								'operator' => '==',
								'value'    => 'top',
							),
							array(
								'name'     => 'hide_custom_form',
								'operator' => '!==',
								'value'    => 'yes',
							),
						),
					),
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_form_fields_style_controls() {
		$this->start_controls_section(
			'section_form_fields_style',
			array(
				'label'     => __( 'Form Fields', smw_slug ),
				'tab'       => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'form_label_style',
				array(
					'label'      => __( 'Label', smw_slug ),
					'type'       => Controls_Manager::HEADING,
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'show_labels',
								'operator' => '!==',
								'value'    => 'none',
							),
							array(
								'name'     => 'show_remember_me',
								'operator' => '==',
								'value'    => 'yes',
							),
						),
					),
				)
			);

			$this->add_control(
				'label_color',
				array(
					'label'      => __( 'Colour', smw_slug ),
					'type'       => Controls_Manager::COLOR,
					'scheme'     => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'    => '',
					'selectors'  => array(
						'{{WRAPPER}} .elementor-field-label, {{WRAPPER}} .smw-login-form-remember, {{WRAPPER}} .smw-logged-in-message' => 'color: {{VALUE}};',
					),
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'show_labels',
								'operator' => '!==',
								'value'    => 'none',
							),
							array(
								'name'     => 'show_remember_me',
								'operator' => '==',
								'value'    => 'yes',
							),
						),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'       => 'label_typo',
					'scheme'     => Typography::TYPOGRAPHY_3,
					'selector'   => '{{WRAPPER}} .elementor-field-label, {{WRAPPER}} .smw-loginform-error, {{WRAPPER}} .smw-logged-in-message',
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'show_labels',
								'operator' => '!==',
								'value'    => 'none',
							),
							array(
								'name'     => 'show_remember_me',
								'operator' => '==',
								'value'    => 'yes',
							),
						),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'label'     => __( 'Remember Me Typography', smw_slug ),
					'name'      => 'rememberme_typo',
					'scheme'    => Typography::TYPOGRAPHY_3,
					'selector'  => '{{WRAPPER}} .smw-login-form-remember',
					'condition' => array(
						'show_remember_me'  => 'yes',
					),
				)
			);

			$this->add_control(
				'label_style_heading',
				array(
					'type'       => Controls_Manager::DIVIDER,
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'show_labels',
								'operator' => '!==',
								'value'    => 'none',
							),
							array(
								'name'     => 'show_remember_me',
								'operator' => '==',
								'value'    => 'yes',
							),
						),
					),
				)
			);

			$this->add_control(
				'form_field_style',
				array(
					'label' => __( 'Input Field', smw_slug ),
					'type'  => Controls_Manager::HEADING,
				)
			);

			$this->add_control(
				'field_text_color',
				array(
					'label'     => __( 'Text / Placeholder Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .elementor-field, {{WRAPPER}} .elementor-field::placeholder, 
						{{WRAPPER}} .smw-login-form input[type="checkbox"]:checked + span:before' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_control(
				'input_bgcolor',
				array(
					'label'     => __( 'Background Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#fafafa',
					'selectors' => array(
						'{{WRAPPER}} .elementor-field,
						{{WRAPPER}} .smw-login-form input[type="checkbox"] + span:before' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'field_typo',
					'scheme'   => Typography::TYPOGRAPHY_3,
					'selector' => '{{WRAPPER}} .elementor-field, {{WRAPPER}} .elementor-field::placeholder',
				)
			);

			$this->add_responsive_control(
				'input_padding',
				array(
					'label'      => __( 'Padding', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .elementor-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'input_border',
				array(
					'label'      => __( 'Border Width', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .elementor-field' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'input_border_color',
				array(
					'label'     => __( 'Border Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .elementor-field, 
						{{WRAPPER}} .smw-login-form input[type="checkbox"] + span:before' => 'border-color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'input_border_radius',
				array(
					'label'      => __( 'Border Radius', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .elementor-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_button_style_controls() {

		$this->start_controls_section(
			'section_button_style',
			array(
				'label'     => __( 'Button', smw_slug ),
				'tab'       => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'button_typography',
					'scheme'   => Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} .elementor-button, {{WRAPPER}} .elementor-button svg',
				)
			);

			$this->add_responsive_control(
				'button_padding',
				array(
					'label'      => __( 'Padding', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
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
						'button_text_color',
						array(
							'label'     => __( 'Text Colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => array(
								'{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'button_background_color',
						array(
							'label'     => __( 'Background Colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => array(
								'type'  => Color::get_type(),
								'value' => Color::COLOR_4,
							),
							'selectors' => array(
								'{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'button_border',
							'label'    => __( 'Border', smw_slug ),
							'selector' => '{{WRAPPER}} .elementor-button',
						)
					);

					$this->add_control(
						'button_border_radius',
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
							'name'     => 'button_box_shadow',
							'selector' => '{{WRAPPER}} .elementor-button',
						)
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'button_hover',
					array(
						'label' => __( 'Hover', smw_slug ),
					)
				);

					$this->add_control(
						'button_hover_color',
						array(
							'label'     => __( 'Text Colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_control(
						'button_background_hover_color',
						array(
							'label'     => __( 'Background Colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'scheme'    => array(
								'type'  => Color::get_type(),
								'value' => Color::COLOR_4,
							),
							'selectors' => array(
								'{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						array(
							'label'    => __( 'Box Shadow', smw_slug ),
							'name'     => 'button_box_hover_shadow',
							'selector' => '{{WRAPPER}} .elementor-button:hover',
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}
	
	protected function register_validation_controls() 
	{
		$this->start_controls_section(
			'section_fields_validate_style',
			array(
				'label'     => __( 'Field Validation Message', smw_slug ),
				'tab'       => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'validation_message_typo',
					'scheme'   => Typography::TYPOGRAPHY_3,
					'selector' => '{{WRAPPER}} .smw-loginform-error',
				)
			);

			$this->add_control(
				'validation_message_color',
				array(
					'label'     => __( 'Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#d9534f',
					'selectors' => array(
						'{{WRAPPER}} .smw-loginform-error' => 'color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_error_style_controls()
	{
	    $this->start_controls_section(
			'section_messages_style',
			array(
				'label' => __( 'Success / Error Messages', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		
		    $this->add_control(
					'error_message_style',
					array(
						'label'        => __( 'Message Style', smw_slug ),
						'type'         => Controls_Manager::SELECT,
						'default'      => 'default',
						'options'      => array(
							'default' => __( 'Default', smw_slug ),
							'custom'  => __( 'Custom', smw_slug ),
						),
						'prefix_class' => 'smw-forgot-form-message-style-',
					)
				);
		
		    $this->add_control(
    				'field_error_heading',
    				array(
    					'label' => __( 'Error Message', smw_slug ),
    					'type'  => Controls_Manager::HEADING,
    					'condition' => array(
							'error_message_style' => 'custom',
						),
    				)
    			);
				
				$this->add_control(
					'error_message_bgcolor',
					array(
						'label'     => __( 'Message Background Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#f2dede',
						'condition' => array(
							'error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-login-message-error' => 'background-color: {{VALUE}}; padding: 0.2em 0.8em;',
						),
					)
				);

				$this->add_control(
					'error_msg_color',
					array(
						'label'     => __( 'Message Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#a94442',
						'condition' => array(
							'error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-login-message-error' => 'color: {{VALUE}}',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'error_message_typo',
						'scheme'   => Typography::TYPOGRAPHY_3,
						'condition' => array(
							'error_message_style' => 'custom',
						),
						'selector' => '{{WRAPPER}} .smw-login-message-error',
					)
				);
				
				$this->add_control(
    				'forgot_field_success_heading',
    				array(
    					'label' => __( 'Success Message', smw_slug ),
    					'type'  => Controls_Manager::HEADING,
    					'condition' => array(
							'error_message_style' => 'custom',
						),
    				)
    			);
				
				$this->add_control(
					'success_message_bgcolor',
					array(
						'label'     => __( 'Message Background Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#dff0d8',
						'condition' => array(
							'error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-login-message-success' => 'background-color: {{VALUE}}; padding: 0.2em 0.8em;',
						),
					)
				);
				
				$this->add_control(
					'success_msg_color',
					array(
						'label'     => __( 'Message Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#3c763d',
						'condition' => array(
							'error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-login-message-success' => 'color: {{VALUE}}',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'success_message_typo',
						'scheme'   => Typography::TYPOGRAPHY_3,
						'condition' => array(
							'error_message_style' => 'custom',
						),
						'selector' => '{{WRAPPER}} .smw-login-message-success',
					)
				);
		
		$this->end_controls_section();
	}
	
	protected function render() 
	{
	    $settings        = $this->get_settings_for_display();
		$node_id         = $this->get_id();
		$is_hidden       = false;
		$logout_redirect = '';
		$redirect        = '';
		$is_editor       = \Elementor\Plugin::instance()->editor->is_edit_mode();

		$invalid_username = '';
		$invalid_password = '';
		$fields_empty     = '';
		$username_empty  = '';
		$password_empty   = '';
		$session_error    = isset( $_SESSION['smw_error'] ) ? $_SESSION['smw_error'] : '';
		$session_id       = session_id();
		$redirect_admin   = 'no';
        
		if ( ! empty( $session_id ) ) 
		{
			if ( isset( $_SESSION['smw_error'] ) ) 
			{
				if ( isset( $session_error ) ) 
				{
				    if ( 'fields_empty' === $session_error ) 
					{
						$fields_empty = __( 'Empty Fields. Looks like you submitted an empty form, please try again', smw_slug );
					} elseif ( 'username_empty' === $session_error ) {
					    $username_empty = __( 'Empty Username. Looks like you submitted a form without a username, please try again', smw_slug );
					} elseif ( 'password_empty' === $session_error ) {
					    $password_empty = __( 'Empty Password. Looks like you submitted a form without a password, please try again', smw_slug );
					} elseif ( 'invalid_username' === $session_error ) {
						$invalid_username = __( 'Unknown Username. Check again or try your email address.', smw_slug );
					} elseif ( 'invalid_email' === $session_error ) {
						$invalid_username = __( 'Unknown Email address. Check again or try your username.', smw_slug );
					} elseif ( 'incorrect_password' === $session_error ) {
						$invalid_password = __( 'Error: The Password you have entered is incorrect.', smw_slug );
					}
					unset( $_SESSION['smw_error'] );
				}
			}
		}
		
		$this->add_render_attribute(
			array(
				'wrapper' => array(
					'class' => array(
						'elementor-form-fields-wrapper',
					),
				),
				'smw_login_wrap' => array(
						'data-success-message' => $settings['login_validation_success_message'],
                        'data-error-message'   => $settings['login_validation_error_message'],
				),
				'field-group'     => array(
					'class' => array(
						'elementor-field-type-text',
						'elementor-field-group',
						'elementor-column',
						'elementor-col-100',
					),
				),
				'submit-group'    => array(
					'class' => array(
						'elementor-field-group',
						'elementor-column',
						'elementor-field-type-submit',
						'elementor-col-' . $settings['button_width'],
						'spacer-top',
					),
				),

				'button' => array(
					'class' => array(
						'elementor-button',
						'smw-login-form-submit',
					),
					'name' => 'smw-login-submit',
					'data-ajax-enable' => $settings['enable_ajax'],
				),
				'icon-align'   => array(
					'class' => array(
						empty( $settings['button_icon_align'] ) ? '' :
							'elementor-align-icon-' . $settings['button_icon_align'],
							'elementor-button-icon',
					),
				),
				'user_input'      => array(
					'type'        => 'text',
					'name'        => 'username',
					'id'          => 'user',
					'placeholder' => wp_kses_post( $settings['user_placeholder'] ),
					'class'       => array(
						'elementor-field',
						'elementor-field-textual',
						'elementor-size-' . $settings['input_size'],
						'smw-login-form-username',
					),
				),
				'password_input'  => array(
					'type'        => 'password',
					'name'        => 'password',
					'id'          => 'password',
					'placeholder' => $settings['password_placeholder'],
					'class'       => array(
						'elementor-field',
						'elementor-field-textual',
						'elementor-size-' . $settings['input_size'],
						'smw-login-form-password',
					),
				),
				
				'user_label' => array(
					'for'   => 'user',
					'class' => 'elementor-field-label',
				),

				'password_label'  => array(
					'for'   => 'password',
					'class' => 'elementor-field-label',
				),
			)
		);
		
		if ( ! empty( $settings['button_width_tablet'] ) ) 
    	{
    		$this->add_render_attribute( 'submit-group', 'class', 'elementor-md-' . $settings['button_width_tablet'] );
    	}

    	if ( ! empty( $settings['button_width_mobile'] ) ) {
    		$this->add_render_attribute( 'submit-group', 'class', 'elementor-sm-' . $settings['button_width_mobile'] );
    	}
    			
		if ( ! empty( $settings['button_size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['button_size'] );
		}
		
		if ( ! empty( $settings['button_type'] ) ) {
    		$this->add_render_attribute( 'button', 'class', 'elementor-button-' . $settings['button_type'] );
    	}
    
    	if ( $settings['button_hover_animation'] ) {
    		$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
    	}

		if ( 'none' === $settings['show_labels'] ) {
			$this->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
		}

		$this->add_render_attribute( 'field-group', 'class', 'elementor-field-required' )
			->add_render_attribute( 'input', 'required', true )
			->add_render_attribute( 'input', 'aria-required', 'true' );

		if ( 'yes' === $settings['redirect_after_login'] && ! empty( $settings['redirect_url']['url'] ) ) {
			$this->add_render_attribute( 'smw_login_wrap', 'data-redirect-url', $settings['redirect_url']['url'] );
			$redirect = $settings['redirect_url']['url'];
		}

		if ( 'yes' === $settings['redirect_after_logout'] && ! empty( $settings['redirect_logout_url']['url'] ) ) {
			$logout_redirect = $settings['redirect_logout_url']['url'];
		}
		
		if ( is_user_logged_in() && ! $is_editor ) 
		{
			if ( 'yes' === $settings['show_logged_in_message'] && 'no' === $settings['custom_login_text']) 
			{
				$current_user = wp_get_current_user();
				?>
				<div class="smw-logged-in-message">
				<?php
				$user_name   = $current_user->display_name;
				$a_tag       = '<a href="' . esc_url( wp_logout_url( $logout_redirect ) ) . '">';
				$close_a_tag = '</a>';
				/* translators: %1$s user name */
				printf( esc_html__( 'You are Logged in as %1$s (%2$sLogout%3$s)', smw_slug ), wp_kses_post( $user_name ), wp_kses_post( $a_tag ), wp_kses_post( $close_a_tag ) );
				?>
				</div>
				<?php
			}
			elseif ( 'yes' === $settings['show_logged_in_message'] && $settings['custom_login_text'] !== 'yes') 
			{
				$current_user = wp_get_current_user();
				?>
				<div class="smw-logged-in-message">
				<?php
				$user_name   = $current_user->display_name;
				$a_tag       = '<a href="' . esc_url( wp_logout_url( $logout_redirect ) ) . '">';
				$close_a_tag = '</a>';
				/* translators: %1$s user name */
				printf( esc_html__( 'You are Logged in as %1$s (%2$sLogout%3$s)', smw_slug ), wp_kses_post( $user_name ), wp_kses_post( $a_tag ), wp_kses_post( $close_a_tag ) );
				?>
				</div>
				<?php
			}
			else
			{
			    $current_user = wp_get_current_user();
			    ?>
			    <div class="smw-logged-in-message">
			        <?php
			        if ( '' !== $settings['logged_in_text'] ) {
						echo '<span>' . wp_kses_post( $settings['logged_in_text'] ) . '</span>';
					}
					else 
					{
					    $user_name   = $current_user->display_name;
				        $a_tag       = '<a href="' . esc_url( wp_logout_url( $logout_redirect ) ) . '">';
				        $close_a_tag = '</a>';
				        /* translators: %1$s user name */
				        printf( esc_html__( 'You are Logged in as %1$s (%2$sLogout%3$s)', smw_slug ), wp_kses_post( $user_name ), wp_kses_post( $a_tag ), wp_kses_post( $close_a_tag ) );
					}
					?>
			    </div>
			    <?php
			}
			return;
		}
			
		if ( ! $is_hidden ) 
		{
			?>
			<div class="login-outcome" style="display:none;"></div>
			
			<?php
			if ( class_exists( 'Limit_Login_Attempts' ) ) 
    		{
    		    ?>
                <div id ="llaerror"></div>
                <?php
            }
            ?>
			
			<div class="smw-login-form-wrapper" <?php echo wp_kses_post( $this->get_render_attribute_string( 'smw_login_wrap' ) ); ?>>
    			    <form class="elementor-form smw-login-form" id="smw-login-form" method="post" <?php echo wp_kses_post( $this->get_render_attribute_string( 'form' ) ); ?>>
    				<?php if ( 'yes' === $settings['redirect_after_login'] && ! empty( $settings['redirect_url']['url'] ) ) { ?>
    					<input type="hidden" name="redirect_to" value=<?php echo esc_url( $settings['redirect_url']['url'] ); ?>>
    					<?php
    					$redirect = $settings['redirect_url']['url']; ?>
    					
    				<?php }
    				else { ?>
    				    <input type="hidden" name="redirect_to" value="/">
    				    <?php
    				}
                    ?>

    				<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
    					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'field-group' ) ); ?>>
    						<?php
    						if ( 'custom' === $settings['show_labels'] ) {
    							echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'user_label' ) ) . '>' . wp_kses_post( $settings['user_label'] ) . '</label>';
    						} elseif ( 'default' === $settings['show_labels'] ) {
    							echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'user_label' ) ) . '>';
    							echo esc_attr__( 'Username or Email Address', smw_slug );
    							echo '</label>';
    						}
    
    						echo '<input size="1" ' . wp_kses_post( $this->get_render_attribute_string( 'user_input' ) ) . '>';
    
    						?>
    						<?php if ( '' !== $invalid_username ) { ?>
    							<span class="smw-login-field-message"><span class="smw-loginform-error"><?php echo wp_kses_post( $invalid_username ); ?></span></span>
    						<?php } ?>
    						<?php if ( '' !== $username_empty ) { ?>
    							<span class="smw-login-field-message"><span class="smw-loginform-error"><?php echo wp_kses_post( $username_empty ); ?></span></span>
    						<?php } ?>
    						
    						<span id="empty_username" style="margin-top:10px;"></span>
    					</div>
    
    					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'field-group' ) ); ?>>
    						<?php
    						if ( 'custom' === $settings['show_labels'] ) {
    							echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'password_label' ) ) . '>' . wp_kses_post( $settings['password_label'] ) .
    							'</label>';
    						} elseif ( 'default' === $settings['show_labels'] ) {
    							echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'password_label' ) ) . '>';
    							echo esc_attr__( 'Password', smw_slug );
    							echo '</label>';
    						}
    
    						echo '<input size="1" ' . wp_kses_post( $this->get_render_attribute_string( 'password_input' ) ) . '>';
    						?>
    						<?php if ( '' !== $invalid_password ) { ?>
    							<span class="smw-login-field-message"><span class="smw-loginform-error"><?php echo wp_kses_post( $invalid_password ); ?></span></span>
    						<?php } ?>
    						<?php if ( '' !== $password_empty ) { ?>
    							<span class="smw-login-field-message"><span class="smw-loginform-error"><?php echo wp_kses_post( $password_empty ); ?></span></span>
    						<?php } ?>
    						
    						<span id="empty_password" style="margin-top:10px;"></span>
    						
    					</div>
    
    					<?php if ( 'yes' === $settings['show_remember_me'] ) { ?>
    						<div class="elementor-field-type-checkbox elementor-field-group elementor-column elementor-col-100 elementor-remember-me">
    							<label for="smw-login-remember-me">
    								<input type="checkbox" id="smw-login-remember-me" class="smw-login-form-remember" name="rememberme" value="forever">
    									<span class="smw-login-form-remember"><?php echo esc_attr__( 'Remember Me', smw_slug ); ?></span>
    							</label>
    						</div>
    					<?php } ?>
    					
    					<?php if ( '' !== $fields_empty ) { ?>
    							<span class="smw-login-field-message"><span class="smw-loginform-error"><?php echo wp_kses_post( $fields_empty ); ?></span></span>
    					<?php } ?>
    					
    					<span id="empty_fields" style="margin-top:10px;"></span>
    
    					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'submit-group' ) ); ?>>
    					    
    						<button type="submit" <?php echo wp_kses_post( $this->get_render_attribute_string( 'button' ) ); ?>>
    							<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'content-wrapper' ) ); ?>>
    							<?php if ( ( ! empty( $settings['button_icon'] ) && ! class_exists( 'Elementor\Icons_Manager' ) ) || ( '' !== $settings['button_icon']['value'] && class_exists( 'Elementor\Icons_Manager' ) ) ) { ?>
    							<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'icon-align' ) ); ?>>
    							<?php
    							if ( $settings['button_icon']['value'] && class_exists( 'Elementor\Icons_Manager' ) ) {
    								\Elementor\Icons_Manager::render_icon( $settings['button_icon'], array( 'aria-hidden' => 'true' ) );
    								} elseif ( ! empty( $settings['button_icon'] ) && ! class_exists( 'Elementor\Icons_Manager' ) ) {
    								?>
    								<i class="<?php echo esc_attr( $settings['button_icon'] ); ?>"></i>	
    								<?php } ?>	
    										<?php } ?>													
    										<?php if ( empty( $settings['button_text'] ) ) { ?>
    											<span class="elementor-screen-only"><?php esc_attr_e( 'Submit', smw_slug ); ?></span>
    										<?php } ?>
    									</span>
    								<?php if ( ! empty( $settings['button_text'] ) ) : ?>
    									<span class="elementor-button-text smw-login-submit"><?php echo wp_kses_post( $settings['button_text'] ); ?></span>
    								<?php endif; ?>
    							</span>
    						</button>
    					</div>
    
    					<?php
    					$show_lost_password = 'yes' === $settings['show_lost_password'];
    					$show_register      = get_option( 'users_can_register' ) && 'yes' === $settings['show_register'];
    
    					if ( $show_lost_password || $show_register ) :
    						?>
    						<div class="elementor-field-group elementor-column elementor-col-100 smw-login-form-footer spacer-top">
    							<?php
    							if ( $show_register ) :
    								$register_url = wp_registration_url();
    								$this->add_render_attribute( 'register_var', 'class', 'smw-login-form-footer-link' );
    
    								if ( 'custom' === $settings['show_register_select'] && ! empty( $settings['show_register_url'] ) ) {
    									$this->add_render_attribute( 'register_var', 'href', $settings['show_register_url']['url'] );
    
    									if ( $settings['show_register_url']['is_external'] ) {
    										$this->add_render_attribute( 'register_var', 'target', '_blank' );
    									}
    
    									if ( $settings['show_register_url']['nofollow'] ) {
    										$this->add_render_attribute( 'register_var', 'rel', 'nofollow' );
    									}
    								} else {
    									$this->add_render_attribute( 'register_var', 'href', $register_url );
    								}
    								?>
    								<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'register_var' ) ); ?>>
    									<span class="elementor-inline-editing" data-elementor-setting-key="show_register_text" data-elementor-inline-editing-toolbar="basic"><?php echo wp_kses_post( $settings['show_register_text'] ); ?></span>
    								</a>
    							<?php endif; ?>
    
    							<?php
    							if ( $show_lost_password ) :
    								$lost_pass_url = wp_lostpassword_url();
    								$this->add_render_attribute( 'lost_pass', 'class', 'smw-login-form-footer-link' );
    
    								if ( 'custom' === $settings['lost_password_select'] && ! empty( $settings['lost_password_url'] ) ) {
    									$this->add_render_attribute( 'lost_pass', 'href', $settings['lost_password_url']['url'] );
    
    									if ( $settings['lost_password_url']['is_external'] ) {
    										$this->add_render_attribute( 'lost_pass', 'target', '_blank' );
    									}
    
    									if ( $settings['lost_password_url']['nofollow'] ) {
    										$this->add_render_attribute( 'lost_pass', 'rel', 'nofollow' );
    									}
    								} else {
    									$this->add_render_attribute( 'lost_pass', 'href', $lost_pass_url );
    								}
    								?>
    								<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'lost_pass' ) ); ?>>
    									<span class="elementor-inline-editing" data-elementor-setting-key="show_lost_password_text" data-elementor-inline-editing-toolbar="basic"><?php echo wp_kses_post( $settings['show_lost_password_text'] ); ?></span>
    								</a>
    							<?php endif; ?>
    						</div>
    					<?php endif; ?>
    					</div>
    					
    					<?php
    					if ( $settings['enable_ajax'] !== 'yes' && ! $is_editor) 
    					{
    						echo '<input type="hidden" name="action" value="login_submit">';
                            wp_nonce_field( 'login_submit', 'smw-nonce' ); 
    					}
    					?>
    			</form>
		</div>
	    <?php } ?>
		<?php
		
		if ( 'yes' === $settings['enable_ajax'] && ! $is_editor ) 
    	{
    	    ?>
            <script type="text/javascript">
    			jQuery(document).ready(function($) 
    			{
    			    //login start
    				var login_form = 'form#smw-login-form';
    				var loading_text='<span class="loading-spinner-log"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span><?php echo esc_html($settings["login_msg_loading_txt"]); ?>';
    				var notverify='<span class="loading-spinner-log"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span><?php echo esc_html($settings["login_msg_validation"]); ?>';
    				var incorrect_text='<span class="loading-spinner-log"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span><?php echo esc_html($settings["login_msg_error"]); ?>';
    				var correct_text='<span class="loading-spinner-log"><i class="fa fa-envelope-o" aria-hidden="true"></i></span><?php echo esc_html($settings["login_msg_success"]); ?>';
    				var empty_fields='<span class="smw-login-field-message"><span class="smw-loginform-error">Empty Fields. Looks like you submitted an empty form, please try again</span></span>';
    				var empty_password='<span class="smw-login-field-message"><span class="smw-loginform-error">Empty Password. Looks like you submitted a form without a password, please try again</span></span>';
    				var empty_username='<span class="smw-login-field-message"><span class="smw-loginform-error">Empty Username. Looks like you submitted a form without a username, please try again</span></span>';
    				var incorrect_username='<span class="smw-login-field-message"><span class="smw-loginform-error">Unknown Username. Check again or try your email address.</span></span>';
    				var incorrect_password='<span class="smw-login-field-message"><span class="smw-loginform-error">Error: The Password you have entered is incorrect.</span></span>';
    				var unknown_email='<span class="smw-login-field-message"><span class="smw-loginform-error">Unknown Email address. Check again or try your username.</span></span>';
    				var success = '';
    				var error = '';
    				
    	            $(login_form).on('submit', function(e)
    	            {
    	                $("#empty_password").empty();
    	                $("#empty_fields").empty();
    	                $("#empty_username").empty();
    	                
    	                success = $(".smw-login-form-wrapper").attr("data-success-message");
    	                error = $(".smw-login-form-wrapper").attr("data-error-message");   
    	                
    			        $.ajax({
    			            type: 'POST',
    			            dataType: 'json',
    			            url: smw_ajax_url,
    			            data: { 
    			                'action': 'smw_login_form_submit',
    			                'username': $(login_form + ' #user').val(), 
    			                'password': $(login_form + ' #password').val(),
    			                'nonce': smw_nonce
    			            },
    						beforeSend: function(){							
    							$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification").addClass("active");
    							$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification .tp-lr-response").html(loading_text);
    						},
    			            success: function(data) 
    			            {	
    			                if (data.success == false)
    			                {
    			                    if(data.data == "empty_password")
    			                    {
    			                        $('.login-outcome').removeClass("smw-login-message-success")
            			                $('.login-outcome').addClass("smw-login-message-error");
            			                $('.login-outcome').html('<span class="smw-login-error">' + error + '</span>');
                                        $('.login-outcome').show();
                                    
    							        $("#empty_password").html(empty_password);
    			                    }
    			                    if(data.data == "fields_empty")
    			                    {
    			                        $('.login-outcome').removeClass("smw-login-message-success")
            			                $('.login-outcome').addClass("smw-login-message-error");
            			                $('.login-outcome').html('<span class="smw-login-error">' + error + '</span>');
                                        $('.login-outcome').show();
                                        
    							        $("#empty_fields").html(empty_fields);
    			                    }
    			                    if(data.data == "empty_username")
    			                    {
    			                        $('.login-outcome').removeClass("smw-login-message-success")
            			                $('.login-outcome').addClass("smw-login-message-error");
            			                $('.login-outcome').html('<span class="smw-login-error">' + error + '</span>');
                                        $('.login-outcome').show();
                                        
    							        $("#empty_username").html(empty_username);
    			                    }
    			                    
    			                    <?php
                            			if ( class_exists( 'Limit_Login_Attempts' ) ) 
                                		{
                                		    ?>
                                		    if( data.data.reason == "incorrect_password" )
            			                    {
            			                        $('.login-outcome').removeClass("smw-login-message-success")
                    			                $('.login-outcome').addClass("smw-login-message-error");
                    			                $('.login-outcome').html('<span class="smw-login-error">' + error + '</span>');
                                                $('.login-outcome').show();
                                                
            							        $("#empty_password").html(incorrect_password);
            							        
            							        if( data.data.llaerror == "ERROR: Too many failed log in attempts. Please try again in 20 minutes" )
            							        {
            							            
            							        }
            			                        
            			                        $('#llaerror').addClass("smw-login-message-warning");
            			                        
            			                        if( data.data.llaerror.includes( 'ERROR' ) )
            							        {
            							            $('#llaerror').html( data.data.llaerror );
            							        }
            							        else
            							        {
            							            $('#llaerror').html( '<strong>WARNING:</strong> ' + data.data.llaerror + ' before you will be locked out of the portal' );
            							        }
            							        
                                                $('#llaerror').show();
            			                    }
            			                    
            			                    if( data.data.reason == "invalid_username" )
            			                    {
            			                        $('.login-outcome').removeClass("smw-login-message-success")
                    			                $('.login-outcome').addClass("smw-login-message-error");
                    			                $('.login-outcome').html('<span class="smw-login-error">' + error + '</span>');
                                                $('.login-outcome').show();
                                                
                                                $("#empty_username").html(incorrect_username);
            			                        
            			                        $('#llaerror').addClass("smw-login-message-warning");
            							        $('#llaerror').html( '<strong>WARNING:</strong> ' + data.data.llaerror + ' before you will be locked out of the portal' );
                                                $('#llaerror').show();
            			                    }
            			                    
            			                    if( data.data.reason == "invalid_email" )
            			                    {
            			                        $('.login-outcome').removeClass("smw-login-message-success")
                    			                $('.login-outcome').addClass("smw-login-message-error");
                    			                $('.login-outcome').html('<span class="smw-login-error">' + error + '</span>');
                                                $('.login-outcome').show();
                                                
            							        $("#empty_username").html(unknown_email);
            							        
            							        $('#llaerror').addClass("smw-login-message-warning");
            							        $('#llaerror').html( '<strong>WARNING:</strong> ' + data.data.llaerror + ' before you will be locked out of the portal' );
                                                $('#llaerror').show();
            			                    }
            			                    
            			                    if( data.data.reason == "too_many_retries")
            			                    {
            			                        $('.login-outcome').removeClass("smw-login-message-success")
                    			                $('.login-outcome').addClass("smw-login-message-error");
                    			                $('.login-outcome').html('<span class="smw-login-error">You Cannot Access The Portal!</span><br/><br/><span>' + data.data.llaerror + '</span>');
                                                $('.login-outcome').show();
                                                
                                                $('#llaerror').hide();
            			                    }
                                		<?php
                                		}
                                		else
                                		{
                                		    ?>
                                		    if(data.data[0].code == "invalid_email")
            			                    {
            			                        $('.login-outcome').removeClass("smw-login-message-success")
                    			                $('.login-outcome').addClass("smw-login-message-error");
                    			                $('.login-outcome').html('<span class="smw-login-error">' + error + '</span>');
                                                $('.login-outcome').show();
                                                
            							        $("#empty_username").html(unknown_email);
            			                    }
                                        
            			                    if(data.data[0].code == "invalid_username")
            			                    {
            			                        $('.login-outcome').removeClass("smw-login-message-success")
                    			                $('.login-outcome').addClass("smw-login-message-error");
                    			                $('.login-outcome').html('<span class="smw-login-error">' + error + '</span>');
                                                $('.login-outcome').show();
                                                
                                                $("#empty_username").html(incorrect_username);
            			                    }
            			                    
            			                    if(data.data[0].code == "incorrect_password")
            			                    {
            			                        $('.login-outcome').removeClass("smw-login-message-success")
                    			                $('.login-outcome').addClass("smw-login-message-error");
                    			                $('.login-outcome').html('<span class="smw-login-error">' + error + '</span>');
                                                $('.login-outcome').show();
                                                
            							        $("#empty_password").html(incorrect_password);
            			                    }
                                		<?php
                                		}
                                        ?>
    			                } else {
    								if(data.data == "loggedin")
    								{
    								    $("#llaerror").hide();
    								    $('.login-outcome').removeClass("smw-login-message-error")
            			                $('.login-outcome').addClass("smw-login-message-success");
            			                $('.login-outcome').html('<span class="smw-login-success">' + success + '</span>');
                                        $('.login-outcome').show();
			                            document.location.href = '<?php echo esc_url( $redirect ); ?>';
    								}
    			                }
    			            },
    			            error: function(data) 
    			            {
    						
    						},
    						complete: function(){
    							setTimeout(function(){
    										$("#tp-user-login<?php echo esc_attr($id);?> .theplus-notification").removeClass("active");	
    									}, 1500);
    						}
    			        });
    			        e.preventDefault();
    			    });
    			});
		    </script> 
		    <?php
    	}
	} 
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_login() );