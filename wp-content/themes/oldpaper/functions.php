<?php

// post format icon function
function iw_post_format_icon( ){
	
	if( has_post_format('quote') ) :		echo '<i class="fa fa-quote-left"></i>';
	
	elseif( has_post_format('image') ) :	echo '<i class="fa fa-picture-o"></i>';
	
	elseif( has_post_format('video') ) :	echo '<i class="fa fa-film"></i>';
	
	elseif( has_post_format('audio') ) :	echo '<i class="fa fa-music"></i>';
	
	else:									echo '<i class="fa fa-thumb-tack"></i>';
	
	endif;
	
	return;
	
}

	// importo il file di framework

require_once( 'framework/iw-framework.php' );



	//add the default style

function iw_my_styles_method() {

	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css' );
}
add_action( 'wp_enqueue_scripts', 'iw_my_styles_method');

/*function iw_custom_framework_styles() {

	wp_enqueue_style( 'customstyles', get_template_directory_uri() . '/css/custom-styles.css' );
}
add_action( 'wp_enqueue_scripts', 'iw_custom_framework_styles');
*/

// include custom styles (not totally deprecated)	
if ( !function_exists( 'iw_enqueue_dynamic_css_custom' ) ) { 
	
	add_action('wp_print_styles', 'iw_enqueue_dynamic_css_custom');
	function iw_enqueue_dynamic_css_custom() { 
		wp_register_style('customstyles', get_template_directory_uri() . '/customstyles.css.php', 'style'); 
		wp_enqueue_style('customstyles'); 
	}
	
}


function iw_content_responsive_class($content) {
   global $post;
   $pattern ="/<img(.*?)class=\"(.*?)\"(.*?)>/i";
   $replacement = '<img$1class="$2 img-responsive"$3>';
   $content = preg_replace($pattern, $replacement, $content);
   return $content;
}
add_filter('the_content', 'iw_content_responsive_class');



	// add some scripts
	
add_action( 'wp_enqueue_scripts', 'iw_my_scripts_method');
function iw_my_scripts_method() {

	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script(
		'prefixfree',
		get_template_directory_uri() . '/js/prefixfree.min.js',
		array( ),
		'1.0.7',
		false
	);
	
	wp_enqueue_script(
		'bootstrap',
		get_template_directory_uri() . '/framework/bootstrap/bootstrap.min.js',
		array( 'jquery' ),
		'3.0.3',
		true
	);
	
	wp_enqueue_script(
		'modernizr',
		get_template_directory_uri() . '/js/modernizr.min.js',
		array( ),
		'2.6.2',
		false
	);
	
	wp_enqueue_script(
		'inview',
		get_template_directory_uri() . '/js/jquery.inview.min.js',
		array( 'jquery' ),
		'0.1',
		true
	);
	
	wp_enqueue_script(
		'equalize',
		get_template_directory_uri() . '/js/equalize.min.js',
		array( 'jquery' ),
		'1.0.1',
		true
	);
	
	wp_enqueue_script(
		'main',
		get_template_directory_uri() . '/js/main.min.js',
		array( 'jquery' ),
		'0.1',
		true
	);
	
}


	// add woocommerce support
add_theme_support('woocommerce');

	// WOOCOMMERCE


remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', create_function('', 'echo "<section id=\"content\" class=\"container woocommerce\">";'), 10);
add_action('woocommerce_after_main_content', create_function('', 'echo "</section>";'), 10);

	//define('WOOCOMMERCE_USE_CSS', false); // rimuove gli stili standard di woocommerce

	// enable featured images

add_theme_support( 'post-thumbnails' );
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'full', 1160, false);
	add_image_size( 'slider', 1160, 480, true);
	add_image_size( 'standard', 800, 600, true);
}

	// remove excerpt [...]

add_filter( 'excerpt_more', 'iw_new_excerpt_more' );
function iw_new_excerpt_more( $more ) {
	return '...';
}

add_filter( 'get_the_content', 'shortcode_unautop');
add_filter( 'get_the_content', 'do_shortcode');

	// enable custom menu

add_action( 'init', 'iw_register_my_menu' );
function iw_register_my_menu( ) {
	register_nav_menu( 'Main Menu', 'Main menu of the theme');
	register_nav_menu( 'Top Menu', 'Small top menu of the theme');
}


// Register sidebars

function iw_register_sidebars() {

    	// enable widget for footer & sidebar

	if ( function_exists( 'register_sidebar' ) ){
	    register_sidebar(array(
			'name'=>'Sidebar',
	        'description' => 'Sidebar widgets',
	        'before_widget' => '<div class="widget %2$s" id="%1$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h4><span>',
	        'after_title' => '</span></h4>',
	    ));
	}

	if ( function_exists( 'register_sidebar' ) ){
	    register_sidebar(array(
			'name'=>'Footer first half',
	        'description' => 'Footer first half widgets',
	        'before_widget' => '<div class="widget %2$s" id="%1$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h4><span>',
	        'after_title' => '</span></h4>',
	    ));
	}

	if ( function_exists( 'register_sidebar' ) ){
	    register_sidebar(array(
			'name'=>'Footer second half',
	        'description' => 'Footer second half widgets',
	        'before_widget' => '<div class="widget col-sm-6 %2$s" id="%1$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h4><span>',
	        'after_title' => '</span></h4>',
	    ));
	}

}
// init sidebars
add_action( 'widgets_init', 'iw_register_sidebars' );

	// custom theme support

remove_theme_support( 'custom-background' );
remove_theme_support( 'custom-header' );

add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-formats', array( 'image', 'quote', 'video', 'audio' ) );

function iw_theme_slug_setup() {
   add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'iw_theme_slug_setup' );

	// width var

if ( ! isset( $content_width ) ) $content_width = 1200;


	// wp_header title function

if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function theme_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'theme_slug_render_title' );
}
	
	// custom comment layout

function iw_comment_format( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}

	?>
	
	<?php echo '<'.$tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> <?php echo 'id="comment-' ?><?php comment_ID() ?><?php echo '">' ?>

		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body row">
		<?php endif; ?>
		
			<div class="comment-author vcard col-sm-2">
				<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</div>
			
			<div class="col-sm-10">
				<div class="comment-content">
				
					<?php if ($comment->comment_approved == '0') : ?>
						<p><em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'oldpaper') ?></em></p>
					<?php endif; ?>
					
					<p class="h4">
						<span class="pull-right"><small class="date"><?php echo get_comment_date() ?> @ <?php echo get_comment_time() ?></small></span>
						<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
						<?php printf( __('<cite class="fn">%s</cite>'), get_comment_author_link() ) ?>
						</a>
					</p>
					
					<?php comment_text() ?>
					
					<p class="buttons">
						 <?php edit_comment_link( __('Admin edit', 'oldpaper'), '', ' or' ); ?> 
						 <?php
					
						// vengono aggiunti argomenti all'array passato dalla funzione nel file comment.php
						comment_reply_link(
							array_merge( 
								$args, 
								array(
									'add_below'		=> $add_below, 
									'depth' 		=> $depth, 
									'max_depth' 	=> $args['max_depth'],
									'before'		=> '',
									'after'			=> ''
								)
							)
						)
						
						?></p>
					
				</div>
			</div>
				
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>

	<?php
}
?>