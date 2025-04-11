<?php
/* Template Name: Custom Home Page for Underfloripa */
get_header();
?>

<main id="main-content">
    <!-- Hero Carousel -->
    <section class="hero-carousel">
        <?php
        $carousel_ids = [];

        $recent_posts = new WP_Query([
            'posts_per_page' => 5,
            'post_status' => 'publish',
        ]);

        if ($recent_posts->have_posts()) :
        ?>
            <div class="carousel-wrapper">
                <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                    <?php $carousel_ids[] = get_the_ID();
                    ?>

                    <div class="carousel-slide">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="carousel-img"><?php the_post_thumbnail('full'); ?></div>
                            <?php endif; ?>
                            <div class="carousel-caption">
                                <div class="meta">
                                    <span class="category">
                                        <?php
                                        $category = get_the_category();
                                        if ($category) :
                                        ?>
                                            <a href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>">
                                                <?php echo esc_html($category[0]->name); ?>
                                            </a>
                                        <?php endif; ?>
                                    </span>
                                    <span class="date">
                                        <span class="dashicons dashicons-calendar-alt"></span>
                                        <?php echo get_the_date(); ?>
                                    </span> <span class="author">by <?php the_author(); ?></span>
                                </div>
                                <h2><?php the_title(); ?></h2>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif;
        wp_reset_postdata(); ?>
    </section>

    <!-- Main Content + Sidebar -->
    <section class="content-with-sidebar container">
        <div class="content-area">
            <h2>Featured Posts</h2>
            <?php
            $featured_posts = new WP_Query([
                'posts_per_page' => 5,
                'post_status' => 'publish',
                'category_name' => 'musica,literatura,cinema,tv',
                'post__not_in' => $carousel_ids,
            ]);
            if ($featured_posts->have_posts()) :
                while ($featured_posts->have_posts()) : $featured_posts->the_post(); ?>
                    <article class="post-card">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="thumb">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="content">
                                <?php
                                $category = get_the_category();
                                if ($category) :
                                ?>
                                    <span class="category-label">
                                        <a href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>">
                                            <?php echo esc_html($category[0]->name); ?>
                                        </a>
                                    </span>
                                <?php endif; ?>
                                <h3><?php the_title(); ?></h3>
                                <p class="meta">
                                    <span class="date">
                                        <span class="dashicons dashicons-calendar-alt"></span>
                                        <?php echo get_the_date(); ?>
                                    </span> <span class="author">por <?php the_author(); ?></span>
                                </p>
                                <p class="excerpt"><?php the_excerpt(); ?></p>
                            </div>
                        </a>
                    </article>
            <?php endwhile;
            endif;
            wp_reset_postdata();
            ?>

            <!-- Resenhas Block -->
            <h2>Resenhas</h2>
            <?php
            $resenhas_posts = new WP_Query([
                'posts_per_page' => 4,
                'post_status' => 'publish',
                'category_name' => 'resenhas',
            ]);
            if ($resenhas_posts->have_posts()) :
                while ($resenhas_posts->have_posts()) : $resenhas_posts->the_post(); ?>
                    <article class="post-card">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="thumb">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="content">
                                <h3><?php the_title(); ?></h3>
                                <p class="meta">
                                    <span class="date">
                                        <span class="dashicons dashicons-calendar-alt"></span>
                                        <?php echo get_the_date(); ?>
                                    </span> <span class="author">por <?php the_author(); ?></span>
                                </p>
                                <p class="excerpt"><?php the_excerpt(); ?></p>
                            </div>
                        </a>
                    </article>
            <?php endwhile;
            endif;
            wp_reset_postdata();
            ?>

            <!-- Coberturas Block -->
            <h2>Coberturas</h2>
            <?php
            $coberturas_posts = new WP_Query([
                'posts_per_page' => 4,
                'post_status' => 'publish',
                'category_name' => 'coberturas',
            ]);
            if ($coberturas_posts->have_posts()) :
                while ($coberturas_posts->have_posts()) : $coberturas_posts->the_post(); ?>
                    <article class="post-card">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="thumb">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="content">
                                <h3><?php the_title(); ?></h3>
                                <p class="meta">
                                    <span class="date">
                                        <span class="dashicons dashicons-calendar-alt"></span>
                                        <?php echo get_the_date(); ?>
                                    </span> <span class="author">por <?php the_author(); ?></span>
                                </p>
                                <p class="excerpt"><?php the_excerpt(); ?></p>
                            </div>
                        </a>
                    </article>
            <?php endwhile;
            endif;
            wp_reset_postdata();
            ?>

            <h2>Colunas</h2>
            <div class="colunas-wrapper">
                <?php
                $colunas_posts = new WP_Query([
                    'posts_per_page' => 2,
                    'post_status' => 'publish',
                    'category_name' => 'colunas',
                ]);
                if ($colunas_posts->have_posts()) :
                    while ($colunas_posts->have_posts()) : $colunas_posts->the_post(); ?>
                        <article class="coluna-card">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="coluna-thumb">
                                        <?php the_post_thumbnail('large'); ?>
                                        <div class="coluna-overlay">
                                            <h3><?php the_title(); ?></h3>
                                            <p class="meta">
                                                <span class="date">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#fff" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 4px;">
                                                        <path d="M3 0a1 1 0 0 1 1 1v1h8V1a1 1 0 0 1 2 0v1h1a1 1 0 0 1 1 1v2H0V3a1 1 0 0 1 1-1h1V1a1 1 0 0 1 1-1zm13 5v9a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5h16z" />
                                                    </svg>
                                                    <?php echo get_the_date(); ?>
                                                </span>
                                                <span class="author">por <?php the_author(); ?></span>
                                            </p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </a>
                        </article>
                <?php endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>

            <!-- View All Posts Button -->
            <div class="view-all-posts">
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="button">
                    Ver todos os posts
                </a>
            </div>
        </div>

        <aside class="sidebar-area">
            <?php get_sidebar(); ?>
        </aside>
    </section>
</main>

<?php get_footer();
