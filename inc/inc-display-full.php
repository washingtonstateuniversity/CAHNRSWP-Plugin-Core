<?php

$p = '<div class="cwp-full' . $item->content_type . ' ' . CAHNRSWP_Core_Post_Display::cwp_display_post_css( $instance , $item ) . '" >';

	$p .= '<div class="cwp-content">';
		
		if( isset( $item->post_date ) || isset( $item->author ) ){
				
			$p .= '<div class="cwp-post-meta">';
	
				if( isset( $item->post_date ) ) $p .= '<span class="cwp-post-date">' . $item->post_date . '</span>';
				
				if( isset( $item->author ) ) $p .= '<span class="cwp-post-author">' . $item->author . '</span>';
			
			$p .= '</div>';
		
		}; // end if

		if( isset( $item->content ) ) {
			
			$p .= $item->content;
			
		} else if( isset( $item->excerpt ) ){
			
			$p .= $item->excerpt;
			
		}; // end if
	
	$p .= '</div>';

$p .= '</div>';

echo $p;