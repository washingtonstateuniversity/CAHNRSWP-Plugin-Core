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
</p><p>
	<label>Count: </label>
    <input type="text" style="width: 40px;" name="<?php echo $this->get_field_name( 'posts_per_page' )?>" value="<?php echo $instance['posts_per_page'];?>" />
</p>