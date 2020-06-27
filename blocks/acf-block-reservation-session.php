<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_reservation_session_acf_init' );
function mbb_acf_block_reservation_session_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-reservation-session',
			'title'           => 'Bloc réservation de ma section',
			'description'     => 'Bloc avec toutes les sessions et navigation par type de session',
			'render_callback' => 'mbb_reservation_session_callback',
			'category'        => 'mybigbang',
			'icon'            => 'calendar-alt',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'session','reservation'],
		] );
	}
}

function mbb_reservation_session_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=wp_kses_post( get_field('titre') );
	$ancre = esc_attr( get_field('ancre') );
	$intro=wp_kses_post( get_field('intro') );
	$label=esc_html(get_field('label'));
	$cible=esc_url(get_field('cible'));
	$eclairage=wp_kses_post( get_field('eclairage') );

	//On cherche tous les types de sessions
	$types_sessions= get_terms( array(
		'taxonomy' => 'type_sessions',
		'orderby' => 'term_id',
	) );

	//On cherche toutes les sessions pour chaque type
	$sessions=array();
	foreach($types_sessions as $type) {
		$term_id=$type->term_id;
		$sessions[$term_id]=get_posts(array(
			'post_type' => 'session',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'tax_query' => array(
				array(
					'taxonomy' => 'type_sessions',
					'terms'    => $term_id
				)
			)
		));
	}

	if(count($sessions)==0) {
		//s'il n'y a pas de sessions, on arrête là
		return;
	}
	$positions=array(); //on remplit avec la position de la première session pour chaque type
	$cumul=1;
	foreach($sessions as $term_id=>$sessions_courantes) {
		$positions[$term_id]=$cumul;
		$cumul+=count($sessions_courantes);
		$count++;
	}
	$total=$cumul-1; //nbre total de sessions
	
	printf('<section class="acf-block-reservation-sessions avec-ancre alignfull %s"><span class="ancre" id="%s"></span>', $className, $ancre); 
		if($titre) printf('<h2 class="h1">%s</h2>',$titre);
		if($intro) printf('<div class="intro">%s</div>', $intro);
		if($label && $cible && function_exists('mbb_get_picto_inline')) {
			printf('<a class="cta-resultat" href="%s"><span>%s</span>', $cible, $label);
			echo mbb_get_picto_inline('fleche-cta').'</a>'; 
		}
		
		echo '<div class="contenu"><div class="decor"></div>';
		
		echo '<nav class="navigation">';
		$count=1;
		foreach($types_sessions as $type) {
			$term_id=$type->term_id;
			printf('<button class="type-%s" data-type="%s" data-left="%s">%s</button>',
				$count,
				$term_id,
				$positions[$term_id],
				$type->name
			);
			$count++;
		}
		printf('<div class="fleches"><button class="fleche-session gauche" data-direction="-1"><img alt="naviguer vers la gauche" src="%s"/></button> <button class="fleche-session droite" data-direction="+1"><img alt="naviguer vers la droite" src="%s"/></button></div>', mbb_get_picto_url('Fleche-P-blanche'), mbb_get_picto_url('Fleche-S-blanche'));
		echo '</nav>';

		echo '<div class="sessions-wrapper">'; //scroll horizontal
			printf( '<ul class="sessions" id="sessions" data-active="0" data-nombre="%s">',$total);
			$count=1; //pour compter les types de sessions
			$count2=1; //pour compter les sessions
			foreach($sessions as $term_id=>$sessions_courantes) :
				foreach($sessions_courantes as $session) :
					$post_id=$session->ID; 
					$nom=get_the_title($post_id);
					$prix=esc_html(get_field('prix',$post_id));
					$prix_dessus=wp_kses_post( get_field('prix_dessus',$post_id) );
					$prix_dessous=wp_kses_post( get_field('prix_dessous',$post_id) );
					$prix_cote=wp_kses_post( get_field('prix_cote',$post_id) );
					$label=esc_html(get_field('label',$post_id));
					$cible=esc_url(get_field('cible',$post_id));

					printf('<li class="session type-%s" data-type="%s" data-session"%s">',$count,$term_id,$count2);
						printf('<h3>%s</h3>',$nom);
						if($prix_dessus) printf('<div class="prix_dessus">%s</div>',$prix_dessus);
						if($prix) printf('<div class="prix">%s<span>%s</span></div>',$prix,$prix_cote);
						if($prix_dessous) printf('<div class="prix_dessous">%s</div>',$prix_dessous);
						
						if($label && $cible && function_exists('mbb_get_picto_inline')) {
							printf('<a class="cta-resultat" href="%s"><span>%s</span>', $cible, $label);
							echo mbb_get_picto_inline('fleche-cta').'</a>'; 
						} elseif ($label) {
							printf('<div class="info">%s</div>',$label);
						}

					echo '</li>'; // fin li.session
					$count2++;
				endforeach; //fin des sessions de ce type
				$count++;
			endforeach;
			echo '</ul>'; // fin de toutes les sessions
		echo '</div>'; // fin sessions-wrapper
			if($eclairage) printf('<div class="eclairage"><div class="relief">%s</div></div>',$eclairage); 
			//eclair = bg img dans _eclairage
		echo '</div>'; // fin contenu
	echo "</section>";
}