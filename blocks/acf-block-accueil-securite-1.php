<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_securite_1_acf_init' );
function mbb_acf_block_securite_1_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-securite-1',
			'title'           => 'Bloc accueil sécurité 1',
			'description'     => 'Premier bloc sécurité pour la page d\'accueil. Ce bloc ne peut être inséré qu\'une fois par page.',
			'render_callback' => 'mbb_securite_1_callback',
			'category'        => 'mybigbang-home',
			'icon'            => 'admin-home',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'image', 'big bang', 'accueil', 'securite'],
		] );
	}
}

function mbb_securite_1_callback( $block ) {
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
	$eclairage=wp_kses_post( get_field('eclairage') );


	printf('<section class="acf-block-securite-1 accueil avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		echo '<div class="part1">';
			printf('<div class="silhouette"><img src="%s" alt="picto silhouette" /></div>', mbb_get_picto_url('Silhouette'));
			if($titre) printf('<h2 class="titre h1">%s</h2>',$titre);
			if($intro) printf('<div class="intro">%s</div>',$intro);
		echo '</div>'; //fin .part1
		echo '<div class="part2">'; //display grid
			if($image_id) printf('<div class="image">%s</div>',	wp_get_attachment_image( $image_id,'medium' ));
			if($texte) printf('<div class="texte">%s</div>',$texte);
		echo '</div>'; //fin .part2
			if($eclairage) printf('<div class="eclairage"><div class="relief">%s</div></div>',$eclairage); 
			//eclair = bg img dans _eclairage + bg img plus large avec décor particules
	echo "</section>";

}