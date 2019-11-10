<?php

// [dropcap]$content[/dropcap]

function dropcap_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'style'      => ''
    ), $atts));
    
    if($style == '') {
    	$return = "";
    }
    else{
    	$return = "dropcap-".$style;
    }
    
	$out = "<span class='dropcap ". $return ."'>" . do_shortcode($content) . "</span>";
    return $out;
}

add_shortcode('dropcap', 'dropcap_func');

?>