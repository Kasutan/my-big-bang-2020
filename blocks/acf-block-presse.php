<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_presse_acf_init' );
function mbb_acf_block_presse_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-presse',
			'title'           => 'Bloc presse',
			'description'     => 'Bloc presse avec carrousel de logos cliquables',
			'render_callback' => 'mbb_presse_callback',
			'category'        => 'mybigbang-home',
			'icon'            => 'paperclip',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'presse'],
		] );
	}
}

function mbb_presse_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$titre=wp_kses_post( get_field('titre') );
	$ancre = esc_attr( get_field('ancre') );
	$count=0; // compte le nombre de logos déjà insérés - on commence à zéro
	printf('<section class="acf-block-presse avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($titre) printf('<h2 class="titre">%s</h2>',$titre);
		if( have_rows('presse') ): 
			echo '<div class="owl-carousel owl-theme">';
			echo '<div class="slide">'; // on ouvre la première slide
			while ( have_rows('presse') ) : the_row();
				if($count!=0 && $count % 4 ==0) echo '</div><div class="slide">'; // on prépare une nouvelle slide tous les 4 logos
				printf('<a class="logo-presse" href="%s"  target="_blank" rel="nofollow noopener" >%s</a>',
					esc_url(get_sub_field('url')),
					wp_get_attachment_image( get_sub_field('image'))
				);
				$count++;
			endwhile;
			echo '</div>'; // on ferme la dernière slide
			echo '</div>'; //fin .owl-carousel
		endif;
	
	echo "</section>";

}