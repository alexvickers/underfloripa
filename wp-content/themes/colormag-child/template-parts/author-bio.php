<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

$author_id = get_the_author_meta('ID');
$author_name = get_the_author();
$author_bio = get_the_author_meta('description');
$custom_avatar = get_field('custom_author_avatar', 'user_' . $author_id);
$default_avatar = get_avatar($author_id, 100);

$avatar_url = is_array($custom_avatar) ? $custom_avatar['url'] : $custom_avatar;
$author_avatar = $avatar_url ? '<img src="' . esc_url($avatar_url) . '" alt="' . esc_attr($author_name) . '" class="custom-avatar">' : $default_avatar;

$author_posts_url = get_author_posts_url($author_id);

if (!empty($author_bio)) : ?>
    <div class="author-bio">
        <div class="author-avatar"><?php echo $author_avatar; ?></div>
        <div class="author-info">
            <h3><?php echo esc_html($author_name); ?></h3>
            <?php if ($author_bio) : ?>
                <p><?php echo esc_html($author_bio); ?></p>
            <?php else : ?>
                <p>No bio available.</p>
            <?php endif; ?>
            <a href="<?php echo esc_url($author_posts_url); ?>" class="author-link">Outras matérias deste autor</a>
        </div>
    </div>
<?php endif;
