<?php

/*

Template name: Authors page

*/

?>

<?php get_header() ?>
	
	<section id="content" class="container authors">						
		<div class="wrapper">
		
		<h1><?php the_title() ?></h1>
		
		<?php 
		    $roles = array('administrator', 'author');
		    $args = array(
		    'role'         => $role,
		    'exclude'      => array(3,4,6,9,10,13,14,15,16,17),
	 	); ?>

		<?php $users = get_users( $args ) ?>
		
		<div id="users">
		
		<?php 
		$count = 0;
		
		foreach($users as $q) : 
		
		
		if($count == 3){ echo '</div>'; $count = 0; }
		if($count == 0){ echo '<div class="row">'; }
		
		$count++;
		
		?>  
		                  
		    <div class="user col-sm-4 clearfix text-center">
		    	<div class="row">
		    		<div class="col-sm-10 col-sm-offset-1">
		    			
				        <div class="user-avatar">  
				            <?php if( count_user_posts($q->ID) > 0 ) : ?>
					            <a href="<?php echo get_author_posts_url($q->ID);?>" title="<?php echo get_the_author_meta('display_name', $q->ID);?> page">  
					            <?php echo get_avatar( $q->ID, 160 ); ?>
					            </a>
					        <?php else : ?>
					        	<?php echo get_avatar( $q->ID, 160 ); ?>
				            <?php endif; ?>
				        </div>
				        
				        <h2 class="user-name">
				        	<?php if( count_user_posts($q->ID) > 0 ) : ?>
					            <a href="<?php echo get_author_posts_url($q->ID);?>" title="<?php echo get_the_author_meta('display_name', $q->ID);?> page">  
						        <?php echo get_the_author_meta('display_name', $q->ID);?>  
						        </a>
					        <?php else : ?>
					        	<?php echo get_the_author_meta('display_name', $q->ID);?>
				            <?php endif; ?>
				        </h2>
				        
				        <ul class="social-links list-inline">
					        <?php if ( get_the_author_meta( 'url', $q->ID ) != '' )  { ?>
					            <li><a class="url-link" href="<?php echo esc_url( get_the_author_meta( 'user_url', $q->ID ) ); ?>">
					            <span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-globe fa-stack-1x fa-inverse"></i>
								</span>
					            </a></li>
					        <?php } ?>
					        
					        <?php if ( get_the_author_meta( 'twitter', $q->ID ) != '' )  { ?>
					            <li><a class="twitter-link" href="https://twitter.com/<?php echo wp_kses( get_the_author_meta( 'twitter', $q->ID ), null ); ?>">
					            <span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
								</span>
								</a></li>
					        <?php } ?>
					 
					        <?php if ( get_the_author_meta( 'facebook', $q->ID ) != '' )  { ?>
					            <li><a class="facebook-link" href="<?php echo esc_url( get_the_author_meta( 'facebook', $q->ID ) ); ?>">
					            <span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
								</span>
					            </a></li>
					        <?php } ?>
					 
					        <?php if ( get_the_author_meta( 'linkedin', $q->ID ) != '' )  { ?>
					            <li><a class="linkedin-link" href="<?php echo esc_url( get_the_author_meta( 'linkedin', $q->ID ) ); ?>">
					            <span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
								</span>
					            </a></li>
					        <?php } ?>
					 
					        <?php if ( get_the_author_meta( 'googleplus', $q->ID ) != '' )  { ?>
					            <li><a class="google-link" href="<?php echo esc_url( get_the_author_meta( 'googleplus', $q->ID ) ); ?>">
					            <span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-google-plus fa-stack-1x fa-inverse"></i>
								</span>
								</a></li>
					        <?php } ?>
					    </ul>
					    
					    <?php if (get_the_author_meta('description', $q->ID) != '') : ?>  
					    	<p><?php echo get_the_author_meta('description', $q->ID); ?></p>  
				        <?php endif; ?>
				        
		    		</div>
		    	</div>
		    </div>  
		  
		<?php 
		
		endforeach; 
		if($count != 0){ echo '</div>';}?>  
		
		</div>
			
		</div> <!-- /wrapper -->
	</section>
	
<?php get_footer() ?>
