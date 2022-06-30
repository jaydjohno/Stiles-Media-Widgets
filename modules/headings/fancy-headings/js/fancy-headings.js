( function( $ ) 
{
    var SMWFancyText = function() 
    {
		var id 					= $( this ).data( 'id' );
		var $this 				= $( this ).find( '.smw-fancy-text-node' );
		var animation			= $this.data( 'animation' );
		var fancystring 		= $this.data( 'strings' );
		var nodeclass           = '.elementor-element-' + id;

		var typespeed 			= $this.data( 'type-speed' );
		var backspeed 			= $this.data( 'back-speed' );
		var startdelay 			= $this.data( 'start-delay' );
		var backdelay 			= $this.data( 'back-delay' );
		var loop 				= $this.data( 'loop' );
		var showcursor 			= $this.data( 'show_cursor' );
		var cursorchar 			= $this.data( 'cursor-char' );

		var speed 				= $this.data('speed');
		var pause				= $this.data('pause');
		var mousepause			= $this.data('mousepause');

		if ( 'type' == animation ) {
			$( nodeclass + ' .smw-typed-main' ).typed({
				strings: fancystring,
				typeSpeed: typespeed,
				startDelay: startdelay,
				backSpeed: backspeed,
				backDelay: backdelay,
				loop: loop,
				showCursor: showcursor,
				cursorChar: cursorchar,
	        });

		} else if ( 'slide' == animation ) {
			$( nodeclass + ' .smw-fancy-text-slide' ).css( 'opacity', '1' );
			$( nodeclass + ' .smw-slide-main' ).vTicker('init', {
					strings: fancystring,
					speed: '60',
					pause: pause,
					mousePause: mousepause,
			});
		}
	}
	
	var WidgetSMWFancyTextHandler = function( $scope, $ ) 
	{
		if ( 'undefined' == typeof $scope ) 
		{
			return;
		}
		
		var node_id = $scope.data( 'id' );
		var viewport_position	= 90;
		var selector = $( '.elementor-element-' + node_id );

		if( typeof elementorFrontend.waypoint !== 'undefined' ) 
		{
			elementorFrontend.waypoint(
				selector,
				SMWFancyText,
				{
					offset: viewport_position + '%'
				}
			);
		}
	};
	
	$( window ).on( 'elementor/frontend/init', function () 
	{
		elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-fancy-headings.default', WidgetSMWFancyTextHandler );
	});
    
} ) ( jQuery );