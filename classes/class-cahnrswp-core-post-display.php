<?php
class CAHNRSWP_Core_Post_Display {
	
	/*
	 * @desc - Select proper post layout based on instance display.
	 * $param object $post - Modified post object.
	 * $param array $instance - Current item instance.
	*/
	public static function cwp_display_post( $item , $instance = array() ){
		
		if ( ! isset( $instance['display'] ) ) $instance['display'] = 'promo';
			
		switch ( $instance['display'] ){
			 
			case 'list':
			 	break;
				
			case 'promo-gallery':
				
				include CAHNRSWPCOREDIR . 'inc/inc-display-gallery.php';
				
				break;
				
			case 'full':
				include CAHNRSWPCOREDIR . 'inc/inc-display-full.php';
				break;
			case 'accordion':
				include CAHNRSWPCOREDIR . 'inc/inc-display-accordion.php';
				break;
				
			case 'promo':
			default:
				include CAHNRSWPCOREDIR . 'inc/inc-display-promo.php';
				break;
			 
		 };
	} // end cwp_display_post
	
	public static function cwp_display_post_css( $instance , $post = 'na' ){
		
		$class = array();
		
		if( isset( $instance['css_hook'] ) && $instance['css_hook'] ){
			
			$class[] = $instance['css_hook'];
			
		}; // end if
		
		if( isset( $instance['display_advanced'] ) && $instance['display_advanced'] ){
			
			$class[] = $instance['display_advanced'];
			
		}; // end if
		
		if ( isset( $instance['visible'] ) && 'na' != $post && isset( $post->index ) ) {
			
			$class[] = 'post-index-' . ( $post->index + 1 );
			
			if ( $post->index < $instance['visible'] ) $class[] = 'cwp-active';
			
		}; // end if
		
		return implode( ' ', $class );
	}
	
	public static function cwp_display_js( $instance ){
		
		$has_js = array( 'accordion' );
		
		if( isset( $instance['display'] ) && in_array( $instance['display'] , $has_js ) ){
			
			ob_start();
			
			include CAHNRSWPCOREDIR . 'js/' . $instance['display'] . '.php'; 
			
			return '<script>' . ob_get_clean() . '</script>';
			
		} else {
			
			return '';
			
		}

	}
	
	public static function cwp_display_wrapper( $instance , $start = false ){
		
		$tag = '';
		
		if ( $start ){
			
			switch ( $instance['display'] ){
				
				case 'list' :
				case 'promo-gallery' :
					$tag = '<ul class="' . $instance['display'] . '" >';
					break;
				
			}; // end switch
			
		} else {
			
			switch ( $instance['display'] ){
				
				case 'list' :
				case 'promo-gallery' :
					$tag = '</ul>';
					break;
					
			}; // end switch
			
		} // end if
		
		return $tag;
		
	} // end method cwp_display_wrapper
	
	
} // end CAHNRWP_Core_Post