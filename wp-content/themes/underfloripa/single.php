<?php
// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}

get_header(); ?>

<div class="site-container content">

	<!-- Main post content -->
	<main>

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
							<span class="entry-author">
								<?php the_author_posts_link(); ?>
							</span>
							<span class="entry-date">
								Publicado em <?php echo get_the_time('j \d\e F \d\e Y \à\s H\hi'); ?>
							</span>
							<?php
							$published_time = get_the_time('U');
							$modified_time  = get_the_modified_time('U');

							if ($modified_time > $published_time) : ?>
								<span class="entry-updated">
									Última atualização em <?php echo get_the_modified_time('j \d\e F \d\e Y \à\s H\hi'); ?>
								</span>
							<?php endif; ?>
						</div>
					</header>

					<!-- Featured image -->
					<?php if (has_post_thumbnail()) : ?>
						<div class="entry-thumbnail ratio-16-9">
							<?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
						</div>
					<?php endif; ?>

					<!-- Content -->
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
					<?php get_template_part('template-parts/author-bio', 'box'); ?>
				</article>

				<div class="lazy-google-ad responsive-ad"
					data-ad-client="ca-pub-2855642712528671"
					data-ad-slot="1234567890">
					<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2855642712528671"
						crossorigin="anonymous"></script>
					<ins class="adsbygoogle"
						style="display:block; text-align:center;"
						data-ad-layout="in-article"
						data-ad-format="fluid"
						data-ad-client="ca-pub-2855642712528671"
						data-ad-slot="3442625715"></ins>
					<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>

				<?php echo get_related_posts_block(get_post()); ?>

		<?php endwhile;
		endif; ?>

		<div class="lazy-google-ad responsive-ad"
			data-ad-client="ca-pub-2855642712528671"
			data-ad-slot="1234567890">
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2855642712528671"
				crossorigin="anonymous"></script>
			<ins class="adsbygoogle"
				style="display:block"
				data-ad-format="autorelaxed"
				data-ad-client="ca-pub-2855642712528671"
				data-ad-slot="2638856769"></ins>
			<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>

	</main>

	<aside class="sidebar">
		<?php dynamic_sidebar('primary-sidebar'); ?>
	</aside>

</div><!-- /.site-container -->

<?php get_footer();
