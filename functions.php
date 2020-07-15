<?php
/**
 * mybigbang functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mybigbang
 */

if ( ! function_exists( 'mbb_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mbb_setup() {
		

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails', array('post','page','profil','coach','studio'));

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => 'Menu principal (en-tête)',
			'liens-footer' => 'Liens du pied de page',
			'liens-techniques-footer' => 'Liens techniques du pied de page',
			'boutons-footer' => 'Boutons du pied de page',
			'social-footer' => 'Liens vers les réseaux sociaux',
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );


		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 55,
			'width'       => 287,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		* Font sizes in editor
		* https://www.billerickson.net/building-a-gutenberg-website/#editor-font-sizes
		*/
		add_theme_support( 'editor-font-sizes', array(
			array(
				'name' => __( 'Petite', 'mybigbang' ),
				'size' => 13,
				'slug' => 'small'
			),
			array(
				'name' => __( 'Normale', 'mybigbang' ),
				'size' => 16,
				'slug' => 'normal'
			),
			array(
				'name' => __( 'Grande', 'mybigbang' ),
				'size' => 20,
				'slug' => 'big'
			),
		) );

		/**
		* Responsive embeds
		*/
		add_theme_support( 'responsive-embeds' );

		/**
		* Wide/full alignment
		*/
		add_theme_support( 'align-wide' );
	}
endif;
add_action( 'after_setup_theme', 'mbb_setup' );

/**
* Register color palette for Gutenberg editor.
*/
require get_template_directory() . '/inc/colors.php';



/**
 * Enqueue scripts and styles.
 */
function mbb_scripts() {
	wp_enqueue_style( 'mybigbang-owl-carousel', get_template_directory_uri() . '/lib/owlcarousel/owl.carousel.min.css',array(),'2.3.4');
	wp_enqueue_style( 'mybigbang-style', get_stylesheet_uri() );
	wp_enqueue_style( 'mybigbang-google-font', 'https://fonts.googleapis.com/css?family=Zilla+Slab:600');
	wp_enqueue_style( 'mybigbang-typekit-font', 'https://use.typekit.net/siy5vua.css');

	wp_enqueue_script( 'mybigbang-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'mybigbang-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'mybigbang-lottie', 'https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.6.10/lottie_light_html.min.js', array(), '', true );

	wp_enqueue_script( 'mybigbang-owl-carousel',get_template_directory_uri() . '/lib/owlcarousel/owl.carousel.min.js', array('jquery'), '2.3.4', true );

	//wp_register_script( 'mybigbang-modaal',get_template_directory_uri() . '/lib/modaal/modaal.min.js', array('jquery'), '0.4.4', true );

	wp_enqueue_script( 'mybigbang-scripts', get_template_directory_uri() . '/js/mybigbang.js', array('mybigbang-lottie','jquery', 'mybigbang-owl-carousel'), '', true );


}
add_action( 'wp_enqueue_scripts', 'mbb_scripts' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
* Image sizes. Work first with medium and large in admin if possible
* https://developer.wordpress.org/reference/functions/add_image_size/
*/

//add_image_size('banniere',1960,300,true);

/**
* CPT et custom taxonomies
*/

require_once( 'inc/cpt-taxonomies.php' );


/**
* Blocks
*/


function mbb_block_categories( $categories, $post ) {
	return array_merge(
		array(
			array(
				'slug' => 'mybigbang-home',
				'title' => 'My Big Bang Accueil',
				'icon'  => 'admin-home',
			),
			array(
				'slug' => 'mybigbang',
				'title' => 'My Big Bang',
				'icon'  => 'universal-access',
			),
		),
		$categories
	);
}
add_filter( 'block_categories', 'mbb_block_categories', 10, 2 );

require_once( 'blocks/acf-block-questionnaire.php' );
require_once( 'blocks/acf-block-accueil-etat-esprit.php' );
require_once( 'blocks/acf-block-accueil-coach.php' );
require_once( 'blocks/acf-block-accueil-securite-1.php' );
require_once( 'blocks/acf-block-accueil-securite-2.php' );
require_once( 'blocks/acf-block-valeurs.php' );
require_once( 'blocks/acf-block-presse.php' );
require_once( 'blocks/acf-block-blog.php' );
require_once( 'blocks/acf-block-newsletter.php' );
require_once( 'blocks/acf-block-elements.php' );
require_once( 'blocks/acf-block-profils.php' );
require_once( 'blocks/acf-block-coach-personnel.php' );
require_once( 'blocks/acf-block-suivi-coaching.php' );
require_once( 'blocks/acf-block-team-coachs.php' );
require_once( 'blocks/acf-block-deroule-seance.php' );
require_once( 'blocks/acf-block-rdv.php' );
require_once( 'blocks/acf-block-reservation-session.php' );
require_once( 'blocks/acf-block-deux-colonnes.php' );
require_once( 'blocks/acf-block-studios.php' );
require_once( 'blocks/acf-block-coupon.php' );
require_once( 'blocks/acf-block-arguments.php' );
require_once( 'blocks/acf-block-facteurs-succes.php' );
require_once( 'blocks/acf-block-temoignages.php' );

/**
* Page options
*/

require_once( 'inc/acf-options-page.php' );


/**
* Maps
*/

require_once( 'inc/maps-api.php' );
