<div class="video-frame" style="position: relative;" >
	<img src="<?php echo CAHNRSWPCOREURL . '/images/spacer16-9.png';?>" style="width: 100%;" />
    <iframe style="position: absolute; top: 0; left: 0; height: 100%; width: 100%;" src="//www.youtube.com/embed/<?php echo $this->model->video_id; ?>?autoplay=1" frameborder="0" allowfullscreen></iframe>
</div>
<?php if( $this->model->video_summary ) :?>
    <h2>Video Summary</h2>
    <?php echo $this->model->video_summary;?>
<?php endif;?>
<?php if( $this->model->video_copy ) :?>
	<h2>More</h2>
	<?php echo $this->model->video_copy;?>
<?php endif;?>