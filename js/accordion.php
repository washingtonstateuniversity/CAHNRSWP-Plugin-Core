if ( typeof jQuery != "undefined" && typeof cwp_accordion == "undefined" ) {
	var init_cwp_accordion = function(){
        jQuery( "body").on( "click" , ".cwp-accordion:not('.on-hover') h4 a" , function( e ){
            e.preventDefault();
            var c = jQuery( this ).parent().siblings(".cwp-content");
            c.slideToggle( "fast");
        }); 
        jQuery( 'body' ).on( 'mouseover' , '.cwp-accordion.on-hover h4 a' , function(){
        	jQuery( this ).parent().siblings(".cwp-content").slideDown( 'fast')
        });
        jQuery( 'body' ).on( 'mouseout' , '.cwp-accordion.on-hover h4 a' , function(){
        	jQuery( this ).parent().siblings(".cwp-content").slideUp( 'fast')
        }); 
    };
    var cwp_accordion = new init_cwp_accordion();
}