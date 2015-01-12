<?php
class CAHNRSWP_Core_Feed extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		
		parent::__construct(
			'cahnrswp_feed', // Base ID
			'Feed', // Name
			array( 'description' => 'Feed Content ', ) // Args
		);
	}
	
	/*
	 * @desc - Sets default values for the widget
	 * @param array $instance - passed by reference
	*/
	public function widget_defaults( &$instance ){
		
		if( !isset( $instance['title'] ) ) $instance['title'] = '';
		
		if( !isset( $instance['post_type'] ) ) $instance['post_type'] = 'post';
		
		if( !isset( $instance['tax_query'] ) ) $instance['tax_query'] = 'category';
		
		if( !isset( $instance['tax_terms'] ) ) $instance['tax_terms'] = '';
		
		if( !isset( $instance['posts_per_page'] ) ) $instance['posts_per_page'] = 3;
		
		if( !isset( $instance['display'] ) ) $instance['display'] = 'promo';
		
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		
		$this->widget_defaults( $instance );
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-query-posts.php';
			
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-post-display.php';
		
		$cwp_query_posts = new CAHNRWP_Core_Query_Posts();
			
		$cwp_display_posts = new CAHNRSWP_Core_Post_Display();
		
		echo $args['before_widget'];
		
		if( isset( $instance['title'] ) && $instance['title'] ){
			
			echo '<h3>' . $instance['title'] . '</h3>';
			
		}
		
		if( !isset( $instance['display'] ) ) $instance['display'] = 'promo';
		
		$posts = apply_filters( 'cwp_core_feed_post' , array() , $instance );
		
		if( !$posts ){
		
			$query_args = $cwp_query_posts->cwp_get_local_query( $instance );
			
			$the_query = new WP_Query( $query_args );
	
			if ( $the_query->have_posts() ) {
	
				while ( $the_query->have_posts() ) {
					
					$the_query->the_post();
					
					$posts[] = $cwp_query_posts->cwp_get_loop_post_obj( $the_query->post , $instance );
									
				}; // end while
				
			}; // end if
			
			wp_reset_postdata();
			
		} // end if !posts
		
		if ( $posts ) {
			
			foreach( $posts as $post ){
				
				$cwp_query_posts->cwp_post_obj_advanced( $post , $instance );
				
				$cwp_display_posts->cwp_display_post( $post , $instance );
				
			}; // end foreach
			
		} // end if
		
		include CAHNRSWPCOREDIR . '/inc/inc-display-more-link.php';
		
		echo $args['after_widget'];
		
	}	

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		
		$this->widget_defaults( $instance );
		
		$cwp_form = new CAHNRWP_Core_Form;
		
		$post_types = $cwp_form->cwp_get_post_types();
		
		include CAHNRSWPCOREDIR . '/inc/inc-feed-form.php';
		
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		
		return $new_instance;
		// processes widget options to be saved
	}
}