<?php
$top_stories = new WP_Query([
	'post_type'      => 'post',
	'posts_per_page' => 4,
	'meta_query'     => [
		[
			'key'     => 'top_story',
			'value'   => 1,
			'compare' => '='
		]
	]
]);

if ($top_stories->have_posts()) : ?>
	<section class="top-stories">
		<div class="site-container">
			<h2>Destaques</h2>
			<div class="top-stories-grid">
				<?php while ($top_stories->have_posts()) : $top_stories->the_post(); ?>
					<article class="top-story">
						<div class="post-categories">
							<?php the_category(' '); ?>
						</div>
						<a href="<?php the_permalink(); ?>">
							<div class="top-story-img">
								<?php the_post_thumbnail('medium_large', [
									'alt'           => get_the_title(),
									'fetchpriority' => 'high',
									'loading'       => 'eager',
									'decoding'      => 'async',
								]); ?> </div>
							<span class="top-story-date"><?php echo get_the_date(); ?></span>
							<h3 class="top-story-title"><?php the_title(); ?></h3>
						</a>
					</article>
				<?php endwhile; ?>
			</div>
		</div>
	</section>
<?php endif;
wp_reset_postdata();
