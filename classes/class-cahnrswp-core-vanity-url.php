<?php
class CAHNRSWP_Core_Vanity_URL {
	
	private $model;
	
	private $view;
	
	public function __construct(){
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-vanity-url-model.php';
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-vanity-url-view.php';
		
		$this->model = new CAHNRSWP_Core_Vanity_URL_Model();
		
		$this->view = new CAHNRSWP_Core_Vanity_URL_View( $this , $this->model );
		
		add_action( 'init', array( $this->model , 'cwp_add_post_type' ) );
		
		add_action( 'edit_form_after_title' , array( $this , 'cwp_editor' ) );
		
		add_action( 'save_post_vanityurl' , array( $this->model , 'cwp_save_post_vanityurl' ) );
		
		add_action( 'template_redirect', array( $this , 'cwp_vanity_url_redirect') );
		
		add_filter( 'post_type_link', array( $this , 'cwp_service_postlink' ) , 10, 3 );
		
	} // end method __construct
	
	public function cwp_editor( $post ){
		
		if ( 'vanityurl' == $post->post_type ) {
		
			$this->model->cwp_set_props_from_meta( $post->ID );
			
			$this->view->output_settings();
			
		}; // end if
		
	} // end method cwp_video_editor
	
	public function cwp_vanity_url_redirect( ){
		
		global $post;
		
		if( 'vanityurl' == get_post_type( $post->ID ) ){
			
			$this->model->cwp_set_props_from_meta( $post->ID );
			
			$url = $this->view->cwp_get_url();

			wp_redirect( $url );
			
			exit;
			
		}; // end if
		
	} // end method cwp_vanity_url_redirect
	
	public function cwp_service_postlink( $post_link, $post, $leavename ) {	
 		/* Remove the slug from published post permalinks. Only affect our CPT though.*/
		
		if( 'vanityurl' == $post->post_type && 'publish' == $post->post_status ){
			
			$post_link = str_replace( '/url/', '/', $post_link );
			
			return $post_link;
			
		} else {
			
			return $post_link;
			
		}; // end if
		
	} // end method cwp_service_postlink
	
} // end class CAHNRSWP_Core_Vanity_URL

$cwp_vanity_urls = new CAHNRSWP_Core_Vanity_URL();