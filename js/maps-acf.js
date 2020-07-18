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
		$("#pro-search").keyup(function(){
			filtreCarte(map);
		});
		$("#filtre-clientele").change(function (e) { 
			filtreCarte(map);
		});
		$('.annuaire .no-search, .annuaire .no-filter').click(function (e) { 
			filtreCarte(map);
		});
		$('.no-filter-mini-annuaire').click(function (e) { 
			$("input[name='filtre-clientele']").attr('checked',false);
			filtreCarte(map);
		});
		

		//Centrer la carte sur une adresse au clic sur la liste de résultats
		$('.annuaire .js-center-map').click(function(e) {
			e.preventDefault();
			var selected_lat= parseFloat( $(this).attr('data-lat') );
			var selected_lng=parseFloat( $(this).attr('data-lng') );
			map.setCenter({lat: selected_lat, lng: selected_lng});
			map.setZoom( 14 );

		});
		
        // centrer la carte sur le milieu de tous les marqueurs au chargement de la carte
        //center_map( map );
	
		//Si mini formulaire de recherche de l'accueil, dézoomer d'un niveau
		if ($el.hasClass('accueil')) {
			map.setZoom(5);
		}


    
        // return
        return map;
    
	}
	
	function filtreCarte(map) {
		var selected_value = $("input[name='filtre-clientele']:checked").val();
		var search=$("#pro-search").val().toLowerCase();
		if(undefined==selected_value) {
			$.each(map.markers, function(i, marker) {
				if(marker.keys.indexOf(search) >= 0)
					marker.setVisible(true);
				else
					marker.setVisible(false);
			});
		} else {
			$.each(map.markers, function(i, marker) {
				if(marker.keys.indexOf(search) >= 0 && marker.keys.indexOf(selected_value) >= 0)
					marker.setVisible(true);
				else
					marker.setVisible(false);
			});
		}
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
    
    function center_map( map ) {
    
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
			map.setZoom( 16 );
        }
        else
        {
            // fit to bounds
              map.setCenter( bounds.getCenter() );
               map.setZoom( 5 ); // Change the zoom value as required
            //map.fitBounds( bounds ); // This is the default setting which I have uncommented to stop the World Map being repeated
    
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
			center_map(map);
			

    
        });
    
    
    });
    
    })(jQuery);
    