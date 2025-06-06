<?php
get_header();
?>

<div class="cm-row">
    <div id="cm-primary" class="cm-primary">
        <div class="cm-posts clearfix">

            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="cm-content-wrapper cm-row">

                        <!-- Featured image -->
                        <div class="cm-col-4">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="cm-featured-image">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Details + Related Excerpt -->
                        <div class="cm-col-8">
                            <header class="entry-header">
                                <h1 class="entry-title">
                                    <?php the_title(); ?>
                                    <?php if (get_field('tour')) { ?>
                                        - <?php esc_attr(the_field('tour'));
                                        } ?>
                                </h1>
                            </header>

                            <div class="entry-content">
                                <?php
                                $related_post = get_field('link');
                                if ($related_post instanceof WP_Post) {
                                    setup_postdata($related_post);
                                ?>
                                    <div class="related-excerpt">
                                        <?php $content = get_the_content(null, false, $related_post);
                                        $h2 = 'Detalhes do Evento';

                                        $lines = preg_split('/\r\n|\r|\n/', $content);
                                        $second_line = isset($lines[1]) ? trim($lines[1]) : '';

                                        if (preg_match('/<h2[^>]*>(.*?)<\/h2>/is', $second_line, $matches)) {
                                            $h2 = wp_strip_all_tags($matches[1]);
                                        }
                                        ?>

                                        <h2><?php echo esc_html($h2); ?></h2>
                                        <p><?php echo get_the_excerpt($related_post); ?></p>
                                        <p><a href="<?php echo get_permalink($related_post); ?>">Leia mais</a></p>
                                    </div>
                                <?php
                                    wp_reset_postdata();
                                }

                                if (function_exists('underfloripa_render_event_details_block')) {
                                    underfloripa_render_event_details_block([get_the_ID()]);
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </article>
            <?php endwhile; ?>

        </div>
    </div>

    <?php colormag_sidebar_select(); ?>
</div>

<?php get_footer();
