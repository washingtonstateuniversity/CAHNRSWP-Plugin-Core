<p style="display: inline-block; width: 48%; margin-right: 2%; vertical-align: top;">
	<input type="checkbox" name="<?php echo $this->get_field_name( 'no_img' ); ?>" value="1" <?php checked( $instance['no_img'] , 1 );?> /> 
    	<label>Hide Image</label><br />
	<input type="checkbox" name="<?php echo $this->get_field_name( 'no_title' ); ?>" value="1" <?php checked( $instance['no_title'] , 1 );?> /> 
    	<label>Hide Title</label><br />
    <input type="checkbox" name="<?php echo $this->get_field_name( 'no_text' ); ?>" value="1" <?php checked( $instance['no_text'] , 1 );?> /> 
    	<label>Hide Text</label><br />
    <input type="checkbox" name="<?php echo $this->get_field_name( 'no_link' ); ?>" value="1" <?php checked( $instance['no_link'] , 1 );?> /> 
    	<label>Remove Link</label><br />
</p><p style="display: inline-block; width: 48%; margin-right: 2%; vertical-align: top;">
	<input type="checkbox" name="<?php echo $this->get_field_name( 'show_content' ); ?>" value="1" <?php checked( $instance['show_content'] , 1 );?> /> 
    	<label>Full Content</label><br />
    <input type="checkbox" name="<?php echo $this->get_field_name( 'show_date' ); ?>" value="1" <?php checked( $instance['show_date'] , 1 );?> /> 
    	<label>Show Date</label><br />
    <input type="checkbox" name="<?php echo $this->get_field_name( 'show_author' ); ?>" value="1" <?php checked( $instance['show_author'] , 1 );?> /> 
    	<label>Show Author</label><br />
    <input type="checkbox" name="<?php echo $this->get_field_name( 'show_lightbox' ); ?>" value="1" <?php checked( $instance['show_lightbox'] , 1 );?> /> 
    	<label>Lightbox Content</label><br />
        
</p>
<p style="display: inline-block; width: 48%; margin-right: 2%; vertical-align: top;">
	<label>More Title:</label><input type="text" name="<?php echo $this->get_field_name( 'more_title' ); ?>" value="<?php echo $instance['more_title'];?>" /><br /> 
    <label>More Link:</label><input type="text" name="<?php echo $this->get_field_name( 'more_url' ); ?>" value="<?php echo $instance['more_url'];?>" />
    	
</p>