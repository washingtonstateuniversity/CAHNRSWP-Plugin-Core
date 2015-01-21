<?php

$item_link = CAHNRSWP_Core_Post_Display::cwp_get_item_link( $item , $instance , true );

$item_link_end = CAHNRSWP_Core_Post_Display::cwp_get_item_link( $item , $instance );

if ( isset( $item->img ) && $item->img ) {
	
	$has_image = ' has-image';
	
} else {
	
	$has_image = false;
	
}; // end if

if ( ! empty( $instance[ 'per_row' ] ) && '1' !=  $instance[ 'per_row' ] ){
	
	$width = ( 100 / $instance[ 'per_row' ] );
	
	$width = round( $width , 2, PHP_ROUND_HALF_DOWN );
	
	$style = 'style="margin: 0 0 1.5rem; 
			padding: 0; display: inline-block; 
			vertical-align: top; width: ' 
			. $width . '% ;" ';
	
};// end if

?>
<li class="cwp-item promo-gallery <?php echo $has_image . ' ' . $item->content_type; ?>" <?php if( ! empty( $style ) ) echo $style; ?> >

	<?php if ( $has_image ):?>
	
    <div class="cwp-image" style="margin: 0 0.5rem;">
    
    	<?php echo $item_link. $item->img . $item_link_end; ?>
    
    </div>
    
    <?php endif;?>
    
    <ul class="cwp-content" style="margin: 0 0.5rem; padding:0; list-style-type: none;">
    
    	<?php if ( isset( $item->title ) ): ?>
					
				<li class="cwp-post-title">
		
					<h4>
                    
                    	<?php echo $item_link . $item->title . $item_link_end; ?>
				 
					</h4>
				
				</li>
			
		<?php endif;?>
    	
        <?php if ( isset( $item->post_date ) || isset( $item->author ) ): ?>
					
				<li class="cwp-post-meta">
		
					<?php if ( isset( $item->post_date ) ) : ?> 
                    
                    	<span class="cwp-post-date"><?php echo $item->post_date; ?></span>
                        
                    <?php endif;?>
                    
                    <?php if ( isset( $item->post_date ) ) : ?> 
                    
                    	<span class="cwp-post-author"><?php echo $item->author; ?></span>
                        
                    <?php endif;?>
				
				</li>
			
		<?php endif;?>
        
        <?php if ( isset( $item->excerpt ) ): ?>
					
				<li class="cwp-post-excerpt">
                    
                    <?php echo $item->excerpt; ?>
				
				</li>
			
		<?php endif;?>
    
    </ul>

</li>