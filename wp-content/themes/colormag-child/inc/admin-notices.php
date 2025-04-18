<?php
add_action('admin_notices', function () {
    if (!current_user_can('manage_options')) return;

    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'plugins') return;

    if (get_user_meta(get_current_user_id(), 'hide_recommended_plugins_notice', true)) return;

    $plugins = [
        'Advanced Custom Fields' => 'https://wordpress.org/plugins/advanced-custom-fields/',
        'CookieYes'              => 'https://br.wordpress.org/plugins/cookie-law-info/',
        'Disable Comments RB'    => 'https://br.wordpress.org/plugins/disable-comments-rb/',
        'LiteSpeed Cache'        => 'https://br.wordpress.org/plugins/litespeed-cache/',
        'Rank Math SEO'          => 'https://br.wordpress.org/plugins/seo-by-rank-math/',
        'Relevanssi'             => 'https://br.wordpress.org/plugins/relevanssi/',
        'Google Site Kit'        => 'https://br.wordpress.org/plugins/google-site-kit/',
        'Smush'                  => 'https://br.wordpress.org/plugins/wp-smushit/',
        'Wordfence Security'     => 'https://br.wordpress.org/plugins/wordfence/'
    ];

    echo '<div class="notice notice-info is-dismissible recommended-plugins-notice">';
    echo '<p><strong>Recommended Plugins:</strong></p><ul style="margin-left: 1em;">';

    foreach ($plugins as $name => $url) {
        echo "<li><a href='{$url}' target='_blank'>{$name}</a></li>";
    }

    echo '</ul></div>';
});

add_action('admin_footer', function () {
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'plugins') return;
?>
    <script>
        (function($) {
            $('.recommended-plugins-notice').on('click', '.notice-dismiss', function() {
                $.post(ajaxurl, {
                    action: 'hide_recommended_plugins_notice'
                });
            });
        })(jQuery);
    </script>
<?php
});

add_action('wp_ajax_hide_recommended_plugins_notice', function () {
    update_user_meta(get_current_user_id(), 'hide_recommended_plugins_notice', true);
    wp_die();
});
