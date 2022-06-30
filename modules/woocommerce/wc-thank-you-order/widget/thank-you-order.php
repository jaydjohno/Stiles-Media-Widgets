<?php

/**
 * Stiles Media Widgets Thank You: Order.
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

class stiles_wc_thank_you_order extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-thank-you-order';
    }
    
    public function get_title() 
    {
        return __( 'Thank You: Order', smw_slug );
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
        $this->thank_you_content();
        
        $this->thank_you_message();
        
        $this->thank_you_label();
        
        $this->thank_you_details();
    }
    
    protected function thank_you_content()
    {
        $this->start_controls_section(
            'order_thankyou_content',
            [
                'label' => __( 'Thank you order', smw_slug ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            
            $this->add_control(
                'order_thankyou_message',
                [
                    'label'     => __( 'Thank you message', smw_slug ),
                    'type'      => Controls_Manager::TEXTAREA,
                    'default' => __( 'Thank you. Your order has been received.', smw_slug ),
                ]
            );

        $this->end_controls_section();
    }
    
    protected function thank_you_message()
    {
        // Order Thankyou Message
        $this->start_controls_section(
            'order_thankyou_message_style',
            array(
                'label' => __( 'Thank You Message', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_control(
                'order_thankyou_message_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-thankyou-order-received' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'order_thankyou_message_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .woocommerce-thankyou-order-received',
                )
            );

            $this->add_responsive_control(
                'order_thankyou_message_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-thankyou-order-received' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'order_thankyou_message_align',
                [
                    'label'        => __( 'Alignment', smw_slug ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-thankyou-order-received' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function thank_you_label()
    {
        // Order Thankyou Label
        $this->start_controls_section(
            'order_thankyou_label_style',
            array(
                'label' => __( 'Order Label', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'order_thankyou_label_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} ul.order_details li' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'order_thankyou_label_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} ul.order_details li',
                )
            );

            $this->add_responsive_control(
                'order_thankyou_label_align',
                [
                    'label'        => __( 'Alignment', smw_slug ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} ul.order_details li' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function thank_you_details()
    {
        // Order Thankyou Details
        $this->start_controls_section(
            'order_thankyou_details_style',
            array(
                'label' => __( 'Order Details', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'order_thankyou_details_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} ul.order_details li strong' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'order_thankyou_details_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} ul.order_details li strong',
                )
            );

            $this->add_responsive_control(
                'order_thankyou_details_align',
                [
                    'label'        => __( 'Alignment', smw_slug ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} ul.order_details li strong' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function render()
    {
       $settings = $this->get_settings_for_display();

        global $wp;
        
        $order_thankyou_message = $settings['order_thankyou_message'];
        
        if( isset($wp->query_vars['order-received']) )
        {
            $received_order_id = $wp->query_vars['order-received'];
        }else
        {
            $received_order_id = stiles_get_last_order_id();
        }
        
        $order = wc_get_order( $received_order_id );

        ?>
        <?php if ( $order ) : ?>
            <?php if ( $order->has_status( 'failed' ) ) : ?>
                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', smw_slug ); ?></p>
        
                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', smw_slug ) ?></a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', smw_slug ); ?></a>
                    <?php endif; ?>
                </p>
            <?php else : ?>
        
                <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', $order_thankyou_message, $order ); ?></p>
        
                <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
                    <li class="woocommerce-order-overview__order order">
                        <?php esc_html_e( 'Order number:', smw_slug ); ?>
                        <strong><?php echo $order->get_order_number(); ?></strong>
                    </li>
        
                    <li class="woocommerce-order-overview__date date">
                        <?php esc_html_e( 'Date:', smw_slug ); ?>
                        <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
                    </li>
        
                    <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                        <li class="woocommerce-order-overview__email email">
                            <?php esc_html_e( 'Email:', smw_slug ); ?>
                            <strong><?php echo $order->get_billing_email(); ?></strong>
                        </li>
                    <?php endif; ?>
        
                    <li class="woocommerce-order-overview__total total">
                        <?php esc_html_e( 'Total:', smw_slug ); ?>
                        <strong><?php echo $order->get_formatted_order_total(); ?></strong>
                    </li>
        
                    <?php if ( $order->get_payment_method_title() ) : ?>
                        <li class="woocommerce-order-overview__payment-method method">
                            <?php esc_html_e( 'Payment method:', smw_slug ); ?>
                            <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
                        </li>
                    <?php endif; ?>
        
                </ul>
        
            <?php endif;
        
            do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
        
        <?php else : ?>
        
            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', $order_thankyou_message, null ); ?></p>
        
        <?php endif;
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_thank_you_order() );