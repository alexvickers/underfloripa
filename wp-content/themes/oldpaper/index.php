<?php get_header() ?>
	
	<?php
			
		// ottengo il numero di pagina
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
	?>
	
	<?php if($paged==1) : ?>
	<section id="chess" class="container">
		
		<div class="row no-gutter">
			<?php
				
			/*
				
			king article
				
			*/
					
			$args = array(
				'posts_per_page' => 1,
				'ignore_sticky_posts' => 1	
			);
			
			
			if ( isset($iw_opt['catfeatured']) and $iw_opt['catfeatured'] != ''){
				$args['cat'] = -$iw_opt['catfeatured'];
			}

			if ( isset($iw_opt['cateditoriale']) and $iw_opt['cateditoriale'] != ''){
				$args['cat'] = -$iw_opt['cateditoriale'];
			}

			if( isset($iw_opt['catchess']) and $iw_opt['catchess'] != ''){
				$args['cat'] = $iw_opt['catchess'];
			}

			$query = new WP_Query( $args );
							
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
							
			?>
			
			<div class="col-sm-7">
				<article <?php post_class('king')?> id="post-<?php the_id() ?>">
				    
				   <?php get_template_part('loop', 'chess'); ?>
				    		
				</article>
			</div>		
			
			<?php
			
			endwhile; endif;
			
			wp_reset_postdata();
			
			?>
					
			<div class="col-sm-5">
				<div class="row">
						
				<?php
				
				/*
				
				towers articles
				
				*/
						
				$args = array(
					'posts_per_page' => 2,
					'ignore_sticky_posts' => 1,
					'offset' => 1
				);

				if ( isset($iw_opt['catfeatured']) and $iw_opt['catfeatured'] != ''){
				$args['cat'] = -$iw_opt['catfeatured'];
				}

				if ( isset($iw_opt['cateditoriale']) and $iw_opt['cateditoriale'] != ''){
					$args['cat'] = -$iw_opt['cateditoriale'];
				}

				if( isset($iw_opt['catchess']) and $iw_opt['catchess'] != ''){
					$args['cat'] = $iw_opt['catchess'];
				}
						
				$query = new WP_Query( $args );
							
				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
									
				?>
						
					<div class="col-sm-6 col-xs-6">
						<article <?php post_class('tower')?> id="post-<?php the_id() ?>">
						
							<?php get_template_part('loop', 'chess'); ?>
				    			
				    	</article>
					</div>
							
				<?php
				
				endwhile; endif;
							
				wp_reset_postdata();
					    	
				?>
							
				</div>
				<div class="row">
						
				<?php
				
				/*
				
				queen article
				
				*/
						
				$args = array(
					'posts_per_page' => 1,
					'ignore_sticky_posts' => 1,
					'offset' => 3
				);

				if ( isset($iw_opt['catfeatured']) and $iw_opt['catfeatured'] != ''){
				$args['cat'] = -$iw_opt['catfeatured'];
				}

				if ( isset($iw_opt['cateditoriale']) and $iw_opt['cateditoriale'] != ''){
					$args['cat'] = -$iw_opt['cateditoriale'];
				}

				if( isset($iw_opt['catchess']) and $iw_opt['catchess'] != ''){
					$args['cat'] = $iw_opt['catchess'];
				}
						
				$query = new WP_Query( $args );
							
				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
									
				?>
						
					<div class="col-sm-12 col-xs-12">
						<article <?php post_class('queen')?> id="post-<?php the_id() ?>">
				    		
				    		<?php get_template_part('loop', 'chess'); ?>
				    			
				    	</article>
					</div>
							
				<?php
				
				endwhile; endif;
							
				wp_reset_postdata();
					    	
				?>
						
				</div>
			</div> <!-- /col-sm-4 -->
		</div>
		
	</section>
	<?php endif; ?>
	
	<section id="content" class="container">
		<div class="wrapper">
		
			<div class="row">
				<div id="main" class="col-lg-9 col-sm-8">
					
					<?php if($paged==1 and $iw_opt['showfeatured']) : ?>
					<div id="featured" class="wrapper">
					
						<h2><?php echo($iw_opt['titlefeatured']) ?></h2>
						
						<div class="row">
						
						<?php get_template_part('part', 'featured') ?>
						
						</div>
						
					</div>
					<?php endif; ?>
					
					<div id="articlelist">
						<?php
						
							/*
						
							standard article list
						
							*/
							if ( isset($iw_opt['catchess']) and $iw_opt['catchess'] != ''){
								$remove_catchess = -$iw_opt['catchess'];
							}

							if ( $iw_opt['catchess'] == ''){
								$args['offset'] = 4 + ( get_option('posts_per_page') * ($paged-1) );
							}

							if ( isset($iw_opt['catfeatured']) and $iw_opt['catfeatured'] != ''){
								$remove_catfeatured = -$iw_opt['catfeatured'];
							}

							if ( isset($iw_opt['cateditoriale']) and $iw_opt['cateditoriale'] != ''){
								$remove_cateditoriale = -$iw_opt['cateditoriale'];
							}
							
							$args = array(
								'paged' => $paged,
								'ignore_sticky_posts' => 1,
								'posts_per_page' => get_option('posts_per_page'),
								'cat' => $remove_catchess, $remove_catfeatured, $remove_cateditoriale
							);

							
									
							$query = new WP_Query( $args );
										
						if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
							
								get_template_part('loop', 'archive');
							
							endwhile;
						
						?>

						<?php if(function_exists('wp_paginate')) {
						    wp_paginate();
						}
						else {
						?>
						<div class="row">
							<div class="col-xs-6">
								<?php next_posts_link( '<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-long-arrow-left fa-stack-1x fa-inverse"></i>
								</span>', $query->max_num_pages ); ?>
							</div>
							<div class="col-xs-6 text-right">
								<?php previous_posts_link( '<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-long-arrow-right fa-stack-1x fa-inverse"></i>
								</span>' ); ?>
							</div>
						</div>
						<?php } ?>
						
						<?php
								
							wp_reset_postdata();
								
						?>

						<?php else:  ?>
						  <p><?php _e( 'Last articles: You have to make other articles to show here', 'oldpaper' ); ?></p>
						<?php endif; ?>
						
						
					</div>
					
				</div> <!-- ./main -->
			
				<aside class="col-lg-3 col-sm-4">
				
					<?php if($paged==1){ get_template_part('part', 'editorial'); } ?>
					
					<?php get_sidebar() ?>
					
				</aside>	
			</div> <!-- /row featured -->	
		</div>
	</section>
	
<?php get_footer() ?>