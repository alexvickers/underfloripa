<?php

add_action( 'init', 'exc_buttons' );

function exc_buttons() {
	add_filter('mce_external_plugins', 'exc_add_buttons');
    add_filter('mce_buttons', 'exc_register_buttons');
}	

function exc_add_buttons($plugin_array) {
	$plugin_array['exc'] = plugin_dir_url( __FILE__) . 'mce-plugin.js';
	return $plugin_array;
}

function exc_register_buttons($buttons) {
	array_push( $buttons, 
		'faicon', 
		'posts', 
		'alert', 
		'progress', 
		'grid', 
		'btn', 
		'servicebox', 
		'hr', 
		'dropcap',
		'slider', 
		'carousel', 
		'lead'
	);
	return $buttons;
}

?>