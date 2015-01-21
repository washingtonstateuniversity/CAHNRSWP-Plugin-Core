<?php CAHNRSWP_Core_Form_Model::cwp_set_core_defaults( $instance ); ?>
<ul class="cwp-form">
	<li class="cwp-form-section cwp-field-set">
    	<?php include CAHNRSWPCOREDIR . '/inc/inc-form-part-title.php'; ?>
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
            	<?php include CAHNRSWPCOREDIR . '/inc/inc-form-part-dynamic-feed.php'; ?>
            </li>
        </ul>
    </li>
    <li class="cwp-form-section cwp-field-accordion">
    	<a href="#" class="cwp-form-section-title">Step 3: Set Display Style</a>
        <ul class="cwp-form-section-content">
        	<li class="cwp-field-set">
            	<p>
                	<?php include CAHNRSWPCOREDIR . '/inc/inc-form-part-display-as.php'; ?>
                </p>
                <?php include CAHNRSWPCOREDIR . '/inc/inc-form-part-advanced-display.php'; ?>
            </li>
        </ul>
    </li>
</ul>