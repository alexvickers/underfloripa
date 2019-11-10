<?php

	// widget authors photo
class iw_Authors_Photo extends WP_Widget {
	
	
	
	// Register widget
	
	public function __construct() {
		
		parent::__construct(
	 		'iw_authors_photo', // Base ID
			__( 'iW Authors Photo & Link', 'oldpaper' ), // Name
			array( 'description' => __( 'A gallery of blog autors with link.', 'oldpaper' ), ) // Args
		);
		
	}

	
	
	// Front-end display of widget
	
	public function widget( $args, $instance ) {
				
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$authors_number = $instance['authors_number'];
		
		echo $before_widget;
			
			echo $before_title . $title . $after_title;
            ?>
            
            <ul class="list-inline">
            
            <?php
			
			$users = array_merge( get_users('role=author'), get_users('role=administrator') );
		
			foreach($users as $q) :
			
			?>  
			                  
			<li>
				<?php if( count_user_posts($q->ID) > 0 ) : ?>
					<a href="<?php echo get_author_posts_url($q->ID);?>" title="<?php echo get_the_author_meta('display_name', $q->ID);?> page">  
					<?php echo get_avatar( $q->ID, 50 ); ?>
					</a>
				<?php else : ?>
					<?php echo get_avatar( $q->ID, 50 ); ?>
				<?php endif; ?>
			</li>
			  
			<?php 
			
			endforeach;
			
			?> 
					
		</ul>
		            
	    <?php 
		echo $after_widget;
		
	}
	
	
	
	// Sanitize widget form values as they are saved
	
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();

		// Strip tags to remove HTML. For text inputs and textarea.
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['authors_number'] = $new_instance['authors_number'];
		
		return $instance;
		
	}
	
	
	
	// Back-end widget form
	
	public function form( $instance ) {
		
		// Default widget settings.
		$defaults = array(
			'title' => 'Authors',
			'authors_number' => '10',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'oldpaper' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'authors_number' ); ?>"><?php _e('Number of authors:', 'oldpaper' ); ?></label>
			<input type="number" id="<?php echo $this->get_field_id( 'authors_number' ); ?>" name="<?php echo $this->get_field_name( 'authors_number' ); ?>" value="<?php echo $instance['authors_number'] ; ?>" class="widefat" />
		</p>
	<?php
	}

}
register_widget( 'iw_Authors_Photo' );