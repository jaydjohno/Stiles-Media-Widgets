;(function($)
{
    "use strict";

    // Tab Menu
    
    function stiles_admin_tabs( $tabmenus, $tabpane )
    {
        $tabmenus.on('click', 'a', function(e)
        {
            e.preventDefault();
            
            var $this = $(this),
                $target = $this.attr('href');
                
            $this.addClass('smactive').parent().siblings().children('a').removeClass('smactive');
            
            $( $tabpane + $target ).addClass('smactive').siblings().removeClass('smactive');
        });
    }
    
    stiles_admin_tabs( $(".stiles-admin-tabs"), '.stiles-admin-tab-pane' );

    var contenttypeval = admin_smlocalize_data.contenttype;
    
    if( contenttypeval == 'fakes' )
    {
        $(".notification_fake").show();
        $(".notification_real").hide();
    }else
    {
        $(".notification_fake").hide();
        $(".notification_real").show();
    }
    
    // When radio button changes hide panel if required
    jQuery(document).on('change','.notification_content_type .radio',function()
    {
        if( $(this).is(":checked") )
        {
            contenttypeval = $(this).val();
        }
        if( contenttypeval == 'fakes' )
        {
            $(".notification_fake").show();
            $(".notification_real").hide();
        }else{
            $(".notification_fake").hide();
            $(".notification_real").show();
        }
    });
})(jQuery);