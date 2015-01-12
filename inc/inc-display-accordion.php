<?php

$post_link = ( isset( $post->link ) )? '<a href="' . $post->link . '" >' : '';

$post_link_end = ( isset( $post->link ) )? '</a>' : '';

$p = '<div class="cwp-accordion ' . $post->content_type . ' ' . $this->cwp_display_post_css( $instance ) . '" >';

	if( isset( $post->title ) ){
	
		$p .= '<h4>';
		
			$p .= $post_link;
		  
			$p .= $post->title;
			
			$p .= $post_link_end; 
		 
		$p .= '</h4>';
	
	}; // end if
	
	$p .= '<div class="cwp-content" style="display: none">';	
				
		if ( isset( $post->content ) ){
	
			$p .= $post->content;
		
		} else if ( isset( $post->excerpt ) ) {
			
			$p .= $post->excerpt;
			
		}; // end if
	
	$p .= '</div>';

$p .= '</div>';

echo $p;