( function( $ ) 
{
    var WidgetSMWFAQHandler = function( $scope, $ ) 
    {
		var smw_faq_answer = $scope.find('.smw-faq-accordion > .smw-accordion-content');
		var layout = $scope.find( '.smw-faq-container' );
		var faq_layout = layout.data('layout');
			$scope.find('.smw-accordion-title').on( 'click keypress',
            function(e)
            {
                e.preventDefault();
                $this = $(this);
                smw_accordion_activate_deactivate($this);	
            }
        );
        function smw_accordion_activate_deactivate($this) 
        {
            if('toggle' == faq_layout ) 
            {
                if( $this.hasClass('smw-title-active') )
                {
                    $this.removeClass('smw-title-active');
                    $this.attr('aria-expanded', 'false');
                }
                else{
                    $this.addClass('smw-title-active');
                    $this.attr('aria-expanded', 'true');
                }
                $this.next('.smw-accordion-content').slideToggle( 'normal','swing');
            }
            else if( 'accordion' == faq_layout )
            {
                if( $this.hasClass('smw-title-active') )
                {
                    $this.removeClass( 'smw-title-active');
                    $this.next('.smw-accordion-content').slideUp( 'normal','swing',						
                        function()
                        {
                            $(this).prev().removeClass('smw-title-active');
                            $this.attr('aria-expanded', 'false');
                        });
                } else {
                    if( smw_faq_answer.hasClass('smw-title-active') )
                    {
                        smw_faq_answer.removeClass('smw-title-active');
                    }
                    smw_faq_answer.slideUp('normal','swing' , function()
                    {
                        $(this).prev().removeClass('smw-title-active');
                    });

                    $this.addClass('smw-title-active');
                    $this.attr('aria-expanded', 'true');
                    $this.next('.smw-accordion-content').slideDown('normal','swing');
                }
                
                return false;
            }
        }					
	}
	
	$( window ).on( 'elementor/frontend/init', function () 
	{
		elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-faq.default', WidgetSMWFAQHandler );
	});
} ) ( jQuery );