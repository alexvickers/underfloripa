<?php get_header(); ?>

<main id="site-content" role="main" class="site-container archive">
    <div class="content-with-sidebar">
        <div id="posts-column">
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

            <div class="archive-posts" id="posts-container">

                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/content', 'ajax'); ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p><?php esc_html_e('No posts found.', 'underfloripa'); ?></p>
                <?php endif; ?>

            </div><!-- #posts-container -->

            <?php if ($wp_query->max_num_pages > 1) : ?>
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
