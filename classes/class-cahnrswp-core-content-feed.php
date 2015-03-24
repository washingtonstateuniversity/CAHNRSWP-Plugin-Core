<?php
class CAHNRSWP_Core_Content_Feed {
	
	private $model;
	
	private $instance;
	
	public $ccl_display;
	
	public function __construct( $instance ){
		
		$this->instance = $instance;
		
		require_once CAHNRSWPCOREDIR . '/classes/class-cahnrswp-core-content-feed-model.php';
		
		$this->model = new CAHNRSWP_Core_Content_Feed_Model();
		
		$this->model->cwp_set_defaults( $this->instance );
		
		$this->ccl_display = new CCL_Display_Core();
		
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
					
					$article = $ccl_query->get_single_article( $url , $this->instance );
					
					$articles[] = $this->ccl_display->get_article_html( $article , $this->instance );
					
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