<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_facteurs_acf_init' );
function mbb_acf_block_facteurs_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-facteurs',
			'title'           => 'Bloc facteurs de succès LP',
			'description'     => 'Bloc facteurs de succès avec image, texte et éclairage pour landing page.',
			'render_callback' => 'mbb_facteurs_callback',
			'category'        => 'mybigbang',
			'icon'            => 'editor-ul',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
			),
			'keywords'        => [ 'landing', 'big bang', 'succes', 'facteur'],
		] );
	}
}

function mbb_facteurs_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$image_id=esc_attr( get_field('image') );
	$texte=wp_kses_post( get_field('texte') );
	$eclairage=wp_kses_post( get_field('eclairage') );
	$definition= get_field('definition');



	printf('<section class="acf-block-facteurs accueil %s">', $className);
		echo '<div class="part2">'; //display grid
			if($image_id) printf('<div class="image">%s</div>',	wp_get_attachment_image( $image_id,'large' ));
			if($texte) printf('<div class="texte">%s</div>',$texte);
		echo '</div>'; //fin .part2
			if($eclairage) printf('<div class="eclairage bleu"><div class="relief">%s</div></div>',$eclairage); 
			//eclair = bg img dans _eclairage + bg img plus large avec décor particules
		if($definition) printf('<div class="definition">%s</div>',$definition);
	echo "</section>";

}