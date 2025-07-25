<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		rel="preload"
		href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Heebo:wght@100..900&display=swap"
		as="style"
		onload="this.onload=null;this.rel='stylesheet'" />
	<noscript>
		<link
			href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Heebo:wght@100..900&display=swap"
			rel="stylesheet"
			type="text/css" />
	</noscript>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header id="site-header">
		<div class="header-container">
			<div class="header-left">
				<?php if (has_custom_logo()) : ?>
					<div class="site-logo"><?php the_custom_logo(); ?></div>
				<?php endif; ?>

				<div class="site-title-tagline">
					<h1 class="site-title"><?php bloginfo('name'); ?></h1>
					<p class="site-description">O maior site de resenhas do Sul do Brasil!</p>
				</div>
			</div>

			<div class="header-right">
				<div class="header-socials">
					<!-- Replace with your real links/icons -->
					<a href="#" aria-label="Instagram">📷</a>
					<a href="#" aria-label="Facebook">📘</a>
					<a href="#" aria-label="X (Twitter)">🐦</a>
				</div>

				<div class="header-banner">
					<!-- Replace with real ad code if needed -->
					<img src="<?php echo get_template_directory_uri(); ?>/assets/banner-placeholder.png" alt="728x90 ad banner" width="728" height="90" />
				</div>
			</div>
		</div>
		<nav id="site-navigation" class="main-navigation">
			<button id="menu-toggle" aria-controls="primary-menu" aria-expanded="false">☰ Menu</button>
			<?php
			wp_nav_menu([
				'theme_location' => 'main_menu',
				'menu_id'        => 'primary-menu',
				'container'      => false,
			]);
			?>
		</nav>
	</header>
	