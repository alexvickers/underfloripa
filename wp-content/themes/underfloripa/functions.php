<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}

// Load PHP files from /inc
foreach (glob(get_stylesheet_directory() . '/inc/*.php') as $file) {
	require_once $file;
}

// Theme setup
function underfloripa_setup() {
	add_theme_support('post-thumbnails');
	add_theme_support('html5', ['search-form', 'gallery', 'caption']);
	add_theme_support('title-tag');

	register_nav_menus([
		'main_menu'   => 'Main Menu',
		'footer_menu' => 'Footer Menu',
	]);
}
add_action('after_setup_theme', 'underfloripa_setup');

// Add category slug(s) to the body class on single posts.
function my_add_category_slug_to_body_class( $classes ) {
    if ( is_single() ) {
        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
            foreach ( $categories as $category ) {
                $classes[] = 'category-' . sanitize_html_class( $category->slug );
            }
        }
    }

    return $classes;
}
add_filter( 'body_class', 'my_add_category_slug_to_body_class' );

// Enqueue styles and scripts
function underfloripa_assets() {
	wp_enqueue_style('underfloripa-style', get_stylesheet_uri(), [], '1.0');
	wp_enqueue_script(
		'underfloripa-theme',
		get_stylesheet_directory_uri() . '/assets/js/header.js',
		[],
		null,
		true
	);
	wp_enqueue_script(
		'lazy-ads',
		get_stylesheet_directory_uri() . '/assets/js/lazy-ads.js',
		[],
		null,
		true
	);
}
add_action('wp_enqueue_scripts', 'underfloripa_assets');

function underfloripa_optimize_jquery() {
	if (is_admin()) return;

	wp_deregister_script('jquery');
	wp_register_script('jquery', includes_url('/js/jquery/jquery.min.js'), [], null, true);
	wp_enqueue_script('jquery');

	add_filter('script_loader_tag', function ($tag, $handle, $src) {
		if ($handle === 'jquery') {
			return '<script src="' . esc_url($src) . '" defer></script>';
		}
		return $tag;
	}, 10, 3);
}
add_action('wp_enqueue_scripts', 'underfloripa_optimize_jquery');

function underfloripa_remove_jquery_migrate($scripts) {
	if (! is_admin() && isset($scripts->registered['jquery'])) {
		$jquery_dep = &$scripts->registered['jquery'];

		if ($jquery_dep->deps) {
			$jquery_dep->deps = array_diff($jquery_dep->deps, array('jquery-migrate'));
		}
	}
}
add_action('wp_default_scripts', 'underfloripa_remove_jquery_migrate');

// Custom Footer Scripts (via ACF option)
function my_custom_footer_scripts() {
	if (function_exists('get_field')) {
		$scripts = get_field('site_footer_scripts', 'option');
		if ($scripts) {
			echo $scripts;
		}
	}
}
add_action('wp_footer', 'my_custom_footer_scripts', 100);

// Added sidebar
function underfloripa_register_sidebars() {
	register_sidebar([
		'name'          => 'Primary Sidebar',
		'id'            => 'primary-sidebar',
		'description'   => 'Main sidebar on the right side',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	]);
}
add_action('widgets_init', 'underfloripa_register_sidebars');

