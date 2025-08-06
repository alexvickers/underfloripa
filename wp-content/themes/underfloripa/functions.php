<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}

// Theme setup
function underfloripa_setup()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', ['search-form', 'gallery', 'caption']);

	register_nav_menus([
		'main_menu'   => 'Main Menu',
		'footer_menu' => 'Footer Menu',
	]);
}
add_action('after_setup_theme', 'underfloripa_setup');

// Enqueue styles and scripts
function underfloripa_assets()
{
	wp_enqueue_style('underfloripa-style', get_stylesheet_uri(), [], '1.0');
}
add_action('wp_enqueue_scripts', 'underfloripa_assets');

// Logo support
add_theme_support('custom-logo', [
	'height'      => 100,
	'width'       => 100,
	'flex-height' => true,
	'flex-width'  => true,
]);

function underfloripa_optimize_jquery()
{
	if (is_admin()) return;

	// Deregister the default jQuery
	wp_deregister_script('jquery');

	// Re-register it in the footer
	wp_register_script('jquery', includes_url('/js/jquery/jquery.min.js'), [], null, true);

	// Enqueue the new jQuery
	wp_enqueue_script('jquery');

	// Filter to add defer
	add_filter('script_loader_tag', function ($tag, $handle, $src) {
		if ($handle === 'jquery') {
			return '<script src="' . esc_url($src) . '" defer></script>';
		}
		return $tag;
	}, 10, 3);
}
add_action('wp_enqueue_scripts', 'underfloripa_optimize_jquery');

function underfloripa_remove_jquery_migrate($scripts)
{
	if (! is_admin() && isset($scripts->registered['jquery'])) {
		$jquery_dep = &$scripts->registered['jquery'];

		if ($jquery_dep->deps) {
			$jquery_dep->deps = array_diff($jquery_dep->deps, array('jquery-migrate'));
		}
	}
}
add_action('wp_default_scripts', 'underfloripa_remove_jquery_migrate');

// Custom Footer Scripts (via ACF option)
function my_custom_footer_scripts()
{
	if (function_exists('get_field')) {
		$scripts = get_field('site_footer_scripts', 'option');
		if ($scripts) {
			echo $scripts;
		}
	}
}
add_action('wp_footer', 'my_custom_footer_scripts', 100);

// Added sidebar
function underfloripa_register_sidebars()
{
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

// AJAX: Load More Posts
function my_ajax_load_more_posts()
{
	if (! isset($_GET['nonce']) || ! wp_verify_nonce($_GET['nonce'], 'load_more_nonce')) {
		wp_send_json_error('Invalid nonce');
		wp_die();
	}

	$paged        = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$category_id  = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
	$search_query = isset($_GET['search_query']) ? sanitize_text_field($_GET['search_query']) : '';
	$author_id    = isset($_GET['author_id']) ? intval($_GET['author_id']) : 0;

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

	if ($category_id) {
		$args['cat'] = $category_id;
	}

	if ($search_query) {
		$args['s'] = $search_query;
	}

	if ($author_id) {
		$args['author'] = $author_id;
	}

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
add_action('wp_ajax_load_more_posts', 'my_ajax_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'my_ajax_load_more_posts');

// AJAX Script Localizer
function colormag_child_enqueue_scripts()
{
	// Only load on archive-type pages
	if (
		is_archive() ||
		is_search() ||
		is_tag() ||
		is_category() ||
		is_author() ||
		is_post_type_archive()
	) {
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
}
add_action('wp_enqueue_scripts', 'colormag_child_enqueue_scripts');

class Underfloripa_Walker_Nav_Menu extends Walker_Nav_Menu
{
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

		// Inject inline chevron SVG if item has children
		if (in_array('menu-item-has-children', $classes)) {
			$output .= '<svg class="menu-chevron" width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        	</svg>';
		}

		$output .= '</a>';
	}
}
