<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_team_coach_acf_init' );
function mbb_acf_block_team_coach_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-team-coach',
			'title'           => 'Bloc ma team de coachs',
			'description'     => 'Bloc team coach avec portraits des coachs',
			'render_callback' => 'mbb_team_coach_callback',
			'category'        => 'mybigbang',
			'icon'            => 'nametag',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'team','coach'],
		] );
	}
}

function mbb_team_coach_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=wp_kses_post( get_field('titre') );
	$ancre = esc_attr( get_field('ancre') );
	$intro1=wp_kses_post( get_field('intro_1') );
	$intro2=wp_kses_post( get_field('intro_2') );
	$coachs=get_field('coachs'); //champ relationnel
	$label=esc_html(get_field('label'));
	$cible=esc_url(get_field('cible'));

	printf('<section class="acf-block-team-coachs avec-ancre alignfull %s"><span class="ancre" id="%s"></span>', $className, $ancre); 
		if($titre) printf('<h2 class="h1">%s</h2>',$titre);
		if($intro1) {
			printf('<div class="intro"><span>%s</span>', $intro1);
			if($intro2) printf('<span class="separateur">|</span><span>%s</span>', $intro2);
			echo '</div>';	
		}
		
		echo '<div class="fond"><div class="decor"><div class="decor-image"></div></div>';
		if($coachs) :
			echo '<div class="coachs-wrapper">'; //scroll horizontal
				printf( '<ul class="coachs" id="coachs" data-active="0" data-nombre="%s">',count($coachs));
				foreach($coachs as $coach) :
					$post_id=$coach->ID; 
					$element=mbb_get_element($post_id);
					$nom=get_the_title($post_id);
					$ville=esc_html(get_field('ville',$post_id));
					$studio=esc_html(get_field('studio',$post_id));
					$push=esc_html(get_field('zone_push',$post_id));
					$energie=esc_html(get_field('energie',$post_id));

					printf('<li class="coach %s">',strtolower($element));
						printf('<div class="image">%s</div>',get_the_post_thumbnail($post_id, 'medium'));
						echo '<div class="nom">';
							printf('<h3>%s</h3>',$nom);
							printf('<img src="%s" alt="" class="picto" height="50" width="50"/>',get_stylesheet_directory_uri(  ).'/icons/'.$element.'.svg');
						echo '</div>';
						printf('<ul class="infos"><span class="pointilles"></span>
							<li><span>%s</span> %s</li>
							<li><span>Le +</span> %s</li>
							<li><span>Mantra</span> %s</li>
							</ul>',
							$ville,
							$studio,
							$push,
							$energie
						);
						if($label && $cible && function_exists('mbb_get_picto_inline')) {
							printf('<a class="cta-resultat" href="%s"><span>%s</span>', $cible, $label);
							echo mbb_get_picto_inline('fleche-cta').'</a>'; 
						} 

						echo '</li>'; // fin li.coach
				endforeach;
				echo '</ul>'; // fin coachs
			echo '</div>'; // fin coachs-wrapper
		printf('<div class="fleches"><button class="fleche-coach gauche" data-direction="-1"><img alt="naviguer vers la gauche" src="%s"/></button> <button class="fleche-coach droite" data-direction="+1"><img alt="naviguer vers la droite" src="%s"/></button></div>', mbb_get_picto_url('Fleche-P-blanche'), mbb_get_picto_url('Fleche-S-blanche'));
		endif;
		echo '</div>'; // fin fond
	echo "</section>";

}