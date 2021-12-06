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
	<?php do_action('fdc_head_bottom'); ?>
</head>

<body <?php body_class(); ?>>
<?php  do_action('fdc_body_top');?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main">Aller directement au contenu</a>
	
	<header id="masthead" class="site-header landing">

		<div class="site-branding">
			<?php
			if(has_custom_logo(  )) {
				the_custom_logo(  );
			} else {
				printf('<a href="%s" class="custom-logo"><img alt="My Big Bang" src="%s" width="286" height="55"/></a>',
					esc_url( home_url( '/' ) ),
					get_template_directory_uri() . '/icons/logo-landing.png'

				);
			}
			?>
		</div>

		<?php 
		if(function_exists('get_field')) {
			$bouton=get_field('lp_header_bouton');
			if(is_array($bouton) && array_key_exists('label',$bouton) && array_key_exists('cible',$bouton)) {
				$label=wp_kses_post($bouton['label']);
				$cible=esc_url($bouton['cible']);
				if($label && $cible) {
					printf('<a href="%s" class="button">%s</a>',$cible,$label);
				}
			}
		}

		?>
	</header><!-- #masthead -->

