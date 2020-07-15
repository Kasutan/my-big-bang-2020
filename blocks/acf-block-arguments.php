<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_arguments_acf_init' );
function mbb_acf_block_arguments_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-arguments',
			'title'           => 'Bloc arguments LP',
			'description'     => 'Bloc arguments numérotés pour les landing pages.',
			'render_callback' => 'mbb_arguments_callback',
			'category'        => 'mybigbang',
			'icon'            => 'editor-ol',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'big bang', 'landing', 'argument'],
		] );
	}
}

function mbb_arguments_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$titre=wp_kses_post( get_field('titre') );

	printf('<section class="acf-block-arguments %s">', $className);
		if($titre) printf('<h2 class="titre screen-reader-text">%s</h2>',$titre);
		if( have_rows('arguments') ):
			echo '<ol class="arguments">';
			echo '<div class="pointilles"></div>';
			$num=1;
			// loop through the rows of data
			while ( have_rows('arguments') ) : the_row();
				printf('<li class="argument"><div class="decor"></div><div class="chiffre">0%s</div><h3>%s</h3><div class="texte">%s</div></li>',
					$num,
					esc_html(get_sub_field('titre')),
					wp_kses_post(get_sub_field('texte'))
				);
			$num++;
			endwhile;
			echo '</ol>'; //fin .arguments
		endif;
	echo "</section>";
}