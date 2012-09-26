<?php use_helper('Text', 'I18N', 'Global') ?>
  <div id="loader_bd">
    <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
  </div>
<?php foreach ($last_viewed_videos_pager->getResults() as $i=>$ytvideo):?>
  <?php
        $videoId = $ytvideo->getYtvideoId();
        $yt = new Zend_Gdata_YouTube();
        $entry = $yt->getVideoEntry($videoId);
        if(empty($entry->mediaGroup->thumbnail[1]))
        {
          $thumbnailUrl ='/uploads/assets/photos/thumbnails/no_pic.gif';
        }
        else
        {
          $thumbnailUrl = $entry->mediaGroup->thumbnail[1]->url;
        }
        if(empty($entry->mediaGroup->title))
        {
          $videoTitle='this video is no longer available';
        }
        else
        {
          $videoTitle = $entry->mediaGroup->title;
        }

  ?>
  <div class="searchResultsVideoList <?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <div class="video_data">
	  <?php echo image_tag($thumbnailUrl, 'alt=play title=play class=video_thumbnail')?>
    </div>
	 <div class="video_title"> <?php echo truncate_text($videoTitle,35)?></div>
    <div class="play_add_buttons">
      <div id="play_button_<?php echo $i?>">
	  <a href="#" class="playButton"> 
            <img src="/images/transparent.gif" video_id="<?php echo $videoId?>" title="<?php echo __('play')?>" alt="play" class="play_button_play">
	  </a>	   	
      </div>	
	
    <?php if($sf_user->isAuthenticated()):?>
         <form method="post" action="<?php echo url_for('@videolist')?>">
           <input type="hidden" name="video_id" id="video_id" value="<?php echo $videoId?>" />
	   <input type="image" name="submit" src="/images/transparent.gif"  class="add_button" title="<?php echo __('add to videolist')?>"/> 
	  </form>
    <?php else:?>
      <div>
	    <a href="#" class="addButton">
       <img src="/images/transparent.gif" alt="<?php echo __('add to videolist')?>" title="<?php echo __('add to videolist')?>" class="add_button">
	    </a>	     
	  </div>
    <?php endif;?>	
  </div>
  	    
  </div>
<?php endforeach;?>
<div class="pagination">
    <div id="photos_pager">
      <?php echo pager_navigation_feed_ajax_jq($last_viewed_videos_pager, '@videos_page') ?>
    </div>
</div>
