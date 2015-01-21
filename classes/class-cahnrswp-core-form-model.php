<?php
class CAHNRSWP_Core_Form_Model {
	
	/*
	 * @desc - Gets registered post types.
	 * @param array $exclude - post types to exclude.
	 * @return array - post types.
	*/
	public static function cwp_get_post_types( $exclude = array() ){
		
		$exclude[] = 'revision';
		
		$exclude[] = 'nav_menu_item';
		
		$post_types = array();
		
		$registered_types = get_post_types( array() , 'objects' );
		
		foreach ( $registered_types as $post_typeid => $post_type ){
			
			
			if ( ! in_array( $post_typeid , $exclude ) ) {
				
				$post_types[ $post_typeid ] = $post_type->name;
				
			} // end if
			
		} // end foreach
		
		return apply_filters( 'cwp_core_get_post_types' , $post_types );
		
	} // end method cwp_get_post_types
	
	/*
	 * @desc - Sets basic defaults
	 * @param array $instance
	*/
	public static function cwp_set_core_defaults( &$instance ) {
		
		if ( ! isset( $instance['display'] ) ){ 
		
			$instance['display'] = 'promo';
		
		}; // end if
		
		if ( ! isset( $instance['per_row'] ) ){ 
		
			$instance['per_row'] = 4;
		
		}; // end if
		
		if( ! isset( $instance['no_img'] ) ){
			
			$instance['no_img'] = false;
			
		}; // end if
		
		if( ! isset( $instance['no_title'] ) ){
			
			$instance['no_title'] = false;
			
		}; // end if
		
		if( ! isset( $instance['no_text'] ) ){
			
			$instance['no_text'] = false;
			
		}; // end if
		
		if( ! isset( $instance['no_link'] ) ){
			
			$instance['no_link'] = false;
			
		}; // end if
		
		if( ! isset( $instance['show_content'] ) ){
			
			$instance['show_content'] = false;
			
		}; // end if
		
		if( ! isset( $instance['show_date'] ) ){
			
			$instance['show_date'] = false;
			
		}; // end if
		
		if( ! isset( $instance['show_author'] ) ){
			
			$instance['show_author'] = false;
			
		}; // end if
		
		if( ! isset( $instance['show_lightbox'] ) ){
			
			$instance['show_lightbox'] = false;
			
		}; // end if
		
		if( ! isset( $instance['css_hook'] ) ){
			
			$instance['css_hook'] = '';
			
		}; // end if
		
		if( ! isset( $instance['more_title'] ) ){
			
			$instance['more_title'] = '';
			
		}; // end if
		
		if( ! isset( $instance['more_url'] ) ){
			
			$instance['more_url'] = '';
			
		}; // end if
		
	} // end method cwp_set_core_defaults
	
} // end class CAHNRSWP_Core_Content_feed