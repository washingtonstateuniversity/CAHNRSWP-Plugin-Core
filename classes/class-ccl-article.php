<?php
/*
 * version: 0.7.3
*/

class CCL_Article_Core {
	
	public function get_single_article( $url ){
		
		$site_url = get_site_url();
		
		if ( strpos( $site_url , $url ) !== false ) {
			
			// check id and do local query
			
			$postid = url_to_postid( $url );
			
			$article = 'local';
			
		} else {
			
			// do WP Rest query
			
			$article = 'remote';
			
		} // end if
		
		return $article;
		
	} // end method get single article
	
	public function get_articles_from_query( $query_args , $args = array() ){
		
		$articles = array();
		
		$query = new WP_Query( $query_args );
		
		if ( $query->have_posts() ){
			
			while ( $query->have_posts() ){
				
				$query->the_post();
				
				$article = $this->get_post_article( $query->post , $args );
				
				$articles[] = $this->get_article_display( $article , $args );
				
			} // end while
			
		} // end if
		
		wp_reset_postdata();
		
		return $articles;
		
	}
	
	public function get_article_display( $article , $args = array() ) {
		
		$this->set_article_advanced( $article , $args );
		
		$html = '';
		
		if ( empty( $args['display'] ) ) $args['display'] = 'promo';
		
		switch ( $args['display'] ){
			case 'full':
				$html .= $this->get_full_html( $article , $args );
				break;
			case 'list':
				$html .= $this->get_list_html( $article , $args );
				break;
			case 'search-result':
				$html .= $this->get_search_result_html( $article , $args );
				break;
			case 'promo-gallery':
			case 'gallery':
				$html .= $this->get_gallery_html( $article , $args );
				break;
			case 'accordion':
				$html .= $this->get_accordion_html( $article , $args );
				break;
			case 'article-accordion':
				$html .= $this->get_article_section_accordion( $article , $args );
				break;
			case 'promo-small':
				$html .= $this->get_promo_small_html( $article , $args );
				break;
			case 'promo':
			default:
				$html .= $this->get_promo_html( $article , $args );
				break;
		}; // end switch
		
		return $html;
		
	}
	
	public function get_article_link( $link , $args = array() ) {
		
		$class = array();
		
		$html = '<a href="' . $link . '" ';
		
		if( ! empty( $args['show_lightbox'] ) ){
		
			$html .= 'class="clb-action" ';
			
		} // end if
		
		if( ! empty( $args['new_window'] ) ){
			
			$html .= 'target="_blank" ';
			
		} // end if
		
		$html .= ' >';
		
		return $html;
		
	} 
	
	
	public function get_rest_article( $wp_rest_item , $args = array() ){
		
		$article = array();
		
		$article['type'] = ( ! empty( $wp_rest_item['type'] ) )? $wp_rest_item['type'] : '';
				
		$article['title'] = ( ! empty( $wp_rest_item['title'] ) )? $wp_rest_item['title'] : '';
			
		$article['content'] = ( ! empty( $wp_rest_item['content'] ) )? $wp_rest_item['content'] : '';
			
		$article['excerpt'] = ( ! empty( $wp_rest_item['excerpt'] ) )? $wp_rest_item['excerpt'] : '';
		
		$article['link'] = ( ! empty( $wp_rest_item['link'] ) )? $wp_rest_item['link'] : '';
		
		$article['link_start'] = $this->get_article_link( $article['link'] , $args );
		
		$article['link_end'] = ( ! empty( $wp_rest_item['link'] ) )? '</a>' : '';
		
		$article['author'] = ( ! empty( $wp_rest_item['author']['name'] ) )? $wp_rest_item['author']['name'] : '';
		
		$article['date'] = ( ! empty( $wp_rest_item['date'] ) )? $wp_rest_item['date'] : '';
		
		if ( ! empty( $wp_rest_item['featured_image']['attachment_meta']['sizes']['thumbnail']['url'] ) ) {
			
			$article['img'] = '<img src=" '
			 			. $wp_rest_item['featured_image']['attachment_meta']['sizes']['thumbnail']['url']
						. '" />';
						
			$article['img'] = apply_filters( 'post_thumbnail_html' , $article['img'] , false, false, 'thumbnail', array() );
			
		}; // end if
		
		$cats = array();
		
		if ( ! empty( $wp_rest_item['terms']['category'] ) ){
			
			foreach( $wp_rest_item['terms']['category'] as $category ){
				
				$cats[] = $category['slug'];
				
			} // end foreach
			
		} // end if
		
		$article['categories'] = $cats;
		
		return apply_filters( 'get_ccl_article' , $article , $args );
		
	}
	
