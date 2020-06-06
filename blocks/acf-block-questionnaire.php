<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_banniere_acf_init' );
function mbb_acf_block_banniere_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-banniere',
			'title'           => 'Bloc questionnaire avec grande image',
			'description'     => 'Bloc questionnaire avec grande image pour découvrir l\'élément du visiteur. Ce bloc ne peut être inséré qu\'une fois par page.',
			'render_callback' => 'mbb_questionnaire_callback',
			'category'        => 'mybigbang',
			'icon'            => 'editor-help',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'image', 'big bang', 'questionnaire'],
		] );
	}
}

function mbb_questionnaire_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$image_id=esc_attr( get_field('image') );
	$titre=wp_kses_post( get_field('titre') );
	$intro=wp_kses_post( get_field('intro') );
	$formulaire_id=esc_attr( get_field('formulaire') );
	printf('<section class="acf-block-questionnaire %s">', $className);
		printf('<div class="image">%s</div>',	wp_get_attachment_image( $image_id,'large' ));
		printf('<div class="texte"><h2 class="titre">%s</h2><div class="questionnaire"><div class="intro">%s</div>%s</div></div>', 
			$titre, $intro, Caldera_Forms::render_form($formulaire_id)
		);
	
	echo "</section>";

}