<?php

// [carousel category='$category' count='$count' columns='$columns' title='$title']

function carousel_func($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
				'category' => '',
				'count' => 6,
				'columns' => 3,
				'title' => 'show'
				
			), $atts
		)
	);
	
	$out = '<script>
		jQuery(document).ready(function(){
			jQuery(".slick").slick({
			  infinite: true,
			  dots: true,
			  slidesToShow: '.$columns.',
			  slidesToScroll: '.$columns.'
			});
		});
	</script>';
	
	
	// add html
	
	$out .= '<div class="iw_posts_carousel">
				<div class="slick">';
			
				$the_query = new WP_Query(
					 array (
					 	'post_type' => 'post',
					 	'category_name' => $category,
					 	'posts_per_page' => $count
					 )
				);
				
				//conteggio posts
				$n = $start = 0;
				
				if($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
					
					if( has_post_thumbnail() ) :
						$get_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'standard' );
						$blog_thumbnail = $get_thumbnail[0];
					else:
						$blog_thumbnail = 'http://placehold.it/800x600&text='.get_the_title();
					endif;
								
					$out .= '<div>
					
						<div class="insideslide"><a href="'.get_permalink().'" title="'.get_the_title().'">
							<img src="'. $blog_thumbnail .'" class="img-responsive" alt="'.get_the_title().'">';
							
							if($title == 'show'){ $out .= '<h3>'.get_the_title().'</h3>'; }
							
					$out .= '</a></div>
						
						</div>';
					
				endwhile; endif; 
			
	            $out .= '</div><!--/.slick--> 
	        </div><!--/.iw_posts_carousel-->';
	    
	    // restore original
		wp_reset_postdata();
	    
	return $out;	    	
	
}
add_shortcode('carousel', 'carousel_func');