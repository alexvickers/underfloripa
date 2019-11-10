<?php global $iw_opt; ?>
	
			<?php if($iw_opt['showeditorale']) : ?>
			
				<div class="wrapper animated" data-anim="fadeInRight">
				
				<?php if( isset($iw_opt['cateditoriale']) and $iw_opt['cateditoriale'] != '' ) : ?>
				
					<?php
							
					$args = array(
						'posts_per_page' => 1,
						'cat' => $iw_opt['cateditoriale']
					);
							
					$query = new WP_Query( $args );
									
					if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
									
					?>
					
					<article <?php post_class() ?> id="editorial-post-<?php the_id() ?>">
					
						<h3 class="text-center"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
						
						<p class="author"><?php the_author_posts_link() ?></p>
						
						<p class="text-center"><time datetime="<?php the_time('Y-m-d'); ?>"><?php echo get_the_date() ?></time></p>
						
						<?php if( has_post_thumbnail() ) : ?>
					    	<p><a href="<?php the_permalink() ?>">
					    	<?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
					    	</a></p>
					    <?php endif; ?>
					    
					    <div class="textcontent"><?php the_content( ) ?></div>
			
			    	</article>
			
					<?php
					
					endwhile; endif;
					
					wp_reset_postdata();
					
					?>
					
				<?php else:
				
					_e('Please, select the category for the Editorial from the Options Panel. Thank you!', 'oldpaper');
				
				endif; ?>
				
				</div>
			
			<?php endif; ?>