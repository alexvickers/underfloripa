<?php get_header() ?>
	
	<section id="content" class="container">						
		<div class="wrapper">
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
			<?php if( !get_post_meta( get_the_ID(), 'page_header', true ) ) : ?>
			
				<?php if( has_post_thumbnail() ) : ?>
					<div class="featimg animated" data-anim="fadeInDown">
						<?php
						$size = ($iw_opt['cropped']) ? 'slider' : 'full';
						the_post_thumbnail($size, array('class' => 'img-responsive center-block')); 
						?>
					</div>
				<?php endif; ?>
				
				<header class="topinfo animated" data-anim="bounceIn">
					<h1 class="entry-title"><?php the_title() ?></h1>
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
			
			<?php if( !get_post_meta( get_the_ID(), 'page_sidebar', true ) ) : ?>
				<aside class="col-sm-3">
					
					<?php get_sidebar(); ?>
					
				</aside>
			<?php endif; ?>
			
			</div> <!-- /row -->
		
		<?php endwhile; endif; ?>
		
		</div> <!-- /wrapper -->
	</section>
	
<?php get_footer() ?>
