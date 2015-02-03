<?php 
class CAHNRSWP_Core_Shortcodes {
	
	public function __construct(){
		
		add_shortcode( 'CWPCONTENTFEED' , array( $this , 'cwp_content_feed' ) );
		
	} // End Method __construct
	
	
	public function cwp_content_feed( $instance ) {
		
		ob_start();
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-content-feed-model.php';
		
		$model = new CAHNRSWP_Core_Content_Feed_Model();
		
		$model->cwp_set_defaults( $instance );
		
		$items = CAHNRSWP_Core_Query::cwp_get_items( $instance );
		
		if ( ! empty( $instance['title'] ) ){
				
			echo '<h3 class="cwp-widget-title">' . $instance['title'] . '</h3>';
			
		}; // end if
		
		if ( $items ) {
			
			echo CAHNRSWP_Core_Post_Display::cwp_display_wrapper( $instance , true );
			
			foreach ( $items as $item ) {
				
				CAHNRSWP_Core_Query::cwp_item_advanced( $item , $instance );
		
				CAHNRSWP_Core_Post_Display::cwp_display_post( $item , $instance );
				
			}; // end foreach
			
			echo CAHNRSWP_Core_Post_Display::cwp_display_wrapper( $instance );
		
		}; // end if
		
		return ob_get_clean();
		
	} // End Method cwp_tab_content
	
};

$cahnrswp_core_shortcodes = new CAHNRSWP_Core_Shortcodes();