<?php class UF_Upcoming_Events_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'uf_upcoming_events_widget',
            'Underfloripa: Upcoming Events',
            ['description' => 'Shows a list of upcoming events for the next 5 weeks.']
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $today = current_time('Y-m-d');
        $five_weeks_later = date('Y-m-d', strtotime('+5 weeks', current_time('timestamp')));

        $query = new WP_Query([
            'post_type' => 'event',
            'posts_per_page' => 5,
            'meta_key' => '_uf_event_date',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => '_uf_event_date',
                    'value' => [$today, $five_weeks_later],
                    'compare' => 'BETWEEN',
                    'type' => 'DATE'
                ]
            ]
        ]);

        if ($query->have_posts()) {
            echo '<ul class="uf-widget-events">';
            while ($query->have_posts()) {
                $query->the_post();
                $date = get_post_meta(get_the_ID(), '_uf_event_date', true);
                $doors_time = get_post_meta(get_the_ID(), '_uf_event_doors_time', true);
                $venue = get_post_meta(get_the_ID(), '_uf_event_venue', true);
                $city = get_post_meta(get_the_ID(), '_uf_event_city', true);

                $display_datetime = date_i18n('M j', strtotime($date));
                if (!empty($doors_time)) {
                    $display_datetime .= ', ' . date_i18n('H:i', strtotime($doors_time));
                }

                echo '<li>';
                echo '<strong>' . esc_html(get_the_title()) . '</strong><br>';
                echo '<small>' . esc_html($display_datetime) . '</small>';
                if (!empty($venue) || !empty($city)) {
                    echo '<br><small>' . esc_html($venue);
                    if (!empty($venue) && !empty($city)) echo ', ';
                    echo esc_html($city) . '</small>';
                }
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No events coming up.</p>';
        }

        wp_reset_postdata();

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'Upcoming Events';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
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
