<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class smw_Admin_Settings
{
    private $settings_api;

    function __construct() 
    {
        $this->settings_api = new smw_Settings_API();
        
        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
        add_action( 'wsa_form_top_smw_elements_tabs', array( $this, 'html_element_toogle_button' ) );
        add_action( 'wsa_form_top_smw_style_tabs', array( $this, 'style_tab_html' ) );
        add_action( 'wsa_form_bottom_smw_style_tabs', array( $this, 'style_tab_bottom_html' ) );
    }

    function admin_init() 
    {
        //set the settings
        $this->settings_api->set_sections( $this->smw_admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->smw_admin_fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    // Plugins menu Register
    function admin_menu() 
    {
        $menu = 'add_menu_' . 'page';
        $menu(
            'smw_panel',
            esc_html__( 'Stiles Media', smw_slug ),
            esc_html__( 'Stiles Media', smw_slug ),
            'smw_page',
            NULL,
            smw_url . 'inc/admin/assets/images/menu-icon.png',
            100
        );
        
        add_submenu_page(
            'smw_page', 
            esc_html__( 'Plugin Options', smw_slug ),
            esc_html__( 'Plugin Options', smw_slug ), 
            'manage_options', 
            'stiles', 
            array ( $this, 'plugin_page' ) 
        );
    }

    // Options page Section register
    function smw_admin_get_settings_sections() 
    {
        $sections = array(
            array(
                'id'    => 'smw_general_tabs',
                'title' => esc_html__( 'General', smw_slug )
            ),

            array(
                'id'    => 'smw_template_tabs',
                'title' => esc_html__( 'WooCommerce Templates', smw_slug )
            ),

            array(
                'id'    => 'smw_elements_tabs',
                'title' => esc_html__( 'Modules', smw_slug )
            ),

            array(
                'id'    => 'smw_rename_label_tabs',
                'title' => esc_html__( 'Rename Labels', smw_slug )
            ),

            array(
                'id'    => 'smw_sales_notification_tabs',
                'title' => esc_html__( 'Sales Notification', smw_slug )
            ),
            
            array(
                'id'    => 'smw_others_tabs',
                'title' => esc_html__( 'Other', smw_slug )
            ),
        );
        
        return $sections;
    }

    // Options page field register
    protected function smw_admin_fields_settings() 
    {
        $settings_fields = array(
            //start of General tabs
            'smw_general_tabs' => array(
                array(
                    'name'      => 'google_maps_heading',
                    'heading'  => esc_html__( 'Google Maps', smw_slug ),
                    'type'      => 'title',
                ),
                
                array(
                    'name'        => 'google_maps_key',
                    'label'       => esc_html__( 'Google Maps API Key', smw_slug ),
                    'desc'        => esc_html__( 'Enter your Google Maps API key', smw_slug ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Insert Google Maps key', smw_slug )
                ),
                
                array(
                    'name'      => 'google_recaptcha_v3_heading',
                    'heading'  => esc_html__( 'Google Recaptcha V3', smw_slug ),
                    'type'      => 'title',
                ),
                
                array(
                    'name'        => 'google_recaptcha_v3_site_key',
                    'label'       => esc_html__( 'Google Recaptcha V3 Site Key', smw_slug ),
                    'desc'        => esc_html__( 'Enter your Google Recaptcha V3 site key', smw_slug ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Insert Google Recaptcha V3 site key ', smw_slug )
                ),
                
                array(
                    'name'        => 'google_recaptcha_v3_secret_key',
                    'label'       => esc_html__( 'Google Recaptcha V3 Secret Key', smw_slug ),
                    'desc'        => esc_html__( 'Enter your Google Recaptcha V3 secret key', smw_slug ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Insert Google Recaptcha V3 secret key ', smw_slug )
                ),
                
                array(
                    'name'      => 'google_recaptcha_v2_heading',
                    'heading'  => esc_html__( 'Google recaptcha V2', smw_slug ),
                    'type'      => 'title',
                ),
                
                array(
                    'name'        => 'google_recaptcha_v2_site_key',
                    'label'       => esc_html__( 'Google Recaptcha V2 Site Key', smw_slug ),
                    'desc'        => esc_html__( 'Enter your Google Recaptcha V2 site key', smw_slug ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Insert Google Recaptcha V2 site key ', smw_slug )
                ),
                
                array(
                    'name'        => 'google_recaptcha_v2_secret_key',
                    'label'       => esc_html__( 'Google Recaptcha V2 Secret Key', smw_slug ),
                    'desc'        => esc_html__( 'Enter your Google Recaptcha V2 secret key', smw_slug ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Insert Google Recaptcha V2 secret key ', smw_slug )
                ),
            ),
            
            //start of templates tab
            'smw_template_tabs'=>array(
                array(
                    'name'  => 'enablecustomlayout',
                    'label'  => esc_html__( 'Enable / Disable Template Builder', smw_slug ),
                    'desc'  => esc_html__( 'Enable', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),

                array(
                    'name'  => 'shoppageproductlimit',
                    'label' => esc_html__( 'Product Limit', smw_slug ),
                    'desc' => wp_kses_post( 'You can Handle Shop page product limit', smw_slug ),
                    'min'               => 1,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'std'               => '10',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'    => 'singleproductpage',
                    'label'   => esc_html__( 'Single Product Template', smw_slug ),
                    'desc'    => esc_html__( 'You can select Custom Product details layout', smw_slug ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => smw_elementor_template()
                ),

                array(
                    'name'    => 'productarchivepage',
                    'label'   => esc_html__( 'Product Archive Page Template', smw_slug ),
                    'desc'    => esc_html__( 'You can select Custom Product Shop page layout', smw_slug ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => smw_elementor_template()
                ),

                array(
                    'name'    => 'productcartpage',
                    'label'   => esc_html__( 'Cart Page Template', smw_slug ),
                    'desc'    => esc_html__( 'You can select Custom cart page layout', smw_slug ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => smw_elementor_template()
                ),

                array(
                    'name'    => 'productemptycartpage',
                    'label'   => esc_html__( 'Empty Cart Page Template', smw_slug ),
                    'desc'    => esc_html__( 'You can select Custom empty cart page layout', smw_slug ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => smw_elementor_template()
                ),

                array(
                    'name'    => 'productcheckoutpage',
                    'label'   => esc_html__( 'Checkout Page Template', smw_slug ),
                    'desc'    => esc_html__( 'You can select Custom checkout page layout', smw_slug ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => smw_elementor_template()
                ),

                array(
                    'name'    => 'productcheckouttoppage',
                    'label'   => esc_html__( 'Checkout Page Top Content', smw_slug ),
                    'desc'    => esc_html__( 'You can checkout top content(E.g: Coupon form, login form etc)', smw_slug ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => smw_elementor_template()
                ),

                array(
                    'name'    => 'productthankyoupage',
                    'label'   => esc_html__( 'Thank You Page Template', smw_slug ),
                    'desc'    => esc_html__( 'You can select Custom thank you page layout', smw_slug ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => smw_elementor_template()
                ),

                array(
                    'name'    => 'productmyaccountpage',
                    'label'   => esc_html__( 'My Account Page Template', smw_slug ),
                    'desc'    => esc_html__( 'You can select Custom my account page layout', smw_slug ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => smw_elementor_template()
                ),

                array(
                    'name'    => 'productmyaccountloginpage',
                    'label'   => esc_html__( 'My Account Login page Template', smw_slug ),
                    'desc'    => esc_html__( 'You can select Custom my account login page layout', smw_slug ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => smw_elementor_template()
                ),

                array(
                    'name'    => 'productquickview',
                    'label'   => esc_html__( 'Product Quick View Template', smw_slug ),
                    'desc'    => esc_html__( 'You can select Custom quick view layout', smw_slug ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => smw_elementor_template()
                ),

            ),

            //start of modules tab
            'smw_elements_tabs' => array(
                array(
                    'name'  => 'advanced-banner',
                    'label'  => esc_html__( 'Advanced Banner', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),

                array(
                    'name'  => 'advanced-button',
                    'label'  => esc_html__( 'Advanced Button', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),

                array(
                    'name'  => 'advanced-menu',
                    'label'  => esc_html__( 'Advanced Menu', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),

                array(
                    'name'  => 'advanced-tabs',
                    'label'  => esc_html__( 'Advanced Tabs', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'countdown-timer',
                    'label'  => esc_html__( 'Countdown Timer', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'dual-buttons',
                    'label'  => esc_html__( 'Dual Buttons', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'multi-buttons',
                    'label'  => esc_html__( 'Multi Buttons', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'faq',
                    'label'  => esc_html__( 'FAQ', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'advanced-form',
                    'label'  => esc_html__( 'Advanced Form', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'google-maps',
                    'label'  => esc_html__( 'Google Maps', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'advanced-headings',
                    'label'  => esc_html__( 'Advanced Headings', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'dual-headings',
                    'label'  => esc_html__( 'Dual Headings', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'fancy-headings',
                    'label'  => esc_html__( 'Fancy Headings', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'image-button',
                    'label'  => esc_html__( 'Image Button', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'off-canvas',
                    'label'  => esc_html__( 'Off Canvas', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'progress-bar',
                    'label'  => esc_html__( 'Progress Bar', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'search',
                    'label'  => esc_html__( 'Search Form', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'team-member-carousel',
                    'label'  => esc_html__( 'Team Member: Carousel', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'team-members',
                    'label'  => esc_html__( 'Team Members', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'testimonials',
                    'label'  => esc_html__( 'Testimonials', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'login',
                    'label'  => esc_html__( 'Login Form', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'register',
                    'label'  => esc_html__( 'Register Form', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'reset-password',
                    'label'  => esc_html__( 'Reset Password Form', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'working-hours',
                    'label'  => esc_html__( 'Working Hours', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
                
                array(
                    'name'  => 'template-selector',
                    'label'  => esc_html__( 'Template Selector', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'smw_table_row',
                ),
            ),

            'smw_rename_label_tabs' => array(
                array(
                    'name'  => 'enablerenamelabel',
                    'label'  => esc_html__( 'Enable / Disable Rename Label', smw_slug ),
                    'desc'  => esc_html__( 'Enable', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'smw_table_row',
                ),

                array(
                    'name'      => 'shop_page_heading',
                    'heading'  => esc_html__( 'Shop Page', smw_slug ),
                    'type'      => 'title',
                ),

                array(
                    'name'        => 'smw_shop_add_to_cart_txt',
                    'label'       => esc_html__( 'Add to Basket Button Text', smw_slug ),
                    'desc'        => esc_html__( 'You can change the Add to Basket button text.', smw_slug ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Add to Basket', smw_slug )
                ),

                array(
                    'name'      => 'product_details_page_heading',
                    'heading'  => esc_html__( 'Product Details Page', smw_slug ),
                    'type'      => 'title',
                ),
                
                array(
                    'name'        => 'smw_add_to_cart_txt',
                    'label'       => __( 'Add to Basket Button Text', smw_slug ),
                    'desc'        => __( 'You can change the Add to Basket button Text.', smw_slug ),
                    'type'        => 'text',
                    'placeholder' => __( 'Add to Basket', smw_slug )
                ),
                
                array(
                    'name'        => 'smw_description_tab_menu_title',
                    'label'       => esc_html__( 'Description', smw_slug ),
                    'desc'        => esc_html__( 'You can change the description tab title.', smw_slug ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Description', smw_slug )
                ),
                
                array(
                    'name'        => 'smw_additional_information_tab_menu_title',
                    'label'       => esc_html__( 'Additional Information', smw_slug ),
                    'desc'        => esc_html__( 'You can change the additional information tab title.', smw_slug ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Additional Information', smw_slug )
                ),
                
                array(
                    'name'        => 'smw_reviews_tab_menu_title',
                    'label'       => esc_html__( 'Reviews', smw_slug ),
                    'desc'        => esc_html__( 'You can change the review tab title.', smw_slug ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Reviews', smw_slug )
                ),

                array(
                    'name'      => 'checkout_page_heading',
                    'heading'  => esc_html__( 'Checkout Page', smw_slug ),
                    'type'      => 'title',
                ),
                
                array(
                    'name'        => 'smw_checkout_placeorder_btn_txt',
                    'label'       => esc_html__( 'Place order', smw_slug ),
                    'desc'        => esc_html__( 'You can change the Place order field label.', smw_slug ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Place Order', smw_slug )
                ),

            ),

            'smw_sales_notification_tabs'=>array(
                array(
                    'name'  => 'enableresalenotification',
                    'label'  => esc_html__( 'Enable / Disable Sales Notification', smw_slug ),
                    'desc'  => esc_html__( 'Enable', smw_slug ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'smw_table_row',
                ),

                array(
                    'name'    => 'notification_content_type',
                    'label'   => esc_html__( 'Notification Content Type', smw_slug ),
                    'desc'    => esc_html__( 'Select Content Type', smw_slug ),
                    'type'    => 'radio',
                    'default' => 'actual',
                    'options' => array(
                        'actual' => esc_html__('Real',smw_slug),
                        'fakes'  => esc_html__('Fakes',smw_slug),
                    )
                ),

                array(
                    'name'    => 'noification_fake_data',
                    'label'   => esc_html__( 'Choose Template', smw_slug ),
                    'desc'    => esc_html__( 'Choose Template for fakes notification.', smw_slug ),
                    'type'    => 'multiselect',
                    'default' => '',
                    'options' => smw_elementor_template(),
                    'class'       => 'notification_fake',
                ),

                array(
                    'name'    => 'notification_pos',
                    'label'   => esc_html__( 'Position', smw_slug ),
                    'desc'    => esc_html__( 'Sale Notification Position on frontend.', smw_slug ),
                    'type'    => 'select',
                    'default' => 'bottomleft',
                    'options' => array(
                        'topleft'       => esc_html__( 'Top Left',smw_slug ),
                        'topright'      => esc_html__( 'Top Right',smw_slug ),
                        'bottomleft'    => esc_html__( 'Bottom Left',smw_slug ),
                        'bottomright'   => esc_html__( 'Bottom Right',smw_slug ),
                    ),
                ),

                array(
                    'name'    => 'notification_layout',
                    'label'   => esc_html__( 'Image Position', smw_slug ),
                    'desc'    => esc_html__( 'Notification Layout.', smw_slug ),
                    'type'    => 'select',
                    'default' => 'imageleft',
                    'options' => array(
                        'imageleft'       => esc_html__( 'Image Left',smw_slug ),
                        'imageright'      => esc_html__( 'Image Right',smw_slug ),
                    ),
                    'class'       => 'notification_real'
                ),

                array(
                    'name'    => 'notification_loadduration',
                    'label'   => esc_html__( 'Loading Time', smw_slug ),
                    'desc'    => esc_html__( 'Notification Loading duration.', smw_slug ),
                    'type'    => 'select',
                    'default' => '3',
                    'options' => array(
                        '2'     => esc_html__( '2 seconds',smw_slug ),
                        '3'     => esc_html__( '3 seconds',smw_slug ),
                        '4'     => esc_html__( '4 seconds',smw_slug ),
                        '5'     => esc_html__( '5 seconds',smw_slug ),
                        '6'     => esc_html__( '6 seconds',smw_slug ),
                        '7'     => esc_html__( '7 seconds',smw_slug ),
                        '8'     => esc_html__( '8 seconds',smw_slug ),
                        '9'     => esc_html__( '9 seconds',smw_slug ),
                        '10'    => esc_html__( '10 seconds',smw_slug ),
                        '20'    => esc_html__( '20 seconds',smw_slug ),
                        '30'    => esc_html__( '30 seconds',smw_slug ),
                        '40'    => esc_html__( '40 seconds',smw_slug ),
                        '50'    => esc_html__( '50 seconds',smw_slug ),
                        '60'    => esc_html__( '1 minute',smw_slug ),
                        '90'    => esc_html__( '1.5 minutes',smw_slug ),
                        '120'   => esc_html__( '2 minutes',smw_slug ),
                    ),
                ),

                array(
                    'name'    => 'notification_time_int',
                    'label'   => esc_html__( 'Time Interval', smw_slug ),
                    'desc'    => esc_html__( 'Time between notifications.', smw_slug ),
                    'type'    => 'select',
                    'default' => '4',
                    'options' => array(
                        '2'     =>esc_html__( '2 seconds',smw_slug ),
                        '4'     =>esc_html__( '4 seconds',smw_slug ),
                        '5'     =>esc_html__( '5 seconds',smw_slug ),
                        '6'     =>esc_html__( '6 seconds',smw_slug ),
                        '7'     =>esc_html__( '7 seconds',smw_slug ),
                        '8'     =>esc_html__( '8 seconds',smw_slug ),
                        '9'     =>esc_html__( '9 seconds',smw_slug ),
                        '10'    =>esc_html__( '10 seconds',smw_slug ),
                        '20'    =>esc_html__( '20 seconds',smw_slug ),
                        '30'    =>esc_html__( '30 seconds',smw_slug ),
                        '40'    =>esc_html__( '40 seconds',smw_slug ),
                        '50'    =>esc_html__( '50 seconds',smw_slug ),
                        '60'    =>esc_html__( '1 minute',smw_slug ),
                        '90'    =>esc_html__( '1.5 minutes',smw_slug ),
                        '120'   =>esc_html__( '2 minutes',smw_slug ),
                    ),
                ),

                array(
                    'name'              => 'notification_limit',
                    'label'             => esc_html__( 'Limit', smw_slug ),
                    'desc'              => esc_html__( 'Order Limit for notification.', smw_slug ),
                    'min'               => 1,
                    'max'               => 100,
                    'default'           => '5',
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'number',
                    'class'       => 'notification_real',
                ),

                array(
                    'name'    => 'notification_uptodate',
                    'label'   => esc_html__( 'Order Upto', smw_slug ),
                    'desc'    => esc_html__( 'Do not show purchases older than.', smw_slug ),
                    'type'    => 'select',
                    'default' => '7',
                    'options' => array(
                        '1'   => esc_html__( '1 day',smw_slug ),
                        '2'   => esc_html__( '2 days',smw_slug ),
                        '3'   => esc_html__( '3 days',smw_slug ),
                        '4'   => esc_html__( '4 days',smw_slug ),
                        '5'   => esc_html__( '5 days',smw_slug ),
                        '6'   => esc_html__( '6 days',smw_slug ),
                        '7'   => esc_html__( '1 week',smw_slug ),
                        '10'  => esc_html__( '10 days',smw_slug ),
                        '14'  => esc_html__( '2 weeks',smw_slug ),
                        '21'  => esc_html__( '3 weeks',smw_slug ),
                        '28'  => esc_html__( '4 weeks',smw_slug ),
                        '35'  => esc_html__( '5 weeks',smw_slug ),
                        '42'  => esc_html__( '6 weeks',smw_slug ),
                        '49'  => esc_html__( '7 weeks',smw_slug ),
                        '56'  => esc_html__( '8 weeks',smw_slug ),
                    ),
                    'class'       => 'notification_real',
                ),

                array(
                    'name'    => 'notification_inanimation',
                    'label'   => esc_html__( 'Animation In', smw_slug ),
                    'desc'    => esc_html__( 'Notification Enter Animation.', smw_slug ),
                    'type'    => 'select',
                    'default' => 'fadeInLeft',
                    'options' => array(
                        'bounce'            => esc_html__( 'bounce',smw_slug ),
                        'flash'             => esc_html__( 'flash',smw_slug ),
                        'pulse'             => esc_html__( 'pulse',smw_slug ),
                        'rubberBand'        => esc_html__( 'rubberBand',smw_slug ),
                        'shake'             => esc_html__( 'shake',smw_slug ),
                        'swing'             => esc_html__( 'swing',smw_slug ),
                        'tada'              => esc_html__( 'tada',smw_slug ),
                        'wobble'            => esc_html__( 'wobble',smw_slug ),
                        'jello'             => esc_html__( 'jello',smw_slug ),
                        'heartBeat'         => esc_html__( 'heartBeat',smw_slug ),
                        'bounceIn'          => esc_html__( 'bounceIn',smw_slug ),
                        'bounceInDown'      => esc_html__( 'bounceInDown',smw_slug ),
                        'bounceInLeft'      => esc_html__( 'bounceInLeft',smw_slug ),
                        'bounceInRight'     => esc_html__( 'bounceInRight',smw_slug ),
                        'bounceInUp'        => esc_html__( 'bounceInUp',smw_slug ),
                        'fadeIn'            => esc_html__( 'fadeIn',smw_slug ),
                        'fadeInDown'        => esc_html__( 'fadeInDown',smw_slug ),
                        'fadeInDownBig'     => esc_html__( 'fadeInDownBig',smw_slug ),
                        'fadeInLeft'        => esc_html__( 'fadeInLeft',smw_slug ),
                        'fadeInLeftBig'     => esc_html__( 'fadeInLeftBig',smw_slug ),
                        'fadeInRight'       => esc_html__( 'fadeInRight',smw_slug ),
                        'fadeInRightBig'    => esc_html__( 'fadeInRightBig',smw_slug ),
                        'fadeInUp'          => esc_html__( 'fadeInUp',smw_slug ),
                        'fadeInUpBig'       => esc_html__( 'fadeInUpBig',smw_slug ),
                        'flip'              => esc_html__( 'flip',smw_slug ),
                        'flipInX'           => esc_html__( 'flipInX',smw_slug ),
                        'flipInY'           => esc_html__( 'flipInY',smw_slug ),
                        'lightSpeedIn'      => esc_html__( 'lightSpeedIn',smw_slug ),
                        'rotateIn'          => esc_html__( 'rotateIn',smw_slug ),
                        'rotateInDownLeft'  => esc_html__( 'rotateInDownLeft',smw_slug ),
                        'rotateInDownRight' => esc_html__( 'rotateInDownRight',smw_slug ),
                        'rotateInUpLeft'    => esc_html__( 'rotateInUpLeft',smw_slug ),
                        'rotateInUpRight'   => esc_html__( 'rotateInUpRight',smw_slug ),
                        'slideInUp'         => esc_html__( 'slideInUp',smw_slug ),
                        'slideInDown'       => esc_html__( 'slideInDown',smw_slug ),
                        'slideInLeft'       => esc_html__( 'slideInLeft',smw_slug ),
                        'slideInRight'      => esc_html__( 'slideInRight',smw_slug ),
                        'zoomIn'            => esc_html__( 'zoomIn',smw_slug ),
                        'zoomInDown'        => esc_html__( 'zoomInDown',smw_slug ),
                        'zoomInLeft'        => esc_html__( 'zoomInLeft',smw_slug ),
                        'zoomInRight'       => esc_html__( 'zoomInRight',smw_slug ),
                        'zoomInUp'          => esc_html__( 'zoomInUp',smw_slug ),
                        'hinge'             => esc_html__( 'hinge',smw_slug ),
                        'jackInTheBox'      => esc_html__( 'jackInTheBox',smw_slug ),
                        'rollIn'            => esc_html__( 'rollIn',smw_slug ),
                        'rollOut'           => esc_html__( 'rollOut',smw_slug ),
                    ),
                ),

                array(
                    'name'    => 'notification_outanimation',
                    'label'   => esc_html__( 'Animation Out', smw_slug ),
                    'desc'    => esc_html__( 'Notification Out Animation.', smw_slug ),
                    'type'    => 'select',
                    'default' => 'fadeOutRight',
                    'options' => array(
                        'bounce'             => esc_html__( 'bounce',smw_slug ),
                        'flash'              => esc_html__( 'flash',smw_slug ),
                        'pulse'              => esc_html__( 'pulse',smw_slug ),
                        'rubberBand'         => esc_html__( 'rubberBand',smw_slug ),
                        'shake'              => esc_html__( 'shake',smw_slug ),
                        'swing'              => esc_html__( 'swing',smw_slug ),
                        'tada'               => esc_html__( 'tada',smw_slug ),
                        'wobble'             => esc_html__( 'wobble',smw_slug ),
                        'jello'              => esc_html__( 'jello',smw_slug ),
                        'heartBeat'          => esc_html__( 'heartBeat',smw_slug ),
                        'bounceOut'          => esc_html__( 'bounceOut',smw_slug ),
                        'bounceOutDown'      => esc_html__( 'bounceOutDown',smw_slug ),
                        'bounceOutLeft'      => esc_html__( 'bounceOutLeft',smw_slug ),
                        'bounceOutRight'     => esc_html__( 'bounceOutRight',smw_slug ),
                        'bounceOutUp'        => esc_html__( 'bounceOutUp',smw_slug ),
                        'fadeOut'            => esc_html__( 'fadeOut',smw_slug ),
                        'fadeOutDown'        => esc_html__( 'fadeOutDown',smw_slug ),
                        'fadeOutDownBig'     => esc_html__( 'fadeOutDownBig',smw_slug ),
                        'fadeOutLeft'        => esc_html__( 'fadeOutLeft',smw_slug ),
                        'fadeOutLeftBig'     => esc_html__( 'fadeOutLeftBig',smw_slug ),
                        'fadeOutRight'       => esc_html__( 'fadeOutRight',smw_slug ),
                        'fadeOutRightBig'    => esc_html__( 'fadeOutRightBig',smw_slug ),
                        'fadeOutUp'          => esc_html__( 'fadeOutUp',smw_slug ),
                        'fadeOutUpBig'       => esc_html__( 'fadeOutUpBig',smw_slug ),
                        'flip'               => esc_html__( 'flip',smw_slug ),
                        'flipOutX'           => esc_html__( 'flipOutX',smw_slug ),
                        'flipOutY'           => esc_html__( 'flipOutY',smw_slug ),
                        'lightSpeedOut'      => esc_html__( 'lightSpeedOut',smw_slug ),
                        'rotateOut'          => esc_html__( 'rotateOut',smw_slug ),
                        'rotateOutDownLeft'  => esc_html__( 'rotateOutDownLeft',smw_slug ),
                        'rotateOutDownRight' => esc_html__( 'rotateOutDownRight',smw_slug ),
                        'rotateOutUpLeft'    => esc_html__( 'rotateOutUpLeft',smw_slug ),
                        'rotateOutUpRight'   => esc_html__( 'rotateOutUpRight',smw_slug ),
                        'slideOutUp'         => esc_html__( 'slideOutUp',smw_slug ),
                        'slideOutDown'       => esc_html__( 'slideOutDown',smw_slug ),
                        'slideOutLeft'       => esc_html__( 'slideOutLeft',smw_slug ),
                        'slideOutRight'      => esc_html__( 'slideOutRight',smw_slug ),
                        'zoomOut'            => esc_html__( 'zoomOut',smw_slug ),
                        'zoomOutDown'        => esc_html__( 'zoomOutDown',smw_slug ),
                        'zoomOutLeft'        => esc_html__( 'zoomOutLeft',smw_slug ),
                        'zoomOutRight'       => esc_html__( 'zoomOutRight',smw_slug ),
                        'zoomOutUp'          => esc_html__( 'zoomOutUp',smw_slug ),
                        'hinge'              => esc_html__( 'hinge',smw_slug ),
                    ),
                ),
                
                array(
                    'name'  => 'background_color',
                    'label' => esc_html__( 'Background Color', smw_slug ),
                    'desc'  => wp_kses_post( 'Notification Background Color.', smw_slug ),
                    'type'  => 'color',
                    'class' => 'notification_real',
                ),

                array(
                    'name'  => 'heading_color',
                    'label' => esc_html__( 'Heading Color', smw_slug ),
                    'desc'  => wp_kses_post( 'Notification Heading Color.', smw_slug ),
                    'type'  => 'color',
                    'class' => 'notification_real',
                ),

                array(
                    'name'  => 'content_color',
                    'label' => esc_html__( 'Content Color', smw_slug ),
                    'desc'  => wp_kses_post( 'Notification Content Color.', smw_slug ),
                    'type'  => 'color',
                    'class' => 'notification_real',
                ),

                array(
                    'name'  => 'cross_color',
                    'label' => esc_html__( 'Cross Icon Color', smw_slug ),
                    'desc'  => wp_kses_post( 'Notification Cross Icon Color.', smw_slug ),
                    'type'  => 'color'
                ),

            ),

            'smw_others_tabs'=>array(
                array(
                    'name'  => 'loadproductlimit',
                    'label' => esc_html__( 'Load Products in Elementor Widget', smw_slug ),
                    'desc'  => wp_kses_post( 'Load Products in Elementor Widget.', smw_slug ),
                    'min'               => 1,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'default'           => '20',
                    'sanitize_callback' => 'floatval'
                ),
                
                array(
                    'name'   => 'ajaxsearch',
                    'label'  => esc_html__( 'Ajax Search Widget', smw_slug ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'smw_table_row',
                ),
                
                array(
                    'name'   => 'languagetranslator',
                    'label'  => esc_html__( 'Language translator', smw_slug ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'smw_table_row',
                ),

                array(
                    'name'   => 'ajaxcart_singleproduct',
                    'label'  => esc_html__( 'Single Product Ajax Add To Cart', smw_slug ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'smw_table_row',
                ),

                array(
                    'name'   => 'single_product_sticky_add_to_cart',
                    'label'  => esc_html__( 'Single Product Sticky Add To Cart', smw_slug ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'smw_table_row',
                ),

                array(
                    'name'   => 'mini_side_cart',
                    'label'  => esc_html__( 'Side Mini Cart', smw_slug ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'smw_table_row',
                ),

                array(
                    'name'    => 'mini_cart_position',
                    'label'   => esc_html__( 'Mini Cart Position', smw_slug ),
                    'desc'    => esc_html__( 'Mini cart position on frontend.', smw_slug ),
                    'type'    => 'select',
                    'default' => 'left',
                    'options' => array(
                        'left'   => esc_html__( 'Left',smw_slug ),
                        'right'  => esc_html__( 'Right',smw_slug ),
                    ),
                ),
                
                array(
                    'name'   => 'user_switching',
                    'label'  => esc_html__( 'User Switching', smw_slug ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'smw_table_row',
                ),
                
                array(
                    'name'   => 'image_flipper',
                    'label'  => esc_html__( 'WooCommerce Image Flipper', smw_slug ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'smw_table_row',
                ),
            ),
        );

        // Post Duplicator Condition
        
        $settings_fields['smw_others_tabs'][] = [
            'name'  => 'postduplicator',
            'label'  => esc_html__( 'Post Duplicator', smw_slug ),
            'type'  => 'checkbox',
            'default'=>'off',
            'class'=>'smw_table_row',
        ];

        // Extra Addons
        if( smw_get_option( 'ajaxsearch', 'smw_others_tabs', 'off' ) == 'on' )
        {
            $settings_fields['smw_elements_tabs'][] = [
                'name'    => 'wc-ajax-search',
                'label'   => __( 'Ajax Product Search Form', smw_slug ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'   => 'smw_table_row',
            ];
        }
        
        if( smw_get_option( 'languagetranslator', 'smw_others_tabs', 'off' ) == 'on' )
        {
            $settings_fields['smw_elements_tabs'][] = [
                'name'    => 'language-translator',
                'label'   => __( 'Website Translator', smw_slug ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'   => 'smw_table_row',
            ];
        }
        
        //register our checkboxes for our WooCommerce Widgets
        //Only show if WooCommerce is active
        if ( class_exists( 'woocommerce' ) )
        {
            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-categories',
                'label'  => esc_html__( 'Category List', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-brand',
                'label'  => esc_html__( 'Brand Logo', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-product-archive',
                'label'  => esc_html__( 'Product Archive', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-product-title',
                'label'  => esc_html__( 'Product Title', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-related',
                'label'  => esc_html__( 'Related Products', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];
          
           $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-related-advanced',
                'label'  => esc_html__( 'Related Products: Advanced', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-add-to-cart',
                'label'  => esc_html__( 'Add To Cart', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-add-to-cart-advanced',
                'label'  => esc_html__( 'Add To Cart: Advanced', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-additional-information',
                'label'  => esc_html__( 'Additional Information', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-data-tabs',
                'label'  => esc_html__( 'Product Data Tabs', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-description',
                'label'  => esc_html__( 'Product Description', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-short-description',
                'label'  => esc_html__( 'Product Short Description', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-price',
                'label'  => esc_html__( 'Product Price', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-rating',
                'label'  => esc_html__( 'Product Rating', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-reviews',
                'label'  => esc_html__( 'Product Reviews', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-product-image',
                'label'  => esc_html__( 'Product Image', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-video-gallery',
                'label'  => esc_html__( 'Product Video Gallery', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];
           
            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-universal-product',
                'label'  => esc_html__( 'Universal Product Layout', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-product-stock',
                'label'  => esc_html__( 'Product Stock Status', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-product-meta',
                'label'  => esc_html__( 'Product Meta Info', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-product-call-for-price',
                'label'  => esc_html__( 'Call For Price', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-suggest-price',
                'label'  => esc_html__( 'Suggest Price', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-cart-table',
                'label'  => esc_html__( 'Product Cart Table', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];
            
            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-cart-total',
                'label'  => esc_html__( 'Cart Total', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-cart-empty-message',
                'label'  => esc_html__( 'Empty Cart Message', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-cart-empty-shop-redirect',
                'label'  => esc_html__( 'Empty Cart Redirect Button', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-cross-sell',
                'label'  => esc_html__( 'Product Cross Sell', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-cross-sell-advanced',
                'label'  => esc_html__( 'Product Cross Sell: Advanced', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-checkout-additional-form',
                'label'  => esc_html__( 'Checkout: Additional Info', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-checkout-billing',
                'label'  => esc_html__( 'Checkout: Billing Form', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-checkout-shipping-form',
                'label'  => esc_html__( 'Checkout: Shipping Form', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-checkout-payment',
                'label'  => esc_html__( 'Checkout: Payment', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-checkout-coupon-form',
                'label'  => esc_html__( 'Checkout: Coupon Form', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-checkout-login-form',
                'label'  => esc_html__( 'Checkout: Login Form', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-order-review',
                'label'  => esc_html__( 'Checkout: Order Review', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-my-account-account',
                'label'  => esc_html__( 'My Account', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-my-account-dashboard',
                'label'  => esc_html__( 'My Account: Dashboard', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-my-account-download',
                'label'  => esc_html__( 'My Account: Download', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-my-account-edit-account',
                'label'  => esc_html__( 'My Account: Edit', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-my-account-address',
                'label'  => esc_html__( 'My Account: Address', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-my-account-login-form',
                'label'  => esc_html__( 'My Account: Login Form', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-my-account-register-form',
                'label'  => esc_html__( 'My Account: Registration', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-my-account-logout',
                'label'  => esc_html__( 'My Account: Logout', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-my-account-order',
                'label'  => esc_html__( 'My Account: Order', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-thank-you-order',
                'label'  => esc_html__( 'Thank You: Order', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-thank-you-customer-address-details',
                'label'  => esc_html__( 'Thank You: Address', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-thank-you-order-details',
                'label'  => esc_html__( 'Thank You: Order Details', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-product-advance-thumbnails',
                'label'  => __( 'Product Image: Advanced', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-social-share',
                'label'  => esc_html__( 'Product Social Share', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-stock-progress-bar',
                'label'  => esc_html__( 'Stock Progress Bar', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-single-product-sale-schedule',
                'label'  => esc_html__( 'Product Sale Schedule', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];
          
           $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-upsell',
                'label'  => esc_html__( 'Product Upsell', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];
            

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-upsell-advanced',
                'label'  => esc_html__( 'Product Upsell: Advanced', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];

            $settings_fields['smw_elements_tabs'][] = 
            [
                'name'  => 'wc-quick-view-product-image',
                'label'  => esc_html__( 'Quick view: Image', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];
        }
                
        //If user has mailchimp installed show the newsletter
        if ( function_exists('mc4wp') ) 
        {       
            $settings_fields['smw_elements_tabs'][] = 
            [        
                'name'  => 'newsletter',
                'label'  => esc_html__( 'Newsletter', smw_slug ),
                'type'  => 'checkbox',
                'default' => 'on',
                'class'=>'smw_table_row',
            ];
        }
        
        return array_merge( $settings_fields );
    }


    function plugin_page() 
    {
        echo '<div class="wrap">';
            echo '<h2>'.esc_html__( 'Stiles Media Widgets Settings',smw_slug ).'</h2>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';

    }

    function save_message() 
    {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Successfully Saved Your Settings.', smw_slug) ?></strong></p>
            </div>
            <?php
        }
    }
    // Custom Markup

    // Element Toogle Button
    function html_element_toogle_button()
    {
        ob_start();
        ?>
            <span class="smopen-element-toggle"><?php esc_html_e( 'Toggle All', smw_slug );?></span>
            <script type="text/javascript">
                (function($)
                {
                    $(function() 
                    {
                        $('.smopen-element-toggle').on('click', function() 
                        {
                          var inputCheckbox = $('#smw_elements_tabs').find('.smw_table_row input[type="checkbox"]');
                          if(inputCheckbox.prop("checked") === true)
                          {
                            inputCheckbox.prop('checked', false)
                          } else 
                          {
                            inputCheckbox.prop('checked', true)
                          }
                        });
                    });
                } )( jQuery );
            </script>
        <?php
        echo ob_get_clean();
    }
}

new smw_Admin_Settings();