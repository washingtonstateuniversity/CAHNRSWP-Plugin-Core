<?php

$item_link = ( isset( $item->link ) )? '<a href="' . $item->link . '" >' : '';

$item_link_end = ( isset( $item->link ) )? '</a>' : '';

if ( isset( $item->img ) && $item->img ) {
	
	$has_image = ' has-image';
	
} else {
	
	$has_image = false;
	
}; // end if

if ( ! empty( $instance[ 'per_row' ] ) && '100%' !=  $instance[ 'per_row' ] ){
	
	$style = 'style="margin: 0 0 1.5rem; 
			padding: 0; display: inline-block; 
			vertical-align: top; width: ' 
			. $instance[ 'per_row' ] . ';" ';
	
};// end if

?>
<li class="promo-gallery <?php echo $has_image . ' ' . $item->content_type; ?>" <?php if( ! empty( $style ) ) echo $style; ?> >

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