<?php

/*

	@package WordPress
	@subpackage Old Paper Theme by Thunderthemes.net

*/

?>

    <!DOCTYPE html>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
    <!--[if gt IE 8]><!-->
    <html class="no-js" <?php language_attributes(); ?>>
    <!--<![endif]-->

    <head>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-2855642712528671",
                enable_page_level_ads: true
            });

        </script>

        <?php global $iw_opt; ?>

        <meta charset="<?php bloginfo('charset') ?>">
        <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <![endif]-->

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="GD9RzkFIgRYVJVBBjghHdJ0uoINCLxFGrOzZc9dhFm0" />

        <?php if( isset($iw_opt['favicon']['url']) and $iw_opt['favicon']['url'] != '' ) : ?>
        <link rel="icon" href="<?php echo $iw_opt['favicon']['url']?>" type="image/png">
        <?php endif; ?>

        <?php
    
    if ( is_singular() && get_option( 'thread_comments' ) ) { 
    	wp_enqueue_script( 'comment-reply' ); 
    }
    
    ?>

            <?php wp_head() ?>

    </head>

    <body <?php body_class(); ?> dir="
        <?php echo $iw_opt['rtl'] ? 'rtl' : 'ltr'; ?>">

        <?php //echo('<pre ondblclick="jQuery(\'#bugfix\').hide()" id="bugfix"> -- CLOSE WITH DOUBLE CLICK -- '); print_r($iw_opt); echo('</pre>'); ?>

        <?php echo $iw_opt['js-codes']; ?>

        <div id="loader"><i class="fa fa-cog fa-spin fa-fw fa-2x"></i></div>

        <?php if( $iw_opt['boxed'] ) : ?>
        <div class="container" id="boxed">
            <?php endif; ?>

            <section id="top" class="animated" data-anim="fadeInDown">
                <div class="container">

                    <div class="row">
                        <div class="col-sm-7">
                            <?php
					
					if( has_nav_menu('Top Menu') ) :	
						wp_nav_menu( array(
							'theme_location'	=> 'Top Menu',
							'container' 		=> '',
							'menu_class' 		=> 'nav nav-pills',
							'menu_id' 			=> 'topmenu',
							'echo' 				=> true,
							'depth'				=> 1,
						)
					);
					endif;
							
					?>
                        </div>

                        <div class="col-sm-5">

                            <ul class="nav nav-pills navbar-right" id="socialmenu">

                                <li class="feed-rss"><a href="<?php bloginfo('atom_url'); ?>" title="Feed RSS"><i class="fa fa-lg fa-rss"></i></a></li>


                                <?php if($iw_opt['facebook'] != '') : ?>
                                <li class="facebook"><a href="<?php echo $iw_opt['facebook']?>" title="Follow us on Facebook" target="_blank"><i class="fa fa-lg fa-facebook"></i></a></li>
                                <?php endif; ?>

                                <?php if($iw_opt['twitter'] != '') : ?>
                                <li class="twitter"><a href="<?php echo $iw_opt['twitter']?>" title="Follow us on Twitter" target="_blank"><i class="fa fa-lg fa-twitter"></i></a></li>
                                <?php endif; ?>

                                <?php if($iw_opt['instagram'] != '') : ?>
                                <li class="instagram"><a href="<?php echo $iw_opt['instagram']?>" title="Follow us on instagram" target="_blank"><i class="fa fa-lg fa-instagram"></i></a></li>
                                <?php endif; ?>

                                <?php if($iw_opt['google'] != '') : ?>
                                <li class="googleplus"><a href="<?php echo $iw_opt['google']?>" title="Follow us on Google Plus" target="_blank"><i class="fa fa-lg fa-google-plus-square"></i></a></li>
                                <?php endif; ?>

                                <?php if($iw_opt['flickr'] != '') : ?>
                                <li class="flickr"><a href="<?php echo $iw_opt['flickr']?>" title="Follow us on Flickr" target="_blank"><i class="fa fa-lg fa-flickr"></i></a></li>
                                <?php endif; ?>

                                <?php if($iw_opt['vimeo'] != '') : ?>
                                <li class="vimeo"><a href="<?php echo $iw_opt['vimeo']?>" title="Follow us on Vimeo" target="_blank"><i class="fa fa-lg fa-vimeo-square"></i></a></li>
                                <?php endif; ?>

                                <?php if($iw_opt['youtube'] != '') : ?>
                                <li class="youtube"><a href="<?php echo $iw_opt['youtube']?>" title="Follow us on YouTube" target="_blank"><i class="fa fa-lg fa-youtube-play"></i></a></li>
                                <?php endif; ?>

                                <?php if($iw_opt['pinterest'] != '') : ?>
                                <li class="pinterest"><a href="<?php echo $iw_opt['pinterest']?>" title="Follow us on Pinterest" target="_blank"><i class="fa fa-lg fa-pinterest"></i></a></li>
                                <?php endif; ?>

                                <?php if($iw_opt['tumblr'] != '') : ?>
                                <li class="tumblr"><a href="<?php echo $iw_opt['tumblr']?>" title="Follow us on Tumblr" target="_blank"><i class="fa fa-lg fa-tumblr"></i></a></li>
                                <?php endif; ?>

                            </ul>

                        </div>
                    </div>

                </div>
            </section>

            <?php 
	
	if( $iw_opt['header-ver'] == 1){
	
		get_template_part('headerver');
	
	} elseif( $iw_opt['header-ver'] == 2){
	
		get_template_part('headerver', 'left');
	
	} elseif( $iw_opt['header-ver'] == 3){
	
		get_template_part('headerver', 'full');
	
	} else{
	
		get_template_part('headerver');
	
	}
	
	?>

            <nav class="container">
                <div class="row">

                    <div class="col-sm-12">
                        <div class="wrapper">
                            <div id="bars">
                                <span class="fa-stack fa-lg">
							<i class="fa fa-square fa-stack-2x"></i>
							<i class="fa fa-bars fa-stack-1x"></i>
						</span>
                            </div>

                            <?php
				
					if( has_nav_menu('Main Menu') ) :	
						wp_nav_menu( array(
							'theme_location'	=> 'Main Menu',
							'container' 		=> '',
							'menu_class' 		=> 'nav nav-pills nav-justified',
							'menu_id' 			=> 'mainmenu',
							'echo' 				=> true,
							'depth'				=> 99,
						)
					);
					endif;
							
					?>
                        </div>
                    </div>

                </div>
            </nav>
