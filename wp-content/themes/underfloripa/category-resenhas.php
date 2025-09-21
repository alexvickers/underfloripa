<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="resenha-archive site-container">
    <div class="site-main">

        <header class="archive-header">
            <?php if (function_exists('rank_math_the_breadcrumbs')) : ?>
                <nav class="breadcrumbs">
                    <?php rank_math_the_breadcrumbs(); ?>
                </nav>
            <?php endif; ?>
            <?php
            the_archive_title('<h1 class="archive-title">', '</h1>');
            the_archive_description('<div class="archive-description">', '</div>');
            ?>
        </header>

        <?php if (have_posts()) : ?>
            <ul class="resenha-list">
                <?php while (have_posts()) : the_post();

                    // Default values
                    $album_name   = '';
                    $artist_name  = '';
                    $record_label = '';
                    $mark         = '';

                    // Parse blocks
                    $blocks = parse_blocks(get_the_content());
                    foreach ($blocks as $block) {
                        if ($block['blockName'] === 'acf/album-review') {
                            $data = $block['attrs']['data'] ?? [];
                            $album_name   = $data['album_name']   ?? '';
                            $artist_name  = $data['artist_name']  ?? '';
                            $record_label = $data['record_label'] ?? '';
                            $mark         = $data['mark']         ?? '';
                            break; // first block only
                        }
                    }

                    // Format mark
                    $formatted_mark = ($mark === '10' || $mark === '0')
                        ? (string) intval($mark)
                        : (is_numeric($mark) ? number_format((float) $mark, 1) : '');

                    // Strip "Resenha:" from title
                    $title = preg_replace('/^Resenha:\s*/i', '', get_the_title());
                ?>

                    <li class="resenha-item">
                        <!-- Album cover -->
                        <div class="resenha-cover">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail('thumbnail', ['alt' => $album_name ?: $title]);
                                } else {
                                    echo '<div class="no-cover">(Sem capa)</div>';
                                } ?>
                            </a>
                        </div>

                        <!-- Content -->
                        <div class="resenha-content">
                            <h3 class="resenha-title">
                                <a href="<?php the_permalink(); ?>"><?php echo esc_html($title); ?></a>
                            </h3>

                            <?php if ($record_label) : ?>
                                <p class="resenha-label"><strong>Gravadora:</strong> <?php echo esc_html($record_label); ?></p>
                            <?php endif; ?>

                            <p class="resenha-meta">
                                Resenhado por <span class="resenha-author"><?php the_author(); ?></span> em <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                            </p>
                        </div>

                        <!-- Mark -->
                        <?php if ($formatted_mark !== '') : ?>
                            <div class="resenha-mark">
                                <div class="mark">
                                    <span><?php echo esc_html($formatted_mark); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </li>

                <?php endwhile; ?>
            </ul>

            <div class="lazy-google-ad responsive-ad"
                data-ad-client="ca-pub-2855642712528671"
                data-ad-slot="9343798014">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2855642712528671"
                    crossorigin="anonymous"></script>
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-format="fluid"
                    data-ad-layout-key="-fu+1w+bi-8x-8m"
                    data-ad-client="ca-pub-2855642712528671"
                    data-ad-slot="9343798014"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>

            <?php the_posts_pagination(); ?>

        <?php else : ?>
            <p>Sem resenhas encontradas.</p>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <aside class="site-sidebar">
        <?php dynamic_sidebar('primary-sidebar'); ?>
    </aside>
</div>

<?php get_footer();
