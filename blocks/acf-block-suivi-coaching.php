<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_suivi_coaching_acf_init' );
function mbb_acf_block_suivi_coaching_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-suivi-coaching',
			'title'           => 'Bloc suivi coaching',
			'description'     => 'Bloc suivi coaching avec 2 zones texte + image pour la page Ma team.',
			'render_callback' => 'mbb_suivi_coaching_callback',
			'category'        => 'mybigbang',
			'icon'            => 'visibility',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'coach', 'suivi'],
		] );
	}
}

function mbb_suivi_coaching_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$titre=wp_kses_post( get_field('titre') );
	$ancre = esc_attr( get_field('ancre') );

	printf('<section class="acf-block-suivi-coaching alignfull avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($titre) printf('<h2 class="titre h1">%s</h2>',$titre);
		if( have_rows('zones') ):
			// loop through the rows of data
			while ( have_rows('zones') ) : the_row();
				printf('<div class="zone">
							<div class="image">%s</div>
							<div class="texte-wrap">
								<h3>%s</h3>
								<div class="texte">%s</div>
							</div>
						</div>',
					wp_get_attachment_image(get_sub_field('image'), 'medium'),
					esc_html(get_sub_field('titre')),
					wp_kses_post(get_sub_field('texte'))
				);
			endwhile;
		endif;
	echo "</section>";

}