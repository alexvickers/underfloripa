<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}

get_header(); ?>

<div class="cm-row">
	<?php do_action('colormag_before_body_content'); ?>

	<div id="cm-primary" class="cm-primary">
		<div id="posts-container" class="cm-posts <?php echo esc_attr('cm-' . $grid_layout . ' ' . $style . ' ' . $col); ?>">

			<header class="page-header">
				<h1><?php the_archive_title(); ?></h1>
				<div class="archive-description"><?php the_archive_description(); ?></div>
			</header>

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

			if ($events->have_posts()) {
				while ($events->have_posts()) {
					$events->the_post();
					$event_id = get_the_ID();

					$event_date   = get_field('event_date', $event_id);
					$doors_time   = get_field('doors_time', $event_id);
					$event_link	  = get_permalink($event_id);
					$ticket_link  = get_field('ticket_link', $event_id);
					$tour         = get_field('tour', $event_id);
					$lineup		  = get_field('lineup', $event_id);
					$opening_acts = get_field('opening_acts', $event_id);
					$venue        = get_field('venue_post', $event_id);

					$venue_name = $venue_city = $venue_address = '';

					if ($venue) {
						$venue_name    = get_the_title($venue->ID);
						$venue_address = get_field('venue_address', $venue->ID);

						$venue_city_value = get_field('venue_city', $venue->ID);
						if ($venue_city_value) {
							if (is_array($venue_city_value) && isset($venue_city_value['name'])) {
								$venue_city = $venue_city_value['name'];
							} elseif (is_object($venue_city_value) && isset($venue_city_value->name)) {
								$venue_city = $venue_city_value->name;
							} elseif (is_numeric($venue_city_value)) {
								$term = get_term($venue_city_value);
								if (!is_wp_error($term) && $term) {
									$venue_city = $term->name;
								}
							}
						}
					}

					$formatted_date = $event_date ? date_i18n('d/m', strtotime($event_date)) : '';
			?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('cm-post'); ?>>
						<div class="event-thumbnail">
							<a href="<?php echo esc_url($event_link); ?>">
								<?php if (has_post_thumbnail()) {
									the_post_thumbnail('medium');
								} else { ?>
									<img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/placeholder-poster.png'); ?>" alt="Concert Poster Placeholder">
								<?php } ?>
							</a>
						</div>

						<div class="event-details cm-post-content">
							<header class="entry-header">
								<h3 class="cm-entry-title">
									<a href="<?php echo esc_url($event_link); ?>">
										<?php the_title(); ?>
										<?php if (!empty($tour)) {
											echo ' - ' . esc_html($tour);
										} ?>
									</a>
								</h3>
								<?php if (!empty($venue_city)) { ?>
									<h4><?php echo esc_html($venue_city); ?></h4>
								<?php } ?>
							</header>

							<div class="entry-meta">
								<?php if (!empty($lineup)) { ?>
									<span class="posted-on"><strong>Com:</strong> <?php echo esc_html($lineup); ?></span><br />
								<?php } ?>

								<?php if (!empty($opening_acts)) { ?>
									<span class="posted-on"><strong>Abertura com:</strong> <?php echo esc_html($opening_acts); ?></span><br />
								<?php } ?>

								<?php if ($formatted_date) { ?>
									<span class="posted-on"><strong>Data:</strong> <?php echo esc_html($formatted_date); ?></span><br />
								<?php } ?>

								<?php if ($doors_time) { ?>
									<span class="posted-on"><strong>Abertura das Portas:</strong> <?php echo esc_html($doors_time); ?></span><br />
								<?php } ?>

								<?php if ($venue_name || $venue_address || $venue_city) { ?>
									<span class="event-venue">
										<strong>Local:</strong>
										<?php
										$parts = array_filter([
											esc_html($venue_name),
											esc_html($venue_address),
											esc_html($venue_city)
										]);
										echo implode(' - ', $parts);
										?>
									</span>
								<?php } ?>
							</div>

							<div class="event-buttons">
								<?php if ($event_link) { ?>
									<a class="cm-entry-button" title="<?php the_title_attribute(); ?>" href="<?php echo esc_url($event_link); ?>">
										<span><?php esc_html_e('Leia Mais', 'colormag'); ?></span>
									</a>
								<?php } ?>

								<?php if ($ticket_link) { ?>
									<a class="cm-entry-button" title="<?php the_title_attribute(); ?>" href="<?php echo esc_url($ticket_link); ?>">
										<span><?php esc_html_e('Ingressos', 'colormag'); ?></span>
									</a>
								<?php } ?>
							</div>
						</div>
					</article>

				<?php }
				wp_reset_postdata();
			} else { ?>
				<p><?php esc_html_e('No upcoming events found.', 'colormag-child'); ?></p>
			<?php } ?>
		</div><!-- #posts-container -->

		<div id="load-more-spinner" style="display:none; text-align:center; padding:1em;">
			<span class="spinner"></span>
		</div>
	</div><!-- #cm-primary -->

	<?php get_sidebar(); ?>
</div><!-- .cm-row -->

<?php get_footer();
