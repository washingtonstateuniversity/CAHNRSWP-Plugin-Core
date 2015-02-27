<?php
class CAHNRSWP_Core_Video {
	
	public $meta_key = '_video';
	
	public function __construct(){
		
		add_action( 'init', array( $this , 'video_post_type' ) );
		
		add_action( 'save_post_video' , array( $this, 'save_post' ) );
		
		add_filter( 'cwp_core_get_post_obj' , array( $this , 'cwp_core_video_get_post_obj' ), 10 , 2 );
		
		add_action( 'edit_form_after_title' , array( $this , 'video_editor' ) );
		
		add_filter( 'post_thumbnail_html' , array( $this , 'cwp_post_thumbnail_html' ) , 30 , 5 );
			
	} // end __construct
	
	public function cwp_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ){
		
		if ( empty( $size ) || 'thumbnail' == $size ){
		
			if ( $post_id && 'video' == get_post_type( $post_id ) ){
			
				if ( empty( $html ) && $post_id && 'video' == get_post_type( $post_id ) ) {
						
					$img_src = get_post_meta( $post_id , '_default_img_src' , true );
						
				} else {
					
					$img = wp_get_attachment_image_src( $post_thumbnail_id , 'thumbnail' );
					
					$img_src = $img[0];
					
				}// end if 
				
				if ( ! empty( $img_src ) ){
					
					$html = '<img ';
					
					$html .= 'src="' . CAHNRSWPCOREURL . '/images/spacer4-3.png" ';
					
					$html .= 'style="background-image: url(' . $img_src . '); background-repeat: no-repeat; background-size: cover; background-position: center center; width: 100%; display: block;" ';
					
					$html .= ' />'; 
					
				} // end if
				
			} // end if
		
		} // end if
		
    	return $html;
		
	}
	
	public function video_editor( $post ){
		
		if( 'video' == $post->post_type ) {
		
			$video = $this->get_video_from_post( $post );
			
			include CAHNRSWPCOREDIR . 'forms/form-video-settings.php';
		
		} // end if
		
	}
	
	public function get_video_from_post( $post ){
		
		$meta = get_post_meta( $post->ID , $this->meta_key , true );
		
		$video = array(
			'ulr'     => '',
			'id'      => '',
			'copy'    => '',
			'summary' => '',
			'img'     => '',
		);
		
		if ( isset( $meta['video_url'] ) ){
			
			$video['url'] = $meta['video_url'];
			
			$video['id'] = $this->cwp_get_video_id_from_url( $video['url'] );
			
			if ( strpos( $video['url'] , '?v=' ) === false) {
				
				$video['url'] = 'https://www.youtube.com/watch?v=' . $video['id'];
				
			} // end if
			
		} else {
			
			$legacy_id = get_post_meta( $post->ID , '_video_id' , true );
			
			if ( $legacy_id ) {
			
				$video['url'] = 'https://www.youtube.com/watch?v=' . $legacy_id;
				
				$video['id'] = $legacy_id;
				
			} // end if
			
		}// end if
		
		$video_copy = get_post_meta( $post->ID , '_video_copy' , true );
		
		if ( ! empty( $video_copy ) ){
			
			$video['copy'] = $video_copy;
			
		} // end if
		
		
		
		if ( isset( $post->post_excerpt ) ){
			
			$video['summary'] = $post->post_excerpt;
			
		} // end if
		
		$default_image = get_post_meta( $post->ID , '_default_img_src' , true );
		
		if ( ! empty( $default_image ) ){
			
			$video['img'] = $default_image;
			
		} else if ( ! empty( $video['id'] ) ) {
			
			$video['img'] = '//img.youtube.com/vi/' . $video['id'] . '/mqdefault.jpg';
			
		} // end if
		
		return $video;
	}
	
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
			
		} // end if
		
	} // end cwp_get_video_id_from_url
	
	public function video_post_type(){
		
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
				'taxonomies' => array( 'category' , 'post_tag' ),
				);
		
		register_post_type( 'video', $args );
		
	} // end end method cwp_add_video_post_type
	
	public function save_post( $post_id ){
		
		$admin_post = new CCL_Admin_Post_Core();
		
		$data = array(
				'video_url'   => 'text',
				'vid_related' => 'text',
				'_video_copy' => 'html',
			);
			
		
		
		$nonce = array( 'key' => 'video' , 'action' => 'add_video' );
		
		$admin_post->save_post( $post_id , $this->meta_key , $data , $nonce );
		
		$admin_post->save_post( $post_id , '_video_copy' , 'html' , $nonce );
			
		$admin_post->save_post( $post_id , '_default_img_src' , 'text' , $nonce );
		
		// Update content
		
		$post = get_post( $post_id );
		
		$video = $this->get_video_from_post( $post ); 
		
		$html = $this->get_video_html( $video );
		
		$admin_post->update_post_content( $this , $post_id , $html , $nonce );
		
	} // end method save_video
	
	public function get_video_html( $video ){
		
		$html = '<div class="video-frame" style="position: relative;" >';
		
		$html .= '<img src="' . CAHNRSWPCOREURL . '/images/spacer16-9.png" style="width: 100%;" />';
		
		$html .= '[cwpvideo type="youtube" source="http://www.youtube.com/embed/' . $video['id'] .'" class="in-wrap" autoplay="1"]';
		
		$html .= '</div>';
		
		if ( ! empty( $video['summary'] ) ) {
    		
			$html .= '<h2>Video Summary</h2>' . $video['summary'];
			
		} // end if
		
		if ( ! empty( $video['copy'] ) ) {
    		
			$html .= '<h2>More</h2>' . $video['copy'];
			
		} // end if
		
		return $html;
	
	}
	
	/*
	 * @desc - Takes the modified post object and adds youtube
	 * thumbnail if a featured image is not set
	 * @param object $post_obj - Custom post object used to display content.
	 * @param object $post - WP Post object
	 * @return - $post_obj.
	*/
	public function cwp_core_video_get_post_obj( $post_obj , $post ){
		
		if ( 'video' == $post->post_type && ! isset( $post_obj->img_src ) ) {
			
			$this->video_model->cwp_set_video_props_from_meta( $post );
			
			$post_obj->img_src = $this->video_model->video_thumbnail;
			
		} // end if
		
		return $post_obj;
	} // end method cwp_core_video_get_post_obj
	
}

$cwp_videos = new CAHNRSWP_Core_Video();