(function($){

	var oldpaper = {};
	
	
	
	/*-----------------------------------------------------------------------------------*/
	/*	Define Functions
	/*-----------------------------------------------------------------------------------*/
	
	oldpaper.visibility = function() {
		
		$('.animated').css( 'opacity', 0 ); // because if js is disabled...
		
		var type;
		
		$('.animated').bind('inview', function(event, visible) {
			if (visible == true) {
				type = $(this).data('anim'); // use the info in the data-anim="{type}"
				$(this).addClass(type);
			}
		});
		
	};
	
	oldpaper.responsivemenu = function(){
		
		$( '<ul id="respmenu" class="list-unstyled">' + $('#mainmenu').html() + '</ul>' ).appendTo('nav .wrapper');
		
		$('#bars').click(function(){
			$('#respmenu').slideToggle();
		});
		
		$('#respmenu').hide();
		
	};
	
	oldpaper.menu = function(){
		
		//$('#mainmenu .sub-menu').hide();
		
		$('#mainmenu li').hover(
			function(){
				$('>a', this).addClass('hover');
				$('>.sub-menu', this).stop(true, true).slideDown('fast');
			}, 
			function(){
				$('>a', this).removeClass('hover');
				$('>.sub-menu', this).slideUp('fast');
			}
		)
		
	};
	
	oldpaper.breakingnews = function(){
		
		if( $('section#breakingnews').length > 0 ){
			
			var max = $('section#breakingnews').find("li").length;
			var vis, nas;
			
			if(max>1){
				$("section#breakingnews li").hide();
			}
			
			visualizza(1);
			
		}
		
		function visualizza(n){
			
			if(n==1){ 	
				h = max;
			}else{
				h = n-1;
			}
			
			if (max>1){
				$('section#breakingnews li:nth-child('+n+')').fadeIn('slow');
				$('section#breakingnews li:nth-child('+h+')').hide();
			}
			
			if(n==max){ n=0; }
			
			setTimeout(function(){visualizza (n+1);} , 4000);
		
		}
		
	};
	
	/*-----------------------------------------------------------------------------------*/
	/*	Start Functions
	/*-----------------------------------------------------------------------------------*/
	
	$(window).load(function(){
	
		oldpaper.menu();
		oldpaper.responsivemenu();
		oldpaper.breakingnews();
		
	});
	
	$(document).ready(function() {
		
		$('#loader').fadeOut('slow', oldpaper.visibility());
		$('#featured').equalize({children: 'h3'});
		
	});
	
})(jQuery);