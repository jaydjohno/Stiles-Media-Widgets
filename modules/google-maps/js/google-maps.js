jQuery( window ).on( 'elementor/frontend/init', function() 
{
    elementorFrontend.hooks.addAction( 'frontend/element_ready/stiles-google-maps.default', function( $scope ) 
    {
        map = new_map($scope.find('.smw-markers'));

        function new_map( $el ) 
        {
            $wrapper = $scope.find('.smw-markers');
            var zoom = $wrapper.data('zoom');
            var $markers = $el.find('.marker');
            var styles = $wrapper.data('style');
            var prevent_scroll = $wrapper.data('scroll');
            // vars
            var args = 
            {
                zoom		: zoom,
                center		: new google.maps.LatLng(0, 0),
                mapTypeId	: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                styles		: styles
            };

            // create map
            var map = new google.maps.Map( $el[0], args);

            // add a markers reference
            map.markers = [];

            // add markers
            $markers.each(function()
            {
                add_marker( jQuery(this), map );
            });

            // center map
            center_map( map, zoom );

            // return
            return map;
        }

        function add_marker( $marker, map ) 
        {
            var animate = $wrapper.data('animate');
            var info_window_onload = $wrapper.data('show-info-window-onload');
            //console.log(info_window_onload);
            $wrapper = $scope.find('.smw-markers');
            //alert($marker.attr('data-lat') + ' - '+ $marker.attr('data-lng'));
            var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

            icon_img = $marker.attr('data-icon');
            if(icon_img != '')
            {
                var icon = 
                {
                    url : $marker.attr('data-icon'),
                    scaledSize: new google.maps.Size($marker.attr('data-icon-size'), $marker.attr('data-icon-size'))
                };
            }

            var marker = new google.maps.Marker({
                position	: latlng,
                map			: map,
                icon        : icon,
                animation: google.maps.Animation.DROP
            });
            
            if(animate == 'animate-yes' && $marker.data('info-window') != 'yes')
            {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }
            
            if(animate == 'animate-yes')
            {
                google.maps.event.addListener(marker, 'click', function() {
                    marker.setAnimation(null);
                });
            }

            // add to array
            map.markers.push( marker );
            // if marker contains HTML, add it to an infoWindow

            if( $marker.html() )
            {
                // create info window
                var infowindow = new google.maps.InfoWindow({
                    content		: $marker.html()
                });

                // show info window when marker is clicked
                if($marker.data('info-window') == 'yes'){
                    infowindow.open(map, marker);
                }
                
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open( map, marker );
                });
            }
            
            if(animate == 'animate-yes') 
            {
                google.maps.event.addListener(infowindow, 'closeclick', function () {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                });
            }
        }

        function center_map( map, zoom ) 
        {
            // vars
            var bounds = new google.maps.LatLngBounds();
            // loop through all markers and create bounds
            jQuery.each( map.markers, function( i, marker ){
                var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
                bounds.extend( latlng );
            });

            // only 1 marker?
            if( map.markers.length == 1 )
            {
                // set center of map
                map.setCenter( bounds.getCenter() );
                map.setZoom( zoom );
            }
            else
            {
                // fit to bounds
                map.fitBounds( bounds );
            }
        }
    });
    
})(jQuery)