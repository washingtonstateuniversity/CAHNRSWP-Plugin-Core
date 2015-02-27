<?php
class CAHNRSWP_Core_Shortcodes {
	
	public $video;
	
	public function __construct(){
		
		require_once CAHNRSWPCOREDIR . '/shortcodes/cahnrswp-core-shortcode-content-feed.php';
		
		require_once CAHNRSWPCOREDIR . '/shortcodes/cahnrswp-core-shortcode-submenu.php';
		
		require_once CAHNRSWPCOREDIR . '/shortcodes/cahnrswp-core-shortcode-insert.php';
		
		require_once CAHNRSWPCOREDIR . '/shortcodes/cahnrswp-core-shortcode-accordion.php';
		
		require_once CAHNRSWPCOREDIR . '/shortcodes/cahnrswp-core-shortcode-video.php';
		
		$this->video = new CAHNRSWP_Core_Shortcode_Video();
		
	} // end method __construct
	
}