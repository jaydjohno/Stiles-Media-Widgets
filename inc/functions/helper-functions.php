<?php

if ( ! function_exists( 'stiles_quick_view_html' ) ) 
{
    function stiles_quick_view_html()
    {
        echo '<div class="woocommerce" id="smquick-viewmodal"><div class="sm-modal-dialog product"><div class="sm-modal-content"><button type="button" class="smcloseqv"><span class="sli sli-close"></span></button><div class="sm-modal-body"></div></div></div></div>';
    }
    if ( class_exists( 'woocommerce' ) ) 
    {
        add_action( 'stiles_footer_render_content', 'stiles_quick_view_html', 10 );
    }
}

if ( ! function_exists( 'smw_get_option' ) ) 
{
    /*
     * Plugin Options value
     * return on/off
     */
    function smw_get_option( $option, $section, $default = '' )
    {
        $options = get_option( $section );
        if ( isset( $options[$option] ) ) 
        {
            return $options[$option];
        }
        return $default;
    }
}

if ( ! function_exists( 'smw_get_option_text' ) ) 
{
    function smw_get_option_text( $option, $section, $default = '' )
    {
        $options = get_option( $section );
        
        if ( isset( $options[$option] ) ) 
        {
            if( !empty($options[$option]) )
            {
                return $options[$option];
            }
            return $default;
        }
        
        return $default;
    }
}

if ( ! function_exists( 'smw_get_option_label_text' ) ) 
{
    function smw_get_option_label_text( $option, $section, $default = '' )
    {
        $options = get_option( $section );
        
        if ( isset( $options[$option] ) ) 
        {
            if( !empty($options[$option]) )
            {
                return $options[$option];
            }
            
            return $default;
        }
        
        return $default;
    }
}

if ( ! function_exists( 'stiles_post_name' ) ) 
{
    function stiles_post_name( $post_type = 'post' )
    {
        $options = array();
        $options['0'] = __('Select',smw_slug);
        $perpage = smw_get_option( 'loadproductlimit', 'smw_others_tabs', '20' );
        $all_post = array( 'posts_per_page' => $perpage, 'post_type'=> $post_type );
        $post_terms = get_posts( $all_post );
        if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) )
        {
            foreach ( $post_terms as $term ) 
            {
                $options[ $term->ID ] = $term->post_title;
            }
            
            return $options;
        }
    }
}

if ( ! function_exists( 'stiles_get_template_type' ) ) 
{
    function stiles_get_template_type( $post_id ) 
    {
        $template =  \Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_item( $post_id );
        return $template['type'];
    }
}

if ( ! function_exists( 'stiles_get_product_category_list' ) ) 
{
    function stiles_get_product_category_list( $id = null, $taxonomy = 'product_cat', $limit = 1 ) 
    { 
        $terms = get_the_terms( $id, $taxonomy );
        $i = 0;
        if ( is_wp_error( $terms ) )
            return $terms;
    
        if ( empty( $terms ) )
            return false;
    
        foreach ( $terms as $term ) 
        {
            $i++;
            $link = get_term_link( $term, $taxonomy );
            if ( is_wp_error( $link ) ) 
            {
                return $link;
            }
            echo '<a href="' . esc_url( $link ) . '">' . $term->name . '</a>';
            if( $i == $limit )
            {
                break;
            }else{ continue; }
        }
    }
}

if( !function_exists('stiles_wc_get_rating_html') )
{
    function stiles_wc_get_rating_html()
    {
        if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) { return; }
        
        global $product;
        $rating_count = $product->get_rating_count();
        $review_count = $product->get_review_count();
        $average      = $product->get_average_rating();
        
        if ( $rating_count > 0 ) 
        {
            $rating_whole = $average / 5*100;
            $wrapper_class = is_single() ? 'rating-number' : 'top-rated-rating';
            ob_start();
        ?>
        <div class="<?php echo esc_attr( $wrapper_class ); ?>">
            <span class="sm-product-rating">
                <span class="sm-product-user-rating" style="width: <?php echo esc_attr( $rating_whole );?>%;">
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                </span>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
            </span>
        </div>
        <?php
            $html = ob_get_clean();
        } else { 
            $html  = ''; 
        }
        
        return $html;
    }
}

if ( ! function_exists( 'smw_get_last_product_id' ) ) 
{
    function smw_get_last_product_id()
    {
        global $wpdb;
        
        // Getting last Product ID (max value)
        $results = $wpdb->get_col( "
            SELECT MAX(ID) FROM {$wpdb->prefix}posts
            WHERE post_type LIKE 'product'
            AND post_status = 'publish'" 
        );
        
        return reset($results);
    }
}

