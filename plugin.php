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
		
		add_action( 'wp_enqueue_scripts', array( $this, 'cwp_enqueue_scripts' ), 20 );
		
	} // end constructor
	
	public function cwp_enqueue_scripts() {
		
		wp_enqueue_style( 'cahnrswp-core', CAHNRSWPCOREURL . '/css/cahnrswp-core.css' , array(), '0.0.1', false );
		
	}
	
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
		
		return apply_filters( 'cwp_core_get_post_types' , $post_types );
	}
	
	
	public function cwp_set_defaults( $defaults , &$instance ){
		
		foreach( $defaults as $default_key => $default_value ){
			
			if( !isset( $instance[ $default_key ] ) ){
				
				$instance[ $default_key ] = $default_value;
				
			} // end if
			
		} // end foreach
		
	} // end cwp_set_defaults
	
} // end CAHNRWP_Core_Form

class CAHNRWP_Core_Query {
	
	public static function cwp_get_local_query( $instance ){
		
		$query = array();
		
		if( isset( $instance['post_type'] ) ) {
			
			$query['post_type'] = $instance['post_type'];
			
		};
		
		if( isset( $instance['tax_query'] ) && isset( $instance['tax_terms'] ) && $instance['tax_terms'] ){
			
			$query['tax_query'] = array(
				array(
					'taxonomy' => $instance['tax_query'],
					'field'    => 'name',
					'terms'    => explode( ',' , $instance['tax_terms'] ),
					),
			);
				
		};
		
		if( isset( $instance['posts_per_page'] ) ) {
			
			if( 'all' == $instance['posts_per_page'] ) $instance['posts_per_page'] = -1;
			
			$query['posts_per_page'] = $instance['posts_per_page'];
			
		}; 
		
		return $query;
		
	}
} // end CAHNRWP_Core_Query

class CAHNRWP_Core_Post {
	
	public static function cwp_get_loop_post_obj( $post ){
		
		$post_obj = new stdClass();
		
		if( isset( $post->post_type ) ){
		
			$post_obj->content_type = $post->post_type;
			
		} else {
			
			$post_obj->content_type = '';
		};
			
		$post_obj->title = get_the_title();
			
		$post_obj->content = get_the_content();
			
		$post_obj->excerpt = get_the_excerpt();
		
		$post_obj->link = get_permalink();
		
		$post_obj->author = get_the_author();
		
		$post_obj->post_date = get_the_date();
		
		if( has_post_thumbnail() ){
			
			$post_obj->img = get_the_post_thumbnail( $post_id, 'thumbnail' );
			
		}
		
		return $post_obj;
		
	} // end cwp_get_loop_post_obj
	
	public static function cwp_post_obj_advanced( &$post , $instance ){
		
		if( isset( $instance['no_link'] ) && $instance['no_link'] ) unset( $post->link ); 
		
		if( isset( $instance['no_title'] ) && $instance['no_title'] ) unset( $post->title );
		
		if( isset( $instance['no_text'] ) && $instance['no_text'] ) {
			
			unset( $post->content );
			
			unset( $post->excerpt );
			
		};
		
		if( isset( $instance['show_content'] ) && $instance['show_content'] ) {
			
			$post->excerpt = $post->content;
			
		};
		
		if( !isset( $instance['show_date'] ) || !$instance['show_date'] ) {
			
			unset( $post->post_date );
			
		}; 
		
		if( !isset( $instance['show_author'] ) || !$instance['show_author'] ) {
			
			unset( $post->author );
			
		}; 
		 		
	}
	
} // end CAHNRWP_Core_Post

class CAHNRWP_Core_Display {
	
	public static function cwp_display_post( $post , $display = 'promo' ){
		
		 switch( $display ){
			 
			case 'list':
			 	break;
				
			case 'promo-gallery':
				include CAHNRSWPCOREDIR . 'inc/inc-display-gallery.php';
				break;
				
			case 'full':
				break;
				
			case 'promo':
			default:
				include CAHNRSWPCOREDIR . 'inc/inc-display-promo.php';
				break;
			 
		 };
	}
	
} // end CAHNRWP_Core_Post


