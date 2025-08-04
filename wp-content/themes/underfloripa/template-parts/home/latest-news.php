<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}
?>

<section class="home-section latest-news">
	<div class="title">
		<h2>Últimas Notícias</h2>
		<a href="<?php echo get_post_type_archive_link('post'); ?>?filter=news" class="see-all-link">Ver todas as notícias</a>
	</div>

	<?php
	$latest_news = new WP_Query([
		'post_type'      => 'post',
		'posts_per_page' => 7,
	]);

	if ($latest_news->have_posts()) :
		$post_count = 0;
		while ($latest_news->have_posts()) : $latest_news->the_post();
			if ($post_count === 0) :
	?>

				<article class="latest-news-featured">
					<div class="post-meta">
						<div class="post-categories">
							<?php the_category(' '); ?>
						</div>
						<h3 class="post-title"><?php the_title(); ?></h3>
						<div class="post-info">
							<span class="post-date"><?php echo get_the_date(); ?></span> –
							<span class="post-author"><?php the_author(); ?></span>
						</div>
						<div class="post-excerpt">
							<?php the_excerpt(); ?>
						</div>
						<a href="<?php the_permalink(); ?>" class="read-more">Leia mais →</a>
					</div>

					<?php if (has_post_thumbnail()) : ?>
						<div class="post-image">
							<?php the_post_thumbnail('large'); ?>
						</div>
					<?php endif; ?>
				</article>

				<div class="latest-news-grid">
				<?php
			else:
				?>
					<article class="latest-news-item">
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
								<span class="post-date"><?php echo get_the_date(); ?></span> –
								<span class="post-author"><?php the_author(); ?></span>
							</div>
							<div class="post-excerpt">
								<?php the_excerpt(); ?>
							</div>
							<a href="<?php the_permalink(); ?>" class="read-more">Leia mais →</a>
						</div>
					</article>
			<?php
			endif;
			$post_count++;
		endwhile;
		wp_reset_postdata();
			?>
				</div><!-- .latest-news-grid -->

			<?php else: ?>
				<p>Nenhuma notícia encontrada.</p>
			<?php endif; ?>
</section>

<div class="homepage-ad">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2855642712528671"
		crossorigin="anonymous"></script>
	<!-- Underfloripa - Homepage -->
	<ins class="adsbygoogle"
		style="display:block"
		data-ad-client="ca-pub-2855642712528671"
		data-ad-slot="8781032206"
		data-ad-format="auto"
		data-full-width-responsive="true"></ins>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
</div>
