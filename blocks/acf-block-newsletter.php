<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_newsletter_acf_init' );
function mbb_acf_block_newsletter_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-newsletter',
			'title'           => 'Bloc newsletter',
			'description'     => 'Bloc inscription newsletter',
			'render_callback' => 'mbb_newsletter_callback',
			'category'        => 'mybigbang-home',
			'icon'            => 'email-alt2',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'newsletter'],
		] );
	}
}

function mbb_newsletter_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=wp_kses_post( get_field('titre') );
	$intro=wp_kses_post( get_field('intro') );
	$formulaire=get_field('formulaire');
	

	printf('<section class="acf-block-newsletter alignfull %s">', $className);
		//decor en bg de la section
		echo '<div class="newsletter">';
			if($titre) printf('<h2 class="titre">%s</h2>',$titre);
			if($intro) printf('<div class="intro">%s</div>',$intro);
			if($formulaire) printf('<div class="formulaire">%s</div>',$formulaire);
		echo '</div>';
	echo "</section>";

}