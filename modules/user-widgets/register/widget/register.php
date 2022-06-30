<?php

/**
 * SMW Register Form.
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

class stiles_register extends Widget_Base
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);

        wp_register_style( 'register-css', plugin_dir_url( __FILE__ ) . '../css/register.css');
    }
    
    public function get_name()
    {
        return 'stiles-register';
    }
    
    public function get_title()
    {
        return 'Register';
    }
    
    public function get_icon()
    {
        return 'eicon-site-identity';
    }
    
    public function get_categories()
    {
        return ['stiles-media-users'];
    }
    
    public function get_style_depends() 
    {
        return [ 'register-css' ];
    }
    
    public static function get_button_sizes() 
    {
		return Widget_Button::get_button_sizes();
	}
    
    /**
	 * Get array of fields type.
	 *
	 * @since 1.18.0
	 * @access protected
	 * @return array fields.
	 */
	 protected function get_field_type() 
	 {
		$fields = array(
			'user_name'    => __( 'Username', smw_slug ),
			'email'        => __( 'Email', smw_slug ),
			'password'     => __( 'Password', smw_slug ),
			'confirm_pass' => __( 'Confirm Password', smw_slug ),
			'first_name'   => __( 'First Name', smw_slug ),
			'last_name'    => __( 'Last Name', smw_slug ),
			'honeypot'     => __( 'Honeypot', smw_slug ),
			//'recaptcha_v3' => __( 'reCAPTCHA v3', smw_slug ),
		);

		$fields = apply_filters( 'smw_registration_form_fields', $fields );

		return $fields;
	}
	
	/**
	 * Retrieve User Roles.
	 *
	 * @since 1.18.0
	 * @access public
	 *
	 * @return array User Roles.
	 */
	public static function get_user_roles() 
	{
		global $wp_roles;

		if ( ! class_exists( 'WP_Roles' ) ) {
			return;
		}

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = get_editable_roles();
		}

		$roles      = isset( $wp_roles->roles ) ? $wp_roles->roles : array();
		$user_roles = array();

		$user_roles['default'] = __( 'Default', smw_slug );

		foreach ( $roles as $role_key => $role ) {
			$user_roles[ $role_key ] = $role['name'];
		}

		return apply_filters( 'smw_user_default_roles', $user_roles );
	}
	
	protected function register_controls() 
	{ 
	   // $this->register_scripts();
	   
		$this->register_general_controls();
		
		$this->register_button_controls();
		
		$this->register_settings_controls();
		
		$this->register_action_after_submit_controls();
		
		$this->register_email_controls();
		
		$this->register_validation_message_controls();
		
		$this->register_spacing_controls();
		
		$this->register_label_style_controls();
		
		$this->register_input_style_controls();
		
		$this->register_submit_style_controls();
		
		$this->register_error_style_controls();
	}
	
	public function register_scripts()
	{
	    wp_register_script( 'register-js', smw_url . 'modules/register/js/stiles-register.js', [ 'elementor-frontend' ], smw_ver, true );
	    
	    wp_localize_script(
    		'register-js',
    		'stiles-register',
    		array(
    			'invalid_mail'       => __( 'Enter valid Email!', smw_slug ),
    			'admin_url'          => admin_url( 'admin-ajax.php' ),
    			'pass_unmatch'       => __( 'The specified password do not match!', smw_slug ),
    			'required'           => __( 'This Field is required!', smw_slug ),
    			'form_nonce'         => wp_create_nonce( 'smw-nonce' ),
    			'incorrect_password' => __( 'Error: The Password you have entered is incorrect.', smw_slug ),
    			'invalid_username'   => __( 'Unknown username or Password. Check again or try your email address.', 'smw' ),
    			'invalid_email'      => __( 'Unknown email address or Password. Check again or try your username.', smw_slug ),
    			'ajaxUrl'                 => admin_url( 'admin-ajax.php' ),
    			'search_str'          => __( 'Search:', smw_slug ),
    			'table_not_found_str' => __( 'No matching records found', smw_slug ),
    			'table_length_string' => __( 'Show _MENU_ Entries', smw_slug ),
    		)
    	);
    }
    
    public function get_script_depends() 
	{
        return [ 'register-js' ];
    }
	
	protected function register_general_controls() 
    {
		$this->start_controls_section(
			'section_general_field',
			array(
				'label' => __( 'Form Fields', smw_slug ),
			)
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'field_type',
				array(
					'label'   => __( 'Type', smw_slug ),
					'type'    => Controls_Manager::SELECT,
					'options' => $this->get_field_type(),
					'default' => 'first_name',
				)
			);

			$repeater->add_control(
				'field_label',
				array(
					'label'   => __( 'Label', smw_slug ),
					'type'    => Controls_Manager::TEXT,
					'default' => '',
					'dynamic' => array(
						'active' => true,
					),
				)
			);

			$repeater->add_control(
				'placeholder',
				array(
					'label'     => __( 'Placeholder', smw_slug ),
					'type'      => Controls_Manager::TEXT,
					'default'   => '',
					'dynamic'   => array(
						'active' => true,
					),
					'condition' => array(
						'field_type!' => array( 'honeypot', 'recaptcha_v3' ),
					),
				)
			);

			$repeater->add_control(
				'required',
				array(
					'label'        => __( 'Required', smw_slug ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'true',
					'default'      => '',
					'condition'    => array(
						'field_type!' => array( 'email', 'password', 'honeypot', 'recaptcha_v3' ),
					),
				)
			);

			$repeater->add_control(
				'required_note',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( 'Note: This field is required by default.', smw_slug ),
					'condition'       => array(
						'field_type' => array( 'email', 'password' ),
					),
					'content_classes' => 'smw-editor-doc',
				)
			);

			$repeater->add_responsive_control(
				'width',
				array(
					'label'     => __( 'Column Width', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
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
					'default'   => '100',
					'condition' => array(
						'field_type!' => array( 'honeypot', 'recaptcha_v3' ),
					),
				)
			);

			$repeater->add_control(
				'recaptcha_badge',
				array(
					'label'     => __( 'Badge Position', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'bottomright',
					'options'   => array(
						'bottomright' => __( 'Bottom Right', smw_slug ),
						'bottomleft'  => __( 'Bottom Left', smw_slug ),
						'inline'      => __( 'Inline', smw_slug ),
					),
					'condition' => array(
						'field_type' => 'recaptcha_v3',
					),
				)
			);

		//if ( ( ! isset( $integration_options['recaptcha_v3_key'] ) || '' === $integration_options['recaptcha_v3_key'] ) && ( ! isset( $integration_options['recaptcha_v3_secretkey'] ) || '' === $integration_options['recaptcha_v3_secretkey'] ) ) {
		//	$repeater->add_control(
				//'recaptcha_setting',
				//array(
				//	'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s admin link */
				//		'raw'         => sprintf( __( 'Please configure reCAPTCHA v3 setup from <a href="%s" target="_blank" rel="noopener">here</a>.', 'uael' ), $admin_link ),
				//	'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				//	'condition'       => array(
				//		'field_type' => 'recaptcha_v3',
				//	),
			//	)
			//);
		//}

			$this->add_control(
				'fields_list',
				array(
					'type'        => Controls_Manager::REPEATER,
					'fields'      => array_values( $repeater->get_controls() ),
					'default'     => array(
						array(
							'field_type'  => 'user_name',
							'field_label' => __( 'Username', smw_slug ),
							'placeholder' => __( 'Username', smw_slug ),
							'width'       => '100',
						),
						array(
							'field_type'  => 'email',
							'field_label' => __( 'Email', smw_slug ),
							'placeholder' => __( 'Email', smw_slug ),
							'required'    => 'true',
							'width'       => '100',
						),
						array(
							'field_type'  => 'password',
							'field_label' => __( 'Password', smw_slug ),
							'placeholder' => __( 'Password', smw_slug ),
							'required'    => 'true',
							'width'       => '100',
						),
					),
					'title_field' => '{{{ field_label }}}',
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
					'label'        => __( 'Label', smw_slug ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', smw_slug ),
					'label_off'    => __( 'Hide', smw_slug ),
					'return_value' => 'true',
					'default'      => 'true',
				)
			);

			$this->add_control(
				'mark_required',
				array(
					'label'     => __( 'Required Mark', smw_slug ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Show', smw_slug ),
					'label_off' => __( 'Hide', smw_slug ),
					'default'   => '',
					'condition' => array(
						'show_labels!' => '',
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
				'label' => __( 'Register Button', smw_slug ),
			)
		);

			$this->add_control(
				'button_text',
				array(
					'label'       => __( 'Text', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Register', smw_slug ),
					'placeholder' => __( 'Register', smw_slug ),
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
					'default'      => 'left',
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
	
	protected function register_settings_controls() {

		$this->start_controls_section(
			'section_settings_field',
			array(
				'label' => __( 'General Settings', smw_slug ),
			)
		);

			$this->add_control(
				'hide_form',
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
				'logged_in_text',
				array(
					'label'       => __( 'Message For Logged In Users', smw_slug ),
					'description' => __( 'Enter the message to display at the frontend for Logged in users.', smw_slug ),
					'type'        => Controls_Manager::WYSIWYG,
					'dynamic'     => array(
						'active' => true,
					),
					'condition'   => array(
						'hide_form' => 'true',
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
						'{{WRAPPER}} .smw-registration-loggedin-message' => 'color: {{VALUE}};',
					),
					'condition' => array(
						'logged_in_text!' => '',
						'hide_form'       => 'true',
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'loggedin_message_typography',
					'selector'  => '{{WRAPPER}} .smw-registration-loggedin-message',
					'scheme'    => Typography::TYPOGRAPHY_3,
					'condition' => array(
						'logged_in_text!' => '',
						'hide_form'       => 'true',
					),
				)
			);

			$this->add_control(
				'select_role',
				array(
					'label'     => __( 'New User Role', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'default',
					'options'   => $this->get_user_roles(),
					'separator' => 'before',
				)
			);

			$this->add_control(
				'default_role_note',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( 'The default option will assign the user role as per the WordPress backend setting.', smw_slug ),
					'content_classes' => 'smw-editor-doc',
					'condition'       => array(
						'select_role' => 'default',
					),
				)
			);

			$this->add_control(
				'login',
				array(
					'label'        => __( 'Login', smw_slug ),
					'description'  => __( 'Add the “Login” link below the register button.', smw_slug ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', smw_slug ),
					'label_off'    => __( 'No', smw_slug ),
					'return_value' => 'true',
					'default'      => 'no',
					'separator'    => 'before',
				)
			);

			$this->add_control(
				'login_text',
				array(
					'label'       => __( 'Text', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Login', smw_slug ),
					'placeholder' => __( 'Login', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
					'condition'   => array(
						'login' => 'true',
					),
				)
			);

			$this->add_control(
				'login_select',
				array(
					'label'     => __( 'Link to', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'default' => __( 'Default WordPress Page', smw_slug ),
						'custom'  => __( 'Custom URL', smw_slug ),
					),
					'default'   => 'default',
					'condition' => array(
						'login' => 'true',
					),
				)
			);

			$this->add_control(
				'login_url',
				array(
					'label'     => __( 'Enter URL', smw_slug ),
					'type'      => Controls_Manager::URL,
					'dynamic'   => array(
						'active' => true,
					),
					'condition' => array(
						'login_select' => 'custom',
						'login'        => 'true',
					),
				)
			);

			$this->add_control(
				'lost_password',
				array(
					'label'        => __( 'Lost Your Password', smw_slug ),
					'description'  => __( 'Add the "Lost Password" link below the register button', smw_slug ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', smw_slug ),
					'label_off'    => __( 'No', smw_slug ),
					'return_value' => 'true',
					'default'      => 'no',
					'separator'    => 'before',
				)
			);

			$this->add_control(
				'lost_password_text',
				array(
					'label'       => __( 'Text', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Lost Your Password?', smw_slug ),
					'placeholder' => __( 'Lost Your Password?', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
					'condition'   => array(
						'lost_password' => 'true',
					),
				)
			);

			$this->add_control(
				'lost_password_select',
				array(
					'label'     => __( 'Link to', smw_slug ),
					'type'      => Controls_Manager::SELECT,
					'options'   => array(
						'default' => __( 'Default WordPress Page', smw_slug ),
						'custom'  => __( 'Custom URL', smw_slug ),
					),
					'default'   => 'default',
					'condition' => array(
						'lost_password' => 'true',
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
						'lost_password'        => 'true',
					),
				)
			);

			$this->add_responsive_control(
				'footer_text_align',
				array(
					'label'      => __( 'Alignment', smw_slug ),
					'type'       => Controls_Manager::CHOOSE,
					'options'    => array(
						'left'   => array(
							'title' => __( 'Left', smw_slug ),
							'icon'  => 'eicon-text-align-left',
						),
						'center' => array(
							'title' => __( 'Center', smw_slug ),
							'icon'  => 'eicon-text-align-center',
						),
						'right'  => array(
							'title' => __( 'Right', smw_slug ),
							'icon'  => 'eicon-text-align-right',
						),
					),
					'separator'  => 'before',
					'default'    => 'left',
					'selectors'  => array(
						'{{WRAPPER}} .smw-rform-footer' => 'text-align: {{VALUE}};',
					),
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'lost_password',
								'operator' => '==',
								'value'    => 'true',
							),
							array(
								'name'     => 'login',
								'operator' => '==',
								'value'    => 'true',
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
						'{{WRAPPER}} .smw-rform-footer, {{WRAPPER}} .smw-rform-footer a' => 'color: {{VALUE}};',
					),
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'lost_password',
								'operator' => '==',
								'value'    => 'true',
							),
							array(
								'name'     => 'login',
								'operator' => '==',
								'value'    => 'true',
							),
						),
					),
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'       => 'footer_text_typography',
					'selector'   => '{{WRAPPER}} .smw-rform-footer',
					'scheme'     => Typography::TYPOGRAPHY_4,
					'conditions' => array(
						'relation' => 'or',
						'terms'    => array(
							array(
								'name'     => 'lost_password',
								'operator' => '==',
								'value'    => 'true',
							),
							array(
								'name'     => 'login',
								'operator' => '==',
								'value'    => 'true',
							),
						),
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
						'{{WRAPPER}} .smw-rform-footer a.smw-rform-footer-link:not(:last-child):after' => 'content: "{{VALUE}}"; margin: 0 0.2em;',
					),
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'lost_password',
								'operator' => '==',
								'value'    => 'true',
							),
							array(
								'name'     => 'login',
								'operator' => '==',
								'value'    => 'true',
							),
						),
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
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_action_after_submit_controls() 
    {
		$this->start_controls_section(
			'section_action_after_submit_field',
			array(
				'label' => __( 'After Register Actions', smw_slug ),
			)
		);

			$this->add_control(
				'actions_array',
				array(
					'label'       => __( 'Add Action', smw_slug ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'default'     => 'send_email',
					'options'     => array(
						'redirect'   => __( 'Redirect', smw_slug ),
						'auto_login' => __( 'Auto Login', smw_slug ),
						'send_email' => __( 'Send Email', smw_slug ),
					),
				)
			);

			$this->add_control(
				'redirect_url',
				array(
					'label'     => __( 'Redirect URL', smw_slug ),
					'type'      => Controls_Manager::URL,
					'dynamic'   => array(
						'active' => true,
					),
					'condition' => array(
						'actions_array' => 'redirect',
					),
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_email_controls() {

		$this->start_controls_section(
			'section_email_fields',
			array(
				'label'     => __( 'Email', smw_slug ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'actions_array' => 'send_email',
				),
			)
		);

			$this->add_control(
				'email_template',
				array(
					'label'   => __( 'Email Template', smw_slug ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => array(
						'default' => __( 'Default', 'smw' ),
						'custom'  => __( 'Custom', 'smw' ),
					),
				)
			);

			$this->add_control(
				'email_imp_custom',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( '<b>Important Notice:</b> If you have only an Email field in the form, then please select the Custom option in the Email Template field above.', smw_slug ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
					'condition'       => array(
						'email_template' => 'default',
					),
				)
			);

			$site_title = get_option( 'blogname' );
			$login_url  = site_url() . '/wp-admin';

			/* translators: %s: Site title. */
			$default_message = sprintf( __( 'Thank you for registering with "%s"!', smw_slug ), $site_title );

			$this->add_control(
				'email_subject',
				array(
					'label'       => __( 'Subject', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					/* translators: %s: Subject */
					'placeholder' => $default_message,
					'default'     => $default_message,
					'label_block' => true,
					'render_type' => 'none',
					'condition'   => array(
						'email_template' => 'custom',
					),
				)
			);

			$this->add_control(
				'email_content',
				array(
					'label'       => __( 'Message', smw_slug ),
					'type'        => Controls_Manager::WYSIWYG,
					'placeholder' => __( 'Enter the Email Content', 'smw' ),
					/* translators: %s: Message. */
					'default'     => sprintf( __( 'Dear User,<br/>You have successfully created your "%1$s" account. Thank you for registering with us! <br/>Get the most of our service benefits with your registered account. <br/>Please click the link below to access your account.<br/>%2$s <br/>And here\'s the password [field=password] to log in to the account. <br/><br/>Regards, <br/>Team ___', smw_slug ), $site_title, $login_url ),
					'label_block' => true,
					'render_type' => 'none',
					'condition'   => array(
						'email_template' => 'custom',
					),
				)
			);

			$this->add_control(
				'email_content_note',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( '<b>Note:</b> If you wish to send a System Generated Password in the email content, use shortcode - <b>[field=password]</b>', smw_slug ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition'       => array(
						'email_template' => 'custom',
					),
				)
			);

			$this->add_control(
				'email_content_type',
				array(
					'label'       => __( 'Send As', smw_slug ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'html',
					'render_type' => 'none',
					'options'     => array(
						'html'  => __( 'HTML', smw_slug ),
						'plain' => __( 'Plain', smw_slug ),
					),
					'condition'   => array(
						'email_template' => 'custom',
					),
				)
			);

		$this->end_controls_section();
	}
	
	protected function register_validation_message_controls() 
	{
		$this->start_controls_section(
			'section_validation_fields',
			array(
				'label' => __( 'Success / Error Messages', smw_slug ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'validation_success_message',
				array(
					'label'       => __( 'Success Message', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Thank you for registering with us!', smw_slug ),
					'dynamic'     => array(
						'active' => true,
					),
					'label_block' => true,
				)
			);

			$this->add_control(
				'validation_error_message',
				array(
					'label'       => __( 'Error Message', smw_slug ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Error: Something went wrong! Unable to complete the registration process.', smw_slug ),
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
						'{{WRAPPER}} .elementor-field-group:not( .elementor-field-type-submit ):not( .smw-rform-footer ):not( .smw-recaptcha-align-bottomright ):not( .smw-recaptcha-align-bottomleft )' => 'margin-top: {{SIZE}}{{UNIT}};',
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
						'body.rtl {{WRAPPER}} .elementor-labels-inline .elementor-field-group > label' => 'padding-left: {{SIZE}}{{UNIT}};',
						// for the label position = inline option.
						'body:not(.rtl) {{WRAPPER}} .elementor-labels-inline .elementor-field-group > label' => 'padding-right: {{SIZE}}{{UNIT}};',
						// for the label position = inline option.
						'body {{WRAPPER}} .elementor-labels-above .elementor-field-group > label' => 'padding-bottom: {{SIZE}}{{UNIT}};',
						// for the label position = above option.
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
						'{{WRAPPER}} .smw-reg-form-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

			$this->add_control(
				'mark_required_color',
				array(
					'label'     => __( 'Required Mark Colour', smw_slug ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .elementor-mark-required .elementor-field-label:after' => 'color: {{COLOR}};',
					),
					'condition' => array(
						'mark_required' => 'yes',
					),
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
	
	protected function register_submit_style_controls() {
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
				'field_error_heading',
				array(
					'label' => __( 'Error Field Validation', smw_slug ),
					'type'  => Controls_Manager::HEADING,
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
						'prefix_class' => 'smw-form-message-style-',
					)
				);

				// Validation Message color.
				$this->add_control(
					'error_message_highlight_color',
					array(
						'label'     => __( 'Message Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'condition' => array(
							'error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-register-error' => 'color: {{VALUE}};',
						),
					)
				);

				$this->add_control(
					'error_message_bgcolor',
					array(
						'label'     => __( 'Message Background Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => 'rgba(255, 0, 0, 0.6)',
						'condition' => array(
							'error_message_style' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-register-error' => 'background-color: {{VALUE}}; padding: 0.2em 0.8em;',
						),
					)
				);

				$this->add_control(
					'error_form_error_msg_color',
					array(
						'label'     => __( 'Message Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ff0000',
						'condition' => array(
							'error_message_style!' => 'custom',
						),
						'selectors' => array(
							'{{WRAPPER}} .smw-register-error' => 'color: {{VALUE}}',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'error_message_typo',
						'scheme'   => Typography::TYPOGRAPHY_3,
						'selector' => '{{WRAPPER}} .smw-register-error',
					)
				);

				$this->add_control(
					'success_message',
					array(
						'label'     => __( 'Form Success & Error Messages', smw_slug ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					)
				);

				$this->add_control(
					'preview_message',
					array(
						'label'        => __( 'Preview Messages', smw_slug ),
						'type'         => Controls_Manager::SWITCHER,
						'return_value' => 'yes',
						'default'      => 'no',
					)
				);

				$this->add_control(
					'message_wrap_style',
					array(
						'label'   => __( 'Message Style', smw_slug ),
						'type'    => Controls_Manager::SELECT,
						'default' => 'default',
						'options' => array(
							'default' => __( 'Default', smw_slug ),
							'custom'  => __( 'Custom', smw_slug ),
						),
					)
				);

				$this->add_control(
					'success_message_color',
					array(
						'label'     => __( 'Success Message Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#008000',
						'selectors' => array(
							'{{WRAPPER}} .smw-registration-message.success,{{WRAPPER}} .smw-reg-preview-message.success' => 'color: {{VALUE}};',
						),
						'condition' => array(
							'message_wrap_style' => 'custom',
						),
					)
				);

				$this->add_control(
					'error_message_color',
					array(
						'label'     => __( 'Error Message Colour', smw_slug ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#d9534f',
						'selectors' => array(
							'{{WRAPPER}} .smw-registration-message.error,{{WRAPPER}} .smw-reg-preview-message.error' => 'color: {{VALUE}};',
						),
						'condition' => array(
							'message_wrap_style' => 'custom',
						),
					)
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					array(
						'name'     => 'message_validation_typo',
						'scheme'   => Typography::TYPOGRAPHY_3,
						'selector' => '{{WRAPPER}} .smw-registration-message, {{WRAPPER}} .smw-reg-preview-message',
					)
				);

		$this->end_controls_section();
	}
	
	protected function render() 
	{
		$settings               = $this->get_settings_for_display();
		$node_id                = $this->get_id();
		$is_pass_valid          = false;
		$is_confirm_pass        = false;
		$is_editor              = \Elementor\Plugin::instance()->editor->is_edit_mode();
		$is_email_exists        = 0;
		$is_user_name_exists    = 0;
		$is_password_exists     = 0;
		$is_confirm_pass_exists = 0;
		$is_first_name_exists   = 0;
		$is_last_name_exists    = 0;
		$page_id                = '';
		//$is_recaptcha_v3_exists = 0;
		//$is_honeypot_exists     = 0;

		//$integration_settings = UAEL_Helper::get_integrations_options();
		//$sitekey              = $integration_settings['recaptcha_v3_key'];
		//$secretkey            = $integration_settings['recaptcha_v3_secretkey'];

		if ( 'true' === $settings['hide_form'] && is_user_logged_in() && ! $is_editor ) {
			$current_user = wp_get_current_user();
			?>
			<div class="smw-registration-form">
				<div class="smw-registration-loggedin-message">
					<?php
					if ( '' !== $settings['logged_in_text'] ) {
						echo '<span>' . wp_kses_post( $settings['logged_in_text'] ) . '</span>';
					}
					?>
				</div>
			</div>
			<?php
		} elseif( is_user_logged_in() && ! $is_editor && ! current_user_can('administrator') ) {
		    echo '<div class="elementor-alert elementor-alert-warning">';
			echo esc_attr__( 'You cannot use this registration form while logged in', dvsa_slug );
			echo '</div>';
		}
		else {
		    
		    if ( null !== \Elementor\Plugin::$instance->documents->get_current() ) {
				$page_id = \Elementor\Plugin::$instance->documents->get_current()->get_main_id();
			}

			if ( ! empty( $settings['fields_list'] ) ) :

				$this->add_render_attribute(
					array(
						'wrapper'      => array(
							'class' => array(
								'smw-registration-form-wrapper',
								'elementor-form-fields-wrapper',
								'elementor-labels-above',
							),
						),
						'button'       => array(
                            'class' => array(
                                'elementor-button smw-register-form-submit',
                                'elementor-button',
                            ),
                            'name' => 'smw-register-submit',
                        ),
						'submit-group' => array(
							'class' => array(
								'smw-reg-form-submit',
								'elementor-field-group',
								'elementor-column',
								'elementor-field-type-submit',
								'elementor-col-' . $settings['button_width'],
							),
						),
						'icon-align'   => array(
							'class' => array(
								empty( $settings['button_icon_align'] ) ? '' :
									'elementor-align-icon-' . $settings['button_icon_align'],
								'elementor-button-icon',
							),
						),
						'widget-wrap'  => array(
							'data-page-id'         => $page_id,
							'data-success-message' => $settings['validation_success_message'],
							'data-error-message'   => $settings['validation_error_message'],
							'data-strength-check'  => $settings['strength_checker'],
						),
					)
				);

				if ( ! empty( $settings['button_width_tablet'] ) ) {
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

				if ( 'true' === $settings['hide_form'] ) {
					$this->add_render_attribute( 'widget-wrap', 'data-hide_form', 'yes' );
				}

				$actions_arr = array();
				$notify_mail = 'admin';

				if ( ! empty( $settings['actions_array'] ) ) {

					if ( is_array( $settings['actions_array'] ) ) {
						foreach ( $settings['actions_array'] as $action ) {
							if ( 'send_email' === $action ) {
								$notify_mail = 'both';
							} elseif ( 'redirect' === $action ) {
								if ( ! empty( $settings['redirect_url']['url'] ) ) {
									$this->add_render_attribute( 'widget-wrap', 'data-redirect-url', $settings['redirect_url']['url'] );
									$this->add_render_attribute( 'widget-wrap', 'redirect', 'yes' );
								}
							} else {
								$this->add_render_attribute(
									'widget-wrap',
									array(
										'data-' . $action => 'yes',
									)
								);
							}
						}
					} else {
						if ( 'send_email' === $settings['actions_array'] ) {
							$notify_mail = 'both';
						} elseif ( 'redirect' === $settings['actions_array'] ) {
							if ( ! empty( $settings['redirect_url']['url'] ) ) {
								$this->add_render_attribute( 'widget-wrap', 'data-redirect-url', $settings['redirect_url']['url'] );
							}
						} else {
							$this->add_render_attribute(
								'widget-wrap',
								array(
									'data-' . $settings['actions_array'] => 'yes',
								)
							);
						}
					}
				}

				$notify_mail = apply_filters( 'smw_registration_notify_email', $notify_mail, $settings );

				$this->add_render_attribute( 'widget-wrap', 'data-send_email', $notify_mail );

				ob_start();
				?>
					<div class="smw-registration-form-wrapper" <?php echo wp_kses_post( $this->get_render_attribute_string( 'widget-wrap' ) ); ?>>
					   <form class="elementor-form smw-register-form" id="smw-register-form" method="post" <?php echo wp_kses_post( $this->get_render_attribute_string( 'form' ) ); ?>>
							<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
								<?php
								foreach ( $settings['fields_list'] as $item_index => $item ) :

									$field_type = $item['field_type'];
									if ( 'user_name' === $field_type || 'first_name' === $field_type || 'last_name' === $field_type ) {
										$field_input_type = 'text';
									} elseif ( 'confirm_pass' === $field_type ) {
										$field_input_type = 'password';
										$is_confirm_pass  = true;
									} else {
										if ( 'password' === $field_type ) {
											$is_pass_valid = true;
										}
										$field_input_type = $field_type;
									}

									${ 'is_' . $field_type . '_exists' }++;

									$this->add_render_attribute( 'input' . $item_index, 'type', $field_input_type );

									$this->add_render_attribute(
										array(
											'input' . $item_index => array(
												'name'  => $field_type,
												'placeholder' => $item['placeholder'],
												'class' => array(
													'elementor-field',
													'elementor-size-' . $settings['input_size'],
													'form-field-' . $field_type,
													'smw-field-' . $field_type
												),
											),
											'label' . $item_index => array(
												'for'   => 'form-field-' . $field_type,
												'class' => 'elementor-field-label',
											),
										)
									);

									if ( ! $settings['show_labels'] ) {
										$this->add_render_attribute( 'label' . $item_index, 'class', 'elementor-screen-only' );
									}

									if ( ! empty( $item['required'] ) || 'email' === $field_type || 'password' === $field_type ) {

										$required_class = 'elementor-field-required';
										if ( ! empty( $settings['mark_required'] ) ) {
											$required_class .= ' elementor-mark-required';
										}
										$this->add_render_attribute( 'field-group' . $item_index, 'class', $required_class );

										$this->add_render_attribute( 'input' . $item_index, 'required', 'required' );
										$this->add_render_attribute( 'input' . $item_index, 'aria-required', 'true' );
									}

									$this->add_render_attribute(
										array(
											'field-group' . $item_index => array(
												'class' => array(
													'elementor-field-group',
													'smw-field-group',
													'smw-field-type-' . $field_type,
													'elementor-field-type-' . $field_type,
													'elementor-column',
													'elementor-col-' . $item['width'],
												),
											),
										)
									);

									//if ( 'recaptcha_v3' === $field_type ) {
									//	$this->add_render_attribute( 'field-group' . $item_index, 'class', 'smw-recaptcha-align-' . $item['recaptcha_badge'] );
									//}

									if ( ! empty( $item['width_tablet'] ) ) {
										$this->add_render_attribute( 'field-group' . $item_index, 'class', 'elementor-md-' . $item['width_tablet'] );
									}

									if ( ! empty( $item['width_mobile'] ) ) {
										$this->add_render_attribute( 'field-group' . $item_index, 'class', 'elementor-sm-' . $item['width_mobile'] );
									}
									if ( 'honeypot' !== $field_type ) {
										?>
										<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'field-group' . $item_index ) ); ?>>
											<?php
											if ( $item['field_label'] ) {
												echo '<label ' . wp_kses_post( $this->get_render_attribute_string( 'label' . $item_index ) ) . '>' . wp_kses_post( $item['field_label'] ) . '</label>';
											}

											switch ( $field_type ) :
												case 'user_name':
												case 'email':
												case 'password':
												case 'first_name':
												case 'last_name':
												case 'confirm_pass':
													$this->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual' );
													echo '<input size="1" ' . wp_kses_post( $this->get_render_attribute_string( 'input' . $item_index ) ) . '>';
													break;
												//case 'recaptcha_v3':
												//	if ( '' !== $sitekey && '' !== $secretkey ) {
												//		echo '<div id="smw-g-recaptcha-' . esc_attr( $node_id ) . '" class="smw-g-recaptcha-field elementor-field form-field-recaptcha" data-sitekey=' . esc_attr( $sitekey ) . ' data-type="v3" data-action="Form" data-badge="' . esc_attr( $item['recaptcha_badge'] ) . '" data-size="invisible"></div>';
												//	} else {
												//		echo '<div class="elementor-alert smw-recaptcha-alert elementor-alert-warning">';
												//		echo esc_attr__( 'To use reCAPTCHA v3, you need to add the API Key and complete the setup process in Dashboard > Settings > Stiles Media > User Registration Form Settings > reCAPTCHA v3.', smw_slug );
												//		echo '</div>';
												//	}
												//	break;

												default:
													break;

											endswitch;
											?>
											<?php if ( 'user_name' === $field_type ) : ?>
												<div class="smw-username-wrapper" style="display: none;">
													<span class="smw-username-notice"></span>
												</div>
											<?php endif; ?>
											<?php if ( 'email' === $field_type ) : ?>
												<div class="smw-email-wrapper" style="display: none;">
													<span class="smw-email-notice"></span>
												</div>
											<?php endif; ?>
											<?php if ( 'password' === $field_type ) : ?>
												<div class="smw-pass-wrapper" style="display: none;">
													<div class="smw-pass-bar"><div class="smw-pass-bar-color"></div></div>
													<span class="smw-pass-notice"></span>
												</div>
												<?php if('yes' === $settings['strength_checker'])
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
											endif; ?>
											<?php if ( 'confirm_pass' === $field_type ) : ?>
												<div class="smw-confirm-pass-wrapper" style="display: none;">
													<span class="smw-confirm-pass-notice"></span>
												</div>
											<?php endif; ?>
										</div>
										<?php
									} elseif ( 'honeypot' === $field_type ) {
									        echo '<div class="smw-input-fields">';
											echo '<input size="1" type="text" style="display:none !important;" class="elementor-field elementor-field-type-text smw-regform-set-field">';
										echo '</div>';
									}
								endforeach;

								?>
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
										<span class="elementor-button-text smw-register-submit"><?php echo wp_kses_post( $settings['button_text'] ); ?></span>
									<?php endif; ?>
										</span>
									</button>
								</div>
								<div class="smw-rform-footer elementor-field-group">

									<?php
									if ( 'true' === $settings['login'] && '' !== $settings['login_text'] ) {

										$login_url = wp_login_url();

										$this->add_render_attribute( 'login', 'class', 'smw-rform-footer-link' );

										if ( 'custom' === $settings['login_select'] && ! empty( $settings['login_url'] ) ) {

											$this->add_render_attribute( 'login', 'href', $settings['login_url']['url'] );

											if ( $settings['login_url']['is_external'] ) {
												$this->add_render_attribute( 'login', 'target', '_blank' );
											}

											if ( $settings['login_url']['nofollow'] ) {
												$this->add_render_attribute( 'login', 'rel', 'nofollow' );
											}
										} else {
											$this->add_render_attribute( 'login', 'href', $login_url );
										}
										?>

										<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'login' ) ); ?>>
											<span><?php echo wp_kses_post( $settings['login_text'] ); ?></span>
										</a>
									<?php } ?>

									<?php
									if ( 'true' === $settings['lost_password'] && '' !== $settings['lost_password_text'] ) {

										$lost_pass_url = wp_lostpassword_url();

										$this->add_render_attribute( 'lost_pass', 'class', 'smw-rform-footer-link' );

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
											<span><?php echo wp_kses_post( $settings['lost_password_text'] ); ?></span>
										</a>
									<?php } ?>
								</div>
							</div>
							<?php
            				    echo '<input id="widget_id" type="hidden" name="widget_id" value="'. $this->get_id() . '">';
            				?>
						</form>
						<?php
						$this->add_render_attribute( 'validation_messages', 'class', 'smw-registration-message' );
						if ( 'default' === $settings['message_wrap_style'] ) {
							$this->add_render_attribute( 'validation_messages', 'class', 'elementor-alert' );
						}

						if ( 'yes' === $settings['preview_message'] && $is_editor ) {
							if ( 'default' === $settings['message_wrap_style'] ) {
								?>
								<div class="smw-reg-preview-message elementor-alert success"><?php echo esc_attr__( 'This is a success message preview!', smw_slug ); ?></div>
								<div class="smw-reg-preview-message elementor-alert error"><?php echo esc_attr__( 'This is a error message preview!', smw_slug ); ?></div>
							<?php } else { ?>
								<div class="smw-reg-preview-message success"><?php echo esc_attr__( 'This is a success message preview!', smw_slug ); ?></div>
								<div class="smw-reg-preview-message error"><?php echo esc_attr__( 'This is an error message preview!', smw_slug ); ?></div>
							<?php } ?>
						<?php } ?>
						<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'validation_messages' ) ); ?>></div>
					</div>
					<?php
					$html                = ob_get_clean();
					$is_allowed_register = get_option( 'users_can_register' );
					$fields_array        = array(
						'email'        => 'Email',
						'password'     => 'Password',
						'confirm_pass' => 'Confirm Password',
						'user_name'    => 'Username',
						'first_name'   => 'First Name',
						'last_name'    => 'Last Name',
						//'recaptcha_v3' => 'Recaptcha',
					);
					$error_string        = '';

					if ( $is_editor ) 
					{
						if ( $is_allowed_register ) {
							foreach ( $fields_array as $key => $value ) {
								$is_repeated = ${ 'is_' . $key . '_exists' };

								if ( isset( $is_repeated ) && 1 < $is_repeated ) {
									$error_string .= $value . ', ';
								}
							}
							if ( '' !== $error_string ) {
								$error_string = rtrim( $error_string, ', ' );
								?>
								<span class='smw-register-error-message'>
									<?php
									echo '<div class="elementor-alert elementor-alert-warning">';
									echo sprintf( __( 'Error! It seems like you have added <b>%s</b> field in the form more than once.', smw_slug ), wp_kses_post( $error_string ) );
									echo '</div>';
									?>
								</span>
								<?php
								return false;
							}

							if ( isset( $is_email_exists ) && 0 === $is_email_exists ) {
								?>
								<span class='smw-register-error-message'>
									<?php
									echo '<div class="elementor-alert elementor-alert-warning">';
										echo esc_attr__( 'For Registration Form E-mail field is required!', smw_slug );
									echo '</div>';
									?>
								</span>
								<?php
								return false;
							} elseif ( $is_confirm_pass && ! $is_pass_valid ) {
								?>
								<span class='smw-register-error-message'>
									<?php
									echo '<div class="elementor-alert elementor-alert-warning">';
									echo esc_attr__( 'Password field should be added to the form to use the Confirm Password field.', smw_slug );
									echo '</div>';
									?>
								</span>
								<?php
								return false;
							}
						} elseif ( is_multisite() ) {
							?>
							<span class='smw-register-error-message'>
								<?php
								echo '<div class="elementor-alert elementor-alert-warning">';
								echo esc_attr__( 'To use the Registration Form on your site, you must set the "Allow new registrations" to "User accounts may be registered" setting from Network Admin -> Dashboard -> Settings.', smw_slug );
								echo '</div>';
								?>
							</span>
							<?php
							return false;
						} else {
							?>
							<span class='smw-register-error-message'>
								<?php
								echo '<div class="elementor-alert elementor-alert-warning">';
								echo esc_attr__( 'To use the Registration Form on your site, you must enable the "Anyone Can Register" setting from Dashboard -> Settings -> General -> Membership.', smw_slug );
								echo '</div>';
								?>
							</span>
							<?php
							return false;
						}
					} elseif ( ( ( ! $is_email_exists ) || ( $is_confirm_pass && ! $is_pass_valid ) ) && ( ! $is_editor ) ) {
						return false;
					} elseif ( ! $is_allowed_register ) {
						return false;
					}
					echo $html;
			endif;
		}
		
		if($is_editor)
		{
		    //do nothing
		}
		else
		{
		    ?>
            <script type="text/javascript">
    			jQuery(document).ready(function($) 
    			{
    			    //register start
    				var register_form = 'form#smw-register-form';
    				var loading_text='<span class="loading-spinner-log"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>';
    				var notverify='<span class="loading-spinner-log"><i class="fa fa-times-circle-o" aria-hidden="true"></i></span>';
    				var success="";
    				var error="";
    				var firstname = "";
    				var lastname = "";
    				var confirmpass = "";
    				var username = "";
    				var email = "";
    				var password = "";
    				var post_id = "";
    				var widget_id = "";
    				var sendemail = "";
    				var redirect_url = "";
    				var auto_login = "";
    				var redirect="";

    				$(register_form).on('submit', function(e)
    	            {
    	                var iserrors = false;
    	                post_id = $(".smw-registration-form-wrapper").attr("data-page-id");
    	                sendemail = $(".smw-registration-form-wrapper").attr("data-send_email");
    	                redirect_url = $(".smw-registration-form-wrapper").attr("data-redirect-url");
    	                auto_login = $(".smw-registration-form-wrapper").attr("data-auto_login");
    	                success = $(".smw-registration-form-wrapper").attr("data-success-message");
    	                error = $(".smw-registration-form-wrapper").attr("data-error-message");
    	                redirect = $(".smw-registration-form-wrapper").attr("redirect");

    	                $('.smw-username-wrapper').hide();
    	                $('.smw-email-wrapper').hide();
    	                $('.smw-pass-wrapper').hide();
    	                $('.smw-confirm-pass-wrapper').hide();
    	                $(".smw-registration-message").hide();
    	                
    	                $('.smw-field-user_name').each(function()
    	                {
                            username = $(this).val();
                        });
                        $('.smw-field-password').each(function()
    	                {
                            password = $(this).val();
                        });
                        $('.smw-field-email').each(function()
    	                {
                            email = $(this).val();
                            var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
                            if(! pattern.test(email))
                            {
                                $('.smw-email-wrapper').html('<span class="smw-register-error">Enter a valid email!</span>');
                                $('.smw-email-wrapper').show();
                                iserrors = true;
                            }
                        });
    	                
    	                var parent = document.querySelector(register_form),
                            confirm_pass = document.querySelector('.smw-field-confirm_pass'),
                            first_name = document.querySelector('.smw-field-first_name'),
                            last_name = document.querySelector('.smw-field-last_name');
                            
    	                var confirm_pass_exists = parent.contains(confirm_pass);
    	                var first_name_exists = parent.contains(first_name);
    	                var last_name_exists = parent.contains(last_name);
    	                
    	                if(confirm_pass_exists)
    	                {
    	                    $('.smw-field-confirm_pass').each(function()
    	                    {
                                confirmpass = $(this).val();
                            });
                            
                            if(confirmpass != password)
                            {
                                $('.smw-confirm-pass-wrapper').html('<span class="smw-register-error">The specified password\'s do not match!</span>');
                                $('.smw-confirm-pass-wrapper').show();
                                iserrors = true;
                            }
    	                }
    	                
    	                if(first_name_exists)
    	                {
    	                    $('.smw-field-first_name').each(function()
    	                    {
                                firstname = $(this).val();
                            });
    	                }
    	                
    	                if(last_name_exists)
    	                {
    	                    $('.smw-field-last_name').each(function()
    	                    {
                                lastname = $(this).val();
                            });
    	                }
    	                
    	                widget_id = $('#widget_id').val();
    	                
                        if(iserrors)
                        {
                            return false;
                        }
                        else
                        {
                            var data = {};
                            
                            data['action'] = 'smw_register_user';
                            data['nonce'] = smw_nonce;
                            data['username'] = username;
                            data['password'] = password;
                            data['email'] = email;
                            data['widget_id'] = widget_id;
                            data['post_id'] = post_id;

                            if(firstname != '')
                                data['firstname'] = firstname;
                            
                            if(lastname != '')
                                data['lastname'] = lastname;
                                
                            if(sendemail != '')
                                data['send_email'] = sendemail;
                                
                            if(redirect_url != '')
                                data['redirect_url'] = redirect_url;
                                
                            if(auto_login != '')
                                data['auto_login'] = auto_login;
                                
                            if(redirect != '')
                                data['redirect'] = redirect;
                                
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
    			                        $(".smw-registration-message").show();
    			                        $(".smw-registration-message").removeClass("success").addClass("error");
    			                        $(".smw-registration-message").html(error);
    			                           
    	                                if(data.error.hasOwnProperty("email"))
    	                                {
    	                                    $('.smw-email-wrapper').show();
                                            $('.smw-email-wrapper').html('<span class="smw-register-error">' + data.error.email + '</span>');
    	                                }
    	                                if(data.error.hasOwnProperty("username"))
    	                                {
    	                                    $('.smw-username-wrapper').show();
                                            $('.smw-username-wrapper').html('<span class="smw-register-error">' + data.error.username + '</span>');
    	                                }
    			                    }
    			                    else
    			                    {
    			                        $(".smw-registration-message").show();
    			                        $(".smw-registration-message").removeClass("error").addClass("success");
    			                        $(".smw-registration-message").html(success);
    			                           
    			                        if(data.redirect == "redirect")
    			                        {
    			                            document.location.href = data.url;
    			                        }
    			                        if(data.redirect == "auto_login")
    			                        {
    			                            document.location.href = data.url;
    			                        }
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
            		    
        				$(".smw-field-password").keyup(function() 
        				{
                            $('.smw-register-form-submit').prop('disabled', true);					
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
                                $('.smw-register-form-submit').prop('disabled', false);					
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

Plugin::instance()->widgets_manager->register_widget_type( new stiles_register() );