<?php
class CAHNRSWP_Core_Post_Admin {
	
	protected $meta_key;
	
	protected $key_array;
	
	private function cwp_clean_data(){
		
		$clean = array();
		
		foreach( $this->key_array as $key => $type ){
			
			switch( $type ){
				
				case 'text':
					$clean[ $key ] = sanitize_text_field( $_POST[ $this->meta_key ][$key] );
				
			};// end switch
			
		}; // end foreach
		
		return $clean;
		
	}
	
	protected function cwp_save_meta( $post_id , $nonce = '' ){
		
		//if ( ! isset( $_POST['variety_nonce'] ) ) return;
		
		//if ( ! wp_verify_nonce( $_POST['variety_nonce'], 'submit_variety' ) ) return;
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		
		$clean = $this->cwp_clean_data();
		
		update_post_meta( $post_id , $this->meta_key , $clean );
		
	}
	
}