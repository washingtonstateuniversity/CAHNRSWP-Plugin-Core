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

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		
		echo 'hello world';
		
	}	

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		
		$defaults = array(
			'post_type' => 'post',
			'display'   => 'promo',
			'count'     => 3,
		);
		
		$cwp_form = new CAHNRWP_Core_Form;
		
		$cwp_form->cwp_set_defaults( $defaults , $instance ); 
		
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