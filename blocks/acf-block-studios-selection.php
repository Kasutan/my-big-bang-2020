<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'mbb_acf_block_studios_selection_acf_init' );
function mbb_acf_block_studios_selection_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-studios-selection',
			'title'           => 'Bloc carte avec une sélection de studios',
			'description'     => 'Bloc studios sélectionnés avec carte',
			'render_callback' => 'mbb_studios_selection_callback',
			'category'        => 'mybigbang',
			'icon'            => 'location-alt',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'big bang', 'studios', 'carte'],
		] );
	}
}

function mbb_studios_selection_callback( $block ) {
	if( !function_exists("get_field") || !function_exists('mbb_affiche_carte_studios')) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$studios=get_field('studios');
	
	if(!is_array($studios) || count($studios)==0) {
		//s'il n'y a pas de studios, on arrête là
		return;
	}
	printf('<section class="acf-block-studios-selection alignfull">', $className);
		mbb_affiche_carte_studios($studios);
	echo '</section>';
}