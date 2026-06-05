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

            <div class="lazy-google-ad responsive-ad"
                data-ad-client="ca-pub-2855642712528671"
                data-ad-slot="8848643347">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2855642712528671"
                    crossorigin="anonymous"></script>
                <ins class="adsbygoogle"
                    style="display:block;"
                    data-ad-client="ca-pub-2855642712528671"
                    data-ad-slot="8848643347"
                    data-ad-format="auto"
                    data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>

            <h1 class="archive-title">Resenhas</h1>
            <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
        </header>

        <div id="posts-container" class="archive-posts">
            <?php
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $args = [
                'post_type'      => 'post',
                'category_name'  => 'resenhas',
                'posts_per_page' => 11,
                'paged'          => $paged,
            ];
            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    get_template_part('template-parts/content', 'resenha');
                endwhile;
            else :
                echo '<p>Nenhuma resenha encontrada.</p>';
            endif;
            wp_reset_postdata();
            ?>
        </div><!-- #posts-container -->

        <?php if ($query->max_num_pages > 1) : ?>
            <div id="load-more-spinner">
                <div class="lds-spinner">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <aside class="sidebar">
        <?php dynamic_sidebar('primary-sidebar'); ?>
    </aside>
</div>

<?php get_footer();