	public function get_post_article( $post , $args = array() ){
		
		$args = apply_filters( 'ccl_get_post_article_args' , $args , $post );
		
		$article = array();
		
		$article['type'] = $post->post_type;
				
		$article['title'] = apply_filters( 'the_title' , $post->post_title );
			
		$article['content'] = apply_filters( 'the_content' , $post->post_content );
		
		if ( isset( $post->post_excerpt ) && $post->post_excerpt ){
			
			$article['excerpt'] = apply_filters( 'the_excerpt' , $post->post_excerpt );
		
		} else {
			
			$article['excerpt'] = wp_trim_words( strip_shortcodes( $article['excerpt'] ) , 35 );
			
		}// end if
		
		$img_size = ( ! empty ( $args['img_size'] ) )?  $args['img_size'] : 'thumbnail';
		
		$article['img'] = get_the_post_thumbnail( $post->ID , $img_size );
		
		if ( ! empty ( $args['more_url'] ) && ! empty ( $args['more_rewrite'] ) && $args['more_rewrite'] ){
		
			$article['link'] = $args['more_url'];
		
		} else {
			
			$article['link'] = get_permalink( $post->ID );
			
		} // end if 
		
		$article['link_start'] = $this->get_article_link( $article['link'] , $args );
		
		$article['link_end'] = '</a>';
		
		
		return $article;
		
	}
	
