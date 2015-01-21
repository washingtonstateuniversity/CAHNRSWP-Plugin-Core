<?php
class CAHNRSWP_Core_Slider_Model {
	
	/*
	 * @desc - Sets default values for the instance.
	 * @param array @instance - Current instance.
	*/
	public function cwp_set_defaults( &$instance ){
		
		if ( ! isset( $instance['feed_type'] ) ) $instance['feed_type'] = 'dynamic';
		
		if ( ! isset( $instance['insert_urls'] ) || ! is_array( $instance['insert_urls'] ) ){
			
			$instance['insert_urls'] = array();
			
		}; // end if
		
		if ( empty( $instance['feed_source'] ) ) $instance['feed_source'] = get_site_url();
		
		if( !isset( $instance['title'] ) ) $instance['title'] = '';
		
		if( !isset( $instance['post_type'] ) ) $instance['post_type'] = 'post';
		
		if( !isset( $instance['tax_query'] ) ) $instance['tax_query'] = 'category';
		
		if( !isset( $instance['tax_terms'] ) ) $instance['tax_terms'] = '';
		
		if( !isset( $instance['display'] ) ) $instance['display'] = 'promo-gallery';
		
		if( !isset( $instance['per_row'] ) ) $instance['per_row'] = 4;
		
		if( !isset( $instance['slide_count'] ) ) $instance['slide_count'] = 2;
		
		$instance['posts_per_page'] = $instance['slide_count'] * $instance['visible'];
		
		$instance['show_id'] = rand( 100, 10000000 );
		
		$instance['tag'] = CAHNRSWP_Core_Post_Display::cwp_get_tag( $instance );
		
	} // end method cwp_set_defaults
	
} // end class CAHNRSWP_Core_Content_feed