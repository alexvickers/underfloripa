<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

add_action('acf/init', function() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type([
            'name'            => 'album_review',
            'title'           => __('Album Review'),
            'description'     => __('A block to display album reviews with a rating.'),
            'render_callback' => 'render_acf_album_review_block',
            'category'        => 'formatting',
            'icon'            => 'star-filled',
            'keywords'        => ['album', 'review', 'music'],
        ]);
    }
});

function render_acf_album_review_block($block, $content = '', $is_preview = false, $post_id = 0) {
    get_template_part('template-parts/blocks/album-review');
}
