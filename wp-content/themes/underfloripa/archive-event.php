<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="site-container events">

    <main>
        <div id="posts-container">

            <header class="page-header">
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

                <h1><?php the_archive_title(); ?></h1>
                <div class="archive-description"><?php the_archive_description(); ?></div>
            </header>

            <?php
            $today = date('Ymd');
            $args = [
                'post_type'      => 'event',
                'post_status'    => 'publish',
                'paged'          => get_query_var('paged') ?: 1,
                'posts_per_page' => 11,
                'meta_key'       => 'event_date',
                'orderby'        => 'meta_value',
                'order'          => 'ASC',
                'meta_query'     => [
                    [
                        'key'     => 'event_date',
                        'compare' => '>=',
                        'value'   => $today,
                    ]
                ]
            ];

            $events = new WP_Query($args);

            if ($events->have_posts()) :
                while ($events->have_posts()) :
                    $events->the_post();
                    get_template_part('template-parts/content', 'event');
                endwhile;
                wp_reset_postdata();
            else : ?>
                <p><?php esc_html_e('No upcoming events found.', 'underfloripa'); ?></p>
            <?php endif; ?>
        </div><!-- #posts-container -->

        <?php if ($events->max_num_pages > 1) : ?>
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
    </main>

    <aside class="sidebar">
        <?php dynamic_sidebar('primary-sidebar'); ?>
    </aside>
</div>

<?php get_footer();
