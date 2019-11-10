<?php

// [slider category='$category' count='$count']

function slider_func($atts, $content = null) {
	extract(
		shortcode_atts(
			array(
				'category' => '',
				'count' => 4
			), $atts
		)
	);
	
	$out = '<div id="carousel-generic" class="carousel slide" data-ride="carousel">
		
			<!-- Indicators -->
			<ol class="carousel-indicators">';
				for($i=0; $i<$count; $i++) {
					$out .= '<li data-target="#carousel-generic" data-slide-to="'.$i.'"';
					if($i==0): $out .= 'class="active"'; endif;
					$out .= '></li>';
				}
			$out .= '</ol>
			
			<!-- Wrapper for slides -->
			<div class="carousel-inner">';
				
				// slider articles
				
				$start = 1;
						
				$args = array(
					'posts_per_page' => $count,
					'ignore_sticky_posts' => 1,
					'category_name' => $category
				);
						
				$query = new WP_Query( $args );
								
				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
				
				$out .= '<div class="item '; if($start){ $out.='active'; $start = 0; } $out .= '">
					<a href="'.get_permalink().'">';
					
						if( has_post_thumbnail() ) :
							$get_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'slider' );
							$blog_thumbnail = $get_thumbnail[0];
						else:
							$blog_thumbnail = 'http://placehold.it/1160x480&text='. get_the_title();
						endif;
								
						$out .= '<img src="'. $blog_thumbnail .'" class="img-responsive" alt="'.get_the_title().'">';
								
					$out .= '</a>
					
					<div class="carousel-caption">
						<h2><a href="'.get_permalink().'">'.get_the_title().'</a></h2>
						<?php global $iw_opt ?>

						<ul class="textinfo list-inline text-center">
							<li>'.get_the_author().'</li>
							<li>'.get_the_category_list(', ').'</li>
							<li>';
							
							$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

							if ( comments_open() ) {
								if ( $num_comments == 0 ) {
									$comments = __('No responses', 'oldpaper');
								} elseif ( $num_comments > 1 ) {
									$comments = $num_comments . __(' responses', 'oldpaper');
								} else {
									$comments = __('One response', 'oldpaper');
								}
								$out .= '<a href="' . get_comments_link() .'">'. $comments.'</a>';
							} else {
								$out .= __('Comments are off for this post.', 'oldpaper');
							}
							
							$out .= '</li>
							<li><time datetime="'. get_the_time('Y-m-d').'">'.get_the_date().'</time></li>	
						</ul>
					</div>
				</div>';
				
				endwhile; endif;
				
				wp_reset_postdata();
				
			$out .= '</div>
			
			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-generic" data-slide="prev">
				<i class="fa fa-long-arrow-left fa-2x"></i>
			</a>
			
			<a class="right carousel-control" href="#carousel-generic" data-slide="next">
				<i class="fa fa-long-arrow-right fa-2x"></i>
			</a>
		
		</div>';
	    
	    // restore original
		wp_reset_postdata();
	    
	return $out;	    	
	
}
add_shortcode('slider', 'slider_func');