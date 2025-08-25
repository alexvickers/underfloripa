<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<?php get_template_part('template-parts/home/top-stories'); ?>

<div class="content-area site-container">
    <main class="main-content" id="site-main">
        <div class="homepage-ad">
            <img src="https://placehold.co/970x250" />
        </div>
        <?php get_template_part('template-parts/home/latest-news'); ?>
        <?php get_template_part('template-parts/home/reviews'); ?>
        <?php get_template_part('template-parts/home/coberturas'); ?>
        <?php get_template_part('template-parts/home/colunas'); ?>
    </main>

    <?php if (is_active_sidebar('primary-sidebar')) : ?>
        <aside class="sidebar">
            <?php dynamic_sidebar('primary-sidebar'); ?>
        </aside>
    <?php endif; ?>
</div>

<?php get_footer();
