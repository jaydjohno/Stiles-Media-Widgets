<?php
/**
* Mini Cart Manager
*/
class Stiles_Mini_Cart 
{
    /**
     * [$instance]
     * @var null
     */
    private static $instance = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [Stiles_Mini_Cart]
     */
    public static function instance()
    {
        if( is_null( self::$instance ) )
        {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    /**
     * [__construct] Class Construction
     */
    function __construct()
    {
        add_action( 'stiles_cart_content', [ $this, 'get_cart_item' ] );

        add_filter( 'woocommerce_add_to_cart_fragments', [ $this,'wc_add_to_cart_fragment' ], 10, 1 );
    }

    /**
     * [get_cart_item] Render fragment cart item
     * @return [html]
     */
    public function get_cart_item()
    {
        $cart_data  = WC()->cart->get_cart();
        $args = array();
        ob_start();
        wc_get_template( 'woocommerce/classes/tmp-mini_cart_content.php', $args, '', smw_dir );
        return ob_get_clean();
    }

    /**
     * [wc_add_to_cart_fragment] add to cart freagment callable
     * @param  [type] $fragments
     * @return [type] $fragments
     */
    public function wc_add_to_cart_fragment( $fragments )
    {
        $item_count = WC()->cart->get_cart_contents_count();
        $cart_item = $this->get_cart_item();

        // Cart Item
        $fragments['div.stiles_cart_content_container'] = '<div class="stiles_cart_content_container">'.$cart_item.'</div>';

        //Cart Counter
        $fragments['span.stiles_mini_cart_counter'] = '<span class="stiles_mini_cart_counter">'.$item_count.'</span>';

        return $fragments;
    }
}

Stiles_Mini_Cart::instance();