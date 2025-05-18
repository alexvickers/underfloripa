<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load PHP files from /inc
foreach ( glob( get_stylesheet_directory() . '/inc/*.php' ) as $file ) {
	require_once $file;
}

// Enqueue Parent and Child Styles
function colormag_child_enqueue_styles() {
	wp_enqueue_style( 'colormag-parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'colormag_child_enqueue_styles' );

// Custom Footer Scripts (via ACF option)
function my_custom_footer_scripts() {
	if ( function_exists( 'get_field' ) ) {
		$scripts = get_field( 'site_footer_scripts', 'option' );
		if ( $scripts ) {
			echo $scripts;
		}
	}
}
add_action( 'wp_footer', 'my_custom_footer_scripts', 100 );

// Admin: Enqueue ACF Script for Album Reviews
function enqueue_admin_review_labels_script() {
	wp_enqueue_script(
		'custom-review-labels',
		get_stylesheet_directory_uri() . '/assets/js/admin-review-labels.js',
		[ 'acf-input' ],
		filemtime( get_stylesheet_directory() . '/assets/js/admin-review-labels.js' ),
		true
	);
}
add_action( 'acf/input/admin_enqueue_scripts', 'enqueue_admin_review_labels_script' );

// SEO: Custom Meta Description for Album Review Posts (via Rank Math)
function filter_rankmath_meta_description( $content ) {
	if ( is_single() || is_page() ) {
		global $post;

		$blocks      = parse_blocks( $post->post_content );
		$artist_name = '';
		$album_name  = '';
		$label_name  = '';

		foreach ( $blocks as $block ) {
			if ( $block['blockName'] === 'acf/album_review' ) {
				$artist_name = $block['attrs']['data']['artist_name'] ?? '';
				$album_name  = $block['attrs']['data']['album_name'] ?? '';
				$label_name  = $block['attrs']['data']['label_name'] ?? '';
				break;
			}
		}

		if ( $album_name && $artist_name && $label_name ) {
			return "Review of '{$album_name}' by {$artist_name}, released by {$label_name}. Read our detailed analysis.";
		} elseif ( $album_name && $artist_name ) {
			return "Review of '{$album_name}' by {$artist_name}. Read our detailed analysis.";
		}
	}

	return $content;
}
add_filter( 'rank_math/frontend/description', 'filter_rankmath_meta_description' );

// AJAX: Load More Posts
function my_ajax_load_more_posts() {
	if ( ! isset( $_GET['nonce'] ) || ! wp_verify_nonce( $_GET['nonce'], 'load_more_nonce' ) ) {
		wp_send_json_error( 'Invalid nonce' );
		wp_die();
	}

	$paged        = isset( $_GET['page'] ) ? intval( $_GET['page'] ) : 1;
	$category_id  = isset( $_GET['category_id'] ) ? intval( $_GET['category_id'] ) : 0;
	$search_query = isset( $_GET['search_query'] ) ? sanitize_text_field( $_GET['search_query'] ) : '';
	$author_id    = isset( $_GET['author_id'] ) ? intval( $_GET['author_id'] ) : 0;

	$post_type = isset($_GET['post_type']) ? sanitize_key($_GET['post_type']) : 'post';

	$args = [
		'post_type'   => $post_type,
		'post_status' => 'publish',
		'paged'       => $paged,
	];

	if ($post_type === 'event') {
		$args['meta_key'] = 'event_date';
		$args['orderby']  = 'meta_value';
		$args['order']    = 'ASC';
	}

	if ( $category_id ) {
		$args['cat'] = $category_id;
	}

	if ( $search_query ) {
		$args['s'] = $search_query;
	}

	if ( $author_id ) {
		$args['author'] = $author_id;
	}

	$query = new WP_Query( $args );

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();

			if (get_post_type() === 'event') {
				get_template_part('template-parts/content', 'event');
			} else {
				get_template_part('template-parts/content', 'ajax');
			}
		}
	} else {
		echo 'no-more-posts';
	}

	wp_die();
}
add_action( 'wp_ajax_load_more_posts', 'my_ajax_load_more_posts' );
add_action( 'wp_ajax_nopriv_load_more_posts', 'my_ajax_load_more_posts' );

// AJAX Script Localizer
function colormag_child_enqueue_scripts() {
	$category_id  = is_category() ? get_queried_object_id() : 0;
	$search_query = is_search() ? get_search_query() : '';
	$author_id    = is_author() ? get_queried_object_id() : 0;

	wp_enqueue_script(
		'load-more',
		get_stylesheet_directory_uri() . '/assets/js/load-more.js',
		[],
		null,
		true
	);

	wp_localize_script('load-more', 'my_ajax_obj', [
		'ajax_url'     => admin_url('admin-ajax.php'),
		'nonce'        => wp_create_nonce('load_more_nonce'),
		'category_id'  => $category_id,
		'search_query' => $search_query,
		'author_id'    => $author_id,
		'post_type'    => get_post_type() ?: 'post',
	]);
}
add_action( 'wp_enqueue_scripts', 'colormag_child_enqueue_scripts' );
