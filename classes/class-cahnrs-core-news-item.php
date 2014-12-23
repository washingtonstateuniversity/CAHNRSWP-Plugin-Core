<?php 
class CAHNRSWP_Core_News_Item {
	
	public $post_meta;
	
	public $excerpt = '';
	
	public function __construct( $post ){
		
		$this->set_post_meta( $post->ID );
		
		$this->set_excerpt( $post );
		
	} // end __construct
	
	/*
	 * @desc Sets the excerpt content for news_ite
	 * @param object $post The WP Post object.
	*/
	public function set_excerpt( $post ){
		
		
		if ( isset( $post->post_excerpt ) ){
			
			$this->excerpt = $post->post_excerpt;
			
		} else {
			
			$this->excerpt = '';
			
		} // end if
		
	} // end set_excerpt
	
	public function set_post_meta( $post_id ){
		
		$meta = get_post_meta( $post_id , '_news_item' , true );
		
		$this->post_meta = $meta;
		
	}
	
} // end CAHNRS_Core_News_Item