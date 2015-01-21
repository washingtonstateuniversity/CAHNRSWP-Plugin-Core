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
        <option value="1" <?php selected( $instance['per_row'] , '1' ); ?> >1</option>
        <option value="2" <?php selected( $instance['per_row'] , '2' ); ?> >2</option>
        <option value="3" <?php selected( $instance['per_row'] , '3' ); ?> >3</option>
        <option value="4" <?php selected( $instance['per_row'] , '4' ); ?> >4</option>
    </select>
</p>