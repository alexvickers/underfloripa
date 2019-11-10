<?php global $iw_opt ?>

<div class="articlebox">

<article <?php post_class('row animated') ?> id="post-<?php the_id() ?>" data-anim="fadeInUp">
	
	<?php if( has_post_format('quote') ) : ?>
	
		<div class="col-sm-10 col-sm-offset-1">
			<div class="textquote">
				<?php echo get_post_meta( get_the_ID(), 'quote_text', true );?>	
			</div>
			<p><small><?php iw_post_format_icon() ?>  <?php echo get_post_meta( get_the_ID(), 'quote_author', true ); ?></small></p>
		</div>
		
	<?php elseif( has_post_format('image') ) : ?>
	
		<div class="col-sm-12">
			<div class="featimg">
		    	<a href="<?php the_permalink() ?>">
				<?php if( has_post_thumbnail() ) :
					the_post_thumbnail('full', array('class' => 'img-responsive')); 
				else : ?>
				    <img src="http://placehold.it/800x600&text=<?php the_title() ?>" class="img-responsive">
			    <?php endif; ?>
			    </a>
				<div class="countcomments"><?php iw_post_format_icon() ?> <?php echo(get_comments_number()) ?></div>
				<?php if(function_exists('taqyeem_get_score')) { taqyeem_get_score(); } ?>
			</div>
			
			<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
			<?php get_template_part('part', 'textinfo') ?>
		</div>
		
	<?php elseif( has_post_format('video') ) : ?>
		
		<div class="col-sm-12">
		   	<div class="featimg">
		    	<a href="<?php the_permalink() ?>">
		    	
		    		<?php
		    		if( get_post_meta( get_the_ID(), 'video_service', true ) == 'youtube' ) :
		    			$videoimg = 'http://img.youtube.com/vi/'.get_post_meta( get_the_ID(), 'youtube_video_id', true ).'/maxresdefault.jpg';
					elseif( get_post_meta( get_the_ID(), 'video_service', true ) == 'vimeo' ) :
						$hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/'.get_post_meta( get_the_ID(), 'vimeo_video_id', true ).'.php'));
						$videoimg = $hash[0]['thumbnail_large'];
					endif;
					?>
					
					<img src="<?php echo $videoimg ?>" class="img-responsive img-forced" alt="<?php the_title() ?>">
					<i class="fa fa-youtube-play"></i>
			    </a>
				<div class="countcomments"><?php iw_post_format_icon() ?> <?php echo(get_comments_number()) ?></div>
				<?php if(function_exists('taqyeem_get_score')) { taqyeem_get_score(); } ?>
			</div>
			
			<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
			<?php get_template_part('part', 'textinfo') ?>
		    <?php the_excerpt() ?>
		</div>
		
	<?php elseif( has_post_format('audio') ) : ?>
		
		<div class="col-sm-12">
			
			<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
			<?php get_template_part('part', 'textinfo') ?>
		    <iframe class="soundcloud" src="https://w.soundcloud.com/player/?url=http://soundcloud.com/<?php echo get_post_meta( get_the_ID(), 'soundcloud_track', true ); ?>&amp;color=<?php echo $iw_opt['secondary-color']; ?>&amp;auto_play=false&amp;hide_related=false&amp;show_artwork=true"></iframe>
		    <?php the_excerpt() ?>
		</div>
				
	<?php elseif ( !has_post_thumbnail() ) : ?>
	
	<div class="col-sm-12">
			<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
			<?php get_template_part('part', 'textinfo') ?>
		    <?php the_excerpt() ?>
	</div>

	<?php else: ?>
	
		<div class="col-sm-4">
		   	<div class="featimg">
		    	<a href="<?php the_permalink() ?>">		    	
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
		</div>
		
		<div class="col-sm-8">
			<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
			<?php get_template_part('part', 'textinfo') ?>
		    <?php the_excerpt() ?>
		</div>
	
	<?php endif; ?>
	
</article>

</div>