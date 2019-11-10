<?php 

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_pages-options',
		'title' => 'Pages options',
		'fields' => array (
			array (
				'key' => 'field_533d21e4edca6',
				'label' => 'Hide page header',
				'name' => 'page_header',
				'type' => 'true_false',
				'instructions' => 'Show or hide the page header: featured image, title and page info (author, date, ecc.)',
				'message' => '',
				'default_value' => 0,
			),
			array (
				'key' => 'field_533d2253edca7',
				'label' => 'Hide sidebar',
				'name' => 'page_sidebar',
				'type' => 'true_false',
				'message' => '',
				'default_value' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
