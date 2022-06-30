<?php
    /**
    *  Single Product Custom Layout
    */
    class Stiles_Woo_Custom_Template_Layout
    {
        public static $sm_woo_elementor_template = array();

        private static $_instance = null;
        
        public static function instance() 
        {
            if ( is_null( self::$_instance ) ) 
            {
                self::$_instance = new self();
            }
            
            return self::$_instance;
        }
        
        function __construct()
        {
            add_action('init', array( $this, 'init' ) );
            
            add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'stiles_init_cart' ) );

            if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) 
            {
                add_action( 'init', array( $this, 'register_wc_hooks' ), 5 );
            }
        }

        public function init()
        {
            // Product details page
            add_filter( 'wc_get_template_part', array( $this, 'stiles_get_product_page_template' ), 99, 3 );
            
            add_filter( 'template_include', array( $this, 'stiles_get_product_elementor_template' ), 100 );
            
            add_action( 'stiles_woocommerce_product_content', array( $this, 'stiles_get_product_content_elementor' ), 5 );
            
            add_action( 'stiles_woocommerce_product_content', array( $this, 'stiles_get_default_product_data' ), 10 );

            // Product Archive Page
            add_action('template_redirect', array($this, 'stiles_product_archive_template'), 999);
            
            add_filter('template_include', array($this, 'stiles_redirect_product_archive_template'), 999);
            
            add_action( 'stiles_woocommerce_archive_product_content', array( $this, 'stiles_archive_product_page_content') );
            
            add_filter( 'wc_get_template', array( $this, 'stiles_page_template' ), 50, 3 );
        
            // Cart
            add_action( 'stiles_cart_content_build', array( $this, 'stiles_cart_content' ) );
            add_action( 'stiles_cart_empty_content_build', array( $this, 'stiles_empty_cart_content' ) );
            
            // Checkout
            add_action( 'stiles_checkout_content', array( $this, 'stiles_checkout_content' ) );
            add_action( 'stiles_checkout_top_content', array( $this, 'stiles_checkout_top_content' ) );
    
            // Thank you Page
            add_action( 'stiles_thank_you_content', array( $this, 'stiles_thank_you_content' ) );
    
            // MyAccount
            add_action( 'stiles_woocommerce_account_content', array( $this, 'stiles_account_content' ) );
            add_action( 'stiles_woocommerce_account_content_form_login', array( $this, 'stiles_account_login_content' ) );
    
            // Quick View Content
            add_action( 'stiles_quick_view_content', array( $this, 'stiles_quick_view_content' ) );
    
            add_filter( 'template_include', array( $this, 'stiles_woocommerce_page_template' ), 999);
        }
        
        public function register_wc_hooks() 
        {
            wc()->frontend_includes();
        }
        
        public function stiles_init_cart() 
        {
            $has_cart = is_a( WC()->cart, 'WC_Cart' );
            
            if ( ! $has_cart ) 
            {
                $session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
                WC()->session = new $session_class();
                WC()->session->init();
                WC()->cart = new \WC_Cart();
                WC()->customer = new \WC_Customer( get_current_user_id(), true );
            }
        }

        public function stiles_get_product_page_template( $template, $slug, $name ) 
        {
            if ( 'content' === $slug && 'single-product' === $name ) 
            {
                if ( Stiles_Woo_Custom_Template_Layout::sm_woo_custom_product_template() ) 
                {
                    $template = smw_dir . 'woocommerce/templates/single-product.php';
                }
            }
            
            return $template;
        }
        
        public function stiles_page_template( $template, $slug, $args )
        {
            if( $slug === 'cart/cart-empty.php')
            {
                $wlemptycart_page_id = smw_get_option( 'productemptycartpage', 'smw_template_tabs', '0' );
                
                if( !empty( $wlemptycart_page_id ) ) 
                {
                    $template = smw_dir . 'woocommerce/templates/cart-empty-elementor.php';
                }
            }
            elseif( $slug === 'cart/cart.php' )
            {
                $wlcart_page_id = smw_get_option( 'productcartpage', 'smw_template_tabs', '0' );
                
                if( !empty( $wlcart_page_id ) ) 
                {
                    $template = smw_dir . 'woocommerce/templates/cart-elementor.php';
                }
            }elseif( $slug === 'checkout/form-checkout.php' )
            {
                $wlcheckout_page_id = smw_get_option( 'productcheckoutpage', 'smw_template_tabs', '0' );
                
                if( !empty( $wlcheckout_page_id ) ) 
                {
                    $template = smw_dir . 'woocommerce/templates/form-checkout.php';
                }
            }elseif( $slug === 'checkout/thankyou.php' )
            {
                $wlthankyou_page_id = smw_get_option( 'productthankyoupage', 'smw_template_tabs', '0' );
                
                if( !empty( $wlthankyou_page_id ) ) 
                {
                    $template = smw_dir . 'woocommerce/templates/thankyou.php';
                }
            }elseif( $slug === 'myaccount/my-account.php' )
            {
                $wlmyaccount_page_id = smw_get_option( 'productmyaccountpage', 'smw_template_tabs', '0' );
                
                if( !empty( $wlmyaccount_page_id ) ) 
                {
                    $template = smw_dir . 'woocommerce/templates/my-account.php';
                }
            }elseif( $slug === 'myaccount/form-login.php' )
            {
                $wlmyaccount_login_page_id = smw_get_option( 'productmyaccountloginpage', 'smw_template_tabs', '0' );
                
                if( !empty( $wlmyaccount_login_page_id ) ) 
                {
                    $template = smw_dir . 'woocommerce/templates/form-login.php';
                }
            }
    
            return $template;
        }
        
        public function stiles_empty_cart_content()
        {
            $elementor_page_id = smw_get_option( 'productemptycartpage', 'smw_template_tabs', '0' );
            
            if( !empty( $elementor_page_id ) )
            {
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
            }
        }

        public function stiles_cart_content()
        {
            $elementor_page_id = smw_get_option( 'productcartpage', 'smw_template_tabs', '0' );
            
            if( !empty( $elementor_page_id ) )
            {
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
            }
        }
    
        public function stiles_checkout_content()
        {
            $elementor_page_id = smw_get_option( 'productcheckoutpage', 'smw_template_tabs', '0' );
            
            if( !empty( $elementor_page_id ) )
            {
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
            }else{ 
                the_content(); 
            }
        }
    
        public function stiles_checkout_top_content()
        {
            $elementor_page_id = smw_get_option( 'productcheckouttoppage', 'smw_template_tabs', '0' );
            
            if( !empty( $elementor_page_id ) )
            {
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
            }
        }
    
        public function stiles_thank_you_content()
        {
            $elementor_page_id = smw_get_option( 'productthankyoupage', 'smw_template_tabs', '0' );
            
            if( !empty( $elementor_page_id ) )
            {
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
            }else{ 
                the_content(); 
            }
        }
    
        public function stiles_account_content()
        {
            $elementor_page_id = smw_get_option( 'productmyaccountpage', 'smw_template_tabs', '0' );
            
            if ( is_user_logged_in() && !empty($elementor_page_id) )
            {
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
            }else{ 
                the_content(); 
            }
        }
    
        public function stiles_account_login_content()
        {
            $elementor_page_id = smw_get_option( 'productmyaccountloginpage', 'smw_template_tabs', '0' );
            
            if ( !empty($elementor_page_id) )
            {
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
            }else{ 
                the_content(); 
            }
        }
    
        public function stiles_quick_view_content()
        {
            $elementor_page_id = smw_get_option( 'productquickview', 'smw_template_tabs', '0' );
            
            if( !empty( $elementor_page_id ) )
            {
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
            }
        }
    
        public function stiles_get_page_template_path( $page_template ) 
        {
            $template_path = '';
            
            if( $page_template === 'elementor_header_footer' )
            {
                $template_path = smw_dir . 'woocommerce/templates/page/header-footer.php';
            }elseif( $page_template === 'elementor_canvas' )
            {
                $template_path = smw_dir . 'woocommerce/templates/page/canvas.php';
            }
            
            return $template_path;
        }

        //Based on elementor template
        public function stiles_get_product_elementor_template( $template ) 
        {
            if ( is_embed() ) 
            {
                return $template;
            }
            
            if ( is_singular( 'product' ) ) 
            {
                $templateid = get_page_template_slug( smw_get_option( 'singleproductpage', 'smw_template_tabs', '0' ) );
                
                if ( 'elementor_header_footer' === $templateid ) 
                {
                    $template = smw_dir . 'woocommerce/templates/single-product-fullwidth.php';
                } elseif ( 'elementor_canvas' === $templateid ) 
                {
                    $template = smw_dir . 'woocommerce/templates/single-product-canvas.php';
                }
            }
            
            return $template;
        }

        public static function stiles_get_product_content_elementor( $post ) 
        {
            if ( Stiles_Woo_Custom_Template_Layout::sm_woo_custom_product_template() ) 
            {
                $smtemplateid = smw_get_option( 'singleproductpage', 'smw_template_tabs', '0' );
                
                $smindividualid = get_post_meta( get_the_ID(), '_selectproduct_layout', true ) ? get_post_meta( get_the_ID(), '_selectproduct_layout', true ) : '0';
                
                if( $smindividualid != '0' )
                { 
                    $smtemplateid = $smindividualid; 
                }
                
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $smtemplateid );
                
            } else 
            {
                the_content();
            }
        }
        
        public function stiles_woocommerce_page_template( $template )
        {
            $elementor_page_slug = 0;
    
            if( is_cart() )
            {
                $cart_page_id = smw_get_option( 'productcartpage', 'smw_template_tabs', '0' );
                
                if( !empty( $cart_page_id ) )
                {
                    $elementor_page_slug = get_page_template_slug( $cart_page_id );
                }
            }elseif ( is_checkout() )
            {
                $sm_checkout_page_id = smw_get_option( 'productcheckoutpage', 'smw_template_tabs', '0' );
                
                if( !empty($sm_checkout_page_id) )
                {
                    $elementor_page_slug = get_page_template_slug( $sm_checkout_page_id );
                }
                
            }elseif ( is_account_page() && is_user_logged_in() )
            {
                $sm_myaccount_page_id = smw_get_option( 'productmyaccountpage', 'smw_template_tabs', '0' );
                
                if( !empty($sm_myaccount_page_id) )
                {
                    $elementor_page_slug = get_page_template_slug( $sm_myaccount_page_id );
                }
            }
            
            if( !empty($elementor_page_slug) )
            {
                $template_path = $this->stiles_get_page_template_path( $elementor_page_slug );
                
                if ( $template_path ) 
                {
                    $template = $template_path;
                }
            }
            
            return $template;
        }

        // product data
        public function stiles_get_default_product_data() 
        {
            WC()->structured_data->generate_product_data();
        }

        public static function sm_woo_custom_product_template() 
        {
            $templatestatus = false;
            
            if ( is_product() ) 
            {
                global $post;
                
                if ( ! isset( self::$sm_woo_elementor_template[ $post->ID ] ) ) 
                {
                    $single_product_default = smw_get_option( 'singleproductpage', 'smw_template_tabs', '0' );
                    
                    if ( ! empty( $single_product_default ) && 'default' !== $single_product_default ) {
                        $templatestatus                              = true;
                        self::$sm_woo_elementor_template[ $post->ID ] = true;
                    }
                } else 
                {
                    $templatestatus = self::$sm_woo_elementor_template[ $post->ID ];
                }
            }
            
            return apply_filters( 'sm_woo_custom_product_template', $templatestatus );
        }

        /*
        * Archive Page
        */
        public function stiles_product_archive_template() 
        {
            $archive_template_id = 0;
            if ( defined('WOOCOMMERCE_VERSION') ) 
            {
                $termobj = get_queried_object();
                
                if ( is_shop() || ( is_tax('product_cat') && is_product_category() ) || ( is_tax('product_tag') && is_product_tag() ) || ( isset( $termobj->taxonomy ) && is_tax( $termobj->taxonomy ) ) ) 
                {
                    $product_achive_custom_page_id = smw_get_option( 'productarchivepage', 'smw_template_tabs', '0' );

                    // Meta value
                    $smtermlayoutid = 0;
                    
                    if(( is_tax('product_cat') && is_product_category() ) || ( is_tax('product_tag') && is_product_tag() ))
                    {
                        $smtermlayoutid = get_term_meta( $termobj->term_id, 'wooletor_selectcategory_layout', true ) ? get_term_meta( $termobj->term_id, 'wooletor_selectcategory_layout', true ) : '0';
                    }
                    if( $smtermlayoutid != '0' )
                    { 
                        $archive_template_id = $smtermlayoutid; 
                    }else{
                        if (!empty($product_achive_custom_page_id)) 
                        {
                            $archive_template_id = $product_achive_custom_page_id;
                        }
                    }
                    return $archive_template_id;
                }
                return $archive_template_id;
            }
        }

        public function stiles_redirect_product_archive_template($template)
        {
            $archive_template_id = $this->stiles_product_archive_template();
            
            $templatefile   = array();
            
            $templatefile[] = 'woocommerce/templates/archive-product.php';
            
            if( $archive_template_id != '0' )
            {
                $template = locate_template( $templatefile );
                
                if ( ! $template || ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) )
                {
                    $template = smw_dir . '/woocommerce/templates/archive-product.php';
                }
                
                $page_template_slug = get_page_template_slug( $archive_template_id );
                
                if ( 'elementor_header_footer' === $page_template_slug ) 
                {
                    $template = smw_dir . '/woocommerce/templates/archive-product-fullwidth.php';
                } elseif ( 'elementor_canvas' === $page_template_slug ) 
                {
                    $template = smw_dir . '/woocommerce/templates/archive-product-canvas.php';
                }
            }
            
            return $template;
        }

        // Element Content
        public function stiles_archive_product_page_content( $post )
        {
            $archive_template_id = $this->stiles_product_archive_template();
            
            if( $archive_template_id != '0' )
            {
                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $archive_template_id );
            }else
            { 
                the_content(); 
            }
        }
    }

    Stiles_Woo_Custom_Template_Layout::instance();