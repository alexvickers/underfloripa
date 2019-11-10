<?php get_header() ?>
	
	<section id="content" class="container">
		<div class="wrapper">
		
			<header class="topinfo sun-row">
				<h1><?php
				if ( is_day() ) :
					printf( __( 'Daily Archives: %s', 'oldpaper' ), get_the_date() );
				elseif ( is_month() ) :
					printf( __( 'Monthly Archives: %s', 'oldpaper' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'oldpaper' ) ) );
				elseif ( is_year() ) :
					printf( __( 'Yearly Archives: %s', 'oldpaper' ), get_the_date( _x( 'Y', 'yearly archives date format', 'oldpaper' ) ) );
				elseif ( is_author() ) :
					printf( __( 'Articles by %s', 'oldpaper' ), get_the_author_meta('display_name') );
				elseif ( is_tag() ) :
					printf( __( 'Tagged %s', 'oldpaper' ), single_tag_title('', false) );
				else :
					printf( __( '%s', 'oldpaper' ), single_cat_title('', false) );
				endif;
				?></h1>
				
				<?php if( is_category() ) : ?>
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2 text-center">
						<?php echo category_description() ?>
					</div>
				</div>
				<?php endif; ?>
			
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
