<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

if (!empty($filtered_posts)) : ?>
    <div class="related-posts">
        <h3><span><?php echo esc_html($heading_text); ?></span></h3>
        <ul>
            <?php foreach ($filtered_posts as $post_item): ?>
                <li>
                    <a href="<?php echo get_permalink($post_item->ID); ?>">
                        <?php
                        if (!$is_resenhas) : ?>
                            <span class="related-post-date">
                                <?php echo get_the_date('j \d\e F \d\e Y', $post_item->ID); ?>
                            </span>
                        <?php endif; ?>

                        <div class="related-post-thumb">
                            <?php
                            $thumb = get_the_post_thumbnail($post_item->ID, [300, 300]);
                            if ($thumb) {
                                echo $thumb;
                            }

                            $categories = get_the_category($post_item->ID);
                            if (!empty($categories) && $categories[0]->slug !== 'resenhas') {
                                $cat_link = get_category_link($categories[0]->term_id);
                                echo '<span class="related-post-category">
                                    <a href="' . esc_url($cat_link) . '">' . esc_html($categories[0]->name) . '</a>
                                </span>';
                            } ?>
                        </div>
                        <span class="related-post-title"><?php echo get_the_title($post_item->ID); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif;
