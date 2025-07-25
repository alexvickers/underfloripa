<?php
get_header();

$excluded_cats = ['resenhas', 'coberturas', 'colunas'];
$excluded_cat_ids = array_map(function($slug) {
  $cat = get_category_by_slug($slug);
  return $cat ? $cat->term_id : 0;
}, $excluded_cats);
?>

<main class="site-container noticias-archive">
  <h1>Notícias</h1>

  <?php
  $news_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 10,
    'category__not_in' => $excluded_cat_ids,
    'paged'          => get_query_var('paged') ?: 1,
  ]);

  if ($news_query->have_posts()) :
    while ($news_query->have_posts()) : $news_query->the_post(); ?>
      <article class="latest-news-item">
        <?php if (has_post_thumbnail()) : ?>
          <div class="post-image">
            <?php the_post_thumbnail('medium'); ?>
          </div>
        <?php endif; ?>
        <div class="post-meta">
          <div class="post-categories"><?php the_category(' '); ?></div>
          <h3 class="post-title"><?php the_title(); ?></h3>
          <div class="post-info">
            <?php the_author(); ?> – <?php echo get_the_date(); ?>
          </div>
          <div class="post-excerpt"><?php the_excerpt(); ?></div>
          <a href="<?php the_permalink(); ?>" class="read-more">Leia mais →</a>
        </div>
      </article>
    <?php endwhile;

    the_posts_pagination([
      'prev_text' => '← Anteriores',
      'next_text' => 'Próximas →',
    ]);
  else :
    echo '<p>Nenhuma notícia encontrada.</p>';
  endif;

  wp_reset_postdata();
  ?>
</main>

<?php get_footer(); ?>
