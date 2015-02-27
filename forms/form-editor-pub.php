<?php wp_nonce_field( 'submit_cahnrs_core', 'cahnrs_core_nonce' ); ?>
<h2>Link: </h2>
<input type="text" style="width: 80%; padding: 0.5rem 1rem; font-size: 1.1rem;" value="<?php echo $this->model['source'] ; ?>" name="<?php echo $this->meta_key;?>[source]" />

<h2>Journal: </h2>
<input type="text" style="width: 80%; padding: 0.5rem 1rem; font-size: 1.1rem;" value="<?php echo $this->model['journal'] ; ?>" name="<?php echo $this->meta_key;?>[journal]" />

<h2>Volume/Issue: </h2>
<input type="text" style="width: 80%; padding: 0.5rem 1rem; font-size: 1.1rem;" value="<?php echo $this->model['volume'] ; ?>" name="<?php echo $this->meta_key;?>[volume]" />

<h2>Author(s): </h2>
<input type="text" style="width: 80%; padding: 0.5rem 1rem; font-size: 1.1rem;" value="<?php echo $this->model['author'] ; ?>" name="<?php echo $this->meta_key;?>[author]" />

<h2>Year: </h2>
<input type="text" style=" padding: 0.5rem 1rem; font-size: 1.1rem;" value="<?php echo $this->model['year'] ; ?>" name="<?php echo $this->meta_key;?>[year]" />

<h2>Publication Summary/Excerpt</h2>
<?php wp_editor( $this->model['excerpt'] , 'excerpt' ); ?>
<hr />
<h2>Full Content</h2>