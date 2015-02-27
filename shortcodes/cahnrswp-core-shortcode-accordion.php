<?php 
class CAHNRSWP_Core_Shortcode_Accordion {
	
	private $default_array = array( 
							'title' => '',
							'class' => '',
							);
	
	public function __construct(){
		
		add_shortcode( 'CWPACCORDION' , array( $this , 'cwp_render_shortcode' ) );
		
	} // End Method __construct
	
	
	public function cwp_render_shortcode( $instance , $content = null ) {
		
		$intstance = shortcode_atts( $this->default_array , $intstance );
		
		$html = '';
		
		if ( ! is_null( $content ) ) {
			
			$id = 'faq-' . rand( 0 , 100000 );
			
			$html .= '<a class="cwp-faq-link ' . $instance['class']. '" style="display: block;" href="#" id="' . $id . '">' . $instance['title'] . '</a>';
			
			$html .= '<div class="cwp-faq-content" style="display:none"><div class="inner-wrapper">' . do_shortcode( $content ) . '</div></div>'; 
			
			$html .= $this->cwp_get_script( $id );
			
		}; // end if
		
		return $html;
		
	} // End Method cwp_tab_content
	
	private function cwp_get_script( $id ) {
		
		ob_start(); ?><script type="text/javascript">
			if ( typeof jQuery !== 'undefined' ) { 
					jQuery( "body" ).on( "click" , "#<?php echo $id; ?>" , function( event ){ 
					event.preventDefault();
					jQuery( this ).toggleClass( 'cwp-active-faq' ).siblings( ".cwp-faq-link" ).removeClass( 'cwp-active-faq' );
					jQuery( this ).next(".cwp-faq-content").slideToggle("fast").siblings(".cwp-faq-content").slideUp("fast");	
				});
		 }</script><?php
		
		return ob_get_clean(); 
		
	} // end method cwp_get_script
	
	
};

$cahnrswp_core_shortcode_accordion = new CAHNRSWP_Core_Shortcode_Accordion();