<?php get_header() ?>
	
	<section id="content" class="container">
		<div class="wrapper">
		
			<header class="topinfo sun-row">
				<h1><?php printf( __( 'Search for: %s', 'oldpaper' ), get_search_query() ); ?></h1>
			</header>
		
			<div class="row">
			<div id="main" class="col-sm-9">
				
				<div id="articlelist">
					<?php 
					
					if ( have_posts() ) : while ( have_posts() ) : the_post();
					
						get_template_part('loop', 'archive');
					
					endwhile; 
					
					?>
				
				</div>
				
				<div class="row">
					<div class="col-xs-6">
						<?php next_posts_link( '<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-long-arrow-left fa-stack-1x fa-inverse"></i>
						</span>' ); ?>
					</div>
					<div class="col-xs-6 text-right">
						<?php previous_posts_link( '<span class="fa-stack fa-lg">
						  <i class="fa fa-circle fa-stack-2x"></i>
						  <i class="fa fa-long-arrow-right fa-stack-1x fa-inverse"></i>
						</span>' ); ?>
					</div>
				</div>
				
					<?php
					
					else: 
						
						_e("<p>We are terrible sorry but the content that you are searching for isn't here!</p><p>Please, came back to the home page and try to navigate in the site or, if you prefer, try with the search form.</p><p>Thank you!</p>", 'oldpaper');
					
					endif;
					
					wp_reset_postdata();
					
					?>
			
			</div>
			
			<aside class="col-sm-3">
				
				<?php get_sidebar() ?>
				
			</aside>	
		</div> <!-- /row featured -->
			
		</div>
	</section>
	
<?php get_footer() ?>
