<?php
$album_name = get_field('album_name');
$artist_name = get_field('artist_name');
$record_label = get_field('record_label');
$mark = get_field('mark');
$description = get_field('description');

if (!$album_name || !$artist_name) {
    echo '<p>Missing album details.</p>';
    return;
}

$formatted_mark = ($mark == 10 || $mark == 0) ? (string) intval($mark) : number_format((float) $mark, 1);
?>

<div class="album-review-block">
    <div class="mark"><span><?php echo $formatted_mark; ?></span></div>
    <div>
        <h3><?php echo esc_html($album_name) . ' - ' . esc_html($artist_name); ?></h3>
        <p><strong>Gravadora:</strong> <?php echo esc_html($record_label); ?></p>
        <p class="description"><?php echo esc_html($description); ?></p>
    </div>
</div>
