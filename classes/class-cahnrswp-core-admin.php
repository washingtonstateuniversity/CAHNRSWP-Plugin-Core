<?php
class CAHNRSWP_Core_Admin {
	
	/*
	 * @desc - Handles standard saving routine for post meta.
	 * @param int $post_id - ID of the post to update.
	 * @param string $nonce - Nonce id to check for.
	 * @param string $nonce_action - Nonce action to check for.
	 * @param string $meta_key - Meta Key to assign data to.
	 * @param string/array $meta_data - Meta data to be saved. 
	 * The data should already be cleaned prior to this method.
	*/
	protected function cwp_save_post_meta( $post_id , $nonce , $nonce_action , $meta_key , $meta_data ) {
		
		if( ! $this->cwp_check_perm( $nonce , $nonce_action ) ) return;
		
		update_post_meta( $post_id, $meta_key , $meta_data );
		
	} // end method cwp_save_post_meta
	
	protected function cwp_save_default_image( $post_id , $nonce , $nonce_action , $image_src ) {
		
		if( ! $this->cwp_check_perm( $nonce , $nonce_action ) ) return;
		
		update_post_meta( $post_id, '_default_img_src' , $image_src );
		
	} // end method cwp_save_default_image
	
	/*
	 * @ desc - Checks if current user can save.
	 * @return bool - TRUE if user can save, FALSE if not.
	*/
	public function cwp_check_perm( $nonce, $nonce_action ){
		
		if ( ! isset( $_POST[ $nonce ] ) ) return false;
		
		if ( ! wp_verify_nonce( $_POST[ $nonce ], $nonce_action ) ) return false;
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return false;
		
		if ( ! current_user_can( 'edit_post', $post_id ) ) return false;
		
		return true;
		
	}// end method cwp_save_post_meta
	
	
} // end class CAHNRSWP_Core_Admin