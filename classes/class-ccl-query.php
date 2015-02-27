<?php
/*
 * version: 0.1.7
*/

class CCL_Query_Core {
	
	
	public function get_post_from_rest( $url , $args = array() ){
		
		$wp_rest_item = false;
	
		
		if ( strpos( $url , '?' ) !== false ){
			
			$clean_url = explode( '?' , $url );
			
			$url = $clean_url[0] . '?rest-ext=true&' . $clean_url[1];
			
		} else if( strpos( $url , '#' ) !== false ){
			
			$clean_url = explode( '#' , $url );
			
			$url = $clean_url[0] . '?rest-ext=true#' . $clean_url[1];
			
		} else {
			
			$url = $url . '?rest-ext=true';
			
		}// end if
		
		$response = wp_remote_get( $url );
		
			
		if ( ! is_wp_error( $response  ) ){ 
				
			 $body = wp_remote_retrieve_body( $response );
			 
			 $rest_item = json_decode( $body , true );
			 
			 if ( $rest_item ){
				 
				$wp_rest_item = $rest_item;
				 
			 }; // end if
			
		}; // end if
		
		return $wp_rest_item;
		
	}
	
	
	public function get_local_query( $instance ){
		
		$query = array();
		
		if ( isset( $instance['post_type'] ) ) {
			
			$query['post_type'] = $instance['post_type'];
			
		}
		
		if ( ! empty( $instance['s'] ) ){
			
			$query['s'] = $instance['s'];
			
		} // end if
		
		if ( isset( $instance['post__in'] ) ) {
			
			/*$query['post_in'][] = $instance['p'];*/
			$query['post__in'][] = $instance['post__in'];
			
			$query['order_by'][] = 'post__in';
			
		}
		
		if ( isset( $instance['tax_query'] ) && isset( $instance['tax_terms'] ) && $instance['tax_terms'] ){
			
			/*
			 * Tax_query seems to have an issue with two word categories
			*/
			$terms = explode( ',' , $instance['tax_terms'] );
			
			$term_ids = array();
			
			foreach ( $terms as $term ){
				
				$term_array = get_term_by( 'name' , $term, $instance['tax_query'] , 'ARRAY_A' );
				
				if ( ! empty( $term_array['term_id'] ) ){
					
					$term_ids[] = intval ( $term_array['term_id'] );
					
				} // end if
				
			} // end foreach
			
			$query['tax_query'] = array(
				array(
					'taxonomy' => $instance['tax_query'],
					'field'    => 'term_id',
					'terms'    => $term_ids,
					),
			);
				
		}
		
		if ( isset( $instance['posts_per_page'] ) ) {
			
			if ( 'all' == $instance['posts_per_page'] ) $instance['posts_per_page'] = -1;
			
			$query['posts_per_page'] = $instance['posts_per_page'];
			
		} 
		
		return $query;
		
	} // end method get_local_query 
	
}