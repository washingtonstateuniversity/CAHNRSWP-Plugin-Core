<p>
            		<input type="radio" class="dynamic-radio-field" data-field="feed-static" name="<?php echo $this->get_field_name( 'feed_type' )?>" value="static" <?php checked( $instance['feed_type'] , 'static' ); ?> /> <strong>Static:</strong> Select specific post/pages by URL.
                </p><p>
            		<input type="radio" class="dynamic-radio-field" data-field="feed-dynamic" name="<?php echo $this->get_field_name( 'feed_type' )?>" value="dynamic" <?php checked( $instance['feed_type'] , 'dynamic' ); ?>/> <strong>Dynamic:</strong> Feed by type, categories or tags. 
            	</p>