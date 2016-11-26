/* Scripts */
jQuery(document).ready(function($){
	
	
	/** Has js **/
	$('html').removeClass('no-js').addClass('js');
	
    /** Window width **/
	var windowWidth = $('#top').width(),
		$site_header = $('#site_header'),
		breakPointSmall = 480, //small screens break point
		breakPointMedium = 767; //medium screen break point
	
	
	/** Resize event **/
	$(window).resize(function(){
		var winW = $('#top').width();
		
		if (winW < breakPointMedium && $site_header.hasClass('newsletter-open')) {
			$site_header.removeClass('newsletter-open');
		}
	});
		
	
	//no validate no autocomplete
	$('.novalidate').attr('novalidate', 'novalidate');
	//$('.novalidate').attr('novalidate', 'novalidate').find('.frm_form_field input').attr('autocomplete', 'off');
	
	
	
	/** == Responsive media == **/
    var resize_embed_media = function(){

        $('iframe, embed, object').each(function(){

            var $iframe = $(this),
                $parent = $iframe.parent(),
                do_resize = false;
				
            if($parent.hasClass('embed-content')){
                do_resize = true;            
            }
			else if($iframe.parents('.so-panel').length) {
				$parent = $iframe.parents('.so-panel');
                do_resize = true;	
			}
            else {                
                
                $parent = $iframe.parents('.entry-content, .player');
                if($parent.length)
                    do_resize = true;				
            }
			
            if(do_resize) {
                var change_ratio = $parent.width()/$iframe.attr('width');
                $iframe.width(change_ratio*$iframe.attr('width'));
                $iframe.height(change_ratio*$iframe.attr('height'));
            }
        });
    };
	
    resize_embed_media(); // Initial page rendering
    $(window).resize(function(){		
		resize_embed_media();	
	});	
	
	
	
	
	/* Center logos  */
	function logo_vertical_center() {
				
		$('.logo-gallery').each(function(){
			
			var logoH = $(this).find('.logo').eq(0).parents('.bit').height() - 3;
			console.log(logoH);
			
			$(this).find('.logo-frame').find('span').css({'line-height' : logoH + 'px'})
		});		
	}

	imagesLoaded('#site_content', function(){
		logo_vertical_center();
	});

	$(window).resize(function(){
		logo_vertical_center();
	});
	
	
	/* Scroll */
	$('.local-scroll, .inpage-menu a').on('click', function(e){
		e.preventDefault();
		
		var full_url = $(this).attr('href'),
			trgt = full_url.split("#")[1],
			target = $("#"+trgt).offset();
					
		if (target.top) {			
			$('html, body').animate({scrollTop:target.top - 50}, 900);
		}
		
	});
	
	$('.tst-shape-block').responsiveEqualHeightGrid();
	
	/** Leyka custom modal **/
	var leykaTopPad = (windowWidth > 940) ? 120 : 66;
	
	$('#leyka-agree-text').easyModal({		
		hasVariableWidth : true,
		top : leykaTopPad,
		updateZIndexOnOpen: false,
		//transitionIn: 'animated zoomIn',
		//transitionOut: 'animated zoomOut',
		onClose : function(){  $('#leyka-agree-text').css('z-index', '0');},
		onOpen : function() { $('#leyka-agree-text').css('z-index', '3007483647'); }
	});
	
	$('body').on('click','.leyka-custom-confirmation-trigger', function(e){

		$('#leyka-agree-text').trigger('openModal');			
		e.preventDefault();
	});
	
	$('body').on('click', '.leyka-modal-close', function(e){
		
		$('#leyka-agree-text').trigger('closeModal');
	});
	
}); //jQuery
