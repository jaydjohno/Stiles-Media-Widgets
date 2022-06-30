<?php

/**
 * Stiles Media Widgets Add to Cart.
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
use Elementor\Repeater;

class stiles_wc_checkout_additional extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-checkout-additional';
    }
    
    public function get_title() 
    {
        return __( 'WC Checkout: Additional', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-form-horizontal';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function additional_form()
    {
        $this->start_controls_section(
            'section_additional_content',
            [
                'label' => esc_html__( 'Additional Form', smw_slug ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            
            $this->add_control(
                'form_title',
                [
                    'label' => esc_html__( 'Title', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Additional information', smw_slug ),
                    'placeholder' => esc_html__( 'Type your title here', smw_slug ),
                    'label_block' => true,
                ]
            );

        $this->end_controls_section();
    }
    
    protected function additional_fields()
    {
        // Manage Additional Field
        $this->start_controls_section(
            'section_additional_fields',
            [
                'label' => esc_html__( 'Manage Field', smw_slug ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            
            $this->add_control(
                'modify_field',
                [
                    'label' => esc_html__( 'Modify Field', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Yes', smw_slug ),
                    'label_off' => esc_html__( 'No', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'field_key',
                [
                    'label' => esc_html__( 'Field name', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'order_comments',
                    'options' => [
                        'order_comments'=> esc_html__( 'Order Notes', smw_slug ),
                        'customadd' => esc_html__( 'Add Custom', smw_slug ),
                    ],
                ]
            );

            $repeater->add_control(
                'field_label', 
                [
                    'label' => esc_html__( 'Label', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Custom Field name' , smw_slug ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'field_placeholder', 
                [
                    'label' => esc_html__( 'Placeholder', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Custom Field name' , smw_slug ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'field_default_value', 
                [
                    'label' => esc_html__( 'Default Value', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Custom Field name' , smw_slug ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'field_validation',
                [
                    'label' => esc_html__( 'Validation', smw_slug ),
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => [
                        'email'     => esc_html__( 'Email', smw_slug ),
                        'phone'     => esc_html__( 'Phone', smw_slug ),
                        'postcode'  => esc_html__( 'Postcode', smw_slug ),
                        'state'     => esc_html__( 'State', smw_slug ),
                        'number'    => esc_html__( 'Number', smw_slug ),
                    ],
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'field_class', 
                [
                    'label' => esc_html__( 'Class', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'notes' , smw_slug ),
                    'description' => esc_html__( 'You can use ( form-row-first,form-row-last,form-row-wide,notes )' , smw_slug ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'field_key_custom', 
                [
                    'label' => esc_html__( 'Custom key', smw_slug ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'customkey' , smw_slug ),
                    'label_block' => true,
                    'condition'=>[
                        'field_key'=>'customadd',
                    ],
                ]
            );

            $repeater->add_control(
                'field_type',
                [
                    'label' => __( 'Field Type', smw_slug ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'textarea',
                    'options' => [
                        'text'      => esc_html__( 'Text', smw_slug ),
                        'password'  => esc_html__( 'Password', smw_slug ),
                        'email'     => esc_html__( 'Email', smw_slug ),
                        'tel'       => esc_html__( 'Tel', smw_slug ),
                        'textarea'  => esc_html__( 'Textarea', smw_slug ),
                        'select'    => esc_html__( 'Select', smw_slug ),
                        'radio'     => esc_html__( 'Radio', smw_slug ),
                    ],
                    'condition'=>[
                        'field_key'=>'customadd',
                    ],
                ]
            );

            $repeater->add_control(
                'field_options',
                [
                    'label' => esc_html__( 'Options', smw_slug ),
                    'type' => Controls_Manager::TEXTAREA,
                    'rows' => 5,
                    'placeholder' => esc_html__( 'Value, Text',smw_slug ),
                    'condition'=>[
                        'field_type' => array( 'radio','select' ),
                    ],
                ]
            );

            $repeater->add_control(
                'field_required',
                [
                    'label'         => esc_html__( 'Required', smw_slug ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', smw_slug ),
                    'label_off'     => esc_html__( 'No', smw_slug ),
                    'return_value'  => true,
                    'default'       => false,
                ]
            );

            $repeater->add_control(
                'field_show_email',
                [
                    'label'         => esc_html__( 'Show in Email', smw_slug ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', smw_slug ),
                    'label_off'     => esc_html__( 'No', smw_slug ),
                    'return_value'  => true,
                    'default'       => true,
                    'condition'=>[
                        'field_key'=>'customadd',
                    ],
                ]
            );

            $repeater->add_control(
                'field_show_order',
                [
                    'label'         => esc_html__( 'Show in Order Detail Page', smw_slug ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', smw_slug ),
                    'label_off'     => esc_html__( 'No', smw_slug ),
                    'return_value'  => true,
                    'default'       => true,
                    'condition'=>[
                        'field_key'=>'customadd',
                    ],
                ]
            );

            $this->add_control(
                'field_list',
                [
                    'label' => __( 'Field List', smw_slug ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'condition'=>[
                        'modify_field'=>'yes',
                    ],
                    'default' => [
                        [
                            'field_key'             => 'order_comments',
                            'field_label'           => esc_html__( 'Order Notes', smw_slug ),
                            'field_placeholder'     => 'Notes about your order, e.g. special notes for delivery.',
                            'field_default_value'   => '',
                            'field_validation'      => '',
                            'field_class'           => 'notes',
                            'field_required'        => false,
                        ],

                    ],
                    'title_field' => '{{{ field_label }}}',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function form_heading()
    {
        // Heading
        $this->start_controls_section(
            'form_heading_style',
            array(
                'label' => __( 'Heading', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'form_heading_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .woocommerce-additional-fields > h3',
                )
            );

            $this->add_control(
                'form_heading_color',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields > h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'form_heading_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields > h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'form_heading_align',
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
                    'default'   => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields > h3' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function form_label()
    {
        // Form label
        $this->start_controls_section(
            'form_label_style',
            array(
                'label' => __( 'Label', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'form_label_typography',
                    'label'     => __( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .woocommerce-additional-fields .form-row label',
                )
            );

            $this->add_control(
                'form_label_color',
                [
                    'label' => __( 'Label Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields .form-row label' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'form_label_padding',
                [
                    'label' => esc_html__( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields .form-row label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'form_label_align',
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
                        '{{WRAPPER}} .woocommerce-additional-fields .form-row label' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function form_input_box()
    {
        // Input box
        $this->start_controls_section(
            'form_input_box_style',
            array(
                'label' => esc_html__( 'Input Box', 'woolentor-pros' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'form_input_box_text_color',
                [
                    'label' => __( 'Text Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'form_input_box_typography',
                    'label'     => esc_html__( 'Typography', smw_slug ),
                    'selector'  => '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'form_input_box_border',
                    'label' => __( 'Border', smw_slug ),
                    'selector' => '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea',
                ]
            );

            $this->add_responsive_control(
                'form_input_box_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                'form_input_box_padding',
                [
                    'label' => esc_html__( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );
            
            $this->add_responsive_control(
                'form_input_box_margin',
                [
                    'label' => esc_html__( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function register_controls() 
    {
        $this->additional_form();
        
        $this->additional_fields();
        
        $this->form_heading();
        
        $this->form_label();
        
        $this->form_input_box();
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $field_list = $this->get_settings_for_display( 'field_list' );

        $items = array();

        if( $settings['modify_field'] == 'yes' )
        {
            if( isset( $field_list ) )
            {
                $priority = 0;

                foreach ( $field_list as $key => $field ) 
                {
                    $fkey = 'additional_' . $field['field_key'];

                    if( $field['field_key'] == 'customadd' )
                    {
                        $fkey = 'additional_' . $field['field_key_custom'];
                    }
                    $items[$fkey] = array(
                        'label'       => $field['field_label'],
                        'required'    => ( $field['field_required'] == true ? $field['field_required'] : false ),
                        'class'       => array( $field['field_class'] ),
                        'default'     => $field['field_default_value'],
                        'placeholder' => $field['field_placeholder'],
                        'validate'    => $field['field_validation'],
                        'priority'    => $priority+10,
                    );

                    if( $field['field_key'] == 'customadd' ){
                        $items[$fkey]['custom']         = true;
                        $items[$fkey]['type']           = $field['field_type'];
                        $items[$fkey]['show_in_email']  = $field['field_show_email'];
                        $items[$fkey]['show_in_order']  = $field['field_show_order'];
                        $items[$fkey]['options']        = isset( $field['field_options'] ) ? $field['field_options'] : '';
                    }
                    $priority = $priority+10;
                }
            }

            if( ! empty( get_option( 'stiles_wc_fields_additional' ) ) || get_option( 'stiles_wc_fields_additional' ) )
            {
                update_option( 'stiles_wc_fields_additional', $items );
            }else
            {
                add_option( 'stiles_wc_fields_additional', $items );
            }
        }else
        {
            delete_option( 'stiles_wc_fields_additional' );
        }

        $checkout = WC()->checkout();
        if ( sizeof( $checkout->checkout_fields ) > 0 ) 
        { ?>
            <div class="woocommerce-additional-fields">
                <?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>
            
                <?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

                    <?php
                        if( !empty( $settings['form_title'] ) )
                        {
                            echo '<h3>'.esc_html__( $settings['form_title'], smw_slug ).'</h3>';
                        }
                    ?>
                    <div class="woocommerce-additional-fields__field-wrapper">
                        <?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
                            <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                        <?php endforeach; ?>
                    </div>
            
                <?php endif; ?>
            
                <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
            </div>
        <?php
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_checkout_additional() );