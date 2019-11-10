<?php

// [row] $content [/row]

function row_func($atts, $content = null) {
	return '<div class="row">'.do_shortcode($content).'</div> <!-- /.row -->';
}
add_shortcode('row', 'row_func');

// [col w='$num'] $content [/col]

function col_func($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
				'w' => '1'
			), $atts
		)
	);
	
	return '<div class="col-md-'.$w.' col-sm-'.$w.'">'.do_shortcode($content).'</div> <!-- /col '.$w.' -->';
}
add_shortcode('col', 'col_func');

?>