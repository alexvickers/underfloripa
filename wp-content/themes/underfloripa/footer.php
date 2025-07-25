<footer id="site-footer">
	<nav class="footer-menu">
		<?php
		wp_nav_menu([
			'theme_location' => 'footer_menu',
			'menu_id'        => 'footer-menu',
			'container'      => false,
		]);
		?>
	</nav>
	<p>&copy; <?php echo date('Y'); ?> Underfloripa</p>
</footer>

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

<?php wp_footer(); ?>
</body>

</html>