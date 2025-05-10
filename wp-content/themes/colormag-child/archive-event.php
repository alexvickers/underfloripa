<?php get_header(); ?>

<main class="events-archive">
	<section class="container">
		<h1 class="archive-title">Upcoming Events</h1>

		<?php
		$today = date('Ymd');

		$args = array(
			'post_type'      => 'event',
			'posts_per_page' => -1,
			'meta_key'       => 'event_date', // Assuming you're using a custom field for the date
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => 'event_date',
					'compare' => '>=',
					'value'   => $today,
				)
			)
		);

		$events = new WP_Query($args);

		if ($events->have_posts()) : ?>
			<ul class="event-list">
				<?php while ($events->have_posts()) : $events->the_post(); ?>
					<li class="event-item">
						<h2 class="event-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="event-meta">
							<strong>Date:</strong> <?php the_field('event_date'); ?><br>
							<strong>Venue:</strong> <?php the_field('venue_name'); ?>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<p>No upcoming events found.</p>
		<?php endif; ?>
	</section>
</main>

<?php get_footer();
