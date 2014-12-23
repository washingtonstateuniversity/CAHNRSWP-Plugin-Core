<?php
class CAHNRSWP_Core_Related_Links extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		
		parent::__construct(
			'cahnrswp_related_links', // Base ID
			'Related Links', // Name
			array( 'description' => 'Set of related links', ) // Args
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
			
		} // end if
		
		echo $args['after_widget'];
		
	}	

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		
		include CAHNRSWPCOREDIR . '/inc/inc-form-related-links.php';
		
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