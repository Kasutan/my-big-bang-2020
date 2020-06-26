<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_rdv_acf_init' );
function mbb_acf_block_rdv_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-rdv',
			'title'           => 'Bloc rendez-vous',
			'description'     => 'Bloc rendez-vous pour page ma session avec picto et descriptif de chaque RDV.',
			'render_callback' => 'mbb_rdv_callback',
			'category'        => 'mybigbang',
			'icon'            => 'calendar-alt',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'rdv', 'session'],
		] );
	}
}

function mbb_rdv_callback( $block ) {
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

	printf('<section class="acf-block-rdv alignfull avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($titre) printf('<h2 class="h1">%s</h2>',$titre);
		if($intro) printf('<div class="intro">%s</div>', $intro);
		echo '<div class="decor"></div>';
		if($mots) printf('<div class="mots">%s</div>',$mots);	

		if( have_rows('rdv') ):
			echo '<div class="rdvs">';
			// loop through the rows of data
			while ( have_rows('rdv') ) : the_row();
				printf('<div class="rdv"><h3>RDV<br>%s</h3><div class="image">%s</div><div class="texte">%s</div>',
					esc_html(get_sub_field('titre')),
					wp_get_attachment_image( get_sub_field('image'),'small' ),
					wp_kses_post(get_sub_field('texte'))
				);
				$label=esc_html(get_sub_field(('label')));
				$cible=esc_url(get_sub_field(('cible')));
				if($label && $cible && function_exists('mbb_get_picto_inline')) {
					printf('<a class="cta-resultat" href="%s"><span>%s</span>', $cible, $label);
					echo mbb_get_picto_inline('fleche-cta').'</a>'; 
				} 
				echo '</div>'; //fin .rdv	
			endwhile;
			echo '</div>'; //fin .rdvs	
		endif;
	echo "</section>";

}