<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_temoignages_acf_init' );
function mbb_acf_block_temoignages_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-temoignages',
			'title'           => 'Bloc témoignages LP',
			'description'     => 'Bloc témoignages pour landing page',
			'render_callback' => 'mbb_temoignages_callback',
			'category'        => 'mybigbang',
			'icon'            => 'format-quote',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'big bang', 'temoignage','team'],
		] );
	}
}

function mbb_temoignages_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=wp_kses_post( get_field('titre') );
	$image_id=esc_attr( get_field('image') ); //copie d'écran des témoignages
	$galerie=get_field('galerie');


	printf('<section class="acf-block-temoignages alignfull %s">', $className); 
		echo '<div class="fond"><div class="decor"></div>';
			if($titre) printf('<h2>%s</h2>',$titre);
			if($image_id) :
				echo '<div class="contenu">'; 
					printf('<div class="temoignages">%s</div>',wp_get_attachment_image( $image_id, 'large'));
					echo '<div class="galerie">';
						foreach( $galerie as $i ) {
							printf('<div class="image-wrapper">%s</div>',
								wp_get_attachment_image( $i, 'large')
							);
						}
					echo '</div>';
				echo '<div>';//fin contenu
			endif;
		echo '</div>'; // fin fond
	echo "</section>";

}