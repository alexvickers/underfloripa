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

function my_custom_footer_scripts() {
    if (function_exists('get_field')) {
        $scripts = get_field('site_footer_scripts', 'option');
        if ($scripts) {
            echo $scripts;
        }
    }
}
add_action('wp_footer', 'my_custom_footer_scripts', 100);

if (file_exists($inc_path . 'gutenberg-blocks.php')) {
    require_once $inc_path . 'gutenberg-blocks.php';
}

// Album Review Meta Descriptions
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

// Related Posts
function get_related_posts_block($post) {
    if (empty($post)) return '';

    $cache_key = 'related_posts_block_' . $post->ID;
    $cached_html = get_transient($cache_key);
    if ($cached_html !== false) {
        return $cached_html;
    }

    $categories = get_the_category($post->ID);
    if (empty($categories)) return '';

    $category_ids = wp_list_pluck($categories, 'term_id');
    $category_slugs = wp_list_pluck($categories, 'slug');
    $is_musica = in_array('musica', $category_slugs);
    $is_voce_precisa_conhecer = in_array('voce-precisa-conhecer', $category_slugs);

    $base_args = [
        'category__in' => $category_ids,
        'posts_per_page' => 6,
        'orderby' => 'rand',
        'no_found_rows' => true,
    ];

    if ($is_resenhas) {
        $base_args['author'] = $post->post_author;
        $related_posts = get_posts($base_args);

        if (count($related_posts) < 3) {
            unset($base_args['author']);
            $related_posts = get_posts($base_args);
        }
    } else {
        $related_posts = get_posts($base_args);
    }

    $filtered_posts = array_filter($related_posts, fn($item) => $item->ID !== $post->ID);
    $filtered_posts = array_slice($filtered_posts, 0, 3);

    if (empty($filtered_posts)) return '';

    // Determine the heading text
    $heading_text = $is_voce_precisa_conhecer ? "Você também precisa conhecer" : "Outras matérias";

    ob_start();
    ?>
    <div class="related-posts">
        <h3><span><?php echo $heading_text; ?></span></h3>
        <ul>
            <?php foreach ($filtered_posts as $post_item): ?>
                <li>
                    <a href="<?php echo get_permalink($post_item->ID); ?>">
                        <?php
                        $thumb = get_the_post_thumbnail($post_item->ID, 'thumbnail');
                        if ($thumb) {
                            echo '<div class="related-post-thumb">' . $thumb . '</div>';
                        }
                        ?>
                        <span class="related-post-title"><?php echo get_the_title($post_item->ID); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    $html = ob_get_clean();

    // Store in transient for 6 hours
    set_transient($cache_key, $html, 6 * HOUR_IN_SECONDS);

    return $html;
}

add_action('save_post', function($post_id) {
    delete_transient('related_posts_block_' . $post_id);
});
