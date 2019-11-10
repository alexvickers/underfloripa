<?php

// config for ReduxFramework

if ( !class_exists( "ReduxFramework" ) ) {
	return;
} 

if ( !class_exists( "Redux_Framework_sample_config" ) ) {
	class Redux_Framework_sample_config {

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct( ) {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();
			
			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();
			
			if ( !isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}
			
			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);

			// Dynamically add a section. Can be also used to modify sections/fields
			//add_filter('redux/options/'.$this->args['opt_name'].'/sections', array( $this, 'dynamic_section' ) );

		}
		
		function change_arguments($args){
		    //$args['dev_mode'] = true;
		    
		    return $args;
		}
			
		
		/**

			Filter hook for filtering the default value of any given field. Very useful in development mode.

		**/

		/* function change_defaults($defaults){
		    $defaults['str_replace'] = "Testing filter hook!";
		    
		    return $defaults;
		} */


		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {
			
			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists('ReduxFrameworkPlugin') ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2 );
			}

			// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
			remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );	

		}


		public function setSections() {

			
			//Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			

			// Background Patterns Reader
			$url_theme = ReduxFramework::$_dir . '../sample/patterns/';

			// Background Patterns Reader
			$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
			$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
			$sample_patterns      = array();

			if ( is_dir( $sample_patterns_path ) ) :
				
			  if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
			  	$sample_patterns = array();

			    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

			      if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
			      	$name = explode(".", $sample_patterns_file);
			      	$name = str_replace('.'.end($name), '', $sample_patterns_file);
			      	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
			      }
			    }
			  endif;
			endif;

			ob_start();

			$ct = wp_get_theme();
			$this->theme = $ct;
			$item_name = $this->theme->get('Name'); 
			$tags = $this->theme->Tags;
			$screenshot = $this->theme->get_screenshot();
			$class = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','redux-framework' ), $this->theme->display('Name') );

			?>
			<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
				<?php if ( $screenshot ) : ?>
					<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
					<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
						<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
					</a>
					<?php endif; ?>
					<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
				<?php endif; ?>

				<h4>
					<?php echo $this->theme->display('Name'); ?>
				</h4>

				<div>
					<ul class="theme-info">
						<li><?php printf( __('By %s','redux-framework'), $this->theme->display('Author') ); ?></li>
						<li><?php printf( __('Version %s','redux-framework'), $this->theme->display('Version') ); ?></li>
						<li><?php echo '<strong>'.__('Tags', 'redux-framework').':</strong> '; ?><?php printf( $this->theme->display('Tags') ); ?></li>
					</ul>
					<p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
					<?php if ( $this->theme->parent() ) {
						printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
							__( 'http://codex.wordpress.org/Child_Themes','redux-framework' ),
							$this->theme->parent()->display( 'Name' ) );
					} ?>
					
				</div>

			</div>

			<?php
			$item_info = ob_get_contents();
			    
			ob_end_clean();

			$sampleHTML = '';
			if( file_exists( dirname(__FILE__).'/info-html.html' )) {
				/** @global WP_Filesystem_Direct $wp_filesystem  **/
				global $wp_filesystem;
				if (empty($wp_filesystem)) {
					require_once(ABSPATH .'/wp-admin/includes/file.php');
					WP_Filesystem();
				}  		
				$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
			}


