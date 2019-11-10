<?php global $iw_opt; ?>

<header class="container">
		<div class="wrapper">
			<div class="row">
				
				<div class="col-sm-12">
					<div id="logo" class="animated" data-anim="fadeInDown">
					<a title="<?php _e('Go back to home', 'oldpaper') ?>" href="<?php echo home_url();?>"><?php
					if(isset($iw_opt['logo']['url']) && $iw_opt['logo']['url'] != '') :
						echo '<img src="' . esc_url($iw_opt['logo']['url']) . '" alt="' . get_bloginfo('name') . '" class="img-responsive" />';
					else:
						bloginfo('name'); 
					endif;
					?></a>
					</div>
					
					<?php if( $iw_opt['showsublogoadd'] ): ?>
						<div id="sublogo" class="animated" data-anim="fadeInUp">
							<?php 
							if( $iw_opt['sublogoadd'] ) :
								echo $iw_opt['sublogoadd'];
							else:
								bloginfo('description');
							endif;
							?>
						</div>
					<?php endif;?>
				</div>
				
			</div>
		</div>
</header>