<?php

$has_image = ( isset( $item->img ) )? ' has-image' : '';

$p = '<div class="cwp-promo' 
	. $has_image 
	.' ' 
	. CAHNRSWP_Core_Post_Display::cwp_display_post_css( $instance , $item ) 
	. '" >';

	if( isset( $item->img ) ){
			
			if( isset( $item->link ) ) {
				
				 $p .= '<a href="' . $item->link . '" >';
				 
			};
		
			$p .= $item->img;
			
			if( isset( $item->link ) ) {
				
				 $p .= '</a>';
				 
			};
		
	}; // end if
	
	$p .= '<div class="cwp-promo-content">';
	
		$p .= '<h4>' . $item->title . '</h4>';
		
		$p .= $item->excerpt;
	
	$p .= '</div>';

$p .= '</div>';

echo $p;