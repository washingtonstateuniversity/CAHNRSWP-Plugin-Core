<?php
class CAHNRSWP_Core_Query {
	
	/*
	 * @desc - Preforms query and returns array of items
	 * @param array $instance.
	 * @return array - Formatted items to display.
	*/
	public static function cwp_get_items( $instance ){
		
		
		
		$items = apply_filters( 'cwp_core_feed_items' , array() , $instance );
		
		if ( empty( $items ) ) {  
		
			switch ( $instance['feed_type'] ) {
				
				case 'static':
				
					if ( ! empty( $instance['insert_urls'] ) ) {
				
						$items = CAHNRSWP_Core_Query::cwp_get_static_items( $instance['insert_urls'] );
					
					}; // end if
					
					break;
				
				case 'dynamic':
				
					if ( ! empty( $instance['post_type'] ) ) { 
					
						$items = CAHNRSWP_Core_Query::cwp_get_dynamic_items( $instance );
					
					}; // end if
					
					break;
				
			}; // end switch
			
		}; // end if
		
		return $items;
		
	} // end method cwp_get_items
	
	/*
	 * @desc - Get items from array of URLs.
	 * @param array $url_array.
	 * @return array of objects - array of item obejcts
	*/
	public static function cwp_get_static_items( $url_array ) {
		
		$items = array();
		
		$site_url = get_site_url();
		
		foreach ( $url_array as $index => $url ) {
			
				if ( strpos( $url , $site_url ) !== false ) {
					
					$id =  url_to_postid( $url );
					
					
				}; // end if
				
				if ( $id ) {
					
					// Local Post
					
					$c_post = get_post( $id );
					
					$items[] = CAHNRSWP_Core_Query::cwp_get_item_from_post( $c_post );
					
				} else {
					
					// Remote Post
					
					$url_array = array( $url );
					
					$post_data = CAHNRSWP_Core_Query::cwp_get_url_rest_data( $url_array );
					
					if ( ! empty( $post_data ) ) {
						
						foreach ( $post_data as $index => $wp_rest_item ) {
							
							$items[] = CAHNRSWP_Core_Query::cwp_get_item_from_rest( $index , $wp_rest_item );
							
						}; // end foreach
						
					}; // end if
				
				}; // end if
				
		
		}; // end foreach
		
		return $items;
			
	} // end method cwp_get_static_items
	
	/*
	 * @desc - Get items from feed.
	 * @param array $instance.
	 * @return array of objects - array of item obejcts
	*/
	public static function cwp_get_dynamic_items( $instance ) {
		
		$items = array();
		
		if ( empty( $instance['feed_source'] ) || strpos( $instance['feed_source'] , get_site_url() ) !== false ) {	
		
			// Is local query 
			
			$query_args = CAHNRSWP_Core_Query::cwp_get_local_query( $instance );
			
			$the_query = new WP_Query( $query_args );
	
			if ( $the_query->have_posts() ) {
	
				while ( $the_query->have_posts() ) {
					
					$the_query->the_post();
					
				 	$items[] = CAHNRSWP_Core_Query::cwp_get_item_from_post( $the_query->post );
									
				}; // end while
				
			}; // end if
			
			wp_reset_postdata();		
			
		} else {
			
			// Is remote query 
			
			$query_args = CAHNRSWP_Core_Query::cwp_get_remote_query_args( $instance );
			
			$query_url = $instance['feed_source'] . 'wp-json/posts?' . $query_args;
			
			$response = wp_remote_get( $query_url );
			
			if ( ! is_wp_error( $response ) ){
				
				$body = wp_remote_retrieve_body( $response );
				
				$post_array = json_decode( $body , true );
				
				if ( ! empty( $post_array ) ) {
			
					foreach ( $post_array as $index => $wp_rest_item ) {
						
						$items[] = CAHNRSWP_Core_Query::cwp_get_item_from_rest( $index , $wp_rest_item );
						
					}; // end foreach
					
				}; // end if
				
			}; // end if
			
		}; // end if
		
		return $items;
		
	} // end method cwp_get_dynamic_items
	
	/*
	 * @desc - Get JSON from array of URLs.
	 * @param array $url_array.
	 * @return array - array of WP Rest post items.
	*/
	public static function cwp_get_url_rest_data( $url_array ) {
		
		$post_data = array();
		
		foreach ( $url_array as $url ){
			
			$response = wp_remote_get( $url . '?rest-ext=true' );
			
			if ( ! is_wp_error( $response  ) ){ 
					
				 $body = wp_remote_retrieve_body( $response );
				 
				 $post_array = json_decode( $body , true );
				 
				 if ( $post_array ){
					 
					 $post_data[] = $post_array;
					 
				 }; // end if
				
			}; // end if
			
		}; // end foreach
		
		return $post_data;
		
	} // end method cwp_get_rest_data
	
