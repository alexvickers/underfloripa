<?php class UF_Upcoming_Events_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'uf_upcoming_events_widget',
            'Underfloripa: Upcoming Events',
            ['description' => 'Shows a list of upcoming events for the next 2 weeks or fills up to 5 if needed.']
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $today = current_time('Y-m-d');
        $two_weeks_later = date('Y-m-d', strtotime('+14 days', current_time('timestamp')));

        $primary_query = new WP_Query([
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
                    'type' => 'DATE'
                ]
            ]
        ]);

        $events = $primary_query->posts;

        // Query 2: fill remaining with future events (if needed)
        if (count($events) < 5) {
            $remaining = 5 - count($events);

            $secondary_query = new WP_Query([
                'post_type' => 'event',
                'posts_per_page' => $remaining,
                'post__not_in' => wp_list_pluck($events, 'ID'),
                'meta_key' => 'event_date',
                'orderby' => 'meta_value',
                'order' => 'ASC',
                'meta_query' => [
                    [
                        'key' => 'event_date',
                        'value' => $today,
                        'compare' => '>=',
                        'type' => 'DATE'
                    ]
                ]
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
                $venue = get_field('venue', $event_id);
                $city = get_field('city', $event_id);
                $link = get_field('link', $event_id);

                $formatted_date = date_i18n('d/m', strtotime($event_date));
                if (!empty($doors_time)) {
                    $formatted_date .= ' - ' . date_i18n('H:i', strtotime($doors_time));
                }

                echo '<li class="event">';
                if (!empty($link)) {
                    echo '<a href="' . esc_url($link) . '" target="_blank">';
                }
                echo '<h4>' . esc_html($title) . '</h4>';
                if (!empty($link)) {
                    echo '</a>';
                }
                echo '<small>' . esc_html($formatted_date) . '</small></br>';
                if (!empty($venue) || !empty($city)) {
                    echo '<small>' . esc_html($venue);
                    if (!empty($venue) && !empty($city)) echo ', ';
                    echo esc_html($city) . '</small>';
                }
                echo '</li>';
            }
            echo '</ul>';
        }

        wp_reset_postdata();

        echo $args['after_widget'];
    }

    public function form($instance) {
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
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title'] = sanitize_text_field($new_instance['title']);
        return $instance;
    }
}

function uf_register_events_widget() {
    register_widget('UF_Upcoming_Events_Widget');
}
add_action('widgets_init', 'uf_register_events_widget');
