<?php
					
/*
	
featured articles
		
*/

global $iw_opt;
					
$args = array(
	'posts_per_page' => $iw_opt['countfeatured'],
	'ignore_sticky_posts' => 1
	);
					
if( isset($iw_opt['catfeatured']) and $iw_opt['catfeatured'] != ''){
	$args['cat'] = $iw_opt['catfeatured'];
}

					
$query = new WP_Query( $args );
								
if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
					
?>
					
<div class="col-sm-<?php echo(12/$iw_opt['colfeatured'])?> animated" data-anim="fadeInDown">
		
	<article <?php post_class('text-center') ?> id="post-<?php the_id() ?>">
						
		<div class="featimg">
		  	<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
		  		<div class="hoverimg">
				   	<i class="fa fa-search fa-5x fa-fw"></i>
			    </div>
		  		<?php if( has_post_thumbnail() ) :
					the_post_thumbnail('standard', array('class' => 'img-responsive')); 
				else : ?>
					<img src="http://placehold.it/800x600&text=<?php the_title() ?>" class="img-responsive">
				<?php endif; ?>
			</a>
			<div class="countcomments"><?php iw_post_format_icon() ?> <?php echo(get_comments_number()) ?></div>
			<?php if(function_exists('taqyeem_get_score')) { taqyeem_get_score(); } ?>
		</div>
		
		<?php if( has_post_format('quote') ) : ?>
		
			<p><?php echo get_post_meta( get_the_ID(), 'quote_text', true ) ?></p>
				
			<p><small><?php iw_post_format_icon() ?> <?php echo get_post_meta( get_the_ID(), 'quote_author', true ); ?></small></p>
			
		<?php else : ?>
		
			<h3>
				<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
				<?php
					$trim_title = get_the_title();
					$title_length = $iw_opt['featured-title-length'];
					echo wp_trim_words( $trim_title , $title_length ); 
				?>
				</a>
			</h3>
				
			<?php if( $iw_opt['featured-author'] ) : ?> 
				<p class="author"><?php the_author_posts_link() ?></p>	
			<?php endif; ?>

			<?php if( $iw_opt['featured-date'] ) : ?> 
				<p class="text-center"><time datetime="<?php the_time('Y-m-d'); ?>"><?php echo get_the_date() ?></time></p>
			<?php endif; ?>

			<?php if( $iw_opt['featured-excerpt'] ) { ?>

				<?php if( $iw_opt['featured-excerpt-length'] ) : ?>    
					<?php
						$content = get_the_excerpt();
						$length = $iw_opt['featured-excerpt-length'];
						echo wp_trim_words( $content , $length ); 
					?>
				<?php else : ?>
					<?php
						$content = get_the_excerpt();
						echo wp_trim_words( $content , '20' ); 
					?>
				<?php endif; ?>

			<?php } ?>
		
		<?php endif;?>
			
	</article>
			    	
</div>
					
<?php
					
endwhile; endif;
					
wp_reset_postdata();
					
?>