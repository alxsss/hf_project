<?php use_helper('Text', 'Global', 'I18N') ?>
  <div id="loader_bd">
    <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
  </div>
<?php //print_r($video_feed)?>
<?php foreach ($video_feed as $i=>$entry):?>
   <?php
        $videoId = $entry->getVideoId();
        $thumbnailUrl = $entry->mediaGroup->thumbnail[0]->url;
        $videoTitle = $entry->mediaGroup->title;
        //$videoDescription = $entry->mediaGroup->description;
  ?>
  <div class="searchResultsVideoList <?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <div class="video_data">
	  <?php echo image_tag($thumbnailUrl, 'alt=play title=play class=video_thumbnail')?>
    </div>
    <div class="video_title"> <?php echo truncate_text($videoTitle,35)?></div>
    <div class="play_add_buttons">
      <div id="play_button_<?php echo $i?>">  
	    <a href="#" class="playButton"> 
	      <?php echo image_tag('transparent.gif', 'class=play_button_play alt=play title=play video_id='.$videoId)?> 
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
      <?php echo pager_navigation_feed_ajax_jq($feed_pager, '@video_search_ajax?query='.$query) ?>
    </div>
</div>
