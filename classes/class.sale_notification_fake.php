<?php
/**
* Class Sale Notification
*/
class Stiles_Sale_Notification
{
    private static $_instance = null;
    
    public static function instance()
    {
        if( is_null( self::$_instance ) )
        {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    function __construct()
    {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'stiles_inline_styles' ] );
        add_action( 'wp_footer', [ $this, 'stiles_ajax_request' ] );
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style( 'stiles-media-frontend' );
        wp_enqueue_style( 'animate-css' );
        wp_enqueue_script( 'main-js' );
        wp_localize_script( 'main-js', 'product_fake_data', $this->stiles_fakes_notification_data() );
    }

    public function stiles_fakes_notification_data()
    {
        $notification = array();
        
        foreach( smw_get_option( 'noification_fake_data','smw_sales_notification_tabs', '' ) as $key => $fakedata ) 
        {
            $nc = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $fakedata );
            array_push( $notification, $nc );
        }
        
        return $notification;
    }

    // Inline CSS
    function stiles_inline_styles() 
    {
        $crosscolor = smw_get_option( 'cross_color','smw_sales_notification_tabs', '#000000' );
        
        $custom_css = "
            .smcross{
                color: {$crosscolor} !important;
            }";
            
        wp_add_inline_style( 'stiles-media-widgets', $custom_css );
    }

    // Ajax request
    function stiles_ajax_request() 
    {

        $intervaltime  = (int)smw_get_option( 'notification_time_int','smw_sales_notification_tabs', '4' )*1000;
        $duration      = (int)smw_get_option( 'notification_loadduration','smw_sales_notification_tabs', '3' )*1000;
        $inanimation   = smw_get_option( 'notification_inanimation','smw_sales_notification_tabs', 'fadeInLeft' );
        $outanimation  = smw_get_option( 'notification_outanimation','smw_sales_notification_tabs', 'fadeOutRight' );
        $notposition  = smw_get_option( 'notification_pos','smw_sales_notification_tabs', 'bottomleft' );

       
        ?>
            <script>
                ;jQuery( document ).ready( function( $ ) 
                {
                    var notposition = '<?php echo $notposition; ?>';

                    $('body').append('<div class="stiles-sale-notification"><div class="notifake stiles-notification-content '+notposition+'"></div></div>');

                    var intervaltime = <?php echo $intervaltime; ?>,
                        i = 0,
                        duration = <?php echo $duration; ?>,
                        inanimation = '<?php echo $inanimation; ?>',
                        outanimation = '<?php echo $outanimation; ?>';

                    window.setTimeout( function()
                    {
                        setInterval(function() 
                        {
                            if( i == product_fake_data.length )
                            { 
                                i = 0; 
                            }
                            
                            $('.stiles-notification-content').html('');
                            var ordercontent = `${ porduct_fake_data[i] }<span class="wlcross">&times;</span>`;
                            $('.stiles-notification-content').append( ordercontent ).addClass('animated '+inanimation).removeClass(outanimation);
                            
                            setTimeout(function() 
                            {
                                $('.stiles-notification-content').removeClass(inanimation).addClass(outanimation);
                            }, intervaltime-500 );
                            
                            i++;
                            
                        }, intervaltime );
                    }, duration );

                    // Close Button
                    $('.stiles-notification-content').on('click', '.wlcross', function(e)
                    {
                        e.preventDefault()
                        $(this).closest('.stiles-notification-content').removeClass(inanimation).addClass(outanimation);
                    });

                });
            </script>
        <?php 
    }
}

Stiles_Sale_Notification::instance();