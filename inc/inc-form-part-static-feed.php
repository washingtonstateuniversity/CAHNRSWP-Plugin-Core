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