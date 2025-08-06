<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
} ?>

<footer id="site-footer">
	<nav class="footer-menu">
		<?php wp_nav_menu([
			'theme_location' => 'footer_menu',
			'menu_id'        => 'footer-menu',
			'container'      => false,
		]); ?>
	</nav>
	<p>&copy; <?php echo date('Y'); ?> Underfloripa</p>
</footer>

<button id="back-to-top" title="Voltar ao topo">↑</button>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const toggle = document.getElementById('menu-toggle');
		const menu = document.getElementById('primary-menu');

		toggle.addEventListener('click', function() {
			const expanded = this.getAttribute('aria-expanded') === 'true';
			this.setAttribute('aria-expanded', !expanded);
			menu.classList.toggle('open');
		});
	});
</script>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const header = document.getElementById('site-header');
		let lastScroll = window.scrollY;

		window.addEventListener('scroll', () => {
			const currentScroll = window.scrollY;

			if (currentScroll > 80) {
				header.classList.add('shrink');
			} else {
				header.classList.remove('shrink');
			}

			lastScroll = currentScroll;
		});
	});
</script>

</div><!-- /.site-container -->

<?php wp_footer(); ?>

</body>

</html>
