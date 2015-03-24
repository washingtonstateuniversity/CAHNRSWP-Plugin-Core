<?php
/*
 * version: 0.3.2
*/

class CCL_Query_Core {
	
	public function get_single_article( $url , $instance ){
		
		$article = array();
		
		$site_url = get_site_url();
		
		if ( strpos( $url , $site_url ) !== false ) {
			
			// check id and do local query
			
			$postid = url_to_postid( $url );
			
			if ( $postid ){
				
				global $post; // Catch for legacy pagebuilder
				
				$temp_post = $post; // Catch for legacy pagebuilder
				
				$post = get_post( $postid );
				
				$article = $this->get_article_from_post( $post , $instance );
				
				$post = $temp_post; // Catch for legacy pagebuilder
				
			} else {
				
				$wp_rest_item = $this->get_wp_rest_item( $url , $instance );
				
				$article = $this->get_article_from_wp_rest_item( $wp_rest_item , $instance );
				
			} // end if
			
		} else {
			
			// do WP Rest query
			
			$wp_rest_item = $this->get_wp_rest_item( $url , $instance );
				
			$article = $this->get_article_from_wp_rest_item( $wp_rest_item , $instance );
			
		} // end if
		
		return $article;
		
	} // end method get single article
	
	public function get_wp_rest_item( $url , $args = array() ){
		
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
	
	public static function set_article_advanced( &$article , $args ){
		
		if ( ! empty( $args['no_link'] ) ) {
			
			$article['link_start'] = '';
			
			$article['link_end'] = '';
			 
		} // end if
		
		if ( ! empty( $args['no_title'] ) ) unset( $article['title'] );
		
		if ( ! empty( $args['no_text'] ) ) {
			
			unset( $article['content'] );
			
			unset( $article['excerpt'] );
			
		};
		
		if ( ! empty( $args['show_content'] ) ) {
			
			$article['excerpt'] = $article['content'];
			
		};
		
		if ( empty( $args['show_date'] ) ) {
			
			unset( $article['post_date'] );
			
		}; 
		
		if ( empty( $args['show_author'] ) ) {
			
			unset( $article['author'] );
			
		}; 
		
		if ( ! empty( $args['short_excerpt'] ) ){
			
			$article['excerpt'] = wp_trim_words( $article['excerpt'] , 15 );
			
		} // end if
		 		
	} // end method cwp_post_obj_advanced
	
	public function get_article_from_post( $post , $instance = array() ){
		
		$instance = apply_filters( 'ccl_get_post_article_args' , $instance , $post );
		
		$fields = $this->get_article_display_fields( $instance );
		
		if ( in_array( 'img' , $fields ) ){
		
			$img_size = ( ! empty ( $instance['img_size'] ) )?  $instance['img_size'] : 'thumbnail';
		
		} // end if 
		
		$article = array();
		
		if ( in_array( 'type' , $fields ) ){
		
			$article['type'] = $post->post_type;
		
		} // end if
		
		if ( in_array( 'title' , $fields ) ){
				
			$article['title'] = apply_filters( 'the_title' , $post->post_title );
		
		} // end if
		
		if ( in_array( 'content' , $fields ) ){
			
			$article['content'] = apply_filters( 'the_content' , $post->post_content );
		
		} // end if
		
		if ( in_array( 'excerpt' , $fields ) ){
		
			if ( isset( $post->post_excerpt ) && $post->post_excerpt ){
				
				$article['excerpt'] = apply_filters( 'the_excerpt' , $post->post_excerpt );
			
			} else {
				
				$article['excerpt'] = wp_trim_words( strip_shortcodes( $article['excerpt'] ) , 35 );
				
			}// end if
		
		} // end if
		
		if ( in_array( 'img' , $fields ) ){
		
			$article['img'] = get_the_post_thumbnail( $post->ID , $img_size );
		
		} // end if
		
		if ( in_array( 'link' , $fields ) ){
			
			
			
			if ( ! empty ( $instance['more_url'] ) && ! empty ( $instance['more_rewrite'] ) && $instance['more_rewrite'] ){
		
				$article['link'] = $instance['more_url'];
			
			} else {
				
				$article['link'] = get_permalink( $post->ID );
				
			} // end if
			
			$article['link_start'] = $this->get_article_link( $article['link'] , $instance );
		
			$article['link_end'] = '</a>';
		
		} else {
			
			$article['link_start'] = '';
		
			$article['link_end'] = '';
			
		} // end if
		
		return $article;
		
	}
	
	public function get_article_from_wp_rest_item( $wp_rest_item , $args = array() ){
		
		$fields = $this->get_article_display_fields( $args );
		
		$article = array();
		
		if ( in_array( 'type' , $fields ) ){
		
			$article['type'] = ( ! empty( $wp_rest_item['type'] ) )? $wp_rest_item['type'] : '';
		
		}; // end if
		
		if ( in_array( 'title' , $fields ) ){
				
			$article['title'] = ( ! empty( $wp_rest_item['title'] ) )? $wp_rest_item['title'] : '';
		
		}; // end if
		
		if ( in_array( 'content' , $fields ) ){
			
			$article['content'] = ( ! empty( $wp_rest_item['content'] ) )? $wp_rest_item['content'] : '';
		
		}; // end if
		
		if ( in_array( 'excerpt' , $fields ) ){
			
			$article['excerpt'] = ( ! empty( $wp_rest_item['excerpt'] ) )? $wp_rest_item['excerpt'] : '';
		
		}; // end if
		
		if ( in_array( 'link' , $fields ) ){
		
			$article['link'] = ( ! empty( $wp_rest_item['link'] ) )? $wp_rest_item['link'] : '';
		
			$article['link_start'] = $this->get_article_link( $article['link'] , $args );
		
			$article['link_end'] = ( ! empty( $wp_rest_item['link'] ) )? '</a>' : '';
		
		}; // end if
		
		if ( in_array( 'author' , $fields ) ){
		
			$article['author'] = ( ! empty( $wp_rest_item['author']['name'] ) )? $wp_rest_item['author']['name'] : '';
		
		}; // end if
		
		if ( in_array( 'date' , $fields ) ){
		
			$article['date'] = ( ! empty( $wp_rest_item['date'] ) )? $wp_rest_item['date'] : '';
		
		}; // end if
		
		if ( in_array( 'img' , $fields ) ){
		
			if ( ! empty( $wp_rest_item['featured_image']['attachment_meta']['sizes']['thumbnail']['url'] ) ) {
				
				$article['img'] = '<img src=" '
							. $wp_rest_item['featured_image']['attachment_meta']['sizes']['thumbnail']['url']
							. '" />';
							
				$article['img'] = apply_filters( 'post_thumbnail_html' , $article['img'] , false, false, 'thumbnail', array() );
				
			}; // end if
		
		}; // end if
		
		return apply_filters( 'get_ccl_article' , $article , $args );
		
	}
	
	public function get_article_link( $link , $instance = array() ) {
		
		$class = array();
		
		$html = '<a href="' . $link . '" ';
		
		if( ! empty( $instance['show_lightbox'] ) ){
		
			$html .= 'class="clb-action" ';
			
		} // end if
		
		if( ! empty( $instance['new_window'] ) ){
			
			$html .= 'target="_blank" ';
			
		} // end if
		
		$html .= ' >';
		
		return $html;
		
	} 
	
	public function get_article_display_fields( $instance ){
		
		$fields = array();
		
		if( empty( $instance['display'] ) )  $instance['display'] = 'promo';
		
		switch ( $instance['display'] ){
			case 'accordion':
				$fields = array( 'type','title','content','link');
				break;
			case 'promo':
			default:
				$fields = array( 'type','title','excerpt','link','img' );
				break;
		} // end swicth
		
		return $fields;
		
	} // end method get_article_display_fields
	
	
	
	public function get_query_from_post(){
		
		$query = array();
		
		$query_keys = array( 
			'p', 
			'posts_per_page', 
			'order', 
			'orderby',
			'post_type',
			'category__and',
			's',
			'offset', 
		);
		
		foreach( $query_keys as $qk ){
			
			if ( ! empty( $_POST[ $qk ] ) ){
				
				if ( is_array( $_POST[ $qk ] ) ) {
					
					foreach( $_POST[ $qk ] as $val ){
						
						$query[ $qk ][] = sanitize_text_field( $val );
						
					} // end foreach
					
				} else {
					
					$query[ $qk ] = sanitize_text_field( $_POST[ $qk ] );
					
				} // end if
				
			} // end if
			
		} // end foreach
		
		return $query;
	}
	
	
	
	
	
	
	
	
	
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