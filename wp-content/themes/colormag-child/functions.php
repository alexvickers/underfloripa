<?php
if (!defined('ABSPATH')) {
    exit;
}

function colormag_child_enqueue_styles() {
    wp_enqueue_style('colormag-parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'colormag_child_enqueue_styles');

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

        $blocks = parse_blocks($post->post_content);
        $album_name = '';
        $artist_name = '';
        $label_name = '';

        foreach ($blocks as $block) {
            if ($block['blockName'] === 'acf/album_review') {
                $artist_name = isset($block['attrs']['data']['artist_name']) ? esc_html($block['attrs']['data']['artist_name']) : '';
                $album_name = isset($block['attrs']['data']['album_name']) ? esc_html($block['attrs']['data']['album_name']) : '';
                $label_name = isset($block['attrs']['data']['label_name']) ? esc_html($block['attrs']['data']['label_name']) : '';
                break;
            }
        }

        if (!empty($album_name) && !empty($artist_name) && !empty($label_name)) {
            return "Review of '{$album_name}' by {$artist_name}, released by {$label_name}. Read our detailed analysis.";
        } elseif (!empty($album_name) && !empty($artist_name)) {
            return "Review of '{$album_name}' by {$artist_name}. Read our detailed analysis.";
        }
    }

    return $content;
}
add_filter('rank_math/frontend/description', 'filter_rankmath_meta_description');
