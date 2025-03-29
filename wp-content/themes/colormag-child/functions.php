<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Ensure parent theme styles load
function colormag_child_enqueue_styles() {
    wp_enqueue_style('colormag-parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'colormag_child_enqueue_styles');

// Check if the inc folder exists before requiring files
$inc_path = get_stylesheet_directory() . '/inc/';

if (file_exists($inc_path . 'acf-options.php')) {
    require_once $inc_path . 'acf-options.php';
}

if (file_exists($inc_path . 'gutenberg-blocks.php')) {
    require_once $inc_path . 'gutenberg-blocks.php';
}
