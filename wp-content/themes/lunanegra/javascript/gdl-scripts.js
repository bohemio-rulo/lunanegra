jQuery(document).ready(function(){
	
	// Search Default text
	jQuery('.search-text input').live("blur", function(){
		var default_value = jQuery(this).attr("data-default");
		if (jQuery(this).val() == ""){
			jQuery(this).val(default_value);
		}	
	}).live("focus", function(){
		var default_value = jQuery(this).attr("data-default");
		if (jQuery(this).val() == default_value){
			jQuery(this).val("");
		}
	});	

	// Social Hover
	jQuery("#gdl-social-icon .social-icon").hover(function(){
		jQuery(this).animate({ opacity: 0.55 }, 150);
	}, function(){
		jQuery(this).animate({ opacity: 1 }, 150);
	});
	
	// Accordion
	var gdl_accordion = jQuery('ul.gdl-accordion');
	gdl_accordion.find('li').not('.active').each(function(){
		jQuery(this).children('.accordion-content').css('display', 'none');
	});
	gdl_accordion.find('li').click(function(){
		if( !jQuery(this).hasClass('active') ){
			jQuery(this).addClass('active').children('.accordion-content').slideDown();
			jQuery(this).siblings('li').removeClass('active').children('.accordion-content').slideUp();
		}
	});
	
	// Toggle Box
	var gdl_toggle_box = jQuery('ul.gdl-toggle-box');
	gdl_toggle_box.find('li').not('.active').each(function(){
		jQuery(this).children('.toggle-box-content').css('display', 'none');
	});
	gdl_toggle_box.find('li').click(function(){
		if( jQuery(this).hasClass('active') ){
			jQuery(this).removeClass('active').children('.toggle-box-content').slideUp();
		}else{
			jQuery(this).addClass('active').children('.toggle-box-content').slideDown();
		}
	});	
	
	// Tab
	var gdl_tab = jQuery('div.gdl-tab');
	gdl_tab.find('.gdl-tab-title li a').click(function(e){
		if( jQuery(this).hasClass('active') ) return;
		
		var data_tab = jQuery(this).attr('data-tab');
		var tab_title = jQuery(this).parents('ul.gdl-tab-title');
		var tab_content = tab_title.siblings('ul.gdl-tab-content');
		
		// tab title
		tab_title.find('a.active').removeClass('active');
		jQuery(this).addClass('active');
		
		// tab content
		tab_content.children('li.active').removeClass('active').css('display', 'none');
		tab_content.children('li[data-tab="' + data_tab + '"]').fadeIn().addClass('active');
		
		e.preventDefault();
	});
	
	// Scroll Top
	jQuery('div.scroll-top').click(function() {
		jQuery('html, body').animate({ scrollTop:0 }, { duration: 600, easing: "easeOutExpo"});
		return false;
	});
	
	// Blog Hover
	jQuery(".blog-media-wrapper.gdl-image img, .port-media-wrapper.gdl-image img, .gdl-gallery-image img").hover(function(){
		jQuery(this).animate({ opacity: 0.55 }, 150);
	}, function(){
		jQuery(this).animate({ opacity: 1 }, 150);
	});
	
	// Port Hover
	var portfolio_holder = jQuery(".portfolio-item-holder");
	portfolio_holder.each(function(){
		var margin_size = 30;
		if( jQuery(this).hasClass('jquery-filter') ){ margin_size = 20; }
		
		jQuery(this).find(".portfolio-item .portfolio-media-wrapper.gdl-image .thumbnail-hover").each(function(){
			jQuery(this).children().not('.portfolio-thumbnail-image-hover').css({ opacity: 0 });
		});
		jQuery(this).find(".portfolio-item .portfolio-media-wrapper.gdl-image .thumbnail-hover").hover(function(){
			var thumbnail_hover = jQuery(this);
			thumbnail_hover.animate({ opacity: 1, 'padding': margin_size + 'px', 'margin-top': '-' + margin_size + 'px', 'margin-left': '-' + margin_size + 'px' }, 150,
				function(){
					thumbnail_hover.children().not('.portfolio-thumbnail-image-hover').animate({ opacity: 1 }, 50);
				});
		}, function(){
			var thumbnail_hover = jQuery(this);
			thumbnail_hover.children().not('.portfolio-thumbnail-image-hover').animate({ opacity: 0 }, 50, function(){
				thumbnail_hover.animate({ opacity: 0, 'padding': '0px', 'margin-top': '0px', 'margin-left': '0px'  }, 150);
			});
			
			
		});
		
	});
	
	// Search Box
	var search_button = jQuery("#gdl-search-button");
	search_button.click(function(){
		if(jQuery(this).hasClass('active')){
			jQuery(this).removeClass('active');
			jQuery(this).siblings('.search-wrapper').slideUp(200);
		}else{
			jQuery(this).addClass('active');
			jQuery(this).siblings('.search-wrapper').slideDown(200);
		}
		return false;
	});
	jQuery("#gdl-search-button, .search-wrapper").click(function(e){
		if (e.stopPropagation){ e.stopPropagation();
		}else if(window.event){ window.event.cancelBubble = true; }
	});
	jQuery(document).click(function(){
		search_button.removeClass('active');
		search_button.siblings('.search-wrapper').slideUp(200);			
	});	
	
	// JW Player Responsive
	responsive_jwplayer();
	function responsive_jwplayer(){
		jQuery('[id^="jwplayer"][id$="wrapper"]').each(function(){
			var data_ratio = jQuery(this).attr('data-ratio');
			if( !data_ratio || data_ratio.length == 0 ){
				data_ratio = jQuery(this).height() / jQuery(this).width();
				jQuery(this).css('max-width', '100%');
				jQuery(this).attr('data-ratio', data_ratio);
			}
			jQuery(this).height(jQuery(this).width() * data_ratio);
		});
	}
	jQuery(window).resize(function(){
		responsive_jwplayer();
	});

});
jQuery(window).load(function(){

	// Menu Navigation
	/*jQuery('#main-superfish-wrapper ul.sf-menu').supersubs({
		minWidth: 14.5, maxWidth: 27, extraWidth: 3.5
	}).superfish({
		delay: 400, speed: 'fast', animation: {opacity:'show',height:'show'}
	});*/

	// Center the portfolio context
	function set_portfolio_context_position(){
		jQuery('div.portfolio-context').each(function(){
			var parent_height = jQuery(this).parent().height();
			var height = jQuery(this).height();
			jQuery(this).css('margin-top', parseInt((parent_height - height - 6) / 2) );
		});
	}
	set_portfolio_context_position();

	// Set Portfolio Max Height
	function set_portfolio_height(){
		jQuery('div.portfolio-item-holder').each(function(){
			var max_height = 0; 
			jQuery(this).children('.portfolio-item').height('auto');
			jQuery(this).children('.portfolio-item').each(function(){
				if( max_height < jQuery(this).height()){
					max_height = jQuery(this).height();
				}				
			});
			jQuery(this).children('.portfolio-item').height(max_height);
		});
	}
	setTimeout(function(){ set_portfolio_height(); }, 100);

	// Personnal Item Height
	function set_personnal_height(){
		jQuery(".personnal-item-holder .row").each(function(){
			var max_height = 0;
			jQuery(this).find('.personnal-item').height('auto');
			jQuery(this).find('.personnal-item-wrapper').each(function(){
				if( max_height < jQuery(this).height()){
					max_height = jQuery(this).height();
				}
			});
			jQuery(this).find('.personnal-item').height(max_height);
		});		
	}
	set_personnal_height();
	
	// Price Table Height
	function set_price_table_height(){
		jQuery(".price-table-wrapper .row").each(function(){
			var max_height = 0;
			jQuery(this).find('.best-price').removeClass('best-active');
			jQuery(this).find('.price-item').height('auto');
			jQuery(this).find('.price-item-wrapper').each(function(){
				if( max_height < jQuery(this).height()){
					max_height = jQuery(this).height();
				}
			});
			jQuery(this).find('.price-item').height(max_height);
			jQuery(this).find('.best-price').addClass('best-active');
		});		
	}	
	set_price_table_height();
	
	// When window resize, set all function again
	jQuery(window).resize(function(){
		set_portfolio_height()	
		set_personnal_height();
		set_price_table_height();
		set_portfolio_context_position();
	});	
	
});

