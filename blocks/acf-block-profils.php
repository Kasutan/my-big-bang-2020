<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_profils_acf_init' );
function mbb_acf_block_profils_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-profils',
			'title'           => 'Bloc profils',
			'description'     => 'Bloc avec carrousel de profils',
			'render_callback' => 'mbb_profils_callback',
			'category'        => 'mybigbang-home',
			'icon'            => 'universal-access',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'big bang', 'profil','slider','carrousel'],
		] );
	}
}

function mbb_profils_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$titre=wp_kses_post( get_field('titre') );
	$ancre = esc_attr( get_field('ancre') );
	$profils=get_field('profils');
	$label=esc_html(get_field('label'));
	$cible=esc_url(get_field('cible'));

	printf('<section class="acf-block-profils avec-ancre %s"><span class="ancre" id="%s"></span>', $className, $ancre);
		if($titre) printf('<h2 class="titre">%s</h2>',$titre);
		if( $profils ): 
			echo '<ul class="profils owl-carousel owl-theme alignfull">';
			foreach( $profils as $p):
				$post_id=$p->ID; 
				$element=mbb_get_element($post_id);
				$besoins=mbb_get_besoins($post_id);
				$conseil=wp_kses_post(get_field('conseil',$post_id));
				$nom=get_the_title($post_id);
				printf('<li class="profil %s">',strtolower($element));
					printf('<div class="image">%s</div>',get_the_post_thumbnail($post_id, 'medium'));
					echo '<div class="texte">';
						printf('<img src="%s" alt="" class="picto-desktop" height="61" weight="61"/>',get_stylesheet_directory_uri(  ).'/icons\/'.$element.'.svg');
						printf('<div class="description">%s</div>',wp_kses_post(get_field('description',$post_id)));
						printf('<div class="element"><p class="contraste">Son élément</p><p>%s</p><img src="%s" alt="" class="picto-mobile" height="61" weight="61"/></div>',$element,get_stylesheet_directory_uri(  ).'/icons\/'.$element.'.svg');
						printf('<div class="besoins"><p class="contraste">Ses besoins</p><p>%s</p></div>',$besoins);
					echo '</div>';//fin .texte 
					if($conseil) :
						echo '<div class="bloc-conseil">';
							echo '<div class="decor-mobile"></div>';
							echo '<div class="relief"><p class="titre-conseil">Conseil de coach</p>';
								printf('<div class="conseil">%s</div>',$conseil);
								printf('<p>Votre profil est proche de celui de %s&nbsp;?</p>',$nom);
								if($label && $cible) printf('<a href="%s" class="fleche inverse">%s</a>',$cible,$label); 
							echo '</div>'; 
						echo '</div>';
					endif;
				echo '</li>';
			endforeach; 
			echo '</ul>';
		endif; 
	echo "</section>";

}