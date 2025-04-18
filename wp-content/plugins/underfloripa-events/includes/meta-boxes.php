<?php
function uf_add_event_meta_boxes() {
    add_meta_box(
        'uf_event_details',
        'Event Details',
        'uf_render_event_meta_box',
        'event',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'uf_add_event_meta_boxes');

function uf_render_event_meta_box($post) {
    wp_nonce_field('uf_save_event_meta', 'uf_event_meta_nonce');

    $date = get_post_meta($post->ID, '_uf_event_date', true);
    $doors_time = get_post_meta($post->ID, '_uf_event_doors_time', true);
    $venue = get_post_meta($post->ID, '_uf_event_venue', true);
    $city = get_post_meta($post->ID, '_uf_event_city', true);
    $link = get_post_meta($post->ID, '_uf_event_link', true);
    ?>
    <p>
        <label for="uf_event_date">Event Date:</label><br>
        <input type="date" id="uf_event_date" name="uf_event_date" value="<?php echo esc_attr($date); ?>" style="width:100%;">
    </p>
    <p>
        <label for="uf_event_doors_time">Doors Open (Time):</label><br>
        <input type="time" id="uf_event_doors_time" name="uf_event_doors_time" value="<?php echo esc_attr($doors_time); ?>" style="width:100%;">
    </p>
    <p>
        <label for="uf_event_venue">Venue:</label><br>
        <input type="text" id="uf_event_venue" name="uf_event_venue" value="<?php echo esc_attr($venue); ?>" style="width:100%;">
    </p>
    <p>
        <label for="uf_event_city">City:</label><br>
        <input type="text" id="uf_event_city" name="uf_event_city" value="<?php echo esc_attr($city); ?>" style="width:100%;">
    </p>
    <p>
        <label for="uf_event_link">Optional Link (e.g. ticket URL):</label><br>
        <input type="url" id="uf_event_link" name="uf_event_link" value="<?php echo esc_attr($link); ?>" style="width:100%;">
    </p>
    <?php
}

function uf_save_event_meta($post_id) {
    if (!isset($_POST['uf_event_meta_nonce']) || !wp_verify_nonce($_POST['uf_event_meta_nonce'], 'uf_save_event_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (!current_user_can('edit_post', $post_id)) return;

    // Save the new fields
    $fields = [
        'uf_event_date' => '_uf_event_date',
        'uf_event_doors_time' => '_uf_event_doors_time',
        'uf_event_venue' => '_uf_event_venue',
        'uf_event_city' => '_uf_event_city',
        'uf_event_link' => '_uf_event_link'
    ];

    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            $value = ($field === 'uf_event_link') ? esc_url_raw($_POST[$field]) : sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, $meta_key, $value);
        }
    }
}
add_action('save_post_event', 'uf_save_event_meta');
