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
	$location=get_field('adresse');
	$email=antispambot(esc_attr(get_field('email')));
	$horaires=get_field('horaires'); //champ de type groupe
	$galerie=get_field('galerie');
	$numero_script=esc_attr(get_field('numero_script'));
	$label=esc_html(get_field('label_cta_studio','option'));
	$cible=esc_url(get_field('cible_cta_studio','option'));
	$label_elements=esc_html(get_field('label_elements_studio','option'));
	$cible_elements=esc_url(get_field('cible_elements_studio','option'));
	$titre_gauche=wp_kses_post(get_field('titre_gauche_studio','option'));
	$titre_droite=wp_kses_post(get_field('titre_droite_studio','option'));
	$texte_gauche=wp_kses_post(get_field('contenu_gauche_studio','option'));
	$texte_droite=wp_kses_post(get_field('contenu_droite_studio','option'));
	$shortcode_widget=esc_html(get_field('shortcode_widget_studio','option'));

	$adresse='';
	if(function_exists('mbb_prepare_adresse')) {
		$adresse=mbb_prepare_adresse($location) ;
	}
}

$semaine=array('lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche');
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
					printf('<span class="nb-avis">%s avis</span>',$avis);
					?>
				</div>
				<div class="telephone"><?php echo $telephone;?></div>
				<?php printf('<a class="button studio" href="%s">%s</a>',$cible,$label); ?>
			</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	
<section class="studio">
	<?php
	echo '<div class="galerie owl-carousel owl-theme">';
		foreach( $galerie as $image_id ) {
			printf('<div class="image-wrapper">%s</div>',
				wp_get_attachment_image( $image_id, 'large')
			);
		}
	echo '</div>';//fin galerie
	echo '<div class="texte">';
		echo '<p class="avant-nom"><strong>Studio Mihabodytec My Big Bang</strong></p>';
		printf('<p class="nom"><strong>%s</strong></p>',get_the_title());
		printf('<p class="adresse">%s</p>',$adresse);
		printf('<p class="email">%s</p>',$email);
		echo '<p class="contraste">Horaires</p><ul class="horaires">';
		foreach($semaine as $jour) {
			printf('<li>%s : <strong>%s</strong>',ucfirst($jour),$horaires[$jour]);
			if(array_key_exists($jour.'_am',$horaires) && !empty($horaires[$jour.'_am'])) {
				printf('<span class="separateur">//</span><strong>%s</strong>',$horaires[$jour.'_am']);
			}
			echo '</li>';
		}
		echo "</ul>";
	echo '</div>';//fin .texte 

	printf('<div class="eclairage localisation"><div class="relief">%s</div></div>',get_the_content());
	?>
</section>
<section class="general">
	<?php if($texte_gauche) {
		printf('<div class="contenu"><h2 class="contraste">%s</h2><div>%s</div></div>',$titre_gauche,$texte_gauche);
	}
	if($texte_droite) {
		printf('<div class="contenu"><h2 class="contraste">%s</h2><div>%s</div></div>',$titre_droite,$texte_droite);
	}
	if($label_elements && $cible_elements && function_exists('mbb_get_picto_inline')) {
		printf('<div class="lien"><a class="cta-resultat" href="%s"><span>%s</span>', $cible_elements, $label_elements);
		echo mbb_get_picto_inline('fleche-cta').'</a></div>';
	}?>
</section>
<?php printf('<a class="button studio studio-2" href="%s">%s</a>',$cible,$label); ?>
<section class="avis">
	<div class="contraste">AVIS</div>
</section>
<section class="carte">
	<div class="contraste">CARTE</div>
</section>


		<?php	

endwhile; // End of the loop. ?>

</main><!-- #main -->

<?php
get_footer();