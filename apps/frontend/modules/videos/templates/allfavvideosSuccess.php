<?php
// auto-generated by sfPropelCrud
// date: 2008/01/12 07:20:21
?>
<?php use_helper('Javascript', 'Global', 'Text') ?>
<h2><?php echo $subscriber?>'s favorite videos</h2>
<div id="videosearchResults">
<div id="favorite_videos">
<?php foreach ($videos_pager->getResults() as $i=>$ytvideo): ?>
 <?php
        $videoId = $ytvideo->getVideoId();
        $yt = new Zend_Gdata_YouTube();
        $entry = $yt->getVideoEntry($videoId);
		//print_r($entry);
		if(empty($entry->mediaGroup->thumbnail[0]))
		{
		  $thumbnailUrl ='/uploads/assets/photos/thumbnails/no_pic.gif';
		}
		else
		{		
          $thumbnailUrl = $entry->mediaGroup->thumbnail[0]->url;
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
           <?php echo link_to_remote(image_tag($thumbnailUrl, 'alt=play title=play class=video_thumbnail'), 
            array(
		    'update' => 'fmpsv_video_player',
            'url'    => url_for('@play_video?video_id='.$videoId),
	        'script' => true,
             )) ?>  
        </div>	 
	  
    <div class="video_title"> <?php echo truncate_text($videoTitle,40)?></div>
    <div class="play_add_buttons">
      <div id="play_button_<?php echo $i?>">     
    	<?php echo link_to_remote(image_tag('transparent.gif', 'id=play_button_image class=play_button_play alt=play title=play'), array(
        'update' => 'result',
        'url'    => url_for('@video_refresh?play=stop&button_number='.$i.'&video_id='.$videoId),
	    'script' => true,
        )) ?>  
      </div>	
	
    <?php if($sf_user->isAuthenticated()):?>
	  <?php echo form_tag('videolist/index') ?>
        <?php echo input_hidden_tag('video_id', $videoId) ?>
	    <input type="image" name="submit" src="/images/transparent.gif"  class="add_button" title="add to videolist"/> 
	  </form>
    <?php else:?>
      <div>
	     <?php echo link_to_function(image_tag('transparent.gif',  'class=add_button title=add to playlist'), visual_effect('blind_down', 'login', array('duration' => 0.5))); ?>
	  </div>
    <?php endif;?>	
  </div>
  
   <div class="favorite_videos">
   <?php if($user_id==$subscriber->getId()):?>
     <?php echo link_to_remote(image_tag('delete.png', 'alt=delete title=delete'), array(
          'url'      => 'videos/removefavytvideo?video_id='.$ytvideo->getVideoId().'&username='.$subscriber,
          'update'   => 'favorite_videos',
  		  'confirm'  => 'Do you want to remove this video?',
          'loading'  => "Element.show('indicator')",
          'complete' => visual_effect('highlight', 'favorite_videos'),
        )) ?> 
    <?php else:?>
      <?php include_partial('videos/favorite', array('video_id' => $videoId)) ?>
	<?php endif;?>
  </div> 
  
 </div>	
  <?php endforeach; ?>
</div>
<div class="pagination">
  <div id="photos_pager">
    <?php echo pager_navigation($videos_pager, 'video/list') ?>
  </div>
</div>
</div><!--videosearchresults-->

<div id="searchResultsVideoColumn">
  <div id="fmpsv_video_player">&nbsp;</div>
  <div id="fmpsv_video_right_ad">
	 <div>Advertisement</div>
	  <?php include_partial('videos/ads') ?>
  </div>
</div>