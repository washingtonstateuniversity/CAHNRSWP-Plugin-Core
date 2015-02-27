<?php
/*
 * version: 0.0.1
*/

class CCL_Shortcode_Core {
	
	
	public function to_shortcode( $shortcode , $attrs , $content = null ) {
		
		$html = '';
		
		$html = '[' . $shortcode . ' ';
		
		foreach ( $attrs as $attr_key => $attr_value ){
			
			if ( is_array( $attr_value ) ){
				
				// handles if value is an array
				
				$html .= $attr_key . '="' . serialize( $attr_value ) . '" ';
				
			} else {
				
				$html .= $attr_key . '="' . $attr_value . '" ';
				
			}; // end if
			
		}; // end for each
		
		$html .= ' ]';
		
		if ( ! is_null( $content ) ){
			
			$html .=  $content . '[/' . $shortcode . ']';
			
		}; // end if
		
		return $html;
		
	} // end method to_shortcode
	
}