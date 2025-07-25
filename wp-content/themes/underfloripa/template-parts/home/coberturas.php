<section class="home-section coverages">
	<h2>Coberturas</h2>

	<?php
	$coberturas = new WP_Query([
		'post_type'      => 'post',
		'posts_per_page' => 6,
		'category_name'  => 'coberturas',
	]);

	if ($coberturas->have_posts()) : ?>
		<div class="coverage-grid">
			<?php while ($coberturas->have_posts()) : $coberturas->the_post(); ?>
				<article class="coverage-item">
					<?php if (has_post_thumbnail()) : ?>
						<div class="post-image">
							<?php the_post_thumbnail('medium'); ?>
						</div>
					<?php endif; ?>

					<div class="post-meta">
						<div class="post-categories">
							<?php the_category(' '); ?>
						</div>
						<h3 class="post-title"><?php the_title(); ?></h3>
						<div class="post-info">
							<span class="post-date"><?php echo get_the_date(); ?></span> – <span class="post-author"><?php the_author(); ?></span>
						</div>
						<div class="post-excerpt">
							<?php the_excerpt(); ?>
						</div>
						<a href="<?php the_permalink(); ?>" class="read-more">Leia mais →</a>
					</div>
				</article>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>
	<?php else : ?>
		<p>Nenhuma cobertura encontrada.</p>
	<?php endif; ?>
	<?php echo get_category_link(get_category_by_slug('coberturas')->term_id); ?>
</section>
