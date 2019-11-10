 <?php global $iw_opt ?>
 
 <?php if( has_post_format('quote') ) : ?>
 	
 	<div class="hover"<?php 
    
    	if( has_post_thumbnail( $post->ID ) ) :
    		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	   		echo ' style="background-image: url('. $image[0] .')"';
	   	endif; ?>> </div>
	   	
	<div class="quote">
	 	<p class="textquote"><?php if( function_exists('acf') ) { echo get_post_meta( get_the_ID(), 'quote_text', true ); }; ?></p>
		<p><small><?php iw_post_format_icon() ?> <?php if( function_exists('acf') ) { echo get_post_meta( get_the_ID(), 'quote_author', true ); }; ?></small></p>
 	</div>
 	
<?php else: ?>	

    <a href="<?php the_permalink() ?>" class="hover"<?php 
    
    	if( has_post_thumbnail( $post->ID ) ) :
    		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	   		echo ' style="background-image: url('. $image[0] .')"';
	   	elseif( has_post_format('video') ):
			
			if( get_post_meta( get_the_ID(), 'video_service', true ) == 'youtube' ) :
		    	$videoimg = 'http://img.youtube.com/vi/'.get_post_meta( get_the_ID(), 'youtube_video_id', true ).'/maxresdefault.jpg';
			elseif( get_post_meta( get_the_ID(), 'video_service', true ) == 'vimeo' ) :
				$hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/'.get_post_meta( get_the_ID(), 'vimeo_video_id', true ).'.php'));
				$videoimg = $hash[0]['thumbnail_large'];
			endif;		
					
	   		echo 'style="background-image: url('.$videoimg.')"';
	   	endif; ?>> </a>
				    		
	<div class="info">
	   	<ul class="list-inline">
	   		<li><?php if( $iw_opt['single-author'])  { the_author_posts_link(); } ?></li>
	   		<li><?php if( $iw_opt['single-date'] ): ?><time datetime="<?php the_time('Y-m-d'); ?>"><?php echo get_the_date() ?></time><?php endif ?></li>
	   	</ul>
		<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
	</div>

<?php endif; ?>