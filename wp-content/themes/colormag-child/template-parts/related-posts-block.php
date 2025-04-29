<?php if (!empty($filtered_posts)) : ?>
    <div class="related-posts">
        <h3><span><?php echo esc_html($heading_text); ?></span></h3>
        <ul>
            <?php foreach ($filtered_posts as $post_item): ?>
                <li>
                    <a href="<?php echo get_permalink($post_item->ID); ?>">
                        <?php if (!empty($is_cultural)) : ?>
                            <span class="related-post-date">
                                <svg class="mzb-icon mzb-icon--calender" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                                    <path d="M1.892 12.929h10.214V5.5H1.892v7.429zm2.786-8.822v-2.09a.226.226 0 00-.066-.166.226.226 0 00-.166-.065H3.98a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.022.122.065.166.044.044.1.065.167.065h.465a.226.226 0 00.166-.065.226.226 0 00.066-.167zm5.571 0v-2.09a.226.226 0 00-.065-.166.226.226 0 00-.167-.065h-.464a.226.226 0 00-.167.065.226.226 0 00-.065.167v2.09c0 .067.021.122.065.166.043.044.099.065.167.065h.464a.226.226 0 00.167-.065.226.226 0 00.065-.167zm2.786-.464v9.286c0 .251-.092.469-.276.652a.892.892 0 01-.653.276H1.892a.892.892 0 01-.653-.275.892.892 0 01-.276-.653V3.643c0-.252.092-.47.276-.653a.892.892 0 01.653-.276h.929v-.696c0-.32.113-.593.34-.82.228-.227.501-.34.82-.34h.465c.319 0 .592.113.82.34.227.227.34.5.34.82v.696h2.786v-.696c0-.32.114-.593.34-.82.228-.227.501-.34.82-.34h.465c.32 0 .592.113.82.34.227.227.34.5.34.82v.696h.93c.25 0 .468.092.652.276a.892.892 0 01.276.653z"></path>
                                </svg>
                                <?php echo get_the_date('d M Y', $post_item->ID); ?>
                            </span>
                        <?php endif;
                        $thumb = get_the_post_thumbnail($post_item->ID, [300, 300]);
                        if ($thumb) {
                            echo '<div class="related-post-thumb">' . $thumb . '</div>';
                        } ?>
                        <span class="related-post-title"><?php echo get_the_title($post_item->ID); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif;
