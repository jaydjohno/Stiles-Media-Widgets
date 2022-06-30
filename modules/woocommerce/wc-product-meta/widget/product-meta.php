<?php

/**
 * Stiles Media Widgets Product Meta.
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

class stiles_wc_product_meta extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-product-meta';
    }
    
    public function get_title() 
    {
        return __( 'Product Meta Info', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-meta';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        $columns = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
// Product Price Style
        $this->start_controls_section(
            'product_meta_style_section',
            array(
                'label' => __( 'Meta', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'meta_text_color',
                array(
                    'label' => __( 'Text Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .product_meta' => 'color: {{VALUE}}',
                    ),
                )
            );

            $this->add_control(
                'meta_link_color',
                array(
                    'label' => __( 'Link Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .product_meta a' => 'color: {{VALUE}}',
                    ),
                )
            );

            $this->add_control(
                'meta_link_hover_color',
                array(
                    'label' => __( 'Link Hover Colour', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .product_meta a:hover' => 'color: {{VALUE}}',
                    ),
                )
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name' => 'meta_text_typography',
                    'label' => __( 'Typography', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} .product_meta',
                )
            );

            $this->add_responsive_control(
                'meta_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', 'em' ),
                    'selectors' => array(
                        '{{WRAPPER}} .product_meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ),
                )
            );

        $this->end_controls_section();
    }
    
    protected function render()
    {
        $settings   = $this->get_settings_for_display();
        global $product;
        $product = wc_get_product();
        
        if( \Elementor\Plugin::instance()->editor->is_edit_mode() )
        { ?>
            <div class="product">
                <div class="product_meta">
                    <?php do_action( 'woocommerce_product_meta_start' ); ?>

                    <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

                        <span class="sku_wrapper"><?php esc_html_e( 'SKU:', smw_slug ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', smw_slug ); ?></span></span>

                    <?php endif; ?>

                    <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), smw_slug ) . ' ', '</span>' ); ?>

                    <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), smw_slug ) . ' ', '</span>' ); ?>

                    <?php do_action( 'woocommerce_product_meta_end' ); ?>
                </div>
            </div>        
        <?php } else
        {
            if ( empty( $product ) ) 
            { 
                return; 
            }
            
            woocommerce_template_single_meta();
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_product_meta() );