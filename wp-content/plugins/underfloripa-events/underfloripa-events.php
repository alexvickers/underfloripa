<?php
/**
 * Plugin Name: Underfloripa Events
 * Description: Custom plugin to manage and display upcoming concerts and events on Underfloripa.
 * Version: 1.0
 * Author: Alexandre Aimbiré
 */

if (!defined('ABSPATH')) {
    exit;
}

// Register custom post type and taxonomy
function uf_register_event_post_type() {
    // Event CPT
    register_post_type('event', [
        'labels' => [
            'name' => 'Events',
            'singular_name' => 'Event',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => ['title', 'editor'],
        'has_archive' => false,
    ]);

    // Event Type taxonomy
    register_taxonomy('event_type', 'event', [
        'labels' => [
            'name' => 'Event Types',
            'singular_name' => 'Event Type',
        ],
        'public' => false,
        'show_ui' => true,
        'hierarchical' => true,
    ]);
}

add_action('init', 'uf_register_event_post_type');

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
add_action('wp_enqueue_scripts', 'uf_enqueue_event_styles');

require_once plugin_dir_path(__FILE__) . 'includes/meta-boxes.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/widget.php';