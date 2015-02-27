<?php 
class CAHNRSWP_Core_Shortcode_Submenu {
	
	public function __construct(){
		
		add_shortcode( 'CWPSUBMENU' , array( $this , 'cwp_render_shortcode' ) );
		
	} // End Method __construct
	
	
	public function cwp_render_shortcode( $instance ) {
		
		$html = '';
		
		if ( ! empty( $instance['menu'] ) ){ 
	  
			$menu = wp_get_nav_menu_items( $instance['menu'] );
			
			if ( $menu ) {
				
				ob_start();
				
				include CAHNRSWPCOREDIR . 'inc/inc-display-shortcode-submenu.php';
				
				$html .= ob_get_clean();
				
			}; // end if
			
		}; // end if
		
		return $html;
		
	} // End Method cwp_tab_content
	
	
};

$cahnrswp_core_shortcode_submenu = new CAHNRSWP_Core_Shortcode_Submenu();