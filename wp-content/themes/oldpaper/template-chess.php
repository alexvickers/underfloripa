<?php

/*

Template name: Chess Layout

*/

?>

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
					'offset' => 1,
				);
						
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
					'offset' => 3,
				);
						
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
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
			<?php if( !get_post_meta( get_the_ID(), 'page_header', true ) ) : ?>
			
				<?php if( has_post_thumbnail() ) : ?>
					<div class="featimg animated" data-anim="fadeInDown">
						<?php
						$size = ($iw_opt['cropped']) ? 'slide' : 'full';
						the_post_thumbnail($size, array('class' => 'img-responsive center-block')); 
						?>
					</div>
				<?php endif; ?>
				
				<header class="topinfo animated" data-anim="bounceIn">
					<h1><?php the_title() ?></h1>
					<?php get_template_part('part', 'textinfo') ?>
				</header>
			
			<?php endif; ?>
			
			<div class="row">
				<div id="main" class="col-sm-<?php echo ( !get_post_meta( get_the_ID(), 'page_sidebar', true ) ) ? '9' : '12' ; ?>">
				
					<article <?php post_class() ?> id="post-<?php the_id() ?>">
						
						<div class="textcontent">
							<?php the_content() ?>
						</div>
						
				    </article>
				    
				    <?php
						
						if( comments_open() and $iw_opt['page-comments'] ){
							comments_template(); 
						}
						
					?> 
									
				</div>
			
			<aside class="col-lg-3 col-sm-4">
				
					<?php if($paged==1){ get_template_part('part', 'editorial'); } ?>
					
					<?php get_sidebar() ?>
					
			</aside>
			
			</div> <!-- /row -->
		
		<?php endwhile; endif; ?>
		
		</div> <!-- /wrapper -->
	</section>
	
<?php get_footer() ?>