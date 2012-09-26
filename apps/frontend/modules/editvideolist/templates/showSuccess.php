<?php use_helper('I18N','Text') ?>
<div class="ifp_nav">
  <ul>
   <li><?php echo link_to(__('recently featured'), 'videos/index')?></li></span>
   <li><?php echo link_to(__('most viewed'), 'videos/mostviewed')?></li>
  </ul>
</div>
<?php include_partial('videos/search')?>
<div id="itemsearchResults">
  <div id="loader_bd">
    <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
  </div>
 <div class="videolist_title">
  <?php echo $videolist->getName()?>
  <?php $videolist_user_id=$videolist->getUserId(); ?>
  <?php if($videolist_user_id==$user_id):?>
    <a href="<?php echo url_for('videolist/edit?id='.$videolist->getId().'&token='.$videolist->getSfGuardUser()->getSalt())?>"><img src="/images/edit.png" title="<?php echo __('edit')?>" alt="<?php echo __('edit')?>"></a>
  <?php endif;?>
  --<?php echo __('created by %user%',array('%user%'=>link_to($videolist->getSfGuardUser(), '@user_profile?username='.$videolist->getSfGuardUser())))?> </div>
<?php if(!empty($videolist_ytvideo)):?>
<?php $playlist=array();?>
<?php foreach ($videolist_ytvideo as $i=>$ytvideo):?>
  <?php
        $videoId = $ytvideo->getYtvideoId();
        $playlist[]=$videoId;
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
  <div class="items searchResultsVideoList <?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
    <div class="video_data">
	  	  <?php echo image_tag($thumbnailUrl, 'alt=play title=play class=video_thumbnail')?>
       </div>
	 <div class="video_title"> <?php echo truncate_text($videoTitle,40)?></div>
    <div class="play_add_buttons">
      <div id="play_button_<?php echo $i?>">     
    	<a href="#" class="playButton_videolist"> 
             <img src="/images/transparent.gif" video_id="<?php echo $videoId?>" videolist_id="<?php echo $videolist_id?>" title="<?php echo __('play')?>" alt="play" class="play_button_play">
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

 <div class="delete_item">
   <?php if($videolist_user_id==$user_id):?>
   	   <?php echo link_to(__('Delete'), 'editvideolist/delete?id='.$ytvideo->getId().'&videolist_id='.$videolist->getId()) ?>
	<?php endif;?>
  </div> 
   
 </div>
<?php endforeach;?>
<?php endif;?>
  </div>
    <div id="searchResultsVideoColumn">
      <div id="fmpsv_video_player">

<object width="410" height="350">
<param name="movie" value="http://www.youtube.com/v/<?php echo $playlist[0]?>?version=3&playlist=<?php echo implode(',',array_slice($playlist,1))?>&autoplay=1"></param>
<param name="allowFullScreen" value="true"></param>
<param name="allowScriptAccess" value="always"></param>
<embed src="http://www.youtube.com/v/<?php echo $playlist[0]?>?version=3&playlist=<?php echo implode(',',array_slice($playlist,1))?>&autoplay=1"
  type="application/x-shockwave-flash"
  allowfullscreen="true"
  allowscriptaccess="always"
  width="410" height="350"
>
</embed>
</object>
<div id="loader_player">
         <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
       </div>
	</div>
 <?php include_partial('videos/ads') ?>
    </div> 
