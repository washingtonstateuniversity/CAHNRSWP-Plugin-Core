<?php 
class CAHNRSWP_Core_News extends CAHNRSWP_Core_Post_Admin {
	
	public $meta_key = '_news';
	
	protected $key_array = array(
		'source' => 'text',
		);
	
	public $model;
	
	public $defaults = array(
		'source'  => '',
		);
	
	public function __construct(){
		
		add_action( 'init', array( $this , 'cwp_register_post_type' ) );
		
		add_action( 'edit_form_after_title', array( $this , 'editor_form' ) );
		
		add_action( 'save_post_news' , array( $this , 'cwp_save_post' ) );
		
		add_action( 'template_redirect', array( $this , 'redirect_source' ) );
		
	} // end __construct
	
	public function redirect_source(){
		
		 global $post;
		 
		 if( 'news' == $post->post_type  &&  is_singular() ){
			 
			 $meta = get_post_meta( $post->ID , $this->meta_key , true );
			 
			 if( is_array( $meta ) && ! empty( $meta['source'] ) ){
				 
				 \wp_redirect( $meta['source'] , 302 );
				 
				 exit;
			 }
		 }
	 }
	
	public function cwp_save_post( $post_id ){
		
		$this->cwp_save_meta( $post_id );
		
	}
	
	public function set_model( $post ){
		
		$model = array();
		
		$meta = get_post_meta( $post->ID , $this->meta_key , true );
		
		if( empty( $meta ) ){
			
			$model = $this->defaults;
			
		} else {
			
			$model['source'] = ( ! empty( $meta['source'] ) ) ? $meta['source'] : '';
			
		}; // end if
		
		if ( $post->post_excerpt ) {
			
			$model['excerpt'] = $post->post_excerpt;
			
		} else {
			
			$model['excerpt'] = '';
			
		}; // end if
		
		$this->model = $model;
		
	}
	
	public function cwp_register_post_type(){
		
		$news_labels = array(
			'name'          => 'News',
			'singular_name' => 'News',
		);
		
		$news_args = array(
			'public'      => true,
			'labels'       => $news_labels,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'news' ),
			'taxonomies' => array( 'category' , 'post_tag' ),
			'supports'    => array( 'title', 'editor', 'author', 'thumbnail', 'comments', ),
		);
		
		register_post_type( 'news', $news_args );
		
	}
	
	public function editor_form( $post ){
		
		if ( 'news' == $post->post_type ){
			
			$this->set_model( $post );
		
			include CAHNRSWPCOREDIR . 'forms/form-editor-news.php';
		
		}; // end if
		
	}
	
} // end CAHNRS_Core_News_Item