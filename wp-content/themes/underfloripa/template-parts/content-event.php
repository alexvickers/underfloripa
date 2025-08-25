<article id="post-<?php the_ID(); ?>" <?php post_class('archive-post'); ?>>
    <div class="event-thumbnail">
        <a href="<?php the_permalink(); ?>">
            <?php
            if (has_post_thumbnail()) {
                the_post_thumbnail('medium_large');
            } else {
                echo '<img src="' . esc_url(get_stylesheet_directory_uri() . '/assets/img/placeholder-poster.png') . '" alt="Concert Poster Placeholder">';
            }
            ?>
        </a>
    </div>

    <div class="event-details">
        <header class="entry-header">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php if ($venue_city) : ?>
                <h4><?php echo esc_html($venue_city); ?></h4>
            <?php endif; ?>
        </header>

        <div class="entry-meta">
            <?php if ($lineup) : ?><span><strong>Com:</strong> <?php echo esc_html($lineup); ?></span><br><?php endif; ?>
            <?php if ($opening_acts) : ?><span><strong>Abertura:</strong> <?php echo esc_html($opening_acts); ?></span><br><?php endif; ?>
            <?php if ($formatted_date) : ?><span><strong>Data:</strong> <?php echo esc_html($formatted_date); ?></span><br><?php endif; ?>
            <?php if ($doors_time) : ?><span><strong>Portas:</strong> <?php echo esc_html($doors_time); ?></span><br><?php endif; ?>
            <?php if ($venue_name || $venue_address || $venue_city) : ?>
                <span><strong>Local:</strong> <?php echo esc_html(implode(' - ', array_filter([$venue_name, $venue_address, $venue_city]))); ?></span>
            <?php endif; ?>
        </div>

        <div class="event-buttons">
            <?php if ($event_link) : ?>
                <a class="button" href="<?php echo esc_url($event_link); ?>">Leia Mais</a>
            <?php endif; ?>
            <?php if ($ticket_link) : ?>
                <a class="button" href="<?php echo esc_url($ticket_link); ?>">Ingressos</a>
            <?php endif; ?>
        </div>
    </div>
</article>
