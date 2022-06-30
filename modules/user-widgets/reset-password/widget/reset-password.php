<?php

/**
 * SMW Reset Password Form.
 *
 * @package SMW
 */

namespace StilesMediaWidgets;

// Elementor Classes.
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Button;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Plugin;

if(!defined('ABSPATH')) exit;

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

class stiles_reset_password extends Widget_Base
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'reset-password-css', plugin_dir_url( __FILE__ ) . '../css/reset-password.css');
    }
    
    public function get_name()
    {
        return 'stiles-reset-password';
    }
    
    public function get_title()
    {
        return 'Reset Password';
    }
    
    public function get_icon()
    {
        return 'eicon-info-circle-o';
    }
    
    public function get_categories()
    {
        return ['stiles-media-users'];
    }
    
    public function get_style_depends() 
    {
        return [ 'reset-password-css' ];
    }
    
    public static function get_button_sizes() 
    {
		return Widget_Button::get_button_sizes();
	}
	
	protected function register_controls() 
	{ 
	    $this->register_form_selection();
	    
		$this->register_general_controls();
		
		$this->register_button_controls();
		
		$this->register_settings_controls();
		
		$this->register_validation_message_controls();
		
		$this->register_spacing_controls();
		
		$this->register_label_style_controls();

		$this->register_input_style_controls();

		$this->register_submit_style_controls();

		$this->register_error_style_controls();
	}
	
	public function get_script_depends()
	{
        return [ 'reset-password-js' ];
    }
    
    protected function register_form_selection()
    {
        $this->start_controls_section(
			'section_choose_form',
			array(
				'label' => __( 'Choose Your Form', smw_slug ),
			)
		);
		
		$this->add_control(
			'choose_form',
			array(
				'label'   => __( 'Choose Form', smw_slug ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'forgot-password'    => __( 'Forgot Password', smw_slug ),
					'reset-password'     => __( 'Reset Password', smw_slug ),
				),
					'default' => 'forgot-password',
					'condition'   => array(
					'generate_password!' => 'true',
				),
			)
		);
		
		$this->add_control(
			'choose_form_generate',
			array(
				'label'   => __( 'Choose Form', smw_slug ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'forgot-password'    => __( 'Forgot Password', smw_slug ),
				),
					'default' => 'forgot-password',
					'condition'   => array(
					'generate_password' => 'true',
				),
			)
		);
		
		$this->end_controls_section();
    }
	
	protected function register_general_controls() 
    {
		$this->start_controls_section(
			'section_general_field',
			array(
				'label' => __( 'Form Fields', smw_slug ),
			)
		);
	
			$this->add_control(
				'input_size',
				array(
					'label'     => __( 'Input Size', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'xs' => __( 'Extra Small', smw_slug ),
						'sm' => __( 'Small', smw_slug ),
						'md' => __( 'Medium', smw_slug ),
						'lg' => __( 'Large', smw_slug ),
						'xl' => __( 'Extra Large', smw_slug ),
					),
					'default'   => 'sm',
					'separator' => 'before',
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
						'label'       => __( 'Reset Password Label', smw_slug ),
						'default'     => __( 'Re-Enter Password', smw_slug ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => array(
							'active' => true,
						),
						'label_block' => true,
						'condition'   => array(
							'show_labels' => 'custom',
							'generate_password!'  => 'true',
						),
					)
				);
				
				$this->add_control(
					'password_placeholder',
					array(
						'label'       => __( 'New Password Placeholder', smw_slug ),
						'default'     => __( 'New Password', smw_slug ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => array(
							'active' => true,
						),
						'label_block' => true,
						'condition'   => array(
							'show_labels' => 'custom',
							'generate_password!'  => 'true',
						),
					)
				);
				
				$this->add_control(
					'confirm_password_label',
					array(
						'label'       => __( 'Reset Password Label', smw_slug ),
						'default'     => __( 'New Password', smw_slug ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => array(
							'active' => true,
						),
						'label_block' => true,
						'condition'   => array(
							'show_labels' => 'custom',
							'generate_password!'  => 'true',
						),
					)
				);
				
				$this->add_control(
					'confirm_password_placeholder',
					array(
						'label'       => __( 'Re-Enter Password Placeholder', smw_slug ),
						'default'     => __( 'Re-Enter Password', smw_slug ),
						'type'        => Controls_Manager::TEXT,
						'dynamic'     => array(
							'active' => true,
						),
						'label_block' => true,
						'condition'   => array(
							'show_labels' => 'custom',
							'generate_password!'  => 'true',
						),
					)
				);
				
				$this->add_control(
				'strength_checker',
				array(
					'label'        => __( 'Password Strength Check', smw_slug ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', smw_slug ),
					'label_off'    => __( 'Hide', smw_slug ),
					'return_value' => 'yes',
					'default'      => 'no',
					'separator'    => 'before',
					'condition'   => array(
							'generate_password!'  => 'true',
						),
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_button_controls() 
	{
		$this->start_controls_section(
			'section_button_field',
			array(
				'label' => __( 'Form Buttons', smw_slug ),
			)
		);
		
		    $this->add_control(
    			'forgot_heading',
    			[
    				'label' => __( 'Forgot Password Button', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			]
    		);

			$this->add_control(
				'forgot_button_text',
				array(
					'label'       => __( 'Text', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Reset Password', smw_slug ),
					'placeholder' => __( 'Reset Password', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$this->add_control(
				'forgot_button_size',
				array(
					'label'   => __( 'Size', smw_slug ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'sm',
					'options' => $this->get_button_sizes(),
				)
			);

			$this->add_responsive_control(
				'forgot_button_width',
				array(
					'label'   => __( 'Column Width', smw_slug ),
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
				'forgot_button_align',
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
					'default'      => 'left',
					'prefix_class' => 'elementor%s-button-align-',
				)
			);

		if ( class_exists( 'Elementor\Icons_Manager' ) ) {
			$this->add_control(
				'forgot_button_icon',
				array(
					'label'       => __( 'Icon', smw_slug ),
					'type'        => Controls_Manager::ICONS,
					'label_block' => true,
				)
			);
		} else {
			$this->add_control(
				'forgot_button_icon',
				array(
					'label'       => __( 'Icon', smw_slug ),
					'type'        => Controls_Manager::ICON,
					'label_block' => true,
				)
			);
		}

			$this->add_control(
				'forgot_button_icon_align',
				array(
					'label'     => __( 'Icon Position', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => array(
						'left'  => __( 'Before', smw_slug ),
						'right' => __( 'After', smw_slug ),
					),
					'condition' => array(
						'forgot_button_icon[value]!' => '',
					),
				)
			);

			$this->add_control(
				'forgot_button_icon_indent',
				array(
					'label'     => __( 'Icon Spacing', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'max' => 50,
						),
					),
					'condition' => array(
						'forgot_button_icon[value]!' => '',
					),
					'selectors' => array(
						'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					),
				)
			);
			
			$this->add_control(
    			'reset_heading',
    			[
    				'label' => __( 'Reset Password Button', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    				'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
    			]
    		);
			
			$this->add_control(
				'reset_button_text',
				array(
					'label'       => __( 'Text', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Reset Password', smw_slug ),
					'placeholder' => __( 'Reset Password', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
					'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
				)
			);

			$this->add_control(
				'reset_button_size',
				array(
					'label'   => __( 'Size', smw_slug ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'sm',
					'options' => $this->get_button_sizes(),
					'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
				)
			);

			$this->add_responsive_control(
				'reset_button_width',
				array(
					'label'   => __( 'Column Width', smw_slug ),
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
					'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
				)
			);

			$this->add_responsive_control(
				'reset_button_align',
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
					'default'      => 'left',
					'prefix_class' => 'elementor%s-button-align-',
					'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
				)
			);

		if ( class_exists( 'Elementor\Icons_Manager' ) ) {
			$this->add_control(
				'reset_button_icon',
				array(
					'label'       => __( 'Icon', smw_slug ),
					'type'        => Controls_Manager::ICONS,
					'label_block' => true,
					'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
				)
			);
		} else {
			$this->add_control(
				'reset_button_icon',
				array(
					'label'       => __( 'Icon', smw_slug ),
					'type'        => Controls_Manager::ICON,
					'label_block' => true,
					'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
				)
			);
		}

			$this->add_control(
				'reset_button_icon_align',
				array(
					'label'     => __( 'Icon Position', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => array(
						'left'  => __( 'Before', smw_slug ),
						'right' => __( 'After', smw_slug ),
					),
					'condition' => array(
						'reset_button_icon[value]!' => '',
						'generate_password!'  => 'true',
					),
				)
			);

			$this->add_control(
				'reset_button_icon_indent',
				array(
					'label'     => __( 'Icon Spacing', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'max' => 50,
						),
					),
					'condition' => array(
						'reset_button_icon[value]!' => '',
						'generate_password!'  => 'true',
					),
					'selectors' => array(
						'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_settings_controls() 
	{
		$this->start_controls_section(
			'section_settings_field',
			array(
				'label' => __( 'General Settings', smw_slug ),
			)
		);
		
		    $this->add_control(
    			'forgot_settings_heading',
    			[
    				'label' => __( 'Forgot Password Settings', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			]
    		);

			$this->add_control(
				'forgot_hide_form',
				array(
					'label'        => __( 'Hide Form from Logged in Users', smw_slug ),
					'description'  => __( 'Enable this option if you wish to hide the form at the frontend from logged in users.', smw_slug ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', smw_slug ),
					'label_off'    => __( 'No', smw_slug ),
					'return_value' => 'true',
					'default'      => 'false',
				)
			);

			$this->add_control(
				'forgot_logged_in_text',
				array(
					'label'       => __( 'Message For Logged In Users', smw_slug ),
					'description' => __( 'Enter the message to display at the frontend for Logged in users.', smw_slug ),
					'type'        => Controls_Manager::WYSIWYG,
					'dynamic'     => array(
						'active' => true,
					),
					'condition'   => array(
						'forgot_hide_form' => 'true',
					),
				)
			);

			$this->add_control(
				'forgot_loggedin_message_color',
				array(
					'label'     => __( 'Text Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'selectors' => array(
						'{{WRAPPER}} .smw-forgot-loggedin-message' => 'color: {{VALUE}};',
					),
					'condition' => array(
						'logged_in_text!' => '',
						'forgot_hide_form'       => 'true',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'forgot_loggedin_message_typography',
					'selector'  => '{{WRAPPER}} .smw-forgot-loggedin-message',
					'scheme'    => Typography::TYPOGRAPHY_3,
					'condition' => array(
						'logged_in_text!' => '',
						'forgot_hide_form'       => 'true',
					),
				)
			);
				
			$this->add_control(
				'generate_password',
				array(
    					'label'        => __( 'Generate Password', smw_slug ),
    					'description'  => __( 'Enable this option if you want the users to get a generated password sent to their email.', smw_slug ),
    					'type'         => Controls_Manager::SWITCHER,
    					'label_on'     => __( 'Yes', smw_slug ),
    					'label_off'    => __( 'No', smw_slug ),
    					'return_value' => 'true',
    					'default'      => 'false',
					)
				);
				
			$this->add_control(
    			'reset_settings_heading',
    			[
    				'label' => __( 'Reset Password Settings', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    				'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
    			]
    		);
    		
    		$this->add_control(
				'reset_hide_form',
				array(
					'label'        => __( 'Hide Form from Logged in Users', smw_slug ),
					'description'  => __( 'Enable this option if you wish to hide the form at the frontend from logged in users.', smw_slug ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', smw_slug ),
					'label_off'    => __( 'No', smw_slug ),
					'return_value' => 'true',
					'default'      => 'false',
					'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
				)
			);

			$this->add_control(
				'reset_logged_in_text',
				array(
					'label'       => __( 'Message For Logged In Users', smw_slug ),
					'description' => __( 'Enter the message to display at the frontend for Logged in users.', smw_slug ),
					'type'        => Controls_Manager::WYSIWYG,
					'dynamic'     => array(
						'active' => true,
					),
					'condition'   => array(
						'reset_hide_form' => 'true',
						'generate_password!'  => 'true',
					),
				)
			);

			$this->add_control(
				'reset_loggedin_message_color',
				array(
					'label'     => __( 'Text Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
					'selectors' => array(
						'{{WRAPPER}} .smw-reset-loggedin-message' => 'color: {{VALUE}};',
					),
					'condition' => array(
						'logged_in_text!' => '',
						'reset_hide_form'       => 'true',
						'generate_password!'  => 'true',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'reset_loggedin_message_typography',
					'selector'  => '{{WRAPPER}} .smw-reset-loggedin-message',
					'scheme'    => Typography::TYPOGRAPHY_3,
					'condition' => array(
						'logged_in_text!' => '',
						'reset_hide_form'       => 'true',
						'generate_password!'  => 'true',
					),
				)
			);
				
		$this->end_controls_section();
	}
	
	protected function register_validation_message_controls() 
	{
		$this->start_controls_section(
			'section_forgot_validation_fields',
			array(
				'label' => __( 'Success / Error Messages', smw_slug ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		    
		    $this->add_control(
    			'forgot_errors_heading',
    			[
    				'label' => __( 'Forgot Password Errors', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    			]
    		);

			$this->add_control(
				'forgot_validation_success_message',
				array(
					'label'       => __( 'Forgot Form Success Message', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Your password reset was sent successfully, please check your email to continue', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
					'label_block' => true,
				)
			);

			$this->add_control(
				'forgot_validation_error_message',
				array(
					'label'       => __( 'Forgot Form Error Message', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Error: Something went wrong! Unable to complete the reset password process.', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
					'label_block' => true,
				)
			);
			
			$this->add_control(
    			'reset_errors_heading',
    			[
    				'label' => __( 'Reset Password Errors', smw_slug ),
    				'type' => \Elementor\Controls_Manager::HEADING,
    				'separator' => 'before',
    				'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
    			]
    		);
			
			$this->add_control(
				'reset_validation_success_message',
				array(
					'label'       => __( 'Reset Form Success Message', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Your password was reset successfully, you can now login.', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
					'label_block' => true,
					'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
				)
			);

			$this->add_control(
				'reset_validation_error_message',
				array(
					'label'       => __( 'Reset Form Error Message', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Error: Something went wrong! Unable to change your password, please try again', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
					'label_block' => true,
					'condition'   => array(
					    'generate_password!'  => 'true',
				    ),
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

			$this->add_control(
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
						'{{WRAPPER}} .elementor-field-group:not( .elementor-field-type-submit ):not( .smw-rform-footer ):not( .smw-recaptcha-align-bottomright ):not( .smw-recaptcha-align-bottomleft )' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'label_spacing',
				array(
					'label'     => __( 'Label Bottom Spacing', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => array(
						'size' => 0,
					),
					'range'     => array(
						'px' => array(
							'min' => 0,
							'max' => 60,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .elementor-field-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
					'condition' => array(
						'show_labels!' => '',
					),
				)
			);

			$this->add_control(
				'button_spacing',
				array(
					'label'              => __( 'Button Spacing', smw_slug ),
					'type'               => Controls_Manager::DIMENSIONS,
					'default'            => array(
						'isLinked' => false,
					),
					'allowed_dimensions' => 'vertical',
					'size_units'         => array( 'px', 'em', '%' ),
					'selectors'          => array(
						'{{WRAPPER}} .smw-forgot-form-wrapper .elementor-field-group.elementor-field-type-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .smw-reset-form-wrapper .elementor-field-group.elementor-field-type-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_label_style_controls() 
    {
        $this->start_controls_section(
            'section_label_style',
            array(
                'label'     => __( 'Label', smw_slug ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_labels!' => '',
                ),
            )
        );
    
            $this->add_control(
                'label_color',
                array(
                    'label'     => __( 'Text Colour', smw_slug ),
                    'type'      => Controls_Manager::COLOR,
                    'scheme'    => array(
                        'type'  => Color::get_type(),
                        'value' => Color::COLOR_3,
                    ),
                    'selectors' => array(
                        '{{WRAPPER}} .elementor-field-group > label, {{WRAPPER}} .elementor-field-subgroup label' => 'color: {{VALUE}};',
                    ),
                )
            );
    
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'     => 'label_typography',
                    'selector' => '{{WRAPPER}} .elementor-field-group > label',
                    'scheme'   => Typography::TYPOGRAPHY_3,
                )
            );
    
        $this->end_controls_section();
    }
	
	protected function register_input_style_controls() 
	{
		$this->start_controls_section(
			'section_input_style',
			array(
				'label' => __( 'Input Fields', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_control(
				'input_style',
				array(
					'label'   => __( 'Input Style', smw_slug ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'box',
					'options' => array(
						'box'       => __( 'Box', smw_slug ),
						'underline' => __( 'Underline', smw_slug ),
					),
				)
			);

			$this->add_control(
				'field_text_color',
				array(
					'label'     => __( 'Text Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'color: {{VALUE}};',
					),
					'scheme'    => array(
						'type'  => Color::get_type(),
						'value' => Color::COLOR_3,
					),
				)
			);

			$this->add_control(
				'field_background_color',
				array(
					'label'     => __( 'Background Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => array(
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'background-color: {{VALUE}};',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'field_typography',
					'selector' => '{{WRAPPER}} .elementor-field-group .elementor-field',
					'scheme'   => Typography::TYPOGRAPHY_3,
				)
			);

			$this->add_control(
				'input_padding',
				array(
					'label'      => __( 'Padding', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->add_control(
				'field_border_color',
				array(
					'label'     => __( 'Border Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#c4c4c4',
					'selectors' => array(
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'border-color: {{VALUE}};',
					),
					'separator' => 'before',
				)
			);

			$this->add_control(
				'active_border_color',
				array(
					'label'     => __( 'Border Active Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#a5afb8',
					'selectors' => array(
						'{{WRAPPER}} .elementor-field-group .elementor-field:focus' => 'border-color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'field_border_width_box',
				array(
					'label'       => __( 'Border Width', smw_slug ),
					'type'        => Controls_Manager::DIMENSIONS,
					'placeholder' => '1',
					'selectors'   => array(
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'border-width: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					),
					'condition'   => array(
						'input_style' => 'box',
					),
				)
			);

			$this->add_responsive_control(
				'field_border_width_underline',
				array(
					'label'     => __( 'Border Width', smw_slug ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'max' => 25,
						),
					),
					'default'   => array(
						'size' => '2',
						'unit' => 'px',
					),
					'selectors' => array(
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'border-width: 0px 0px {{SIZE}}px 0px; border-style: solid; box-shadow: none;',
					),
					'condition' => array(
						'input_style' => 'underline',
					),
				)
			);

			$this->add_control(
				'field_border_radius',
				array(
					'label'      => __( 'Border Radius', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'default'    => array(
						'top'    => '2',
						'bottom' => '2',
						'left'   => '2',
						'right'  => '2',
						'unit'   => 'px',
					),
					'selectors'  => array(
						'{{WRAPPER}} .elementor-field-group .elementor-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_submit_style_controls() 
	{
		$this->start_controls_section(
			'section_submit_style',
			array(
				'label' => __( 'Button', smw_slug ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'button_typography',
					'scheme'   => Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} .elementor-button',
				)
			);

			$this->add_control(
				'button_text_padding',
				array(
					'label'      => __( 'Padding', smw_slug ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_button_style' );

				$this->start_controls_tab(
					'tab_button_normal',
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
								'{{WRAPPER}} .elementor-button svg' => 'fill: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						array(
							'name'           => 'button_background_color',
							'label'          => __( 'Background Colour', smw_slug ),
							'types'          => array( 'classic', 'gradient' ),
							'selector'       => '{{WRAPPER}} .elementor-button',
							'fields_options' => array(
								'color' => array(
									'scheme' => array(
										'type'  => Color::get_type(),
										'value' => Color::COLOR_4,
									),
								),
							),
						)
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						array(
							'name'     => 'button_border',
							'selector' => '{{WRAPPER}} .elementor-button',
						)
					);

					$this->add_control(
						'reset_button_border_radius',
						array(
							'label'      => __( 'Border Radius', smw_slug ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => array( 'px', '%' ),
							'selectors'  => array(
								'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'button_hover_color',
						array(
							'label'     => __( 'Text Colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
							),
						)
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						array(
							'name'           => 'button_background_hover_color',
							'label'          => __( 'Hover Background Colour', smw_slug ),
							'types'          => array( 'classic', 'gradient' ),
							'selector'       => '{{WRAPPER}} .elementor-button:hover',
							'fields_options' => array(
								'color' => array(
									'scheme' => array(
										'type'  => Color::get_type(),
										'value' => Color::COLOR_4,
									),
								),
							),
						)
					);

					$this->add_control(
						'button_hover_border_color',
						array(
							'label'     => __( 'Border Colour', smw_slug ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => array(
								'{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
							),
							'condition' => array(
								'button_border_border!' => '',
							),
						)
					);

					$this->add_control(
						'button_hover_animation',
						array(
							'label' => __( 'Animation', smw_slug ),
							'type'  => Controls_Manager::HOVER_ANIMATION,
						)
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

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
				'reset_field_error_success_heading',
				array(
					'label' => __( 'Reset Form Success / Error', smw_slug ),
					'type'  => Controls_Manager::HEADING,
				)
			);

				$this->add_control(
					'reset_error_message_style',
					array(
						'label'        => __( 'Message Style', smw_slug ),
						'type'         => Controls_Manager::SELECT,
						'default'      => 'default',
						'options'      => array(
							'default' => __( 'Default', smw_slug ),
							'custom'  => __( 'Custom', smw_slug ),
						),
						'prefix_class' => 'smw-reset-form-message-style-',
					)
				);
				
				$this->add_control(
    				'reset_field_error_heading',
    				array(
    					'label' => __( 'Error Message', smw_slug ),
    					'type'  => Controls_Manager::HEADING,
    					'condition' => array(
							'reset_error_message_style' => 'custom',
						),
    				)
    			);
				
				$this->add_control(
					'reset_error_message_bgcolor',
					array(
						'label'     => __( 'Message Background Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#f2dede',
						'condition' => array(
							'reset_error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-reset-message-error' => 'background-color: {{VALUE}}; padding: 0.2em 0.8em;',
						),
					)
				);

				$this->add_control(
					'reset_error_form_error_msg_color',
					array(
						'label'     => __( 'Message Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#a94442',
						'condition' => array(
							'reset_error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-reset-message-error' => 'color: {{VALUE}}',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'reset_error_message_typo',
						'scheme'   => Typography::TYPOGRAPHY_3,
						'condition' => array(
							'reset_error_message_style' => 'custom',
						),
						'selector' => '{{WRAPPER}} .smw-reset-message-error',
					)
				);
				
				$this->add_control(
    				'forgot_field_submit_heading',
    				array(
    					'label' => __( 'Success Message', smw_slug ),
    					'type'  => Controls_Manager::HEADING,
    					'condition' => array(
							'reset_error_message_style' => 'custom',
						),
    				)
    			);
    			
				$this->add_control(
					'reset_success_message_bgcolor',
					array(
						'label'     => __( 'Message Background Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#dff0d8',
						'condition' => array(
							'reset_error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-reset-message-success' => 'background-color: {{VALUE}}; padding: 0.2em 0.8em;',
						),
					)
				);
				
				$this->add_control(
					'reset_form_success_msg_color',
					array(
						'label'     => __( 'Message Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#3c763d',
						'condition' => array(
							'reset_error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-reset-message-success' => 'color: {{VALUE}}',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'reset_success_message_typo',
						'scheme'   => Typography::TYPOGRAPHY_3,
						'condition' => array(
							'reset_error_message_style' => 'custom',
						),
						'selector' => '{{WRAPPER}} .smw-reset-message-success',
					)
				);

    			$this->add_control(
    				'forgot_field_error_success_heading',
    				array(
    					'label' => __( 'Forgot Form Success / Error', smw_slug ),
    					'type'  => Controls_Manager::HEADING,
    				)
    			);

				$this->add_control(
					'forgot_error_message_style',
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
    				'forgot_field_error_heading',
    				array(
    					'label' => __( 'Error Message', smw_slug ),
    					'type'  => Controls_Manager::HEADING,
    					'condition' => array(
							'forgot_error_message_style' => 'custom',
						),
    				)
    			);
				
				$this->add_control(
					'forgot_error_message_bgcolor',
					array(
						'label'     => __( 'Message Background Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#f2dede',
						'condition' => array(
							'forgot_error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-forgot-message-error' => 'background-color: {{VALUE}}; padding: 0.2em 0.8em;',
						),
					)
				);

				$this->add_control(
					'forgot_error_msg_color',
					array(
						'label'     => __( 'Message Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#a94442',
						'condition' => array(
							'forgot_error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-forgot-message-error' => 'color: {{VALUE}}',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'forgot_error_message_typo',
						'scheme'   => Typography::TYPOGRAPHY_3,
						'condition' => array(
							'forgot_error_message_style' => 'custom',
						),
						'selector' => '{{WRAPPER}} .smw-forgot-message-error',
					)
				);
				
				$this->add_control(
    				'forgot_field_success_heading',
    				array(
    					'label' => __( 'Success Message', smw_slug ),
    					'type'  => Controls_Manager::HEADING,
    				)
    			);
				
				$this->add_control(
					'forgot_success_message_bgcolor',
					array(
						'label'     => __( 'Message Background Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#dff0d8',
						'condition' => array(
							'forgot_error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-forgot-message-success' => 'background-color: {{VALUE}}; padding: 0.2em 0.8em;',
						),
					)
				);
				
				$this->add_control(
					'forgot_success_msg_color',
					array(
						'label'     => __( 'Message Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#3c763d',
						'condition' => array(
							'forgot_error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-forgot-message-success' => 'color: {{VALUE}}',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'forgot_success_message_typo',
						'scheme'   => Typography::TYPOGRAPHY_3,
						'condition' => array(
							'forgot_error_message_style' => 'custom',
						),
						'selector' => '{{WRAPPER}} .smw-forgot-message-success',
					)
				);

		$this->end_controls_section();
	}
	
	protected function render() 
	{
	    $settings        = $this->get_settings_for_display();
		$node_id         = $this->get_id();
		$reset_redirect  = '';
		$is_editor       = \Elementor\Plugin::instance()->editor->is_edit_mode();
		$invalid_username = '';
		$session_error    = isset( $_SESSION['smw_error'] ) ? $_SESSION['smw_error'] : '';
		$session_id       = session_id();
		$action           = '';
		$key              = '';
		$username         = '';
		
		if(isset($_GET['action']) && $_GET['action'] != "")
		{
            $action = $_GET['action'];
        }
        
        if(isset($_GET['key']) && $_GET['key'] != "")
        {
            $key = $_GET['key'];
        }
        
        if(isset($_GET['login']) && $_GET['login'] != "")
        {
            $username = $_GET['login'];
        }

		if ( ! empty( $session_id ) ) 
		{
			if ( isset( $_SESSION['smw_error'] ) ) {
				if ( isset( $session_error ) ) {
					if ( 'invalid_username' === $session_error ) {
						$invalid_username = __( 'Unknown Username. Check again or try your email address.', smw_slug );
					} elseif ( 'invalid_email' === $session_error ) {
						$invalid_username = __( 'Unknown Email address. Check again or try your username.', smw_slug );
					} 
					unset( $_SESSION['smw_error'] );
				}
			}
		}
		
		$this->add_render_attribute(
            array(
                'forgot_wrapper'      => array(
                    'class' => array(
                        'smw-forgot-form-wrapper',
                        'elementor-form-fields-wrapper',
                        'elementor-labels-above',
                    ),
                ),
                'reset_wrapper'      => array(
                    'class' => array(
                        'smw-reset-form-wrapper',
                        'elementor-form-fields-wrapper',
                        'elementor-labels-above',
                    ),
                ),
                'forgot_button'       => array(
                    'class' => array(
                        'elementor-button smw-forgot-form-submit',
                        'elementor-button',
                        'elementor-size-' . $settings['forgot_button_size'],
                    ),
                    'name' => 'smw-forgot-submit',
                    'data-ajax-enable' => $settings['enable_ajax'],
                ),
                'reset_button'       => array(
                    'class' => array(
                        'elementor-button smw-reset-form-submit',
                        'elementor-button',
                        'elementor-size-' . $settings['reset_button_size'],
                    ),
                    'name' => 'smw-reset-submit',
                    'data-ajax-enable' => $settings['enable_ajax'],
                ),
                'forgot-user-input'      => array(
                    'type'        => 'text',
                    'name'        => 'username',
                    'id'          => 'user',
                    'placeholder' => wp_kses_post( $settings['user_placeholder'] ),
                    'class'       => array(
                        'elementor-field',
                        'elementor-field-textual',
                        'elementor-size-' . $settings['input_size'],
                        'smw-forgot-form-username',
                    ),
                ),
                
                'reset-password-input'      => array(
                    'type'        => 'password',
                    'name'        => 'password',
                    'id'          => 'password',
                    'placeholder' => wp_kses_post( $settings['password_placeholder'] ),
                    'class'       => array(
                        'elementor-field',
                        'elementor-field-textual',
                        'elementor-size-' . $settings['input_size'],
                        'smw-reset-form-password',
                        'elementor-field-label',
                    ),
                ),
                'confirm-password-input'      => array(
                    'type'        => 'password',
                    'name'        => 'confirm_password',
                    'id'          => 'confirm_password',
                    'placeholder' => wp_kses_post( $settings['confirm_password_placeholder'] ),
                    'class'       => array(
                        'elementor-field',
                        'elementor-field-textual',
                        'elementor-size-' . $settings['input_size'],
                        'smw-reset-form-confirm-password',
                        'elementor-field-label',
                    ),
                ),
                'user_label'      => array(
					'for'   => 'user',
					'class' => 'elementor-field-label',
				),

				'password_label'  => array(
					'for'   => 'password',
					'class' => 'elementor-field-label',
				),
				'confirm_password_label'  => array(
					'for'   => 'confirm_password',
					'class' => 'elementor-field-label',
				),
                'field-group'     => array(
                    'class' => array(
                        'elementor-field-type-text',
                        'elementor-field-group',
                        'elementor-column',
                        'elementor-col-100',
                    ),
                ),
                'forgot-submit-group' => array(
                    'class' => array(
                        'smw-forgot-form-submit',
                        'elementor-field-group',
                        'elementor-column',
                        'elementor-field-type-submit',
                        'elementor-col-' . $settings['forgot_button_width'],
                    ),
                ),
                'reset-submit-group' => array(
                    'class' => array(
                        'smw-reset-form-submit',
                        'elementor-field-group',
                        'elementor-column',
                        'elementor-field-type-submit',
                        'elementor-col-' . $settings['reset_button_width'],
                    ),
                ),
                'forgot-icon-align'   => array(
                    'class' => array(
                        empty( $settings['forgot_button_icon_align'] ) ? '' :
                            'elementor-align-icon-' . $settings['forgot_button_icon_align'],
                        'elementor-button-icon',
                    ),
                ),
                'reset-icon-align'   => array(
                    'class' => array(
                        empty( $settings['reset_button_icon_align'] ) ? '' :
                            'elementor-align-icon-' . $settings['reset_button_icon_align'],
                        'elementor-button-icon',
                    ),
                ),
                'forgot-widget-wrap'  => array(
                    'data-post-id'         => $this->get_id(),
                    'data-page-id'         => get_the_id(),
                    'data-success-message' => $settings['forgot_validation_success_message'],
                    'data-error-message'   => $settings['forgot_validation_error_message'],
                ),
                'reset-widget-wrap'  => array(
                    'data-post-id'         => $this->get_id(),
                    'data-page-id'         => get_the_id(),
                    'data-login'           => $username,
                    'data-key'             => $key,
                    'data-success-message' => $settings['reset_validation_success_message'],
                    'data-error-message'   => $settings['reset_validation_error_message'],
                ),
            )
        );
        
        if ( ! empty( $settings['forgot_button_width_tablet'] ) ) 
        {
            $this->add_render_attribute( 'forgot-submit-group', 'class', 'elementor-md-' . $settings['forgot_button_width_tablet'] );
        }elseif ( ! empty( $settings['reset_button_width_tablet'] ) ) 
        {
            $this->add_render_attribute( 'reset-submit-group', 'class', 'elementor-md-' . $settings['forgot_button_width_tablet'] );
        }
        
        if ( ! empty( $settings['forgot_button_width_mobile'] ) ) {
            $this->add_render_attribute( 'forgot-submit-group', 'class', 'elementor-sm-' . $settings['forgot_button_width_mobile'] );
        }elseif ( ! empty( $settings['reset_button_width_mobile'] ) ) {
            $this->add_render_attribute( 'reset-submit-group', 'class', 'elementor-sm-' . $settings['reset_button_width_mobile'] );
        }
        
        if ( ! empty( $settings['forgot_button_size'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['forgot_button_size'] );
        }elseif ( ! empty( $settings['reset_button_size'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['reset_button_size'] );
        }
        
        if ( ! empty( $settings['forgot_button_type'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-button-' . $settings['forgot_button_type'] );
        }elseif ( ! empty( $settings['reset_button_type'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-button-' . $settings['reset_button_type'] );
        }
        
        if ( $settings['forgot_button_hover_animation'] ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['forgot_button_hover_animation'] );
        }elseif ( $settings['reset_button_hover_animation'] ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['reset_button_hover_animation'] );
        }
        
        if ( 'none' === $settings['show_labels'] ) {
            $this->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
        }elseif ( 'none' === $settings['show_labels'] ) {
            $this->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
        }
        else
        {
            $this->add_render_attribute( 'label', 'class', 'elementor-field-label' );
        }
		
		if ( 'true' === $settings['forgot_hide_form'] && is_user_logged_in() && ! $is_editor && '' === $action ) 
		{
			?>
			<div class="smw-forgot-form">
    			<div class="smw-forgot-loggedin-message">
        			<?php
        			if ( '' !== $settings['forgot_logged_in_text'] ) 
        			{
    					echo '<span>' . wp_kses_post( $settings['forgot_logged_in_text'] ) . '</span>';
    				}
        			?>
    			</div>
    		</div>
			<?php
		}
		elseif ( 'true' === $settings['reset_hide_form'] && is_user_logged_in() && ! $is_editor && '' === $action) 
		{
			?>
			<div class="smw-reset-form">
    			<div class="smw-reset-loggedin-message">
        			<?php
        			if ( '' !== $settings['reset_logged_in_text'] ) 
        			{
    					echo '<span>' . wp_kses_post( $settings['reset_logged_in_text'] ) . '</span>';
    				}
        			?>
    			</div>
    		</div>
			<?php
		}
		elseif('forgot-password' === $settings['choose_form'] && $is_editor || 'forgot-password' === $settings['choose_form_generate'] && $is_editor)
		{
		?>
		    <div class="smw-forgot-form-wrapper" <?php echo wp_kses_post( $this->get_render_attribute_string( 'forgot-widget-wrap' ) ); ?>>
                <form class="elementor-form smw-forgot-form" method="post" <?php echo wp_kses_post( $this->get_render_attribute_string( 'form' ) ); ?>>
                    <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'field-group' ) ); ?>>                    
                    <?php
                        if ( 'custom' === $settings['show_labels'] ) 
                        {
                            echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'user_label' ) ) . '>' . wp_kses_post( $settings['user_label'] ) . '</label>';
                        } elseif ( 'default' === $settings['show_labels'] ) 
                        {
                            echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'user_label' ) ) . '>';
                            echo esc_attr__( 'Username or Email Address', smw_slug );
                            echo '</label>';
                        }
            
                        echo '<input size="1" ' . wp_kses_post( $this->get_render_attribute_string( 'forgot-user-input' ) ) . '>';
            
                        ?>
                        <?php if ( '' !== $invalid_username ) { ?>
                            <span class="smw-forgot-field-message"><span class="smw-form-error"><?php echo wp_kses_post( $invalid_username ); ?></span></span>
                        <?php } ?>
                    </div>
                    <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'forgot-submit-group' ) ); ?>>
                        <button type="submit" <?php echo wp_kses_post( $this->get_render_attribute_string( 'forgot_button' ) ); ?>>
                            <span <?php echo wp_kses_post( $this->get_render_attribute_string( 'content-wrapper' ) ); ?>>
                                <?php if ( ( ! empty( $settings['forgot_button_icon'] ) && ! class_exists( 'Elementor\Icons_Manager' ) ) || ( '' !== $settings['button_icon']['value'] && class_exists( 'Elementor\Icons_Manager' ) ) ) { ?>
                                    <span <?php echo wp_kses_post( $this->get_render_attribute_string( 'forgot-icon-align' ) ); ?>>
                                        <?php
                                        if ( $settings['forgot_button_icon']['value'] && class_exists( 'Elementor\Icons_Manager' ) ) {
                                            \Elementor\Icons_Manager::render_icon( $settings['forgot_button_icon'], array( 'aria-hidden' => 'true' ) );
                                        } elseif ( ! empty( $settings['forgot_button_icon'] ) && ! class_exists( 'Elementor\Icons_Manager' ) ) {
                                            ?>
                                            <i class="<?php echo esc_attr( $settings['forgot_button_icon'] ); ?>"></i>	
                                        <?php } ?>	
                                        <?php } ?>													
                                        <?php if ( empty( $settings['forgot_button_text'] ) ) { ?>
                                            <span class="elementor-screen-only"><?php esc_attr_e( 'Submit', smw_slug ); ?></span>
                                        <?php } ?>
                                    </span>
                                <?php if ( ! empty( $settings['forgot_button_text'] ) ) : ?>
                                    <span class="elementor-button-text smw-forgot-submit"><?php echo wp_kses_post( $settings['forgot_button_text'] ); ?></span>
                                <?php endif; ?>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        <?php
	    }
	    elseif('reset-password' === $settings['choose_form'] && $is_editor)
		{
		    ?>
            <div class="smw-reset-form-wrapper" <?php echo wp_kses_post( $this->get_render_attribute_string( 'forgot-widget-wrap' ) ); ?>>
                <form class="elementor-form smw-reset-form" method="post" <?php echo wp_kses_post( $this->get_render_attribute_string( 'form' ) ); ?>>
                    <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'field-group' ) ); ?>>                    
                    <?php
                        if ( 'custom' === $settings['show_labels'] ) 
                        {
                            echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'password_label' ) ) . '>' . wp_kses_post( $settings['password_label'] ) . '</label>';
                        } elseif ( 'default' === $settings['show_labels'] ) 
                        {
                            echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'password_label' ) ) . '>';
                            echo esc_attr__( 'New Password', smw_slug );
                            echo '</label>';
                        }

                        echo '<input size="1" ' . wp_kses_post( $this->get_render_attribute_string( 'reset-password-input' ) ) . '>';
                        
                        if ( 'custom' === $settings['show_labels'] ) 
                        {
                            echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'confirm_password_label' ) ) . '>' . wp_kses_post( $settings['confirm_password_label'] ) . '</label>';
                        } elseif ( 'default' === $settings['show_labels'] ) 
                        {
                            echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'confirm_password_label' ) ) . '>';
                            echo esc_attr__( 'Re-Enter Password', smw_slug );
                            echo '</label>';
                        }

                        echo '<input size="1" ' . wp_kses_post( $this->get_render_attribute_string( 'confirm-password-input' ) ) . '>';
                        
                        ?>
                        <?php if ( '' !== $invalid_username ) { ?>
                            <span class="smw-reset-field-message"><span class="smw-form-error"><?php echo wp_kses_post( $invalid_username ); ?></span></span>
                        <?php } ?>
                    </div>
                    <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'reset-submit-group' ) ); ?>>
                        <button type="submit" <?php echo wp_kses_post( $this->get_render_attribute_string( 'reset_button' ) ); ?>>
                            <span <?php echo wp_kses_post( $this->get_render_attribute_string( 'content-wrapper' ) ); ?>>
                                <?php if ( ( ! empty( $settings['reset_button_icon'] ) && ! class_exists( 'Elementor\Icons_Manager' ) ) || ( '' !== $settings['reset_button_icon']['value'] && class_exists( 'Elementor\Icons_Manager' ) ) ) { ?>
                                    <span <?php echo wp_kses_post( $this->get_render_attribute_string( 'reset-icon-align' ) ); ?>>
                                        <?php
                                        if ( $settings['reset_button_icon']['value'] && class_exists( 'Elementor\Icons_Manager' ) ) {
                                            \Elementor\Icons_Manager::render_icon( $settings['reset_button_icon'], array( 'aria-hidden' => 'true' ) );
                                        } elseif ( ! empty( $settings['reset_button_icon'] ) && ! class_exists( 'Elementor\Icons_Manager' ) ) {
                                            ?>
                                            <i class="<?php echo esc_attr( $settings['reset_button_icon'] ); ?>"></i>	
                                        <?php } ?>	
                                        <?php } ?>													
                                        <?php if ( empty( $settings['reset_button_text'] ) ) { ?>
                                            <span class="elementor-screen-only"><?php esc_attr_e( 'Submit', smw_slug ); ?></span>
                                        <?php } ?>
                                    </span>
                                <?php if ( ! empty( $settings['reset_button_text'] ) ) : ?>
                                    <span class="elementor-button-text smw-reset-submit"><?php echo wp_kses_post( $settings['reset_button_text'] ); ?></span>
                                <?php endif; ?>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        <?php
		}
		elseif( '' === $action && ! $is_editor )
		{
		?>
		    <div class="smw-forgot-form-wrapper" <?php echo wp_kses_post( $this->get_render_attribute_string( 'forgot-widget-wrap' ) ); ?>>
		        <div class="forgot-outcome elementor alert" style="display:none"></div>
                <form class="elementor-form smw-forgot-form" id="smw-forgot-form" method="post" <?php echo wp_kses_post( $this->get_render_attribute_string( 'form' ) ); ?>>
                    <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'field-group' ) ); ?>>                    
                    <?php
                        if ( 'custom' === $settings['show_labels'] ) 
                        {
                            echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'user_label' ) ) . '>' . wp_kses_post( $settings['user_label'] ) . '</label>';
                        } elseif ( 'default' === $settings['show_labels'] ) 
                        {
                            echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'user_label' ) ) . '>';
                            echo esc_attr__( 'Username or Email Address', smw_slug );
                            echo '</label>';
                        }
            
                        echo '<input size="1" ' . wp_kses_post( $this->get_render_attribute_string( 'forgot-user-input' ) ) . '>';
                        
                        echo '<div class="smw-email-wrapper" style="margin-top:10px;"></div>';
            
                        ?>
                        
                    </div>
                    <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'forgot-submit-group' ) ); ?>>
                        <button type="submit" <?php echo wp_kses_post( $this->get_render_attribute_string( 'forgot_button' ) ); ?>>
                            <span <?php echo wp_kses_post( $this->get_render_attribute_string( 'content-wrapper' ) ); ?>>
                                <?php if ( ( ! empty( $settings['forgot_button_icon'] ) && ! class_exists( 'Elementor\Icons_Manager' ) ) || ( '' !== $settings['button_icon']['value'] && class_exists( 'Elementor\Icons_Manager' ) ) ) { ?>
                                    <span <?php echo wp_kses_post( $this->get_render_attribute_string( 'forgot-icon-align' ) ); ?>>
                                        <?php
                                        if ( $settings['forgot_button_icon']['value'] && class_exists( 'Elementor\Icons_Manager' ) ) {
                                            \Elementor\Icons_Manager::render_icon( $settings['forgot_button_icon'], array( 'aria-hidden' => 'true' ) );
                                        } elseif ( ! empty( $settings['forgot_button_icon'] ) && ! class_exists( 'Elementor\Icons_Manager' ) ) {
                                            ?>
                                            <i class="<?php echo esc_attr( $settings['forgot_button_icon'] ); ?>"></i>	
                                        <?php } ?>	
                                        <?php } ?>													
                                        <?php if ( empty( $settings['forgot_button_text'] ) ) { ?>
                                            <span class="elementor-screen-only"><?php esc_attr_e( 'Submit', smw_slug ); ?></span>
                                        <?php } ?>
                                    </span>
                                <?php if ( ! empty( $settings['forgot_button_text'] ) ) : ?>
                                    <span class="elementor-button-text smw-forgot-submit"><?php echo wp_kses_post( $settings['forgot_button_text'] ); ?></span>
                                <?php endif; ?>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
            
            <script type="text/javascript">
    			jQuery(document).ready(function($) 
    			{
    			    //forgot password form start
    			    var forgot_form = 'form#smw-forgot-form';
    				var loading_text='<span class="loading-spinner-log"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>';
    				var notverify='<span class="loading-spinner-log"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span>';
    				var success= "";
    				var error= "";
    				var page_id = "";
    				var widget_id = "";
    				var username = "";
    				
    				$(forgot_form).on('submit', function(e)
    	            {
    	                var iserrors = false;
    	                page_id = $(".smw-forgot-form-wrapper").attr("data-page-id");
    	                widget_id = $(".smw-forgot-form-wrapper").attr("data-post-id");
    	                $('.smw-email-wrapper').hide();
    	                success = $(".smw-forgot-form-wrapper").attr("data-success-message");
    	                error = $(".smw-forgot-form-wrapper").attr("data-error-message");
    	                
    	                $('.smw-forgot-form-username').each(function()
    	                {
                            username = $(this).val();
                        });
                        
                        if(username == "")
                        {
                            $('.smw-email-wrapper').html('<span class="smw-form-error">Email cannot be blank!</span>');
                            $('.smw-email-wrapper').show();
                            iserrors = true;
                        }
                        
                        if(iserrors)
                        {
                            return false;
                        }
                        else
                        {
                            var data = {};
                            
                            data['action'] = 'smw_forgot_password';
                            data['nonce'] = smw_nonce;
                            data['username'] = username;
                            data['widget_id'] = widget_id;
                            data['page_id'] = page_id;
                            
                            $.ajax({
                                type: 'POST',
        			            dataType: 'json',
        			            url: smw_ajax_url,
        			            data: data,
    						    beforeSend: function()
        			            {							
        							
    						    },
    						    success: function(data) 
    			                {
    			                    if(data.success == false)
        			                {
        			                    if(data.data == 'invalid_username')
        			                    {
        			                        $('.smw-email-wrapper').html('<span class="smw-form-error">Username does not exist, try again!</span>');
                                            $('.smw-email-wrapper').show();
        			                    }
        			                    
        			                    $('.forgot-outcome').removeClass("smw-forgot-message-success")
        			                    $('.forgot-outcome').addClass("smw-forgot-message-error");
        			                    $('.forgot-outcome').html('<span class="smw-forgot-error">' + error + '</span>');
                                        $('.forgot-outcome').show();
        			                }
        			                else
        			                {
        			                    $('.forgot-outcome').removeClass("smw-forgot-message-error")
        			                    $('.forgot-outcome').addClass("smw-forgot-message-success");
        			                    $('.forgot-outcome').html('<span class="smw-forgot-success">' + success + '</span>');
                                        $('.forgot-outcome').show();
        			                }
    			                },
    			                error: function(data) 
        			            {
        						
        						},
        						complete: function()
        						{
        						    
        						}
                                
                            });
    	                    e.preventDefault();
                        }
    	            });
    			});
    		</script>
        <?php
	    }
	    elseif( 'rp' === $action && ! $is_editor)
		{
		    if( 'true' === $settings['generate_password'] )
		    {
		        echo '<div class="smw-reset-message-error"><span class="elementor-alert warning">The site administrator has enabled the generate password option, this form cannot be used.</span></div>';
		    }
		    else
		    {
		    ?>
    		    <div class="smw-reset-form-wrapper" <?php echo wp_kses_post( $this->get_render_attribute_string( 'reset-widget-wrap' ) ); ?>>
    		        <div class="reset-outcome elementor alert" style="display:none">hello</div>
                    <form class="elementor-form smw-reset-form" id="smw-reset-form" method="post" <?php echo wp_kses_post( $this->get_render_attribute_string( 'form' ) ); ?>>
                        <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'field-group' ) ); ?>>                    
                        <?php
                            if ( 'custom' === $settings['show_labels'] ) 
                            {
                                echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'password_label' ) ) . '>' . wp_kses_post( $settings['password_label'] ) . '</label>';
                            } elseif ( 'default' === $settings['show_labels'] ) 
                            {
                                echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'password_label' ) ) . '>';
                                echo esc_attr__( 'New Password', smw_slug );
                                echo '</label>';
                            }
                
                            echo '<input size="1" ' . wp_kses_post( $this->get_render_attribute_string( 'reset-password-input' ) ) . '>';
                            
                            if('yes' === $settings['strength_checker'])
    						{ ?>
    							<div id="pswd_info">
                                    <h4>Password must meet the following requirements:</h4>
                                    <ul>
                                        <li id="letter" class="invalid">At least <strong>one letter</strong></li>
                                        <li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
                                        <li id="number" class="invalid">At least <strong>one number</strong></li>
                                        <li id="length" class="invalid">Be at least <strong>8 characters</strong></li>
                                    </ul>
                                </div>
                            <?php }
                            
                            echo '<div class="smw-password-wrapper" style="margin-top:10px;"></div>';
    
                            ?>
                        </div>
                        <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'field-group' ) ); ?>>                    
                        <?php
                            if ( 'custom' === $settings['show_labels'] ) 
                            {
                                echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'confirm_password_label' ) ) . '>' . wp_kses_post( $settings['confirm_password_label'] ) . '</label>';
                            } elseif ( 'default' === $settings['show_labels'] ) 
                            {
                                echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'confirm_password_label' ) ) . '>';
                                echo esc_attr__( 'Re-Enter Password', smw_slug );
                                echo '</label>';
                            }
                
                            echo '<input size="1" ' . wp_kses_post( $this->get_render_attribute_string( 'confirm-password-input' ) ) . '>';
                            
                            echo '<div class="smw-confirm-pass-wrapper" style="margin-top:10px;"></div>';
                            
                            ?>
                            <?php if ( '' !== $invalid_username ) { ?>
                                <span class="smw-reset-field-message"><span class="smw-form-error"><?php echo wp_kses_post( $invalid_username ); ?></span></span>
                            <?php } ?>
                        </div>
                        <div <?php echo wp_kses_post( $this->get_render_attribute_string( 'reset-submit-group' ) ); ?>>
                            <button type="submit" <?php echo wp_kses_post( $this->get_render_attribute_string( 'reset_button' ) ); ?>>
                                <span <?php echo wp_kses_post( $this->get_render_attribute_string( 'content-wrapper' ) ); ?>>
                                    <?php if ( ( ! empty( $settings['reset_button_icon'] ) && ! class_exists( 'Elementor\Icons_Manager' ) ) || ( '' !== $settings['reset_button_icon']['value'] && class_exists( 'Elementor\Icons_Manager' ) ) ) { ?>
                                        <span <?php echo wp_kses_post( $this->get_render_attribute_string( 'reset-icon-align' ) ); ?>>
                                            <?php
                                            if ( $settings['reset_button_icon']['value'] && class_exists( 'Elementor\Icons_Manager' ) ) {
                                                \Elementor\Icons_Manager::render_icon( $settings['reset_button_icon'], array( 'aria-hidden' => 'true' ) );
                                            } elseif ( ! empty( $settings['reset_button_icon'] ) && ! class_exists( 'Elementor\Icons_Manager' ) ) {
                                                ?>
                                                <i class="<?php echo esc_attr( $settings['reset_button_icon'] ); ?>"></i>	
                                            <?php } ?>	
                                            <?php } ?>													
                                            <?php if ( empty( $settings['reset_button_text'] ) ) { ?>
                                                <span class="elementor-screen-only"><?php esc_attr_e( 'Submit', smw_slug ); ?></span>
                                            <?php } ?>
                                        </span>
                                    <?php if ( ! empty( $settings['reset_button_text'] ) ) : ?>
                                        <span class="elementor-button-text smw-reset-submit"><?php echo wp_kses_post( $settings['reset_button_text'] ); ?></span>
                                    <?php endif; ?>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
                
                <script type="text/javascript">
        			jQuery(document).ready(function($) 
        			{
        			    //reset password form start
        			    var reset_form = 'form#smw-reset-form';
        				var loading_text='<span class="loading-spinner-log"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>';
        				var notverify='<span class="loading-spinner-log"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span>';
        				var success="";
        				var error="";
        				var page_id = "";
        				var widget_id = "";
        				var password = "";
        				var confirmpass = "";
        				var key = "";
        				var username = "";
        				var action = "";
        				
        				$(reset_form).on('submit', function(e)
        	            {
        	                var iserrors = false;
        	                page_id = $(".smw-reset-form-wrapper").attr("data-page-id");
        	                widget_id = $(".smw-reset-form-wrapper").attr("data-post-id");
        	                key = $(".smw-reset-form-wrapper").attr("data-key");
                            username = $(".smw-reset-form-wrapper").attr("data-login");
                            success = $(".smw-reset-form-wrapper").attr("data-success-message");
        	                error = $(".smw-reset-form-wrapper").attr("data-error-message");
                            
        	                $('.smw-password-wrapper').hide();
        	                $('.smw-confirm-pass-wrapper').hide();
        	                
        	                $('.smw-reset-form-password').each(function()
        	                {
                                password = $(this).val();
                            });
                            
                            $('.smw-reset-form-confirm-password').each(function()
        	                {
                                confirmpass = $(this).val();
                            });
                            
                            if(password == '')
                            {
                                $('.smw-password-wrapper').html('<span class="smw-form-error">This field is required!</span>');
                                $('.smw-password-wrapper').show();
                                iserrors = true;
                            }
                            
                            if(confirmpass == '')
                            {
                                $('.smw-confirm-pass-wrapper').html('<span class="smw-form-error">This field is required!</span>');
                                $('.smw-confirm-pass-wrapper').show();
                                iserrors = true;
                            }
                            
                            if(password != confirmpass)
                            {
                                $('.smw-confirm-pass-wrapper').html('<span class="smw-form-error">Password\'s do not match!</span>');
                                $('.smw-confirm-pass-wrapper').show();
                                iserrors = true;
                            }
                            
                            if(key == '' || username == '')
                            {
                                iserrors = true;
                            }
                            
                            if(iserrors)
                            {
                                return false;
                            }
                            else
                            {
                                var data = {};
                                
                                data['action'] = 'smw_reset_password';
                                data['nonce'] = smw_nonce;
                                data['username'] = username;
                                data['password'] = password;
                                data['widget_id'] = widget_id;
                                data['page_id'] = page_id;
                                data['key'] = key;
                                
                                $.ajax({
                                    type: 'POST',
            			            dataType: 'json',
            			            url: smw_ajax_url,
            			            data: data,
            			            beforeSend: function()
            			            {							
            							
        						    },
        						    success: function(data) 
        			                {
        			                    if(data.success == false)
        			                    {
        			                        $('.reset-outcome').removeClass("smw-reset-message-success")
        			                        $('.reset-outcome').addClass("smw-reset-message-error");
        			                        $('.reset-outcome').html('<span class="smw-reset-error">' + error + '</span>');
                                            $('.reset-outcome').show();
        			                    }
        			                    else
        			                    {
        			                        $('.reset-outcome').removeClass("smw-reset-message-error")
        			                        $('.reset-outcome').addClass("smw-reset-message-success");
        			                        $('.reset-outcome').html('<span class="smw-reset-success">' + success + '</span>');
                                            $('.reset-outcome').show();
        			                    }
        			                    
        			                },
        			                error: function(data) 
            			            {
            						
            						},
            						complete: function()
            						{
            						    
            						}
                                });
                                
                                e.preventDefault();
                            }
        	                
        	            });
        			});
        		</script>
        		
        		<?php if('yes' === $settings['strength_checker'])
    			{ ?>
                	<script type="text/javascript">
                		jQuery(document).ready(function($) 
                		{
                		    var lengthvalid = false;
                		    var lettervalid = false;
                		    var capitalvalid = false;
                		    var numbervalid = false;
                		    
            				$(".smw-reset-form-password").keyup(function() 
            				{
                                $('.smw-reset-form-submit').prop('disabled', true);					
                                var pswd = $(this).val();
            					if ( pswd.length < 8 ) 
            					{
                                    $('#length').removeClass('valid').addClass('invalid');
                                    lengthvalid = false;
                                } else {
                                    $('#length').removeClass('invalid').addClass('valid');
                                    lengthvalid = true;
                                }
                                //validate letter
                                if ( pswd.match(/[A-z]/) ) {
                                    $('#letter').removeClass('invalid').addClass('valid');
                                    lettervalid = true;
                                } else {
                                    $('#letter').removeClass('valid').addClass('invalid');
                                    lettervalid = false;
                                }
                                //validate capital letter
                                if ( pswd.match(/[A-Z]/) ) {
                                    $('#capital').removeClass('invalid').addClass('valid');
                                    capitalvalid = true;
                                } else {
                                    $('#capital').removeClass('valid').addClass('invalid');
                                    capitalvalid = false;
                                }
                                //validate number
                                if ( pswd.match(/\d/) ) {
                                    $('#number').removeClass('invalid').addClass('valid');
                                    numbervalid = true;
                                } else {
                                    $('#number').removeClass('valid').addClass('invalid');
                                    numbervalid = false;
                                }
                                
                                if(Boolean(lengthvalid && numbervalid && capitalvalid && lettervalid))
                                {
                                    $('.smw-reset-form-submit').prop('disabled', false);					
                                }
            
            				}).focus(function() 
            				{
                                $('#pswd_info').show();
                            }).blur(function() 
                            {
                                $('#pswd_info').hide();
                            });
                		});
            		</script>
    	        <?php }
		    }
		}
	}
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_reset_password() );