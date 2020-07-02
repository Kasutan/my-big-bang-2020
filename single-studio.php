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
if(function_exists('get_field')) {
	$etoiles=esc_attr(get_field('nombre_etoiles'));
	$avis=esc_attr(get_field('nombre_avis'));
	$telephone=esc_attr(get_field('telephone'));
	$adresse=esc_attr(get_field('adresse'));
	$horaires=get_field('horaires'); //champ de type groupe
	$galerie=get_field('galerie');
	$numero_script=esc_attr(get_field('numero_script'));
	$label=esc_html(get_field('label_cta_studio','option'));
	$cible=esc_url(get_field('cible_cta_studio','option'));
	$titre_gauche=wp_kses_post(get_field('titre_gauche_studio','option'));
	$texte_droite=wp_kses_post(get_field('texte_droite_studio','option'));
	$titre_gauche=wp_kses_post(get_field('titre_gauche_studio','option'));
	$texte_droite=wp_kses_post(get_field('texte_droite_studio','option'));
	$shortcode_widget=esc_html(get_field('shortcode_widget_studio','option'));

}
?>

<main id="main" class="site-main">
<?php
	while ( have_posts() ) :
		the_post();
		?>

			<header class="entry-header">
				
				<?php printf('<h1 class="page-title"><span class="sur-titre">Centre d’électrostimulation (EMS) Miha Bodytech </span>%s</h1>',
					 get_the_title() 
				);?>
				
					<div class="entry-meta">
						<div class="notation">
							<?php for($i=1;$i<=$etoiles;$i++) {
								echo '<span class="etoile"></span>';
							}
							printf('<span class="screen-reader-text">%s étoiles</span>',$etoiles);
							printf('<span class="avis">%s avis</span>',$avis);
							?>
						</div>
						<div class="telephone"><?php echo $telephone;?></div>
						<?php printf('<a class="button studio" href="%s">%s</a>',$cible,$label); ?>
					</div><!-- .entry-meta -->
			</header><!-- .entry-header -->

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
