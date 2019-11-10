<?php global $iw_opt; ?>

<header class="container">
		<div class="wrapper">
			<div class="row">
				
				<div class="col-sm-4 col-xs-12 header-left">
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
				
				<div class="col-sm-8 hidden-xs hidden-sm">
					<?php if($iw_opt['advlong'] or $iw_opt['advlongscript']) : ?>
						
						<?php if( $iw_opt['advlong']['url'] != '' ) : ?>
						
							<?php if( $iw_opt['advlonglink'] != '' ) : ?>
								<a href="<?php echo $iw_opt['advlonglink'] ?>">
								<img src="<?php echo $iw_opt['advlong']['url'] ?>" class="img-responsive advlong pull-right" alt="Advertising">
								</a>
							<?php else: ?>
								<img src="<?php echo $iw_opt['advlong']['url'] ?>" class="img-responsive advlong pull-right" alt="Advertising">
							<?php endif; ?>
						
						<?php else: ?>
						
							<span class="pull-right"><?php echo($iw_opt['advlongscript']); ?></span>
						
						<?php endif; ?>
						
					<?php endif; ?>
				</div>
				
			</div>
		</div>
	</header>