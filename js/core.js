
jQuery( document ).ready( function( $ ) {
	/**
	 * @desc Checks to see if there is an existing instance of cahnrs_lb before
	 * creating a new one.
	*/
	if ( typeof cahnrs_lb == 'undefined' ) {
		
		function init_cahnrs_lb() {
			
			this.content_parent = '.cwp-item';
			
			this.content_wrap = 'cahnrs-lb-content';
			
			var self = this;
			
			/**
			 * @desc Handles all of the functions requiring the dom to be loaded as
			 * well as all of the events.
			*/
			
				
				$( 'body' ).on( 'click' , '.show-lightbox-content' , function( e ) {
					
					if ( $( this ).is( 'a' ) ) e.preventDefault(); // Stop default action for link
					
					var content = self.get_click_content( $( this )  );
					
					//self.show_lb( content , false );
					
				}); // end on click .show-lightbox-content 
				
			
			
			/**
			 * @desc Gets the content from a click/interacted item. 
			 *
			 * @param item_interacted object DOM object that was clicked/interacted with
			 * 
			 * @return object The DOM ojbect containing the content
			*/ 
			self.get_click_content = function( item_interacted ){
				
				var wrapper = item_interacted.parents( self.content_parent );
			
				var content_wrap = wrapper.find( '.' + self.content_wrap );
				
				//if ( content_wrap.length > 0 ) {
					
					//content = content_wrap;
					
				//} else {
				
					var type = item_interacted.attr( 'data-lbtype' );  
					
					if ( typeof type !== typeof undefined && type !== false ) {
						
						alert( type );
						
					} else {
					
						var href = item_interacted.attr('href');
						
						var data = self.content_from_url( href , wrapper ); 
						
						//wrapper.prepend('<div class="' + self.content_wrap + '" style="display:none;">' + data + '</div>' );
						
						//content = wrapper.find( '.' + self.content_wrap );
					
					}; // end if
					
				//}; // end if
				
				//return content;
				
			}; //end set_lb_content()
			
			/**
			 * @desc - Load content from url
			 *
			 * @param string $href - Url to load of content to load
			 * @return string - the content
			*/
			self.content_from_url = function( href , wrapper ) {
				
				var results= '';
				
				if ( typeof service_url !== 'undefined' ){
					
					results = $.get( 
						service_url, 
						{
							'cwpcore_service' : 'query',
							'display'         : 'full',
							'feed_type'       : 'static',
							'insert_urls[]'   : [
													href
												],
						},
						function( data ) {
							
							self.set_content( data , wrapper );
						
					}); // end get
					
				};// end if
				
			} // end content_from_url
			
			/*
			 * @desc - Takes contend and preps it for lightbox
			*/
			self.set_content = function( content , wrapper ) {
				
				wrapper.prepend('<div class="' + self.content_wrap + '" style="display:none;">' + content + '</div>' );
						
				content_obj = wrapper.find( '.' + self.content_wrap );
				
				self.show_lb( content_obj , false );
				
			}; // end method set_content
			
			/**
			 * @desc Initiates display of the lightbox
			 *
			 * @param object/string content_obj The content or DOM object containing the content
			 * @param string title The title used for the dialog box. A value of false will cause it
			 * to look for a the title attribute on content_obj. An empty string will be returned in
			 * the case of content_obj being a string.
			*/
			self.show_lb = function( content_obj , title ){
					
				content_obj.wrapInner( '<div class="cahnrs-dialog-content"></div>' )
				
				content = content_obj.find( '.cahnrs-dialog-content');
				
				if( !title ) {
					
					title = content_obj.attr( 'title' );
					
					if( 'undefined' === title ) {
					
						title = '';
						
					}; // end if
					
				}; // end if
				
				$( content ).dialog({
					modal: true,
					width: 700,
					title: title,
					buttons: {
						Close: function() {
							
							$( this ).dialog( "close" );
							
						}
					},
					close: function(){ 
					
						self.close_lb( content_obj , $( this ) ) 
					
					}
				}); // end .dialog*/
				
			}; // end show_lb
			
			self.close_lb = function( content_obj  , lightbox ){
				/* The following function was set up to store content
				 * instead of accessing it agaion - inactive for now
				*/ 
				
				//content_obj.html( lightbox.html() );
								
				lightbox.dialog( "close" );
								
				lightbox.dialog('destroy').remove();
				
			}; // end method self.close_lb
			
		}; // end init_cahnrs_lb
		
		var cahnrs_lb = new init_cahnrs_lb();
		
	} // end if cahnrs_lb
	
}); // end document ready