<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}

get_header(); ?>

<div class="content-area">
	<main class="main-content">
		<?php
		if (have_posts()) :
			while (have_posts()) : the_post();
				the_title('<h2>', '</h2>');
				the_content();
			endwhile;
		else :
			echo '<p>No content found.</p>';
		endif;
		?>
	</main>
	<aside class="sidebar">
		<?php get_sidebar(); ?> </aside>
</div>

<?php get_footer();
