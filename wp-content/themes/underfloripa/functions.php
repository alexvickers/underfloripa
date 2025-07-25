<?php
// Theme setup
function underfloripa_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', ['search-form', 'gallery', 'caption']);

	register_nav_menus([
		'main_menu'   => 'Main Menu',
		'footer_menu' => 'Footer Menu (Categories)',
	]);
}
add_action('after_setup_theme', 'underfloripa_setup');

// Enqueue styles and scripts
function underfloripa_assets() {
	wp_enqueue_style('underfloripa-style', get_stylesheet_uri(), [], '1.0');
}
add_action('wp_enqueue_scripts', 'underfloripa_assets');

// Logo support
add_theme_support('custom-logo', [
	'height'      => 100,
	'width'       => 100,
	'flex-height' => true,
	'flex-width'  => true,
]);
