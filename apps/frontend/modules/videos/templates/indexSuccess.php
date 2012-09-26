<?php use_helper('Text', 'Global', 'I18N') ?>
<div class="ifp_nav">
  <ul>
   <li class="selected"><?php echo link_to(__('recently featured'), 'videos/index')?></li></span>
   <li class="last_nb"><?php echo link_to(__('most viewed'), 'videos/mostviewed')?></li>
  </ul>
</div>
<?php include_partial('videos/search')?>
<div id="itemsearchResults">
  <div id="loader_bd">
    <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
  </div>
<?php foreach ($last_viewed_videos_pager->getResults() as $i=>$ytvideo):?>
  <?php
        $videoId = $ytvideo->getYtvideoId();
        $yt = new Zend_Gdata_YouTube();
        $entry = $yt->getVideoEntry($videoId);
        if(!$entry)continue;
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
          $ytvideo->delete();
        }
        else
        {
          $videoTitle = $entry->mediaGroup->title;
        }

        /*$videoId = $entry->getVideoId();
        $thumbnailUrl = $entry->mediaGroup->thumbnail[0]->url;
        $videoTitle = $entry->mediaGroup->title;
        //$videoDescription = $entry->mediaGroup->description;
     */
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

  </div>
   
    <div id="searchResultsNavigation">
        <form id="navigationForm">
          <input type="button" id="previousPageButton" onclick="ytvbp.listVideos(ytvbp.previousQueryType, ytvbp.previousSearchTerm, ytvbp.previousPage);" value="Back" style="display: none;"></input>
          <input type="button" id="nextPageButton" onclick="ytvbp.listVideos(ytvbp.previousQueryType, ytvbp.previousSearchTerm, ytvbp.nextPage);" value="Next" style="display: none;"></input>
        </form>
      </div>

    <div id="searchResultsVideoColumn">
      <div id="fmpsv_video_player">
	    <div id="loader_player">
         <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
       </div>
  </div>
	 <?php include_partial('ads') ?>
    </div> 
