<?php CAHNRSWP_Core_Form_Model::cwp_set_core_defaults( $instance ); ?>
<ul class="cwp-form">
	<li class="cwp-form-section cwp-field-set">
    	<?php include CAHNRSWPCOREDIR . '/inc/inc-form-part-title.php'; ?>
    </li>
    <li class="cwp-form-section cwp-field-accordion active-field-accordion">
    	<a href="#" class="cwp-form-section-title">Step 1: Select Feed Type</a>
        <ul class="cwp-form-section-content">
        	<li class="cwp-field-set">
            	<?php include CAHNRSWPCOREDIR . '/inc/inc-form-part-feed-type.php'; ?>
            </li>
        </ul>
    </li>
    <li class="cwp-form-section cwp-field-accordion">
    	<a href="#" class="cwp-form-section-title">Step 2: Select Content</a>
        <ul class="cwp-form-section-content">
        	<li class="cwp-field-set dynamic-field feed-static<?php if ( 'static' == $instance['feed_type'] ) echo ' active-field' ;?>">
            	<?php include CAHNRSWPCOREDIR . '/inc/inc-form-part-static-feed.php'; ?>
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
            	<?php include CAHNRSWPCOREDIR . '/inc/inc-form-part-display-as.php'; ?>
                <p>
                	<label>Slide Count: </label><input type="text" name="<?php echo $this->get_field_name( 'slide_count' )?>" value="<?php echo $instance['slide_count'];?>" />
                </p>
                <?php include CAHNRSWPCOREDIR . '/inc/inc-form-part-advanced-display.php'; ?>
            </li>
        </ul>
    </li>
</ul>