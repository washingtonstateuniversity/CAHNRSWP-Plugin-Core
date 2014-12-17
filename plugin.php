<?php
/**
* Plugin Name: CAHNRSWP Core
* Plugin URI:  http://cahnrs.wsu.edu/communications/
* Description: Core feature set for CAHNRS sites.
* Version:     0.0.1
* Author:      CAHNRS Communications, Danial Bleile
* Author URI:  http://cahnrs.wsu.edu/communications/
* License:     Copyright Washington State University
* License URI: http://copyright.wsu.edu
*/
class CAHNRSWP_Core {
	
	private static $instance = null;
	
	/**
	  * @desc Ensures that a single instance CAHNRSWP_Core is created
	  * @return object instance CAHNRSWP_Core
	*/
	
	public static function get_instance(){
		
		if( null == self::$instance ) {
			self::$instance = new self;
		} // end if
		
		return self::$instance;
	} // end get_instance
	
	/**
	  * @desc Defines contstants, action & filter hooks
	*/
	
	private function __construct(){
		
		define( 'CAHNRSWPCOREURL' , plugin_dir_url( __FILE__ ) ); // Plugin Base url
		
		define( 'CAHNRSWPCOREDIR' , plugin_dir_path( __FILE__ ) ); // Plugin Directory Path
		
		add_action( 'widgets_init', array( $this , 'cwp_register_widgets') );
		
	} // end constructor
	
	public function cwp_register_widgets(){
		
		require_once CAHNRSWPCOREDIR.'widgets/cahnrswp-core-feed.php';
		
		register_widget( 'CAHNRSWP_Core_Feed' );
		
	}
	
} // end class CAHNRSWP_Core

$cahnrswp_core = CAHNRSWP_Core::get_instance();

class CAHNRWP_Core_Form {
	
	public function cwp_get_image_sizes(){
		
		global $_wp_additional_image_sizes;
		
		return $_wp_additional_image_sizes;
		
	}
	
	public function cwp_get_post_types(){
		
		$post_types = array();
		
		$registered_types = get_post_types( array() , 'objects' );
		
		$exclude = array( 'revision', 'nav_menu_item' );
		
		
		
		foreach( $registered_types as $post_typeid => $post_type ){
			
			
			if ( !in_array( $post_typeid , $exclude ) ) {
				
				$post_types[ $post_typeid ] = $post_type->name;
				
			} // end if
			
		} // end foreach
		
		return $post_types;
	}
	
	
	public function cwp_set_defaults( $defaults , &$instance ){
		
		foreach( $defaults as $default_key => $default_value ){
			
			if( !isset( $instance[ $default_key ] ) ){
				
				$instance[ $default_key ] = $default_value;
				
			} // end if
			
		} // end foreach
		
	} // end cwp_set_defaults
	
}

