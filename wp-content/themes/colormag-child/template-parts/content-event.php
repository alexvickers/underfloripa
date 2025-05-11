<?php
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
    <div class="event-thumbnail">
        <a href="<?php echo esc_url($event_link); ?>">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('medium'); ?>
            <?php else: ?>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/placeholder-poster.png" alt="Concert Poster Placeholder">
            <?php endif; ?>
        </a>
    </div>

    <div class="event-details cm-post-content">
        <header class="entry-header">
            <h3 class="cm-entry-title">
                <a href="<?php echo esc_url($event_link); ?>">
                    <?php the_title(); ?>
                    <?php if (!empty($tour)) { ?>
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