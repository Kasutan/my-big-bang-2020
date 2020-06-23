<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_coach_personnel_acf_init' );
function mbb_acf_block_coach_personnel_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-coach-personnel',
			'title'           => 'Bloc coach personnel',
			'description'     => 'Bloc coach personnel avec 6 avantages pour la page Ma team.',
			'render_callback' => 'mbb_coach_personnel_callback',
			'category'        => 'mybigbang',
			'icon'            => 'editor-ol',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'coach', 'team'],
		] );
	}
}

function mbb_coach_personnel_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$intro=wp_kses_post( get_field('intro') );
	$titre=wp_kses_post( get_field('titre') );
	$ancre = esc_attr( get_field('ancre') );
	$mots=esc_attr( get_field('mots') );

	printf('<section class="acf-block-coach-personnel alignfull avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($titre) printf('<h2 class="titre h1">%s</h2>',$titre);
		echo '<div class="fond">';
		if($intro) printf('<div class="intro">%s</div>', $intro);
		if( have_rows('avantages') ):
			echo '<ol class="avantages">';
			echo '<div class="pointilles"></div>';
			$num=1;
			// loop through the rows of data
			while ( have_rows('avantages') ) : the_row();
				printf('<li class="avantage"><div class="decor"></div><div class="chiffre">0%s</div><h3>%s</h3><div class="texte">%s</div></li>',
					$num,
					esc_html(get_sub_field('titre')),
					wp_kses_post(get_sub_field('texte'))
				);
			$num++;
			endwhile;
			echo '</ol>'; //fin .avantages
		endif;
		echo '</div>'; //fin .fond
		if($mots) printf('<div class="mots">%s</div>',$mots);	
	echo "</section>";

}