<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_valeurs_acf_init' );
function mbb_acf_block_valeurs_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-valeurs',
			'title'           => 'Bloc valeurs avec 3 pictos',
			'description'     => 'Bloc valeurs avec 3 pictos.',
			'render_callback' => 'mbb_valeurs_callback',
			'category'        => 'mybigbang-home',
			'icon'            => 'image-filter',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'valeurs'],
		] );
	}
}

function mbb_valeurs_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$intro=wp_kses_post( get_field('intro') );
	$titre=wp_kses_post( get_field('titre') );
	$ancre = esc_attr( get_field('ancre') );
	printf('<section class="acf-block-valeurs alignfull avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($titre) printf('<h2 class="screen-reader-text">%s</h2>',$titre);
		if($intro) printf('<div class="intro">%s</div>', $intro);
		if( have_rows('valeurs') ):
			echo '<div class="slider-container"><div class="valeurs slider" data-active="0" data-nombre="3">';
			// loop through the rows of data
			while ( have_rows('valeurs') ) : the_row();
				printf('<div class="valeur"><div class="image">%s</div><h3>%s</h3><div class="texte">%s</div></div>',
					wp_get_attachment_image( get_sub_field('image'),'small' ),
					esc_html(get_sub_field('titre')),
					wp_kses_post(get_sub_field('texte'))
				);
	
			endwhile;
			echo '</div>'; //fin .valeurs	

			printf('<div class="fleches"><button class="fleche-slider gauche" data-direction="-1"><img alt="naviguer vers la gauche" src="%s"/></button> <button class="fleche-slider droite"  data-direction="+1"><img alt="naviguer vers la droite" src="%s"/></button></div>', mbb_get_picto_url('Fleche-P-blanche'), mbb_get_picto_url('Fleche-S-blanche'));
			echo '</div>'; //fin .slider-container	
		endif;
	
	echo "</section>";

}