if ( ! function_exists( 'stiles_custom_product_badge' ) ) 
{
    /* Custom product badge */
    function stiles_custom_product_badge( $show = 'yes' )
    {
        global $product;
        
        $custom_saleflash_text = get_post_meta( get_the_ID(), '_saleflash_text', true );
        
        if( $show == 'yes' )
        {
            if( !empty( $custom_saleflash_text ) && $product->is_in_stock() )
            {
                if( $product->is_featured() )
                {
                    echo '<span class="sm-product-label sm-product-label-left hot">' . esc_html( $custom_saleflash_text ) . '</span>';
                }else{
                    echo '<span class="sm-product-label sm-product-label-left">' . esc_html( $custom_saleflash_text ) . '</span>';
                }
            }
        }
    }
}

if ( ! function_exists( 'stiles_sale_flash' ) ) 
{
    /* Sale badge */
    function stiles_sale_flash( $offertype = 'default' )
    {
        global $product;
        
        if( $product->is_on_sale() && $product->is_in_stock() )
        {
            if( $offertype !='default' && $product->get_regular_price() > 0 )
            {
                $_off_percent = (1 - round($product->get_price() / $product->get_regular_price(), 2))*100;
                $_off_price = round($product->get_regular_price() - $product->get_price(), 0);
                $_price_symbol = get_woocommerce_currency_symbol();
                $symbol_pos = get_option('woocommerce_currency_pos', 'left');
                $price_display = '';
                switch( $symbol_pos )
                {
                    case 'left':
                        $price_display = '-'.$_price_symbol.$_off_price;
                    break;
                    case 'right':
                        $price_display = '-'.$_off_price.$_price_symbol;
                    break;
                    case 'left_space':
                        $price_display = '-'.$_price_symbol.' '.$_off_price;
                    break;
                    default: /* right_space */
                        $price_display = '-'.$_off_price.' '.$_price_symbol;
                    break;
                }
                if( $offertype == 'number' )
                {
                    echo '<span class="sm-product-label sm-product-label-right">'.$price_display.'</span>';
                }elseif( $offertype == 'percent')
                {
                    echo '<span class="sm-product-label sm-product-label-right">'.$_off_percent.'%</span>';
                }else{ echo ' '; }

            }else{
                echo '<span class="sm-product-label sm-product-label-right">'.esc_html__( 'Sale!', smw_slug ).'</span>';
            }
        }else{
            $out_of_stock = get_post_meta( get_the_ID(), '_stock_status', true );
            
            $out_of_stock_text = apply_filters( 'stiles_shop_out_of_stock_text', __( 'Out of stock', smw_slug ) );
            
            if ( 'outofstock' === $out_of_stock ) 
            {
                echo '<span class="sm-stockout sm-product-label sm-product-label-right">'.esc_html( $out_of_stock_text ).'</span>';
            }
        }
    }
}

if ( ! function_exists( 'smw_taxonomy_list' ) ) 
{
    function smw_taxonomy_list( $taxonomy = 'product_cat' )
    {
        $terms = get_terms( array(
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ));
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
            foreach ( $terms as $term ) {
                $options[ $term->slug ] = $term->name;
            }
            return $options;
        }
    }
}

if ( ! function_exists( 'stiles_compare_button' ) ) 
{
    function stiles_compare_button( $buttonstyle = 1 )
    {
        if( !class_exists('YITH_Woocompare') ) return;
        
        global $product;
        $product_id = $product->get_id();
        $comp_link = home_url() . '?action=yith-woocompare-add-product';
        $comp_link = add_query_arg('id', $product_id, $comp_link);
    
        if( $buttonstyle == 1 )
        {
            echo do_shortcode('[yith_compare_button]');
        }else
        {
            echo '<a title="'. esc_attr__('Add to Compare', smw_slug) .'" href="'. esc_url( $comp_link ) .'" class="woolentor-compare compare" data-product_id="'. esc_attr( $product_id ) .'" rel="nofollow">'.esc_html__( 'Compare', smw_slug ).'</a>';
        }
    }
}

