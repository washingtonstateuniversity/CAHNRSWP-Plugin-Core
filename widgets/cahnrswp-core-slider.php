<?php
class CAHNRSWP_Core_Slider extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		
		parent::__construct(
			'cahnrswp_slider', // Base ID
			'Slider Feed', // Name
			array( 'description' => 'Feed content in a dynamic slider.', ) // Args
		);
	} // end method __construct
	
	/*
	 * @desc - Sets default values for the widget
	 * @param array $instance - passed by reference
	*/
	public function widget_defaults( &$instance ){
		
		if( !isset( $instance['title'] ) ) $instance['title'] = '';
		
		if( !isset( $instance['post_type'] ) ) $instance['post_type'] = 'post';
		
		if( !isset( $instance['tax_query'] ) ) $instance['tax_query'] = 'category';
		
		if( !isset( $instance['tax_terms'] ) ) $instance['tax_terms'] = '';
		
		if( !isset( $instance['slide_count'] ) ) $instance['slide_count'] = 3;
		
		if( !isset( $instance['display'] ) ) $instance['display'] = 'promo-gallery';
		
		if( !isset( $instance['visible'] ) ) $instance['visible'] = 4;
		
		$instance['posts_per_page'] = $instance['slide_count'] * $instance['visible'];
		
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		
		$this->widget_defaults( $instance );
		
		$slider_id = rand( 100, 10000000 );
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-query-posts.php';
			
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-post-display.php';
		
		$cwp_query_posts = new CAHNRWP_Core_Query_Posts();
			
		$cwp_display_posts = new CAHNRSWP_Core_Post_display();
		
		echo $args['before_widget'];
		
		echo '<div class="cwp-slider slider-' . $instance['visible'] . '-visible" >';
		
		if ( $instance['title'] ){
			
			echo '<h2 class="cwp-widget-title">' . $instance['title'] . '</h2>';
			
		}; // end if
		
		echo '<a href="#" id="cycle-prev-' .$slider_id . '" class="cycle-prev"></a>';
			
		echo '<div class="cycle-pager" id="pager-' .$slider_id . '"></div>';
		
		echo '<a href="#" id="cycle-next-' .$slider_id . '" class="cycle-next"></a>';
		
		$posts = apply_filters( 'cwp_core_feed_post' , array() , $instance );
		
		/*
		 * Check if a set of posts already exist from cwp_core_feed_post. 
		 * If the filter returns a set of posts skip the query
		 * section below.
		*/
		
		if ( ! $posts ){
		
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
			
			$slider_data = array(
				'data-cycle-fx=scrollHorz',
				'data-cycle-timeout=0',
				//'data-cycle-carousel-visible=' . $instance['visible'],
				'data-cycle-slides="> div"',
				//'data-cycle-carousel-fluid=true',
				'data-cycle-prev="#cycle-prev-' .$slider_id . '"',
        		'data-cycle-next="#cycle-next-' .$slider_id . '"',
				'data-cycle-pager="#pager-' .$slider_id . '"',
			);
			
			echo '<div class="cwp-slider-wrap cycle-slideshow" ' . implode( ' ', $slider_data )  . '>';
			
			$slide_index = 0;
			
			foreach( $posts as $post_index => $post ){
				
				if( 0 === $slide_index ) {
					
					echo '<div class="cwp-slide">';
					
				};
				
				$post->index = $post_index;
				
				$cwp_query_posts->cwp_post_obj_advanced( $post , $instance );
				
				$cwp_display_posts->cwp_display_post( $post , $instance );
				
				if( ( $instance['visible'] - 1 ) === $slide_index || count( $posts ) == ( $post_index + 1 ) ) {
					
					echo '</div>';
					
					$slide_index = 0;
					
				} else {
					
					$slide_index++;
					
				}; // end if
				
			}; // end foreach
			
			echo '</div>';
			
		} // end if
		
		echo '</div>';
		
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
		
		include CAHNRSWPCOREDIR . '/inc/inc-form-slider-feed.php';
		
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