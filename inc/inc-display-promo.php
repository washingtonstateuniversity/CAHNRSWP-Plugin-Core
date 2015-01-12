<?php

$has_image = ( isset( $post->img ) )? ' has-image' : '';

$p = '<div class="cwp-promo' . $has_image .' ' . $this->cwp_display_post_css( $instance , $post ) . '" >';

	if( isset( $post->img ) ){
			
			if( isset( $post->link ) ) {
				
				 $p .= '<a href="' . $post->link . '" >';
				 
			};
		
			$p .= $post->img;
			
			if( isset( $post->link ) ) {
				
				 $p .= '</a>';
				 
			};
		
	}; // end if
	
	$p .= '<div class="cwp-promo-content">';
	
		$p .= '<h4>' . $post->title . '</h4>';
		
		$p .= $post->excerpt;
	
	$p .= '</div>';

$p .= '</div>';

echo $p;