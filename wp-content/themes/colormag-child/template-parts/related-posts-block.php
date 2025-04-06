<?php if (!empty($filtered_posts)) : ?>
<div class="related-posts">
    <h3><span><?php echo esc_html($heading_text); ?></span></h3>
    <ul>
        <?php foreach ($filtered_posts as $post_item): ?>
            <li>
                <a href="<?php echo get_permalink($post_item->ID); ?>">
                    <?php
                    $thumb = get_the_post_thumbnail($post_item->ID, [300, 300]);
                    if ($thumb) {
                        echo '<div class="related-post-thumb">' . $thumb . '</div>';
                    }
                    ?>
                    <span class="related-post-title"><?php echo get_the_title($post_item->ID); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
