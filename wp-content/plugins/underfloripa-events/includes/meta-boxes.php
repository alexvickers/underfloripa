<?php function uf_add_event_meta_boxes() {
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
    // Nonce field for security
    wp_nonce_field('uf_save_event_meta', 'uf_event_meta_nonce');

    // Retrieve existing values
    $date = get_post_meta($post->ID, '_uf_event_date', true);
    $location = get_post_meta($post->ID, '_uf_event_location', true);
    $link = get_post_meta($post->ID, '_uf_event_link', true);

    ?>
    <p>
        <label for="uf_event_date">Date & Time:</label><br>
        <input type="datetime-local" id="uf_event_date" name="uf_event_date" value="<?php echo esc_attr($date); ?>" style="width:100%;">
    </p>
    <p>
        <label for="uf_event_location">Location:</label><br>
        <input type="text" id="uf_event_location" name="uf_event_location" value="<?php echo esc_attr($location); ?>" style="width:100%;">
    </p>
    <p>
        <label for="uf_event_link">Optional Link (e.g. ticket URL):</label><br>
        <input type="url" id="uf_event_link" name="uf_event_link" value="<?php echo esc_attr($link); ?>" style="width:100%;">
    </p>
    <?php
}

function uf_save_event_meta($post_id) {
    // Check nonce
    if (!isset($_POST['uf_event_meta_nonce']) || !wp_verify_nonce($_POST['uf_event_meta_nonce'], 'uf_save_event_meta')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) return;

    // Save fields
    if (isset($_POST['uf_event_date'])) {
        update_post_meta($post_id, '_uf_event_date', sanitize_text_field($_POST['uf_event_date']));
    }

    if (isset($_POST['uf_event_location'])) {
        update_post_meta($post_id, '_uf_event_location', sanitize_text_field($_POST['uf_event_location']));
    }

    if (isset($_POST['uf_event_link'])) {
        update_post_meta($post_id, '_uf_event_link', esc_url_raw($_POST['uf_event_link']));
    }
}
add_action('save_post_event', 'uf_save_event_meta');
