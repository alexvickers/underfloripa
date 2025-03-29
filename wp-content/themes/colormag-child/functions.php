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

function filter_rankmath_meta_description($content) {
    if (is_single() || is_page()) {
        global $post;
        
        // Parse the content blocks
        $blocks = parse_blocks($post->post_content);
        $album_name = '';
        $artist_name = '';

        foreach ($blocks as $block) {
            if ($block['blockName'] === 'acf/album_review') {
                $album_name = isset($block['attrs']['data']['album_name']) ? esc_html($block['attrs']['data']['album_name']) : '';
                $artist_name = isset($block['attrs']['data']['artist_name']) ? esc_html($block['attrs']['data']['artist_name']) : '';
                break;
            }
        }

        if (!empty($album_name) && !empty($artist_name)) {
            return "Review of '{$album_name}' by {$artist_name}. Read our detailed analysis.";
        }
    }

    return $content;
}
add_filter('rank_math/frontend/description', 'filter_rankmath_meta_description');
