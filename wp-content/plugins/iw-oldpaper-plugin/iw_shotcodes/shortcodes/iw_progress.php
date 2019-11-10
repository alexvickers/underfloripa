<?php

// [progress type="$type" percentage="$percentage"  showlabel="$showlabel"]

function progress_func($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
				'type' => 'info', // success or info or warning or danger
				'percentage' => 50,
				'showlabel' => true
			), $atts
		)
	);
	
	$out = '<div class="progress progress-striped active">
		  <div class="progress-bar  progress-bar-'.$type.'" role="progressbar" aria-valuenow="'.$percentage.'" 
		  aria-valuemin="0" aria-valuemax="100" style="width: '.$percentage.'%;">';
	
	if(!$showlabel){ 
		$out .= '<span class="sr-only">'.$percentage.'%</span>'; 
	}else{ 
		$out .= $percentage.'%'; 
	}
	
	$out .='</div>
		</div>';

	return $out;
}

add_shortcode('progress', 'progress_func');

?>