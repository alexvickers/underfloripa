<?php

// [lead] $content [/lead]

function lead_func($atts, $content = null) {

	return '<p class="lead text-primary text-center">' . $content . '</p>';

}
add_shortcode('lead', 'lead_func');

?>