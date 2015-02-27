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
			case 'gallery':	
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
	
	public static function cwp_add_display_wrapper( $instance , $content , $css = '' ){
		
		if ( empty( $instance['tag'] ) ){
			
			$instance['tag'] = CAHNRSWP_Core_Post_Display::cwp_get_tag( $instance );
			
		};// end if
		
		$html = '<' . $instance['tag'] . ' class="' . $instance['display'] . ' cwp-item-content" style="' . $css . '">';
		
		$html .= $content;
		
		$html .= '</' . $instance['tag'] . '>';
		
		if( ! empty( $instance['show_accordion'] ) ) {
			
			$html = '<div class="cwp-section-accordion-content">' . $html . '</div>';
			
			$html = '<script type="text/javascript"> if( typeof cwp_section_accordion === "undefined" ){ var cwp_section_accordion = function(){ jQuery( "body" ).on( "click" , "a.cwp-section-accordion-link" , function( event ){ event.preventDefault();})};</script>';
			
		}; // end if
		
		return $html;
		
	} // end method cwp_display_wrapper
	
	
	
	/*public static function cwp_display_wrapper( $instance , $start = false , $css = '' ){
		
		
		if ( empty( $instance['tag'] ) ){
			
			$instance['tag'] = CAHNRSWP_Core_Post_Display::cwp_get_tag( $instance );
			
		};// end if
		
		
		
		
		if ( $start ){
			
			$tag = '<' . $instance['tag'] .' class="' . $instance['display'] . ' cwp-item-content" style="' . $css . '">';
			
			if ( ! empty( $instance['show_accordion'] ) ){
			
				$tag = '<div class="cwp-accordion-content">' . $tag;
			
			}; // end if
			
		} else {
	
			$tag = '</' . $instance['tag'] .'>';
			
			if ( ! empty( $instance['show_accordion'] ) ){
			
				$tag . '</div>';
			
			}; // end if
			
		} // end if
		
		return $tag;
		
	} // end method cwp_display_wrapper */
	
	/*
	 * @desc - Gets slideshow from instance
	 * @param array $instance
	 * @return array - Slideshow settings
	*/
 public static function cwp_get_slideshow_settings( $instance ) {
		
		$show_settings = array();
		
		// Slideshow Effects
		
		if ( ! empty( $instance['show_fx'] ) ) {
			
			$show_settings[] = 'data-cycle-fx=' . $instance['show_fx'];
			
		} else {
			
			$show_settings[] = 'data-cycle-fx=scrollHorz';
			
		}; // end if
		
		// Slideshow Delay
		
		if ( ! empty( $instance['show_delay'] ) ) {
			
			$show_settings[] = 'data-cycle-timeout=' . $instance['show_delay'];
			
		} else {
			
			$show_settings[] = 'data-cycle-timeout=0';
			
		}; // end if
		
		if ( ! empty( $instance['tag'] ) ) {
			
			$show_settings[] = 'data-cycle-slides="> ' . $instance['tag'] .'"';
			
		} else {
			
			$show_settings[] = 'data-cycle-slides="> div"';
			
		}; // end if
		
		if ( ! empty( $instance['show_id'] ) ){
			
			$show_settings[] = 'data-cycle-prev="#cycle-prev-' . $instance['show_id'] . '"';
			
        	$show_settings[] = 'data-cycle-next="#cycle-next-' . $instance['show_id'] . '"';
			
			$show_settings[] = 'data-cycle-pager="#pager-' . $instance['show_id'] . '"';
			
		}; // end if
		
		return $show_settings;
		
	} // end method function cwp_get_slideshow_settings
	
	/*
	 * @desc - get tag from set display
	 * @param array $instance
	 * @return string - html tag
	*/
	public static function cwp_get_tag( $instance ){
		
		if( ! empty( $instance['display'] ) ){
		
			switch ( $instance['display'] ){
				
				case 'list' :
				case 'promo-gallery' :
					$tag = 'ul';
					break;
				default:
					$tag = 'div';
					break;
				
			}; // end switch
			
		} else {
			
			$tag = 'div';
			
		}; // end if
		
		return $tag;
		
	} // end method cwp_get_tag
	
	public static function cwp_get_item_link( $item , $instance , $start = false ){
		
		if ( ! isset( $item->link ) ){
			
			$link = '';
			
		} else if( $start ) {
			
			$lb_class = ( ! empty( $instance['show_lightbox'] ) ) ? 'clb-action' : '';
			
			$link = '<a href="' . $item->link . '" class="' . $lb_class . '" >';
			
		} else {
			
			$link = '</a>';
			
		}; // end if
		
		return $link;
		
	} // end method cwp_get_tag
	 
	
	
} // end CAHNRWP_Core_Post