if ( ! function_exists( 'is_elementor_installed' ) ) 
{
	/**
	 * Check if Elementor Pro is installed
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	function is_elementor_installed() 
	{
		$path    = 'elementor/elementor.php';
		$plugins = get_plugins();

		return isset( $plugins[ $path ] );
	}
}

if ( ! function_exists( 'is_job_manager_activated' ) ) 
{
    /**
	 * Check if WP Job Manager is installed
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	function is_job_manager_activated() 
    {
        if( function_exists( 'WPJM' ) ) 
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

if ( ! function_exists( 'is_woocommerce_activated' ) ) 
{
    /**
	 * Check if WooCommerce is installed
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	function is_woocommerce_activated() 
	{
		if ( class_exists( 'woocommerce' ) ) 
		{ 
		    return true; 
		} else { 
		    return false; 
		}
	}
}

if ( ! function_exists( 'is_wpml_string_translation_active' ) ) 
{
	/**
	 * Check if WPML String Translation plugin is active.
	 *
	 * @since 1.2.0
	 */
	function is_wpml_string_translation_active() 
	{
		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		return is_plugin_active( 'wpml-string-translation/plugin.php' );
	}
}

/*
 * Elementor Templates List
 * return array
 */
if ( ! function_exists( 'smw_elementor_template' ) ) 
{
    function smw_elementor_template() 
    {
        $templates = '';
        
        if( class_exists( '\Elementor\Plugin' ) )
        {
            $templates = \Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();
        }
        
        $types = array();
        
        if ( empty( $templates ) ) 
        {
            $template_lists = [ '0' => __( 'No Saved Templates Found.', smw_slug ) ];
        } else {
            $template_lists = [ '0' => __( 'Select Template', smw_slug ) ];
            
            foreach ( $templates as $template ) 
            {
                $template_lists[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            }
        }
        return $template_lists;
    }
}

if ( ! function_exists( 'stiles_get_last_order_id' ) ) 
{
    function stiles_get_last_order_id()
    {
        global $wpdb;
        
        $statuses = array_keys(wc_get_order_statuses());
        $statuses = implode( "','", $statuses );
    
        // Getting last Order ID (max value)
        $results = $wpdb->get_col( "
            SELECT MAX(ID) FROM {$wpdb->prefix}posts
            WHERE post_type LIKE 'shop_order'
            AND post_status IN ('$statuses')" 
        );
        
        return reset($results);
    }
}

if ( ! function_exists( 'stiles_add_to_wishlist_button' ) ) 
{
    function stiles_add_to_wishlist_button( $normalicon = '<i class="fa fa-heart-o"></i>', $addedicon = '<i class="fa fa-heart"></i>', $tooltip = 'no' ) 
    {
        global $product, $yith_wcwl;
    
        if ( ! class_exists( 'YITH_WCWL' ) || empty(get_option( 'yith_wcwl_wishlist_page_id' ))) return;
    
        $url          = YITH_WCWL()->get_wishlist_url();
        $product_type = $product->get_type();
        $exists       = $yith_wcwl->is_product_in_wishlist( $product->get_id() );
        $classes      = 'class="add_to_wishlist"';
        $add          = get_option( 'yith_wcwl_add_to_wishlist_text' );
        $browse       = get_option( 'yith_wcwl_browse_wishlist_text' );
        $added        = get_option( 'yith_wcwl_product_added_text' );
    
        $output = '';
    
        $output  .= '<div class="'.( $tooltip == 'yes' ? '' : 'tooltip_no' ).' wishlist button-default yith-wcwl-add-to-wishlist add-to-wishlist-' . esc_attr( $product->get_id() ) . '">';
            $output .= '<div class="yith-wcwl-add-button';
                $output .= $exists ? ' hide" style="display:none;"' : ' show"';
                $output .= '><a href="' . esc_url( htmlspecialchars( YITH_WCWL()->get_wishlist_url() ) ) . '" data-product-id="' . esc_attr( $product->get_id() ) . '" data-product-type="' . esc_attr( $product_type ) . '" ' . $classes . ' >'.$normalicon.'<span class="ht-product-action-tooltip">'.esc_html( $add ).'</span></a>';
                $output .= '<i class="fa fa-spinner fa-pulse ajax-loading" style="visibility:hidden"></i>';
            $output .= '</div>';
    
            $output .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a class="" href="' . esc_url( $url ) . '">'.$addedicon.'<span class="ht-product-action-tooltip">'.esc_html( $browse ).'</span></a></div>';
            $output .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a href="' . esc_url( $url ) . '" class="">'.$addedicon.'<span class="ht-product-action-tooltip">'.esc_html( $added ).'</span></a></div>';
        $output .= '</div>';
        return $output;
    }
}

if ( ! function_exists( 'stiles_html_render_infooter' ) ) 
{
    function stiles_html_render_infooter()
    {
        do_action( 'stiles_footer_render_content' );
    }

    add_action( 'wp_footer', 'stiles_html_render_infooter' );
}

if ( ! function_exists( 'stiles_styles_inline' ) ) 
{
    function stiles_styles_inline() 
    {
        $containerwid = get_option( 'elementor_container_width', '1140' );
        
        if( $containerwid == 0 )
        { 
            $containerwid = '1140'; 
        }
    
        $emptycartcss = $checkoutpagecss = $noticewrap = '';
        
        if ( class_exists( 'WooCommerce' ) ) 
        {
            if ( WC()->cart->is_empty() ) 
            {
                $emptycartcss = "
                    .stiles-page-template .woocommerce{
                        margin: 0 auto;
                        width: {$containerwid}px;
                    }
                ";
            }
            if( is_checkout() )
            {
                $checkoutpagecss = "
                   .stiles-woocommerce-checkout .woocommerce-NoticeGroup, .woocommerce-error{
                        margin: 0 auto;
                        width: {$containerwid}px;
                    } 
                ";
            }
        }
    
        $noticewrap = "
            .woocommerce-notices-wrapper{
                margin: 0 auto;
                width: {$containerwid}px;
            }
        ";
    
        $custom_css = "
            $emptycartcss
            $checkoutpagecss
            $noticewrap
            ";
            
        wp_add_inline_style( 'stiles-media-widgets', $custom_css );
    }
    
    add_action( 'wp_enqueue_scripts', 'stiles_styles_inline' );
}

if ( ! function_exists( 'stiles_media_allow_tags' ) ) 
{
    function stiles_media_allow_tags($tag = null) 
    {
        $tag_allowed = wp_kses_allowed_html('post');
    
        $tag_allowed['input']  = [
            'class'   => [],
            'id'      => [],
            'name'    => [],
            'value'   => [],
            'checked' => [],
            'type'    => [],
        ];
        
        $tag_allowed['select'] = [
            'class'    => [],
            'id'       => [],
            'name'     => [],
            'value'    => [],
            'multiple' => [],
            'type'     => [],
        ];
        
        $tag_allowed['option'] = [
            'value'    => [],
            'selected' => [],
        ];
    
        $tag_allowed['title'] = [
            'a'      => [
                'href'  => [],
                'title' => [],
                'class' => [],
            ],
            'br'     => [],
            'em'     => [],
            'strong' => [],
            'hr'     => [],
        ];
    
        $tag_allowed['text'] = [
            'a'      => [
                'href'  => [],
                'title' => [],
                'class' => [],
            ],
            'br'     => [],
            'em'     => [],
            'strong' => [],
            'hr'     => [],
            'i'      => [
                'class' => [],
            ],
            'span'   => [
                'class' => [],
            ],
        ];
    
        $tag_allowed['svg'] = [
            'svg'     => [
                'version'     => [],
                'xmlns'       => [],
                'viewbox'     => [],
                'xml:space'   => [],
                'xmlns:xlink' => [],
                'x'           => [],
                'y'           => [],
                'style'       => [],
            ],
            'g'       => [],
            'path'    => [
                'class' => [],
                'd'     => [],
            ],
            'ellipse' => [
                'class' => [],
                'cx'    => [],
                'cy'    => [],
                'rx'    => [],
                'ry'    => [],
            ],
            'circle'  => [
                'class' => [],
                'cx'    => [],
                'cy'    => [],
                'r'     => [],
            ],
            'rect'    => [
                'x'         => [],
                'y'         => [],
                'transform' => [],
                'height'    => [],
                'width'     => [],
                'class'     => [],
            ],
            'line'    => [
                'class' => [],
                'x1'    => [],
                'x2'    => [],
                'y1'    => [],
                'y2'    => [],
            ],
            'style'   => [],
    
    
        ];
    
        if ( $tag == null ) 
        {
            return $tag_allowed;
        } elseif ( is_array($tag) ) 
        {
            $new_tag_allow = [];
    
            foreach ( $tag as $_tag ) 
            {
                $new_tag_allow[$_tag] = $tag_allowed[$_tag];
            }
    
            return $new_tag_allow;
        } else 
        {
            return isset($tag_allowed[$tag]) ? $tag_allowed[$tag] : [];
        }
    }
}