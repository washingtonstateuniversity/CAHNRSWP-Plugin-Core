<?php
class CAHNRSWP_Core_Content_Feed_Model {
	
	/*
	 * @desc - Sets default values for the instance.
	 * @param array @instance - Current instance.
	*/
	public function cwp_set_defaults( &$instance ){
		
		if ( ! isset( $instance['feed_type'] ) ){
			
			$instance['feed_type'] = 'static';
			
		}; // end if
		
		if ( ! isset( $instance['insert_urls'] ) || ! is_array( $instance['insert_urls'] ) ){
			
			$instance['insert_urls'] = array();
			
		}; // end if
		
		if ( ! isset( $instance['feed_source'] ) || empty( $instance['feed_source'] ) ){ 
		
			$instance['feed_source'] = get_site_url();
		
		}; // end if
		
	} // end method cwp_set_defaults
	
} // end class CAHNRSWP_Core_Content_feed