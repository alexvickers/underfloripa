<?php
/**
 * Theme Single Post Section for our theme.
 *
 * @package ColorMag
 *
 * @since   ColorMag 1.0.0
 */

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="cm-row">
    <?php
    /**
     * Hook: colormag_before_body_content.
     */
    do_action('colormag_before_body_content');
    ?>

    <div id="cm-primary" class="cm-primary">
        <div class="cm-posts clearfix">

            <?php
            /**
             * Hook: colormag_before_single_post_page_loop.
             */
            do_action('colormag_before_single_post_page_loop');

            while (have_posts()) :
                the_post();

                get_template_part('template-parts/content', 'single');
            endwhile;

            get_template_part('template-parts/author-bio');

            /**
             * Hook: colormag_after_single_post_page_loop.
             */
            do_action('colormag_after_single_post_page_loop');
            ?>
        </div><!-- .cm-posts -->

        <?php if (is_single()) {
            global $post;

            $categories = get_the_category($post->ID);
            if (!empty($categories)) {
                $category_ids = wp_list_pluck($categories, 'term_id');

                $count_args = [
                    'category__in' => $category_ids,
                    'post__not_in' => [$post->ID],
                    'posts_per_page' => -1,
                    'fields' => 'ids',
                    'no_found_rows' => true,
                ];
                $all_posts = get_posts($count_args);

                if (count($all_posts) > 3) {
                    $args = [
                        'category__in' => $category_ids,
                        'posts_per_page' => 3,
                        'orderby' => 'rand',
                        'post__not_in' => [$post->ID],
                        'no_found_rows' => true,
                    ];

                    $related_posts = get_posts($args);

                    if (!empty($related_posts)) {
                        echo '<div class="related-posts">';
                        echo '<h3><span>Outras matérias</span></h3><ul>';

                        foreach ($related_posts as $post_item) {
                            $thumbnail = get_the_post_thumbnail($post_item->ID, 'thumbnail');
                            echo '<li>';
                            echo '<a href="' . get_permalink($post_item->ID) . '">';
                            if ($thumbnail) {
                                echo '<div class="related-post-thumb">' . $thumbnail . '</div>';
                            }
                            echo '<span class="related-post-title">' . get_the_title($post_item->ID) . '</span>';
                            echo '</a>';
                            echo '</li>';
                        }

                    echo '</ul></div>';
                    }
                }
            }
        }

        /**
         * Hook: colormag_before_comments_template.
         */
        do_action('colormag_before_comments_template');

        /**
         * Functions hooked into colormag_action_after_inner_content action.
         *
         * @hooked colormag_render_comments - 10
         */
        do_action('colormag_action_comments');

        /**
         * Hook: colormag_after_comments_template.
         */
        do_action('colormag_after_comments_template');
        ?>
    </div><!-- #cm-primary -->

    <?php

    colormag_sidebar_select();
    ?>
</div>

<?php
/**
 * Hook: colormag_after_body_content.
 */
do_action('colormag_after_body_content');

get_footer();
