<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
} ?>

<article
    <?php post_class('archive-post post-fade-in'); ?>
    id="post-<?php the_ID(); ?>"
    itemscope
    itemtype="https://schema.org/Article">

    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" class="archive-post-thumbnail" itemprop="url">
            <?php the_post_thumbnail('medium_large', ['itemprop' => 'image', 'alt' => get_the_title()]); ?>
        </a>
    <?php endif; ?>

    <div class="archive-post-content">
        <h2 class="archive-post-title" itemprop="headline">
            <a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a>
        </h2>

        <div class="archive-meta">
            <time class="archive-date" datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished">
                <?php echo get_the_date(); ?>
            </time>
            <span class="archive-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" itemprop="name"><?php the_author(); ?></a>
            </span>
        </div>

        <div class="archive-excerpt" itemprop="description">
            <?php the_excerpt(); ?>
        </div>
    </div>

</article>