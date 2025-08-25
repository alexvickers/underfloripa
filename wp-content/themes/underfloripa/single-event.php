<?php
get_header();
?>

<div class="site-container event-single">

	<?php while (have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="featured-image">
				<?php if (has_post_thumbnail()) : ?>
					<?php the_post_thumbnail('large'); ?>
				<?php else : ?>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/placeholder-poster.png" alt="Placeholder image" />
				<?php endif; ?>
			</div>

			<div class="event-content">
				<header class="entry-header">
					<h1 class="entry-title">
						<?php
						the_title();
						$venue = get_field('venue_post');
						if ($venue) {
							$venue_name = get_the_title($venue);
							echo ' - ' . esc_html($venue_name);

							$city_terms = get_the_terms($venue, 'venue_city');

							if (!is_wp_error($city_terms) && !empty($city_terms)) {
								$city = $city_terms[0];
								echo ', ' . esc_html($city->name);
							}
						}
						?>
					</h1>
					<?php if (get_post_status() === 'past_event') : ?>
						<div class="notice notice-warning">Este evento já aconteceu.</div>
					<?php endif; ?>
				</header>

				<div class="entry-content">
					<?php
					$related_post = get_field('link');
					if ($related_post instanceof WP_Post) {
						setup_postdata($related_post);
					?>
						<div class="related-excerpt">
							<?php $content = get_the_content(null, false, $related_post);
							$h2 = 'Detalhes do Evento';

							$lines = preg_split('/\r\n|\r|\n/', $content);
							$second_line = isset($lines[1]) ? trim($lines[1]) : '';

							if (preg_match('/<h2[^>]*>(.*?)<\/h2>/is', $second_line, $matches)) {
								$h2 = wp_strip_all_tags($matches[1]);
							}
							?>

							<h2><?php echo esc_html($h2); ?></h2>
							<p><?php echo get_the_excerpt($related_post); ?></p>
							<p><a href="<?php echo get_permalink($related_post); ?>">Leia mais</a></p>
						</div>
					<?php
						wp_reset_postdata();
					}

					if (function_exists('underfloripa_render_event_details_block')) {
						underfloripa_render_event_details_block([get_the_ID()]);
					}
					?>
				</div>

			</div>
		</article>
	<?php endwhile; ?>

	<aside class="sidebar">
		<?php dynamic_sidebar('primary-sidebar'); ?>
	</aside>
</div>

<?php get_footer();
