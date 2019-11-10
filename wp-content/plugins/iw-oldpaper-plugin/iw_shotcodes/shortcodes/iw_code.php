<?php

// [code] $content [/code]

function code_func($atts, $content = null) {
	return '<pre class="code">'.$content.'</pre>';
}
add_shortcode('code', 'code_func');

?>