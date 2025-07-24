<?php

/**
 * Site branding template file.
 *
 * @package ColorMag
 *
 * TODO: @since.
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$screen_reader        = '';
$description          = get_bloginfo('description', 'display');
$header_display_type  = get_theme_mod('colormag_header_logo_placement', 'header_text_only');
$site_identity_enable = get_theme_mod('colormag_enable_site_identity', true);
$site_tagline_enable  = get_theme_mod('colormag_enable_site_tagline', true);

?>
<div id="cm-site-branding" class="cm-site-branding">
	<a href="<?php site_url() ?>" class="custom-logo-link" rel="home" aria-current="page">
		<img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/logo.jpg'); ?>" class="custom-logo lazy loaded" alt="Under Floripa">
	</a>
</div><!-- #cm-site-branding -->

<?php

if ($site_identity_enable || $site_tagline_enable) { ?>
	<div id="cm-site-info">
		<h1 class="cm-site-title cm-title-show-desktop cm-title-show-tablet cm-title-show-mobile">
			<a href="<?php site_url() ?>" title="Under Floripa" rel="home">Under Floripa</a>
		</h1>

		<p class="cm-site-description cm-tagline-show-desktop cm-tagline-show-tablet cm-tagline-show-mobile ">
			O maior site de resenhas do Sul do Brasil! </p>
	</div><!-- #cm-site-info -->
<?php }
