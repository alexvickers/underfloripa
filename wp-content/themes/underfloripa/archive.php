<?php get_header(); ?>

<main id="site-content" role="main" class="site-container listing-page <?php echo is_search() ? 'search-results' : 'archive'; ?>">
    <div class="content-with-sidebar">
        <div id="posts-column">
            <header class="listing-header">
                <?php if (function_exists('rank_math_the_breadcrumbs')) : ?>
                    <nav class="breadcrumbs">
                        <?php rank_math_the_breadcrumbs(); ?>
                    </nav>
                <?php endif; ?>

                <?php if (is_search()) : ?>
                    <h1 class="listing-title">
                        <?php printf(
                            esc_html__('Resultados da busca por: %s', 'underfloripa'),
                            '<span>' . get_search_query() . '</span>'
                        ); ?>
                    </h1>
                <?php elseif (is_archive()) : ?>
                    <?php
                    the_archive_title('<h1 class="listing-title">', '</h1>');
                    the_archive_description('<div class="listing-description">', '</div>');
                    ?>
                <?php else : ?>
                    <h1 class="listing-title"><?php esc_html_e('Posts', 'underfloripa'); ?></h1>
                <?php endif; ?>
            </header>

            <div class="listing-posts" id="posts-container">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/content', 'ajax'); ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p><?php esc_html_e('No posts found.', 'underfloripa'); ?></p>
                <?php endif; ?>
            </div><!-- #posts-container -->

            <?php if ($wp_query->max_num_pages > 1) : ?>
                <div id="load-more-spinner" style="height: 80px; visibility: hidden; text-align:center; margin:2rem 0;">
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
