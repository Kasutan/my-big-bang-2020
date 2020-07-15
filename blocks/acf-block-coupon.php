<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_coupon_acf_init' );
function mbb_acf_block_coupon_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-coupon',
			'title'           => 'Bloc coupon LP',
			'description'     => 'Bloc coupon avec image, titre et questionnaire pour landing page',
			'render_callback' => 'mbb_coupon_callback',
			'category'        => 'mybigbang',
			'icon'            => 'tickets-alt',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'big bang', 'coupon', 'landing'],
		] );
	}
}

function mbb_coupon_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=wp_kses_post( get_field('titre') );
	$formulaire=wp_kses_post( get_field('formulaire') );
	$image = esc_attr( get_field('image') );
	

	printf('<section class="acf-block-coupon alignfull %s">', $className);
		if($image) {
			printf('<div class="image"> %s</div>',
				wp_get_attachment_image($image, 'large')
			);
		}
		
		printf('<div class="texte"><h2 class="titre">%s</h2><div class="formulaire">%s</div></div>',
			$titre,$formulaire
		);
	echo "</section>";

}