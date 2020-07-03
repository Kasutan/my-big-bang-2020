<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_deux_colonnes_acf_init' );
function mbb_acf_block_deux_colonnes_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-deux-colonnes',
			'title'           => 'Bloc deux colonnes',
			'description'     => 'Bloc deux colonnes avec image à gauche et texte WYSIWYG à droite',
			'render_callback' => 'mbb_deux_colonnes_callback',
			'category'        => 'mybigbang-home',
			'icon'            => 'align-left',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'colonnes'],
		] );
	}
}

function mbb_deux_colonnes_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$texte=wp_kses_post( get_field('texte') );
	$image = esc_attr( get_field('image') );
	

	printf('<section class="acf-block-deux-colonnes alignfull %s">', $className);

		printf('<div class="image"> %s</div>',
			wp_get_attachment_image($image, 'large')
		);
		printf('<div class="texte"> %s</div>',
			$texte
		);
	echo "</section>";

}