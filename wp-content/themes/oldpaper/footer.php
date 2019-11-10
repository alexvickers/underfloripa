<?php global $iw_opt ?>
	
	<?php if( $iw_opt['showbreakingnews'] ) : ?>
	
	<section id="breakingnews" class="container">
	
	<?php
		
		$args = array(
			'posts_per_page'	=> $iw_opt['countbreakingnews'],
			'post_type'			=> 'breakingnews'	
		);
						
		$query = new WP_Query( $args );
								
		if ( $query->have_posts() ) : 
		
	?>
	
		<ul>
	
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<li <?php ?>>
				<div class="cat"><?php echo get_post_meta( get_the_ID(), 'spot_category', true ) ?></div>
				<div class="text">
					<?php if( get_post_meta( get_the_ID(), 'spot_link', true ) ): ?>
						<a target="_blank" href="<?php echo get_post_meta( get_the_ID(), 'spot_link', true ) ?>"><?php the_title() ?> <i class="fa fa-long-arrow-right"></i></a>
					<?php else: ?>
						<?php the_title() ?>
					<?php endif; ?>
				</div>
			</li>
			
	<?php endwhile; ?>
	
		</ul>
	
	<?php
	
		endif;
			
	wp_reset_postdata();
			
	?>
	
	</section>
	
	<?php endif; ?>
	
	<footer class="animate" data-anim="fadeIn">
		<div class="container">
			<div class="wrapper">
				<div class="row">
					
					<div class="col-sm-6">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer first half') ) : ?>
						<div class="widget">
							<h4><span><?php _e('Footer first half', 'oldpaper') ?></span></h4>
							<p><?php _e('Use the Admin widget page to populate the sidebar.', 'oldpaper') ?></p>
						</div>					
					<?php endif; ?>
					</div>
					
					<div class="col-sm-6">
						<div class="row">
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer second half') ) : ?>
								<div class="widget col-sm-6">
									<h4><span><?php _e('Footer second half', 'oldpaper') ?></span></h4>
									<p><?php _e('Use the Admin widget page to populate the sidebar.', 'oldpaper') ?></p>
								</div>
							<?php endif; ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</footer>
	
	<div id="subfooter">
		<div class="container">
			<p class="text-center"><?php echo($iw_opt['footer-text']) ?></p>
		</div>
	</div>
	
	<?php if( $iw_opt['boxed'] ) : ?></div> <!-- #boxed --><?php endif; ?>
		
    <?php wp_footer(); ?>

</body>
</html>
