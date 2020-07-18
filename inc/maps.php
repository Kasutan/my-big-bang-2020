<?php 
//https://www.advancedcustomfields.com/resources/google-map/
//https://gist.github.com/neilgee/a8cf60790c275508c03dd06bc5b48683

// Enqueue Google Map scripts
function mbb_google_maps_scripts() {
	wp_register_script( 'maps-acf', get_template_directory_uri() . '/js/maps-acf.js', array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'google-maps-api', 'https://maps.googleapis.com/maps/api/js?key='.MAPS_API_KEY, null, null, true);
	
	if(is_page( 'mon-studio' ) || is_page( 'nos-studios-delectro-stimulation' ) || (is_single() && 'studio' == get_post_type()) ) {
		wp_enqueue_script('maps-acf');
		wp_enqueue_script('google-maps-api');
	}
}
add_action( 'wp_enqueue_scripts', 'mbb_google_maps_scripts' );  


//Define a custom function to render markup for a map from an array of WP objects 

function mbb_affiche_carte_studios($studios) {
	ob_start();
	echo '<div class="acf-map carte" id="carte"><ul class="list">';

	foreach($studios as $studio) :
		$post_id=$studio->ID; 
		$location=get_field('adresse',$post_id);
		if(!empty($location)) :
			echo mbb_get_studio_marker($post_id,$location);
		endif;
	endforeach;
	printf('</ul></div>');

	echo ob_get_clean();
}


function mbb_get_studio_marker($post_id,$address) {
	ob_start();
	$lat = $address['lat'];
	$lng = $address['lng'];
	if($address['post_code']=='75116') $address['post_code']='75016';

	$search_keys=strtolower($address['post_code'].' '.$address['city'].' '.get_the_title($post_id));
	//Si besoin : concaténer d'autres critères de filtre
		if(!empty($lat) && !empty($lng)) :
			?>
			<div class="marker" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>" id="marker-<?php echo $post_id;?>" data-keys="<?php echo $search_keys; ?>">
				<span class="etiquette"><strong>My Big Bang</strong> <?php echo get_the_title($post_id); ?> </span><br>
				<a href="<?php echo get_the_permalink($post_id);?>">Voir le studio</a>
			</div>
		<?php endif;
	return ob_get_clean();
}