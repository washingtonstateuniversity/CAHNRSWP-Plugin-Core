var pagebuilder_form;

jQuery(document).ready(function( $ ){
	
	function init_pagebuilder_form() {
		
		/*
		 * @desc - Changes the class state of form sections based
		 * on selections above
		*/
		$( 'body' ).on( 'change' , '.dynamic-radio-field' , function() {
			
			var field_class = $( this ).data( 'field' );
			
			var form = $( this ).parents( '.cwp-form');
			
			var selected = form.find( '.' + field_class );
			
			selected.addClass( 'active-field' ).siblings( '.dynamic-field' ).removeClass( 'active-field' );
			
		}); // end on change
		
		$( 'body' ).on( 'change' , '.dynamic-select-field' , function() {
			
			var field_class = $( this ).find(':selected').data( 'field' );
			
			var form = $( this ).parents( '.cwp-form');
			
			var selected = form.find( '.' + field_class );
			
			selected.addClass( 'active-field' ).siblings( '.dynamic-field' ).removeClass( 'active-field' );
			
		}); // end on change
		
		$( 'body' ).on( 'click' , '.action-add-insert' , function( e ){
			
			e.preventDefault();
			
			var input = $( this ).siblings( 'input, select, textarea' );
			
			var input_name = input.data( 'addname' ) + '[]';
			
			var form_section = $( this ).parents( '.cwp-form-section');
			
			var add_wrapper = form_section.find('.add-insert');
			
			var insert_item = '<li class="add-insert-item">' + input.val() + '<input type="hidden" name="' + input_name + '" value="' + input.val() + '" /><a href="#"></a></li>';
			
			add_wrapper.prepend( insert_item );
			
			input.val( "" );
			
		}); // end on click
		
		$( 'body' ).on( 'click' , '.cwp-form-section-title' , function( e ){
			
			e.preventDefault();
			
			var form_section = $( this ).parents( '.cwp-form-section');
			
			form_section.find( '.cwp-form-section-content').slideDown( 'medium' );
			
			form_section.siblings( '.cwp-form-section' ).find( '.cwp-form-section-content').slideUp( 'medium' );
			
			
			
		}); // end on click 
		
	}; // end function init_pagebuilder_form
	
	pagebuilder_form = new init_pagebuilder_form();
	
});