<?php 
	if( !isset( $instance['title'] ) ) $instance['title'] = '';
	if( !isset( $instance['postid'] ) ) $instance['postid'] = '';
	$instance['posts_per_page'] = 1;
	if( !isset( $instance['display'] ) ) $instance['display'] = 'full';
;?>
<div class="cwp-form">
	<?php include CAHNRSWPCOREDIR . '/inc/inc-form-title.php'; ?>
	<div class="cwp-form-section">
    	<a href="#" class="cwp-form-section-title">
        	Basic Settings
        </a>
        <div class="cwp-form-section-content">
        	<p>
            	<input type="text" name="<?php echo $this->get_field_name( 'post__in' ); ?>" value="<?php echo $instance['post__in'];?>" />
                <input type="hidden" name="<?php echo $this->get_field_name( 'post_type' ); ?>" value="any" />
                <input type="hidden" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="1" />
        	</p>
            <p>
            	<label>display As: </label>
                <select name="<?php echo $this->get_field_name( 'display' ); ?>">
                	<option value="list" <?php selected( $instance['display'] , 'list' );?> >List</option>
                    <option value="promo" <?php selected( $instance['display'] , 'promo' );?> >Promo</option>
                    <option value="promo-gallery" <?php selected( $instance['display'] , 'promo-gallery' );?> >Gallery Style</option>
                    <option value="full" <?php selected( $instance['display'] , 'full' );?> >Full Content</option>
                    <option value="accordion" <?php selected( $instance['display'] , 'accordion' );?> >Accordion</option>
                </select>
            </p>
        </div>
    </div>
    <div class="cwp-form-section">
    	<a href="#" class="cwp-form-section-title">
        	Advanced Settings
        </a>
        <div class="cwp-form-section-content">
        	<?php include CAHNRSWPCOREDIR . '/inc/inc-form-advanced.php'; ?>
        </div>
    </div>
</div>