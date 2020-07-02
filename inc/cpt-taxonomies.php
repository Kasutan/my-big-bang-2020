<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/***************************************************************
	Custom Taxonomy Elements
/***************************************************************/

add_action( 'init', 'create_element_tag', 0 );
function create_element_tag() {
// Labels part for the GUI
$labels = array(
	'name' => _x( 'Eléments', 'taxonomy general name' ),
	'singular_name' => _x( 'Elément', 'taxonomy singular name' ),
	'menu_name' => __( 'Eléments' ),
); 
register_taxonomy('element','profil',array(
	'hierarchical' => true,
	'labels' => $labels,
	'show_ui' => true,
	'show_admin_column' => true,
	'query_var' => false,
	'public' => false,
	'show_in_rest' => true
));
}

add_action( 'init', 'create_besoin_tag', 0 );
function create_besoin_tag() {
// Labels part for the GUI
$labels = array(
	'name' => _x( 'Besoins', 'taxonomy general name' ),
	'singular_name' => _x( 'Besoin', 'taxonomy singular name' ),
	'menu_name' => __( 'Besoins' ),
); 
register_taxonomy('besoin','profil',array(
	'hierarchical' => false,
	'labels' => $labels,
	'show_ui' => true,
	'show_admin_column' => true,
	'query_var' => false,
	'public' => false,
	'show_in_rest' => true
));
}

add_action( 'init', 'create_session_tag', 0 );
function create_session_tag() {
// Labels part for the GUI
$labels = array(
	'name' => _x( 'Types de sessions', 'taxonomy general name' ),
	'singular_name' => _x( 'Type de sessions', 'taxonomy singular name' ),
	'menu_name' => __( 'Types de sessions' ),
); 
register_taxonomy('type_sessions','session',array(
	'hierarchical' => true,
	'labels' => $labels,
	'show_ui' => true,
	'show_admin_column' => true,
	'query_var' => false,
	'public' => false,
	'show_in_rest' => true
));
}



