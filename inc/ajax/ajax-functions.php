<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! session_id() && ! headers_sent() ) 
{
	session_start();
}

//Stiles login ajax call
add_action( 'wp_ajax_smw_login_form_submit', 'get_login_form_data' );
add_action( 'wp_ajax_nopriv_smw_login_form_submit', 'get_login_form_data' );
//non ajax login call
add_action( 'init', 'login_submit', 1 );

add_action( 'wp_ajax_smw_register_user', 'get_register_form_data' );
add_action( 'wp_ajax_nopriv_smw_register_user', 'get_register_form_data' );
add_filter( 'wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 10, 3 );

add_action( 'wp_ajax_smw_forgot_password', 'get_forgot_form_data' );
add_action( 'wp_ajax_nopriv_smw_forgot_password', 'get_forgot_form_data' );
add_action( 'wp_ajax_smw_reset_password', 'get_reset_form_data' );
add_action( 'wp_ajax_nopriv_smw_reset_password', 'get_reset_form_data' );
//add_filter( 'wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 10, 3 );

add_action( 'wp_ajax_stiles_quickview', 'stiles_wc_quickview' );
add_action( 'wp_ajax_nopriv_stiles_quickview', 'stiles_wc_quickview' );

function get_login_form_data() 
{
	check_ajax_referer('smw-nonce', 'nonce');
	
	$data     = array();
	$error = array();
	
	$data = $_POST;
	
	$username   = ! empty( $data['username'] ) ? $data['username'] : '';
	$password   = ! empty( $data['password'] ) ? $data['password'] : '';
	$rememberme = ! empty( $data['rememberme'] ) ? $data['rememberme'] : '';
	
    if(empty( $username ) and empty( $password ))
    {
        wp_send_json_error( 'fields_empty' );
    }
    elseif(empty( $username ))
    {
        wp_send_json_error( 'empty_username' );
    }
    elseif(empty( $password ))
    {
        wp_send_json_error( 'empty_password' );
    }
    
    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
		'remember'      => ( 'forever' === $rememberme ) ? true : false
    );
    
    $user_data = wp_signon( $creds );
 
    if ( is_wp_error( $user_data ) ) 
    {
        if ( class_exists( 'Limit_Login_Attempts' ) ) 
		{
            // Limit Login Attempts is active
            global $limit_login_attempts_obj;

            $llaerror = $limit_login_attempts_obj->get_message();
            
            if ( isset( $user_data->errors['invalid_email'][0] ) ) 
            {
                $error[ 'reason' ] = 'invalid_email';
                $error[ 'llaerror' ] = $llaerror;
            } 
            elseif ( isset( $user_data->errors['invalid_username'][0] ) ) 
            {
                $error[ 'reason' ] = 'invalid_username';
                $error[ 'llaerror' ] = $llaerror;
            } 
            elseif ( isset( $user_data->errors['incorrect_password'][0] ) ) 
            {
                $error[ 'reason' ] = 'incorrect_password';
                $error[ 'llaerror' ] = $llaerror;
            }
            elseif ( isset( $user_data->errors['too_many_retries'][0] ) ) 
            {
                $error[ 'reason' ] = 'too_many_retries';
                $error[ 'llaerror' ] = $llaerror;
            }
            
            wp_send_json_error( $error );
        }
        else
        {
            wp_send_json_error( $user_data );
        }
	} else 
	{
        wp_send_json_success( 'loggedin' );	
	}
}

