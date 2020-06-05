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
		add_theme_support( 'post-thumbnails', array('post','page'));

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Menu principal', 'mybigbang' ),
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
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mbb_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Copyright', 'mybigbang' ),
		'id'            => 'copyright',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="widget-title">',
		'after_title'   => '</span>',
	) );
}
add_action( 'widgets_init', 'mbb_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mbb_scripts() {
	wp_enqueue_style( 'mybigbang-style', get_stylesheet_uri() );
	wp_enqueue_style( 'mybigbang-google-font', 'https://fonts.googleapis.com/css?family=Zilla+Slab:600');
	wp_enqueue_style( 'mybigbang-typekit-font', 'https://use.typekit.net/siy5vua.css');

	wp_enqueue_script( 'mybigbang-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'mybigbang-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'mybigbang-scripts', get_template_directory_uri() . '/js/mybigbang.js', array('jquery'), '', true );

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
* Blocks
*/


function mbb_block_categories( $categories, $post ) {
	return array_merge(
		array(
			array(
				'slug' => 'mybigbang',
				'title' => 'My Big Bang',
				'icon'  => '<svg
				xmlns="http://www.w3.org/2000/svg"
				version="1.1"
				viewBox="0 0 28.767763 38.256863"
				height="38.256863"
				width="28.767763">
				<g
					transform="translate(5.8409116e-4,-0.00513647)">
					<path
	
					transform="translate(-131.626,-8.859)"
					d="m 132.152,47 a 0.466,0.466 0 0 1 -0.428,-0.656 l 9.928,-22.819 h -9.559 a 0.469,0.469 0 0 1 -0.46,-0.553 l 2.691,-13.754 a 0.469,0.469 0 0 1 0.919,0.181 l -2.582,13.194 h 9.709 a 0.469,0.469 0 0 1 0.428,0.656 L 132.583,46.726 A 0.469,0.469 0 0 1 132.152,47 Z"
						/>
					<path
	
					transform="translate(-170.086,-9.148)"
					d="m 198.379,47.35 a 0.466,0.466 0 0 1 -0.428,-0.281 L 187.614,23.521 a 0.469,0.469 0 0 1 0.431,-0.656 h 9.709 l -2.4,-13.022 a 0.477,0.477 0 0 1 0.938,-0.172 l 2.5,13.579 a 0.469,0.469 0 0 1 -0.453,0.553 h -9.575 l 10.047,22.9 a 0.469,0.469 0 0 1 -0.241,0.625 0.441,0.441 0 0 1 -0.191,0.022 z"
						/>
					<path
	
					transform="translate(-142.649,-63.832)"
					d="m 148.131,102.093 a 0.488,0.488 0 0 1 -0.256,-0.075 0.469,0.469 0 0 1 -0.134,-0.65 l 7.48,-11.475 a 2.338,2.338 0 0 1 1.963,-1.063 v 0 a 2.338,2.338 0 0 1 1.963,1.06 l 7.421,11.356 a 0.47013642,0.47013642 0 1 1 -0.788,0.513 l -7.418,-11.353 a 1.379,1.379 0 0 0 -1.178,-0.625 v 0 a 1.385,1.385 0 0 0 -1.178,0.625 l -7.48,11.475 a 0.472,0.472 0 0 1 -0.394,0.213 z"
						/>
					<path
	
					transform="translate(-145.542,-12.826)"
					d="m 167.574,21.151 h -5.783 a 0.469,0.469 0 0 1 -0.428,-0.66 c 0.313,-0.75 1.035,-2.954 0.334,-4.1 a 1.914,1.914 0 0 0 -1.644,-0.806 h -0.222 a 1.9,1.9 0 0 0 -1.619,0.788 c -0.7,1.144 0,3.36 0.338,4.12 a 0.469,0.469 0 0 1 -0.034,0.444 0.475,0.475 0 0 1 -0.394,0.213 h -5.783 a 0.469,0.469 0 1 1 0,-0.938 h 5.1 c -0.344,-1.025 -0.838,-3.016 -0.028,-4.329 a 2.831,2.831 0 0 1 2.391,-1.25 h 0.275 a 2.807,2.807 0 0 1 2.416,1.25 c 0.8,1.316 0.313,3.292 -0.028,4.311 h 5.1 a 0.469,0.469 0 1 1 0,0.938 z"
						/>
				</g>
				</svg>',
			),
		),
		$categories
	);
}
add_filter( 'block_categories', 'mbb_block_categories', 10, 2 );

//require_once( 'blocks/acf-block-banniere.php' );

/**
* Page options
*/

require_once( 'inc/acf-options-page.php' );


