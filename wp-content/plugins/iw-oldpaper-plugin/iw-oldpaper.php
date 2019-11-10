<?php

/*
	Plugin Name: Old Paper Plugin
	Plugin URI: http://www.thunderthemes.net/
	Description: A series of utilities used in Old Paper Theme.
	Version: 1.0
	Author: ThunderThemes
	Author URI: http://www.thunderthemes.net/
*/

	//metabox
require_once('super-cpt-master/super-cpt.php');

	//shortcodes
require_once('iw_shotcodes/index.php');

	//remove super cpt from admin menu
add_filter( 'scpt_show_admin_menu', '__return_false' );

	//custom style in admin
add_action('admin_head', 'iw_custom_colors');
function iw_custom_colors() {
	echo '<style type="text/css">
	#menu-posts-breakingnews .wp-menu-image::before {	content: "\f339" !important;	}
	input:required:invalid, input:focus:invalid		{	background: #fcc;				}
	</style>';
}

	//slick for carousel
add_action( 'wp_enqueue_scripts', 'iw_slick_method');
function iw_slick_method() {
	wp_enqueue_style( 'slick', plugins_url( '', __FILE__ ) . '/iw_shotcodes/slick/slick.css' );
}
add_action( 'wp_enqueue_scripts', 'iw_slickjs_method');
function iw_slickjs_method() {
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script(
		'slick',
		plugins_url( '', __FILE__ ) . '/iw_shotcodes/slick/slick.min.js',
		array( 'jquery' ),
		'1.0.1',
		true
	);
}

	//add post taxs e fiels
$breakingnews = new Super_Custom_Post_Type( 'breaking news', 'Spot', 'Breaking news' );

	// custom field made by ACP
if( function_exists('acf') ){
	
	define( 'ACF_LITE', true );
	include_once('custom-fields/fields.php');

}

	// add author extra information
add_filter( 'user_contactmethods', 'iw_oldpaper_contact_methods' );
function iw_oldpaper_contact_methods( $contactmethods ) {
 
    // Remove we what we don't want
    unset( $contactmethods[ 'aim' ] );
    unset( $contactmethods[ 'yim' ] );
    unset( $contactmethods[ 'jabber' ] );
 
    // Add some useful ones
    $contactmethods[ 'twitter' ] 	= 'Twitter Username';
    $contactmethods[ 'facebook' ] 	= 'Facebook Profile URL';
    $contactmethods[ 'linkedin' ] 	= 'LinkedIn Public Profile URL';
    $contactmethods[ 'googleplus' ] = 'Google+ Profile URL';
 
    return $contactmethods;
} 

?>