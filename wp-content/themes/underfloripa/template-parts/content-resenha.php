<?php
$blocks = parse_blocks(get_the_content());
$album_review_data = null;

foreach ($blocks as $block) {
    if ($block['blockName'] === 'acf/album-review') {
        $album_review_data = $block['attrs']['data'] ?? [];
        break;
    }
}

$album_name   = $album_review_data['album_name'] ?? '';
$artist_name  = $album_review_data['artist_name'] ?? '';
$record_label = $album_review_data['record_label'] ?? '';
$mark         = $album_review_data['mark'] ?? '';
$formatted_mark = ($mark === '10' || $mark === '0') ? (string) intval($mark) : (is_numeric($mark) ? number_format((float) $mark, 1) : '');

// Strip "Resenha:" from title
$title = preg_replace('/^Resenha:\s*/i', '', get_the_title());
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('archive-post'); ?>>
    <div class="resenha-cover">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) {
                the_post_thumbnail('thumbnail', ['alt' => $album_name ?: $title]);
            } else {
                echo '<div class="no-cover">(Sem capa)</div>';
            } ?>
        </a>
    </div>

    <div class="resenha-content">
        <h3 class="resenha-title">
            <a href="<?php the_permalink(); ?>"><?php echo esc_html($title); ?></a>
        </h3>
        <?php if ($record_label) : ?>
            <p class="resenha-label"><?php echo esc_html($record_label); ?></p>
        <?php endif; ?>
        <p class="resenha-meta">
            <span class="resenha-author"><?php the_author(); ?></span> ·
            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
        </p>
    </div>

    <?php if ($formatted_mark !== '') : ?>
        <div class="resenha-mark">
            <div class="mark">
                <span><?php echo esc_html($formatted_mark); ?></span>
            </div>
        </div>
    <?php endif; ?>
</article>
