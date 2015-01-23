<?php
class CAHNRSWP_Core_Vanity_URL_View {
	
	private $controller;
	
	private $model;
	
	public function __construct( $controller , $model ){
		
		$this->controller = $controller;
		
		$this->model = $model;
		
	} // end __construct
	
	public function output_settings(){
		
		include CAHNRSWPCOREDIR . '/inc/inc-form-vanity-url-settings.php';
		
	} // end method output_settings 
	
	public function cwp_get_url(){
		
		$campaign = array();
		
		if ( ! empty( $this->model->vanityurl_camp_name ) ) {
			
			$campaign[] = 'utm_campaign=' .$this->model->vanityurl_camp_name;
			
		};// end if
		
		if ( ! empty( $this->model->vanityurl_camp_source ) ) {
			
			$campaign[] = 'utm_source=' .$this->model->vanityurl_camp_source;
			
		};// end if
		
		if ( ! empty( $this->model->vanityurl_camp_medium ) ) {
			
			$campaign[] = 'utm_medium=' .$this->model->vanityurl_camp_medium;
			
		};// end if
		
		if ( ! empty( $this->model->vanityurl_camp_term) ) {
			
			$campaign[] = 'utm_term=' .$this->model->vanityurl_camp_term;
			
		};// end if
		
		if ( ! empty( $this->model->vanityurl_camp_content) ) {
			
			$campaign[] = 'utm_content=' .$this->model->vanityurl_camp_content;
			
		};// end if
		
		$url = $this->model->vanityurl_redirect;
		
		if( $campaign ) {
			
			$url .= '?' . implode( '&' , $campaign );
			
		}; // end if
		
		return $url;
		
	} // end method cwp_get_url
	
} // end CAHNRSWP_Commodities_Vanity_URL_View