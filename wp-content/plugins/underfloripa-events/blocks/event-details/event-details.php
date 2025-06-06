<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

setlocale(LC_TIME, 'pt_BR.UTF-8');

$events = get_query_var('selected_event_ids', []);

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
    <h3 style="font-weight: 500; text-decoration: underline;">
        <?php echo $is_multiple ? 'Serviços' : 'Serviço'; ?>:
    </h3>

    <?php foreach ($events as $event_id) {
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
                    'December' => 'dezembro'
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
        $lineup = get_post_meta($event_id, 'lineup', true);
        $opening_acts = get_post_meta($event_id, 'opening_acts', true);
        $tour = get_post_meta($event_id, 'tour', true);

        $venue = get_field('venue_post', $event_id);
        $venue_name = $venue_address = $venue_city = '';

        if ($venue) {
            $venue_name = get_the_title($venue->ID);
            $venue_address = get_field('venue_address', $venue->ID);
            $venue_city = '';
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
    ?>
        <div class="event-details__item">
            <ul>
                <li>
                    <h3 style="font-weight: 700;">
                        <?php echo esc_html($event_name); ?>
                        <?php if (!empty($tour)) {
                            echo ' - ' . esc_html($tour);
                        } ?>
                    </h3>
                    <h6><?php echo esc_html($venue_city); ?></h6>
                </li>

                <?php if (!empty($lineup)) { ?>
                    <span class="posted-on"><strong>Com:</strong> <?php echo esc_html($lineup); ?></span><br />
                <?php } ?>


                <?php if (!empty($opening_acts)) { ?>
                    <li><strong>Abertura com:</strong> <?php echo esc_html($opening_acts); ?></li>
                <?php } ?>

                <li><strong>Data:</strong> <?php echo esc_html($event_date); ?></li>
                <li><strong>Local:</strong> <?php echo esc_html($venue_name); ?></li>
                <li><strong>Endereço:</strong> <?php echo esc_html($venue_address); ?>, <?php echo esc_html($venue_city); ?></li>
                <li><strong>Abertura das Portas:</strong> <?php echo esc_html($doors_time); ?></li>
                <li><strong>Censura:</strong> <?php echo esc_html($min_age); ?></li>

                <?php if (!empty($tickets_link)) { ?>
                    <li>
                        <a href="<?php echo esc_url($tickets_link); ?>" target="_blank" rel="noopener">
                            Garanta seu Ingresso
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
</div>