	/*
	 * @desc - Get item from rest data
	 * @param int $index - Index of current item
	 * @param array $wp_rest_item.
	 * @param array $instance.
	*/
	public static function cwp_get_item_from_rest( $index , $wp_rest_item , $instance = array() ) {
		
		$item = new stdClass();
		
		$item->content_type = ( ! empty( $wp_rest_item['type'] ) )? $wp_rest_item['type'] : '';
				
		$item->title = ( ! empty( $wp_rest_item['title'] ) )? $wp_rest_item['title'] : '';
			
		$item->content = ( ! empty( $wp_rest_item['content'] ) )? $wp_rest_item['content'] : '';
			
		$item->excerpt = ( ! empty( $wp_rest_item['excerpt'] ) )? $wp_rest_item['excerpt'] : '';
		
		$item->link = ( ! empty( $wp_rest_item['link'] ) )? $wp_rest_item['link'] : '';
		
		$item->author = ( ! empty( $wp_rest_item['author']['name'] ) )? $wp_rest_item['author']['name'] : '';
		
		$item->post_date = ( ! empty( $wp_rest_item['date'] ) )? $wp_rest_item['date'] : '';
		
		if ( ! empty( $wp_rest_item['featured_image']['attachment_meta']['sizes']['thumbnail']['url'] ) ) {
			
			$item->img = '<img src=" '
			 			. $wp_rest_item['featured_image']['attachment_meta']['sizes']['thumbnail']['url']
						. '" />';
						
			$item->img = apply_filters( 'post_thumbnail_html' , $item->img , false, false, 'thumbnail', array() );
			
		}; // end if
		
		return apply_filters( 'cwp_core_get_item_obj' , $item  );
		
	} // end cwp_get_item_from_rest
	
	/*
	 * @desc - Get item from WP Post data
	 * @param int $post - WP Post object
	 * @param bool $in_loop - is in loop.
	 * @return object - item object
	*/
	public static function cwp_get_item_from_post( $post , $in_loop = true ) {
		
		
		$item = new stdClass();
		
		if ( isset( $post->post_type ) ){
		
			$item->content_type = $post->post_type;
			
		} else {
			
			$item->content_type = '';
		};
		
		$item->title = apply_filters( 'the_title' ,  $post->post_title );
			
		$item->content = apply_filters( 'the_content' ,  $post->post_content );
			
		$item->excerpt = strip_tags( strip_shortcodes( apply_filters( 'the_excerpt' , get_post_field('post_excerpt', $post->ID ) ) ) );
		
		$item->link = get_permalink( $post->ID );
		
		$item->author = get_the_author( $post->ID );
		
		$item->post_date = get_the_date( 'F j, Y' , $post->ID );
		
		$item->img = get_the_post_thumbnail( $post->ID , 'thumbnail' );
		
		return apply_filters( 'cwp_core_get_item_obj' , $item  );
		
	} // end method cwp_get_item_from_post
	
	/*
	 * @desc - Construct a local query from instance data.
	 * @param array $instance - Instance settings
	 * @return array - WP_Query args.
	*/
	public static function cwp_get_local_query( $instance ){
		
		$query = array();
		
		if ( isset( $instance['post_type'] ) ) {
			
			$query['post_type'] = $instance['post_type'];
			
		};
		
		if ( isset( $instance['post__in'] ) ) {
			
			/*$query['post_in'][] = $instance['p'];*/
			$query['post__in'][] = $instance['post__in'];
			
			$query['order_by'][] = 'post__in';
			
		};
		
		if ( isset( $instance['tax_query'] ) && isset( $instance['tax_terms'] ) && $instance['tax_terms'] ){
			
			$query['tax_query'] = array(
				array(
					'taxonomy' => $instance['tax_query'],
					'field'    => 'name',
					'terms'    => explode( ',' , $instance['tax_terms'] ),
					),
			);
				
		};
		
		if ( isset( $instance['posts_per_page'] ) ) {
			
			if ( 'all' == $instance['posts_per_page'] ) $instance['posts_per_page'] = -1;
			
			$query['posts_per_page'] = $instance['posts_per_page'];
			
		}; 
		
		return $query;
		
	} // end method cwp_get_local_query
	
	/*
	 * @desc - Construct a remote WP Rest query from instance data.
	 * @param array $instance - Instance settings
	 * @return string - query string.
	*/
	public static function cwp_get_remote_query_args( $instance ){
		
		$query_args = array();
		
		if( isset( $instance['post_type'] ) ){
			
			$query_args[] = 'type=' . $instance['post_type'];
			
		}; // end if
		
		if ( isset( $instance['posts_per_page'] ) && $instance['posts_per_page'] ) {
			
			if ( 'all' == $instance['posts_per_page'] ) $instance['posts_per_page'] = -1;
			
			$query_args[] = 'posts_per_page=' .$instance['posts_per_page'];
			
		}; 
		
		return implode( '&' , $query_args );
		
	} // end method cwp_get_remote_query_args
	
	/*
	 * @desc - Unset items items that are not used in this instance.
	 * @param object $post - Modified post object.
	 * @param array $instance - Current item instance.
	*/
	public static function cwp_item_advanced( &$item , $instance ){
		
		if ( ! empty( $instance['no_link'] ) ) unset( $item->link ); 
		
		if ( ! empty( $instance['no_title'] ) ) unset( $item->title );
		
		if ( ! empty( $instance['no_text'] ) ) {
			
			unset( $item->content );
			
			unset( $item->excerpt );
			
		};
		
		if ( ! empty( $instance['show_content'] ) ) {
			
			$item->excerpt = $item->content;
			
		};
		
		if ( empty( $instance['show_date'] ) ) {
			
			unset( $item->post_date );
			
		}; 
		
		if ( empty( $instance['show_author'] ) ) {
			
			unset( $item->author );
			
		}; 
		
		if ( ! empty( $instance['short_excerpt'] ) ){
			
			$item->excerpt = wp_trim_words( $item->excerpt , 15 );
			
		} // end if
		 		
	} // end method cwp_post_obj_advanced
	
} // end class CAHNRSWP_Core_Query