<?php

	// widget Last Post with featured image
	
class iw_Last_Posts_Image extends WP_Widget {
	
	
	
	// Register widget
	
	public function __construct() {
		
		parent::__construct(
	 		'iw_last_posts', // Base ID
			__( 'iW Last posts', 'oldpaper' ), // Name
			array( 'description' => __( 'Your last blog post with featured image.', 'oldpaper' ), ) // Args
		);
		
	}

	
	
	// Front-end display of widget
	
	public function widget( $args, $instance ) {
				
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$posts_number = $instance['posts_number'];
		$hide_author = isset( $instance['hide_author'] ) ? $instance['hide_author'] : false;
		$hide_title = isset( $instance['hide_title'] ) ? $instance['hide_title'] : false;
		
		echo $before_widget;
			
			if ( ! $hide_title )
			if ( $title ) echo $before_title . $title . $after_title;
			
            ?>
            
            <?php
				
				$last_query = new WP_Query(
					array (
					 	'post_type' => 'post',
					 	'ignore_sticky_posts' => 1,
					 	'posts_per_page' => $posts_number
					 )
				);
				
				if($last_query->have_posts()):
					
					while ($last_query->have_posts()):
						$last_query->the_post();
						
						?>
						
						<div class="row">
							<div class="col-sm-4 col-xs-3">
								<?php if( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink() ?>">
										<?php the_post_thumbnail('thumbnail', array('class' => 'img-responsive h5')); ?>
									</a>
								<?php endif; ?>
							</div>
							
							<div class="col-sm-8 col-xs-9">
								<h5><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
								<p><time datetime="<?php the_time('Y-m-d'); ?>"><?php echo( get_the_date() ) ?></time>
								<?php if(!$hide_author) : ?><br><?php the_author() ?><?php endif; ?></p>
							</div>
						</div><!-- /.row -->
						<hr>
						
						<?php
					endwhile;
					
				endif;
				
				// restore original
				wp_reset_postdata();
			
			?>
            
	    <?php 
		echo $after_widget;
		
	}
	
	
	
	// Sanitize widget form values as they are saved
	
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();

		// Strip tags to remove HTML. For text inputs and textarea.
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_number'] = strip_tags( $new_instance['posts_number'] );
		$instance['hide_author'] = $new_instance['hide_author'];
		$instance['hide_title'] = $new_instance['hide_title'];
		
		return $instance;
		
	}
	
	
	
	// Back-end widget form
	
	public function form( $instance ) {
		
		// Default widget settings.
		$defaults = array(
			'title' => 'Last posts whit image',
			'posts_number' => '5',
			'hide_author' => false,
			'hide_title' => false,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'oldpaper' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_number' ); ?>"><?php _e('Number of posts', 'oldpaper' ); ?></label>
			<input type="number" id="<?php echo $this->get_field_id( 'posts_number' ); ?>" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" value="<?php echo $instance['posts_number'] ; ?>" class="widefat" />
		</p>
        <p>
			<input class="checkbox" type="checkbox" <?php if( $instance['hide_author'] == true ) echo 'checked'; ?> id="<?php echo $this->get_field_id( 'hide_author' ); ?>" name="<?php echo $this->get_field_name( 'hide_author' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'hide_author' ); ?>"><?php _e( 'Hide author name?', 'oldpaper' ); ?></label>
		</p>
        <p>
			<input class="checkbox" type="checkbox" <?php if( $instance['hide_title'] == true ) echo 'checked'; ?> id="<?php echo $this->get_field_id( 'hide_title' ); ?>" name="<?php echo $this->get_field_name( 'hide_title' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'hide_title' ); ?>"><?php _e( 'Hide title?', 'oldpaper' ); ?></label>
		</p>
	<?php
	}

}

register_widget( 'iw_Last_Posts_Image' );
