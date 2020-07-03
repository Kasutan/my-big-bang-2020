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
	printf('<section class="acf-block-presse avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($titre) printf('<h2 class="titre">%s</h2>',$titre);
		if( have_rows('presse') ): 
			echo '<div class="owl-carousel owl-theme">';
			while ( have_rows('presse') ) : the_row();
				printf('<a class="logo-presse" href="%s"  target="_blank" rel="nofollow noopener" >%s</a>',
					esc_url(get_sub_field('url')),
					wp_get_attachment_image( get_sub_field('image'),'small' )
				);
			endwhile;
			echo '</div>'; //fin .owl-carousel
		endif;
	
	echo "</section>";

}