<?php
$event = get_field('event_post');

if ($event):
    $event_id = $event->ID;

    $event_name = get_the_title($event_id);
    $event_date = get_field('event_date', $event_id);
    $city = get_field('city', $event_id);
    $doors_time = get_field('doors_time', $event_id);
    $min_age = get_field('min_age', $event_id);
    $ticket_link = get_field('ticket_link', $event_id);
    $permalink = get_permalink($event_id);
    $venue = get_field('venue_post', $event_id);

    if ($venue) {
        $venue_name = get_the_title($venue->ID);
        $venue_address = get_field('venue_address', $venue->ID);
        $venue_city = get_field('venue_city', $venue->ID);
    }
?>

<div class="event-details">
    <h3><a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($event_name); ?></a></h3>
    <ul>
        <li><strong>Data:</strong> <?php echo esc_html($event_date); ?></li>
        <li><strong>Local:</strong> <?php echo esc_html($venue_name); ?></li>
        <li><strong>Endereço:</strong> <?php echo esc_html($venue_address); ?>, <?php echo esc_html($venue_city); ?></li>
        <li><strong>Abertura das Portas:</strong> <?php echo esc_html($doors_time); ?></li>
        <li><strong>Idade Mínima:</strong> <?php echo esc_html($min_age); ?>+</li>
        <?php if ($ticket_link): ?>
            <li><a href="<?php echo esc_url($ticket_link); ?>" target="_blank" rel="noopener">Buy Tickets</a></li>
        <?php endif; ?>
    </ul>
</div>

<?php endif;
