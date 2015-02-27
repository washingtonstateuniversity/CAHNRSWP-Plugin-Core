<?php
class CAHNRSWP_Core_Slider {
	
	private $instance;
	
	public $controller;
	
	public function __construct( $instance = array() , $controller = false ){
		
		$this->instance = $this->set_defaults( $instance );
		
		$this->controller = $controller;
		
	} // end __construct
	
	public function get_html(){
		
		$html = '';
		
		$items = CAHNRSWP_Core_Query::cwp_get_items( $this->instance );
		
		if ( $items ) {
			
			$html .= $this->get_slider_wrapper( true );
			
			$item_html = '';
			
			$slide_index = 0;
			
			foreach ( $items as $index => $item ) {
				
				CAHNRSWP_Core_Query::cwp_item_advanced( $item , $this->instance );
				
				ob_start();
		
				CAHNRSWP_Core_Post_Display::cwp_display_post( $item , $this->instance );
				
				$item_html .= ob_get_clean();
				
				if ( ( $this->instance['per_row'] - 1 ) == $slide_index || count( $items ) == ( $index + 1 ) ) {
					
					
					$html .= CAHNRSWP_Core_Post_Display::cwp_add_display_wrapper( $this->instance , $item_html , 'width:100%;' );
					
					$item_html = '';
					
					$slide_index = 0;
					
				} else {
					
					$slide_index++;
					
				}; // end if
				
				
			}; // end foreach
			
			//$html .= CAHNRSWP_Core_Post_Display::cwp_add_display_wrapper( $this->instance , $item_html  );
			
			$html .= $this->get_slider_wrapper();
			
		}; // end if
		
		return $html;
		
	}
	
	public function get_field_name( $name ){
		
		if ( $this->controller && method_exists( $this->controller , ' get_field_name' ) ){
			
			$this->controller->get_field_name( $name );
			
		} else {
			
			$name;
			
		};// end if
		
	} // end method 
	
	public function set_defaults( $instance ){
		
		if ( ! isset( $instance['feed_type'] ) ) $instance['feed_type'] = 'dynamic';
		
		if ( ! isset( $instance['insert_urls'] ) || ! is_array( $instance['insert_urls'] ) ){
			
			$instance['insert_urls'] = array();
			
		}; // end if
		
		if ( empty( $instance['feed_source'] ) ) $instance['feed_source'] = get_site_url();
		
		if( !isset( $instance['title'] ) ) $instance['title'] = '';
		
		if( !isset( $instance['post_type'] ) ) $instance['post_type'] = 'post';
		
		if( !isset( $instance['tax_query'] ) ) $instance['tax_query'] = 'category';
		
		if( !isset( $instance['tax_terms'] ) ) $instance['tax_terms'] = '';
		
		if( !isset( $instance['display'] ) ) $instance['display'] = 'promo-gallery';
		
		if( !isset( $instance['per_row'] ) ) $instance['per_row'] = 4;
		
		if( !isset( $instance['slide_count'] ) ) $instance['slide_count'] = 2;
		
		$instance['posts_per_page'] = $instance['slide_count'] * $instance['visible'];
		
		$instance['show_id'] = rand( 100, 10000000 );
		
		$instance['tag'] = CAHNRSWP_Core_Post_Display::cwp_get_tag( $instance );
		
		return $instance;
		
	} // end method cwp_set_defaults
	
	public function get_slider_wrapper( $start = false ) {
		
		$html = '';
		
		if ( $start ) {
			
			$slide_index = 0;
			
			$show_data = CAHNRSWP_Core_Post_Display::cwp_get_slideshow_settings( $this->instance ); 
			
			echo '<div class="cwp-slider slider-' . $this->instance['per_row'] . '-visible" style="position: relative;" >';
				
				if ( ! empty( $this->instance['title'] ) ){
							
					echo '<h3 class="cwp-widget-title">' . $this->instance['title'] . '</h3>';
					
				}; // end if
				
				echo '<a href="#" id="cycle-prev-' . $this->instance['show_id'] . '" class="cycle-prev"></a>';
							
				echo '<div class="cycle-pager" id="pager-' . $this->instance['show_id'] . '"></div>';
				
				echo '<a href="#" id="cycle-next-' . $this->instance['show_id'] . '" class="cycle-next"></a>';
				
				echo '<div class="cwp-slider-wrap cycle-slideshow" ' . implode( ' ', $show_data )  . '>';
			
		} else {
			
			$html = '</div></div>'; 
			
		};
		
		return $html;
		
	}
	
}