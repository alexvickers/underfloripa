<?php

// [i class='$id']

function ico_func($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
				'class' => 'default',
			), $atts
		)
	);
	
	return '<i class="fa '.$class.'"></i>';
}

add_shortcode('i', 'ico_func');

?>