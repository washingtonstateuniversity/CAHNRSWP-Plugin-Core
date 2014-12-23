<?php 
	if( !isset( $instance['title'] ) ) $instance['title'] = '';
	if( !isset( $instance['post_type'] ) ) $instance['post_type'] = 'post';
	if( !isset( $instance['tax_query'] ) ) $instance['tax_query'] = 'category';
	if( !isset( $instance['tax_terms'] ) ) $instance['tax_terms'] = '';
	if( !isset( $instance['posts_per_page'] ) ) $instance['posts_per_page'] = 3;
	if( !isset( $instance['display'] ) ) $instance['display'] = 'promo';
;?>
<div class="cwp-form">
	<?php include CAHNRSWPCOREDIR . '/inc/inc-form-title.php'; ?>
	<div class="cwp-form-section">
    	<a href="#" class="cwp-form-section-title">
        	Basic Settings
        </a>
        <div class="cwp-form-section-content">
        	<p>
                <label>Post Type: </label>
                <select name="<?php echo $this->get_field_name( 'post_type' ); ?>">
                <?php foreach( $post_types as $typeid => $type_name ):?>
                    <option value="<?php echo $typeid;?>" <?php selected( $instance['post_type'] , $typeid );?> ><?php echo $type_name; ?></option>
                <?php endforeach;?>
                </select>
            </p>
            <p>
            	<select id="<?php echo $this->get_field_id( 'tax_query' ); ?>" name="<?php echo $this->get_field_name( 'tax_query' ); ?>">
                	<option value="category" <?php selected( $instance['tax_query'] , 'category' );?> >Categories</option>
                    <option value="post_tag" <?php selected( $instance['tax_query'] , 'post_tag' );?> >Tags</option>
                    <option value="any" <?php selected( $instance['tax_query'] , 'any' );?> >Any</option>
                </select> : 
                <input type="text" name="<?php echo $this->get_field_name( 'tax_terms' ); ?>" value="<?php echo $instance['tax_terms']; ?>" />
            </p>
            <p>
            	<label>Count: </label><input type="text" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo $instance['posts_per_page']; ?>" />
            </p>
            <p>
            	<label>display As: </label>
                <select name="<?php echo $this->get_field_name( 'display' ); ?>">
                	<option value="list" <?php selected( $instance['display'] , 'list' );?> >List</option>
                    <option value="promo" <?php selected( $instance['display'] , 'promo' );?> >Promo</option>
                    <option value="promo-gallery" <?php selected( $instance['display'] , 'promo-gallery' );?> >Gallery Style</option>
                    <option value="full" <?php selected( $instance['display'] , 'full' );?> >Full Content</option>
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