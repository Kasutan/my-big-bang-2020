<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_elements_acf_init' );
function mbb_acf_block_elements_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-elements',
			'title'           => 'Bloc elements',
			'description'     => 'Bloc elements.',
			'render_callback' => 'mbb_elements_callback',
			'category'        => 'mybigbang',
			'icon'            => 'admin-site',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'big bang', 'elements'],
		] );
	}
}

function mbb_elements_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$ancre = esc_attr( get_field('ancre') );
	$intro=wp_kses_post( get_field('intro') );
	$titre=wp_kses_post( get_field('titre') );
	printf('<section class="acf-block-elements alignfull avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($intro) printf('<div class="intro">%s</div>', $intro);
		printf('<h2 class="titre">%s</h2>',$titre);

		if( have_rows('elements', 'options') ):
			echo '<div class="elements">';
			// loop through the rows of data
			while ( have_rows('elements', 'options') ) : the_row();
				$nom=esc_attr(get_sub_field('nom')) ;
				printf('<div class="element %s">',strtolower($nom) );
					printf('<div class="nom %s"><h3>%s</h3><div class="picto"><img src="%s" alt="picto %s" height="105" weight="105"/></div></div>',
						strtolower($nom),
						$nom,
						get_stylesheet_directory_uri(  ).'/icons\/'.$nom.'.svg',
						$nom
					);
					printf('<ul class="mots-cles"><li>%s</li><li>%s</li><li>%s</li></ul>',
						esc_html(get_sub_field('mot_1')),
						esc_html(get_sub_field('mot_2')),
						esc_html(get_sub_field('mot_3')),
					);
					printf('<div class="texte">%s</div>',wp_kses_post(get_sub_field('description')));
				echo "</div>";
			endwhile;
			echo '</div>'; //fin .elements	
		endif;
	
	echo "</section>";

}