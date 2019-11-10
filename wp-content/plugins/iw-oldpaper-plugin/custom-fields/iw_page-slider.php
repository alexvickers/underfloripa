<?php

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_slider-options',
		'title' => 'Slider options',
		'fields' => array (
			array (
				'key' => 'field_533c175bc30c9',
				'label' => 'Slider category',
				'name' => 'slider_category',
				'type' => 'taxonomy',
				'instructions' => 'If not selected will show the last posts',
				'taxonomy' => 'category',
				'field_type' => 'select',
				'allow_null' => 1,
				'load_save_terms' => 0,
				'return_format' => 'id',
				'multiple' => 0,
			),
			array (
				'key' => 'field_533c17a9c30ca',
				'label' => 'Post count',
				'name' => 'post_count',
				'type' => 'number',
				'instructions' => 'How many posts to show?',
				'required' => 1,
				'default_value' => 4,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => 1,
				'max' => 10,
				'step' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-slider.php',
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
