<?php use_helper('Javascript', 'Text', 'Global') ?>
<div class="video_nav">
  <ul>
   <li><?php echo link_to('recently featured', 'videos/index')?></li></span>
   <li><?php echo link_to('most viewed', 'videos/mostviewed')?></li>
  </ul>
</div>
<div id="videosearchResults">
  <div id="loader_bd">
    <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
  </div>
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
    <div class="video_title"> <?php echo truncate_text($videoTitle,40)?></div>
    <div class="play_add_buttons">
      <div id="play_button_<?php echo $i?>">  
	    <a href="#" class="playButton"> 
	      <?php echo image_tag('transparent.gif', 'class=play_button_play alt=play title=play video_id='.$videoId)?> 
	    </a>    	
      </div>	
	
    <?php if($sf_user->isAuthenticated()):?>
	  <?php echo form_tag('videolist/index') ?>
        <?php echo input_hidden_tag('video_id', $videoId) ?>
	    <input type="image" name="submit" src="/images/transparent.gif"  class="add_button" title="add to playlist"/> 
	  </form>
    <?php else:?>
      <div>
        <a href="#" class="addButton">
		   <?php echo image_tag('transparent.gif', 'class=add_button title=add to playlist alt=add to playlist')?> 
	    </a>	
	  </div>
    <?php endif;?>	
  </div>	
    <div class="favorite_videos">
    <?php //include_partial('favorite', array('video_id' => $videoId)) ?>
  </div>     
  </div>
<?php endforeach;?>


  <div class="pagination">
    <div id="photos_pager">
      <?php echo pager_navigation_feed($feed_pager, '@video_search_ajax?query='.$query, 'videosearchResults') ?>
    </div>
  </div>
</div> 
 <div id="searchResultsVideoColumn">
      <div id="fmpsv_video_player">
	    <div id="loader_player">
         <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
        </div>
	 </div>
	  <div id="fmpsv_video_right_ad">
	  	<div>Advertisement</div>
				 <?php include_partial('ads') ?>
	  </div>
    </div> 