/***************************************************************
	Custom Post Type : profil
/***************************************************************/
function mbb_profil_post_type() {

	$labels = array(
		'name'                  => _x( 'Profils', 'Post Type General Name', 'mybigbang' ),
		'singular_name'         => _x( 'Profil', 'Post Type Singular Name', 'mybigbang' ),
		'menu_name'             => __( 'Profils', 'mybigbang' ),
		'name_admin_bar'        => __( 'Profils', 'mybigbang' ),
		'archives'              => __( 'Item Archives', 'mybigbang' ),
		'attributes'            => __( 'Item Attributes', 'mybigbang' ),
		'parent_item_colon'     => __( 'Parent Item:', 'mybigbang' ),
		'all_items'             => __( 'Tous les profils', 'mybigbang' ),
		'add_new_item'          => __( 'Ajouter un profil', 'mybigbang' ),
		'add_new'               => __( 'Ajouter', 'mybigbang' ),
		'new_item'              => __( 'Nouveau profil', 'mybigbang' ),
		'edit_item'             => __( 'Modifier le profil', 'mybigbang' ),
		'update_item'           => __( 'Mettre à jour le profil', 'mybigbang' ),
		'view_item'             => __( 'Voir le profil', 'mybigbang' ),
		'view_items'            => __( 'Voir les profils', 'mybigbang' ),
		'search_items'          => __( 'Rechercher un profil', 'mybigbang' ),
		'not_found'             => __( 'Aucun profil', 'mybigbang' ),
		'not_found_in_trash'    => __( 'Aucun profil dans la corbeille', 'mybigbang' ),
		'featured_image'        => __( 'Photo de profil', 'mybigbang' ),
		'set_featured_image'    => __( 'Choisir une photo de profil', 'mybigbang' ),
		'remove_featured_image' => __( 'Supprimer la photo de profil', 'mybigbang' ),
		'use_featured_image'    => __( 'Utiliser comme photo de profil', 'mybigbang' ),
		'insert_into_item'      => __( 'Insert into item', 'mybigbang' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'mybigbang' ),
		'items_list'            => __( 'Items list', 'mybigbang' ),
		'items_list_navigation' => __( 'Items list navigation', 'mybigbang' ),
		'filter_items_list'     => __( 'Filter items list', 'mybigbang' ),
	);
	$args = array(
		'label'                 => __( 'Profil', 'mybigbang' ),
		'description'           => __( 'Post Type Description', 'mybigbang' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'element', 'besoin' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-universal-access',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'profil', $args );

}
add_action( 'init', 'mbb_profil_post_type', 0 );

/***************************************************************
	Custom Post Type : coach
/***************************************************************/
function mbb_coach_post_type() {

	$labels = array(
		'name'                  => _x( 'Coachs', 'Post Type General Name', 'mybigbang' ),
		'singular_name'         => _x( 'Coach', 'Post Type Singular Name', 'mybigbang' ),
		'menu_name'             => __( 'Coachs', 'mybigbang' ),
		'name_admin_bar'        => __( 'Coachs', 'mybigbang' ),
		'archives'              => __( 'Item Archives', 'mybigbang' ),
		'attributes'            => __( 'Item Attributes', 'mybigbang' ),
		'parent_item_colon'     => __( 'Parent Item:', 'mybigbang' ),
		'all_items'             => __( 'Tous les coachs', 'mybigbang' ),
		'add_new_item'          => __( 'Ajouter un coach', 'mybigbang' ),
		'add_new'               => __( 'Ajouter', 'mybigbang' ),
		'new_item'              => __( 'Nouveau coach', 'mybigbang' ),
		'edit_item'             => __( 'Modifier le coach', 'mybigbang' ),
		'update_item'           => __( 'Mettre à jour le coach', 'mybigbang' ),
		'view_item'             => __( 'Voir le coach', 'mybigbang' ),
		'view_items'            => __( 'Voir les coachs', 'mybigbang' ),
		'search_items'          => __( 'Rechercher un coach', 'mybigbang' ),
		'not_found'             => __( 'Aucun coach', 'mybigbang' ),
		'not_found_in_trash'    => __( 'Aucun coach dans la corbeille', 'mybigbang' ),
		'featured_image'        => __( 'Photo de profil', 'mybigbang' ),
		'set_featured_image'    => __( 'Choisir une photo de profil', 'mybigbang' ),
		'remove_featured_image' => __( 'Supprimer la photo de profil', 'mybigbang' ),
		'use_featured_image'    => __( 'Utiliser comme photo de profil', 'mybigbang' ),
		'insert_into_item'      => __( 'Insert into item', 'mybigbang' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'mybigbang' ),
		'items_list'            => __( 'Items list', 'mybigbang' ),
		'items_list_navigation' => __( 'Items list navigation', 'mybigbang' ),
		'filter_items_list'     => __( 'Filter items list', 'mybigbang' ),
	);
	$args = array(
		'label'                 => __( 'Coach', 'mybigbang' ),
		'description'           => __( 'Post Type Description', 'mybigbang' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'element' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-universal-access-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'coach', $args );

}
add_action( 'init', 'mbb_coach_post_type', 0 );


/***************************************************************
    Custom Post Type : studio
/***************************************************************/
function mbb_studio_post_type() {

	$labels = array(
		'name'                  => _x( 'Studios', 'Post Type General Name', 'mybigbang' ),
		'singular_name'         => _x( 'Studio', 'Post Type Singular Name', 'mybigbang' ),
		'menu_name'             => __( 'Studios', 'mybigbang' ),
		'name_admin_bar'        => __( 'Studios', 'mybigbang' ),
		'archives'              => __( 'Item Archives', 'mybigbang' ),
		'attributes'            => __( 'Item Attributes', 'mybigbang' ),
		'parent_item_colon'     => __( 'Parent Item:', 'mybigbang' ),
		'all_items'             => __( 'Tous les studios', 'mybigbang' ),
		'add_new_item'          => __( 'Ajouter un studio', 'mybigbang' ),
		'add_new'               => __( 'Ajouter', 'mybigbang' ),
		'new_item'              => __( 'Nouveau studio', 'mybigbang' ),
		'edit_item'             => __( 'Modifier le studio', 'mybigbang' ),
		'update_item'           => __( 'Mettre à jour le studio', 'mybigbang' ),
		'view_item'             => __( 'Voir le studio', 'mybigbang' ),
		'view_items'            => __( 'Voir les studios', 'mybigbang' ),
		'search_items'          => __( 'Rechercher un studio', 'mybigbang' ),
		'not_found'             => __( 'Aucun studio', 'mybigbang' ),
		'not_found_in_trash'    => __( 'Aucun studio dans la corbeille', 'mybigbang' ),
		'featured_image'        => __( 'Photo principale', 'mybigbang' ),
		'set_featured_image'    => __( 'Choisir une photo principale', 'mybigbang' ),
		'remove_featured_image' => __( 'Supprimer la photo principale', 'mybigbang' ),
		'use_featured_image'    => __( 'Utiliser comme photo principale', 'mybigbang' ),
		'insert_into_item'      => __( 'Insert into item', 'mybigbang' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'mybigbang' ),
		'items_list'            => __( 'Items list', 'mybigbang' ),
		'items_list_navigation' => __( 'Items list navigation', 'mybigbang' ),
		'filter_items_list'     => __( 'Filter items list', 'mybigbang' ),
	);
	$args = array(
		'label'                 => __( 'Studio', 'mybigbang' ),
		'description'           => __( 'Post Type Description', 'mybigbang' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-store',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		//'rewrite'				=> array('slug' =>'nos-studios-delectro-stimulation'),
		'rewrite'				=> array('slug' =>'nos-studios'),
	);
	register_post_type( 'studio', $args );

}
add_action( 'init', 'mbb_studio_post_type', 0 );

/***************************************************************
	Custom Post Type : sessions
/***************************************************************/
function mbb_session_post_type() {

	$labels = array(
		'name'                  => _x( 'Sessions', 'Post Type General Name', 'mybigbang' ),
		'singular_name'         => _x( 'Session', 'Post Type Singular Name', 'mybigbang' ),
		'menu_name'             => __( 'Sessions', 'mybigbang' ),
		'name_admin_bar'        => __( 'Sessions', 'mybigbang' ),
		'archives'              => __( 'Item Archives', 'mybigbang' ),
		'attributes'            => __( 'Item Attributes', 'mybigbang' ),
		'parent_item_colon'     => __( 'Parent Item:', 'mybigbang' ),
		'all_items'             => __( 'Toutes les sessions', 'mybigbang' ),
		'add_new_item'          => __( 'Ajouter une session', 'mybigbang' ),
		'add_new'               => __( 'Ajouter', 'mybigbang' ),
		'new_item'              => __( 'Nouvelle session', 'mybigbang' ),
		'edit_item'             => __( 'Modifier la session', 'mybigbang' ),
		'update_item'           => __( 'Mettre à jour la session', 'mybigbang' ),
		'view_item'             => __( 'Voir la session', 'mybigbang' ),
		'view_items'            => __( 'Voir les sessions', 'mybigbang' ),
		'search_items'          => __( 'Rechercher une session', 'mybigbang' ),
		'not_found'             => __( 'Aucune session', 'mybigbang' ),
		'not_found_in_trash'    => __( 'Aucune session dans la corbeille', 'mybigbang' ),
	);
	$args = array(
		'label'                 => __( 'Session', 'mybigbang' ),
		'description'           => __( 'Sessions à réserver en ligne ou en studio', 'mybigbang' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'type_sessions'),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'session', $args );

}
add_action( 'init', 'mbb_session_post_type', 0 );

/***************************************************************
	Fonctions communes
/***************************************************************/
function mbb_get_element($post_id) {
	$terms=get_the_terms($post_id,'element');
	if($terms) {
		return $terms[0]->name;
	}
}
function mbb_get_besoins($post_id) {
	$terms=get_the_terms($post_id,'besoin');
	if($terms) {
		$besoins=array();
		foreach($terms as $term) {
			$besoins[]=$term->name;
		}
		return join(' <span class="separateur"> | </span>',$besoins);
	}
}
function mbb_get_type_session_id($post_id) {
	$terms=get_the_terms($post_id,'type_session');
	if($terms) {
		return $terms[0]->term_id;
	}
}