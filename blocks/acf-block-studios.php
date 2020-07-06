<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_studios_acf_init' );
function mbb_acf_block_studios_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-studios',
			'title'           => 'Bloc studios à proximité',
			'description'     => 'Bloc studios avec filtre, liste et carte',
			'render_callback' => 'mbb_studios_callback',
			'category'        => 'mybigbang-home',
			'icon'            => 'location-alt',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'studios', 'carte'],
		] );
	}
}

function mbb_studios_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$titre=wp_kses_post( get_field('titre') );
	$ancre = esc_attr( get_field('ancre') );

	$studios=get_posts(array(
		'post_type' => 'studio',
		'numberposts' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
	));
	if(count($studios)==0) {
		//s'il n'y a pas de studios, on arrête là
		return;
	}
	printf('<section class="acf-block-studios avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($titre) printf('<h2 class="titre">%s</h2>',$titre);
		echo '<div class="fond" id="studios">';
		?>
			<div class="filtre">
				<label for="studios-search" class="screen-reader-text">Rechercher un studio par nom, code postal ou ville</label>
				<input  id="studios-search" class="search" name="studios-search" type="search" placeholder="Nom, Code postal, Ville"/>
				<button class="avec-fleche">Rechercher</button>
			</div>

			<div class="onglets">
				<button id="toggle-liste" aria-controls="liste" aria-expanded="true">Voir la liste</button>
				<button id="toggle-carte" aria-controls="carte" aria-expanded="false">Voir la carte</button>
			</div>

			<div class="studios">
				<ul id="liste" class="list">
				<?php foreach($studios as $studio) :
					$post_id=$studio->ID; 
					mbb_affiche_studio($post_id);
				endforeach;?>
				</ul>
				<div class="carte" id="carte">
					<?php mbb_affiche_carte_studios($studios);?>
				</div>
			</div>
		</div>
	</section>
<?php
}

function mbb_affiche_carte_studios($studios) {
	echo '<div>Carte</div>';
}

function mbb_affiche_studio($post_id) {
	$location=get_field('adresse',$post_id);
	$ville=$location['city'];
	$code_postal=$location['post_code'];
	$adresse=mbb_prepare_adresse($location);

	$metro=get_field('metro',$post_id);
	$telephone=get_field('telephone',$post_id);

	//Données temporaires
	$ville='Bordeaux';
	$code_postal='33000';
	$adresse='125 rue Sainte Catherine, 33000 Bordeaux';

	printf('<li class="studio" id="studio-%s">',$post_id);
		printf('<p><span class="ville">%s</span> <span class="nom">%s</span></p>',$ville, get_the_title($post_id));
		printf('<p class="adresse">%s</p>',$adresse);
		printf('<p class="metro">%s</p>',$metro);
		printf('<a href="https://www.google.com/maps/dir/?api=1&destination=%s" class="itinéraire" target="_blank" title="Voir l\'itinéraire dans un nouvel onglet">Itinéraire</a>',urlencode($adresse));
		printf('<a href="tel:" class="telephone">%s</a>',$telephone, $telephone);
		printf('<p class="email">%s</p>',$email);
		printf('<a class="cta-resultat" href="%s"><span>%s</span>', get_the_permalink($post_id), 'Voir le studio');
		echo mbb_get_picto_inline('fleche-cta').'</a>'; 
	echo '</li>';
}

function mbb_prepare_adresse($location) {
	$adresse=array();
    foreach( array('street_number', 'street_name', 'post_code', 'city') as $i => $k ) {
        if( isset( $location[ $k ] ) ) {
            $adresse[]=$location[ $k ];
        }
	}
	$adresse=implode(', ',$adresse);
	return $adresse;
}