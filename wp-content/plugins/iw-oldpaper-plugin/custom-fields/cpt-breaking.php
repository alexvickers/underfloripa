<?php

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_breaking-news-informations',
		'title' => 'Breaking news informations',
		'fields' => array (
			array (
				'key' => 'field_533c074d4f67b',
				'label' => 'Spot category',
				'name' => 'spot_category',
				'type' => 'text',
				'instructions' => 'A label text before the breaking news text (the title)',
				'required' => 1,
				'default_value' => '',
				'placeholder' => 'Breaking news',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => 30,
			),
			array (
				'key' => 'field_533bc80ad6852',
				'label' => 'Spot link',
				'name' => 'spot_link',
				'type' => 'text',
				'instructions' => 'Optional. Link the spot to a web page.',
				'default_value' => '',
				'placeholder' => 'http://',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'breakingnews',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'permalink',
				1 => 'the_content',
				2 => 'excerpt',
				3 => 'custom_fields',
				4 => 'discussion',
				5 => 'comments',
				6 => 'revisions',
				7 => 'slug',
				8 => 'author',
				9 => 'format',
				10 => 'featured_image',
				11 => 'categories',
				12 => 'tags',
				13 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
}
