<?php
$author_id = get_the_author_meta('ID');
$author_name = get_the_author();
$author_description = get_field('author_custom_bio', 'user_' . $author_id);
$custom_avatar = get_field('custom_author_avatar', 'user_' . $author_id);
$default_avatar = get_avatar($author_id, 100); // Gravatar fallback

// Ensure the correct image format is retrieved
$avatar_url = is_array($custom_avatar) ? $custom_avatar['url'] : $custom_avatar;
$author_avatar = $avatar_url ? '<img src="' . esc_url($avatar_url) . '" alt="' . esc_attr($author_name) . '" class="custom-avatar">' : $default_avatar;

$author_posts_url = get_author_posts_url($author_id);
?>

<div class="author-bio">
    <div class="author-avatar"><?php echo $author_avatar; ?></div>
    <div class="author-info">
        <h3>Mais sobre <?php echo esc_html($author_name); ?></h3>
        <?php if ($author_description) : ?>
            <p><?php echo esc_html($author_description); ?></p>
        <?php else : ?>
            <p>No bio available.</p>
        <?php endif; ?>
        <a href="<?php echo esc_url($author_posts_url); ?>" class="author-link">Outras matérias deste autor</a>
    </div>
</div>
