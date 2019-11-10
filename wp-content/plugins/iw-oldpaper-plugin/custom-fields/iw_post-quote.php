<?php

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_quote-post-informations',
		'title' => 'Quote post informations',
		'fields' => array (
			array (
				'key' => 'field_5339342885f4b',
				'label' => 'Quote text',
				'name' => 'quote_text',
				'type' => 'textarea',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_533bff3677fa7',
				'label' => 'Quote author',
				'name' => 'quote_author',
				'type' => 'text',
				'required' => 1,
				'default_value' => 'Anonymous',
				'placeholder' => 'Anonymous',
				'prepend' => '',
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
					'value' => 'quote',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
				1 => 'excerpt',
			),
		),
		'menu_order' => 0,
	));
}
