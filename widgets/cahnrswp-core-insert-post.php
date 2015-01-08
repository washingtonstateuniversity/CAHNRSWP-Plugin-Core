<?php
class CAHNRSWP_Core_Insert_Post extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		
		parent::__construct(
			'cahnrswp_insert_post', // Base ID
			'Insert Post/Page', // Name
			array( 'description' => 'Insert Single Post/Page', ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		
		echo $args['before_widget'];
		
		if( isset( $instance['title'] ) && $instance['title'] ){
			
			echo '<h3>' . $instance['title'] . '</h3>';
			
		}
		
		if( !isset( $instance['display'] ) ) $instance['display'] = 'promo';
		
		$insert_post = apply_filters( 'cwp_core_feed_insert_post' , array() , $instance );
		
		if( !$insert_post ){
		
			$query = CAHNRWP_Core_Query::cwp_get_local_query( $instance );
			
			$the_query = new WP_Query( $query );
	
			if ( $the_query->have_posts() ) {
	
				while ( $the_query->have_posts() ) {
					
					$the_query->the_post();
					
					$post_obj = CAHNRWP_Core_Post::cwp_get_loop_post_obj( $the_query->post , $instance );
					
					$insert_post[] = $post_obj;
									
				}; // end while
				
			}; // end if
			
			wp_reset_postdata();
			
		} // end if !posts
		
		if ( $insert_post ) {
			
			if( 'list' == $instance['display'] ) echo '<ul>';
			
			foreach( $insert_post as $post ){
				
				CAHNRWP_Core_Post::cwp_post_obj_advanced( $post_obj , $instance );
				
				CAHNRWP_Core_Display::cwp_display_post( $post , $instance );
				
			}; // end foreach
			
			if( 'list' == $instance['display'] ) echo '</ul>';
			
		} // end if
		
		echo $args['after_widget'];
		
		echo CAHNRWP_Core_Display::cwp_display_js( $instance );
		
	}	

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		
		$cwp_form = new CAHNRWP_Core_Form;
		
		$post_types = $cwp_form->cwp_get_post_types();
		
		include CAHNRSWPCOREDIR . '/inc/inc-form-insert-post.php';
		
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