<?php
class CAHNRSWP_Core_Video {
	
	private $video_model;
	
	private $video_view;
	
	public function __construct(){
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-video-model.php';
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-video-view.php';
		
		$this->video_model = new CAHNRSWP_Core_Video_Model();
		
		$this->video_view = new CAHNRSWP_Core_Video_View( $this , $this->video_model );
		
		add_action( 'init', array( $this->video_model , 'cwp_add_video_post_type' ) );
		
		add_action( 'edit_form_after_title' , array( $this , 'cwp_video_editor' ) );
		
		add_action( 'save_post_video' , array( $this, 'cwp_video_save' ) );
		
		add_filter( 'cwp_core_get_post_obj' , array( $this , 'cwp_core_video_get_post_obj' ), 10 , 2 );
			
	} // end __construct
	
	public function cwp_video_save( $post_id ){
		
		$this->video_model->cwp_set_video_props_from_post_data();
		
		if ( isset( $_POST[ '_video' ] ) ) {
			
			$meta_data = array(
				'video_url'      => $this->video_model->video_url,
				'video_related' => $this->video_model->video_related,
				'video_copy'     => $this->video_model->video_copy,
				);
			
			$this->video_model->cwp_save_video( $post_id , $meta_data ); 
			
			$this->video_model->cwp_save_image( $post_id , $this->video_model->video_thumbnail );
			
			// Check permissions again just in case 
			if ( $this->video_model->cwp_check_perm( 'video' , 'add_video' ) ){
			
				// unhook this function so it doesn't loop infinitely
				remove_action( 'save_post_video', array( $this, 'cwp_video_save' ) );
				
				$updated_content = $this->video_view->cwp_get_save_content_view( $meta_data );
				
				$post_data = array(
					'ID' 		   => $post_id,
					'post_content' => $updated_content,	
					);
					
				wp_update_post( $post_data );
			
			};
			
		}; // end if
		
	} // end method cwp_video_save
	
	/*
	 * @desc Sets and renders editor view of video
	 * @param object $post - WP Post object
	*/
	public function cwp_video_editor( $post ){
		
		if ( 'video' == $post->post_type ) {
		
			$this->video_model->cwp_set_video_props_from_meta( $post );
			
			$this->video_view->output_settings();
			
		}; // end if
		
	} // end method cwp_video_editor
	
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
			
		}; // end if
		
		return $post_obj;
	} // end method cwp_core_video_get_post_obj
	
}