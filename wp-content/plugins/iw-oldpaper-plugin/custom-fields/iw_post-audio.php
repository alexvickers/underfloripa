<?php

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_audio-post-informations',
		'title' => 'Audio post informations',
		'fields' => array (
			array (
				'key' => 'field_533945e81bda7',
				'label' => 'Soundcloud track',
				'name' => 'soundcloud_track',
				'type' => 'text',
				'instructions' => 'The URL address of the Soundtrack audio post. For example: for https://soundcloud.com/officialmetallica/metallica-master-of-puppets insert officialmetallica/metallica-master-of-puppets',
				'default_value' => '',
				'placeholder' => 'officialmetallica/metallica-master-of-puppets',
				'prepend' => 'https://soundcloud.com/',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'audio',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
