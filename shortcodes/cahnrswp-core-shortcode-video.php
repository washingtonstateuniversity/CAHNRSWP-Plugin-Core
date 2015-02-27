<?php 
class CAHNRSWP_Core_Shortcode_Video {
	
	private $defaults = array( 
							'title'    => '',
							'source'   => false,
							'class'    => '',
							'type'     => 'youtube',
							'autoplay' => false,
							);
	
	public function __construct(){
		
		add_shortcode( 'cwpvideo' , array( $this , 'cwp_render_shortcode' ) );
		
	} // End Method __construct
	
	
	public function cwp_render_shortcode( $instance ) {
		
		$instance = shortcode_atts( $this->defaults , $instance );
		
		$html = '';
		
		if ( ! empty( $instance['source'] ) ){
			
			$html .= '<iframe ';
			
			if ( 'in-wrap' == $instance['class'] ) {
			
				$html .='style="position: absolute; top: 0; left: 0; height: 100%; width: 100%;" ';
			
			}; // end if
			
			if ( $instance['class'] ) {
			
				$html .='class="' . $instance['class'] . '" ';
			
			}; // end if
			
			$html .= 'src="'. $instance['source'];
			
			if ( $instance['autoplay'] ) {
			
				$html .= '?autoplay=1';
			
			}; // end if
			
			$html .= '" frameborder="0" allowfullscreen></iframe>';
			
		}; // end if
		
		return $html;
		
	} // End Method cwp_tab_content
	
};

$cahnrswp_core_shortcode_video = new CAHNRSWP_Core_Shortcode_Video();