<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}
?>

<section class="home-section coverages">
	<div class="title">
		<h2>Coberturas</h2>
		<a href="<?php echo get_category_link(get_category_by_slug('coberturas')->term_id); ?>" class="button">Ver todas as coberturas</a>
	</div>

	<?php
	$coberturas = new WP_Query([
		'post_type'      => 'post',
		'posts_per_page' => 4,
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
						<a href="<?php the_permalink(); ?>">
							<h3 class="post-title">
								<?php the_title(); ?>
							</h3>
						</a>
						<div class="post-info">
							<span class="post-date"><?php echo get_the_date(); ?></span> – <span class="post-author"><?php the_author(); ?></span>
						</div>
						<div class="post-excerpt">
							<a href="<?php the_permalink(); ?>">
								<?php the_excerpt(); ?>
							</a>
						</div>
					</div>
				</article>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>
	<?php else : ?>
		<p>Nenhuma cobertura encontrada.</p>
	<?php endif; ?>
</section>

<div class="homepage-ad">
	<img src="https://placehold.co/768x90" />
</div>
