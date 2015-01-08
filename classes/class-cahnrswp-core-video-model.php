<?php

require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-admin.php';

class CAHNRSWP_Core_Video_Model extends CAHNRSWP_Core_Admin {
	
	public $meta_key = '_video';
	
	public $video_meta = array();
	
	public $video_url = '';
	
	public $video_id = '';
	
	public $video_summary = '';
	
	public $video_copy = '';
	
	public $video_related = false;
	
	public function cwp_add_video_post_type(){
		
		$supports = array( 'title', 'thumbnail', 'comments' );
		
		if( isset( $_GET['cwp-debug'] ) ) $supports[] = 'editor';
		
		$labels = array(
				'name'          => 'Videos',
				'singular_name' => 'Video',
				);
				
		$args = array(
				'public'      => true,
				'labels' 	  => $labels,
				'has_archive' => true,
				'rewrite'     => array( 'slug' => 'videos' ),
				'supports' 	  => $supports,
				);
		
		register_post_type( 'video', $args );
		
	} // end end method cwp_add_video_post_type
	
	/*
	 * @desc - Sets model properties from post meta.
	 * @param object $post - WP Post object.
	*/
	public function cwp_set_video_props_from_meta( $post ){
		
		$meta = get_post_meta( $post->ID , $this->meta_key , true );
		
		if ( isset( $meta['video_url'] ) ){
			
			$this->video_url = $meta['video_url'];
			
			$this->video_id = $this->cwp_get_video_id_from_url( $this->video_url );
			
			if ( strpos( $this->video_url , '?v=' ) === false) {
				
				
				$this->video_url = 'https://www.youtube.com/watch?v=' . $this->video_url;
				
			}; // end if
			
		} else {
			
			$legacy_id = get_post_meta( $post->ID , '_video_id' , true );
			
			if ( $legacy_id ) {
			
				$this->video_url = 'https://www.youtube.com/watch?v=' . $legacy_id;
				
				$this->video_id = $legacy_id;
				
			}; // end if
			
		};// end if
		
		
		if ( isset( $meta['video_related'] ) ){
			
			$this->video_related = $meta['video_related'];
			
		}; // end if
		
		if ( isset( $meta['video_copy'] ) ){
			
			$this->video_copy = $meta['video_copy'];
			
		} else {
			
			$this->video_copy = $post->post_content;
			
		};// end if
		
		if ( isset( $post->post_excerpt ) ){
			
			$this->video_summary = $post->post_excerpt;
			
		}; // end if
		
	} // end method cwp_set_video_props_from_meta
	
	/*
	 * @desc - Save post meta from the video.
	 * @param int $post_id - Post ID to update.
	 * @param string/array $meta_data - Sanitized data to be saved.
	*/
	public function cwp_save_video( $post_id , $meta_data ){
			
		if ( $meta_data ){
			
			$this->cwp_save_post_meta( $post_id , 'video' , 'add_video' , '_video' , $meta_data );
			
		} // end if
		
	} // end method cwp_save_video
	
	/*
	 * @desc - Cleans $_POST input and sets appropriate model properties.
	*/
	public function cwp_set_video_props_from_post_data(){
		
		if ( isset( $_POST[ '_video' ] ) ) {
			
			if ( isset( $_POST['_video']['video_url'] ) ) {
				
				$this->video_url = sanitize_text_field( $_POST['_video']['video_url'] );
				
				$this->video_id = $this->cwp_get_video_id_from_url( $this->video_url );
				
			}; // end if
			
			if ( isset( $_POST['_video']['video_related'] ) ) {
				
				$this->video_related = sanitize_text_field( $_POST['_video']['video_related'] );
				
			}; // end if
			
			if ( isset( $_POST['_video_copy'] ) ) {
				
				$this->video_copy = wp_kses_post( $_POST['_video_copy'] );
				
			}; // end if
			
			if ( isset( $_POST['excerpt'] ) ) {
				
				$this->video_summary = sanitize_text_field( $_POST['excerpt'] );
				
			}; // end if
			
		} // end if
		
	} // end method cwp_set_post_data
	
	/*
	 * @desc - Extracts video id from url
	 * @return string - The video id.
	*/
	public function cwp_get_video_id_from_url( $url ){
		
		$url = explode( 'watch?v=' , $url );
			
		if ( isset( $url[1] ) ) {
			
			return $url[1];
			
		} else {
			
			return $url[0];
			
		}; // end if
		
	} // end cwp_get_video_id_from_url
	
}