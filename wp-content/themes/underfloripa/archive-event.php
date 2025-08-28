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
            <div id="load-more-spinner" style="height: 80px; visibility: hidden; text-align:center; margin:2rem 0;">
                <div class="lds-spinner">
                    <div></div><div></div><div></div><div></div>
                    <div></div><div></div><div></div><div></div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <aside class="sidebar">
        <?php dynamic_sidebar('primary-sidebar'); ?>
    </aside>
</div>

<?php get_footer();
