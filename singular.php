<?php
/**
 * The template for displaying all pages and posts
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mybigbang
 */

get_header();

$masquer_titre=false;
if(function_exists('mbb_page_avec_banniere') && mbb_page_avec_banniere()) {
	$masquer_titre=true;
} else if(function_exists('get_field') && get_field('masquer_titre')=='oui') {
	$masquer_titre=true;
}
?>

<main id="main" class="site-main">
<?php
	while ( have_posts() ) :
		the_post();
		if($masquer_titre) :
			the_title( '<h1 class="page-title screen-reader-text">', '</h1>' );
		else : ?>

			<header class="entry-header">
				
				<?php printf('<h1 class="page-title">%s</h1>',
					remove_accents( get_the_title() )
				);?>
				
				<?php if ( 'post' === get_post_type() ) :
					?>
					<div class="entry-meta">
						<?php
						the_date('', 'Publié le ');
						?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->

		<?php endif;?>

		<div class="entry-content container">
			<div class="overlay"></div>
			<?php
			the_content();
			?>

		</div><!-- .entry-content -->

		<?php	

endwhile; // End of the loop. ?>

</main><!-- #main -->

<?php
get_footer();
