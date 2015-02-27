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
		
		$content_feed = new CAHNRSWP_Core_Content_Feed( $instance );
		
		$title = $content_feed->cwp_get_title();
		
		$html = $content_feed->cwp_get_feed();
		
		echo $args['before_widget'];
		
		echo $title . $html;
		
		echo $args['after_widget'];
		
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