<?php

$p = '<div class="cwp-full' . $post->content_type . '" >';

	$p .= '<div class="cwp-content">';
	
		if( isset( $post->title ) ){
	
			$p .= '<h2>';
			
				$p .= $post_link;
			  
				$p .= $post->title;
				
				$p .= $post_link_end; 
			 
			$p .= '</h2>';
		
		}; // end if
		
		if( isset( $post->post_date ) || isset( $post->author ) ){
				
			$p .= '<div class="cwp-post-meta">';
	
				if( isset( $post->post_date ) ) $p .= '<span class="cwp-post-date">' . $post->post_date . '</span>';
				
				if( isset( $post->author ) ) $p .= '<span class="cwp-post-author">' . $post->author . '</span>';
			
			$p .= '</div>';
		
		}; // end if

		if( isset( $post->content ) ) {
			
			$p .= $post->content;
			
		} else if( isset( $post->excerpt ) ){
			
			$p .= $post->excerpt;
			
		}; // end if
	
	$p .= '</div>';

$p .= '</div>';

echo $p;