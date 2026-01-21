<?php
if (! defined('ABSPATH')) {
    exit;
}

$album_name   = get_field('album_name');
$artist_name  = get_field('artist_name');
$record_label = get_field('record_label');
$mark         = get_field('mark');
$description  = get_field('description');

$formatted_mark = ($mark === null || $mark === '')
    ? ''
    : (($mark == 10 || $mark == 0)
        ? (string) $mark
        : number_format((float) $mark, 1));
?>

<div <?php echo get_block_wrapper_attributes(['class' => 'album-review-block']); ?>>
    <?php if ($formatted_mark !== '') : ?>
        <div class="mark">
            <span><?php echo esc_html($formatted_mark); ?></span>
        </div>
    <?php endif; ?>
    <div>
        <h3>
            <?php
            echo esc_html($album_name);
            if (!empty($artist_name)) {
                echo ' - ' . esc_html($artist_name);
            }
            ?>
        </h3>
        <p><strong>Gravadora:</strong> <?php echo esc_html($record_label); ?></p>
        <p class="description"><?php echo esc_html($description); ?></p>
    </div>
</div>
