<?php

/**
 * Stiles Media Widgets My Account: Dashboard.
 *
 * @package SMW
 */
 
namespace StilesMediaWidgets;

if ( ! defined( 'ABSPATH' ) ) 
{
	exit;   // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Base;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Widget_Base;

class stiles_wc_my_account_dashboard extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-my-account-dashboard';
    }
    
    public function get_title() 
    {
        return __( 'My Account: Dashboard', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-woocommerce';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        // Style
        $this->start_controls_section(
            'myaccount_content_style',
            array(
                'label' => __( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_control(
                'myaccount_text_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}}' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'myaccount_link_color',
                [
                    'label' => __( 'Link Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'myaccount_text_typography',
                    'selector' => '{{WRAPPER}}',
                ]
            );
            
            $this->add_responsive_control(
                'myaccount_alignment',
                [
                    'label' => __( 'Alignment', smw_slug ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', smw_slug ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'prefix_class' => 'elementor%s-align-',
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}}' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function render() 
    {
        $current_user = wp_get_current_user();
        $url = home_url();
     
        if ( Plugin::instance()->editor->is_edit_mode() ) 
        {
        ?>
            <p>
            	<?php
            	printf(
            		/* translators: 1: user display name 2: logout url */
            		__( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ),
            		'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
            		esc_url( wc_logout_url() )
            	);
            	?>
            </p><br/>
            
            <p>
            	<?php
            	    $user = wp_get_current_user();
            	    
            	    if( $user && in_array( 'store_manager', $user->roles ) )
                    {
                        echo 'Welcome to the Family Connects Management Portal from this portal you can view your reports, input your sales information and manage your staff';
                        
                        echo '<br/><br/>';
                        
                        echo 'Please ensure when using this portal that you save your information, you should get a message saying saved successfully, if this does not happen then try again.';
                        
                        echo '<br/><br/>';
                        
                        echo 'If you continue to have issues then contact Masih Family who will be able to help further';
                    }
                    if( $user && in_array( 'multi_manager', $user->roles ) )
                    {
                        echo 'Welcome to the Family Connects Management Portal from this portal you can view your reports, input your sales information and manage your staff';
                        
                        echo '<br/><br/>';
                        
                        echo 'As you are a multi site manager, you need to set the store that you wish to manage when looking at users, reports etc, if this is not set you will not see the relevant information.';
                        
                        echo '<br/><br/>';
                        
                        echo 'Please ensure when using this portal that you save your information, you should get a message saying saved successfully, if this does not happen then try again.';
                        
                        echo '<br/><br/>';
                        
                        echo 'If you continue to have issues then contact Masih Family who will be able to help further';
                    }
                    if( $user && in_array( 'senior_manager', $user->roles ) )
                    {
                        echo 'Welcome to the Family Connects Management Portal from this portal you can view reports, view sales information and manage staff';
                        
                        echo '<br/><br/>';
                        
                        echo 'Please ensure when using this portal that you save your information, you should get a message saying saved successfully, if this does not happen then try again.';
                        
                        echo '<br/><br/>';
                        
                        echo 'If you continue to have issues then contact Masih Family who will be able to help further';
                    }
                    elseif( $user && in_array( 'employee', $user->roles ) )
                    {
                        echo 'Welcome to the Family Connects User Portal, from this portal you can check your employee details, browse your current sales target and how close you are to achieving it.';
                        
                	    echo '<br/><br/>';
                	    
                	    echo 'If there is any issue with your employee details, or you believe your sales target or sales figures are wrong then speak to your store manager who can have a look at this for you.';
                    }
                    elseif( $user && in_array( 'administrator', $user->roles ) )
                    {
                        printf(
                    		__( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' ),
                    		esc_url( wc_get_endpoint_url( 'orders' ) ),
                    		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
                    		esc_url( wc_get_endpoint_url( 'edit-account' ) )
                    	);
                    }
            	?>
            </p>
            
            <?php
            	/**
            	 * My Account dashboard.
            	 *
            	 * @since 2.6.0
            	 */
            	do_action( 'woocommerce_account_dashboard' );
            
            	/**
            	 * Deprecated woocommerce_before_my_account action.
            	 *
            	 * @deprecated 2.6.0
            	 */
            	do_action( 'woocommerce_before_my_account' );
            
            	/**
            	 * Deprecated woocommerce_after_my_account action.
            	 *
            	 * @deprecated 2.6.0
            	 */
            	do_action( 'woocommerce_after_my_account' );
            
            /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

        }else
        {
            if ( ! is_user_logged_in() ) 
            { 
                return __('You need to be logged in to view this page', smw_slug); 
            }
            	printf(
            		/* translators: 1: user display name 2: logout url */
            		__( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ),
            		'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
            		esc_url( wc_logout_url() )
            	);
            	?>
            </p>
            
            <p>
            	<?php
            	    $user = wp_get_current_user();
            
            	    if( $user && in_array( 'store_manager', $user->roles ) )
                    {
                        echo 'Welcome to the Family Connects Management Portal from this portal you can view your reports, input your sales information and manage your staff';
                        
                        echo '<br/><br/>';
                        
                        echo 'Please ensure when using this portal that you save your information, you should get a message saying saved successfully, if this does not happen then try again.';
                        
                        echo '<br/><br/>';
                        
                        echo 'If you continue to have issues then contact Masih Family who will be able to help further';
                    }
                    if( $user && in_array( 'multi_manager', $user->roles ) )
                    {
                        echo 'Welcome to the Family Connects Management Portal from this portal you can view your reports, input your sales information and manage your staff';
                        
                        echo '<br/><br/>';
                        
                        echo 'As you are a multi site manager, you need to set the store that you wish to manage when looking at users, reports etc, if this is not set you will not see the relevant information.';
                        
                        echo '<br/><br/>';
                        
                        echo 'Please ensure when using this portal that you save your information, you should get a message saying saved successfully, if this does not happen then try again.';
                        
                        echo '<br/><br/>';
                        
                        echo 'If you continue to have issues then contact Masih Family who will be able to help further';
                    }
                    if( $user && in_array( 'senior_manager', $user->roles ) )
                    {
                        echo 'Welcome to the Family Connects Management Portal from this portal you can view reports, view sales information and manage staff';
                        
                        echo '<br/><br/>';
                        
                        echo 'Please ensure when using this portal that you save your information, you should get a message saying saved successfully, if this does not happen then try again.';
                        
                        echo '<br/><br/>';
                        
                        echo 'If you continue to have issues then contact Masih Family who will be able to help further';
                    }
                    elseif( $user && in_array( 'employee', $user->roles ) )
                    {
                        echo 'Welcome to the Family Connects User Portal, from this portal you can check your employee details, browse your current sales target and how close you are to achieving it.';
                        
                	    echo '<br/><br/>';
                	    
                	    echo 'If there is any issue with your employee details, or you believe your sales target or sales figures are wrong then speak to your store manager who can have a look at this for you.';
                    }
                    elseif( $user && in_array( 'administrator', $user->roles ) )
                    {
                        printf(
                    		__( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' ),
                    		esc_url( wc_get_endpoint_url( 'orders' ) ),
                    		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
                    		esc_url( wc_get_endpoint_url( 'edit-account' ) )
                    	);
                    }
            	?>
            </p>
            
            <?php
            	/**
            	 * My Account dashboard.
            	 *
            	 * @since 2.6.0
            	 */
            	do_action( 'woocommerce_account_dashboard' );
            
            	/**
            	 * Deprecated woocommerce_before_my_account action.
            	 *
            	 * @deprecated 2.6.0
            	 */
            	do_action( 'woocommerce_before_my_account' );
            
            	/**
            	 * Deprecated woocommerce_after_my_account action.
            	 *
            	 * @deprecated 2.6.0
            	 */
            	do_action( 'woocommerce_after_my_account' );
            
            /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_my_account_dashboard() );