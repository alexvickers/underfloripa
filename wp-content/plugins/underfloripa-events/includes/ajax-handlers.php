<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

add_action('wp_ajax_uf_filter_events_by_city', 'uf_filter_events_by_city');
add_action('wp_ajax_nopriv_uf_filter_events_by_city', 'uf_filter_events_by_city');

function uf_filter_events_by_city()
{
	$city = sanitize_text_field($_POST['city'] ?? '');

	$today = current_time('Y-m-d');
	$two_weeks_later = date('Y-m-d', strtotime('+14 days', current_time('timestamp')));

	$tax_query = [];

	if (!empty($city)) {
		$tax_query[] = [
			'taxonomy' => 'venue_city',
			'field' => 'slug',
			'terms' => $city,
		];
	}

	$query_args = [
		'post_type' => 'event',
		'posts_per_page' => 5,
		'meta_key' => 'event_date',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_query' => [
			[
				'key' => 'event_date',
				'value' => [$today, $two_weeks_later],
				'compare' => 'BETWEEN',
				'type' => 'DATE',
			]
		],
	];

	if (!empty($tax_query)) {
		$query_args['tax_query'] = $tax_query;
	}

	$query = new WP_Query($query_args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$event_id = get_the_ID();
			$title = get_the_title();
			$date = get_field('event_date');
			$doors_time = get_field('doors_time');
			$link = get_field('link') ?: get_field('ticket_link');

			$venue = get_field('venue_post');
			$venue_name = $venue_city = '';
			if ($venue) {
				$venue_name = get_the_title($venue->ID);
				$term = get_field('venue_city', $venue->ID);
				if ($term && is_object($term)) {
					$venue_city = $term->name;
				}
			}

			$formatted_date = date_i18n('d/m', strtotime($date));
			if ($doors_time) {
				$formatted_date .= ' - ' . date_i18n('H:i', strtotime($doors_time));
			}

			echo '<li class="event">';
			echo '<a href="' . esc_url($link) . '" target="_blank">';
			echo '<h4>' . esc_html($title) . ' - ' . esc_html($venue_city) . '</h4>';
			echo '</a>';
			echo '<small>' . esc_html($formatted_date) . '</small><br>';
			if ($venue_name || $venue_city) {
				echo '<small>' . esc_html($venue_name);
				if ($venue_name && $venue_city) echo ', ';
				echo esc_html($venue_city) . '</small>';
			}
			echo '</li>';
		}
	} else {
		echo '<li class="event">Nenhum evento encontrado.</li>';
	}

	wp_reset_postdata();
	wp_die();
}
