<?php

// [alert type="$type"] $content [/alerts]

function alert_func($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
				'type' => 'info'
			), $atts
		)
	);
	
	return '<div class="alert alert-'.$type.' alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  '.$content.'
		</div>';
}
add_shortcode('alert', 'alert_func');

?>