( function( $ ) 
{
	var isElEditMode = false;
	
	var offCanvasHandler = function ($scope, $) 
	{
        new window.SMWOffcanvasContent( $scope );
    };
	
	$( window ).on( 'elementor/frontend/init', function () 
	{
		if ( elementorFrontend.isEditMode() ) 
		{
			isElEditMode = true;
		}

		elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-off-canvas.default', offCanvasHandler );
	});
    
} ) ( jQuery );