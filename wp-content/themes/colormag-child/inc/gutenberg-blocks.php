<?php
function register_acf_album_blocks() {
    acf_register_block_type(array(
        'name'              => 'album_review',
        'title'             => __('Album Review'),
        'description'       => __('A block to display album reviews with a rating.'),
        'render_callback'   => 'render_acf_album_review_block',
        'category'          => 'formatting',
        'icon'              => 'star-filled',
        'keywords'          => array('album', 'review', 'music'),
    ));
}
add_action('acf/init', 'register_acf_album_blocks');

function render_acf_album_review_block($block) {
    get_template_part('template-parts/blocks/album-review');
}
