<?php
class CAHNRSWP_Core_Content_Feed extends WP_Widget {
	
	private $model;
	
	private $view;

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		
		parent::__construct(
			'cahnrswp_content_feed', // Base ID
			'Content Feed', // Name
			array( 'description' => 'Feed Content dynamically or by URL ', ) // Args
		);
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-content-feed-model.php';
		
		$this->model = new CAHNRSWP_Core_Content_Feed_Model();
		
	} // end method __construct

	/**
	 * @desc - Outputs the content of the widget
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		
		$this->model->cwp_set_defaults( $instance );
		
		$items = CAHNRSWP_Core_Query::cwp_get_items( $instance );
		
		if ( $items ) {
		
			echo $args['before_widget'];
			
			if ( ! empty( $instance['title'] ) ){
				
				echo '<h3 class="cwp-widget-title">' . $instance['title'] . '</h3>';
				
			}; // end if
			
			echo CAHNRSWP_Core_Post_Display::cwp_display_wrapper( $instance , true );
			
			foreach ( $items as $item ) {
				
				CAHNRSWP_Core_Query::cwp_item_advanced( $item , $instance );
		
				CAHNRSWP_Core_Post_Display::cwp_display_post( $item , $instance );
				
			}; // end foreach
			
			echo CAHNRSWP_Core_Post_Display::cwp_display_wrapper( $instance );
				
			echo $args['after_widget'];
		
		}; // end if
		
	} // end method widget	

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-form-model.php';
		
		$form_model = new CAHNRSWP_Core_Form_Model();
		
		$this->model->cwp_set_defaults( $instance );
		
		include CAHNRSWPCOREDIR . '/inc/inc-form-content-feed.php';
		
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