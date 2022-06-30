<?php

namespace StilesMediaWidgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Core\Schemes\Color;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class stiles_product_sale_schedule extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
      
      wp_register_style( 'product-sale-css', plugin_dir_url( __FILE__ ) . '../css/product-sale.css');

      wp_register_script( 'countdown-handler', plugin_dir_url( __FILE__ ) . '../js/product-sale.js');
    }
    
    public function get_name() 
    {
        return 'stiles-product-sale-schedule';
    }
    
    public function get_title() 
    {
        return __( 'Product Sale Schedule', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-countdown';
    }
    
    public function get_style_depends() 
    {
        return [ 'product-sale-css' ];
    }
    
    public function get_script_depends() 
    {
        return [
            'countdown',
            'countdown-handler',
        ];
    }

    protected function register_controls() 
    {
         // Sale Schedule
        $this->start_controls_section(
            'wl-products-sale-schedule-setting',
            [
                'label' => esc_html__( 'Sale Schedule', smw_slug ),
            ]
        );

            $this->add_control(
                'customlabel_days',
                [
                    'label'       => __( 'Days', smw_slug ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Days', smw_slug ),
                ]
            );

            $this->add_control(
                'customlabel_hours',
                [
                    'label'       => __( 'Hours', smw_slug ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Hours', smw_slug ),
                ]
            );

            $this->add_control(
                'customlabel_minutes',
                [
                    'label'       => __( 'Minutes', smw_slug ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Minutes', smw_slug ),
                ]
            );

            $this->add_control(
                'customlabel_seconds',
                [
                    'label'       => __( 'Seconds', smw_slug ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Seconds', smw_slug ),
                ]
            );

        $this->end_controls_section();

        // Style Countdown tab section
        $this->start_controls_section(
            'sale_schedule_counter_style_section',
            [
                'label' => __( 'Style', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'sale_schedule_counter_Colour',
                [
                    'label' => __( 'Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_1,
                    ],
                    'default' =>'#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .sm-product-countdown-wrap .sm-product-countdown .cd-single .cd-single-inner h3' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .sm-product-countdown-wrap .sm-product-countdown .cd-single .cd-single-inner p' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'sale_schedule_counter_background_color',
                    'label' => __( 'Counter Background', smw_slug ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .sm-product-countdown-wrap .sm-product-countdown .cd-single .cd-single-inner',
                ]
            );

            $this->add_responsive_control(
                'sale_schedule_counter_space_between',
                [
                    'label' => __( 'Space', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .sm-product-countdown-wrap .sm-product-countdown .cd-single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
        $this->end_controls_section();
    }

    protected function render() 
    {
        $settings = $this->get_settings_for_display();

        // Countdown Custom Label
        $data_customlabel = [];
        $data_customlabel['daytxt'] = ! empty( $settings['customlabel_days'] ) ? $settings['customlabel_days'] : 'Days';
        $data_customlabel['hourtxt'] = ! empty( $settings['customlabel_hours'] ) ? $settings['customlabel_hours'] : 'Hours';
        $data_customlabel['minutestxt'] = ! empty( $settings['customlabel_minutes'] ) ? $settings['customlabel_minutes'] : 'Min';
        $data_customlabel['secondstxt'] = ! empty( $settings['customlabel_seconds'] ) ? $settings['customlabel_seconds'] : 'Sec';

        // Sale Schedule
        if( Plugin::instance()->editor->is_edit_mode() )
        {
            $product_id = smw_get_last_product_id();
        } else
        {
            $product_id = get_the_ID();
        }

        $offer_start_date_timestamp = get_post_meta( $product_id, '_sale_price_dates_from', true );
        $offer_start_date = $offer_start_date_timestamp ? date_i18n( 'Y/m/d', $offer_start_date_timestamp ) : '';
        $offer_end_date_timestamp = get_post_meta( $product_id, '_sale_price_dates_to', true );
        $offer_end_date = $offer_end_date_timestamp ? date_i18n( 'Y/m/d', $offer_end_date_timestamp ) : '';

        if ( $offer_end_date == '' ) 
        {
            echo '<div class="sm-single-product-countdown">'.__( 'You need to set the sale schedule in your product in order to use this widget', smw_slug ).'</div>';
        }else
        {
            if( $offer_end_date != '' ):
                if( $offer_start_date_timestamp && $offer_end_date_timestamp && current_time( 'timestamp' ) > $offer_start_date_timestamp && current_time( 'timestamp' ) < $offer_end_date_timestamp
                ): 
            ?>
                <div class="sm-single-product-countdown sm-product-countdown-wrap">
                    <div class="sm-product-countdown" data-countdown="<?php echo esc_attr( $offer_end_date ); ?>" data-customlabel='<?php echo wp_json_encode( $data_customlabel ) ?>'></div>
                </div>
            <?php endif; endif;
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_product_sale_schedule() );