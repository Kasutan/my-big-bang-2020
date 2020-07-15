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

get_header();?>
	
	<main id="main" class="site-main">

	<?php while ( have_posts() ) :
		the_post();
		if(function_exists('mbb_fil_ariane')) mbb_fil_ariane();
		?>
		<div class="primary">
			<header class="entry-header">
				
				<?php printf('<h1 class="entry-title">%s</h1>',
					get_the_title()
				);?>
				
				<div class="entry-meta">
					<div class="date">
					<?php 
						printf('<span>%s</span>',get_the_date('d/m/Y'));
						//est-ce que l'article a été mis à jour depuis?
						$u_time = get_the_time('U'); 
						$u_modified_time = get_the_modified_time('U'); 
						if ($u_modified_time >= $u_time + 86400) { 
							printf(' - Mis à jour le <strong>%s</strong>',get_the_modified_date('d/m/Y'));
						} 
					?>
					</div>
					<div class="auteur">
						Par <strong><?php the_author() ?></strong>
					</div>
				</div><!-- .entry-meta -->
			</header><!-- .entry-header -->


			<div class="entry-content">
				<?php
				the_content();
				?>

			</div><!-- .entry-content -->
		</div><!-- .primary -->
		<aside class="sidebar" >
			<?php dynamic_sidebar('blog');?>
		</aside>

		<?php	

	endwhile; // End of the loop. 

	
	
	?>

	</main><!-- #main -->

<?php
//bloc newsletter réutilisable https://wordpress.org/support/topic/reusable-block-in-single-php/
$reuse_block = get_post( 22715 ); //ID du bloc réutilisable
$reuse_block_content = apply_filters( 'the_content', $reuse_block->post_content);
echo $reuse_block_content;
get_footer();