function login_submit()
{
    if(!isset($_POST['action']) || $_POST['action'] !== 'login_submit')
    {
        return;
    }
    
    if ( ! isset( $_POST['smw-nonce'] ) || ! wp_verify_nonce( $_POST['smw-nonce'], 'login_submit' ) 
    ) 
    {
      echo 'incorrect nonce, security has failed';
      exit();
    } 
	
	$data = array();
	
	$data = $_POST;

	$username   = ! empty( $data['username'] ) ? $data['username'] : '';
	$password   = ! empty( $data['password'] ) ? $data['password'] : '';
	$rememberme = ! empty( $data['rememberme'] ) ? $data['rememberme'] : '';
    $location = $_SERVER['HTTP_REFERER'];
    
    if(empty( $username ) and empty( $password ))
    {
        $_SESSION['smw_error'] = 'fields_empty';
        wp_safe_redirect($location);
        exit();
    }
    elseif(empty( $username ))
    {
        $_SESSION['smw_error'] = 'username_empty';
        wp_safe_redirect($location);
        exit();
    }
    elseif(empty( $password ))
    {
        $_SESSION['smw_error'] = 'password_empty';
        wp_safe_redirect($location);
        exit();
    }
    
    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => ( 'forever' === $rememberme ) ? true : false
    );
    
    $user = wp_signon( $creds );
    
    if ( is_wp_error( $user ) ) 
    {
		if ( isset( $user->errors['invalid_email'][0] ) ) 
		{
		    $_SESSION['smw_error'] = 'invalid_email';
		    wp_safe_redirect($location);
            exit();
		} elseif ( isset( $user->errors['invalid_username'][0] ) ) 
		{
            $_SESSION['smw_error'] = 'invalid_username';
            wp_safe_redirect($location);
            exit();
        } elseif ( isset( $user->errors['incorrect_password'][0] ) ) 
        {
            $_SESSION['smw_error'] = 'incorrect_password';
            wp_safe_redirect($location);
            exit();
		}
	} else 
	{
		wp_set_current_user( $user_data->ID, $username );
		do_action( 'wp_login', $user_data->user_login, $user_data );
		if ( isset( $data['redirect_to'] ) && '' !== $data['redirect_to'] ) 
		{
			wp_safe_redirect( $data['redirect_to'] );
			exit();
		}
	}
 
    if ( is_wp_error( $user ) ) 
    {
        $_SESSION['smw_error'] = $user->get_error_message();
        wp_safe_redirect($location);
        exit();
    }
}

function custom_wp_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) 
{
	if ( array_key_exists( 'template_type', $email_content ) && 'custom' === $email_content['template_type'] ) 
	{
		$wp_new_user_notification_email['subject'] = sprintf( $email_content['subject'], $blogname, $user->user_login );

		$message = $email_content['message'];

		$find = array( '/\[field=password\]/', '/\[field=username\]/', '/\[field=email\]/', '/\[field=first_name\]/', '/\[field=last_name\]/' );

		$replacement = array( $email_content['pass'], $email_content['user_login'], $email_content['user_email'], $email_content['first_name'], $email_content['last_name'] );

		if ( isset( $email_content['pass'] ) ) 
		{
			$message = preg_replace( $find, $replacement, $message );
		}

		$wp_new_user_notification_email['message'] = $message;

		$wp_new_user_notification_email['headers'] = $email_content['headers'];
	}

	return $wp_new_user_notification_email;
}

/**
 * @since 1.18.0
 * @access public
 * @param string $email New customer email address.
 * @param string $suffix Append string to username to make it unique.
 * @return string Generated username.
 */
function smw_create_username( $email, $suffix ) 
{
    $username_parts = array();

    // If there are no parts, e.g. name had unicode chars, or was not provided, fallback to email.
    if ( empty( $username_parts ) ) 
    {
        $email_parts    = explode( '@', $email );
        $email_username = $email_parts[0];

        // Exclude common prefixes.
        if ( in_array(
            $email_username,
            array(
                'sales',
                'hello',
                'mail',
                'contact',
                'info',
                'admin',
                'enquiries',
            ),
            true
        ) ) {
            // Get the domain part.
            $email_username = $email_parts[1];
        }

        $username_parts[] = sanitize_user( $email_username, true );
    }
    $username = strtolower( implode( '', $username_parts ) );

    if ( $suffix ) {
        $username .= $suffix;
    }

    if ( username_exists( $username ) ) 
    {
        // Generate something unique to append to the username in case of a conflict with another user.
        $suffix = '-' . zeroise( wp_rand( 0, 9999 ), 4 );
        return smw_create_username( $email, $suffix );
    }

    return $email_username;
}
    
/* Get Widget Setting data.
 *
 * @since 1.18.0
 * @access public
 * @param array  $elements Element array.
 * @param string $form_id Element ID.
 * @return Boolean True/False.
 */
