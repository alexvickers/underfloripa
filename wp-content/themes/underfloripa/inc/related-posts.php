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

	$category_ids   = wp_list_pluck($categories, 'term_id');
	$category_slugs = wp_list_pluck($categories, 'slug');
	$is_resenhas    = in_array('resenhas', $category_slugs);
	$is_voce_precisa_conhecer = in_array('voce-precisa-conhecer', $category_slugs);
	$is_cultural    = array_intersect(['musica', 'cinema', 'literatura'], $category_slugs);
	$is_colunas     = in_array('colunas', $category_slugs);
	$is_coberturas  = in_array('coberturas', $category_slugs);

	$posts_to_show = $is_resenhas ? 4 : 3;
	$related_posts = [];

	if (!empty($is_cultural)) {
		$cultural_terms = get_terms([
			'taxonomy'   => 'category',
			'slug'       => ['musica', 'cinema', 'literatura'],
			'fields'     => 'ids',
			'hide_empty' => false,
		]);

		$base_args = [
			'category__in'        => $cultural_terms,
			'posts_per_page'      => $posts_to_show,
			'orderby'             => 'rand',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
			'date_query'          => [
				[
					'after'     => '1 week ago',
					'inclusive' => true,
				],
			],
		];

		$related_posts = get_posts($base_args);

		if (count($related_posts) < $posts_to_show) {
			$needed = $posts_to_show - count($related_posts);

			$fallback_args = [
				'category__in'        => $cultural_terms,
				'posts_per_page'      => $needed * 2,
				'orderby'             => 'date',
				'order'               => 'DESC',
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			];

			$fallback_posts = get_posts($fallback_args);
			$related_posts  = array_merge($related_posts, $fallback_posts);
		}
	} elseif ($is_resenhas) {
		$base_args = [
			'category__in'        => $category_ids,
			'posts_per_page'      => $posts_to_show,
			'orderby'             => 'rand',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
			'author'              => $post->post_author,
		];

		$related_posts = get_posts($base_args);

		if (count($related_posts) < $posts_to_show) {
			unset($base_args['author']);
			$related_posts = get_posts($base_args);
		}
	} elseif ($is_colunas || $is_coberturas) {
		$base_args = [
			'category__in'        => $category_ids,
			'posts_per_page'      => $posts_to_show,
			'orderby'             => 'rand',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
		];

		$related_posts = get_posts($base_args);
	} else {
		$base_args = [
			'category__in'        => $category_ids,
			'posts_per_page'      => $posts_to_show,
			'orderby'             => 'rand',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
			'date_query'          => [
				[
					'after'     => '1 week ago',
					'inclusive' => true,
				],
			],
		];

		$related_posts = get_posts($base_args);

		if (count($related_posts) < $posts_to_show) {
			$needed = $posts_to_show - count($related_posts);

			$fallback_args = [
				'category__in'        => $category_ids,
				'posts_per_page'      => $needed * 2,
				'orderby'             => 'date',
				'order'               => 'DESC',
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			];

			$fallback_posts = get_posts($fallback_args);
			$related_posts  = array_merge($related_posts, $fallback_posts);
		}
	}

	$related_posts  = array_values(array_unique($related_posts, SORT_REGULAR));
	$filtered_posts = array_filter($related_posts, fn($item) => $item->ID !== $post->ID);
	$filtered_posts = array_slice($filtered_posts, 0, $posts_to_show);

	if (empty($filtered_posts)) return '';

	if ($is_resenhas) {
		foreach ($filtered_posts as $related_post) {
			$title = trim($related_post->post_title);
			if (stripos($title, 'Resenha: ') === 0) {
				$related_post->post_title = substr($title, 9);
			}
		}
	}

	if ($is_voce_precisa_conhecer) {
		$heading_text = "Você também precisa conhecer";
	} elseif ($is_resenhas) {
		$heading_text = "Outras Resenhas";
	} elseif ($is_colunas) {
		$heading_text = "Outras colunas";
	} elseif ($is_coberturas) {
		$heading_text = "Outras coberturas";
	} else {
		$heading_text = "Outras matérias";
	}

	ob_start();
	include get_stylesheet_directory() . '/template-parts/related-posts-block.php';
	$html = ob_get_clean();
	set_transient( $cache_key, $html, 6 * HOUR_IN_SECONDS );
	return $html;
}
