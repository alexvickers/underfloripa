<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

$media_type = get_field('media_type');
$album_name = get_field('album_name');
$artist_name = get_field('artist_name');
$record_label = get_field('record_label');
$mark = get_field('mark');
$description = get_field('description');

if (!$album_name) {
    echo '<p>Missing album name.</p>';
    return;
}

$media_icon = match ($media_type) {
    'Movie' => '🎬',
    'Book' => '📖',
    default => '🎵',
};

if (is_admin()) {
    echo '<p><strong>' . esc_html($media_icon . ' ' . $media_type . ' Review') . '</strong></p>';
}

$label_title = match ($media_type) {
    'Movie' => 'Estúdio',
    'Book' => 'Editora',
    default => 'Gravadora',
};

$formatted_mark = ($mark == 10 || $mark == 0) ? (string) intval($mark) : number_format((float) $mark, 1);
$class_suffix = is_string($media_type) ? strtolower($media_type) : 'unknown';
?>

<div class="album-review-block <?= esc_attr($class_suffix) ?>">
    <div class="mark"><span><?php echo $formatted_mark; ?></span></div>
    <div>
        <h3>
            <?php echo esc_html($album_name);
            if (!empty($artist_name)) { ?>
                - <?php echo esc_html($artist_name);
            } ?>
        </h3>
        <p><strong><?php echo esc_html($label_title); ?>:</strong> <?php echo esc_html($record_label); ?></p>
        <p class="description"><?php echo esc_html($description); ?></p>
    </div>
</div>
