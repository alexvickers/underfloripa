<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="content-area">
    <main class="main-content" id="site-main">
        <?php get_template_part('template-parts/home/latest-news'); ?>
        <?php get_template_part('template-parts/home/reviews'); ?>
        <?php get_template_part('template-parts/home/coberturas'); ?>
        <?php get_template_part('template-parts/home/colunas'); ?>
    </main>
    <aside class="sidebar">
        <?php get_sidebar(); ?> </aside>
</div>

<?php get_footer();
