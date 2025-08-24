<?php get_header(); ?>

<div class="site-container content">

	<!-- Main post content -->
	<main class="content-area">

		<?php
		if (have_posts()) :
			while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<!-- Title -->
					<header class="entry-header">
						<?php if (function_exists('rank_math_the_breadcrumbs')) : ?>
							<nav class="breadcrumbs">
								<?php rank_math_the_breadcrumbs(); ?>
							</nav>
						<?php endif; ?>

						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="entry-meta">
							<span class="entry-date"><?php echo get_the_date(); ?></span> |
							<span class="entry-author"><?php the_author_posts_link(); ?></span>
						</div>
					</header>

					<!-- Featured image -->
					<?php if (has_post_thumbnail()) : ?>
						<div class="entry-thumbnail ratio-16-9">
							<?php the_post_thumbnail('large'); ?>
						</div>
					<?php endif; ?>

					<!-- Content -->
					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<!-- Author box (reusable component) -->
					<?php get_template_part('template-parts/author-bio', 'box'); ?>

					<!-- Related posts (reusable component) -->
					<?php get_template_part( 'template-parts/related-posts-block' ); ?>
				</article>

		<?php endwhile;
		endif; ?>

	</main>

	<!-- Sidebar -->
	<aside class="sidebar">
		<?php get_sidebar(); ?>
	</aside>

</div><!-- /.site-container -->

<?php get_footer(); ?>