<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

// Handle AJAX request to filter events by city
add_action('wp_ajax_uf_filter_events_by_city', 'uf_filter_events_by_city');
add_action('wp_ajax_nopriv_uf_filter_events_by_city', 'uf_filter_events_by_city');

function uf_filter_events_by_city() {
	check_ajax_referer('uf_events_filter_nonce', 'nonce');

	$city_id = isset($_POST['city_id']) ? intval($_POST['city_id']) : 0;

	wp_send_json_success([
		'html' => '<li>Filtered results will go here</li>'
	]);
}
