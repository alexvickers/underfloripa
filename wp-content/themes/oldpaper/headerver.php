<?php global $iw_opt; ?>

<header class="container">
		<div class="wrapper">
			<div class="row">
			
				<div class="col-sm-2 col-md-2 hidden-xs">
					<?php if($iw_opt['advleft'] or $iw_opt['advleftscript']) : ?>
						
						<?php if( $iw_opt['advleft']['url'] != '' ) : ?>
						
							<?php if( $iw_opt['advleftlink'] != '' ) : ?>
								<a href="<?php echo $iw_opt['advleftlink'] ?>">
								<img src="<?php echo $iw_opt['advleft']['url'] ?>" class="img-responsive advleft" alt="Advertising">
								</a>
							<?php else: ?>
								<img src="<?php echo $iw_opt['advleft']['url'] ?>" class="img-responsive advleft" alt="Advertising">
							<?php endif; ?>
						
						<?php else: ?>
						
							<?php echo($iw_opt['advleftscript']); ?>
						
						<?php endif; ?>
						
					<?php endif; ?>
				</div>
				
				<div class="col-sm-8 col-sm-offset-0   col-md-6 col-md-offset-1   col-xs-10 col-xs-offset-1">
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
				
				<div class="col-sm-2 col-sm-offset-0   col-md-2 col-md-offset-1   hidden-xs">
					<?php if($iw_opt['advright'] or $iw_opt['advrightscript']) : ?>
						
						<?php if( $iw_opt['advright']['url'] != '' ) : ?>
						
							<?php if( $iw_opt['advrightlink'] != '' ) : ?>
								<a href="<?php echo $iw_opt['advrightlink'] ?>">
								<img src="<?php echo $iw_opt['advright']['url'] ?>" class="img-responsive advright" alt="Advertising">
								</a>
							<?php else: ?>
								<img src="<?php echo $iw_opt['advright']['url'] ?>" class="img-responsive advright" alt="Advertising">
							<?php endif; ?>
						
						<?php else: ?>
						
							<?php echo($iw_opt['advrightscript']); ?>
						
						<?php endif; ?>
						
					<?php endif; ?>
				</div>
				
			</div>
		</div>
	</header>