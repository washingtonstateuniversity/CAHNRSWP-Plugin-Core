<?php

$item_link = ( isset( $item->link ) )? '<a href="' . $item->link . '" >' : '';

$item_link_end = ( isset( $item->link ) )? '</a>' : '';

$p = '<div class="cwp-accordion ' . $item->content_type . ' ' . CAHNRSWP_Core_Post_Display::cwp_display_post_css( $instance ) . '" >';

	if( isset( $item->title ) ){
	
		$p .= '<h4>';
		
			$p .= $item_link;
		  
			$p .= $item->title;
			
			$p .= $item_link_end; 
		 
		$p .= '</h4>';
	
	}; // end if
	
	$p .= '<div class="cwp-content" style="display: none">';	
				
		if ( isset( $item->content ) ){
	
			$p .= $item->content;
		
		} else if ( isset( $item->excerpt ) ) {
			
			$p .= $item->excerpt;
			
		}; // end if
	
	$p .= '</div>';

$p .= '</div>';

echo $p;