/*-------------------------------------------

		THE SECTIONS OF THE PANEL
	
-------------------------------------------*/	

			// ACTUAL DECLARATION OF SECTIONS
			$this->sections[] = array(
				'icon' => 'el-icon-dashboard',
				'title' => __('General settings', 'redux-framework'),
				'heading' => __('General theme settings', 'redux-framework'),
				'desc'    => __('<p class="description">Some general options and settings for the theme.</p>', 'redux-framework'),
				'fields' => array(
					
					array(
						'id'		=> 'favicon',
						'type' 		=> 'media', 
						'url'		=> true,
						'title' 	=> __('Favicon image', 'redux-framework'),
						'compiler' 	=> 'true',
						'desc'		=> __('Must be .png w:16px - h:16px', 'redux-framework'),
						'subtitle' 	=> __('Upload your favicon', 'redux-framework'),
						'default'	=> ''
					),
						
					array(
                        'id'        => 'showsublogoadd',
                        'type'      => 'switch',
                        'title'     => __('Show tagline', 'redux-framework'),
                        'subtitle'  => __('Show or hide the tagline', 'redux-framework'),
                        'desc'      => __('A text line under the title (the Wordpress tagline by default or custom text).', 'redux-framework'),
                        'default'   => true,
                    ),
                    
                    array(
						'id'		=> 'sublogoadd',
						'type' 		=> 'text',
						'title' 	=> __('Tagline', 'redux-framework'), 
						'subtitle' 	=> __('A tagline under the main title/logo of the site', 'redux-framework'),
                        'desc'      => __('If not set, you can change default the Tagline from the <a href="options-general.php">General Settings Tagline</a>', 'redux-framework'),
						'default' 	=> '',
                        'required'  => array('showsublogoadd', '=', true),
					),
                    
                    array(
                        'id'        => 'rtl',
                        'type'      => 'switch',
                        'title'     => __('RTL support', 'redux-framework'),
                        'subtitle'  => __('Right-To-Left text direction', 'redux-framework'),
                        'desc'      => __('Activate the RTL support', 'redux-framework'),
                        'default'   => false,
                    ),
                    
                    array(
                        'id'        => 'showbreakingnews',
                        'type'      => 'switch',
                        'title'     => __('Show breaking news', 'redux-framework'),
                        'subtitle'  => __('The slider with breaking news', 'redux-framework'),
                        'desc'      => __('A bar sliding last breaking news (<a href="edit.php?post_type=breakingnews">add from here</a>), just before the footer.', 'redux-framework'),
                        'default'   => true,
                    ),
                    
                    array(
                        'id'        => 'countbreakingnews',
                        'type'      => 'spinner',
                        'title'     => __('Select how many breaking news you want to show', 'redux-framework'),
                        'desc'      => __('One news a time with fade effect', 'redux-framework'),
                        'default'   => '3',
                        'min'       => '1',
                        'step'      => '1',
                        'max'       => '100',
                        'required'  => array('showbreakingnews', '=', true),
                    ),
                    
                    array(
                        'id'        => 'cropped',
                        'type'      => 'button_set',
                        'title'     => __('Featured image', 'redux-framework'),
                        'subtitle'  => __('The featured image size', 'redux-framework'),
                        'desc'      => __('Select if you want a full height or cropped featured image in a single page and posts.', 'redux-framework'),
                        
                        //Must provide key => value pairs for radio options
                        'options'   => array(
                            '0' => 'Full height', 
                            '1' => 'Cropped'
                        ), 
                        'default'   => '0'
                    ),
					
					array(
                        'id'        => 'boxed',
                        'type'      => 'button_set',
                        'title'     => __('Layout type', 'redux-framework'),
                        'subtitle'  => __('Standard or Boxed', 'redux-framework'),
                        'desc'      => __('Select your layout', 'redux-framework'),
                        
                        //Must provide key => value pairs for radio options
                        'options'   => array(
                            '0' => 'Standard', 
                            '1' => 'Boxed'
                        ), 
                        'default'   => '0'
                    ),
					
					array(
						'id'		=> 'footer-text',
						'type' 		=> 'editor',
						'title' 	=> __('Footer Text', 'redux-framework'), 
						'subtitle' 	=> __('Some little info in the footer of the site', 'redux-framework'),
						'default' 	=> 'Images are for demo purposes only and are properties of their respective owners.<br><strong>Old Paper</strong> by <a href="http://themeforest.net/user/thunderthemes/portfolio">ThunderThemes.net</a>',
					),
                    
				)
			);
			
			$this->sections[] = array(
				'icon'    => ' el-icon-home',
				'title'   => __('Home page options', 'redux-framework'),
				'heading' => __('Select the home page options and sections', 'redux-framework'),
				'desc'    => __('<p class="description">Set you preferred options.</p>', 'redux-framework'),
				'fields'  => array(
                    
                    array(
                        'id'        => 'catchess',
                        'type'      => 'select',
                        'data'      => 'categories',
                        'multi'     => false,
                        'title'     => __('Chess Layout Posts', 'redux-framework'),
                        'subtitle'  => __('Select category for Chess Layout', 'redux-framework'),
                        'desc'      => __('Select posts from a certain category. If not selected it show the last posts published.', 'redux-framework'),
                    ),

                    array(
                        'id'        => 'showfeatured',
                        'type'      => 'switch',
                        'title'     => __('Show featured posts', 'redux-framework'),
                        'subtitle'  => __('A list of three post in evidence in the top of the page, before the posts list.', 'redux-framework'),
                        'default'   => true,
                    ),
						
					array(
						'id'		=> 'titlefeatured',
						'type' 		=> 'text',
						'title' 	=> __('Featured post title', 'redux-framework'), 
						'subtitle' 	=> __('Set the title for the featured posts section', 'redux-framework'),
                        'default' 	=> 'Featured posts',
                        'required'  => array('showfeatured', '=', true),
					),
                    
					array(
                        'id'        => 'catfeatured',
                        'type'      => 'select',
                        'data'      => 'categories',
                        'multi'     => false,
                        'title'     => __('Featured posts', 'redux-framework'),
                        'subtitle'  => __('Article category', 'redux-framework'),
                        'desc'      => __('Select featured posts section category. If not selected it show the last three posts published.', 'redux-framework'),
                        'required'  => array('showfeatured', '=', true),
                    ),
                    
                    array(
                        'id'        => 'colfeatured',
                        'type'      => 'spinner',
                        'title'     => __('How many columns for featured posts you want?', 'redux-framework'),
                        'desc'      => __('Select from 1 to 4 columns', 'redux-framework'),
                        'default'   => '3',
                        'min'       => '1',
                        'step'      => '1',
                        'max'       => '4',
                        'required'  => array('showfeatured', '=', true),
                    ),
                    
                    array(
                        'id'        => 'countfeatured',
                        'type'      => 'spinner',
                        'title'     => __('How many featured posts you want?', 'redux-framework'),
                        'desc'      => __('If is more than the total columns the posts will ordered automatically in rows.', 'redux-framework'),
                        'default'   => '3',
                        'min'       => '1',
                        'step'      => '1',
                        'max'       => '100',
                        'required'  => array('showfeatured', '=', true),
                    ),

                    array(
                        'id'        => 'featured-author',
                        'type'      => 'switch',
                        'title'     => __('Show the Excerpt Author in the featured box', 'redux-framework'),
                        'subtitle'  => __('Show/Hide author in featured box in the homepage', 'redux-framework'),
                        'default'   => true,
                        'required'  => array('showfeatured', '=', true),
                    ),

                    array(
                        'id'        => 'featured-date',
                        'type'      => 'switch',
                        'title'     => __('Show the Excerpt Date in the featured box', 'redux-framework'),
                        'subtitle'  => __('Show/Hide date in featured box in the homepage', 'redux-framework'),
                        'default'   => true,
                        'required'  => array('showfeatured', '=', true),
                    ),

                    array(
                        'id'        => 'featured-excerpt',
                        'type'      => 'switch',
                        'title'     => __('Show the Excerpt text in the featured box', 'redux-framework'),
                        'subtitle'  => __('The excerpt for featured posts in homepage', 'redux-framework'),
                        'default'   => true,
                        'required'  => array('showfeatured', '=', true),
                    ),

                    array(
                        'id'        => 'featured-excerpt-length',
                        'type'      => 'spinner',
                        'title'     => __('Excerpt length : How many words do you want?', 'redux-framework'),
                        'desc'  => __('Select how many words in the excerpt', 'redux-framework'),
                        'default'   => '20',
                        'min'       => '1',
                        'step'      => '1',
                        'max'       => '100',
                        'required'  => array('showfeatured', '=', true),
                    ),

                     array(
                        'id'        => 'featured-title-length',
                        'type'      => 'spinner',
                        'title'     => __('Title length : How many words do you want for titles?', 'redux-framework'),
                        'desc'  => __('Select how many words for the titles', 'redux-framework'),
                        'default'   => '6',
                        'min'       => '1',
                        'step'      => '1',
                        'max'       => '100',
                        'required'  => array('showfeatured', '=', true),
                    ),

                    array(
                        'id'        => 'showeditorale',
                        'type'      => 'switch',
                        'title'     => __('Show the Editorial post in the right side', 'redux-framework'),
                        'subtitle'  => __('A <strong>complete</strong> post in the right side of the home page, just before the sidebar widgets.', 'redux-framework'),
                        'default'   => true,
                    ),
                    
					array(
                        'id'        => 'cateditoriale',
                        'type'      => 'select',
                        'data'      => 'categories',
                        'multi'     => false,
                        'title'     => __('Editorial', 'redux-framework'),
                        'subtitle'  => __('Homepage right side article', 'redux-framework'),
                        'desc'      => __('Select the category to show the Editorial article in the right side of the home page. (show the last article)', 'redux-framework'),
                        'required'  => array('showeditorale', '=', true),
                    ),
					
				)
			);
			
			
			
			$this->sections[] = array(
				'icon'    => ' el-icon-website',
				'title'   => __('Theme header options', 'redux-framework'),
				'heading' => __('Header customization: Fonts and Adv', 'redux-framework'),
				'desc'    => __('<p class="description">Customize the header options</p>', 'redux-framework'),
				'fields'  => array(

					array(
						'id'		=> 'logo',
						'type' 		=> 'media', 
						'url'		=> true,
						'title' 	=> __('Logo image', 'redux-framework'),
						'compiler' 	=> 'true',
						'desc'		=> __('Recommended w:570px - h:140px. You can set your logo as text from the <a href="options-general.php">General Settings Site Title</a> ', 'redux-framework'),
						'subtitle' 	=> __('Upload your logo image', 'redux-framework'),
						'default'	=> ''
					),

					array(
						'id'			=> 'logofont',
						'type'			=> 'typography', 
						'title'			=> __('Select logo font', 'redux-framework'),
						'google'		=> true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	=> true, // Select a backup non-google font in addition to a google font
						'subsets'		=> false, // Only appears if google is true and subsets not set to false
						'font-size'		=> true,
						'line-height'	=> true,
						'word-spacing'	=> true, // Defaults to false
						'letter-spacing'=> true, // Defaults to false
						'color'			=> false,
						'all_styles' 	=> true, // Enable all Google Font style/weight variations to be added to the page
						'output' 		=> array('header .wrapper #logo'), // An array of CSS selectors to apply this font style to dynamically
						'compiler'		=> array(''), // An array of CSS selectors to apply this font style to dynamically
						'units'			=> 'px', // Defaults to px
						'subtitle'		=> __('Select the options for the logo title in the very top of all pages.', 'redux-framework'),
					),
					
					// header ver selection
					
					array(
                        'id'        => 'header-ver',
                        'type'      => 'image_select',
                        'title'     => __('Header version', 'redux-framework'),
                        'subtitle' 	=> __('Select version for options.', 'redux-framework'),
                        'desc'      => __('Select your favorite header version and choose options below.', 'redux-framework'),
                        'options'   => array(
                            '1' => array(
                            	'alt' => 'Header v1: Header standard with two square banner at sides', 
                            	'img' => get_template_directory_uri().'/framework/redux-skins/headerver.png'
                            ),
                            '2' => array(
                            	'alt' => 'Header v2: Header with logo at left and a long banner at right', 
                            	'img' => get_template_directory_uri().'/framework/redux-skins/headerver-left.png'
                            ),
                            '3' => array(
                            	'alt' => 'Header v3: Header with full logo width (no options)', 
                            	'img' => get_template_directory_uri().'/framework/redux-skins/headerver-full.png'
                            )
                        ),
                        'default'	=> 1,
                        'width'		=> '230px',
                        'height'	=> '47px',
                    ),
                    
					// header version 1
						
						array(
							'id'		=> 'advleft',
							'type' 		=> 'media', 
							'url'		=> true,
							'title' 	=> __('Adv at left of the logo', 'redux-framework'),
							'compiler' 	=> 'true',
							'desc'		=> __('We recommend an image w:400px - h:400px.', 'redux-framework'),
							'subtitle' 	=> __('Upload a banner to show at left of the logo.', 'redux-framework'),
							'default'	=> '',
							'required'  => array('header-ver', '=', 1),
						),
						
	                    array(
	                        'id'        => 'advleftlink',
	                        'type'      => 'text',
	                        'title'     => __('Adv left link', 'redux-framework'),
	                        'subtitle'  => __('The link for the banner at left of the logo.', 'redux-framework'),
	                        'desc'      => __('This must be a URL.', 'redux-framework'),
	                        'validate'  => 'url',
	                        'default'   => '',
	                        'required'  => array('header-ver', '=', 1),
	                    ),
	                    
	                    array(
							'id'		=> 'advleftscript',
							'type' 		=> 'ace_editor',
							'title' 	=> __('Javascripts adv code for left', 'redux-framework'), 
							'subtitle' 	=> __('(eg. Google AdSense)', 'redux-framework'),
							'mode' 		=> 'javascript',
				            'theme' 	=> 'chrome',
							'desc' 		=> 'Paste your code here. If you set an image as ADV this field will not be displayed.',
				            'default' 	=> "",
				            'required'  => array('header-ver', '=', 1),
						),
	                    
						array(
							'id'		=> 'advright',
							'type' 		=> 'media', 
							'url'		=> true,
							'title' 	=> __('Adv at right of the logo', 'redux-framework'),
							'compiler' 	=> 'true',
							'desc'		=> __('We recommend an image w:400px - h:400px', 'redux-framework'),
							'subtitle' 	=> __('Upload a banner to show at right of the logo.', 'redux-framework'),
							'default'	=> '',
							'required'  => array('header-ver', '=', 1),
						),
						
	                    array(
	                        'id'        => 'advrightlink',
	                        'type'      => 'text',
	                        'title'     => __('Adv right link', 'redux-framework'),
	                        'subtitle'  => __('The link for the banner at right of the logo.', 'redux-framework'),
	                        'desc'      => __('This must be a URL.', 'redux-framework'),
	                        'validate'  => 'url',
	                        'default'   => '',
	                        'required'  => array('header-ver', '=', 1),
	                    ),
	                    
	                    array(
							'id'		=> 'advrightscript',
							'type' 		=> 'ace_editor',
							'title' 	=> __('Javascripts adv code for right', 'redux-framework'), 
							'subtitle' 	=> __('(eg. Google AdSense)', 'redux-framework'),
							'mode' 		=> 'javascript',
				            'theme' 	=> 'chrome',
							'desc' 		=> 'Paste your code here. If you set an image as ADV this field will not be displayed.',
				            'default' 	=> "",
				            'required'  => array('header-ver', '=', 1),
						),
					
					// end header ver 1
					// header version 2
		                    
							array(
								'id'		=> 'advlong',
								'type' 		=> 'media', 
								'url'		=> true,
								'title' 	=> __('Adv at right of the logo', 'redux-framework'),
								'compiler' 	=> 'true',
								'desc'		=> __('We recommend an image w:728px - h:90px', 'redux-framework'),
								'subtitle' 	=> __('Upload a long banner to show at right of the logo.', 'redux-framework'),
								'default'	=> '',
								'required'  => array('header-ver', '=', 2),
							),
							
		                    array(
		                        'id'        => 'advlonglink',
		                        'type'      => 'text',
		                        'title'     => __('Adv right link', 'redux-framework'),
		                        'subtitle'  => __('The link for the banner at right of the logo.', 'redux-framework'),
		                        'desc'      => __('This must be a URL.', 'redux-framework'),
		                        'validate'  => 'url',
		                        'default'   => '',
		                        'required'  => array('header-ver', '=', 2),
		                    ),
		                    
		                    array(
								'id'		=> 'advlongscript',
								'type' 		=> 'ace_editor',
								'title' 	=> __('Javascripts adv code for right', 'redux-framework'), 
								'subtitle' 	=> __('(eg. Google AdSense)', 'redux-framework'),
								'mode' 		=> 'javascript',
					            'theme' 	=> 'chrome',
								'desc' 		=> 'Paste your code here. If you set an image as ADV this field will not be displayed.',
					            'default' 	=> "",
					            'required'  => array('header-ver', '=', 2),
							),
						
					// end header ver 2
					
				)
			);
			
			$this->sections[] = array(
				'icon'    => 'el-icon-bookmark-empty',
				'title'   => __('Page options', 'redux-framework'),
				'heading' => __('Page options', 'redux-framework'),
				'desc'    => __('<p class="description">Select how to show in the pages of the site.</p>', 'redux-framework'),
				'fields'  => array(
				
                    array(
                        'id'        => 'page-author',
                        'type'      => 'switch',
                        'title'     => __('Show author', 'redux-framework'),
                        'subtitle'  => __('Show author name under the page title.', 'redux-framework'),
                        'default'   => true,
                    ),
                    
                    array(
                        'id'        => 'page-comments',
                        'type'      => 'switch',
                        'title'     => __('Show comments', 'redux-framework'),
                        'subtitle'  => __('Show comments count under the page title and the comments list under the content.', 'redux-framework'),
                        'default'   => true,
                    ),
                    
                    array(
                        'id'        => 'page-date',
                        'type'      => 'switch',
                        'title'     => __('Show date', 'redux-framework'),
                        'subtitle'  => __('Show date under the page title.', 'redux-framework'),
                        'default'   => true,
                    ),
						
				)
			);
			
			$this->sections[] = array(
				'icon'    => 'el-icon-bookmark',
				'title'   => __('Article options', 'redux-framework'),
				'heading' => __('Article options', 'redux-framework'),
				'desc'    => __('<p class="description">Select how to show in the single article.</p>', 'redux-framework'),
				'fields'  => array(
				
                    array(
                        'id'        => 'single-featured-content',
                        'type'      => 'button_set',
                        'title'     => __('Show post s featured image/video/quote', 'redux-framework'),
                        'subtitle'  => __('How to show featured image/video/quote', 'redux-framework'),
                        'options'   => array(
                            '0' => 'Full Width', 
                            '1' => 'In the Content'
                        ), 
                        'default'   => '0'
                    ),

                    array(
                        'id'        => 'single-author',
                        'type'      => 'switch',
                        'title'     => __('Show author', 'redux-framework'),
                        'subtitle'  => __('Show author name under the single article title.', 'redux-framework'),
                        'default'   => true,
                    ),
                    
                    array(
                        'id'        => 'single-categories',
                        'type'      => 'switch',
                        'title'     => __('Show categories', 'redux-framework'),
                        'subtitle'  => __('Show the categories list under the single article title.', 'redux-framework'),
                        'default'   => true,
                    ),
                    
                    array(
                        'id'        => 'single-comments',
                        'type'      => 'switch',
                        'title'     => __('Show comments count', 'redux-framework'),
                        'subtitle'  => __('Show comments count under the single article title.', 'redux-framework'),
                        'default'   => true,
                    ),
                    
                    array(
                        'id'        => 'single-date',
                        'type'      => 'switch',
                        'title'     => __('Show date', 'redux-framework'),
                        'subtitle'  => __('Show date under the single article title.', 'redux-framework'),
                        'default'   => true,
                    ),
                    
                    array(
                        'id'        => 'single-taglist',
                        'type'      => 'switch',
                        'title'     => __('Show the tags list', 'redux-framework'),
                        'subtitle'  => __('Show the list of tags in the end of the article single page.', 'redux-framework'),
                        'default'   => true,
                    ),
                    
                    array(
                        'id'        => 'single-authorarea',
                        'type'      => 'switch',
                        'title'     => __('Show a box with author info', 'redux-framework'),
                        'subtitle'  => __('A box with avatar, bio and social link in the end of the article.', 'redux-framework'),
                        'default'   => true,
                    ),
                    
                    array(
                        'id'        => 'single-relatedposts',
                        'type'      => 'switch',
                        'title'     => __('Show related posts', 'redux-framework'),
                        'subtitle'  => __('Some related post at the end of the article.', 'redux-framework'),
                        'default'   => true,
                    ),

                    array(
                        'id'        => 'single-sidebar',
                        'type'      => 'switch',
                        'title'     => __('Show sidebar', 'redux-framework'),
                        'subtitle'  => __('You can select to show/hide sidebar', 'redux-framework'),
                        'default'   => true,
                    ),

                    array(
                        'id'        => 'single-dropcaps',
                        'type'      => 'switch',
                        'title'     => __('Show dropcaps', 'redux-framework'),
                        'subtitle'  => __('Show dropcaps to article first letter', 'redux-framework'),
                        'default'   => false,
                    ),

		
				)
			);
			
			$this->sections[] = array(
				'icon'    => 'el-icon-qrcode',
				'title'   => __('Code add', 'redux-framework'),
				'heading' => __('Code add', 'redux-framework'),
				'desc'    => __('<p class="description">Add your custom CSS and JS code in the site.</p>', 'redux-framework'),
				'fields'  => array(
			        
			        array(
						'id'		=> 'css-code',
						'type' 		=> 'ace_editor',
						'title' 	=> __('CSS Code', 'redux-framework'), 
						'subtitle' 	=> __('Paste your custom CSS code here.', 'redux-framework'),
						'mode' 		=> 'css',
			            'theme' 	=> 'monokai',
						'desc' 		=> 'Put your custom css code in the header.',
			            'default' 	=> ".simpleclassbyoptions{\nmargin: auto;\n}"
					),	        
			        
			        array(
						'id'		=> 'js-codes',
						'type' 		=> 'ace_editor',
						'title' 	=> __('Javascripts codes', 'redux-framework'), 
						'subtitle' 	=> __('(eg. Google Analytics)', 'redux-framework'),
						'mode' 		=> 'javascript',
			            'theme' 	=> 'chrome',
						'desc' 		=> 'Paste your codes here (after < body >).',
			            'default' 	=> ""
					),
					
				)
			);
			
			$this->sections[] = array(
				'icon'    => 'el-icon-hand-right',
				'title'   => __('Social link', 'redux-framework'),
				'heading' => __('Social networks links', 'redux-framework'),
				'desc'    => __('<p class="description">Your social networks links in the top right of the page.</p>', 'redux-framework'),
				'fields'  => array(
					
					array(
						'id'		=> 'facebook',
						'type' 		=> 'text',
						'title' 	=> __('Facebook profile', 'redux-framework'),
						'subtitle' 	=> __('Your Facebook profile url.', 'redux-framework'),
						'desc' 		=> __('ex. http://www.facebook.com/YOURNAME', 'redux-framework'),
						'validate' 	=> 'url',
						'default' 	=> ''
					),
						
					array(
						'id'		=> 'twitter',
						'type' 		=> 'text',
						'title' 	=> __('Twitter profile', 'redux-framework'),
						'subtitle' 	=> __('Your Twitter profile url.', 'redux-framework'),
						'desc' 		=> __('ex. http://www.twitter.com/YOURNAME', 'redux-framework'),
						'validate' 	=> 'url',
						'default' 	=> ''
					),
					
					array(
						'id'		=> 'instagram',
						'type' 		=> 'text',
						'title' 	=> __('Instagram profile', 'redux-framework'),
						'subtitle' 	=> __('Your Instagram profile url.', 'redux-framework'),
						'desc' 		=> __('ex. http://www.instagram.com/YOURNAME', 'redux-framework'),
						'validate' 	=> 'url',
						'default' 	=> ''
					),
					
					array(
						'id'		=> 'google',
						'type' 		=> 'text',
						'title' 	=> __('Google+ profile', 'redux-framework'),
						'subtitle' 	=> __('Your Google+ profile url.', 'redux-framework'),
						'desc' 		=> __('ex. http://plus.google.com/+YOURNAME', 'redux-framework'),
						'validate' 	=> 'url',
						'default' 	=> ''
					),
					
					array(
						'id'		=> 'flickr',
						'type' 		=> 'text',
						'title' 	=> __('Flickr! profile', 'redux-framework'),
						'subtitle' 	=> __('Your Flickr! profile url.', 'redux-framework'),
						'desc' 		=> __('ex. http://www.flickr.com/photos/YOURNAME', 'redux-framework'),
						'validate' 	=> 'url',
						'default' 	=> ''
					),
						
					array(
						'id'		=> 'vimeo',
						'type' 		=> 'text',
						'title' 	=> __('Vimeo profile', 'redux-framework'),
						'subtitle' 	=> __('Your Vimeo profile url.', 'redux-framework'),
						'desc' 		=> __('ex. http://www.vimeo.com/YOURNAME', 'redux-framework'),
						'validate' 	=> 'url',
						'default' 	=> ''
					),
						
					array(
						'id'		=> 'youtube',
						'type' 		=> 'text',
						'title' 	=> __('YouTube profile', 'redux-framework'),
						'subtitle' 	=> __('Your YouTube profile url.', 'redux-framework'),
						'desc' 		=> __('ex. http://www.youtube.com/user/YOURNAME', 'redux-framework'),
						'validate' 	=> 'url',
						'default' 	=> ''
					),
						
					array(
						'id'		=> 'pinterest',
						'type' 		=> 'text',
						'title' 	=> __('Pinterest profile', 'redux-framework'),
						'subtitle' 	=> __('Your Pinterest profile url.', 'redux-framework'),
						'desc' 		=> __('ex. http://www.pinterest.com/YOURNAME', 'redux-framework'),
						'validate' 	=> 'url',
						'default' 	=> ''
					),
					
					array(
						'id'		=> 'tumblr',
						'type' 		=> 'text',
						'title' 	=> __('Tumblr profile', 'redux-framework'),
						'subtitle' 	=> __('Your Tumbrl profile url.', 'redux-framework'),
						'desc' 		=> __('ex. http://YOURNAME.tumbrl.com', 'redux-framework'),
						'validate' 	=> 'url',
						'default' 	=> ''
					),
						
				)
			);
				
			$this->sections[] = array(
				'icon'    => 'el-icon-brush',
				'title'   => __('Theme styles options', 'redux-framework'),
				'heading' => __('Font, colors and styles options', 'redux-framework'),
				'desc'    => __('<p class="description">Customize the theme with your favorite fonts and colors.</p>', 'redux-framework'),
				'fields'  => array(
                    
                    array(
                        'id'        => 'opt-presets',
                        'type'      => 'image_select',
                        'presets'   => true,
                        'title'     => __('Predefinited Skins', 'redux-framework'),
                        'subtitle'  => __('A set of selected skin palettes.', 'redux-framework'),
                        'default'   => 0,
                        'desc'      => __('Select your favourite combination and save. You can also select your favorite colors from the options below.', 'redux-framework'),
                        'options'   => array(
                            '1'			=> array(
                            				'alt' 		=> 'Default', 
                            				'img' 		=> get_template_directory_uri().'/framework/redux-skins/default.png', 
                            				'presets' 	=> array(
                            					'primary-color'		=> '#2c3e50', 
                            					'secondary-color'	=> '#ffcc0d'
                            				)
                            			),
                            '2'     	=> array(
                            				'alt' 		=> 'Classic flat', 
                            				'img' 		=> get_template_directory_uri().'/framework/redux-skins/classicflat.png', 
                            				'presets'	=> array(
                            					'primary-color'		=> '#34495e', 
                            					'secondary-color'	=> '#16a085'
                            				)
                            			),
                            '3'     	=> array(
                            				'alt' 		=> 'Black white flat', 
                            				'img' 		=> get_template_directory_uri().'/framework/redux-skins/blackwhite.png', 
                            				'presets'	=> array(
                            					'primary-color'		=> '#000000', 
                            					'secondary-color'	=> '#999999'
                            				)
                            			),
                            '4'     	=> array(
                            				'alt' 		=> 'Pink', 
                            				'img' 		=> get_template_directory_uri().'/framework/redux-skins/pink.png', 
                            				'presets'	=> array(
                            					'primary-color'		=> '#633377', 
                            					'secondary-color'	=> '#db77ce'
                            				)
                            			),
                            '5'     	=> array(
                            				'alt' 		=> 'Seppia', 
                            				'img' 		=> get_template_directory_uri().'/framework/redux-skins/seppia.png', 
                            				'presets'	=> array(
                            					'primary-color'		=> '#5d5853', 
                            					'secondary-color'	=> '#D4BA8B'
                            				)
                            			),
                            '6'     	=> array(
                            				'alt' 		=> 'Romanic', 
                            				'img' 		=> get_template_directory_uri().'/framework/redux-skins/romanic.png', 
                            				'presets'	=> array(
                            					'primary-color'		=> '#331f12', 
                            					'secondary-color'	=> '#d35400'
                            				)
                            			),
                            			
                            '7'     	=> array(
                            				'alt' 		=> 'Mark 2', 
                            				'img' 		=> get_template_directory_uri().'/framework/redux-skins/mark2.png', 
                            				'presets'	=> array(
                            					'primary-color'		=> '#4B3F55', 
                            					'secondary-color'	=> '#D4A16B'
                            				)
                            			),
                            			
                        ),
                        'default'	=> 1
                    ),
					
					array(
						'id'		=> 'primary-color',
						'type' 		=> 'color',
						'title' 	=> __('Primary color of the theme.', 'redux-framework'), 
						'subtitle' 	=> __('Pick a color for the theme (default: #2c3e50).', 'redux-framework'),
						'default' 	=> '#2c3e50',
						'validate' 	=> 'color',
						'output'    => array(
								    	'background-color' => '.wp-paginate .current,section#chess article,section#breakingnews ul li div.cat,.woocommerce span.onsale, .woocommerce-page span.onsale,section#top',
								        'color'            => 'body,nav .wrapper #bars .fa-bars,.carousel .carousel-control i,.woocommerce input.button, .woocommerce .button,nav.woocommerce-pagination span.current a, nav.woocommerce-pagination ul li .page-numbers:hover, .woocommerce ul.products li .price .amount, .woocommerce #content input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover',
								        'border-color'	   => 'header .wrapper,section#content #main .wrapper, nav .wrapper #mainmenu,header .wrapper #logo,header .wrapper #sublogo,nav div.rowstyle,hr, .hr,section#content #main section.comments .commentlist li.comment:not(:first-child),section#content #main section.comments .commentlist li.comment:not(:last-child),section#breakingnews ul,.wpcf7 input[type="text"],.wpcf7 input[type="email"],.wpcf7 select,.wpcf7 textarea, .woocommerce #content input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover,section#content .wrapper,footer .wrapper,nav .wrapper',
								        'border-left-color' => 'section#breakingnews ul li div.cat:after'
								    	)
					),
					
					array(
						'id'		=> 'secondary-color',
						'type' 		=> 'color',
						'title' 	=> __('Secondary color of the theme.', 'redux-framework'), 
						'subtitle' 	=> __('Pick a color for the theme (default: #ffcc0d).', 'redux-framework'),
						'default' 	=> '#ffcc0d',
						'validate' 	=> 'color',
						'output'    => array(
								    	'background-color' => 'nav .wrapper #mainmenu li.menu-item-has-children ul.sub-menu,.countcomments,section#content #main .featimg .countcomments',
								        'color'            => 'a:hover, a:focus,section#top a:hover,#mainmenu > li > a:hover,.widget h4,section#content #main #featured p time,#content a:hover, #content a:focus,footer a:hover, footer a:focus,nav .wrapper #bars .fa-square,nav #respmenu a:hover,section#chess article .info ul,section#content aside .wrapper p time,#breakingnews a:hover, section#content #main #featured time,.carousel .textinfo, .woocommerce #content input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt, .woocommerce #content div.product p.price',
								        'border-color'	   => 'section#content aside .wrapper,section#content aside .wrapper,.woocommerce input.button a:hover,.woocommerce input.checkout-button, .woocommerce input.alt, .woocommerce #content input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt',
								        'border-bottom-color' => '.widget h4:before,#mainmenu li a.hover:before,section#content header.topinfo h1:after,section#content article .textinfo:after, section#content header.topinfo .textinfo:after,section#content #main section.comments h3:after,section#content.authors #users h2:after,section#content.authors h1:after,section#content article .textcontent a:hover, section#content header.topinfo .textcontent a:hover,section#content #main #featured h2:after,section#chess article .quote .textquote:after,section#content #main #articlelist article.format-quote .textquote:after,.textinfo:after,section#content #main .relatedposts h3:after,nav .wrapper #mainmenu li.menu-item-has-children > a.hover:before,.woocommerce h2:after,.woocommerce ul.products li h3:after',
								        'border-right-color'  => 'section#content #main .featimg .countcomments:after',
								        'border-top-color'    => '.widget h4:before',
								    	)
					),
                    
                    array(
                        'id'        => 'opt-background',
                        'type'      => 'background',
                        'title'     => __('Body Background', 'redux-framework'),
                        'subtitle'  => __('Body background with image, color, etc.', 'redux-framework'),
                        'output'    => array('body'),
                    ),
                    
                    /* --- home page --- */
					array(
                        'id'        => 'section-typography',
                        'type'      => 'section',
                        'title'     => __('Typography and text options', 'redux-framework'),
                        'indent'    => false // Indent all options below until the next 'section' option is set.
                    ),
                    
					array(
						'id'			=> 'headingsfont',
						'type'			=> 'typography', 
						'title'			=> __('Select headings font', 'redux-framework'),
						'google'		=> true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	=> true, // Select a backup non-google font in addition to a google font
						'subsets'		=> false, // Only appears if google is true and subsets not set to false
						'font-size'		=> true,
						'line-height'	=> true,
						'word-spacing'	=> true, // Defaults to false
						'letter-spacing'=> true, // Defaults to false
						'color'			=> false,
						'all_styles' 	=> true, // Enable all Google Font style/weight variations to be added to the page
						'output' 		=> array('h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6'), // An array of CSS selectors to apply this font style to dynamically
						'compiler'		=> array(''), // An array of CSS selectors to apply this font style to dynamically
						'units'			=> 'px', // Defaults to px
						'subtitle'		=> __('Select the options for the titles.', 'redux-framework'),
					),
					
					array(
						'id'			=> 'bodyfont',
						'type'			=> 'typography', 
						'title' 		=> __('Select body font', 'redux-framework'),
						//'compiler'=>true, // Use if you want to hook in your own CSS compiler
						'google'		=> true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	=> true, // Select a backup non-google font in addition to a google font
						//'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
						'subsets'		=> false, // Only appears if google is true and subsets not set to false
						'font-size'		=> true,
						'line-height'	=> false,
						//'word-spacing'=>true, // Defaults to false
						//'letter-spacing'=>true, // Defaults to false
						'color'			=> false,
						//'preview'=>false, // Disable the previewer
						'all_styles' 	=> true, // Enable all Google Font style/weight variations to be added to the page
						'output' 		=> array('body'), // An array of CSS selectors to apply this font style to dynamically
						'compiler' 		=> array(''), // An array of CSS selectors to apply this font style to dynamically
						'units'			=> 'px', // Defaults to px
						'subtitle'		=> __('Select the options for the body text.', 'redux-framework'),
					),
					
					array(
						'id'			=> 'menufont',
						'type'			=> 'typography', 
						'title' 		=> __('Select menu font', 'redux-framework'),
						//'compiler'=>true, // Use if you want to hook in your own CSS compiler
						'google'		=> true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	=> true, // Select a backup non-google font in addition to a google font
						//'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
						'subsets'		=> false, // Only appears if google is true and subsets not set to false
						'font-size'		=> true,
						'line-height'	=> false,
						//'word-spacing'=>true, // Defaults to false
						//'letter-spacing'=>true, // Defaults to false
						'color'			=> false,
						//'preview'=>false, // Disable the previewer
						'all_styles' 	=> true, // Enable all Google Font style/weight variations to be added to the page
						'output' 		=> array('nav .wrapper'), // An array of CSS selectors to apply this font style to dynamically
						'compiler' 		=> array(''), // An array of CSS selectors to apply this font style to dynamically
						'units'			=> 'px', // Defaults to px
						'subtitle'		=> __('Select the options for the menus.', 'redux-framework'),
					),
				)
			
			);
					
					

			$theme_info = '<div class="redux-framework-section-desc">';
			$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'redux-framework').'<a href="'.$this->theme->get('ThemeURI').'" target="_blank">'.$this->theme->get('ThemeURI').'</a></p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'redux-framework').$this->theme->get('Author').'</p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'redux-framework').$this->theme->get('Version').'</p>';
			$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$this->theme->get('Description').'</p>';
			$tabs = $this->theme->get('Tags');
			if ( !empty( $tabs ) ) {
				$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'redux-framework').implode(', ', $tabs ).'</p>';	
			}
			$theme_info .= '</div>';

			if(file_exists(dirname(__FILE__).'/README.md')){
			$this->sections['theme_docs'] = array(
						'icon' => ReduxFramework::$_url.'assets/img/glyphicons/glyphicons_071_book.png',
						'title' => __('Documentation', 'redux-framework'),
						'fields' => array(
							array(
								'id'=>'17',
								'type' => 'raw',
								'content' => file_get_contents(dirname(__FILE__).'/README.md')
								),				
						),
						
					);
			}//if 

			$this->sections[] = array(
				'type' 		=> 'divide',
			);

			$this->sections[] = array(
				'icon' 		=> 'el-icon-info-sign',
				'title' => __('Theme Information', 'redux-framework'),
				'desc' => __('<p class="description">Follow us on <a href="https://www.facebook.com/ThunderThemes?fref=ts">Facebook</a> or visit our <a href="http://www.thunderthemes.net/">website</a> for support.</p>', 'redux-framework'),
				'fields' => array(
					array(
						'id'=>'raw_new_info',
						'type' => 'raw',
						'content' => $item_info,
						)
					),   
				);

			if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
			    $tabs['docs'] = array(
					'icon' => 'el-icon-book',
					    'title' => __('Documentation', 'redux-framework'),
			        'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
			    );
			}

		}

		public function setHelpTabs() {

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args['help_tabs'][] = array(
			    'id' => 'redux-opts-1',
			    'title' => __('Theme Information 1', 'redux-framework'),
			    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework')
			);

			$this->args['help_tabs'][] = array(
			    'id' => 'redux-opts-2',
			    'title' => __('Theme Information 2', 'redux-framework'),
			    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework')
			);

			// Set the help sidebar
			$this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework');

		}


		/**
			
			All the possible arguments for Redux.
			For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

		 **/
		public function setArguments() {
			
			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
	            
	            // TYPICAL -> Change these values as you need/desire
				'opt_name'          	=> 'iw_opt', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'			=> $theme->get('Name'), // Name that appears at the top of your panel
				'display_version'		=> $theme->get('Version'), // Version that appears at the top of your panel
				'menu_type'          	=> 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'     	=> true, // Show the sections below the admin menu item or not
				'menu_title'			=> __( 'Old Paper Theme', 'redux-framework' ),
	            'page'		 	 		=> __( 'Old Paper Theme', 'redux-framework' ),
	            'google_api_key'   	 	=> 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII', // Must be defined to add google fonts to the typography module
	            'global_variable'    	=> '', // Set a different name for your global variable other than the opt_name
	            'dev_mode'           	=> false, // Show the time the page took to load, etc
	            'customizer'         	=> true, // Enable basic customizer support

	            // OPTIONAL -> Give you extra features
	            'page_priority'      	=> null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	            'page_parent'        	=> 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	            'page_permissions'   	=> 'manage_options', // Permissions needed to access the options panel.
	            'menu_icon'          	=> '', // Specify a custom URL to an icon
	            'last_tab'           	=> '', // Force your panel to always open to a specific tab (by id)
	            'page_icon'          	=> 'icon-themes', // Icon displayed in the admin panel next to your menu_title
	            'page_slug'          	=> '_options', // Page slug used to denote the panel
	            'save_defaults'      	=> true, // On load save the defaults to DB before user clicks save or not
	            'default_show'       	=> false, // If true, shows the default value next to each field that is not the default value.
	            'default_mark'       	=> '', // What to print by the field's title if the value shown is default. Suggested: *


	            // CAREFUL -> These options are for advanced use only
	            'transient_time' 	 	=> 60 * MINUTE_IN_SECONDS,
	            'output'            	=> true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	            'output_tag'            => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	            //'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
	            'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
	            

	            // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	            'database'           	=> '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	            
	        
	            'show_import_export' 	=> true, // REMOVE
	            'system_info'        	=> false, // REMOVE
	            
	            'help_tabs'          	=> array(),
	            'help_sidebar'       	=> '', // __( '', $this->args['domain'] );            
				);


			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.		
				
			$this->args['share_icons'][] = array(
			    'url' => 'https://www.facebook.com/ThunderThemes',
			    'title' => 'Like us on Facebook', 
			    'icon' => 'el-icon-facebook'
			);
	 
			// Panel Intro text -> before the form
			if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false ) {
				if (!empty($this->args['global_variable'])) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace("-", "_", $this->args['opt_name']);
				}
				$this->args['intro_text'] = sprintf( __('<p>If you need help see <a href="http://docs.thunderthemes.net/oldpaper/" target="_blank">Template Documentation</a></p>', 'redux-framework' ), $v );
			} else {
				$this->args['intro_text'] = __('<p>Thank you for purchasing one of our Premium Themes!</p>', 'redux-framework');
			}

			// Add content after the form.
			$this->args['footer_text'] = __('<p>A huge thank you for purchasing our WordPress Theme at ThemeForest.</p>', 'redux-framework');

		}
	}
	new Redux_Framework_sample_config();

}


/** 

	Custom function for the callback referenced above

 */
if ( !function_exists( 'redux_my_custom_field' ) ):
	function redux_my_custom_field($field, $value) {
	    print_r($field);
	    print_r($value);
	}
endif;

/**
 
	Custom function for the callback validation referenced above

**/
if ( !function_exists( 'redux_validate_callback_function' ) ):
	function redux_validate_callback_function($field, $value, $existing_value) {
	    $error = false;
	    $value =  'just testing';
	    /*
	    do your validation
	    
	    if(something) {
	        $value = $value;
	    } elseif(something else) {
	        $error = true;
	        $value = $existing_value;
	        $field['msg'] = 'your custom error message';
	    }
	    */
	    
	    $return['value'] = $value;
	    if($error == true) {
	        $return['error'] = $field;
	    }
	    return $return;
	}
endif;
