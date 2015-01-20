<?php

$item_link = ( isset( $item->link ) )? '<a href="' . $item->link . '" >' : '';

$item_link_end = ( isset( $item->link ) )? '</a>' : '';

if ( isset( $item->img ) && $item->img ) {
	
	$has_image = ' has-image';
	
} else {
	
	$has_image = false;
	
}; // end if

$p = '<div class="cwp-gallery cwp-post-item' . $has_image .' ' . $item->content_type . ' ' . CAHNRSWP_Core_Post_Display::cwp_display_post_css( $instance , $item ) . '" >';

	$p .= '<div class="cwp-post-item-wrapper">';

		if ( $has_image ){
			
			$p .= '<div class="cwp-image" >';
					
				$p .= $item_link;
				
				$p .= $item->img;
				
				$p .= $item_link_end;
			
			$p .= '</div>';
			
		}; // end if
		
		$p .= '<div class="cwp-content">';
		
			if ( isset( $item->post_date ) || isset( $item->author ) ){
					
				$p .= '<div class="cwp-post-meta">';
		
					if ( isset( $item->post_date ) ) $p .= '<span class="cwp-post-date">' . $item->post_date . '</span>';
					
					if ( isset( $item->author ) ) $p .= '<span class="cwp-post-author">' . $item->author . '</span>';
				
				$p .= '</div>';
			
			}; // end if
		
			if ( isset( $item->title ) ){
		
				$p .= '<h4>';
				
					$p .= $item_link;
				  
					$p .= $item->title;
					
					$p .= $item_link_end; 
				 
				$p .= '</h4>';
			
			}; // end if
					
			if ( isset( $item->excerpt ) ){
		
				$p .= $item->excerpt;
			
			}; // end if
		
		$p .= '</div>';
	
	$p .= '</div>';

$p .= '</div>';

echo $p;