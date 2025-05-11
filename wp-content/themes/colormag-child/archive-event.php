<?php get_header(); ?>

<div class="cm-row">
	<?php

	/**
	 * Hook: colormag_before_body_content.
	 */
	do_action('colormag_before_body_content');
	?>

	<div id="cm-primary" class="cm-primary">

		<div id="posts-container" class="cm-posts <?php echo esc_attr('cm-' . $grid_layout . ' ' . $style . ' ' . $col); ?>">

			<?php if (have_posts()) : ?>
				<header class="page-header">
					<h1 class="page-title"><?php _e('Agenda de Shows', 'colormag-child'); ?></h1>
				</header><!-- .page-header -->

				<?php
				$today = date('Ymd');
				$args = array(
					'post_type'      => 'event',
					'post_status'    => 'publish',
					'paged'          => $paged,
					'posts_per_page' => 11,
					'meta_key'       => 'event_date',
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

				if ($events->have_posts()) :
					while ($events->have_posts()) : $events->the_post();
						$event_date  = get_field('event_date');
						$venue = get_field('venue_post', $event_id);
						$event_link  = get_field('link');
						$ticket_link = get_field('ticket_link');
						$event_date = get_field('event_date', $event_id);
						$doors_time = get_field('doors_time', $event_id);
						$tour = get_field('tour', $event_id);

						if ($venue) {
							$venue_name = get_the_title($venue->ID);
							$venue_city = get_field('venue_city', $venue->ID);
							$venue_address = get_field('venue_address', $venue->ID);
						}

						$formatted_date = date_i18n('d/m', strtotime($event_date));
				?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('cm-post'); ?>>
							<?php if (has_post_thumbnail()): ?>
								<div class="event-thumbnail" style="float: left; margin-right: 20px;">
									<a href="<?php echo esc_url($event_link); ?>">
										<?php the_post_thumbnail('medium'); ?>
									</a>
								</div>
							<?php endif; ?>

							<div class="event-details cm-post-content">
								<header class="entry-header">
									<h3 class="cm-entry-title">
										<a href="<?php echo esc_url($event_link); ?>">
											<?php the_title(); ?>
											<?php if(!$tour) { ?>
												- <?php echo esc_html($tour); ?>
											<?php } ?>
										</a>
									</h3>
								</header>

								<div class="entry-meta">
									<?php if ($event_date): ?>
										<span class="posted-on"><strong>Data:</strong> <?php echo esc_html($formatted_date); ?></span><br>
										<span class="posted-on"><strong>Abertura das Portas:</strong> <?php echo esc_html($doors_time); ?></span><br>
									<?php endif; ?>
									<?php if (!empty($venue_name) || !empty($venue_city)) : ?>
										<span class="event-venue"><strong>Local:</strong> <?php echo esc_html($venue_name); ?> - <?php echo esc_html($venue_address); ?> - <?php echo esc_html($venue_city); ?></span>
									<?php endif; ?>
								</div>
								<div class="event-buttons">
									<?php if ($event_link): ?>
										<a class="cm-entry-button" title="<?php the_title_attribute(); ?>" href="<?php echo esc_url($event_link); ?>">
											<span><?php echo esc_html__('Leia Mais', 'colormag'); ?></span>
										</a>
									<?php endif; ?>

									<?php if ($ticket_link): ?>
										<a class="cm-entry-button" title="<?php the_title_attribute(); ?>" href="<?php echo esc_url($ticket_link); ?>">
											<span><?php esc_html_e('Ingressos', 'colormag'); ?></span>
										</a>
									<?php endif; ?>
								</div>

							</div>
						</article>

					<?php endwhile;
					wp_reset_postdata();
				else : ?>
					<p><?php _e('No upcoming events found.', 'colormag-child'); ?></p>
				<?php endif; ?>

			<?php else : ?>
				<p><?php _e('No events found.', 'colormag-child'); ?></p>
			<?php endif; ?>

		</div><!-- #content -->

		<div id="load-more-spinner" style="display:none; text-align:center; padding:1em;">
			<span class="spinner"></span>
		</div>

	</div><!-- #primary -->

	<?php get_sidebar(); ?>
</div><!-- #main -->

<?php get_footer();
