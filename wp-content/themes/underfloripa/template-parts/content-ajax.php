<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
} ?>

<article <?php post_class('archive-post post-fade-in'); ?> id="post-<?php the_ID(); ?>">

    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" class="archive-post-thumbnail">
            <?php the_post_thumbnail('medium_large'); ?>
        </a>
    <?php endif; ?>

    <div class="archive-post-content">
        <h2 class="archive-post-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <div class="archive-meta">
            <span class="archive-date"><?php echo get_the_date(); ?></span>
            <span class="archive-author"><?php the_author_posts_link(); ?></span>
        </div>

        <div class="archive-excerpt">
            <?php the_excerpt(); ?>
        </div>
    </div>

</article>