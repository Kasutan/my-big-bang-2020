<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package mybigbang
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function mbb_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'mbb_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function mbb_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'mbb_pingback_header' );


/**
* Get picto url.
*/
function mbb_get_picto_url($name) {
	return get_template_directory_uri() . '/icons\/'.$name.'.svg';
}

function mbb_get_picto_social_url($name) {
	return get_template_directory_uri() . '/icons/social/'.$name.'.svg';
}


/**
* Chercher si la page contient un bloc bannière ACF.
*/
function mbb_page_avec_banniere() {
	if( ! ( is_singular() && function_exists( 'parse_blocks' ) ) )
		return;

	global $post;
	$blocks = parse_blocks( $post->post_content );

	foreach ( $blocks as $block ) {

		if( ! isset( $block['blockName'] ) )
			continue;

		// Custom header block
		if( 'acf/acf-banniere' === $block['blockName'] ) {
			return true;

		// Heading block
		} 
	}

	return false;
}


/***************************************************************
Remove WP compression for images - there's a plugin for that
***************************************************************/
add_filter( 'jpeg_quality', 'smashing_jpeg_quality' );
function smashing_jpeg_quality() {
return 100;
}

/***************************************************************
				Remove image link
***************************************************************/
function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	
	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
add_action('admin_init', 'wpb_imagelink_setup', 10);

/***************************************************************
	Enable shortcodes in widgets
/***************************************************************/
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter('widget_text','do_shortcode');

/***************************************************************
						Clean header
/***************************************************************/
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
//Si on n'utilise pas les commentaires :
function clean_header(){ wp_deregister_script( 'comment-reply' ); } add_action('init','clean_header');

/***************************************************************
	Hide admin author page
/***************************************************************/
function bwp_template_redirect()
{
if (is_author())
{
wp_redirect( home_url() ); exit;
}
}
add_action('template_redirect', 'bwp_template_redirect');

/***************************************************************
			Afficher l'adresse mail via un shortcode
***************************************************************/

function mc_adresse_email($atts) {
	extract( shortcode_atts( array(    
		'mail' => ' ',    
		), $atts) );
	
			return (antispambot($mail));
		}
		
add_shortcode( 'adresse-email', 'mc_adresse_email' );


/***************************************************************
	Affiche l'ID de l'objet dans l'admin
/***************************************************************/
/* cf. https://premium.wpmudev.org/blog/display-wordpress-post-page-ids/ */
add_filter( 'manage_posts_columns', 'revealid_add_id_column', 5 );
add_action( 'manage_posts_custom_column', 'revealid_id_column_content', 5, 2 );
add_filter( 'manage_pages_columns', 'revealid_add_id_column' , 5);
add_action( 'manage_pages_custom_column', 'revealid_id_column_content', 5, 2  );

$custom_post_types = get_post_types( 
	array( 
	'public'   => true, 
	'_builtin' => false 
	), 
	'names'
); 
 
foreach ( $custom_post_types as $post_type ) {
	add_action( 'manage_edit-'. $post_type . '_columns', 'revealid_add_id_column', 5 );
	add_filter( 'manage_'. $post_type . '_custom_column', 'revealid_id_column_content', 5, 2 );
}

function revealid_add_id_column( $columns ) {
$columns['revealid_id'] = 'ID';
return $columns;
}

function revealid_id_column_content( $column, $id ) {
if( 'revealid_id' == $column ) {
	echo $id;
}
}