function find_element_recursive( $elements, $form_id ) 
{
    foreach ( $elements as $element ) 
    {
        if ( $form_id === $element['id'] ) {
            return $element;
        }

        if ( ! empty( $element['elements'] ) ) 
        {
            $element = find_element_recursive( $element['elements'], $form_id );

            if ( $element ) 
            {
                return $element;
            }
        }
    }

    return false;
}

function get_register_form_data() 
{
    check_ajax_referer('smw-nonce', 'nonce');

    $data             = array();
    $error            = array();
    $response         = array();
    $allow_register   = get_option( 'users_can_register' );
    
    $data = $_POST;

    if ( '1' === $allow_register ) 
    {
        $username   = ! empty( $data['username'] ) ? $data['username'] : '';
        $email   = ! empty( $data['email'] ) ? $data['email'] : '';
        $password   = ! empty( $data['password'] ) ? $data['password'] : '';
        $firstname = ! empty( $data['firstname'] ) ? $data['firstname'] : '';
        $lastname = ! empty( $data['lastname'] ) ? $data['lastname'] : '';
        $post_id   = ! empty( $data['post_id'] ) ? $data['post_id'] : '';
		$widget_id = ! empty( $data['widget_id'] ) ? $data['widget_id'] : '';
		$redirect_url = ! empty( $data['redirect_url'] ) ? $data['redirect_url'] : '';
		$redirect = ! empty( $data['redirect'] ) ? $data['redirect'] : '';
		$location = $_SERVER['HTTP_REFERER'];


        if('' === $username)
        {
            $username = smw_create_username( $email , '' );
        }
        
        $elementor = \Elementor\Plugin::$instance;
		$meta      = $elementor->documents->get( $post_id )->get_elements_data();

        $widget_data = find_element_recursive( $meta, $widget_id );

        $widget = $elementor->elements_manager->create_element_instance( $widget_data );

        $settings = $widget->get_settings();
        
        if ( 'both' === $data['send_email'] && 'custom' === $settings['email_template'] ) 
        {
            $email_content['subject'] = $settings['email_subject'];
            $email_content['message'] = $settings['email_content'];
            $email_content['headers'] = 'Content-Type: text/' . $settings['email_content_type'] . '; charset=UTF-8' . "\r\n";
        }
        
        $email_content['template_type'] = $settings['email_template'];

        $user_role = ( 'default' !== $settings['select_role'] && ! empty( $settings['select_role'] ) ) ? $settings['select_role'] : get_option( 'default_role' );

        /* Checking Email address. */
        if ( isset( $data['email'] ) && ! is_email( $data['email'] ) ) 
        {
            $error['email'] = __( 'The email address is incorrect.', smw_slug );
        } elseif ( email_exists( $data['email'] ) ) 
        {
            $error['email'] = __( 'An account is already registered with your email address. Please choose another one.', smw_slug );
        }
        
        /* Checking User name. */
        if ( isset( $data['username'] ) && ! empty( $data['username'] ) && ! validate_username( $data['username'] ) ) 
        {
            $error['username'] = __( 'This username is invalid because it uses illegal characters. Please enter a valid username.', smw_slug );

        } elseif ( isset( $data['username'] ) && ( mb_strlen( $data['username'] ) > 60 ) && validate_username( $data['username'] ) ) 
        {
            $error['username'] = __( 'Username may not be longer than 60 characters.', smw_slug );
        } elseif ( isset( $data['username'] ) && username_exists( $data['username'] ) ) 
        {
            $error['username'] = __( 'This username is already registered. Please choose another one.', smw_slug );

        } elseif ( isset( $data['username'] ) && ! empty( $data['username'] ) ) 
        {
            /** This Filters the list of blacklisted usernames. */
            $illegal_logins = (array) apply_filters( 'smw_illegal_user_logins', array() );

            if ( in_array( strtolower( $data['username'] ), array_map( 'strtolower', $illegal_logins ), true ) ) {
                $error['user_login'] = __( 'Sorry, that username is not allowed.', smw_slug );
            }
        }
        
        // Handle password creation.
        $password_generated = false;
        $user_pass          = '';
        if ( ! isset( $data['password'] ) && empty( $data['password'] ) ) 
        {
            $user_pass          = wp_generate_password();
            $password_generated = true;
        } else 
        {
            /* Checking User Password. */
            if ( false !== strpos( wp_unslash( $data['password'] ), '\\' ) ) 
            {
                $error['password'] = __( 'Password may not contain the character "\\"', smw_slug );
            } else 
            {
                $user_pass = $data['password'];
            }
        }
        
        $user_login = ( isset( $data['username'] ) && ! empty( $data['username'] ) ) ? sanitize_user( $data['username'], true ) : '';
        $user_email = ( isset( $data['email'] ) && ! empty( $data['email'] ) ) ? sanitize_text_field( wp_unslash( $data['email'] ) ) : '';
        
        $first_name = ( isset( $data['firstname'] ) && ! empty( $data['firstname'] ) ) ? sanitize_text_field( wp_unslash( $data['first_name'] ) ) : '';

        $last_name = ( isset( $data['lastname'] ) && ! empty( $data['lastname'] ) ) ? sanitize_text_field( wp_unslash( $data['lastname'] ) ) : '';
        
        if ( ! empty( $error ) ) 
        {
            // If there are items in our errors array, return those errors.
            $response['success'] = false;
            $response['error']   = $error;

        } else 
        {
            $email_content['user_login'] = $user_login;
            $email_content['user_email'] = $user_email;
            $email_content['first_name'] = $first_name;
            $email_content['last_name']  = $last_name;
            
            $user_args = apply_filters(
                'smw_register_insert_user_args',
                array(
                    'user_login'      => isset( $user_login ) ? $user_login : '',
                    'user_pass'       => isset( $user_pass ) ? $user_pass : '',
                    'user_email'      => isset( $user_email ) ? $user_email : '',
                    'first_name'      => isset( $first_name ) ? $first_name : '',
                    'last_name'       => isset( $last_name ) ? $last_name : '',
                    'user_registered' => gmdate( 'Y-m-d H:i:s' ),
                    'role'            => isset( $user_role ) ? $user_role : '',
                )
            );

            $result = wp_insert_user( $user_args );
            
            if ( ! is_wp_error( $result ) ) 
            {
                if( 'yes' === $data['redirect'])
                {
                    // show a message of success and provide a true success variable.
                    $response['success'] = true;
                    $response['message'] = __( 'successfully registered', smw_slug );
                    $response['redirect'] = "redirect";
                    
                    if('' === $redirect_url)
                    {
                        $response['url'] = $location;
                    }
                    else
                    {
                        $response['url'] = $redirect_url;
                    }
                    
                    $notify = $data['send_email'];
                }
                elseif('yes' === $data['auto_login'])
                {
                    // show a message of success and provide a true success variable.
                    $response['success'] = true;
                    $response['message'] = __( 'successfully registered', smw_slug );
                    $response['redirect'] = "auto_login";
                    $response['url'] = $location;
                }
                else
                {
                    $response['success'] = true;
                    $response['message'] = __( 'successfully registered', smw_slug );
                    
                    $notify = $data['send_email'];
                }

                /* Login user after registration and redirect to home page if not currently logged in */
                if ( ! is_user_logged_in() && 'yes' === $data['auto_login'] ) 
                {
                    $creds                  = array();
                    $creds['user_login']    = $user_login;
                    $creds['user_password'] = $user_pass;
                    $creds['remember']      = true;
                    $login_user             = wp_signon( $creds );
                }

                if ( $result ) 
                {
                    // Send email to the user even if the send email option is disabled.
                    $email_content['pass'] = $user_pass;
                }

                /**
                 * Fires after a new user has been created.
                 *
                 * @since 1.18.0
                 *
                 * @param int    $user_id ID of the newly created user.
                 * @param string $notify  Type of notification that should happen. See wp_send_new_user_notifications()
                 *                        for more information on possible values.
                 */
                do_action( 'edit_user_created_user', $result, $notify );

            } else 
            {
                $response['error'] = wp_send_json_error();
            }
        }
        
        wp_send_json( $response );
    } else 
    {
        wp_die();
    }
}

