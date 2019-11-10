<?php

	//multilanguage theme
	
add_action('after_setup_theme', 'iw_language_theme_setup');
function iw_language_theme_setup( ) {
    load_theme_textdomain('oldpaper', get_template_directory().'/languages');
}



	// integrate the reduxframework options panel in the theme

if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/redux-framework-master/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/redux-framework-master/ReduxCore/framework.php' );
}
if ( !isset( $iw_opt ) && file_exists( dirname( __FILE__ ) . '/iw-config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/iw-config.php' );
}



	// required plugin

require_once( 'plugin/required.php' );
	
	// update notifier
	
require_once( 'update-notifier.php' );

	// widgets

require_once( 'widgets/iw-lastposts.php' );
require_once( 'widgets/iw-authors.php' );

?>