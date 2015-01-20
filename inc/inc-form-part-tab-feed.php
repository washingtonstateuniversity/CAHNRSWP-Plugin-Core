
	<div class="cwp-form-section">
    	<a href="#" class="cwp-form-section-title">
        	Tab <?php echo $i;?>
        </a>
        <div class="cwp-form-section-content">
        	<p>
                <label>Post Type: </label>
                <select name="<?php echo $this->get_field_name( 'post_type_' . $i ); ?>">
                <?php foreach( $post_types as $typeid => $type_name ):?>
                    <option value="<?php echo $typeid;?>" <?php selected( $instance['post_type_' . $i ] , $typeid );?> ><?php echo $type_name; ?></option>
                <?php endforeach;?>
                </select>
            </p>
            <p>
            	<select id="<?php echo $this->get_field_id( 'tax_query_' . $i  ); ?>" name="<?php echo $this->get_field_name( 'tax_query_' . $i  ); ?>">
                	<option value="category" <?php selected( $instance['tax_query_' . $i ] , 'category' );?> >Categories</option>
                    <option value="post_tag" <?php selected( $instance['tax_query_' . $i ] , 'post_tag' );?> >Tags</option>
                    <option value="any" <?php selected( $instance['tax_query_' . $i ] , 'any' );?> >Any</option>
                </select> : 
                <input type="text" name="<?php echo $this->get_field_name( 'tax_terms_' . $i  ); ?>" value="<?php echo $instance['tax_terms_' . $i ]; ?>" />
            </p>
            <p>
            	<label>Count: </label><input type="text" name="<?php echo $this->get_field_name( 'posts_per_page_' . $i  ); ?>" value="<?php echo $instance['posts_per_page_' . $i ]; ?>" />
            </p>
            <p>
            	<label>display As: </label>
                <select name="<?php echo $this->get_field_name( 'display_' . $i  ); ?>">
                	<option value="list" <?php selected( $instance['display_' . $i ] , 'list' );?> >List</option>
                    <option value="promo" <?php selected( $instance['display_' . $i ] , 'promo' );?> >Promo</option>
                    <option value="promo-gallery" <?php selected( $instance['display_' . $i ] , 'promo-gallery' );?> >Gallery Style</option>
                    <option value="full" <?php selected( $instance['display_' . $i ] , 'full' );?> >Full Content</option>
                </select>
            </p>
        </div>
    </div>
