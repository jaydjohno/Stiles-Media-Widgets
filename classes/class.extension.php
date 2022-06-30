<?php 

/**
* Stiles Extension Class
*/

class Stiles_Extension
{
    private static $instance = null;
    
    public static function instance()
    {
        if( is_null( self::$instance ) )
        {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    function __construct()
    {

        $this->include_file();
        
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );

        if( smw_get_option( 'single_product_sticky_add_to_cart', 'smw_others_tabs', 'off' ) == 'on' )
        {
            add_action( 'stiles_footer_render_content', [ $this, 'sticky_single_add_to_cart' ], 15 );
            
        }

        if( smw_get_option( 'mini_side_cart', 'smw_others_tabs', 'off' ) == 'on' )
        {
            add_action( 'stiles_footer_render_content', [ $this, 'mini_cart' ] );
        }

    }

    // Scripts enqueue
    public function enqueue_assets()
    {
        if ( is_product() )
        {
            wp_enqueue_script( 'main-js' );
        }
        
        if( smw_get_option( 'mini_side_cart', 'smw_others_tabs', 'off' ) == 'on' )
        {
            wp_enqueue_script( 'mini-cart-js' );
        }
    }

    // Single Product Sticky Add to Cart
    public function sticky_single_add_to_cart()
    {
        global $product;
        
        if ( ! is_product() ) return;
        
        require( smw_dir . 'woocommerce/classes/tmp-sticky_add_to_cart.php' );
    }

    /**
     * [mini_cart] Add Mini Cart Markup In Footer
     * @return [void]
     */
    public function mini_cart()
    {
        require( smw_dir . 'woocommerce/classes/tmp-mini_cart.php' );
    }

    /**
     * [include_file] Nessary File Required
     * @return [void]
     */
    public function include_file()
    {
        if( smw_get_option( 'mini_side_cart', 'smw_others_tabs', 'off' ) == 'on' )
        {
            require( smw_dir . 'woocommerce/classes/class.mini_cart.php' );
        }
    }

}

Stiles_Extension::instance();