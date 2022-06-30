<?php

/**
 * Stiles Media Widgets Video Gallery.
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

class stiles_wc_video_gallery extends \Elementor\Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
      parent::__construct($data, $args);

      wp_register_style( 'video-gallery-style', plugin_dir_url( __FILE__ ) . '../css/video-gallery.css');
    }
    
    public function get_name() 
    {
        return 'stiles-video-gallery';
    }
    
    public function get_title() 
    {
        return __( 'Product: Video Gallery', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-video-camera';
    }

    public function get_categories() 
    {
        return [ 'stiles-media-commerce' ];
    }

    public function get_style_depends()
    {
        return [ 'video-gallery-style' ];
    }
    
    protected function register_controls() 
    {
        $this->product_content_style();
        
        $this->product_main_mage_style();
        
        $this->product_thumbnails_style();
        
        $this->product_thumbnail_image_style();
    }
    
    protected function product_content_style()
    {
        $this->start_controls_section(
            'product_thumbnails_content',
            array(
                'label' => __( 'Video Thumbanails', smw_slug ),
                'tab' => Controls_Manager::TAB_CONTENT,
            )
        );
            
            $this->add_control(
                'tab_thumbnails_position',
                [
                    'label'   => __( 'Thumbnails Position', smw_slug ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', smw_slug ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'top' => [
                            'title' => __( 'Top', smw_slug ),
                            'icon'  => 'eicon-v-align-top',
                        ],
                        'bottom' => [
                            'title' => __( 'Bottom', smw_slug ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'     => 'bottom',
                    'toggle'      => false,
                    'label_block' => true,
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_main_mage_style()
    {
        // Product Main Image Style
        $this->start_controls_section(
            'product_image_style_section',
            [
                'label' => __( 'Main Video Area', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'main_video_height',
                [
                    'label' => __( 'Height', 'plugin-domain' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 550,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .embed-responsive' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_image_border',
                    'label' => __( 'Product image border', smw_slug ),
                    'selector' => '{{WRAPPER}} .stiles-product-gallery-video',
                ]
            );

            $this->add_responsive_control(
                'product_image_border_radius',
                [
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-product-gallery-video img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .stiles-product-gallery-video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .embed-responsive' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-product-gallery-video' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_thumbnail_image_style()
    {
        // Product Thumbnails Image Style
        $this->start_controls_section(
            'product_image_thumbnails_style_section',
            [
                'label' => __( 'Thumbnails', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_thumbnais_image_border',
                    'label' => __( 'Product image border', smw_slug ),
                    'selector' => '{{WRAPPER}} .stiles-product-video-tabs li a',
                ]
            );

            $this->add_responsive_control(
                'product_thumbnais_image_border_radius',
                [
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-product-video-tabs li a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .stiles-product-video-tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_product_thumbnais_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-product-video-tabs li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function product_thumbnails_style()
    {
        // Product Thumbnails Image Style
        $this->start_controls_section(
            'product_image_thumbnails_style_section',
            [
                'label' => __( 'Thumbnails', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_thumbnais_image_border',
                    'label' => __( 'Product image border', smw_slug ),
                    'selector' => '{{WRAPPER}} .stiles-product-video-tabs li a',
                ]
            );

            $this->add_responsive_control(
                'product_thumbnais_image_border_radius',
                [
                    'label' => __( 'Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-product-video-tabs li a img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                        '{{WRAPPER}} .stiles-product-video-tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_product_thumbnais_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles-product-video-tabs li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function render() 
    {
        $settings  = $this->get_settings_for_display();

        $this->add_render_attribute( 'sm_product_thumbnails_attr', 'class', 'sm-product-video-thumbnails thumbnails-tab-position-'.$settings['tab_thumbnails_position'] );

        if( Plugin::instance()->editor->is_edit_mode() )
        {
            $product = wc_get_product( smw_get_last_product_id() );
        } else{
            global $product;
        }

        if ( empty( $product ) ) { return; }
        $gallery_images_ids = $product->get_gallery_image_ids() ? $product->get_gallery_image_ids() : array();
        if ( $product->get_image_id() )
        {
            array_unshift( $gallery_images_ids, $product->get_image_id() );
        }

        ?>

        <div <?php echo $this->get_render_attribute_string( 'sm_product_thumbnails_attr' ); ?>>
            <div class="sm-thumbnails-image-area">

                    <?php if( $settings['tab_thumbnails_position'] == 'left' || $settings['tab_thumbnails_position'] == 'top' ): ?>
                        <ul class="stiles-product-video-tabs">
                            <?php
                                $j=0;
                                foreach ( $gallery_images_ids as $thkey => $gallery_attachment_id ) 
                                {
                                    $j++;
                                    if( $j == 1 ){ $tabactive = 'smactive'; }else{ $tabactive = ' '; }
                                    $video_url = get_post_meta( $gallery_attachment_id, 'stiles_video_url', true );
                                    ?>
                                    <li class="<?php if( !empty( $video_url ) ){ echo 'smvideothumb'; }?>">
                                        <a class="<?php echo $tabactive; ?>" href="#smvideo-<?php echo $j; ?>">
                                            <?php
                                                if( !empty( $video_url ) )
                                                {
                                                    echo '<span class="smvideo-button"><i class="sli sli-control-play"></i></span>';
                                                    echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                }else
                                                {
                                                    echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                }
                                            ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            ?>
                        </ul>
                    <?php endif; ?>

                    <div class="stiles-product-gallery-video">
                        <?php
                            $i = 0;
                            foreach ( $gallery_images_ids as $thkey => $gallery_attachment_id ) {
                                $i++;
                                if( $i == 1 ){ $tabactive = 'smactive'; }else{ $tabactive = ' '; }
                                $video_url = get_post_meta( $gallery_attachment_id, 'stiles_video_url', true );
                                ?>
                                <div class="video-cus-tab-pane <?php echo $tabactive; ?>" id="smvideo-<?php echo $i; ?>">
                                    <?php
                                        if( !empty( $video_url ) ){
                                            ?>
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <?php echo wp_oembed_get( $video_url ); ?>
                                                </div>
                                            <?php
                                        }else{
                                            echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_single' );
                                        }
                                    ?>
                                </div>
                                <?php
                            }
                        ?>
                    </div>

                    <?php if( $settings['tab_thumbnails_position'] == 'right' || $settings['tab_thumbnails_position'] == 'bottom' ): ?>

                        <ul class="stiles-product-video-tabs">
                            <?php
                                $j=0;
                                foreach ( $gallery_images_ids as $thkey => $gallery_attachment_id ) {
                                    $j++;
                                    if( $j == 1 ){ $tabactive = 'smactive'; }else{ $tabactive = ' '; }
                                    $video_url = get_post_meta( $gallery_attachment_id, 'stiles_video_url', true );
                                    ?>
                                    <li class="<?php if( !empty( $video_url ) ){ echo 'smvideothumb'; }?>">
                                        <a class="<?php echo $tabactive; ?>" href="#smvideo-<?php echo $j; ?>">
                                            <?php
                                                if( !empty( $video_url ) ){
                                                    echo '<span class="smvideo-button"><i class="sli sli-control-play"></i></span>';
                                                    echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                }else{
                                                    echo wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' );
                                                }
                                            ?>
                                        </a>
                                    </li>
                                    <?php
                                }
                            ?>
                        </ul>

                    <?php endif; ?>
            </div>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new stiles_wc_video_gallery() );