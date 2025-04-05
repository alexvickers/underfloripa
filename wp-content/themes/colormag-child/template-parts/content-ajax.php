<article id="post-<?php the_ID(); ?>" <?php post_class('cm-post'); ?>>

    <?php if (has_post_thumbnail()) : ?>
        <div class="cm-featured-image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('colormag-featured-image'); ?>
            </a>
        </div>
    <?php endif; ?>

	<div class="cm-post-content">

        <header class="cm-entry-header">
            <h3 class="cm-entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        </header>

        <div class="cm-entry-meta">
            <?php colormag_entry_meta(); ?>
        </div>

        <div class="cm-entry-summary">
            <p><?php echo wp_trim_words( get_the_content(), 30, '...' ); ?></p>
        </div>

        <div class="cm-read-more">
            <a href="<?php the_permalink(); ?>" class="cm-btn cm-btn-primary">
                <?php esc_html_e('Leia Mais', 'colormag'); ?>
            </a>
        </div>

    </div>

</article>
