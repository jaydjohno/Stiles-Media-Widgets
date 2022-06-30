( function( $ ) 
{
	var isElEditMode = false;
	
	var AdvancedMenuHandler = function ($scope, $) 
	{
		new SMWAdvancedMenu( $scope );
	};
	
	$( window ).on( 'elementor/frontend/init', function () 
	{

		if ( elementorFrontend.isEditMode() ) 
		{
			isElEditMode = true;
		}

		elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-advanced-menu.default', AdvancedMenuHandler );
	});
    
} ) ( jQuery );