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

$formatted_mark = ($mark == 10) ? '10' : number_format((float) $mark, 1);
?>

<style>
    .album-review-block {
        display: flex;
        margin-top: 22px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.24);
        padding-bottom: 12px;
        margin-bottom: 22px;
    }
    @media screen and (max-width: 768px) {
        .album-review-block {
            display: block;
            text-align: center;

        }
    }

    .album-review-block .mark {
        margin-right: 24px;
    }

    @media screen and (max-width: 768px) {
        .album-review-block .mark {
            margin-bottom: 12px;
        }
    }

    .album-review-block .mark span {
        display: inline-flex;
        font-weight: bold;
        font-size: 32px;
        line-height: 32px;
        border: 5px solid #000000;
        border-radius: 50%;
        padding: 10px;
        text-align: center;
        width: 44px;
        height: 44px;
        align-items: center;
        justify-content: center;
        letter-spacing: -2px;
    }

    .album-review-block p {
        margin-bottom: 4px;
    }

    .album-review-block h3 {
        margin-bottom: 6px;
        font-size: 22px;
        font-weight: bold;
        text-transform: uppercase;
    }
</style>

<div class="album-review-block">
    <div class="mark"><span><?php echo $formatted_mark; ?></span></div>
    <div>
        <h3><?php echo esc_html($album_name) . ' - ' . esc_html($artist_name); ?></h3>
        <p><strong>Gravadora:</strong> <?php echo esc_html($record_label); ?></p>
        <p class="description"><?php echo esc_html($description); ?></p>
    </div>
</div>