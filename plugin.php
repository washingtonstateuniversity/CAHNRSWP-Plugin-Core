<?php
/**
* Plugin Name: CAHNRSWP Core
* Plugin URI:  http://cahnrs.wsu.edu/communications/
* Description: Core feature set for CAHNRS sites.
* Version:     0.0.3
* Author:      CAHNRS Communications, Danial Bleile
* Author URI:  http://cahnrs.wsu.edu/communications/
* License:     Copyright Washington State University
* License URI: http://copyright.wsu.edu
*/

define( 'CAHNRSWPCOREKEY' , 'zPD7ukOLK9' ); // Key for encryption
		
define( 'CAHNRSWPCOREURL' , plugin_dir_url( __FILE__ ) ); // Plugin Base url
		
define( 'CAHNRSWPCOREDIR' , plugin_dir_path( __FILE__ ) ); // Plugin Directory Path 

require_once CAHNRSWPCOREDIR . '/classes/class-cwp-post-public.php';

require_once CAHNRSWPCOREDIR . '/classes/class-ccl-query.php';
		
require_once CAHNRSWPCOREDIR . '/classes/class-ccl-article.php';

require_once CAHNRSWPCOREDIR . '/classes/class-ccl-shortcode.php';

require_once CAHNRSWPCOREDIR . '/classes/class-ccl-display.php';

class CAHNRSWP_Core {
	
	public $news;
	
	public $shortcodes;
	
	private static $instance = null;
	
	/**
	  * @desc Ensures that a single instance CAHNRSWP_Core is created
	  * @return object instance CAHNRSWP_Core
	*/
	
	public static function get_instance(){
		
		if ( null == self::$instance ) {
			self::$instance = new self;
		} // end if
		
		return self::$instance;
	} // end get_instance
	
	/**
	  * @desc Defines contstants, action & filter hooks
	*/
	
	private function __construct(){
		
		
		
		// Load core classes 
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-form-model.php';
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-query.php';
		 
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-post-display.php';
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-post-admin.php';
		
		
		
		if ( is_admin() ){
			
			require_once CAHNRSWPCOREDIR . '/classes/class-ccl-admin-post.php';
			
		} // end admin
		
		// Add actions
		
		$this->cwp_add_actions();
		
		// Add Filters
		
		$this->cwp_add_filters();
		
		// Add Supported Modules
		
		$this->cwp_modules();
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-news.php';
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-publications.php'; 
		
		$this->news = new CAHNRSWP_Core_News();
		
		$this->publications = new CAHNRSWP_Core_Publications();
		
		// Add Shortcodes
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-shortcodes.php';
		
		$this->shortcodes = new CAHNRSWP_Core_Shortcodes();
		
	} // end constructor
	
