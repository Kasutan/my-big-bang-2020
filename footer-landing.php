<?php
	/**
	* The template for displaying the footer
	*
	* Contains the closing of the #page div 
	*
	* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	*
	* @package mybigbang
	*/

	?>

	<footer id="landin-footer" class="landing-footer">
		<?php


		wp_nav_menu( array(
			'theme_location' => 'liens-techniques-footer',
			'container' => false,
			'fallback_cb' => false,
			'menu_id' => 'liens-techniques-footer',
			'menu_class' => 'liens-techniques'
		) );

		printf('<div class="copyright">Copyright 2016-%s My Big Bang</div>',current_time('Y'));
		
		?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<?php do_action('fdc_body_bottom');?>
</body>
</html>
