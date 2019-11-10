<?php 

header("Content-type: text/css; charset=utf-8"); 

$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

require_once( $path_to_wp . '/wp-load.php' );

$options = get_option('iw_opt');

?>

	/* start customstyles.php */
	
	<?php if( isset($iw_opt['primary-color']) and $iw_opt['primary-color'] != '#2c3e50' ) : ?>
		
		/* primary color */
		
		/*section#top { background-color:<?php echo $iw_opt['primary-color']; ?>;}*/
		
		@media (max-width: 767px){
			.carousel h2 a{
			color: <?php echo $iw_opt['primary-color']; ?> !important;
			}
		}
		
	<?php endif; ?>

	<?php if( $iw_opt['single-dropcaps'] ) : ?>

		.single-article .textcontent p:first-child:first-letter{
			background-color: <?php echo $iw_opt['secondary-color']; ?> !important;
			font-size: 210%;
			float: left;
			margin-right: 8px;
			padding: 8px;
		}

		.single-article .textcontent blockquote p:first-child:first-letter {
			font-size:100%;
			float:none;
			background-color:transparent !important;
			margin:0;
			padding:0;
	}

	<?php endif; ?>
	
	<?php 
	
	//only for the logo shadow
	if( !$iw_opt['boxed'] and
		isset($iw_opt['opt-background']['background-color']) and 
		( $iw_opt['opt-background']['background-color'] != '' or
		$iw_opt['primary-color'] != '#2c3e50' ) 
	) :
	
		$bg = ($iw_opt['opt-background']['background-color'] != '')	? $iw_opt['opt-background']['background-color'] : '#ffffff';
		$pr = ($iw_opt['primary-color'] != '#2c3e50' ) 				? $iw_opt['primary-color'] 						: '#2c3e50';
	
	?>
		/* logo shadow */
	
		header .wrapper #logo{
			text-shadow: 2px 2px 0 <?php echo $bg ?>, 4px 4px 0px <?php echo $pr ?> !important;
		}
		
	<?php endif; ?>
	
	<?php if( !$iw_opt['boxed'] and 
		isset($iw_opt['opt-background']['background-color']) and 
		$iw_opt['opt-background']['background-color'] != '' 
	) : ?>
	
		/* background */
	
		.widget h4{
			background-image: none !important;
		}
		
		.widget h4 span{
			background: <?php echo $iw_opt['opt-background']['background-color'] ?> !important;
		}
		
		#loader{
			background: <?php echo $iw_opt['opt-background']['background-color'] ?> !important;
		}
	<?php endif; ?>
	
	<?php echo $iw_opt['css-code']; ?>