<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_deux_colonnes_acf_init' );
function mbb_acf_block_deux_colonnes_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-deux-colonnes',
			'title'           => 'Bloc deux colonnes',
			'description'     => 'Bloc deux colonnes avec titre optionnel, image ou vidéo à gauche et texte WYSIWYG à droite',
			'render_callback' => 'mbb_deux_colonnes_callback',
			'category'        => 'mybigbang',
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

	$titre=wp_kses_post( get_field('titre') );
	$texte=wp_kses_post( get_field('texte') );
	$image = esc_attr( get_field('image') );
	$video = get_field('video');
	$titre_video=wp_kses_post( get_field('titre_video') );
	$inverser=esc_attr(get_field('inverser'));
	

	printf('<section class="acf-block-deux-colonnes alignfull %s %s">', $className, $inverser ? 'inverse' : '');
		if($titre) printf('<h2 class="titre">%s</h2>',$titre);
		if($image) {
			printf('<div class="image"> %s</div>',
				wp_get_attachment_image($image, 'large')
			);
		} else if($video) {
			echo '<div class="video">';
				if($titre_video) printf('<div class="titre-video">%s</div>',$titre_video);
				printf('<div class="embed-container">%s</div>',
					$video
				);
			echo '</div>';
		}
		
		printf('<div class="texte"> %s</div>',
			$texte
		);
	echo "</section>";

}