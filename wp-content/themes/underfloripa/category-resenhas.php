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

        <div id="posts-container">
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
                    <div></div><div></div><div></div><div></div>
                    <div></div><div></div><div></div><div></div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <aside class="site-sidebar">
        <?php dynamic_sidebar('primary-sidebar'); ?>
    </aside>
</div>

<?php get_footer();
