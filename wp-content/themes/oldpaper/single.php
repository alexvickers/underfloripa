<?php get_header() ?>
	
	<section id="content" class="container single-article">						
		<div class="wrapper">
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
			<?php if( $iw_opt['single-featured-content'] != '1' ) : ?>

				<?php if( has_post_format('video') ) : ?>
				
					<div class="featvideo animated" data-anim="fadeInDown">
					
						<?php if( get_post_meta( get_the_ID(), 'video_service', true ) == 'youtube' ) : ?> 
						
							<iframe src="//www.youtube.com/embed/<?php echo get_post_meta( get_the_ID(), 'youtube_video_id', true ) ?>" frameborder="0" allowfullscreen></iframe>
						<?php elseif( get_post_meta( get_the_ID(), 'video_service', true ) == 'vimeo' ) : ?>
							
							<iframe src="//player.vimeo.com/video/<?php echo get_post_meta( get_the_ID(), 'vimeo_video_id', true ) ?>?color=<?php echo $iw_opt['secondary-color']; ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
						
						<?php else: echo('error video auto screenshot'); endif; ?>
						
					</div>
				
				<?php elseif( has_post_thumbnail() ) : ?>
				
					<div class="featimg animated" data-anim="fadeInDown">
							<?php
								$size = ($iw_opt['cropped']) ? 'slider' : 'full';
								the_post_thumbnail($size, array('class' => 'img-responsive center-block')); 
							?>
					</div>
				
				<?php endif; ?>
				
				<?php if( has_post_format('audio') ) : ?>
					<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http://soundcloud.com/<?php echo get_post_meta( get_the_ID(), 'soundcloud_track', true ); ?>&amp;color=<?php echo $iw_opt['secondary-color']; ?>&amp;auto_play=false&amp;hide_related=false&amp;show_artwork=true"></iframe>
				<?php endif; ?>

				<header class="topinfo animated" data-anim="bounceIn">
					<h1><?php the_title() ?></h1>
					<?php get_template_part('part', 'textinfo') ?>
				</header>

			<?php endif; ?>
			
			<div class="row">
				<div id="main" class="<?php 

					if( $iw_opt['single-sidebar'] == '1' ){ echo('col-sm-9'); 
					}
					else{ echo('col-md-12');
					}?>">
					
					<!-- article -->
					<article <?php post_class() ?> id="post-<?php the_id() ?>">
						
						<!-- if single-featured-content != 0 -->
						<?php if( $iw_opt['single-featured-content'] != '0' ) : ?>

							<?php if( has_post_format('video') ) : ?>
							
								<div class="featvideo animated" data-anim="fadeInDown">
								
									<?php if( get_post_meta( get_the_ID(), 'video_service', true ) == 'youtube' ) : ?> 
									
										<iframe src="//www.youtube.com/embed/<?php echo get_post_meta( get_the_ID(), 'youtube_video_id', true ) ?>" frameborder="0" allowfullscreen></iframe>
									<?php elseif( get_post_meta( get_the_ID(), 'video_service', true ) == 'vimeo' ) : ?>
										
										<iframe src="//player.vimeo.com/video/<?php echo get_post_meta( get_the_ID(), 'vimeo_video_id', true ) ?>?color=<?php echo $iw_opt['secondary-color']; ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
									
									<?php else: echo('error video auto screenshot'); endif; ?>
									
								</div>
							
							<?php elseif( has_post_thumbnail() ) : ?>
							
								<div class="featimg animated" data-anim="fadeInDown">
										<?php
											$size = ($iw_opt['cropped']) ? 'slider' : 'full';
											the_post_thumbnail($size, array('class' => 'img-responsive center-block')); 
										?>
								</div>
							
							<?php endif; ?>
							
							<?php if( has_post_format('audio') ) : ?>
							<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http://soundcloud.com/<?php echo get_post_meta( get_the_ID(), 'soundcloud_track', true ); ?>&amp;color=<?php echo $iw_opt['secondary-color']; ?>&amp;auto_play=false&amp;hide_related=false&amp;show_artwork=true"></iframe>
							<?php endif; ?>

							<header class="topinfo  animated" data-anim="bounceIn">
								<h1 class="entry-title"><?php the_title() ?></h1>
								<?php get_template_part('part', 'textinfo') ?>
							</header>

						<?php endif; ?>
						<!-- END (if single-featured-content != 0) -->
						
						<?php if( has_post_format('quote') ) : ?>
						
						 	<blockquote>
						 		<p><?php echo get_post_meta( get_the_ID(), 'quote_text', true ); ?></p>
						 		<footer><?php iw_post_format_icon() ?> <cite title="<?php echo get_post_meta( get_the_ID(), 'quote_author', true ); ?>"><?php echo get_post_meta( get_the_ID(), 'quote_author', true ); ?></cite></footer>
							</blockquote>
						
						<?php else : ?>
						
								<div class="textcontent clearfix entry-content"><?php the_content(); ?></div>
						
						<?php endif; ?>
						
						<hr>
						
						<?php
						$args = array(
							'before'           => '<div class="articlepage"><i class="fa fa-puzzle-piece fa-fw"></i> ' . __( 'Pages:', 'oldpaper' ),
							'after'            => '</div><hr>',
							'separator'        => ' '
						);
						 
						wp_link_pages( $args );
						?>
						
						<?php if( is_single() and has_tag() and $iw_opt['single-taglist']) : ?>
						<div class="tagslist">
							<?php the_tags('<p><i class="fa fa-tags fa-fw"></i> <span>Tagged:</span> ', ', ', '</p>') ?>
						</div>
						<hr>
						<?php endif; ?>
						
				    	<?php if ( is_single() and $iw_opt['single-authorarea'] ) : ?>
				    	
				    		<div class="authorarea">
						        <div class="row">
						            <div class="col-sm-2 col-xs-12">
						                <?php echo get_avatar( get_the_author_meta( 'user_email' ), 100 ); ?>
						            </div>
						
						            <div class="authorinfo col-md-10 col-sm-10 col-xs-12">
						                <div class="h3 author vcard"><?php _e('About', 'oldpaper') ?> <?php the_author_posts_link() ?></div>
						                <p><?php the_author_meta( 'description' ); ?></p>
						                
						                <ul class="social-links list-inline">
						                	<?php if ( get_the_author_meta( 'url' ) != '' )  { ?>
											<li>
												<a class="url-link" href="<?php echo esc_url( get_the_author_meta( 'user_url' ) ); ?>">
												<i class="fa fa-globe"></i>
												</a>
											</li>
											<?php } ?>
											        
											<?php if ( get_the_author_meta( 'twitter' ) != '' )  { ?>
											<li>
												<a class="twitter-link" href="https://twitter.com/<?php echo wp_kses( get_the_author_meta( 'twitter' ), null ); ?>">    
											    <i class="fa fa-twitter"></i>
												</a>
											</li>
											<?php } ?>
											 
											<?php if ( get_the_author_meta( 'facebook' ) != '' )  { ?>
											<li>
												<a class="facebook-link" href="<?php echo esc_url( get_the_author_meta( 'facebook' ) ); ?>">
												<i class="fa fa-facebook"></i>
												</a>
											</li>
											<?php } ?>
											 
											<?php if ( get_the_author_meta( 'linkedin' ) != '' )  { ?>
											<li>
												<a class="linkedin-link" href="<?php echo esc_url( get_the_author_meta( 'linkedin' ) ); ?>">
											    <i class="fa fa-linkedin"></i>
												</a>
											</li>
											<?php } ?>
											
											<?php if ( get_the_author_meta( 'googleplus' ) != '' )  { ?>
											<li>
												<a class="google-link" href="<?php echo esc_url( get_the_author_meta( 'googleplus' ) ); ?>">
												<i class="fa fa-google-plus"></i>
												</a>
											</li>
											<?php } ?>
										</ul>	    
											    
						            </div>
						        </div>
						    </div>
						    <hr>
				    	
				    	<?php endif; ?>
						
				    </article>
				    
				    <?php if( $iw_opt['single-relatedposts'] ) : ?>
				    <!-- related posts -->
				    <div class="relatedposts">
				    	<h3><?php _e('You may also like...', 'oldpaper') ?></h3>
				    	
				    	<div class="row">
				    	
				    	
				    	
				    	
				    	<?php
				    	
				    	$categories = get_the_category( $post->ID );
						$first_cat = $categories[0]->cat_ID;
						
						$args = array(
							'category__in' => array( $first_cat ),
							'post__not_in' => array( $post->ID ),
							'posts_per_page' => 3,
                            'orderby' => 'rand'
						);
						
						$related_posts = get_posts( $args );
						if( $related_posts ) {
							
							$my_query = new WP_Query($args);
							
							if( $my_query->have_posts() ) : 
								while ($my_query->have_posts()) : $my_query->the_post(); 
						
						?>
							
							<article <?php post_class('related col-md-4')?>>
							
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
								<h4 class="text-center"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
								<p class="text-center">
									<time datetime="<?php the_time('Y-m-d'); ?>">
									<a href="<?php echo get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>">
									<?php echo get_the_date() ?>
									</a>
									</time>
								</p>
								
						    </article>
							
						<?php
							
								endwhile; 
							else:
						?>
							<div class="col-sm-12">
								<p><?php _e('No related posts found...', 'oldpaper'); ?></p>
							</div>
							
						<?php
							
							endif;
							
						wp_reset_query();
						
						}
						
						?>
						
				    	</div>
				    	
				    	<hr>
				    </div>
				    <?php endif; ?>
				    
				    <!-- comments -->
				    <?php
						
						if( comments_open() ){
							comments_template(); 
						}
						
					?>
								
				</div>
				
				<?php if( $iw_opt['single-sidebar'] ) : ?>
				<aside class="col-sm-3">
					
					<?php get_sidebar() ?>
					
				</aside>
				<?php endif; ?>

		
			</div> <!-- /row -->
			
		<?php endwhile; endif; ?>
			
		</div> <!-- /wrapper -->
	</section>
	
<?php get_footer() ?>