	/*
	 * @desc - Add WP Actions
	*/
	private function cwp_add_actions(){
		
		if ( is_admin() ) {
			
			add_action( 'admin_enqueue_scripts', array( $this, 'cwp_admin_enqueue_scripts' ), 20 );
			
			//add_action( 'edit_form_after_title', array( $this ,'cwp_edit_form_after_title' ) );
			
			add_action( 'save_post' , array( $this , 'cwp_save_post' ) );
		
		} // end if
		
		add_action( 'widgets_init', array( $this , 'cwp_register_widgets') );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'cwp_enqueue_scripts' ), 20 );
		
		//add_action( 'init', array( $this , 'cwp_init' ) );
		
		add_action('wp_head', array( $this , 'cwp_wp_head' ) );
		
	} // end method cwp_add_actions
	
	/*
	 * @desc - Add WP Filters
	*/
	private function cwp_add_filters(){
		
		//add_filter( 'post_thumbnail_html' , array( $this , 'cwp_post_thumbnail_html' ) , 20 , 5 );
		
		if ( ! empty( $_GET['cwpcore_service'] ) ){ 
		
			add_filter( 'template_include', array( $this , 'cwp_template_include' ) , 99 );
		
		} // end if
		
	} // end method cwp_add_filters
		
	/*
	 * @desc - Add feature modules
	*/
	private function cwp_modules(){
		
		// add video support
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-video.php';
		
		// add vanity url support
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-vanity-url.php';
		
	} // end method cwp_modules
	
	
	/*
	 * @desc - Adds code to page head
	*/
	public function cwp_wp_head() {
		
		echo '<script>';
		
		echo 'var service_url = "' . get_site_url() . '"';
		
		echo '</script>';
		
	} // end method cwp_head
	
	/*
	 * @desc - Gets service template
	*/
	public function cwp_template_include( $template ){
		
		switch( $_GET['cwpcore_service'] ){
			
			case 'query':
				$template = CAHNRSWPCOREDIR . '/service/service-cahnrswp-core-query.php';
				break;
				
			case 'iframe':
				$template = CAHNRSWPCOREDIR . '/service/service-cahnrswp-core-iframe.php';
				break;
			case 'ajax':
				$template = CAHNRSWPCOREDIR . '/service/service-cahnrswp-core-ajax.php';
				break;
			
		} // end switch
		
		return $template;
		
	} // end method cwp_template_include
	
	/*
	 * @desc
	 * @param
	*/
	public function cwp_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ){
		
		//if ( empty( $size ) || 'thumbnail' == $size || 'thumbnail-square' == $size ){
		
			//if ( empty( $html ) && $post_id ) {
				
				//$img_src = get_post_meta( $post_id , '_default_img_src' , true );
				
			//} else {
				
				/*
				 * Instead of doing more calls to get the src, lets try and
				 * pull it from the $html.
				*/
				//preg_match('/src="(.*?)"/i', $html, $matches );
				
				//if ( $matches ){
					
					//$img_src = str_replace ( array( 'src="' , '"' ) , '' , $matches[0] );
					
				//}
			
			//} // end if
			
			//if ( ! empty( $img_src ) ){
				
				//$html = '<img ';
				
				//$html .= 'src="' . CAHNRSWPCOREURL . '/images/spacer4-3.png" ';
				
				//$html .= 'style="background-image: url(' . $img_src . '); background-repeat: no-repeat; background-size: cover; background-position: center center; width: 100%; display: block;" ';
				
				//$html .= ' />'; 
				
			//} // end if
			
		//} // end if
		
    	return $html;
	}
	
	/**
	 * @desc Actions initiated by add_action( init , ... 
	*/
	public function cwp_init(){
		
		$this->cwp_register_post_types();
		
	} // end cwp_init
	
	/*
	 * @desc Add actions from edit_form_after_title
	*/
	public function cwp_edit_form_after_title() {
		
		global $post;
		
		if ( 'news_item' == $post->post_type ){
			
			require_once CAHNRSWPCOREDIR . 'classes/class-cahnrs-core-news-item.php';
			
			$news_data = new CAHNRSWP_Core_News_Item( $post );
			
			include 'inc/inc-editor-form-news-item.php';
			
		} // end if
		
	} // end cwp_edit_form_after_title
	
	public function cwp_enqueue_scripts() {
		
		wp_enqueue_script( 'cycle2', CAHNRSWPCOREURL . '/js/cycle2.js' , array(), '0.0.2', false );
		
		wp_enqueue_script( 'cahnrswp-core-js', CAHNRSWPCOREURL . '/js/core.js' , array(), '0.0.2', false );
		
		wp_enqueue_style( 'cahnrswp-core', CAHNRSWPCOREURL . '/css/cahnrswp-core.css' , array(), '0.0.3', false );
		
		wp_enqueue_style( 'jquery-ui-css', '//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' , array(), '0.0.4', false );
		
	} // cwp_enqueue_scripts
	
	public function cwp_admin_enqueue_scripts() {
		
		wp_enqueue_style( 'cahnrswp-core-admin-css', CAHNRSWPCOREURL . '/css/cahnrswp-core-admin.css' , array(), '0.0.1', false );
		
		wp_enqueue_script( 'cahnrswp-core-admin-js', CAHNRSWPCOREURL . '/js/admin.js' , array(), '0.0.1', false );
		
	} // cwp_enqueue_scripts
	
	public function cwp_register_widgets(){
		
		
		
		/*require_once CAHNRSWPCOREDIR.'widgets/cahnrswp-core-related-links.php';
		
		register_widget( 'CAHNRSWP_Core_Related_Links' );*/
		
		require_once CAHNRSWPCOREDIR.'widgets/cahnrswp-core-insert-post.php';
		
		register_widget( 'CAHNRSWP_Core_Insert_Post' );
		
		require_once CAHNRSWPCOREDIR.'widgets/widget-cahnrswp-core-slider.php';
		
		register_widget( 'Widget_CAHNRSWP_Core_Slider' );
		
		require_once CAHNRSWPCOREDIR.'widgets/cahnrswp-core-tabs.php';
		
		register_widget( 'CAHNRSWP_Core_Tabs' );
		
		require_once CAHNRSWPCOREDIR.'widgets/widget-cahnrswp-core-content-feed.php';
		
		register_widget( 'Widget_CAHNRSWP_Core_Content_Feed' );
		
	}
	
	/*
	 * @desc Register custom post types
	*/
	/*private function cwp_register_post_types(){
		
		$news_labels = array(
			'name'          => 'News Items',
			'singular_name' => 'News Item',
		);
		
		$news_args = array(
			'public'      => true,
			'labels'       => $news_labels,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'news' ),
			'supports'    => array( 'title', 'editor', 'author', 'thumbnail', 'comments', ),
		);
		
		register_post_type( 'news_item', $news_args );
		
	}*/
	
	public function cwp_save_post( $post_id ){
		
		if ( ! isset( $_POST['cahnrs_core_nonce'] ) ) return;
		
		if ( ! wp_verify_nonce( $_POST['cahnrs_core_nonce'], 'submit_cahnrs_core' ) ) return;
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		
		$keys = array( 
			'_news_item' => 'text' 
			);
		
		foreach ( $keys as $key => $type ){
			
			$clean = 'undefined';
			
			if ( isset( $_POST[ $key ] ) ){
				
				$value = $_POST[ $key ];
				
				if ( 'text' == $type ) {
					
					if ( is_array( $value ) ){
							
							if( 
								array_walk_recursive( 
									&$value , 
									function( &$data , $index ){ $data = sanitize_text_field( $data );} 
								)
							) {
								
								$clean = $value;
								
							} // end if
						
					} else {
						
						$clean = sanitize_text_field( $value ); 
						
					} // end if
					
				} // end if text
				
			} // end if
			
			if ( 'undefined' != $clean ){
				
				update_post_meta( $post_id , $key , $clean );
				
			} // end if
			
		} // end foreach
		
	} // end cwp_save_post
	
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
		
		
		
		foreach ( $registered_types as $post_typeid => $post_type ){
			
			
			if ( ! in_array( $post_typeid , $exclude ) ) {
				
				$post_types[ $post_typeid ] = $post_type->name;
				
			} // end if
			
		} // end foreach
		
		return apply_filters( 'cwp_core_get_post_types' , $post_types );
	}
	
	
	public function cwp_set_defaults( $defaults , &$instance ){
		
		foreach ( $defaults as $default_key => $default_value ){
			
			if ( ! isset( $instance[ $default_key ] ) ){
				
				$instance[ $default_key ] = $default_value;
				
			} // end if
			
		} // end foreach
		
	} // end cwp_set_defaults
	
} // end CAHNRWP_Core_Form


