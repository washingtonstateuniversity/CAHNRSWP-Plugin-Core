<?php
class Service_CAHNRSWP_Core_Iframe {
	
	public $url; 
	
	public $content;
	
	public function __construct(){
		
		$this->url = $_GET[ 'url'];
		
	} // end method __construct
	
	private function cwp_get_content(){
		
		
		
	} // end cwp_get_content
	
} // end class Service_CAHNRSWP_Core_Iframe

$cwp_core_iframe = new Service_CAHNRSWP_Core_Iframe();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<?php wp_head();?>
</head>
<body>
<?php var_dump( $cwp_core_iframe->url );?>
</body>
</html>