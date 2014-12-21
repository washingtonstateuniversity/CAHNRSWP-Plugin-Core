<?php

$has_image = ( isset( $post->img ) )? ' has-image' : '';

$post_link = ( isset( $post->link ) )? '<a href="' . $post->link . '" >' : '';

$post_link_end = ( isset( $post->link ) )? '</a>' : '';

$p = '<div class="cwp-gallery' . $has_image .' ' . $post->content_type . '" >';

	if( isset( $post->img ) ){
		
		$p .= '<div class="cwp-image" >';
				
			$p .= $post_link;
		
			$p .= $post->img;
			
			$p .= $post_link_end;
		
		$p .= '</div>';
		
	}; // end if
	

	
	$p .= '<div class="cwp-content">';
	
		if( isset( $post->post_date ) || isset( $post->author ) ){
				
			$p .= '<div class="cwp-post-meta">';
	
				if( isset( $post->post_date ) ) $p .= '<span class="cwp-post-date">' . $post->post_date . '</span>';
				
				if( isset( $post->author ) ) $p .= '<span class="cwp-post-author">' . $post->author . '</span>';
			
			$p .= '</div>';
		
		}; // end if
	
		if( isset( $post->title ) ){
	
			$p .= '<h4>';
			
				$p .= $post_link;
			  
				$p .= $post->title;
				
				$p .= $post_link_end; 
			 
			$p .= '</h4>';
		
		}; // end if
				
		if( isset( $post->excerpt ) ){
	
			$p .= $post->excerpt;
		
		}; // end if
	
	$p .= '</div>';

$p .= '</div>';

echo $p;