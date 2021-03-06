<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_etat_esprit_acf_init' );
function mbb_acf_block_etat_esprit_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-etat-esprit',
			'title'           => 'Bloc accueil philosophie',
			'description'     => 'Bloc philosophie pour la page d\'accueil. Ce bloc ne peut être inséré qu\'une fois par page.',
			'render_callback' => 'mbb_etat_esprit_callback',
			'category'        => 'mybigbang-home',
			'icon'            => 'admin-home',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'image', 'big bang', 'accueil', 'esprit'],
		] );
	}
}

function mbb_etat_esprit_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$ancre = esc_attr( get_field('ancre') );
	$image_id=esc_attr( get_field('image') );
	$titre=wp_kses_post( get_field('titre') );
	$intro=wp_kses_post( get_field('intro') );
	$texte=wp_kses_post( get_field('texte') );
	$label=esc_html(get_field('label'));
	$label_mobile=esc_html(get_field('label_mobile'));
	$cible=esc_url(get_field('cible'));
	$eclairage=wp_kses_post( get_field('eclairage') );
	$texte_duree=wp_kses_post( get_field('texte_duree') );
	$mots=esc_attr( get_field('mots') );


	printf('<section class="acf-block-etat-esprit accueil avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		echo '<div class="part1">';
			printf('<div class="silhouette"><img src="%s" alt="picto silhouette" /></div>', mbb_get_picto_url('Silhouette'));
			if($titre) printf('<h2 class="titre h1">%s</h2>',$titre);
			if($intro) printf('<div class="intro">%s</div>',$intro);
			if($mots) printf('<div class="mots">%s</div>',$mots);
		echo '</div>'; //fin .part1
		echo '<div class="part2">'; //display grid
			if($image_id) printf('<div class="image">%s</div>',	wp_get_attachment_image( $image_id,'medium' ));
			if($texte) printf('<div class="texte">%s',$texte);
				if($label && $cible) printf('<a href="%s" class="fleche"><span class="show-for-md">%s</span><span class="hide-for-md">%s</span></a>',$cible,$label,$label_mobile); //fleche = bg img (ds _navigation)
			echo '</div>'; //fin .texte
		echo '</div>'; //fin .part2
			if($eclairage) printf('<div class="eclairage"><div class="relief">%s</div></div>',$eclairage); 
			//eclair = bg img dans _eclairage + bg img plus large avec décor particules
		if($texte_duree) : 
			echo '<div class="part3">'; 
				printf('<div class="texte-duree">%s</div>',$texte_duree);
			echo '</div>'; //fin .part3	
		endif;
	echo "</section>";

}