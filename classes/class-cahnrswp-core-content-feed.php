<?php
class CAHNRSWP_Core_Content_Feed {
	
	private $model;
	
	private $instance;
	
	public function __construct( $instance ){
		
		$this->instance = $instance;
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-content-feed-model.php';
		
		$this->model = new CAHNRSWP_Core_Content_Feed_Model();
		
		$this->model->cwp_set_defaults( $this->instance );
		
	}
	
	
	public function cwp_get_title( $tag = 'H3' ){
		
		$title = '';
		
		if( ! empty( $this->instance['title'] ) ){
			
			if( ! empty( $this->instance['show_accordion'] ) ){
				
				$title = '<' . $tag . ' class="cwp-accordion-link"><a href="#">' . $this->instance['title'] . '</a></' . $tag . '>';
				
			} else {
				
				$title = '<' . $tag . '>' . $this->instance['title'] . '</' . $tag . '>';
				
			}; // end if
			
		}; // end if
		
		return $title;
		
	}
	
	public function cwp_get_feed(){
		
		$html = '';
		
		$ccl_query = new CCL_Query_Core();
			
		$ccl_article = new CCL_Article_Core();
		
		if ( ! empty( $this->instance['feed_type'] ) && 'static' == $this->instance['feed_type'] ){
			
			if( ! empty( $this->instance['insert_urls'] ) && is_array( $this->instance['insert_urls'] ) ){
				
				foreach( $this->instance['insert_urls'] as $url ){
					
					$wp_rest_item = $ccl_query->get_post_from_rest( $url );
		
					$article = $ccl_article->get_rest_article( $wp_rest_item );
					
					if( $article ) {
						
						$articles[] = $ccl_article->get_article_display( $article , $this->instance );
						
					} // end if 
					
				} // end foreach
				
			} // end if
			
		} else {
		
			$query_args = $ccl_query->get_local_query( $this->instance );
			
			$articles = $ccl_article->get_articles_from_query( $query_args , $this->instance );
			
		} // end if
		
		if ( ! empty( $articles ) ){
		
		$html .= implode( '', $articles );
		
		} // end if
		
		return $html;
		
	}
	
	
}