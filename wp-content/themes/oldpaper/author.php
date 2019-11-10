<?php get_header() ?>
	
	<section id="content" class="container">
		<div class="wrapper">
			
			 
			<?php /* <pre>
			<?php
			
			 
			$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
			
			print_r( $curauth );
			
			echo( $curauth-> ID );
						
			?>
			</pre> */ ?>
			
						
			<header class="topinfo sun-row">
				<h1><?php printf( __( 'Articles by %s', 'oldpaper' ), get_the_author_meta('display_name') ); ?></h1>
			</header>
			
			<div class="row">
				<div class="col-sm-2 col-sm-offset-2"><?php echo get_avatar( get_the_author_meta('ID'), 160 ); ?></div>
				<div class="col-sm-6">
					<p><?php echo get_the_author_meta('description'); ?></p>
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
			
			<hr>
		
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
