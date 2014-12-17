<div class="cwp-form">
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
            	<select name="<?php echo $this->get_field_name( 'taxonomy' ); ?>">
                	<option value="category" <?php selected( $instance['taxonomy'] , 'category' );?> >Categories</option>
                    <option value="post_tag" <?php selected( $instance['taxonomy'] , 'post_tag' );?> >Tags</option>
                    <option value="any" <?php selected( $instance['taxonomy'] , 'any' );?> >Any</option>
                </select> : 
                <input type="text" name="<?php echo $this->get_field_name( 'tax_names' ); ?>" value="<?php echo $instance['tax_names']; ?>" />
            </p>
            <p>
            	<label>Count: </label><input type="text" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" />
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
        </div>
    </div>
</div>