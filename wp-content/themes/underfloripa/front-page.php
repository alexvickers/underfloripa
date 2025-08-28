<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<?php get_template_part('template-parts/home/top-stories'); ?>

<div class="content-area site-container">
    <main class="main-content" id="site-main">
        <div class="ad">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2855642712528671"
                crossorigin="anonymous"></script>
            <!-- Under Floripa 2025 - Homepage Top -->
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-2855642712528671"
                data-ad-slot="8781032206"
                data-ad-format="auto"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>

        <?php get_template_part('template-parts/home/latest-news'); ?>
        <?php get_template_part('template-parts/home/reviews'); ?>
        <?php get_template_part('template-parts/home/coberturas'); ?>
        <?php get_template_part('template-parts/home/colunas'); ?>

        <div class="ad">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2855642712528671"
                crossorigin="anonymous"></script>
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-format="autorelaxed"
                data-ad-client="ca-pub-2855642712528671"
                data-ad-slot="2638856769"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </main>

    <?php if (is_active_sidebar('primary-sidebar')) : ?>
        <aside class="sidebar">
            <?php dynamic_sidebar('primary-sidebar'); ?>
        </aside>
    <?php endif; ?>
</div>

<?php get_footer();
