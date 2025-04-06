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
    $is_resenhas = in_array('resenhas', $category_slugs);
    $is_voce_precisa_conhecer = in_array('voce-precisa-conhecer', $category_slugs);
    $is_cultural = array_intersect(['musica', 'cinema', 'literatura'], $category_slugs);

    $base_args = [
        'category__in' => $category_ids,
        'posts_per_page' => 6,
        'orderby' => 'rand',
        'no_found_rows' => true,
    ];

    if (!empty($is_cultural)) {
        $cultural_terms = get_terms([
            'taxonomy' => 'category',
            'slug' => ['musica', 'cinema', 'literatura'],
            'fields' => 'ids',
            'hide_empty' => false,
        ]);
        $category_ids = $cultural_terms;

        $base_args['date_query'] = [
            [
                'after' => '2 months ago',
                'inclusive' => true,
            ],
        ];
    }

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
    if ($is_voce_precisa_conhecer) {
        $heading_text = "Você também precisa conhecer";
    } elseif ($is_resenhas) {
        $heading_text = "Últimas Resenhas";
    } else {
        $heading_text = "Outras matérias";
    }

    ob_start();
    ?>
    <div class="related-posts">
        <h3><span><?php echo $heading_text; ?></span></h3>
        <ul>
            <?php foreach ($filtered_posts as $post_item): ?>
                <li>
                    <a href="<?php echo get_permalink($post_item->ID); ?>">
                        <?php
                        $thumb = get_the_post_thumbnail($post_item->ID, [300, 300]);
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

    set_transient($cache_key, $html, 6 * HOUR_IN_SECONDS);

    return $html;
}

add_action('save_post', function($post_id) {
    delete_transient('related_posts_block_' . $post_id);
});

// Autoload archive posts
function my_ajax_load_more_posts() {
    if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'load_more_nonce')) {
        wp_send_json_error('Invalid nonce');
        wp_die();
    }

    $paged         = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $category_id   = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
    $search_query  = isset($_GET['search_query']) ? sanitize_text_field($_GET['search_query']) : '';
    $author_id     = isset($_GET['author_id']) ? intval($_GET['author_id']) : 0;

    $args = [
        'post_type'   => 'post',
        'post_status' => 'publish', // ← THIS!
        'paged'       => $paged,
    ];

    if ($category_id) {
        $args['cat'] = $category_id;
    }

    if (!empty($search_query)) {
        $args['s'] = $search_query;
    }

    if ($author_id) {
        $args['author'] = $author_id;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/content', 'ajax');
        endwhile;
    else :
        echo 'no-more-posts';
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_posts', 'my_ajax_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'my_ajax_load_more_posts');

function colormag_child_enqueue_scripts()
{
    $category_id   = 0;
    $search_query  = '';
    $author_id     = 0;

    if (is_category()) {
        $cat = get_queried_object();
        $category_id = $cat->term_id;
    }

    if (is_search()) {
        $search_query = get_search_query();
    }

    if (is_author()) {
        $author = get_queried_object();
        $author_id = $author->ID;
    }

    wp_enqueue_script(
        'load-more',
        get_stylesheet_directory_uri() . '/assets/js/load-more.js',
        [],
        false,
        true
    );

    wp_localize_script('load-more', 'my_ajax_obj', [
        'ajax_url'     => admin_url('admin-ajax.php'),
        'nonce'        => wp_create_nonce('load_more_nonce'),
        'category_id'  => $category_id,
        'search_query' => $search_query,
        'author_id'    => $author_id,
    ]);
}
add_action('wp_enqueue_scripts', 'colormag_child_enqueue_scripts');
