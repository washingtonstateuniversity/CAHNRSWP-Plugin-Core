<?php
class CAHNRSWP_Core_Slider_Model {
	
	/*
	 * @desc - Sets default values for the instance.
	 * @param array @instance - Current instance.
	*/
	public function cwp_set_defaults( &$instance ){
		
		if( !isset( $instance['title'] ) ) $instance['title'] = '';
		
		if( !isset( $instance['post_type'] ) ) $instance['post_type'] = 'post';
		
		if( !isset( $instance['tax_query'] ) ) $instance['tax_query'] = 'category';
		
		if( !isset( $instance['tax_terms'] ) ) $instance['tax_terms'] = '';
		
		if( !isset( $instance['slide_count'] ) ) $instance['slide_count'] = 3;
		
		if( !isset( $instance['display'] ) ) $instance['display'] = 'promo-gallery';
		
		if( !isset( $instance['visible'] ) ) $instance['visible'] = 4;
		
		$instance['posts_per_page'] = $instance['slide_count'] * $instance['visible'];
		
	} // end method cwp_set_defaults
	
} // end class CAHNRSWP_Core_Content_feed