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

            echo get_related_posts_block(get_post());
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
