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

function mbb_carte_studios($the_query,$contexte) {
	ob_start();

	if( $the_query->have_posts() ):
		printf('<div class="acf-map %s" id="carte-studios"><ul class="list">',$contexte);
		while ( $the_query->have_posts() ) : $the_query->the_post(); 
			$post_id=get_the_ID();
			$adresse1=get_field('adresse_acf_1',$post_id);
			$adresse2=get_field('adresse_acf_2',$post_id);
			$clientele_profil=get_field('clientele_profil',$post_id);
			$clientele=mbb_clientele($clientele_profil);

		
			if(!empty($adresse1)) :
				echo mbb_get_profile_marker($post_id,$adresse1,1,$clientele);
			endif;
			if(!empty($adresse2)) :
				echo mbb_get_profile_marker($post_id,$adresse2,2,$clientele);
			endif;
		endwhile;
		printf('</ul></div>');
	wp_reset_postdata();
	endif; 

	return ob_get_clean();
}


function mbb_get_profile_marker($post_id,$address,$i,$clientele) {
	ob_start();
	$lat = $address['lat'];
	$lng = $address['lng'];
	$search_keys=strtolower($address['post_code'].' '.$address['city'].' '.get_the_title().' '.$clientele);
	//Si besoin : concaténer d'autres critères de filtre
		if(!empty($lat) && !empty($lng)) :
			?>
			<li class="marker" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>" id="marker-<?php echo $post_id.'-'.$i;?>" data-keys="<?php echo $search_keys; ?>">
				<p><a href="/annuaire-des-therapeutes/#therapeute-<?php echo $post_id; ?>" rel="bookmark" class="nom"> <?php the_title(); ?></a> <span class="code"><?php echo $address['post_code'];?> <span class="ville"><?php echo $address['city'];?></p> 
		</li>
		<?php endif;
	return ob_get_clean();
}