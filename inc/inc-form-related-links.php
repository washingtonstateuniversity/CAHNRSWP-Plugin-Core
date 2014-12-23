<?php 
	if( !isset( $instance['links'] ) ) $instance['links'] = array( 0 , 1, 2 );
;?>
<div class="cwp-form">
	<?php include CAHNRSWPCOREDIR . '/inc/inc-form-title.php'; ?>
	<div class="cwp-form-section">
    	<a href="#" class="cwp-form-section-title">
        	Basic Settings
        </a>
        <div class="cwp-form-section-content">
        	<?php foreach( $instance['links'] as $index => $link ){
				$title = ( isset( $link['title'] ) )? $link['title'] : '';
				$url = ( isset( $link['url'] ) )? $link['url'] : '';
				$icon = ( isset( $link['icon'] ) )? $link['icon'] : '';
				?>
                <p>
                    <label>Title: </label>
                    <input type="text" name="<?php echo $this->get_field_name( 'links' ) . '[' . $index . '][title]'; ?>" value="<?php echo $title;?> " /><br />
                    <label>Url: </label>
                    <input type="text" name="<?php echo $this->get_field_name( 'links' ) . '[' . $index . '][url]'; ?>" value="<?php echo $url;?> " />
                    <label>Icon: </label>
                    <input type="text" name="<?php echo $this->get_field_name( 'links' ) . '[' . $index . '][icon]'; ?>" value="<?php echo $icon;?> " />
            	</p>
            <?php };?>
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