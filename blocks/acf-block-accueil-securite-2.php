<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_securite_2_acf_init' );
function mbb_acf_block_securite_2_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-securite-2',
			'title'           => 'Bloc accueil sécurité 2',
			'description'     => 'Deuxième bloc sécurité pour la page d\'accueil. Ce bloc ne peut être inséré qu\'une fois par page.',
			'render_callback' => 'mbb_securite_2_callback',
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

function mbb_securite_2_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$image_id=esc_attr( get_field('image') );
	$texte=wp_kses_post( get_field('texte') );
	$eclairage=wp_kses_post( get_field('eclairage') );
	$mots=esc_attr( get_field('mots') );


	printf('<section class="acf-block-securite-2 accueil %s">', $className);
		echo '<div class="part1">';
			if($mots) printf('<div class="mots">%s</div>',$mots);
		echo '</div>'; //fin .part1
		echo '<div class="part2">'; //display grid
			if($texte) printf('<div class="texte">%s</div>',$texte);
			if($image_id) printf('<div class="image">%s</div>',	wp_get_attachment_image( $image_id,'medium' ));
		echo '</div>'; //fin .part2
			if($eclairage) printf('<div class="eclairage inverse"><div class="relief">%s</div></div>',$eclairage); 
			//eclair = bg img dans _eclairage + bg img plus large avec décor particules
	echo "</section>";

}