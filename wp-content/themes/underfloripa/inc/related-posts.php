<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Get Related Posts Block
 *
 * Generates a related posts block for a given post.
 *
 * @param WP_Post $post
 * @return string
 */
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

	$posts_to_show = 4;

	$base_args = [
			'category__in' => $category_ids,
			'posts_per_page' => 6,
			'orderby' => 'rand',
			'no_found_rows' => true,
			'ignore_sticky_posts' => true,
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
							'after' => '2 weeks ago',
							'inclusive' => true,
					],
			];
	}

	if ($is_resenhas) {
			$base_args['author'] = $post->post_author;
			$related_posts = get_posts($base_args);

			if (count($related_posts) < $posts_to_show) {
					unset($base_args['author']);
					$related_posts = get_posts($base_args);
			}
	} else {
			$related_posts = get_posts($base_args);
	}

	$filtered_posts = array_filter($related_posts, fn($item) => $item->ID !== $post->ID);
	$filtered_posts = array_slice($filtered_posts, 0, $posts_to_show);

	if (count($filtered_posts) < $posts_to_show) {
			$needed = $posts_to_show - count($filtered_posts);

			$fallback_args = [
					'date_query' => [
							[
									'after' => '1 week ago',
									'inclusive' => true,
							],
					],
					'posts_per_page' => $needed,
					'orderby' => 'rand',
					'no_found_rows' => true,
					'ignore_sticky_posts' => true,
			];

			$fallback_posts = get_posts($fallback_args);
			$fallback_posts = array_filter($fallback_posts, fn($item) => $item->ID !== $post->ID);
			$filtered_posts = array_merge($filtered_posts, $fallback_posts);
			$filtered_posts = array_slice($filtered_posts, 0, $posts_to_show);
	}

	if (empty($filtered_posts)) return '';

	foreach ($filtered_posts as &$related_post) {
			if ($is_resenhas && strpos($related_post->post_title, 'Resenha: ') === 0) {
					$related_post->post_title = substr($related_post->post_title, 9);
			}
	}

	if ($is_voce_precisa_conhecer) {
			$heading_text = "Você também precisa conhecer";
	} elseif ($is_resenhas) {
			$heading_text = "Outras Resenhas";
	} else {
			$heading_text = "Outras matérias";
	}

	ob_start();
	include get_stylesheet_directory() . '/template-parts/related-posts-block.php';
	$html = ob_get_clean();

	set_transient($cache_key, $html, 6 * HOUR_IN_SECONDS);

	return $html;
}

add_action('save_post', function ($post_id) {
	delete_transient('related_posts_block_' . $post_id);
});
