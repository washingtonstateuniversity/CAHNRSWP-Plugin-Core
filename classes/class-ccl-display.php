<?php
/*
 * version: 0.0.1
*/

class CCL_Display_Core {
	
	public function get_article_html( $article , $instance = array() ) {
		
		$html = '';
		
		if ( empty( $instance['display'] ) ) $instance['display'] = 'promo';
		
		switch ( $instance['display'] ){
			/*case 'full':
				$html .= $this->get_full_html( $article , $instance );
				break;
			case 'list':
				$html .= $this->get_list_html( $article , $instance );
				break;
			case 'search-result':
				$html .= $this->get_search_result_html( $article , $instance );
				break;
			case 'promo-gallery':
			case 'gallery':
				$html .= $this->get_gallery_html( $article , $instance );
				break;
			
			case 'article-accordion':
				$html .= $this->get_article_section_accordion( $article , $instance );
				break;
			case 'promo-small':
				$html .= $this->get_promo_small_html( $article , $instance );
				break;*/
			case 'accordion':
				$html .= $this->get_accordion_html( $article , $instance );
				break;
			case 'promo':
			default:
				$html .= $this->get_promo_html( $article , $instance );
				break;
		}; // end switch
		
		return $html;
		
	}
	
	
	
	public function get_promo_html( $article, $args ){
		
		if( empty( $article['excerpt'] ) ){
			
			$article['excerpt'] = $article['content'];
			
		} // end if
		
		$ul_style = 'list-style-type: none;';
		
		$li_style = '';
		
		$has_image = ( empty( $article['img'] ) )? ' has_image' : '';
		
		
		$html = '<ul class="cwp-item promo '. $has_image . ' ' . $article['type'] . '" style="' . $ul_style . 'margin: 0; padding: 0.5rem 0;" >';
			
			if ( ! empty( $article['img'] ) ){
		
				$html .= '<li class="cwp-image" style="display: inline-block; width: 20%; vertical-align: top; margin-right: 2%;">';
				
					$html .= '<a href="' . $article['link'] . '"  >' . $article['img'] . '</a>'; 
						
				$html .= '</li>';
		
			} // end if
			
			$html .= '<li class="cwp-content promo-content '. $has_image . ' ' . $article['type'] . '" style="margin: 0; padding: 0; width: 75%; display: inline-block; vertical-align: top;">';
				
				if ( ! empty( $article['excerpt'] ) ){
				
					$html .= '<h4 class="cwp-title">' . $article['link_start'] . $article['title'] . $article['link_end'] . '</h4>';
					
				} // end if
					
				/*$html .= '<div class="cwp-meta">';
					
					$html .= $article['link_start'] . $article['link'] . $article['link_end'];
					
				$html .= '</div>';*/
					
				if ( ! empty( $article['excerpt'] ) ){
				
					$html .= '<div class="cwp-excerpt">';
					
						$html .= wp_trim_words( strip_shortcodes( $article['excerpt'] ) , 55 );
					
					$html .= '</div>';
				
				} // end if
			
			$html .= '</li>';
    
    	$html .= '</ul>';
		
		return $html;
		
	}
	
	public function get_accordion_html( $article, $args ){
		
		$id = 'ccl-article-accordion-' . rand( 0 , 100000 );
		
		$css = ( ! empty( $args['css_hook'] ) )? $args['css_hook'] : '';
		
		$html = '';
		
		$html .= '<div class="cwp-accordion post ' . $css . '">';
		
			$html .= '<h4>' . $article['link_start'] . $article['title'] . $article['link_end'] . '</h4>';
			
			$html .= '<div class="cwp-content" style="display: none;">';
				
				$html .= $article['content'];
			
			$html .= '</div>';
			
		$html .= '</div>';
		
		return $html;
		
	}
	
	
}