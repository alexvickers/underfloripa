<?php

// [servicebox icon="$ico" title="$title" link="$link"] $content [/col]

function hr_func($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
				'gap' => '20'
			), $atts
		)
	);
	
	return '<hr style="margin:'.$gap.'px 0">';
}
add_shortcode('hr', 'hr_func');

?>