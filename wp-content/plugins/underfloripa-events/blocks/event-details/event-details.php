<?php
setlocale(LC_TIME, 'pt_BR.UTF-8');
$events = get_field('selected_event');

if (empty($events)) {
    echo '<p>No event selected.</p>';
    return;
}

usort($events, function ($a, $b) {
    $date_a = strtotime(get_post_meta($a, 'event_date', true));
    $date_b = strtotime(get_post_meta($b, 'event_date', true));
    return $date_a - $date_b;
});

$is_multiple = count($events) > 1;
?>

<div class="event-details">
    <h3><?php echo $is_multiple ? 'Serviços' : 'Serviço'; ?></h3>

    <?php foreach ($events as $event_id): ?>
        <?php
        $event_name = get_the_title($event_id);

        $event_date_raw = get_post_meta($event_id, 'event_date', true);

        $event_date = '';
        if ($event_date_raw) {
            $event_date_obj = DateTime::createFromFormat('Ymd', $event_date_raw);

            if ($event_date_obj) {
                $month_names = [
                    'January' => 'janeiro',
                    'February' => 'fevereiro',
                    'March' => 'março',
                    'April' => 'abril',
                    'May' => 'maio',
                    'June' => 'junho',
                    'July' => 'julho',
                    'August' => 'agosto',
                    'September' => 'setembro',
                    'October' => 'outubro',
                    'November' => 'novembro',
                    'December' => 'dezembro',
                ];

                $day = $event_date_obj->format('j');
                $month_en = $event_date_obj->format('F');
                $month_pt = $month_names[$month_en] ?? strtolower($month_en);
                $year = $event_date_obj->format('Y');

                $event_date = "{$day} de {$month_pt}, {$year}";
            }
        }
        $doors_time_raw = get_post_meta($event_id, 'doors_time', true);
        $doors_time = $doors_time_raw ? date('H\hi', strtotime($doors_time_raw)) : 'Horário desconhecido';
        $min_age = get_post_meta($event_id, 'min_age', true);
        $tickets_link = get_post_meta($event_id, 'ticket_link', true);

        $venue = get_field('venue_post', $event_id);

        $venue_name = '';
        $venue_address = '';
        $venue_city = '';

        if ($venue) {
            $venue_name = get_the_title($venue->ID);
            $venue_address = get_field('venue_address', $venue->ID);
            $venue_city = get_field('venue_city', $venue->ID);
        }
        ?>
        <div class="event-details__item">
            <ul>
                <li><strong><?php echo esc_html($event_name); ?></strong></li>
                <li><strong>Data:</strong> <?php echo esc_html($event_date); ?></li>
                <li><strong>Local:</strong> <?php echo esc_html($venue_name); ?></li>
                <li><strong>Endereço:</strong> <?php echo esc_html($venue_address); ?>, <?php echo esc_html($venue_city); ?></li>
                <li><strong>Abertura das Portas:</strong> <?php echo esc_html($doors_time); ?></li>
                <li><strong>Censura:</strong> <?php echo esc_html($min_age); ?></li>
                <?php if ($tickets_link): ?>
                    <li><a href="<?php echo esc_url($tickets_link); ?>" target="_blank" rel="noopener">Garanta seu Ingresso</a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>
