<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/* Template Name: Notícias */
get_header(); ?>

<main id="site-content" role="main" class="site-container archive">
    <div class="content-with-sidebar">
        <div id="posts-column">
            <header class="archive-header">
                <?php if (function_exists('rank_math_the_breadcrumbs')) : ?>
                    <nav class="breadcrumbs">
                        <?php rank_math_the_breadcrumbs(); ?>
                    </nav>
                <?php endif; ?>

                <h1 class="archive-title">Notícias</h1>
            </header>

            <div class="archive-posts" id="posts-container">
                <?php
                // Categories to exclude
                $excluded = ['resenhas', 'colunas', 'coberturas'];
                $excluded_ids = array_map(function ($slug) {
                    $cat = get_category_by_slug($slug);
                    return $cat ? $cat->term_id : 0;
                }, $excluded);

                // Initial query
                $args = [
                    'post_type' => 'post',
                    'posts_per_page' => 10,
                    'paged' => get_query_var('paged') ?: 1,
                    'category__not_in' => $excluded_ids,
                ];

                $noticias_query = new WP_Query($args);

                if ($noticias_query->have_posts()) :
                    while ($noticias_query->have_posts()) : $noticias_query->the_post();
                        get_template_part('template-parts/content', 'ajax');
                    endwhile;
                else :
                    echo '<p>' . esc_html__('No posts found.', 'underfloripa') . '</p>';
                endif;

                wp_reset_postdata();
                ?>
            </div><!-- #posts-container -->

            <?php if ($noticias_query->max_num_pages > 1) : ?>
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
    </div>

    <aside class="sidebar">
        <?php dynamic_sidebar('primary-sidebar'); ?>
    </aside>
    </div><!-- .content-with-sidebar -->

</main>

<?php get_footer();
