<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}
?>

<div class="lazy-google-ad responsive-ad"
	data-ad-client="ca-pub-2855642712528671"
	data-ad-slot="1234567890">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2855642712528671"
		crossorigin="anonymous"></script>
	<!-- Under Floripa 2025 - Colunas -->
	<ins class="adsbygoogle"
		style="display:block"
		data-ad-client="ca-pub-2855642712528671"
		data-ad-slot="8767918142"
		data-ad-format="auto"
		data-full-width-responsive="true"></ins>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
</div>

<section class="home-section colunas-grid">
	<div class="title">
		<h2>Colunas</h2>
		<a href="<?php echo get_category_link(get_category_by_slug('colunas')->term_id); ?>" class="button">Ver todas as colunas</a>
	</div>

	<?php
	$colunas = new WP_Query([
		'post_type'      => 'post',
		'posts_per_page' => 6,
		'category_name'  => 'colunas',
	]);

	if ($colunas->have_posts()) : ?>
		<div class="colunas-cards">
			<?php while ($colunas->have_posts()) : $colunas->the_post();
				$categories = get_the_category();
				$category_classes = '';
				if (! empty($categories)) {
					foreach ($categories as $cat) {
						$category_classes .= ' category-' . esc_attr($cat->slug);
					}
				}
			?>
				<div class="coluna-card<?php echo $category_classes; ?>">
					<div class="post-categories">
						<?php the_category(' '); ?>
					</div>
					<a href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail()) :
							$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large', ['alt' => get_the_title()]);
						endif; ?>

						<div class="coluna-bg" style="background-image: url('<?php echo esc_url($thumb_url); ?>');">
							<div class="coluna-content">
								<h3 class="post-title"><?php the_title(); ?></h3>
								<div class="post-info">
									<?php the_author(); ?> – <?php the_date(); ?>
								</div>
							</div>
						</div>
					</a>
				</div>
			<?php endwhile;

			wp_reset_postdata(); ?>
		</div>
	<?php else : ?>
		<p>Nenhuma coluna encontrada.</p>
	<?php endif; ?>
</section>