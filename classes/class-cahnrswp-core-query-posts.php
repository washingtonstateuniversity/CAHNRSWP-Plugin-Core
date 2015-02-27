<?php 
class CAHNRWP_Core_Query_Posts {
	
	/*
	 * @desc - Construct a local query from instance data.
	 * @param array $instance - Instance settings
	 * @return array - WP_Query args.
	*/
	public function cwp_get_local_query( $instance ){
		
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
	 * @desc - Create custom modified post object from inside loop.
	 * @param object $post - WP Post object.
	 * @param array $instance - Current item instance.
	 * @return object - Modified post object.
	*/
	public function cwp_get_loop_post_obj( $post , $instance ){
		
		$post_obj = new stdClass();
		
		if ( isset( $post->post_type ) ){
		
			$post_obj->content_type = $post->post_type;
			
		} else {
			
			$post_obj->content_type = '';
		};
			
		$post_obj->title = get_the_title();
			
		$post_obj->content = get_the_content();
			
		$post_obj->excerpt = strip_shortcodes( get_the_excerpt() );
		
		$post_obj->link = get_permalink();
		
		$post_obj->author = get_the_author();
		
		$post_obj->post_date = get_the_date();
		
		$post_obj->img = get_the_post_thumbnail( $post->ID , 'thumbnail' );
		
		return apply_filters( 'cwp_core_get_post_obj' , $post_obj , $post );
		
	} // end cwp_get_loop_post_obj
	
	/*
	 * @desc - Unset items items that are not used in this instance.
	 * @param object $post - Modified post object.
	 * @param array $instance - Current item instance.
	*/
	public function cwp_post_obj_advanced( &$post , $instance ){
		
		if ( isset( $instance['no_link'] ) && $instance['no_link'] ) unset( $post->link ); 
		
		if ( isset( $instance['no_title'] ) && $instance['no_title'] ) unset( $post->title );
		
		if ( isset( $instance['no_text'] ) && $instance['no_text'] ) {
			
			unset( $post->content );
			
			unset( $post->excerpt );
			
		};
		
		if ( isset( $instance['show_content'] ) && $instance['show_content'] ) {
			
			$post->excerpt = $post->content;
			
		};
		
		if ( ! isset( $instance['show_date'] ) || ! $instance['show_date'] ) {
			
			unset( $post->post_date );
			
		}; 
		
		if ( ! isset( $instance['show_author'] ) || ! $instance['show_author'] ) {
			
			unset( $post->author );
			
		}; 
		
		if ( ! empty( $instance['short_excerpt'] ) ){
			
			$post->excerpt = wp_trim_words( $post->excerpt , 15 );
			
		} // end if
		 		
	} // end method cwp_post_obj_advanced
	
} // end CAHNRWP_Core_Query