<?php

// [btn type="$type" link="$link"] $content [/btn]

function btn_func($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
				'type' => 'primary', //default primary success info warning danger link
				'link' => '#',
			), $atts
		)
	);
	
	return '<a class="btn btn-'.$type.'" href="'.$link.'">'.do_shortcode($content).'</a>';
}

add_shortcode('btn', 'btn_func');

?>