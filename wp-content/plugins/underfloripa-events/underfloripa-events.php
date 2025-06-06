<?php

/**
 * Plugin Name: Underfloripa Events
 * Description: Manage and display upcoming concerts and events on Underfloripa.
 * Version: 1.2
 * Author: Alexandre Aimbiré
 */

if (! defined('ABSPATH')) {
	exit;
}

// ACF Config
add_filter('acf/settings/load_json', 'uf_acf_json_load_point');
function uf_acf_json_load_point($paths) {
	$paths[] = plugin_dir_path(__FILE__) . 'acf-json';
	return $paths;
}
add_filter('acf/settings/remove_wp_meta_box', '__return_true');

// CPTs
class UF_Event_Plugin {
	public static function init() {
		add_action('init', [__CLASS__, 'register_post_types']);
		add_action('init', [__CLASS__, 'register_taxonomies']);
		add_action('save_post', [__CLASS__, 'enforce_single_city'], 20);
		add_action('admin_menu', [__CLASS__, 'remove_city_metabox']);
		add_action('admin_menu', [__CLASS__, 'add_taxonomy_submenu']);
		add_filter('get_the_archive_title', [__CLASS__, 'filter_archive_title']);
		add_filter('get_the_archive_description', [__CLASS__, 'filter_archive_description']);
	}

	public static function register_post_types() {
		// Event CPT
		register_post_type('event', [
			'labels' => [
				'name' => 'Events',
				'singular_name' => 'Event',
				'add_new_item' => 'Add New Event',
				'edit_item' => 'Edit Event',
			],
			'public' => true,
			'has_archive' => true,
			'rewrite' => ['slug' => 'agenda'],
			'menu_icon' => 'dashicons-calendar-alt',
			'supports' => ['title', 'custom-fields', 'thumbnail'],
			'show_in_rest' => true,
		]);

		// Venue CPT
		register_post_type('venue', [
			'labels' => [
				'name' => 'Venues',
				'singular_name' => 'Venue',
				'add_new_item' => 'Add New Venue',
				'edit_item' => 'Edit Venue',
			],
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => 'edit.php?post_type=event',
			'supports' => ['title'],
			'show_in_rest' => true,
		]);
	}

	public static function register_taxonomies() {
		// City Taxonomy for Venue
		register_taxonomy('venue_city', 'venue', [
			'labels' => [
				'name' => 'Cities',
				'singular_name' => 'City',
				'menu_name' => 'Cities',
			],
			'public' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_rest' => true,
			'show_in_menu' => 'edit.php?post_type=event',
		]);
	}

	public static function enforce_single_city($post_id) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if (get_post_type($post_id) !== 'venue') return;

		$terms = wp_get_post_terms($post_id, 'venue_city', ['fields' => 'ids']);
		if (count($terms) > 1) {
			wp_set_post_terms($post_id, [$terms[0]], 'venue_city', false);
		}
	}

	public static function remove_city_metabox() {
		remove_meta_box('tagsdiv-venue_city', 'venue', 'side');
	}

	public static function add_taxonomy_submenu() {
		add_submenu_page(
			'edit.php?post_type=event',
			'Cities',
			'Cities',
			'manage_categories',
			'edit-tags.php?taxonomy=venue_city&post_type=venue'
		);
	}

	public static function filter_archive_title($title) {
		if (is_post_type_archive('event')) {
			$title = esc_html__('Agenda de Shows e Eventos Culturais em Florianópolis e no Brasil', 'your-text-domain');
		}
		return $title;
	}

	public static function filter_archive_description($description) {
		if (is_post_type_archive('event')) {
			$description = wp_kses_post(
				'<p>' . esc_html__('Confira os melhores shows, festas e eventos culturais em Florianópolis. Atualizamos nossa agenda semanalmente com as principais atrações da cena local, da música independente e os grandes shows Brasil afora.', 'your-text-domain') . '</p>'
			);
		}
		return $description;
	}
}

UF_Event_Plugin::init();

// 301 Event redirects
add_action('template_redirect', 'uf_redirect_event_permalink');
function uf_redirect_event_permalink() {
	if (is_singular('event')) {
		$acf_link = get_field('link');
		if ($acf_link) {
			if (!str_starts_with($acf_link, 'http')) {
				$acf_link = home_url($acf_link);
			}
			wp_redirect($acf_link, 301);
			exit;
		}
	}
}

// Admin UI Edits
add_action('init', 'uf_remove_editor_from_event_cpt');
function uf_remove_editor_from_event_cpt() {
	remove_post_type_support('event', 'editor');
}

