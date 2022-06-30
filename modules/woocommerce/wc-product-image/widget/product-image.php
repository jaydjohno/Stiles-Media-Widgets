<?php

/**
 * Stiles Media Widgets Product Image.
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

class stiles_wc_product_image extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);
    }
    
    public function get_name() 
    {
        return 'stiles-product-image';
    }
    
    public function get_title() 
    {
        return __( 'Product Image', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-product-images';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }
    
    protected function register_controls() 
    {
        $this->product_image_style();
        
        $this->product_thumbnail_style();
    }
    
    protected function product_image_style()
    {
        // Product Image Style
        $this->start_controls_section(
            'product_image_style_section',
            array(
                'label' => __( 'Image', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                array(
                    'name' => 'product_image_border',
                    'selector' => '.woocommerce {{WRAPPER}} .woocommerce-product-gallery__trigger + .woocommerce-product-gallery__wrapper,
                    .woocommerce {{WRAPPER}} .flex-viewport',
                )
            );

            $this->add_responsive_control(
                'product_image_border_radius',
                array(
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .woocommerce-product-gallery__trigger + .woocommerce-product-gallery__wrapper,
                        .woocommerce {{WRAPPER}} .flex-viewport' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ),
                )
            );

            $this->add_responsive_control(
                'product_margin',
                array(
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', 'em' ),
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .flex-viewport:not(:last-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ),
                )
            );

        $this->end_controls_section();
    }
    
    protected function product_thumbnail_style()
    {
        // Product Thumbnails Style
        $this->start_controls_section(
            'product_thumbnails_image_style_section',
            array(
                'label' => __( 'Thumbnails', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                array(
                    'name' => 'product_thumbnails_border',
                    'label' => __( 'Thumbnails Border', smw_slug ),
                    'selector' => '.woocommerce {{WRAPPER}} .flex-control-thumbs img',
                )
            );

            $this->add_responsive_control(
                'product_thumbnails_border_radius',
                array(
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => array( 'px', '%' ),
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .flex-control-thumbs img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ),
                )
            );

            $this->add_control(
                'product_thumbnails_spacing',
                array(
                    'label' => __( 'Spacing', smw_slug ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => array( 'px', 'em' ),
                    'selectors' => array(
                        '.woocommerce {{WRAPPER}} .flex-control-thumbs li' => 'padding-right: calc({{SIZE}}{{UNIT}} / 2); padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: {{SIZE}}{{UNIT}}',
                        '.woocommerce {{WRAPPER}} .flex-control-thumbs' => 'margin-right: calc(-{{SIZE}}{{UNIT}} / 2); margin-left: calc(-{{SIZE}}{{UNIT}} / 2)',
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
        {
            if ( $product->is_on_sale() ) 
            { 
                echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', smw_slug ) . '</span>', $post, $product ); 
            }
            
            $columns = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
            
            $thumbnail_id = $product->get_image_id();
            
            $wrapper_classes = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
                'woocommerce-product-gallery',
                'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
                'woocommerce-product-gallery--columns-' . absint( $columns ),
                'images',
            ) );
            
            if ( function_exists( 'wc_get_gallery_image_html' ) ) 
            {
                ?>
                <div class="product">
                    <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
                        <figure class="woocommerce-product-gallery__wrapper">
                            <?php
                            if ( $product->get_image_id() ) 
                            {
                                $html = wc_get_gallery_image_html( $thumbnail_id, true );
                            } else 
                            {
                                $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', smw_slug ) );
                                $html .= '</div>';
                            }
            
                            echo $html;
            
                            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
            
                            $attachment_ids = $product->get_gallery_image_ids();
            
                            if ( $attachment_ids && $product->get_image_id() ) 
                            {
                                foreach ( $attachment_ids as $attachment_id ) 
                                {
                                    echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
                                }
                            }
            
                            ?>
                        </figure>
                    </div>
                </div>
                <?php
            }
        } else
        {
            if ( empty( $product ) ) 
            {
                return;
            }
            
            /**
            * Hook: woocommerce_before_single_product_summary.
            *
            * @hooked woocommerce_show_product_sale_flash - 10
            * @hooked woocommerce_show_product_images - 20
            */
            do_action( 'woocommerce_before_single_product_summary' );
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_product_image() );