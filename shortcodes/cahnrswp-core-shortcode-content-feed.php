<?php 
class CAHNRSWP_Core_Shortcode_Content_Feed {
	
	public function __construct(){
		
		add_shortcode( 'cwpfeed' , array( $this , 'cwp_content_feed' ) );
		
	} // End Method __construct
	
	
	public function cwp_content_feed( $instance ) {
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-content-feed.php';
		
		$content_feed = new CAHNRSWP_Core_Content_Feed( $instance );
		
		$title = $content_feed->cwp_get_title();
		
		$html = $content_feed->cwp_get_feed();
		
		return $title . $html;
		
	} // End Method cwp_tab_content
	
};

$cahnrswp_core_shortcode_content_feed = new CAHNRSWP_Core_Shortcode_Content_Feed();