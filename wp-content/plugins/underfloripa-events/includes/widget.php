<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}

class UF_Upcoming_Events_Widget extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
			'uf_upcoming_events_widget',
			'Underfloripa: Upcoming Events',
			['description' => 'Shows a list of the next 5 upcoming events.']
		);
	}

	public function widget($args, $instance)
	{
		echo $args['before_widget'];

		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}

		$today = current_time('Y-m-d');

		$primary_query = new WP_Query([
			'post_type'      => 'event',
			'posts_per_page' => 5,
			'meta_key'       => 'event_date',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
			'meta_query' => [
				'relation' => 'AND',
				[
					'key'     => 'event_date',
					'value'   => $today,
					'compare' => '>=',
					'type'    => 'DATE',
				],
				[
					'relation' => 'OR',
					[
						'key'     => 'event_status',
						'compare' => 'NOT EXISTS',
					],
					[
						'key'     => 'event_status',
						'value'   => 'archived',
						'compare' => '!=',
					]
				]
			]
		]);

		$cities_with_upcoming_events = get_transient('uf_cities_with_upcoming_events');

		if ($cities_with_upcoming_events === false) {
			$event_query = new WP_Query([
				'post_type' => 'event',
				'posts_per_page' => -1,
				'meta_key' => 'event_date',
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'meta_query' => [
					'relation' => 'AND',
					[
						'key'     => 'event_date',
						'value'   => $today,
						'compare' => '>=',
						'type'    => 'DATE',
					],
					[
						'relation' => 'OR',
						[
							'key'     => 'event_status',
							'compare' => 'NOT EXISTS',
						],
						[
							'key'     => 'event_status',
							'value'   => 'archived',
							'compare' => '!=',
						]
					]
				]
			]);

			$city_slugs = [];

			if ($event_query->have_posts()) {
				foreach ($event_query->posts as $event) {
					$venue = get_field('venue_post', $event->ID);
					if ($venue) {
						$terms = wp_get_post_terms($venue->ID, 'venue_city');
						if (!is_wp_error($terms) && !empty($terms)) {
							foreach ($terms as $term) {
								$city_slugs[$term->slug] = $term->name;
							}
						}
					}
				}
			}

			wp_reset_postdata();
			$cities_with_upcoming_events = $city_slugs;
			set_transient('uf_cities_with_upcoming_events', $cities_with_upcoming_events, 900);
		}

		echo '<select id="uf-event-city-filter" class="uf-event-filter">';
		echo '<option value="">Todas as cidades</option>';
		foreach ($cities_with_upcoming_events as $slug => $name) {
			echo '<option value="' . esc_attr($slug) . '">' . esc_html($name) . '</option>';
		}
		echo '</select>';

		wp_reset_postdata();

		$events = $primary_query->posts;

		if (count($events) < 5) {
			$remaining = 5 - count($events);

			$secondary_query = new WP_Query([
				'post_type' => 'event',
				'posts_per_page' => $remaining,
				'post__not_in' => wp_list_pluck($events, 'ID'),
				'meta_key' => 'event_date',
				'orderby' => 'meta_value',
				'order' => 'ASC',
				'meta_query'     => [
					'relation' => 'AND',
					[
						'key'     => 'event_date',
						'value'   => $today,
						'compare' => '>=',
						'type'    => 'DATE',
					],
					[
						'key'     => 'event_status',
						'value'   => 'archived',
						'compare' => '!=',
					]
				],
			]);

			$events = array_merge($events, $secondary_query->posts);
		}

		if (!empty($events)) {
			echo '<ul class="uf-widget-events">';
			foreach ($events as $event) {
				$event_id = $event->ID;
				$title = get_the_title($event_id);
				$event_date = get_field('event_date', $event_id);
				$doors_time = get_field('doors_time', $event_id);
				$link = get_permalink($event_id);
				$ticket_link = get_field('ticket_link', $event_id);
				$venue = get_field('venue_post', $event_id);

				$venue_name = $venue_city = '';
				if ($venue) {
					$venue_name = get_the_title($venue->ID);
					$venue_city_value = get_field('venue_city', $venue->ID);

					if ($venue_city_value) {
						if (is_array($venue_city_value) && isset($venue_city_value['name'])) {
							$venue_city = $venue_city_value['name'];
						} elseif (is_object($venue_city_value) && isset($venue_city_value->name)) {
							$venue_city = $venue_city_value->name;
						} elseif (is_numeric($venue_city_value)) {
							$term = get_term($venue_city_value);
							if (!is_wp_error($term) && $term) {
								$venue_city = $term->name;
							}
						}
					}
				}

				$formatted_date = date_i18n('d/m', strtotime($event_date));
				if (!empty($doors_time)) {
					$formatted_date .= ' - ' . date_i18n('H:i', strtotime($doors_time));
				}

				$link_to_use = !empty($link) ? $link : $ticket_link;

				echo '<li class="event">';
				echo '<a href="' . esc_url($link_to_use) . '">';
				echo '<h4>' . esc_html($title) . ' - ' . esc_html($venue_city) . '</h4>';
				echo '</a>';
				echo '<small>' . esc_html($formatted_date) . '</small></br>';
				if (!empty($venue_name) || !empty($venue_city)) {
					echo '<small>' . esc_html($venue_name);
					if (!empty($venue_name) && !empty($venue_city)) echo ', ';
					echo esc_html($venue_city) . '</small>';
				}
				echo '</li>';
			}
			echo '</ul>';
		}

		$agenda_link = get_site_url() . '/agenda';
		echo '<a href="' . esc_url($agenda_link) . '" class="button view-more-events"><span>Ver mais eventos</span></a>';

		wp_reset_postdata();

		echo $args['after_widget'];
	}

	public function form($instance)
	{
		$title = !empty($instance['title']) ? $instance['title'] : 'Próximos Eventos';
?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Título:</label>
			<input class="widefat"
				id="<?php echo esc_attr($this->get_field_id('title')); ?>"
				name="<?php echo esc_attr($this->get_field_name('title')); ?>"
				type="text"
				value="<?php echo esc_attr($title); ?>">
		</p>
<?php }

	public function update($new_instance, $old_instance)
	{
		$instance = [];
		$instance['title'] = sanitize_text_field($new_instance['title']);
		return $instance;
	}
}

function uf_register_events_widget()
{
	register_widget('UF_Upcoming_Events_Widget');
}
add_action('widgets_init', 'uf_register_events_widget');

function uf_clear_upcoming_event_cache($post_id)
{
	if (get_post_type($post_id) === 'event') {
		delete_transient('uf_cities_with_upcoming_events');
	}
}
add_action('save_post', 'uf_clear_upcoming_event_cache');
add_action('deleted_post', 'uf_clear_upcoming_event_cache');

function uf_order_events_in_admin($query)
{
	if (is_admin() && $query->is_main_query() && $query->get('post_type') === 'event') {
		$query->set('meta_key', 'event_date');
		$query->set('orderby', 'meta_value');
		$query->set('order', 'ASC');
		$query->set('meta_type', 'DATE');
	}
}
add_action('pre_get_posts', 'uf_order_events_in_admin');
