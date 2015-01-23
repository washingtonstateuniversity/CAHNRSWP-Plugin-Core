<?php

require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-admin.php';

class CAHNRSWP_Core_Vanity_URL_Model extends CAHNRSWP_Core_Admin {
	
	public $meta_key = '_vanity_url';
	
	public $vanityurl_redirect = '';
	
	public $vanityurl_redirect_owner = '';
	
	public $vanityurl_camp_name = '';
	
	public $vanityurl_camp_source = '';
	
	public $vanityurl_camp_medium = ''; 
	
	public $vanityurl_camp_term = '';
	
	public $vanityurl_camp_content = '';
	
	public $keys = array(
		'vanityurl_redirect'       => 'text',
		'vanityurl_redirect_owner' => 'text',
		'vanityurl_camp_name'      => 'text',
		'vanityurl_camp_source'    => 'text',
		'vanityurl_camp_medium'    => 'text', 
		'vanityurl_camp_term'      => 'text',
		'vanityurl_camp_content'   => 'text',
	);
	
	public function cwp_add_post_type(){
		
		$supports = array( 'title' );
		
		if( isset( $_GET['cwp-debug'] ) ) $supports[] = 'editor';
		
		$labels = array(
				'name'          => 'Vanity URLs',
				'singular_name' => 'Vanity URL',
				);
				
		$args = array(
				'public'      => true,
				'labels' 	  => $labels,
				'rewrite'     => array( 'slug' => 'url' ),
				'supports' 	  => $supports,
				);
		
		register_post_type( 'vanityurl', $args );
		
	} // end end method cwp_add_video_post_type
	
	/*
	 * @desc - Sets model properties from post meta.
	 * @param object $post - WP Post object.
	*/
	public function cwp_set_props_from_meta( $post_id  ){
		
		$meta = get_post_meta( $post_id , $this->meta_key , true );
		
		foreach ( $this->keys as $key_id => $key_type ) {
			
			if ( isset( $meta[ $key_id ] ) ) {
				
				$this->$key_id = $meta[ $key_id ];
				
			} else {
				
				$this->cwp_check_legacy( $post_id, $key_id );
				
			};// end if
			
		};// end foreach
		
	} // end method cwp_set_props_from_meta
	
	public function cwp_set_props_from_post(){
		
		$meta = $_POST[ $this->meta_key ];
		
		foreach ( $this->keys as $key_id => $key_type ) {
			
			if ( isset( $meta[ $key_id ] ) ) {
				
				switch( $key_type ){
					
					case 'text':
						$this->$key_id = sanitize_text_field( $meta[ $key_id ] );
						break;
					
				}; // end switch
				
			};// end if
			
		};// end foreach
		
	} // end method cwp_set_props_from_meta
	
	public function cwp_save_post_vanityurl( $post_id ) {
		
		$this->cwp_set_props_from_post();
		
		$meta = array();
		
		foreach( $this->keys as $key_id => $key_data ){
			
			if ( isset( $this->$key_id ) ){
				
				$meta[ $key_id ] = $this->$key_id;
				
			}; // end if
			
		}; // end foreach
		
		$this->cwp_save_post_meta( $post_id , 'redirect_nonce' , 'set_redirect' , $this->meta_key , $meta );
		
	} // end method cwp_save_post_vanityurl
	
	/*
	 * @desc - Save post meta from the video.
	 * @param int $post_id - Post ID to update.
	 * @param string/array $meta_data - Sanitized data to be saved.
	*/
	/*public function cwp_save_video( $post_id , $meta_data ){
			
		if ( $meta_data ){
			
			$this->cwp_save_post_meta( $post_id , 'video' , 'add_video' , '_video' , $meta_data );
			
			if ( ! empty( $meta_data['video_url'] ) ){
				
				$video_id = $this->cwp_get_video_id_from_url( $meta_data['video_url'] );
				
				$video_img = '//img.youtube.com/vi/' . $video_id . '/mqdefault.jpg';
				
				$this->cwp_save_post_meta( $post_id , 'video' , 'add_video' , '_default_img_src' , $video_img );
				
			}; // end if
			
		} // end if
		
	} // end method cwp_save_video
	
	/*
	 * @desc - Saves default images for videos
	 * @param int $post_id
	 * @param string $image_src
	*/
	/*public function cwp_save_image( $post_id , $image_src ){
	
		$this->cwp_save_default_image( $post_id , 'video' , 'add_video' , $image_src );
		
	} // end method cwp_save_image
	
	/*
	 * @desc - Cleans $_POST input and sets appropriate model properties.
	*/
	/*public function cwp_set_video_props_from_post_data(){
		
		if ( isset( $_POST[ '_video' ] ) ) {
			
			if ( isset( $_POST['_video']['video_url'] ) ) {
				
				$this->video_url = sanitize_text_field( $_POST['_video']['video_url'] );
				
				$this->video_id = $this->cwp_get_video_id_from_url( $this->video_url );
				
			}; // end if
			
			if ( ! empty( $_POST['_default_img_src'] ) ){
				
				$this->video_thumbnail = sanitize_text_field( $_POST['_default_img_src'] );
				
			} else {
				
				$this->video_thumbnail = '//img.youtube.com/vi/' . $this->video_id . '/mqdefault.jpg';
				
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
	*/
	
	public function cwp_check_legacy( $post_id , $property , $key = false ){
		
		if ( ! $key ) $key = $property;
		
		$meta = get_post_meta( $post_id , $key , true );
		
		if ( ! empty( $meta ) ) {
			
			$this->$property = $meta;
			
		}; // end if
		
	} // end method cwp_check_legacy
	
}