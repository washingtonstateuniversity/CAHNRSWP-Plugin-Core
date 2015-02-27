<?php
/*
 * version: 0.0.4
*/

class CCL_Admin_Post_Core {
	
	public function save_post( $post_id , $post_key , $data_type , $nonce ) {
		
		// Check edit permissions
		
		$can_edit = $this->check_can_edit( $post_id , $nonce );
		
		if ( ! $can_edit || 'can_edit' != $can_edit ) return;
		
		if ( ! is_array( $data_type ) ){
			
			$clean_data = $this->clean_by_type( $_POST[ $post_key ] , $data_type );
			
		} else {
			
			$clean_data = array();
			
			foreach ( $data_type as $data => $type ){
				
				if ( ! empty( $_POST[ $post_key ][ $data ] ) ){
					
					if ( is_array( $_POST[ $post_key ][ $data ] ) ){
						
					} else {
						
						$clean_data[ $data ] = $this->clean_by_type( $_POST[ $post_key ][ $data ] , $type );
						
					}; // end if
					
				}; // end if
				
			}; // end foreach
			
		}; // end if
		
		
		if ( ! is_null( $clean_data ) ){ 
		
			update_post_meta( $post_id , $post_key , $clean_data );
			
		}; // end if
		
	} // end method save_post
	
	private function clean_by_type( $data , $type ) {
		
		$clean = null;
		
		switch ( $type ){
			case 'text':
				$clean = sanitize_text_field( $data );
				break;
			case 'html':
				$clean = wp_kses_post( $data );
				break;
		}; // end switch
		
		return $clean;
		
	} // end method clean_by_type
	
	public function update_post_content( $control, $post_id , $html , $nonce ){
		
		// Check edit permissions
		
		$can_edit = $this->check_can_edit( $post_id , $nonce );
		
		if ( ! $can_edit || 'can_edit' != $can_edit ) return;
		
		remove_action( 'save_post_video', array( $control, 'save_post' ) );
				
		$post_data = array(
			'ID' 		   => $post_id,
			'post_content' => $html,	
			);
					
		wp_update_post( $post_data );
		
	}
	
	public function check_can_edit( $post_id , $nonce ){
		
		if( empty( $nonce ) ) return false;
		
		if ( ! isset( $_POST[ $nonce['key'] ] ) ) return false;
		
		//if ( ! wp_verify_nonce( 'video' , 'add_video' ) ) return;
		
		//var_dump( 'pass' );
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;
		
		if ( ! current_user_can( 'edit_post', $post_id ) ) return false;
		
		return 'can_edit';
		
	}
	
	public function to_shortcode( $shortcode , $attrs , $content = null ) {
		
		$html = '';
		
		$html .= '[' . $shortcode . ' ';
		
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