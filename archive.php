<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mybigbang
 */

get_header();
?>

	<main id="main" class="site-main">
		<?php if(function_exists('mbb_fil_ariane')) mbb_fil_ariane(); ?>
		<div class="primary">


		<?php 
			printf('<h1 class="screen-reader-text">%s - %s</h1>',get_the_title(get_option( 'page_for_posts' )),get_the_archive_title());
		?>

		<?php if ( have_posts() ) : ?>

			<div class="entry-content loop">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content-loop', get_post_type() );

			endwhile;
			?>
			<?php
			
			if (function_exists('wp_pagenavi')) :
				wp_pagenavi();
			else :
				the_posts_navigation();
			endif;

			echo '</div>';

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
		</div><!-- .primary -->
		<aside class="sidebar" >
			<?php dynamic_sidebar('blog');?>
		</aside>
	</main><!-- #main -->

<?php

get_footer();
