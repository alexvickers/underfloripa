<?php

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_video-post-information',
		'title' => 'Video post information',
		'fields' => array (
			array (
				'key' => 'field_533c00292ec65',
				'label' => 'Video service',
				'name' => 'video_service',
				'type' => 'select',
				'instructions' => 'Select your favorite video service',
				'required' => 1,
				'choices' => array (
					'youtube' => 'YouTube',
					'vimeo' => 'Vimeo',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_53392efacf0df',
				'label' => 'YouTube video Id',
				'name' => 'youtube_video_id',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_533c00292ec65',
							'operator' => '==',
							'value' => 'youtube',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => 'https://www.youtube.com/watch?v=',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => 14,
			),
			array (
				'key' => 'field_533bffde2ec64',
				'label' => 'Vimeo video id',
				'name' => 'vimeo_video_id',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_533c00292ec65',
							'operator' => '==',
							'value' => 'vimeo',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => 'https://vimeo.com/',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => 14,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'video',
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
