<?php

// [postsincol category='$cat' col='$col' count='$count' excerpt'$excerpt']

function postsincol_func($atts) {
	extract(
		shortcode_atts(
			array(
				'category' => get_option('default_category'),
				'col' => 3,
				'count' => 3,
				'excerpt' => 'show'
			), $atts
		)
	);
	
	$articlecol = floor(12/$col);
	
	global $post;
    $out = '';
	
	$args = array (
				'post_type' 		=> 'post',
				'posts_per_page'	=> $count,
				'category_name' 	=> $category
			);
	
	query_posts( $args );
	
	$out .= '<div class="row">';
	
	if( have_posts() ): while( have_posts() ) : the_post();
	
	$out .= '<div class="col-sm-'.$articlecol.' animated" data-anim="fadeInLeft">
		
		<article '.get_post_class('text-center').' id="post-'.get_the_id().'">
							
			<div class="featimg">
			  	<a href="'. get_permalink(). '" title="' . get_the_title() . '">';
			  	
			  		if( has_post_thumbnail() ) :
			
						$blog_thumbnail= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'standard' );
						$thumb_id = get_post_thumbnail_id(get_the_ID());
						$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
						
						$out .= '<img class="img-responsive" src="'.$blog_thumbnail[0].'" alt="'.$alt .'">';
					
					else:
					
						$out .= '<img src="http://placehold.it/800x600&text='.get_the_title().'" class="img-responsive">';
						
					endif;
					
				$out .= '</a>
				<div class="countcomments">'.get_comments_number().'</div>
			</div>
			
				<h3><a href="'. get_permalink(). '" title="' . get_the_title() . '">'. get_the_title(). '</a></h3>
					
				<p class="author">'.get_the_author().'</p>
					
				<p class="text-center"><time datetime="'.get_the_time('Y-m-d').'">'.get_the_date().'</time></p>';
				
				if($excerpt == 'show') { $out .= get_the_excerpt(); }
			
		$out .= '</article>
				    	
	</div>';
	
	endwhile; 
	
	else: 
	
		$out .= 'No posts found: review your shortcode in the editor!'; 
	
	endif;
	
	$out .= '</div>';
	
	wp_reset_query();
	
	return $out;
}

add_shortcode('postsincol', 'postsincol_func');

?>