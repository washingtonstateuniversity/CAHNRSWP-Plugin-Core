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
		
		if ( null == self::$instance ) {
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
		
		$this->cwp_add_video_support();
		
		add_action( 'widgets_init', array( $this , 'cwp_register_widgets') );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'cwp_enqueue_scripts' ), 20 );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'cwp_admin_enqueue_scripts' ), 20 );
		
		add_action( 'init', array( $this , 'cwp_init' ) );
		
		add_action( 'edit_form_after_title', array( $this ,'cwp_edit_form_after_title' ) );
		
		add_action( 'save_post' , array( $this , 'cwp_save_post' ) );
		
	} // end constructor
	
	/*
	 * @desc Adds video support to theme
	*/ 
	public function cwp_add_video_support(){
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-video.php';
		
		$cwp_videos = new CAHNRSWP_Core_Video();
		
	} // end cwp_add_video_support
	
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
			
		}; // end if
		
	} // end cwp_edit_form_after_title
	
	public function cwp_enqueue_scripts() {
		
		wp_enqueue_style( 'cahnrswp-core', CAHNRSWPCOREURL . '/css/cahnrswp-core.css' , array(), '0.0.1', false );
		
	} // cwp_enqueue_scripts
	
	public function cwp_admin_enqueue_scripts() {
		
		wp_enqueue_style( 'cahnrswp-core-admin', CAHNRSWPCOREURL . '/css/cahnrswp-core-admin.css' , array(), '0.0.1', false );
		
	} // cwp_enqueue_scripts
	
	public function cwp_register_widgets(){
		
		require_once CAHNRSWPCOREDIR.'widgets/cahnrswp-core-feed.php';
		
		register_widget( 'CAHNRSWP_Core_Feed' );
		
		/*require_once CAHNRSWPCOREDIR.'widgets/cahnrswp-core-related-links.php';
		
		register_widget( 'CAHNRSWP_Core_Related_Links' );*/
		
		require_once CAHNRSWPCOREDIR.'widgets/cahnrswp-core-insert-post.php';
		
		register_widget( 'CAHNRSWP_Core_Insert_Post' );
		
	}
	
	/*
	 * @desc Register custom post types
	*/
	private function cwp_register_post_types(){
		
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
		
	}
	
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
						
					}; // end if
					
				}; // end if text
				
			}; // end if
			
			if ( 'undefined' != $clean ){
				
				update_post_meta( $post_id , $key , $clean );
				
			}; // end if
			
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

class CAHNRWP_Core_Query {
	
	public static function cwp_get_local_query( $instance ){
		
		$query = array();
		
		if ( isset( $instance['post_type'] ) ) {
			
			$query['post_type'] = $instance['post_type'];
			
		};
		
		if ( isset( $instance['post__in'] ) ) {
			
			/*$query['post_in'][] = $instance['p'];*/
			$query['post__in'][] = $instance['post__in'];
			
			$query['order_by'][] = 'post__in';
			
		};
		
		if ( isset( $instance['tax_query'] ) && isset( $instance['tax_terms'] ) && $instance['tax_terms'] ){
			
			$query['tax_query'] = array(
				array(
					'taxonomy' => $instance['tax_query'],
					'field'    => 'name',
					'terms'    => explode( ',' , $instance['tax_terms'] ),
					),
			);
				
		};
		
		if ( isset( $instance['posts_per_page'] ) ) {
			
			if ( 'all' == $instance['posts_per_page'] ) $instance['posts_per_page'] = -1;
			
			$query['posts_per_page'] = $instance['posts_per_page'];
			
		}; 
		
		return $query;
		
	}
} // end CAHNRWP_Core_Query

class CAHNRWP_Core_Post {
	
	public static function cwp_get_loop_post_obj( $post ){
		
		$post_obj = new stdClass();
		
		if ( isset( $post->post_type ) ){
		
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
		
		if ( has_post_thumbnail() ){
			
			$post_obj->img = get_the_post_thumbnail( $post_id, 'thumbnail' );
			
		}
		
		return $post_obj;
		
	} // end cwp_get_loop_post_obj
	
	public static function cwp_post_obj_advanced( &$post , $instance ){
		
		if ( isset( $instance['no_link'] ) && $instance['no_link'] ) unset( $post->link ); 
		
		if ( isset( $instance['no_title'] ) && $instance['no_title'] ) unset( $post->title );
		
		if ( isset( $instance['no_text'] ) && $instance['no_text'] ) {
			
			unset( $post->content );
			
			unset( $post->excerpt );
			
		};
		
		if ( isset( $instance['show_content'] ) && $instance['show_content'] ) {
			
			$post->excerpt = $post->content;
			
		};
		
		if ( ! isset( $instance['show_date'] ) || ! $instance['show_date'] ) {
			
			unset( $post->post_date );
			
		}; 
		
		if ( ! isset( $instance['show_author'] ) || ! $instance['show_author'] ) {
			
			unset( $post->author );
			
		}; 
		 		
	}
	
} // end CAHNRWP_Core_Post

class CAHNRWP_Core_Display {
	
	public static function cwp_display_post( $post , $instance = array() ){
		
		if( ! isset( $instance['display'] ) ) $instance['display'] = 'promo';
		
		switch ( $instance['display'] ){
			 
			case 'list':
			 	break;
				
			case 'promo-gallery':
				include CAHNRSWPCOREDIR . 'inc/inc-display-gallery.php';
				break;
				
			case 'full':
				include CAHNRSWPCOREDIR . 'inc/inc-display-full.php';
				break;
			case 'accordion':
				include CAHNRSWPCOREDIR . 'inc/inc-display-accordion.php';
				break;
				
			case 'promo':
			default:
				include CAHNRSWPCOREDIR . 'inc/inc-display-promo.php';
				break;
			 
		 };
	} // end cwp_display_post
	
	public static function cwp_display_post_css( $instance ){
		
		$class = array();
		
		if( isset( $instance['css_hook'] ) && $instance['css_hook'] ){
			
			$class[] = $instance['css_hook'];
			
		}; // end if
		
		if( isset( $instance['display_advanced'] ) && $instance['display_advanced'] ){
			
			$class[] = $instance['display_advanced'];
			
		}; // end if
		
		return implode( ' ', $class );
	}
	
	public static function cwp_display_js( $instance ){
		
		$has_js = array( 'accordion' );
		
		if( isset( $instance['display'] ) && in_array( $instance['display'] , $has_js ) ){
			
			ob_start();
			
			include CAHNRSWPCOREDIR . 'js/' . $instance['display'] . '.php'; 
			
			return '<script>' . ob_get_clean() . '</script>';
			
		} else {
			
			return '';
			
		}

	}
	
} // end CAHNRWP_Core_Post


