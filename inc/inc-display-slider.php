<?php
$slide_index = 0;
			
$show_data = CAHNRSWP_Core_Post_Display::cwp_get_slideshow_settings( $instance ); 

echo '<div class="cwp-slider slider-' . $instance['per_row'] . '-visible" style="position: relative;" >';
	
	if ( ! empty( $instance['title'] ) ){
				
		echo '<h3 class="cwp-widget-title">' . $instance['title'] . '</h3>';
		
	}; // end if
	
	echo '<a href="#" id="cycle-prev-' . $instance['show_id'] . '" class="cycle-prev"></a>';
				
	echo '<div class="cycle-pager" id="pager-' . $instance['show_id'] . '"></div>';
	
	echo '<a href="#" id="cycle-next-' . $instance['show_id'] . '" class="cycle-next"></a>';
	
	echo '<div class="cwp-slider-wrap cycle-slideshow" ' . implode( ' ', $show_data )  . '>';
	
		foreach ( $items as $index => $item ) {
			
			if ( 0 == $slide_index ) {
				
				echo CAHNRSWP_Core_Post_Display::cwp_display_wrapper( $instance , true , 'width: 100%; margin: 0; padding: 0;list-style-type: none;' );
				
			}; // end if
			
			CAHNRSWP_Core_Query::cwp_item_advanced( $item , $instance );
		
			CAHNRSWP_Core_Post_Display::cwp_display_post( $item , $instance );
			
			if ( ( $instance['per_row'] - 1 ) == $slide_index || count( $items ) == ( $index + 1 ) ) {
				
				echo CAHNRSWP_Core_Post_Display::cwp_display_wrapper( $instance );
				
				$slide_index = 0;
				
			} else {
				
				$slide_index++;
				
			}; // end if
			
		}; // end foreach
	
	echo '</div>';

echo '</div>';