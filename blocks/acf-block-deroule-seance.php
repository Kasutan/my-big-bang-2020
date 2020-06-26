<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_deroule_seance_acf_init' );
function mbb_acf_block_deroule_seance_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-deroule-seance',
			'title'           => 'Bloc déroulé séance',
			'description'     => 'Bloc déroulé séance avec numéros et pictos pour la page Ma séance.',
			'render_callback' => 'mbb_deroule_seance_callback',
			'category'        => 'mybigbang',
			'icon'            => 'editor-ol',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'déroulé', 'séance'],
		] );
	}
}

function mbb_deroule_seance_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$titre=wp_kses_post( get_field('titre') );
	$picto_chrono = esc_attr( get_field('picto_chrono') );

	printf('<section class="acf-block-deroule-seance avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($titre) printf('<h2 class="titre h1">%s</h2>',$titre);
		if($picto_chrono) printf('<div class="picto-chrono">%s</div>',wp_get_attachment_image($picto_chrono));
		if( have_rows('etapes') ):
			echo '<ol class="etapes">';
			echo '<div class="pointilles"></div>';
			$num=1;
			// loop through the rows of data
			while ( have_rows('etapes') ) : the_row();
				if($num<10) : $chiffre="0".$num; else : $chiffre=$num; endif;
				printf('<li class="etape">
						<div class="texte">
							<div class="chiffre">0%s</div>
							<div class="titre"><strong><span>%s</span> %s </strong> %s</div>
						</div>
						<div class="picto desktop">%s</div>	
						<div class="picto mobile">%s</div>	
						</li>',
					$chiffre,
					wp_kses_post(get_sub_field('titre_1')),
					wp_kses_post(get_sub_field('titre_2')),
					wp_kses_post(get_sub_field('titre_3')),
					wp_get_attachment_image(esc_attr(get_sub_field('picto_desktop')),'medium'),
					wp_get_attachment_image(esc_attr(get_sub_field('picto_mobile')))
				);
			$num++;
			endwhile;
			echo '</ol>'; //fin .etapes
		endif;
	echo "</section>";

}