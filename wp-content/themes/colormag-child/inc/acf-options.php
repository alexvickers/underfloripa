<?php
// Add ACF options page the right way
add_action('acf/init', function() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title'    => 'Site Settings',
            'menu_title'    => 'Site Settings',
            'menu_slug'     => 'site-settings',
            'capability'    => 'manage_options',
            'redirect'      => false
        ));
    }
});

function add_custom_head_script() {
    if (function_exists('get_field')) {
        $custom_script = get_field('custom_head_script', 'option');

        if ($custom_script) {
            echo $custom_script;
        }
    }
}
add_action('wp_head', 'add_custom_head_script');
