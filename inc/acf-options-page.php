<?php

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Réglages My Big Bang',
		'menu_title'	=> 'My Big Bang',
		'menu_slug' 	=> 'my-big-bang-settings',
		'capability'	=> 'edit_posts',
		'position' 		=> '2.5',
		'icon_url' 		=> get_stylesheet_directory_uri(  ).'/icons/picto_menu_bo.png',
		'redirect'		=> false,
		'update_button' => 'Mettre à jour',
		'updated_message' => 'Réglages My Big Bang mis à jour',
	));
	
}