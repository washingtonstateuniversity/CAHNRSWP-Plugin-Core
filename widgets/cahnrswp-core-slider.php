<?php
class CAHNRSWP_Core_Slider extends WP_Widget {
	
	private $model;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		
		parent::__construct(
			'cahnrswp_slider', // Base ID
			'Slider Feed', // Name
			array( 'description' => 'Feed content in a dynamic slider.', ) // Args
		);
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-slider-model.php';
		
		$this->model = new CAHNRSWP_Core_Slider_Model();
		
	} // end method __construct

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		
		$this->model->cwp_set_defaults( $instance );
		
		$items = CAHNRSWP_Core_Query::cwp_get_items( $instance );
		
		if ( $items ) {
		
			echo $args['before_widget'];
			
			include CAHNRSWPCOREDIR . '/inc/inc-display-slider.php';
				
			echo $args['after_widget'];
		
		}; // end if
		
	} // end method widget	 

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		
		$this->model->cwp_set_defaults( $instance );
		
		include CAHNRSWPCOREDIR . '/inc/inc-form-slider-feed.php';
		
	} // end method form

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