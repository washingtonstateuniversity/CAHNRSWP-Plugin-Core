<?php
class CAHNRSWP_Core_Video_View {
	
	private $controller;
	
	private $model;
	
	public function __construct( $controller , $model ){
		
		$this->controller = $controller;
		
		$this->model = $model;
		
	} // end __construct
	
	public function output_settings(){
		
		include CAHNRSWPCOREDIR . '/inc/inc-form-video-settings.php';
		
	} // end method output_settings 
	
	public function cwp_get_save_content_view(){
		
		ob_start();
			
		include CAHNRSWPCOREDIR . '/inc/inc-post-video-content.php';
			
		return ob_get_clean();
			
	} // end method cwp_get_save_content_view
	
} // end CAHNRSWP_Commodities_Video_View