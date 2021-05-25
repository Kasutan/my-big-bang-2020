<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_actus_franchises_acf_init' );
function mbb_acf_block_actus_franchises_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-actus-franchises',
			'title'           => 'Bloc slider actualités franchises',
			'description'     => 'Bloc slider avec 3 actus franchises',
			'render_callback' => 'mbb_actus_franchises_callback',
			'category'        => 'mybigbang-home',
			'icon'            => 'slider',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'big bang', 'actu', 'franchise','slider'],
		] );
	}
}

function mbb_actus_franchises_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre_section=wp_kses_post( get_field('titre') );
	$ancre = esc_attr( get_field('ancre') );

	if( have_rows('actus') ):

		printf('<section class="acf-block-actus-franchises avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);

			if($titre_section) printf('<h2 class="titre-section">%s</h2>',$titre_section);

			echo '<ul class="actus owl-carousel owl-theme">';
			while ( have_rows('actus') ) : the_row();
				$titre=wp_kses_post(get_sub_field('titre'));
				$texte=wp_kses_post(get_sub_field('texte'));
				$image=esc_attr(get_sub_field('image'));

				echo '<li class="actu">';
					printf('<div class="image"><div class="image-wrapper">%s</div></div>',wp_get_attachment_image( $image, 'medium'));
		
					echo '<div class="texte">';
						printf('<h3 class="titre">%s</h3>',$titre);
						printf('<div class="extrait">%s</div>', $texte);
					echo '</div>'; //fin .texte
				echo '</li>'; //fin .actu
			endwhile;
			echo '</ul>'; //fin ul.actus
	
		echo "</section>";
	
	endif;

}