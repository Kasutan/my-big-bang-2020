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
	$search_keys=strtolower($address['post_code'].' '.$address['city'].' '.get_the_title());
	//Si besoin : concaténer d'autres critères de filtre
		if(!empty($lat) && !empty($lng)) :
			?>
			<li class="marker" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>" id="marker-<?php echo $post_id;?>" data-keys="<?php echo $search_keys; ?>">
				<p ><a class="etiquette" href="#studio-<?php echo $post_id; ?>" rel="bookmark"><strong>My Big Bang</strong> <?php echo get_the_title($post_id); ?> <span class="nom screen-reader-text"><?php echo get_the_title($post_id); ?></span></a><br> <span class="code"><?php echo $address['post_code'];?> <span class="ville"><?php echo $address['city'];?></p> 
		</li>
		<?php endif;
	return ob_get_clean();
}