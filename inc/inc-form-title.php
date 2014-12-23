<?php if( !isset( $instance['title'] ) ) $instance['title'] = ''; ?>
<div class="cwp-form-section">
    <p>
		<input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
    </p>
</div>