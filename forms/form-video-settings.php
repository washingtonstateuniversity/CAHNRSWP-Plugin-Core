<?php wp_nonce_field( 'add_video', 'video' ); ?>
<div class="cwp-editor-form">
    <input style="display: none;" type="checkbox" name="_video[vid_related]" value="0" checked="checked" />
    <input type="checkbox" name="_video[video_related]" value="1" /><label>Auto Display Related Videos</label>
    <h2>Video URL</h2>
    <p id="cwp-video-url"> 
        <span class="cwp-helper-text">
            Video URL can be the full YouTube URL or the ID for the video. Example: <strong>https://www.youtube.com/watch?v=4rb8aOzy9t4</strong> or simply <strong>4rb8aOzy9t4</strong>.
        </span><br />	
        <input class="full" type="text" name="_video[video_url]" value="<?php echo $video['url'];?>" />
        
    </p>
    <h2>Video Image</h2>
    <p id="cwp-video-url"> 
        <span class="cwp-helper-text">
            If the video image is left empty it will automatically be set to the default YouTube thumbnail. The "Featured Image" will override this setting.
        </span><br />	
        <input class="full" type="text" name="_default_img_src" value="<?php echo $video['img'];?>" />
        
    </p>
    <h2>Video Summary</h2>
    <p id="cwp-video-summary">
        <span class="cwp-helper-text">
            Provide a plain text description of the video ( 1-4 sentances ). The summary will render on the video page above the "Video Page Content".
        </span><br />
        <textarea class="full" name="excerpt" ><?php echo $video['summary'];?></textarea>
    </p>
    <h2>Video Page Content</h2>
    <span class="cwp-helper-text">
         The video page content will be displayed when a user navigates to or watches a video.
    </span>
    <?php wp_editor(  $video['copy'] , '_video_copy');?>
</div>
