<?php wp_nonce_field( 'submit_cahnrs_core', 'cahnrs_core_nonce' ); ?>
<h2>Source Link: </h2>
<input type="text" style="width: 80%; padding: 0.5rem 1rem; font-size: 1.1rem;" value="<?php echo $this->model['source'] ; ?>" name="<?php echo $this->meta_key;?>[source]" />

<h2>News Summary/Excerpt</h2>
<?php wp_editor( $this->model['excerpt'] , 'excerpt' ); ?>
<hr />
<h2>Full Content</h2>