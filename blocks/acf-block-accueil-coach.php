<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_coach_acf_init' );
function mbb_acf_block_coach_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-coach',
			'title'           => 'Bloc accueil coach',
			'description'     => 'Bloc coach pour la page d\'accueil.',
			'render_callback' => 'mbb_coach_callback',
			'category'        => 'mybigbang-home',
			'icon'            => 'admin-home',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
			),
			'keywords'        => [ 'image', 'big bang', 'accueil', 'coach'],
		] );
	}
}

function mbb_coach_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$ancre = esc_attr( get_field('ancre') );
	$image_id=esc_attr( get_field('image') );
	$titre=wp_kses_post( get_field('titre') );
	$texte=wp_kses_post( get_field('texte') );
	$eclairage=wp_kses_post( get_field('eclairage') );
	$mots=esc_attr( get_field('mots') );


	printf('<section class="acf-block-coach accueil avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		echo '<div class="part1">';
			if($titre) printf('<h2 class="titre h1">%s</h2>',$titre);
			if($mots) printf('<div class="mots">%s</div>',$mots);
		echo '</div>'; //fin .part1
		echo '<div class="part2">'; //display grid
			if($image_id) printf('<div class="image">%s</div>',	wp_get_attachment_image( $image_id,'medium' ));
			if($texte) printf('<div class="texte">%s',$texte);
			echo '</div>'; //fin .texte
		echo '</div>'; //fin .part2
			if($eclairage) printf('<div class="eclairage bleu"><div class="relief">%s</div></div>',$eclairage); 
			//eclair = bg img dans _eclairage + bg img plus large avec décor particules
	echo "</section>";

}