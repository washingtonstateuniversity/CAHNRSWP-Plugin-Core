<?php if ( isset( $instance['more_url'] ) && $instance['more_url'] ){
	
	if ( isset( $instance['more_title'] ) && $instance['more_title'] ) {
		
		$more_text = $instance['more_title'];
		
	} else {
		
		$more_text = 'More';
		
	};
	
	echo '<a class="cwp-more-link" href="' . $instance['more_url'] . '">';
	
	echo $more_text . ' >';
	
	echo '</a>';

};?>