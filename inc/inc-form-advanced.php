<?php 
	$instance['no_img'] = ( isset( $instance['no_img'] ) )? $instance['no_img'] : false ;
	$instance['no_title'] = ( isset( $instance['no_title'] ) )? $instance['no_title'] : false ;
	$instance['no_text'] = ( isset( $instance['no_text'] ) )? $instance['no_text'] : false ;
	$instance['no_link'] = ( isset( $instance['no_link'] ) )? $instance['no_link'] : false ;
	$instance['show_content'] = ( isset( $instance['show_content'] ) )? $instance['show_content'] : false ;
	$instance['show_date'] = ( isset( $instance['show_date'] ) )? $instance['show_date'] : false ;
	$instance['show_author'] = ( isset( $instance['show_author'] ) )? $instance['show_author'] : false ;
	/*$instance['is_lightbox'] = ( isset( $instance['show_author'] ) )? $instance['show_author'] : false ;*/
	$instance['css_hook'] = ( isset( $instance['css_hook'] ) )? $instance['css_hook'] : '' ;
?>
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
</p>
<p style="display: inline-block; width: 48%; margin-right: 2%; vertical-align: top;">
	<label>Display Hook: </label><input type="text" name="<?php echo $this->get_field_name( 'css_hook' ); ?>" value="<?php echo $instance['css_hook'];?>" /> 
    	
</p>