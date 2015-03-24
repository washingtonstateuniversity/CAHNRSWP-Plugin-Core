if ( typeof clb === 'undefined' && typeof jQuery !== 'undefined' ) {
	
	function cahnrs_lb(){
		
		this.lbw;
		
		this.lbg;
		
		this.lbc;
		
		s = this;
		
		s.set_lb = function(){
			
			s.lbw = jQuery( '#clb-wrapper' );
			
			s.lbg = jQuery( '#clb-bg' );
			
			s.lbc = jQuery( '#clb-wrapper .clb-content' );
			
		};
		
		jQuery( document ).ready( function( jQuery ){
			
			if ( jQuery('#clb-bg').length < 1 ){
				
				var lb_html = s.get_lb();
				
				jQuery( 'body' ).append( lb_html );
				
				s.set_lb();
				
			}; // end if
			
			jQuery('body').on( 'click' , '#clb-bg, .clb-close' , function( event ){
				
				event.stopPropagation();
				
				if ( jQuery( this ).is( 'a' ) ){
					
					event.preventDefault();
					
				}; // end if
				
				s.close_lb();
				
			});
			
			jQuery('body').on( 'click' , '.clb-action' , function( event ){
				
				s.activate_lb( jQuery( this ) );
				
			});
			
		});
		
		s.activate_lb = function( c ){
				
			var url = s.get_url( c );
			
			if ( c.is( 'a' ) ) {
					
				event.preventDefault();
					
			}; // end if
			
			if ( url ){
			
				s.open_lb();
				
				jQuery.get( "", { cwpcore_service: "ajax" , source: url } , function( data ){
					
					s.set_content( data , 'title' );
					
				});
			
			};
				
		}; // end if
		
		s.get_url = function( c ){
			
			var url = false;
			
			if ( c.is( 'a' ) ) {
					
				var attr = c.attr( 'href' );
				
				if (typeof attr !== typeof undefined && attr !== false) {
					
					url = c.attr( 'href' );
					
				};
					
			} else {
				
				var attr = c.attr( 'data-source' );
				
				if (typeof attr !== typeof undefined && attr !== false) {
					
					url = c.data( 'source' );
					
				}
			
			}; // end if
			
			return url;
			
		};
		
		s.get_height = function(){
			
			var scrollpos = jQuery( document ).scrollTop();
			
			return scrollpos + 50; 
			
		};
		
		s.open_lb = function(){
			
			s.lbw.css( 'top' , s.get_height() + 'px' );
			
			s.lbg.fadeIn( 'fast' , function(){ s.lbw.fadeIn( 'fast' ) } );
			
		};
		
		s.close_lb = function(){
			
			s.lbw.fadeOut( 'fast' , function(){ s.lbg.fadeOut( 'fast' ) } );
			
			s.lbc.html( '' );
			
		};
		
		s.set_content = function( content , title ){
			
			var lb_title = s.lbw.find( '.clb-frame > header > div' );
			
			s.lbc.html( content );
			
		};
		
		s.get_lb = function(){
			
			var html = '<div id="clb-bg" style="display: none"></div>';
			
			html += '<div id="clb-wrapper" style="display:none">';
			
			html += '<div class="clb-frame">';
			
			html += '<header><div></div><a href="#" class="clb-close">Close x</a></header>';
			
			html += '<div class="clb-content">'
			
			html += '</div></div></div>';
			
			return html;
			
		};
		
	};
	
	var clb = new cahnrs_lb();
	
}

/*
 * @desc - Dynamically resize iframes with "dynamic-window" class
*/
if ( typeof jQuery !== 'undefined' ) {
	
	jQuery( document ).ready( function( jQuery ) {
		
		var cwp_dynamic_window_obj = function(){
			
			var s = this;
			
		}; // end cwp_dynamic_window_obj
		
		var cwp_dynamic_window = new cwp_dynamic_window_obj();
		
	}); // end document ready

}; // end if

jQuery( document ).ready( function( $ ) {
	jQuery( "body").on( "click" , ".cwp-accordion:not(.on-hover) h4 a" , function( e ){
		e.preventDefault();
		alert('fire');
		var c = jQuery( this ).parent().siblings(".cwp-content");
		c.slideToggle( "fast");
	}); 
        jQuery( 'body' ).on( 'mouseover' , '.cwp-accordion.on-hover h4 a' , function(){
        	jQuery( this ).parent().siblings(".cwp-content").slideDown( 'fast')
        });
        jQuery( 'body' ).on( 'mouseout' , '.cwp-accordion.on-hover h4 a' , function(){
        	jQuery( this ).parent().siblings(".cwp-content").slideUp( 'fast')
        }); 
    });
   
