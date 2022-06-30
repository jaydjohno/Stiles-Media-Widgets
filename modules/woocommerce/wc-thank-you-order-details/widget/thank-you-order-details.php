<?php

/**
 * Stiles Media Widgets Thank You: Order Details.
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

class stiles_wc_thank_you_order_details extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-thank-you-order-details';
    }
    
    public function get_title() 
    {
        return __( 'Thank You: Order Details', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-woocommerce';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function order_heading()
    {
        // Heading
        $this->start_controls_section(
            'order_details_heading_style',
            array(
                'label' => __( 'Heading', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_control(
                'order_details_heading_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-order-details .woocommerce-order-details__title' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'order_details_heading_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .woocommerce-order-details .woocommerce-order-details__title',
                )
            );

            $this->add_responsive_control(
                'order_details_heading_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-order-details .woocommerce-order-details__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'order_details_heading_align',
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
                        '{{WRAPPER}} .woocommerce-order-details .woocommerce-order-details__title' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function table_content()
    {
        // Table Content
        $this->start_controls_section(
            'order_details_table_content_style',
            array(
                'label' => __( 'Table Content', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_control(
                'order_details_table_heading',
                [
                    'label' => __( 'Table Heading', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_control(
                'order_details_table_heading_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-order-details .order_details th' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .woocommerce-order-details .order_details tfoot td' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'order_details_table_heading_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .woocommerce-order-details .order_details th, {{WRAPPER}} .woocommerce-order-details .order_details tfoot td',
                )
            );

            $this->add_responsive_control(
                'order_details_table_heading_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-order-details .order_details th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} {{WRAPPER}} .woocommerce-order-details .order_details tfoot td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'order_details_table_content_heading',
                [
                    'label' => __( 'Table Content', smw_slug ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_control(
                'order_details_table_content_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-order-details .order_details td' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'order_details_table_content_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .woocommerce-order-details .order_details td',
                )
            );

            $this->add_control(
                'order_details_table_content_link_color',
                [
                    'label' => __( 'Link Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-order-details .order_details td a' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .woocommerce-order-details .order_details td strong' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'order_details_table_content_link_hover_color',
                [
                    'label' => __( 'Link Hover Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-order-details .order_details td a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'order_details_table_content_border_color',
                [
                    'label' => __( 'Border Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-order-details .order_details' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}} .woocommerce-order-details .order_details td' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}} .woocommerce-order-details .order_details th' => 'border-color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function register_controls() 
    {
        $this->order_heading();
        
        $this->table_content();
    }
    
    protected function render()
    {
       global $wp;
        
        if( isset( $wp->query_vars['order-received'] ) )
        {
            $received_order_id = $wp->query_vars['order-received'];
        }else
        {
           $received_order_id = stiles_get_last_order_id();
        }

        if( ! $received_order_id )
        { 
            return; 
        }
        
        $order = wc_get_order( $received_order_id );
        $order_id = $order->get_id();
        
        
        if ( ! $order = wc_get_order( $order_id ) ) 
        { 
            return; 
        }
        
        $order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
        $show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
        $show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
        $downloads             = $order->get_downloadable_items();
        $show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();
        
        if ( $show_downloads ) 
        {
            wc_get_template( 'order/order-downloads.php', array( 'downloads' => $downloads, 'show_title' => true ) );
        }
        
        ?>
        <section class="woocommerce-order-details">
            <?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>
        
            <h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Order details', smw_slug ); ?></h2>
        
            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
        
                <thead>
                    <tr>
                        <th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', smw_slug ); ?></th>
                        <th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', smw_slug ); ?></th>
                    </tr>
                </thead>
        
                <tbody>
                    <?php
                    do_action( 'woocommerce_order_details_before_order_table_items', $order );
        
                    foreach ( $order_items as $item_id => $item ) 
                    {
                        $product = $item->get_product();
                        wc_get_template( 'order/order-details-item.php', array(
                            'order'              => $order,
                            'item_id'            => $item_id,
                            'item'               => $item,
                            'show_purchase_note' => $show_purchase_note,
                            'purchase_note'      => $product ? $product->get_purchase_note() : '',
                            'product'            => $product,
                        ) );
                    }
        
                    do_action( 'woocommerce_order_details_after_order_table_items', $order );
                    ?>
                </tbody>
        
                <tfoot>
                    <?php
                        foreach ( $order->get_order_item_totals() as $key => $total ) 
                        {
                            ?>
                            <tr>
                                <th scope="row"><?php echo $total['label']; ?></th>
                                <td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : $total['value']; ?></td>
                            </tr>
                            <?php
                        }
                    ?>
                    <?php if ( $order->get_customer_note() ) : ?>
                        <tr>
                            <th><?php esc_html_e( 'Note:', smw_slug ); ?></th>
                            <td><?php echo wptexturize( $order->get_customer_note() ); ?></td>
                        </tr>
                    <?php endif; ?>
                </tfoot>
            </table>
        
            <?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
        </section>
        
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_thank_you_order_details() );