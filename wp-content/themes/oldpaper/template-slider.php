<?php

/*

Template name: Home page with slider

*/

?>

<?php get_header() ?>
	
	<?php
			
		// ottengo il numero di pagina
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
	?>
	
	<?php if($paged==1) : ?>
	<section id="slider" class="container">
	
		<div id="carousel-generic" class="carousel slide" data-ride="carousel">
		
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<?php for($i=0; $i<get_post_meta( get_the_ID(), 'post_count', true ); $i++) { ?>
					<li data-target="#carousel-generic" data-slide-to="<?php echo $i ?>" <?php if($i==0): ?>class="active"<?php endif; ?>></li>
				<?php } ?>
			</ol>
			
			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				
				<?php
				
				// slider articles
				
				$start = 1;
						
				$args = array(
					'posts_per_page' => get_post_meta( get_the_ID(), 'post_count', true ),
					'ignore_sticky_posts' => 1,
					'cat' => get_post_meta( get_the_ID(), 'slider_category', true ),

				);
						
				$query = new WP_Query( $args );
								
				if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
								
				?>
				
				<div class="item <?php if($start){ echo 'active'; $start = 0; } ?>">
					<a href="<?php the_permalink()?>">
					<?php if( has_post_thumbnail() ) :
						the_post_thumbnail('slider'); 
					else : ?>
						<img src="http://placehold.it/1160x480&text=<?php the_title() ?>">
					<?php endif; ?>
					</a>
					
					<div class="carousel-caption">
						<h2><a href="<?php the_permalink()?>"><?php the_title() ?></a></h2>
						<?php get_template_part('part', 'textinfo'); ?>
					</div>
				</div>
				
				<?php
				
				endwhile; endif;
				
				wp_reset_postdata();
				
				?>
				
			</div>
			
			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-generic" data-slide="prev">
				<i class="fa fa-long-arrow-left"></i>
			</a>
			
			<a class="right carousel-control" href="#carousel-generic" data-slide="next">
				<i class="fa fa-long-arrow-right"></i>
			</a>
		
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
							
							$args = array(
								'paged' => $paged,
								'ignore_sticky_posts' => 1,
								'posts_per_page' => get_option('posts_per_page'),
								'cat' => -get_post_meta( get_the_ID(), 'slider_category', true ),
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
