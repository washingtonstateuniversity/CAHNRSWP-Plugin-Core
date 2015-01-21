<?php
class Service_CAHNRSWP_Core_Query {
	
	public $instance = array();
	
	public function __construct(){
		
		$this->set_instance();
		
		$items = CAHNRSWP_Core_Query::cwp_get_items( $this->instance );
		
		if( ! empty( $items ) && is_array( $items ) ){
			
			foreach( $items as $index => $item ){
			
				CAHNRSWP_Core_Query::cwp_item_advanced( $item , $this->instance );
			
				CAHNRSWP_Core_Post_Display::cwp_display_post( $item , $this->instance );
			
			};// end foreach
			
		};// end if
		
	} // end method __construct
	
	public function set_instance(){
		
		if ( ! empty( $_GET['feed_type'] ) ) $this->instance['feed_type'] = $_GET['feed_type'];
		
		if ( ! empty( $_GET['display'] ) ) $this->instance['display'] = $_GET['display'];
		
		if ( ! empty( $_GET['insert_urls'] ) ) $this->instance['insert_urls'] = $_GET['insert_urls'];
		
	} // end method set_instance
	
} // end class Service_CAHNRSWP_Core_Query

$service_cahnrswp_core_query = new Service_CAHNRSWP_Core_Query();