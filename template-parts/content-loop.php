<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mybigbang
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
			echo get_the_category_list();

			if(has_post_thumbnail()) :
				printf('<a class="image" href="%s"><div class="image-wrapper">%s</div></a>',
					get_permalink(),
					get_the_post_thumbnail( get_the_ID(), 'medium')
				);
			else : 
				printf('<a class="image" href="%s"><div class="image-wrapper"><img src="%s" alt="Logo My Big Bang" width="170" height="170"/></div></a>',
				get_permalink(),
				mbb_get_picto_url('logo-Footer') 
			);
			endif;

			printf('<span class="date">%s</span>', get_the_date(''));

			printf( '<h2 class="item-title"><a href="%s" rel="bookmark">%s</a></h2>',
				esc_url( get_permalink() ),
				get_the_title()
			);

			printf('<div class="extrait">%s</div>', get_the_excerpt(  ));

			printf('<a href="%s" class="fleche">Lire la suite<span class="screen-reader-text"> %s</span></a>',get_permalink(), get_the_title()); 
?>
</article><!-- #post-<?php the_ID(); ?> -->
