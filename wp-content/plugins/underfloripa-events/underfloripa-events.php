<?php /**
 * Plugin Name: Underfloripa Events
 * Description: Manage and display upcoming concerts and events on Underfloripa.
 * Version: 1.1
 * Author: Alexandre Aimbiré
 */

if (!defined('ABSPATH')) {
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
add_action('init', 'uf_register_event_post_type');
function uf_register_event_post_type() {
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
}

add_action('init', 'uf_register_venue_post_type');
function uf_register_venue_post_type() {
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
function uf_schedule_event_archiver()
{
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
add_action('init', function() {
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

// Enqueue Styles
add_action('wp_enqueue_scripts', 'uf_enqueue_event_styles');
function uf_enqueue_event_styles() {
	if (!is_admin()) {
		wp_enqueue_style(
			'underfloripa-events-css',
			plugin_dir_url(__FILE__) . 'css/underfloripa-events.css',
			[],
			'1.0'
		);
	}
}

// Widget Include
require_once plugin_dir_path(__FILE__) . 'includes/widget.php';
