<?php

wp_nonce_field( 'submit_cahnrs_core', 'cahnrs_core_nonce' );

$source = ( isset ( $news_data->post_meta['source'] ) ) ? $news_data->post_meta['source'] : '';

$excerpt = ( isset ( $news_data->excerpt ) ) ? $news_data->excerpt : '';

?>

<h2>Source Link: </h2>
<input type="text" style="width: 80%; padding: 0.5rem 1rem; font-size: 1.1rem;" value="<?php echo $source ; ?>" name="_news_item[source]" />

<h2>News Summary/Excerpt</h2>
<?php wp_editor( $excerpt , 'excerpt' ); ?>
<hr />
<h2>Full Content</h2>