<?php CAHNRSWP_Core_Form_Model::cwp_set_core_defaults( $instance ); ?>
<ul class="cwp-form">
	<li class="cwp-form-section cwp-field-set">
    </li>
    <li class="cwp-form-section cwp-field-accordion active-field-accordion">
    	<a href="#" class="cwp-form-section-title">Step 1: Select Feed Type</a>
        <ul class="cwp-form-section-content">
        	<li class="cwp-field-set">
            	<p>
            		<input type="radio" class="dynamic-radio-field" data-field="feed-static" name="<?php echo $this->get_field_name( 'feed_type' )?>" value="static" <?php checked( $instance['feed_type'] , 'static' ); ?> /> <strong>Static:</strong> Select specific post/pages by URL.
                </p><p>
            		<input type="radio" class="dynamic-radio-field" data-field="feed-dynamic" name="<?php echo $this->get_field_name( 'feed_type' )?>" value="dynamic" <?php checked( $instance['feed_type'] , 'dynamic' ); ?>/> <strong>Dynamic:</strong> Feed by type, categories or tags. 
            	</p>
            </li>
        </ul>
    </li>
    <li class="cwp-form-section cwp-field-accordion">
    	<a href="#" class="cwp-form-section-title">Step 2: Select Content</a>
        <ul class="cwp-form-section-content">
        	<li class="cwp-field-set dynamic-field feed-static<?php if ( 'static' == $instance['feed_type'] ) echo ' active-field' ;?>">
            	URL: <input type="text" value="" data-addname="<?php echo $this->get_field_name( 'insert_urls' )?>" /><br />
                <a href="#" class="action-add-insert pagebuilder-button-standard">+ ADD</a><br />
                <h5>Selected Items:</h5>
                <ul class="add-insert">
                	<?php if ( $instance['insert_urls'] && is_array( $instance['insert_urls'] ) ):?>
                    	<?php foreach ( $instance['insert_urls'] as $url ): ?>
                    		<li class="add-insert-item">
                    			<?php echo $url;?>
                        		<input type="hidden" name="<?php echo $this->get_field_name( 'insert_urls' )?>[]" value="<?php echo $url;?>" />
                                <a href="#"></a>
                            </li>
                    	<?php endforeach; ?>
                    <?php endif;?> 
                </ul>
            </li>
            <li class="cwp-field-set dynamic-field feed-dynamic<?php if ( 'dynamic' == $instance['feed_type'] ) echo ' active-field' ;?>">
            	<p>
                    <label>Source: </label><input type="text" name="<?php echo $this->get_field_name( 'feed_source' )?>" value="<?php echo $instance['feed_source'];?>" />
                </p><p>
                	<label>Post Type: </label><select name="<?php echo $this->get_field_name( 'post_type' )?>">
                    	<option value="any">Any</option>
                        <?php
						 
							$post_types = CAHNRSWP_Core_Form_Model::cwp_get_post_types();
							
							foreach( $post_types as $id => $name ) {
								
								echo '<option value="' 
									. $id . '" ' 
									. selected( $instance['post_type'] , $id ) 
									. '>' 
									. $name 
									. '</option>';
								
							}; // end for each
							
						?>
                    </select><br />
                    <span class="helper-text">The post type "any" is not available for feeds from other wordpress sites.</span>
                </p>
                </p><p>
                	<select name="<?php echo $this->get_field_name( 'taxonomy' )?>">
                    	<option value="cat">Categories</option>
                    </select> : 
                    <input type="text" style="width: 50%;" name="<?php echo $this->get_field_name( 'tax_terms' )?>" value="<?php echo $instance['tax_terms'];?>" />
                </p>
            </li>
        </ul>
    </li>
    <li class="cwp-form-section cwp-field-accordion">
    	<a href="#" class="cwp-form-section-title">Step 3: Set Display Style</a>
        <ul class="cwp-form-section-content">
        	<li class="cwp-field-set">
            	<p>
                	<label>Display As: <label>
                	<select class="dynamic-select-field" name="<?php echo $this->get_field_name( 'display' )?>">
                    	<option value="promo" <?php selected( $instance['display'] , 'promo' ); ?> >Promo</option>
                        <option data-field="dynamic-display-row" value="promo-gallery" <?php selected( $instance['display'] , 'promo-gallery' ); ?> >Gallery</option>
                        <option value="list" <?php selected( $instance['display'] , 'list' ); ?> >List</option>
                        <option value="full" <?php selected( $instance['display'] , 'full' ); ?> >Full Content</option>
                    </select> 
                </p><p class="dynamic-display-row dynamic-field<?php if ( 'promo-gallery' == $instance['display'] ) echo ' active-field' ;?>" >
                	<label>Items Per Row: </label>
                    <select name="<?php echo $this->get_field_name( 'per_row' )?>">
                    	<option value="100%" <?php selected( $instance['per_row'] , '100%' ); ?> >1</option>
                        <option value="50%" <?php selected( $instance['per_row'] , '50%' ); ?> >2</option>
                        <option value="33.33%" <?php selected( $instance['per_row'] , '33.33%' ); ?> >3</option>
                        <option value="25%" <?php selected( $instance['per_row'] , '25%' ); ?> >4</option>
                    </select>
                </p>
                <?php include CAHNRSWPCOREDIR . '/inc/inc-form-advanced.php'; ?>
            </li>
        </ul>
    </li>
</ul>