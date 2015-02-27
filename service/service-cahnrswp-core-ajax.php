<?php
class CAHNRSWP_Core_Service_Ajax {
	
	private $source = false;
	
	
	public function __construct(){
		
		$this->set_source();
		
	}
	
	private function set_source(){
		
		if ( ! empty( $_GET['source'] ) ){
			
			$this->source = sanitize_text_field( $_GET['source'] );
			
		} // end if
		
	}
	
	public function get_article(){
		
		$ccl_query = new CCL_Query_Core();
			
		$ccl_article = new CCL_Article_Core();
		
		$wp_rest_item = $ccl_query->get_post_from_rest( $this->source );
		
		
		
		$article = $ccl_article->get_rest_article( $wp_rest_item );
		
		return $article;
		
	}
	
	
}
$cahnrswp_core_service_ajax = new CAHNRSWP_Core_Service_Ajax();

$article = $cahnrswp_core_service_ajax->get_article();

?>
<h1><?php echo  $article['title'];?></h1>
<?php echo  $article['content'];?>