	/*
	 * @desc - Unset items items that are not used in this instance.
	 * @param object $post - Modified post object.
	 * @param array $args- Current item instance.
	*/
	public static function set_article_advanced( &$article , $args ){
		
		if ( ! empty( $args['no_link'] ) ) {
			
			$article['link_start'] = '';
			
			$article['link_end'] = '';
			 
		} // end if
		
		if ( ! empty( $args['no_title'] ) ) unset( $article['title'] );
		
		if ( ! empty( $args['no_text'] ) ) {
			
			unset( $article['content'] );
			
			unset( $article['excerpt'] );
			
		};
		
		if ( ! empty( $args['show_content'] ) ) {
			
			$article['excerpt'] = $article['content'];
			
		};
		
		if ( empty( $args['show_date'] ) ) {
			
			unset( $article['post_date'] );
			
		}; 
		
		if ( empty( $args['show_author'] ) ) {
			
			unset( $article['author'] );
			
		}; 
		
		if ( ! empty( $args['short_excerpt'] ) ){
			
			$article['excerpt'] = wp_trim_words( $article['excerpt'] , 15 );
			
		} // end if
		 		
	} // end method cwp_post_obj_advanced
	
	
	public function get_article_section_accordion( $article, $args ){
		
		$id = 'ccl-article-accordion-' . rand( 0 , 100000 );
		
		$html = '';
		
		$open = ( ! empty( $args['open'] ) )? 'block' : 'none'; 
		
		$cats = '';
		
		if ( ! empty( $article['categories'] ) && is_array( $article['categories'] ) ) {
			
			$cats = implode( ' ' , $article['categories'] ); 
			
		} // end if
		
		$html .= '<ul id="' . $id . '" class="ccl-article-accordion ' . $cats . '">';
			
			$html .= '<li class="ccl-title">' . $article['title'] . '</li>';
			
			$html .= '<li class="ccl-content" style="display:' . $open . '">' . $article['content'] . '</li>';
		
		$html .= '</ul>';
		
		$html .='<script>if ( typeof jQuery !== undefined ){ jQuery( "body").on( "click" , "#' . $id . ' > .ccl-title" , function(){ var t = jQuery( this ); t.toggleClass( "active" ); t.siblings( ".ccl-content" ).slideToggle("medium"); var u = t.parent().siblings( ".ccl-article-accordion"); u.children(".ccl-content").slideUp( "medium"); u.children(".ccl-title").removeClass("active"); });};</script>';
		
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
	
	public function get_gallery_html( $article, $args ){
		
		$has_image = '';
		
		$style = '';
		
		if ( ! empty( $article['img'] ) ) { 
			
			$has_image = ' has-image';
			
		} // end if 
		
		if ( ! empty( $args[ 'per_row' ] ) && '1' !=  $args[ 'per_row' ] ){
			
			$width = ( 100 / $args[ 'per_row' ] );
			
			$width = round( $width , 2, PHP_ROUND_HALF_DOWN );
			
			$style = 'margin: 0 0 1.5rem; 
					padding: 0; display: inline-block; 
					vertical-align: top; width: ' 
					. $width . '% ;';
			
		} else {
			
			$style = 'margin: 0 0 1.5rem; padding: 0; display: block;';
			
		};// end if
		
		$html = '<ul class="cwp-item gallery '. $has_image . ' ' . $article['type'] . '" style="list-style-type: none;' . $style . '" >';
    
        if ( $has_image ) {
        
			$html .= '<li class="cwp-image" style="margin: 0 0.5rem;">';
			
				$html .= $article['link_start'] . $article['img'] . $article['link_end'];
			
			$html .= '</li>';
        
		} // end if
        
        $html .= '<li class="cwp-content" style="margin: 0 0.5rem; padding:0; list-style-type: none;">';
        
            if ( ! empty( $article['title'] ) ) {
                        
            	$html .= '<h4>' . $article['link_start'] . $article['title'] . $article['link_end'] . '</h4>';
                
			} // end if title
            
            if ( ! empty( $article['post_date'] ) || ! empty( $article['author'] ) ){
                        
                    $html .= '<div class="cwp-post-meta">';
            
                    if ( ! empty( $article['post_date'] ) ) {
                        
                           $html .= '<span class="cwp-post-date">' . $article['post_date'] . '</span>';
                            
                    } // end if post date
                        
                    if ( ! empty( $article['author'] ) ) { 
                        
                            $html .= '<span class="cwp-post-author">' . $article['author'] . '</span>';
                            
                    } // end if
                    
                    $html .= '</div>';
                
			} // end if
            
            if ( ! empty( $article['excerpt'] ) ){
                        
                    $html .= '<div class="cwp-post-excerpt">';
                        
                        $html .= $article['excerpt'];
                    
                    $html .= '</div>';
                
			} // end if excerpt
        
        $html .= '</li>';
    
    $html .= '</ul>';
		
		return $html;
		
	}
	
	
	public function get_search_result_html( $article, $args ){
		
		if( empty( $article['excerpt'] ) ){
			
			$article['excerpt'] = wp_trim_words( strip_shortcodes( $article['content'] ) , 35 );
			
		} // end if
		
		$ul_style = 'list-style-type: none;';
		
		$li_style = '';
		
		$has_image = ( empty( $article['img'] ) )? ' has_image' : '';
		
		$article['excerpt'] = wp_trim_words( strip_shortcodes( $article['excerpt'] ) , 35 );
		
		$html = '<ul class="cwp-item search-result '. $has_image . ' ' . $article['type'] . '" style="' . $ul_style . 'margin: 0; padding: 0.5 0;" >';
		
			$html .= '<li>';
			
				if ( ! empty( $article['img'] ) ){
			
					$html .= '<a href="' . $article['link'] . '" style="display: inline-block; width: 10%; vertical-align: top; margin-right: 2%;" >' . $article['img'] . '</a>'; 
			
				} // end if
				
				$html .= '<ul class="search-result-content '. $has_image . ' ' . $article['type'] . '" style="' . $ul_style . 'margin: 0; padding: 0; width: 85%; display: inline-block; vertical-align: top;" >';
				
					$html .= '<li class="cwp-title">';
						
						$html .= '<h4>' . $article['link_start'] . $article['title'] . $article['link_end'] . '</h4>';
						
					$html .= '</li>';
					
					$html .= '<li class="cwp-meta">';
						
						$html .= $article['link_start'] . $article['link'] . $article['link_end'];
						
					$html .= '</li>';
					
					if ( ! empty( $article['excerpt'] ) ){
					
						$html .= '<li class="cwp-excerpt">';
						
							$html .= $article['excerpt'];
						
						$html .= '</li>';
					
					} // end if
				
				$html .= '</ul>';
			
			$html .= '</li>';
    
    	$html .= '</ul>';
		
		return $html;
		
	}
	
	public function get_promo_small_html( $article, $args ){
		
		if( empty( $article['excerpt'] ) ){
			
			$article['excerpt'] = $article['content'];
			
		} // end if
		
		$ul_style = 'list-style-type: none;';
		
		$li_style = '';
		
		$has_image = ( empty( $article['img'] ) )? ' has_image' : '';
		
		
		$html = '<ul class="cwp-item promo-small '. $has_image . ' ' . $article['type'] . '" style="' . $ul_style . 'margin: 0; padding: 0.5rem 0;" >';
			
			if ( ! empty( $article['img'] ) ){
		
				$html .= '<li class="cwp-image" style="display: inline-block; width: 10%; vertical-align: top; margin-right: 2%;">';
				
					$html .= '<a href="' . $article['link'] . '"  >' . $article['img'] . '</a>'; 
						
				$html .= '</li>';
		
			} // end if
			
			$html .= '<li class="cwp-content promo-content '. $has_image . ' ' . $article['type'] . '" style="margin: 0; padding: 0; width: 85%; display: inline-block; vertical-align: top;">';
				
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
	
	public function get_list_html( $article, $args ){
		
		if( empty( $article['excerpt'] ) ){
			
			$article['excerpt'] = $article['content'];
			
		} // end if
		
		$ul_style = 'list-style-type: none;';
		
		$li_style = '';
		
		
		$html = '<ul class="cwp-item list ' . $article['type'] . '" style="' . $ul_style . 'margin: 0; padding: 0.5rem 0;" >';
			
			$html .= '<li class="cwp-content list-content ' . $article['type'] . '" style="margin: 0; padding: 0; display: block;">';
				
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
	
	public function get_full_html( $article, $args ){
		
		$html = $article['content'];
		
		return $html;
		
	}
	
}