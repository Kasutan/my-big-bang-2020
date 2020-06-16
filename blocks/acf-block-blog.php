<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_blog_acf_init' );
function mbb_acf_block_blog_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-blog',
			'title'           => 'Bloc blog',
			'description'     => 'Bloc blog avec article le plus récent',
			'render_callback' => 'mbb_blog_callback',
			'category'        => 'mybigbang-home',
			'icon'            => 'format-aside',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'blog'],
		] );
	}
}

function mbb_blog_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=wp_kses_post( get_field('titre') );
	$ancre = esc_attr( get_field('ancre') );
	$label=esc_html(get_field('label'));
	$cible=esc_url(get_field('cible'));
	$post_id=get_posts(array('numberposts' => 1))[0]->ID; // le dernier post publié

	printf('<section class="acf-block-blog avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($titre) printf('<h2 class="titre">%s</h2>',$titre);

		printf('<a class="image" href="%s"><div class="image-wrapper">%s</div></a>',
			get_the_permalink( $post_id),
			get_the_post_thumbnail( $post_id, 'medium')
		);
		echo '<div class="texte">';
			printf('<span class="date">%s</span>', get_the_date('',$post_id));
			printf('<a class="titre" href="%s"><h3>%s</h3></a>', get_the_permalink( $post_id),get_the_title($post_id));
			printf('<div class="extrait">%s</div>', get_the_excerpt($post_id));
		
			if($label && $cible) printf('<a href="%s" class="fleche">%s</a>',$cible,$label); //fleche = bg img (ds _navigation)
		echo '</div>'; //fin .texte
	echo "</section>";

}