<?php function uf_render_event_list($atts) {
    $now = current_time('timestamp');

    $five_weeks_later = strtotime('+5 weeks', $now);

    $query = new WP_Query([
        'post_type' => 'event',
        'posts_per_page' => -1,
        'meta_key' => '_uf_event_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => [
            [
                'key' => '_uf_event_date',
                'value' => [
                    date('Y-m-d\TH:i', $now),
                    date('Y-m-d\TH:i', $five_weeks_later)
                ],
                'compare' => 'BETWEEN',
                'type' => 'DATETIME'
            ]
        ]
    ]);

    if (!$query->have_posts()) {
        return '<p>No upcoming events.</p>';
    }

    ob_start();
    echo '<ul class="uf-event-list">';
    while ($query->have_posts()) {
        $query->the_post();

        $date = get_post_meta(get_the_ID(), '_uf_event_date', true);
        $location = get_post_meta(get_the_ID(), '_uf_event_location', true);
        $link = get_post_meta(get_the_ID(), '_uf_event_link', true);
        $formatted_date = date_i18n('F j, Y \a\t H:i', strtotime($date));

        echo '<li style="margin-bottom: 1.5em;">';
        echo '<strong>' . esc_html(get_the_title()) . '</strong><br>';
        echo '<em>' . esc_html($formatted_date) . '</em><br>';
        if ($location) echo esc_html($location) . '<br>';
        if ($link) echo '<a href="' . esc_url($link) . '" target="_blank">More info</a><br>';
        echo '</li>';
    }
    echo '</ul>';
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('uf_event_list', 'uf_render_event_list');
