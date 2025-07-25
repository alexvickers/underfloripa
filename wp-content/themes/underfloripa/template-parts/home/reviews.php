<section class="home-section review-grid">
	<h2>Resenhas</h2>

	<?php
	$reviews = new WP_Query([
		'post_type'      => 'post',
		'posts_per_page' => 6,
		'category_name'  => 'resenhas',
	]);

	if ($reviews->have_posts()) : ?>
		<div class="review-cards">
			<?php while ($reviews->have_posts()) : $reviews->the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="review-card">
					<?php if (has_post_thumbnail()) : ?>
						<div class="review-image">
							<?php the_post_thumbnail([280, 280], ['style' => 'width: 100%; height: auto; object-fit: cover;']); ?>
						</div>
					<?php endif; ?>

					<div class="review-meta">
						<h3 class="review-title">
							<?php echo preg_replace('/^Resenha:\s*/i', '', get_the_title()); ?>
						</h3>
						<p class="review-info">
							<?php echo get_the_author(); ?> – <?php echo get_the_date(); ?>
						</p>
					</div>
				</a>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>
	<?php else : ?>
		<p>Nenhuma resenha encontrada.</p>
	<?php endif; ?>
	<?php echo get_category_link(get_category_by_slug('resenhas')->term_id); ?>
</section>
