<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

$author_id   = get_the_author_meta('ID');
$author_name = get_the_author();
$author_bio  = get_the_author_meta('description');
$custom_avatar = get_field('custom_author_avatar', 'user_' . $author_id);
$default_avatar = get_avatar($author_id, 120);

$avatar_url = '';
if (is_array($custom_avatar)) {
    $avatar_url = $custom_avatar['sizes']['thumbnail'] ?? $custom_avatar['url'];
} elseif (is_string($custom_avatar)) {
    $avatar_url = $custom_avatar;
}

$author_avatar = $avatar_url
    ? '<img src="' . esc_url($avatar_url) . '" alt="' . esc_attr($author_name) . '" class="custom-avatar" width="120" height="120">'
    : $default_avatar;

$author_posts_url = get_author_posts_url($author_id);

$instagram_raw = get_field('instagram', 'user_' . $author_id);

$instagram_url = '';
if ($instagram_raw) {
    $instagram_raw = trim($instagram_raw);

    if (strpos($instagram_raw, 'http://') === 0 || strpos($instagram_raw, 'https://') === 0) {
        $instagram_url = $instagram_raw;
    } else {
        $handle = ltrim($instagram_raw, '/@');
        $instagram_url = 'https://instagram.com/' . $handle;
    }
}
?>

<div class="author-bio">
    <div class="author-avatar"><?php echo $author_avatar; ?></div>
    <div class="author-info">
        <h3><?php echo esc_html($author_name); ?></h3>

        <?php if (! empty($author_bio)) : ?>
            <p><?php echo esc_html($author_bio); ?></p>
        <?php endif; ?>

        <div class="buttons">
            <?php if ($instagram_url) : ?>
                <a
                    href="<?php echo esc_url($instagram_url); ?>"
                    class="author-instagram button"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="<?php echo esc_attr(sprintf(__('Visit %s on Instagram', 'underfloripa'), $author_name)); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor" d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7z" />
                        <path fill="currentColor" d="M12 7.25a4.75 4.75 0 1 1 0 9.5 4.75 4.75 0 0 1 0-9.5zm0 2a2.75 2.75 0 1 0 0 5.5 2.75 2.75 0 0 0 0-5.5zM17.5 6.25a.75.75 0 1 1 0 1.5.75.75 0 0 1 0-1.5z" />
                    </svg>

                    <span class="author-instagram-label">
                        Instagram
                    </span>
                </a>
            <?php endif; ?>

            <a href="<?php echo esc_url($author_posts_url); ?>" class="author-link button">
                Outras matérias deste autor
            </a>
        </div>
    </div>
</div>