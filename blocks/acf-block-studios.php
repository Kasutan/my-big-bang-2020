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
		'orderby' => 'title',
		'order' => 'ASC',
	));
	if(count($studios)==0) {
		//s'il n'y a pas de studios, on arrête là
		return;
	}
	printf('<section class="acf-block-studios alignfull avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($titre) printf('<h2 class="h1">%s</h2>',$titre);
		echo '<div class="fond" id="studios">';
		?>
			<div class="filtre">
				<label for="studios-search" class="screen-reader-text">Rechercher un studio par nom, code postal ou ville</label>
				<input  id="studios-search" class="search" name="studios-search" type="search" placeholder="Nom, Code postal, Ville"/><button id="button-studios-search">
				<svg xmlns="http://www.w3.org/2000/svg" width="16.191" height="10.457" viewBox="0 0 16.191 10.457">
					<g id="Composant_14_3" data-name="Composant 14 – 3" transform="translate(0.652 0.921)">
						<line id="Ligne_47" data-name="Ligne 47" x1="14.463" transform="translate(0 4.379)" fill="#ebeae9" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.304"/>
						<path id="Tracé_515" data-name="Tracé 515" d="M200.987,194.055l3.956,4.339-3.956,4.275" transform="translate(-190.057 -194.055)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.304"/>
					</g>
					</svg>
					<span>Rechercher</span>
				</button>
				<p class="no-result">Aucun studio ne correspond à votre recherche</p>
			</div>

			<div class="onglets">
				<button id="toggle-liste" aria-controls="liste" aria-expanded="true">Voir la liste</button><button id="toggle-carte" aria-controls="carte" aria-expanded="false" class="inactif">Voir la carte</button>
			</div>

			<div class="studios">
				<ul id="liste" class="list">
				<?php foreach($studios as $studio) :
					$post_id=$studio->ID; 
					mbb_affiche_studio($post_id);
				endforeach;?>
				</ul>
				<?php mbb_affiche_carte_studios($studios);?>
			</div>
		</div>
	</section>
<?php
}


function mbb_affiche_studio($post_id) {
	$location=get_field('adresse',$post_id);
	$ville=$location['city'];
	$code_postal=$location['post_code'];
	//hack
	if($code_postal=='75116') $code_postal='75016';
	$adresse=mbb_prepare_adresse($location);

	$metro=get_field('metro',$post_id);
	$email=antispambot(esc_attr(get_field('email',$post_id)));
	$telephone=get_field('telephone',$post_id);
	//dissocier les 2 numéros s'il y en a 2 
	if(strpos($telephone,' / ')>0) {
		$array_tel=explode(' / ',$telephone);
		$telephone=$array_tel[0];
		$telephone_2=$array_tel[1];
	} else {
		$telephone_2='';
	}

	printf('<li class="studio" id="studio-%s">',$post_id);
		printf('<p class="screen-reader-text"><span class="ville">%s</span><span class="code_postal">%s</span></p>',$ville,$code_postal);//pour le filtre avec list.js
		printf('<p class="nom">%s</p>',get_the_title($post_id));
		printf('<p class="adresse">%s</p>',$adresse);
		printf('<p class="metro">%s</p>',$metro);
		printf('<a href="https://www.google.com/maps/dir/?api=1&destination=%s" class="itineraire" target="_blank" title="Voir l\'itinéraire dans un nouvel onglet">Itinéraire</a>',urlencode($adresse));
		printf('<a href="tel:%s" class="telephone">%s</a>',str_replace(' ', '', $telephone), $telephone);
		if($telephone_2) printf('<a href="tel:%s" class="telephone">%s</a>',str_replace(' ', '', $telephone_2), $telephone_2);
		printf('<p class="email">%s</p>',$email);
		printf('<a class="cta-resultat" href="%s"><span>%s</span>', get_the_permalink($post_id), 'Voir le studio');
		echo mbb_get_picto_inline('fleche-cta').'</a>'; 
	echo '</li>';
}

function mbb_prepare_adresse($location) {
	$adresse='';
	if( isset( $location[ 'street_number' ] ) ) {
		$adresse.=$location[ 'street_number' ].' ';
	}
	if($location['post_code']=='75116') $location['post_code']='75016';

	$adresse.=$location['street_name'].', '.$location['post_code'].' '.$location['city'];
	return $adresse;
}