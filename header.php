<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mybigbang
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<link rel="dns-prefetch" href="//fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>


	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main">Aller directement au contenu</a>
	<?php if (function_exists('get_field') && !empty(get_field('mbb_topbar','option'))) {
		printf('<div class="topbar">%s</div>',get_field('mbb_topbar','option'));
	} ?>
	
	<header id="masthead" class="site-header">

		<div class="site-branding">
			<?php
			if(has_custom_logo(  )) {
				the_custom_logo(  );
			} else {
				printf('<a href="%s" class="custom-logo"><img alt="My Big Bang" src="%s" width="269" height="55"/></a>',
					esc_url( home_url( '/' ) ),
					mbb_get_picto_url('Logo-MPP-Header')
				);
			}
			?>
		</div>

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="Menu">

				<svg  class="menu" version="1.1" viewBox="0 0 36 36" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" focusable="false" role="img" width="32" height="32" fill="currentColor"><path class="clr-i-outline clr-i-outline-path-1" d="M32,29H4a1,1,0,0,1,0-2H32a1,1,0,0,1,0,2Z"/><path class="clr-i-outline clr-i-outline-path-2" d="M32,19H4a1,1,0,0,1,0-2H32a1,1,0,0,1,0,2Z"/><path class="clr-i-outline clr-i-outline-path-3" d="M32,9H4A1,1,0,0,1,4,7H32a1,1,0,0,1,0,2Z"/></svg>

				<svg class="times" version="1.1" viewBox="0 0 36 36" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" focusable="false" role="img" width="32" height="32" fill="currentColor"><path class="clr-i-outline clr-i-outline-path-1" d="M19.41,18l8.29-8.29a1,1,0,0,0-1.41-1.41L18,16.59,9.71,8.29A1,1,0,0,0,8.29,9.71L16.59,18,8.29,26.29a1,1,0,1,0,1.41,1.41L18,19.41l8.29,8.29a1,1,0,0,0,1.41-1.41Z"/></svg>
			</button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

