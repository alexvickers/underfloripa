<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

$event_id = get_the_ID();
$event_date   = get_field('event_date', $event_id);
$doors_time   = get_field('doors_time', $event_id);
$event_link   = get_permalink($event_id);
$tour         = get_field('tour', $event_id);
$lineup       = get_field('lineup', $event_id);
$opening_acts = get_field('opening_acts', $event_id);
$ticket_link  = get_field('ticket_link', $event_id);

$venue = get_field('venue_post', $event_id);
$venue_name = $venue_address = $venue_city = '';

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

<article id="post-<?php the_ID(); ?>" <?php post_class('archive-post'); ?> itemscope itemtype="https://schema.org/Event">
    <div class="event-thumbnail">
        <a href="<?php echo esc_url($event_link); ?>" itemprop="url">
            <?php if (has_post_thumbnail()) :
                the_post_thumbnail('large', [
                    'alt' => get_the_title(),
                    'itemprop' => 'image'
                ]);
            else : ?>
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/placeholder-poster.png'); ?>" alt="Concert Poster Placeholder" itemprop="image">
            <?php endif; ?>
        </a>
    </div>

    <div class="event-details">
        <header class="entry-header">
            <h3 itemprop="name">
                <a href="<?php echo esc_url($event_link); ?>"><?php the_title(); ?><?php if ($tour) echo ' - ' . esc_html($tour); ?></a>
            </h3>
            <?php if ($venue_city) : ?>
                <h4 itemprop="location" itemscope itemtype="https://schema.org/Place">
                    <span itemprop="addressLocality"><?php echo esc_html($venue_city); ?></span>
                </h4>
            <?php endif; ?>
        </header>

        <div class="entry-meta">
            <?php if ($lineup) : ?><span><strong>Com:</strong> <?php echo esc_html($lineup); ?></span><br><?php endif; ?>
            <?php if ($opening_acts) : ?><span><strong>Abertura:</strong> <?php echo esc_html($opening_acts); ?></span><br><?php endif; ?>
            <?php if ($formatted_date) : ?>
                <span>
                    <strong>Data:</strong>
                    <time datetime="<?php echo esc_attr($event_date); ?>" itemprop="startDate">
                        <?php echo esc_html($formatted_date); ?>
                    </time>
                </span><br>
            <?php endif; ?>
            <?php if ($doors_time) : ?><span><strong>Portas:</strong> <?php echo esc_html($doors_time); ?></span><br><?php endif; ?>
            <?php if ($venue_name || $venue_address || $venue_city) : ?>
                <span itemprop="location" itemscope itemtype="https://schema.org/Place">
                    <strong>Local:</strong>
                    <span itemprop="name"><?php echo esc_html($venue_name); ?></span>
                    <?php if ($venue_address) : ?> - <span itemprop="address"><?php echo esc_html($venue_address); ?></span><?php endif; ?>
                    <?php if ($venue_city) : ?> - <span itemprop="addressLocality"><?php echo esc_html($venue_city); ?></span><?php endif; ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="event-buttons">
            <?php if ($event_link) : ?>
                <a class="button" href="<?php echo esc_url($event_link); ?>"><?php esc_html_e('Leia Mais', 'underfloripa'); ?></a>
            <?php endif; ?>
            <?php if ($ticket_link) : ?>
                <a class="button" href="<?php echo esc_url($ticket_link); ?>" target="_blank" rel="noopener"><?php esc_html_e('Ingressos', 'underfloripa'); ?></a>
            <?php endif; ?>
        </div>
    </div>
</article>
