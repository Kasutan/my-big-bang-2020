(function($) {

    /*
    *  new_map
    *
    *  This function will render a Google Map onto the selected jQuery element
    *
    *  @type	function
    *  @date	8/11/2013
    *  @since	4.3.0
    *
    *  @param	$el (jQuery element)
    *  @return	n/a
    */
    
    function new_map( $el ) {
    
        // var
        var $markers = $el.find('.marker');
    
    
        // vars
        var args = {
            zoom		: 6,
            //center		: new google.maps.LatLng(46.8, 2.3),
            mapTypeId	: google.maps.MapTypeId.ROADMAP
		};
		
		
    
    
        // create map
        var map = new google.maps.Map( $el[0], args);
    
    
        // add a markers reference
        map.markers = [];
    
    
        // add markers
        $markers.each(function(){
    
            add_marker( $(this), map );
        });
	

		//https://stackoverflow.com/questions/35065861/filter-google-map-markers
		//Filtrer les marqueurs à la saisie dans le champ de recherche
		$("#studios-search").keyup(function(){
			filtreCarte(map);
		});

    
        // return
        return map;
    
	}
	
	function filtreCarte(map) {
		var search=$("#studios-search").val().toLowerCase();
		$.each(map.markers, function(i, marker) {
			if(marker.keys.indexOf(search) >= 0)
				marker.setVisible(true);
			else
				marker.setVisible(false);
		});
	}
    
    /*
    *  add_marker
    *
    *  This function will add a marker to the selected Google Map
    *
    *  @type	function
    *  @date	8/11/2013
    *  @since	4.3.0
    *
    *  @param	$marker (jQuery element)
    *  @param	map (Google Map object)
    *  @return	n/a
    */
    
    function add_marker( $marker, map ) {
    
        // var
        var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
	
		var image="/wp-content/themes/my-big-bang-2020/icons/pic-studio-blanc.svg";
        // create marker
        var marker = new google.maps.Marker({
            position	: latlng,
			map			: map,
			id : $marker.attr('id'),
			keys : $marker.attr('data-keys'),
			icon:image

        });
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
            google.maps.event.addListener(marker, 'click', function() {
    
                infowindow.open( map, marker );
    
            });
        }
    
    }
    
    /*
    *  center_map
    *
    *  This function will center the map, showing all markers attached to this map
    *
    *  @type	function
    *  @date	8/11/2013
    *  @since	4.3.0
    *
    *  @param	map (Google Map object)
    *  @return	n/a
    */
    
    function center_map( map , desktop, landing) {
    
        // vars
        var bounds = new google.maps.LatLngBounds();
    
        // loop through all markers and create bounds
        $.each( map.markers, function( i, marker ){
    
            var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
    
            bounds.extend( latlng );
    
        });
    
        // only 1 marker?
        if( map.markers.length == 1 )
        {
            // set center of map
			map.setCenter( bounds.getCenter() );
			if(desktop || landing) {
				map.setZoom( 16 );
			} else {
				map.setZoom( 10 );
			}
        }
        else
        {
            // fit to bounds
			  map.setCenter( bounds.getCenter() );
			  if(desktop || landing) {
				map.setZoom( 10 );
				map.fitBounds( bounds ); 

			} else {
				map.setZoom( 5 );
			}
    
        }
    
    }
    
    /*
    *  document ready
    *
    *  This function will render each map when the document is ready (page has loaded)
    *
    *  @type	function
    *  @date	8/11/2013
    *  @since	5.0.0
    *
    *  @param	n/a
    *  @return	n/a
    */
    // global var
    var map = null;
    
    jQuery(document).ready(function($){
    
        $('.acf-map').each(function(){
    
            // create map
			map = new_map( $(this) );
			center_map(map, window.innerWidth > 768, $('body').hasClass('page-template-landing'));
			

    
        });
    
    
    });
    
    })(jQuery);
    