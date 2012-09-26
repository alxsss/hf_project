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
              <div id="user_player">
  <?php echo link_to('explore this playlist','editPlaylist/show?playlist_id=1')?>
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="350" height="170" id="xspf_player" align="middle">
      <param name="allowScriptAccess" value="sameDomain" />
      <param name="movie" value="/js/xspf_player.swf?playlist_url=<?php echo url_for('@generate_playlist?playlist_id=1') ?>&autoload=true&autoplay=false&shuffle=true" />
      <param name="quality" value="high" />
      <param name="bgcolor" value="#e6e6e6" />
      <embed src="/js/xspf_player.swf?playlist_url=<?php echo url_for('@generate_playlist?playlist_id=1') ?>&autoload=true&autoplay=false&shuffle=true" quality="high" bgcolor="#e6e6e6" width="350" height="170" name="xspf_player" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
    </object>
  </div>

         <?php //echo image_tag('loader_bd.gif', 'alt=loader')?>
	 <?php include_partial('ads') ?>
    </div> 
