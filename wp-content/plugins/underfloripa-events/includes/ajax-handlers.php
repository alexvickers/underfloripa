<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

add_action('wp_ajax_uf_filter_events_by_city', 'uf_filter_events_by_city');
add_action('wp_ajax_nopriv_uf_filter_events_by_city', 'uf_filter_events_by_city');

function uf_filter_events_by_city() {
	$city = sanitize_text_field($_POST['city'] ?? '');

	$meta_query = [];

	if (!empty($city)) {
		$venue_ids = get_posts([
			'post_type' => 'venue',
			'fields' => 'ids',
			'posts_per_page' => -1,
			'tax_query' => [
				[
					'taxonomy' => 'venue_city',
					'field' => 'slug',
					'terms' => $city,
				]
			],
		]);

		if (!empty($venue_ids)) {
			$meta_query[] = [
				'key' => 'venue_post',
				'value' => $venue_ids,
				'compare' => 'IN',
			];
		} else {
			echo '<li class="event">Nenhum evento encontrado.</li>';
			wp_die();
		}
	}

	$query_args = [
		'post_type' => 'event',
		'posts_per_page' => 5,
		'meta_key' => 'event_date',
		'orderby' => 'meta_value',
		'order' => 'ASC',
	];

	if (!empty($meta_query)) {
		$query_args['meta_query'] = $meta_query;
	}

	$query = new WP_Query($query_args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$title = get_the_title();
			$date = get_field('event_date');
			$doors_time = get_field('doors_time');
			$link = get_field('link') ?: get_field('ticket_link');

			$venue = get_field('venue_post');
			$venue_name = $venue_city = '';
			if ($venue) {
				$venue_name = get_the_title($venue->ID);
				$terms = wp_get_post_terms($venue->ID, 'venue_city');
				if (!is_wp_error($terms) && !empty($terms)) {
					$venue_city = $terms[0]->name;
				}
			}

			$formatted_date = $date ? date_i18n('d/m', strtotime($date)) : '';
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
