<?php 
class CAHNRSWP_Core_Publications extends CAHNRSWP_Core_Post_Admin {
	
	public $meta_key = '_publication';
	
	protected $key_array = array(
		'source'  => 'text',
		'journal' => 'text',
		'volume'  => 'text',
		'author'  => 'text',
		'year'    => 'text',
		);
	
	public $model;
	
	public $defaults = array(
		'source'  => '',
		);
	
	public function __construct(){
		
		add_action( 'init', array( $this , 'cwp_register_post_type' ) );
		
		add_action( 'edit_form_after_title', array( $this , 'editor_form' ) );
		
		add_action( 'save_post_publication' , array( $this , 'cwp_save_post' ) );
		
		add_action( 'template_redirect', array( $this , 'redirect_source' ) );
		
	} // end __construct
	
	public function redirect_source(){
		
		 global $post;
		 
		 if( 'publication' == $post->post_type  &&  is_singular() ){
			 
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
		
		var_dump( 'meta' );
		
		if( empty( $meta ) ){
			
			$model = $this->defaults;
			
		} else {
			
			$model['source'] = ( ! empty( $meta['source'] ) ) ? $meta['source'] : '';
			
			$model['journal'] = ( ! empty( $meta['journal'] ) ) ? $meta['journal'] : '';
			
			$model['volume'] = ( ! empty( $meta['volume'] ) ) ? $meta['volume'] : '';
			
			$model['author'] = ( ! empty( $meta['author'] ) ) ? $meta['author'] : '';
			
			$model['year'] = ( ! empty( $meta['year'] ) ) ? $meta['year'] : '';
			
		}; // end if
		
		if ( $post->post_excerpt ) {
			
			$model['excerpt'] = $post->post_excerpt;
			
		} else {
			
			$model['excerpt'] = '';
			
		}; // end if
		
		$this->model = $model;
		
	}
	
	public function cwp_register_post_type(){
		
		$pub_labels = array(
			'name'          => 'Publications',
			'singular_name' => 'Publication',
		);
		
		$pub_args = array(
			'public'      => true,
			'labels'       => $pub_labels,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'publications' ),
			'taxonomies' => array( 'category' , 'post_tag' ),
			'supports'    => array( 'title', 'editor', 'author', 'thumbnail', ),
		);
		
		register_post_type( 'publication', $pub_args );
		
	}
	
	public function editor_form( $post ){
		
		if ( 'publication' == $post->post_type ){
			
			$this->set_model( $post );
		
			include CAHNRSWPCOREDIR . 'forms/form-editor-pub.php';
		
		}; // end if
		
	}
	
} // end