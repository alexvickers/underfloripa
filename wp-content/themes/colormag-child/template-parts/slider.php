<section class="homepage-slider">
	<div class="swiper" id="homepageSwiper">
		<div class="swiper-wrapper">
			<?php
			$slider_query = new WP_Query([
				'posts_per_page' => 6,
				'post_status'    => 'publish',
			]);
			if ($slider_query->have_posts()) :
				while ($slider_query->have_posts()) :
					$slider_query->the_post();
					$category = get_the_category();
			?>
					<div class="swiper-slide">
						<div class="slider-featured-image">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('large'); ?>
							</a>
						</div>
						<div class="slider-post-content">
							<?php if (!empty($category)) : ?>
								<span class="slider-category">
									<a href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>">
										<?php echo esc_html($category[0]->name); ?>
									</a>
								</span>
							<?php endif; ?>
							<span class="slider-date">
								<?php echo get_the_date(); ?>
							</span>
							<h2 class="slider-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
						</div>
					</div>
			<?php endwhile;
				wp_reset_postdata();
			endif; ?>
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>