// AJAX: Load More Posts / CPTs
function uf_ajax_load_more_posts()
{
	$paged        = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$post_type    = isset($_GET['post_type']) ? sanitize_key($_GET['post_type']) : 'post';
	$is_noticias  = isset($_GET['is_noticias']) ? intval($_GET['is_noticias']) : 0;
	$excluded_ids = !empty($_GET['excluded_ids']) ? array_map('intval', (array) $_GET['excluded_ids']) : [];

	$args = [
		'post_type'      => $post_type,
		'post_status'    => 'publish',
		'paged'          => $paged,
		'posts_per_page' => 11,
	];

	// Exclude categories only on Notícias
	if ($is_noticias && !empty($excluded_ids)) {
		$args['category__not_in'] = $excluded_ids;
	}

	// Filters only if NOT Notícias
	if (!$is_noticias) {
		$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
		$author_id   = isset($_GET['author_id']) ? intval($_GET['author_id']) : 0;

		if ($category_id) $args['cat'] = $category_id;
		if ($author_id) $args['author'] = $author_id;
	}

	// Special handling for events
	if ($post_type === 'event') {
		$today = date('Ymd');
		$args['meta_key']   = 'event_date';
		$args['orderby']    = 'meta_value';
		$args['order']      = 'ASC';
		$args['meta_query'] = [
			[
				'key'     => 'event_date',
				'compare' => '>=',
				'value'   => $today,
				'type'    => 'NUMERIC',
			]
		];
	}

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();

			if ($post_type === 'event') {
				get_template_part('template-parts/content', 'event');
			} elseif (has_category('resenhas')) {
				get_template_part('template-parts/content', 'resenha');
			} else {
				get_template_part('template-parts/content', 'ajax');
			}
		}
	} else {
		echo 'no-more-posts';
	}

	wp_reset_postdata();
	wp_die();
}
add_action('wp_ajax_load_more_posts', 'uf_ajax_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'uf_ajax_load_more_posts');

// AJAX: Load More Search Results (Relevanssi)
function my_ajax_load_more_search()
{
	if (! isset($_GET['nonce']) || ! wp_verify_nonce($_GET['nonce'], 'load_more_nonce')) {
		wp_send_json_error('Invalid nonce');
		wp_die();
	}

	$paged        = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

	$args = [
		'post_type'   => ['post', 'event'],
		'post_status' => 'publish',
		'paged'       => $paged,
		's'           => $search_query,
	];

	$query = new WP_Query($args);

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
add_action('wp_ajax_load_more_search', 'my_ajax_load_more_search');
add_action('wp_ajax_nopriv_load_more_search', 'my_ajax_load_more_search');

// AJAX Script Localizer
function uf_enqueue_load_more_script()
{
	if (
		is_archive() ||
		is_search() ||
		is_tag() ||
		is_category() ||
		is_author() ||
		is_post_type_archive() ||
		is_page_template('page-noticias.php')
	) {
		wp_enqueue_script(
			'load-more',
			get_stylesheet_directory_uri() . '/assets/js/load-more.js',
			['jquery'],
			null,
			true
		);

		// Determine current post type
		$post_type = 'post';
		if (is_post_type_archive('event') || is_singular('event')) {
			$post_type = 'event';
		} elseif (is_archive() && get_post_type()) {
			$post_type = get_post_type();
		}

		// Default: no exclusions
		$excluded_ids = [];

		// Only exclude on Notícias
		if (is_page_template('page-noticias.php')) {
			$excluded_slugs = ['resenhas', 'colunas', 'coberturas'];
			$excluded_ids = array_map(function ($slug) {
				$cat = get_category_by_slug($slug);
				return $cat ? $cat->term_id : 0;
			}, $excluded_slugs);
		}

		wp_localize_script('load-more', 'my_ajax_obj', [
			'ajax_url'     => admin_url('admin-ajax.php'),
			'nonce'        => wp_create_nonce('load_more_nonce'),
			'category_id'  => is_page_template('page-noticias.php') ? 0 : (is_category() ? get_queried_object_id() : 0),
			'search_query' => is_search() ? get_search_query() : '',
			'author_id'    => is_author() ? get_queried_object_id() : 0,
			'post_type'    => $post_type,
			'excluded_ids' => $excluded_ids,
			'is_noticias'  => is_page_template('page-noticias.php') ? 1 : 0,
		]);
	}
}
add_action('wp_enqueue_scripts', 'uf_enqueue_load_more_script');

// Clear related posts block cache when posts are saved or deleted,
function my_clear_related_posts_cache( $post_id ) {
    if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
        return;
    }

    delete_transient( 'related_posts_block_' . $post_id );

    $categories = wp_get_post_categories( $post_id );
    if ( empty( $categories ) ) {
        return;
    }
    $category_slugs = wp_list_pluck( get_the_category( $post_id ), 'slug' );
    $cultural_slugs = ['musica', 'cinema', 'literatura'];
    $groups = [];

    if ( array_intersect( $category_slugs, $cultural_slugs ) ) {
        $groups[] = 'cultural';
    }
    if ( in_array( 'colunas', $category_slugs ) ) {
        $groups[] = 'colunas';
    }
    if ( in_array( 'coberturas', $category_slugs ) ) {
        $groups[] = 'coberturas';
    }
    if ( in_array( 'resenhas', $category_slugs ) ) {
        $groups[] = 'resenhas';
    }

    $args = [
        'posts_per_page'      => -1,
        'category__in'        => $categories,
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'fields'              => 'ids',
        'ignore_sticky_posts' => true,
    ];

    $posts_to_clear = get_posts( $args );

    if ( in_array( 'cultural', $groups ) ) {
        $cultural_terms = get_terms([
            'taxonomy'   => 'category',
            'slug'       => $cultural_slugs,
            'fields'     => 'ids',
            'hide_empty' => false,
        ]);

        $cultural_posts = get_posts([
            'posts_per_page'      => -1,
            'category__in'        => $cultural_terms,
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'fields'              => 'ids',
            'ignore_sticky_posts' => true,
        ]);

        $posts_to_clear = array_merge( $posts_to_clear, $cultural_posts );
    }

    foreach ( $posts_to_clear as $pid ) {
        delete_transient( 'related_posts_block_' . $pid );
    }
}
add_action( 'save_post', 'my_clear_related_posts_cache' );
add_action( 'before_delete_post', 'my_clear_related_posts_cache' );

class Underfloripa_Walker_Nav_Menu extends Walker_Nav_Menu {
	public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
	{
		$classes = empty($item->classes) ? [] : (array) $item->classes;
		$class_names = join(' ', array_filter($classes));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		$output .= '<li' . $class_names . '>';

		$attributes  = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"'     : '';
		$attributes .= !empty($item->xfn)        ? ' rel="' . esc_attr($item->xfn) . '"'           : '';
		$attributes .= !empty($item->url)        ? ' href="' . esc_url($item->url) . '"'           : '';

		$title = apply_filters('the_title', $item->title, $item->ID);

		$output .= '<a' . $attributes . '>';
		$output .= esc_html($title);

		if (in_array('menu-item-has-children', $classes)) {
			$output .= '<svg class="menu-chevron" width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
			</svg>';
		}

		$output .= '</a>';
	}
}
