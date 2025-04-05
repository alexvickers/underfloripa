<?php
/*
Plugin Name: Custom Author Avatars for Magazine Blocks
Description: Overrides author avatars in Magazine Blocks with ACF image field.
Author: Alexandre Aimbiré
Version: 1.1
*/

add_filter('render_block', 'replace_author_avatar_in_magazine_blocks', 10, 2);

function replace_author_avatar_in_magazine_blocks($block_content, $block) {
    if (!isset($block['blockName']) || strpos($block['blockName'], 'magazine-blocks/') !== 0) {
        return $block_content;
    }

    $post_id = get_the_ID();
    if (!$post_id) {
        return $block_content;
    }

    $author_id = get_post_field('post_author', $post_id);
    if (!$author_id) {
        return $block_content;
    }

    $acf_avatar_url = get_field('custom_author_avatar', 'user_' . $author_id);
    if (empty($acf_avatar_url)) {
        return $block_content;
    }

    $updated_content = preg_replace(
        '#https://secure\.gravatar\.com/avatar/[^"\']+#',
        esc_url($acf_avatar_url),
        $block_content
    );

    return $updated_content;
}
