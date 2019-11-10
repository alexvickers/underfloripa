<?php /*

	@package WordPress
	@subpackage Excursion Theme by Thunderthemes.net

*/ ?>

<section class="comments" id="comments">
	<div class="row">
		<div class="col-sm-12">

<?php if ( post_password_required() ) : ?>

	<p><?php _e( 'This post is password protected. Enter the password to view any comments.', 'oldpaper' ); ?></p>
	
<?php return; endif; ?>

<h3>'<?php the_title() ?>' <?php comments_number( __('has no comments', 'oldpaper'), __('has 1 comment', 'oldpaper'), __('have % comments', 'oldpaper') ); ?></h3>

<?php if ( have_comments() ) : ?>
	
	<ol id="singlecomments" class="commentlist">
		<?php 
		
		wp_list_comments( array(
			'callback' 		=> 'iw_comment_format',
			'reply_text'	=> __('Reply', 'oldpaper'),
			'avatar_size'	=> 100,
			)
		); 
		
		?>
	</ol>
	
<?php else: 
	
	_e('Be the first to comment this post!', 'oldpaper');
	
endif;  ?>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :  ?>

	<div class="row pagelink">
		<div class="nav-previous col-sm-6">
			<?php previous_comments_link('<i class="fa fa-arrow-left"></i>'); ?>
		</div>
		<div class="nav-next col-sm-6">
			<?php next_comments_link('<i class="fa fa-arrow-right"></i>'); ?>
		</div>
	</div>
	
<?php endif;  ?>

<hr>

<?php if ( comments_open() ) : ?>
	
	<?php
		
		$comments_args = array(
			'fields'				=> apply_filters( 'comment_form_default_fields', array(
			
				'author' 	=> '<div class="row">
								<div class="name-field col-sm-4">
									<input type="text" name="author" placeholder="'.__( 'Name', 'oldpaper' ).'*" class="form-control" />
								</div>',
			
				'email'  	=> '<div class="email-field col-sm-4">
									<input type="email" name="email" placeholder="'.__( 'Email', 'oldpaper' ).'*" class="form-control" />
								</div>',
			
				'url'    	=> '<div class="website-field col-sm-4">
									<input type="url" id="url" name="url" placeholder="'.__( 'Website', 'oldpaper' ).'" class="form-control" />
								</div>
								</div>'
				)
			),
			
			'id_form' 				=> 'comment-form',
	        'id_submit' 			=> 'btn-submit',
	        
	        'title_reply'			=> '<div class="clear"></div>'.__( 'Would you like to share your thoughts?', 'oldpaper' ),
	        'title_reply_to'   		=> '<div class="clear"></div>'.__( 'Would you like reply to %s', 'oldpaper' ),
	        
	        'comment_field' 		=> '<div class="row">
	        								<div class="message-field col-sm-12">
	        								<textarea id="message" name="comment" id="textarea" rows="5" cols="30" placeholder="'.__( 'Enter your comment here...', 'oldpaper' ).'" class="form-control" rows="4"></textarea>
											</div>
										</div>',
			
			'label_submit' 			=> __( 'Post Comment' , 'oldpaper' ),
			'cancel_reply_link' 	=> '<br><button class="btn btn-danger btn-xs">'.__( 'Cancel reply', 'oldpaper' ).'</button>',
			
			'comment_notes_before' 	=> '<small class="comment-notes" style="margin-bottom:15px;display:block;">'.__( 'Your email address will not be published.', 'oldpaper' ) . '</small>',
			'comment_notes_after' 	=> '',
			
			'must_log_in' 			=> '<p class="must-log-in">'.sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'oldpaper' ), wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) ).'</p>',
			'logged_in_as' 			=> '<p class="logged-in-as">'.sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ).'</p>',
    
		);
		
		comment_form($comments_args);
	
	?>
	
<?php endif; ?>

		</div>
	</div>
</section>