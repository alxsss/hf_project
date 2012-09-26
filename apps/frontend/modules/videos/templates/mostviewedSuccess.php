<?php use_helper('Text','I18N') ?>
<div class="ifp_nav">
  <ul>
    <li><?php echo link_to(__('recently featured'), 'videos/index')?></li>
    <li class="selected"><?php echo link_to(__('most viewed'), 'videos/mostviewed')?></li></span>
  </ul>
</div>
<?php include_partial('videos/search')?>

<div id="itemsearchResults">
  <div id="loader_bd">
    <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
  </div>
<?php foreach ($most_viewed_feed as $i=>$entry):?>
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