function get_forgot_form_data()
{
    check_ajax_referer('smw-nonce', 'nonce');

    $data             = array();
    $error            = array();
    $response         = array();
    
    $data = $_POST;
    
    $username   = ! empty( $data['username'] ) ? $data['username'] : '';
    $widget_id   = ! empty( $data['widget_id'] ) ? $data['widget_id'] : '';
    $page_id = ! empty( $data['page_id'] ) ? $data['page_id'] : '';
    $location = $_SERVER['HTTP_REFERER'];
    
    $elementor = \Elementor\Plugin::$instance;
	$meta      = $elementor->documents->get( $page_id )->get_elements_data();
    $widget_data = find_element_recursive( $meta, $widget_id );
    $widget = $elementor->elements_manager->create_element_instance( $widget_data );
    $settings = $widget->get_settings();
    
    if( email_exists( $username ))
    {
        $user = get_user_by( 'email', $username );
    }
    elseif( username_exists( $username ) )
    {
        $user = get_user_by( 'login' , $username );
    }
    else
    {
        wp_send_json_error('invalid_username');
    }
    
    $username = $user->user_login;
    $email = $user->user_email;
    $display_name = $user->display_name;
    
    if ( ! ( $user instanceof WP_User ) ) 
    {
        wp_send_json_error(new WP_Error( 'invalidcombo', __( '<strong>Error</strong>: There is no account with that username or email address.' ) ));
    }
	
	if ( is_multisite() )
	{
		$blogname = $GLOBALS['current_site']->site_name;
	}
	else
	{
		/*
		 * The blogname option is escaped with esc_html on the way into the database
		 * in sanitize_option we want to reverse this for the plain text arena of emails.
		 */
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	}
	
	$url = get_site_url();
    $find_h = '#^http(s)?://#';
    $find_w = '/^www\./';
    $replace = '';
    $output = preg_replace( $find_h, $replace, $url );
    $url = preg_replace( $find_w, $replace, $output );
    $headers = "From:" . $blogname . "<no-reply@" . $url .">" . "\r\n";
    
    if('true' === $settings['generate_password'])
    {
        $password = wp_generate_password( 8, false );

        $msg  = __( 'Hello ' . $display_name, smw_slug ) . "\r\n\r\n";
        $msg .= sprintf( __( 'You asked us to reset your password for your account using the forgot password form %s.', smw_slug ), $user_login ) . "\r\n\r\n";
        $msg .= __( "If this was a mistake, or you didn't ask for a password reset, then contact the site administrator, who can reset your password.", smw_slug ) . "\r\n\r\n";
        $msg .= __( 'We have generated the following password for you', smw_slug ) . "\r\n\r\n";
        $msg .= __( 'New password: ', smw_slug ) . $password . "\r\n\r\n";
        $msg .= __( 'Thanks!', smw_slug ) . "\r\n";
        
        reset_password($user, $password);
        
        $title = sprintf( __('[%s] Password Generated'), $blogname );
        $to = $email;
        $body = $msg;
            
        if ( wp_mail( $email, wp_specialchars_decode( $title ), $msg, $headers ) )
        {
    		 wp_send_json_success('password_generated', __('Check your e-mail for the confirmation link.'), 'message');
        }
    	else
    	{
    	    wp_send_json_error('could_not_send', __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.'), 'message');
    	}
    }
    else
    {
        $key = get_password_reset_key( $user );
    
    	if ( is_wp_error( $key ) ) 
    	{
    		wp_send_json_error($key);
    	}
	
        $msg  = __( 'Hello ' . $display_name , smw_slug ) . "\r\n\r\n";
        $msg .= sprintf( __( 'You asked us to reset your password for your account using forgot password form %s.', smw_slug ), $user_login ) . "\r\n\r\n";
        $msg .= __( "If this was a mistake, or you didn't ask for a password reset, just ignore this email and nothing will happen.", smw_slug ) . "\r\n\r\n";
        $msg .= __( 'To reset your password, visit the following address:', smw_slug ) . "\r\n\r\n";
        $msg .= __( $location . '?action=rp&key=' . $key . '&login=' . rawurlencode( $username ) , smw_slug ) . "\r\n\r\n";
        $msg .= __( 'Thanks!', smw_slug ) . "\r\n";
        
        $title = sprintf( __('[%s] Password Reset'), $blogname );
        
        if ( wp_mail( $email, wp_specialchars_decode( $title ), $msg, $headers ) )
        {
		    wp_send_json_success('confirm', __('Check your e-mail for the confirmation link.'), 'message');
        }
	    else
	    {
		    wp_send_json_error('could_not_send', __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.'), 'message');
	    }
    }
}

function get_reset_form_data()
{
    check_ajax_referer('smw-nonce', 'nonce');
    
    $data             = array();
    $error            = array();
    $response         = array();
    
    $data = $_POST;
    
    $password   = ! empty( $data['password'] ) ? $data['password'] : '';
    $key        = ! empty( $data['key'] ) ? $data['key'] : '';
    $username   = ! empty( $data['username'] ) ? $data['username'] : '';
    $displayname = '';
    $email = '';
    
    if( username_exists( $username ))
    {
        $user = get_user_by( 'login' , $username );
        $displayname = $user->display_name;
        $email = $user->user_email;
        $user = check_password_reset_key( $key, $username );
    }
    elseif( email_exists( $username ) )
    {
        $user = get_user_by( 'email', $username );
        $displayname = $user->display_name;
        $email = $user->user_email;
        $user = check_password_reset_key( $key, $username );
    }
    else
    {
        wp_send_json_error( 'invalid_username' );
    }
    
    if ( is_wp_error( $user ) ) 
    {
        if ( $user->get_error_code() === 'expired_key' )
        {
            wp_send_json_error( "Key is expired");
        }
        else
        {
            wp_send_json_error( "Key is not valid");
        }
    }
    
    if ( is_multisite() )
	{
		$blogname = $GLOBALS['current_site']->site_name;
	}
	else
	{
		/*
		 * The blogname option is escaped with esc_html on the way into the database
		 * in sanitize_option we want to reverse this for the plain text arena of emails.
		 */
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	}
	
	$url = get_site_url();
    $find_h = '#^http(s)?://#';
    $find_w = '/^www\./';
    $replace = '';
    $output = preg_replace( $find_h, $replace, $url );
    $url = preg_replace( $find_w, $replace, $output );
    $headers = "From:" . $blogname . "<no-reply@" . $url .">" . "\r\n";
    
    // Check if key is valid
	if ( is_wp_error($user) ) 
	{
		if ( $user->get_error_code() === 'expired_key' ){
			wp_send_json_error( 'expired_key' );
		}
		else
		{
			wp_send_json_error( 'invalid_key' );
		}
	}
	else
	{
	    reset_password($user, $password);
	    
    	$msg  = __( 'Hello ' . $displayname, smw_slug ) . "\r\n\r\n";
        $msg .= __( 'Your password was reset successfully', smw_slug ) . "\r\n\r\n";
        $msg .= __( "If this was a mistake, or you didn't ask for a password reset, then contact the site administrator, who can reset your password.", smw_slug ) . "\r\n\r\n";
        $msg .= __( 'You should now be able to login with your new password if you haven\'t already', smw_slug ) . "\r\n\r\n";
        $msg .= __( 'Thanks!', smw_slug ) . "\r\n";
            
    	$title = sprintf( __('[%s] Password Reset Successfully'), $blogname );
        $to = $email;
        $body = $msg;
    	 
    	if ( wp_mail( $email, wp_specialchars_decode( $title ), $msg, $headers ) )
        {
            $response['reset'] = "password_reset";
            $response['email'] = "email_sent";
            wp_send_json_success( $response );
        }
    	else
    	{
    	    $response['reset'] = "password_reset";
            $response['email'] = "email_not_sent";
            wp_send_json_success( $response );
    	}
	}
}

// Quick view Ajax Callback
function stiles_wc_quickview() 
{
    // Get product from request.
    if ( isset( $_POST['id'] ) && (int) $_POST['id'] ) 
    {
        global $post, $product, $woocommerce;
        $id      = ( int ) $_POST['id'];
        $post    = get_post( $id );
        $product = get_product( $id );
        if ( $product ) 
        { 
            include ( apply_filters( 'stiles_quickview_tmp', smw_dir . 'inc/functions/quickview-content.php' ) ); 
        }
    }
    wp_die();
}