add_action('admin_notices', 'uf_show_event_redirect_notice');
function uf_show_event_redirect_notice() {
	global $post;

	if (
		isset($post) &&
		$post->post_type === 'event' &&
		get_current_screen()->base === 'post'
	) {
		$acf_link = get_field('link', $post->ID);
		if ($acf_link) {
			if (!str_starts_with($acf_link, 'http')) {
				$acf_link = home_url($acf_link);
			}

			echo '<div class="notice notice-info is-dismissible">';
			echo '<p><strong>Heads up:</strong> This event will redirect visitors to <a href="' . esc_url($acf_link) . '" target="_blank">' . esc_html($acf_link) . '</a>.</p>';
			echo '</div>';
		}
	}
}

add_action('pre_get_posts', 'uf_order_venues_alphabetically_admin');
function uf_order_venues_alphabetically_admin($query) {
	if (!is_admin() || !$query->is_main_query()) {
		return;
	}

	$screen = get_current_screen();
	if ($screen && $screen->post_type === 'venue') {
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
	}
}

// Past Event Archives
add_action('init', 'uf_register_past_event_status');
function uf_register_past_event_status() {
	register_post_status('past_event', [
		'label'                     => 'Past Event',
		'public'                    => false,
		'exclude_from_search'       => true,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop('Past Event', 'Past Events'),
	]);
}

add_action('admin_footer-post.php', 'uf_add_custom_status_to_dropdown');
function uf_add_custom_status_to_dropdown() {
	global $post;
	if ($post->post_type !== 'event') return;

	$selected = $post->post_status === 'past_event' ? 'selected="selected"' : '';
	echo "<script>
        jQuery(document).ready(function($) {
            $('select#post_status').append('<option value=\"past_event\" $selected>Past Event</option>');
        });
    </script>";
}

add_action('admin_head', 'uf_style_past_events_in_admin');
function uf_style_past_events_in_admin() {
	echo '<style>.status-past_event { opacity: 0.5; }</style>';
}

add_filter('the_title', 'uf_add_past_event_label_to_title', 10, 2);
function uf_add_past_event_label_to_title($title, $post_id) {
	$post = get_post($post_id);
	if ($post->post_type === 'event' && $post->post_status === 'past_event') {
		$title .= ' (Expirado)';
	}
	return $title;
}

// Archive Events Cron
add_action('wp', 'uf_schedule_event_archiver');
function uf_schedule_event_archiver() {
	if (!wp_next_scheduled('uf_archive_past_events_daily')) {
		wp_schedule_event(time(), 'daily', 'uf_archive_past_events_daily');
	}
}

add_action('uf_archive_past_events_daily', 'uf_archive_past_events');
function uf_archive_past_events() {
	$today = date('Y-m-d');

	$past_events = get_posts([
		'post_type' => 'event',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_query' => [[
			'key' => 'event_date',
			'value' => $today,
			'compare' => '<',
			'type' => 'DATE'
		]]
	]);

	foreach ($past_events as $event) {
		wp_update_post([
			'ID' => $event->ID,
			'post_status' => 'past_event'
		]);
	}
}

// Event Details Gutenberg Block
add_action('init', function () {
	if (function_exists('load_plugin_textdomain')) {
		load_plugin_textdomain('your-plugin-domain', false, plugin_dir_path(__FILE__) . 'languages');
	}
});

add_action('acf/init', 'uf_register_event_details_block');
function uf_register_event_details_block() {
	if (function_exists('acf_register_block_type')) {
		acf_register_block_type([
			'name'              => 'event-details',
			'title'             => __('Event Details'),
			'description'       => __('Display selected event details'),
			'render_template'   => plugin_dir_path(__FILE__) . 'blocks/event-details/event-details.php',
			'category'          => 'widgets',
			'icon'              => 'calendar-alt',
			'keywords'          => ['event', 'concert', 'show'],
			'mode'              => 'edit',
			'supports'          => ['align' => true],
		]);
	}
}

// Enqueue Styles and Scripts for Event Widget + City Filter
function uf_enqueue_event_assets() {
	if (!is_admin()) {
		wp_enqueue_style(
			'underfloripa-events-css',
			plugin_dir_url(__FILE__) . 'css/underfloripa-events.min.css',
			[],
			'1.0'
		);

		wp_enqueue_script(
			'uf-events-script',
			plugins_url('js/underfloripa-events.js', __FILE__),
			['jquery'],
			'1.0',
			true
		);

		wp_localize_script('uf-events-script', 'ufEvents', [
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('uf_events_filter_nonce')
		]);
	}
}
add_action('wp_enqueue_scripts', 'uf_enqueue_event_assets');

// Widget Include
require_once plugin_dir_path(__FILE__) . 'includes/widget.php';

// AJAX Handlers
require_once plugin_dir_path(__FILE__) . 'includes/ajax-handlers.php';
