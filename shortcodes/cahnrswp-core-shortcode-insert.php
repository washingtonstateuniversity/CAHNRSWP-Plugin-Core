<?php 
class CAHNRSWP_Core_Shortcode_Insert {
	
	public function __construct(){
		
		add_shortcode( 'cwpinsert' , array( $this , 'cwp_render_shortcode' ) );
		
	} // End Method __construct
	
	
	public function cwp_render_shortcode( $instance ) {
		
		if ( empty( $instance['display'] ) ) {
			 
			$instance['display'] = 'full';
			
		} // end if
		
		$html = '';
		
		if ( ! empty( $instance['url'] ) ){
		
			$ccl_query = new CCL_Query_Core();
			
			$ccl_article = new CCL_Article_Core();
			
			$wp_rest_item = $ccl_query->get_post_from_rest( $instance['url'] );
		
			$article = $ccl_article->get_rest_article( $wp_rest_item );
			
			if ( ! empty( $instance['title'] ) ){
				
				$article['title'] = $instance['title'];
				
			}; // end if
			
			$html .= $ccl_article->get_article_display( $article , $instance );
		
		}; // end if
		
		return $html;
		
	} // End Method cwp_tab_content
	
};

$cahnrswp_core_shortcode_insert = new CAHNRSWP_Core_Shortcode_Insert();