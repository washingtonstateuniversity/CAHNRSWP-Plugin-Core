<?php
class Widget_CAHNRSWP_Core_Content_Feed extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-content-feed.php';
		
		$this->defaults['feed_source'] = get_site_url();
		
		parent::__construct(
			'cahnrswp_content_feed', // Base ID
			'Content Feed', // Name
			array( 'description' => 'Feed Content dynamically or by URL ', ) // Args
		);
		
	} // end method __construct

	/**
	 * @desc - Outputs the content of the widget
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		
		$content_feed = new CAHNRSWP_Core_Content_Feed( $instance );
		
		$title = $content_feed->cwp_get_title();
		
		$html = $content_feed->cwp_get_feed();
		
		echo $args['before_widget'];
		
		echo $title . $html;
		
		echo $args['after_widget'];
		
	} // end method widget	

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		
		$content_feed = new CAHNRSWP_Core_Content_Feed( $instance );
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-form-model.php';
		
		$form_model = new CAHNRSWP_Core_Form_Model();
		
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