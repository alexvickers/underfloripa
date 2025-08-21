<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
} ?>

<footer id="site-footer">
	<nav class="footer-menu site-container">
		<?php wp_nav_menu([
			'theme_location' => 'footer_menu',
			'menu_id'        => 'footer-menu',
			'container'      => false,
		]); ?>
	</nav>
	<div class="site-container">
		<p>Under Floripa (2004 - <?php echo date('Y'); ?>). Todos os Direitos Reservados. O maior site de resenhas do Sul do Brasil! Indo na contramão desde 2004.</p>
	</div>
</footer>

<button id="back-to-top" title="Voltar ao topo">↑</button>

<script>
	(() => {
		const header = document.getElementById('site-header');
		if (!header) return;

		const miniLogo = header.querySelector('.mini-logo');
		const shrinkThreshold = 180; // pixels to scroll before shrinking

		// Detect scrollable container
		let scrollContainer = window;
		const testScroll = document.documentElement.scrollHeight > window.innerHeight;
		if (!testScroll) {
			// Try body or main wrapper
			const container = document.querySelector('body');
			if (container) scrollContainer = container;
		}

		const handleScroll = () => {
			const scrollY = scrollContainer === window ? window.scrollY : scrollContainer.scrollTop;

			if (scrollY > shrinkThreshold) {
				header.classList.add('shrink');
				if (miniLogo) miniLogo.style.opacity = 1;
			} else {
				header.classList.remove('shrink');
				if (miniLogo) miniLogo.style.opacity = 0;
			}
		};

		// Attach listener
		scrollContainer.addEventListener('scroll', handleScroll);

		// Run once in case page is already scrolled
		handleScroll();
	})();
</script>

<?php wp_footer(); ?>

</body>

</html>