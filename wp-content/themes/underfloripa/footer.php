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

<?php wp_footer(); ?>

</body>

</html>
