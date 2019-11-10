<?php global $iw_opt ?>

<ul class="textinfo list-inline text-center">
	
	<?php if( ( !is_page() and $iw_opt['single-author'] ) or ( is_page() and $iw_opt['page-author'] ) ) : ?>
		<li class="vcard author post-author"><span class="fn"><?php the_author_posts_link() ?><span></li>
	<?php endif; ?>
	
	<?php if( !is_attachment() and !is_page() and !is_search() and $iw_opt['single-categories'] ) : ?>
		<li><?php the_category(', ') ?></li>
	<?php endif ?>
	
	 <?php
	 	if( comments_open() ){
	?>
	
	<?php if( ( !is_page() and $iw_opt['single-comments'] ) or ( is_page() and $iw_opt['page-comments'] ) ) : ?>	
		<li><a href="<?php comments_link(); ?>"><?php comments_number( __('No responses', 'oldpaper') , __('One response', 'oldpaper') , __('% responses', 'oldpaper') ); ?></a></li>
	<?php endif; ?>
	
	<?php } ?>

	<?php if( ( !is_page() and $iw_opt['single-date'] ) or ( is_page() and $iw_opt['page-date'] ) ) : ?>
		<li>
			<time class="date updated" datetime="<?php the_time('Y-m-d'); ?>">
			<a href="<?php echo get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>">
			<?php echo get_the_date() ?>
			</a>
			</time>
		</li>
	<?php endif; ?>
		
</ul>