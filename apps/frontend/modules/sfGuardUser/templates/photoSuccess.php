<?php use_helper('Text', 'I18N') ?>
<?php include_partial('sfGuardUser/profile_links', array('subscriber' => $subscriber, 'inbox_num_msgs' => $inbox_num_msgs, 'num_guests'=>$num_guests, 'num_rates'=>$num_rates,
'num_friendsRequests'=>$num_friendsRequests, 'user_id'=>$user_id)) ?>

<div id="right_column_user">
<div id="updates_profile_right_column">
 <?php if(($subscriber->getProfile()->getVisibility())&&!(($subscriber->isFriend($user_id))||($user_id==$subscriber->getId()))):?>
   <div class="private_profile">
   <?php echo __('This profile is set to private')?>
   </div>
 <?php else:?>
  <div class="ifp_nav">
    <ul>
	  <li><?php echo link_to(__('Info'), 'info/'.$subscriber) ?></li>
	  <li><?php echo link_to(__('Friends'), 'friend/'.$subscriber) ?></li>
	  <li class="last_nb selected"><?php echo link_to(__('Photos'), 'photo/'.$subscriber) ?></li>
	</ul>
  </div>

  <div class="profile_section">
    <span class="recent_activity"><?php echo __('Photos')?>(<?php echo $num_photos?>)</span>
    <div class="friends_to_be_invited_line">
      <?php foreach ($photos as $photo): ?>
        <?php $visibility=$photo->getVisibility();?>
        <?php //check  if photo has visibility 1?>
        <?php if($visibility):?>
          <?php //in this case album is visible only to friends. Check  if  signed user is a friend to this user?>
          <?php if($subscriber->isFriend($user_id)||($user_id==$subscriber->getId())):?>
		  <?php $pic_url='/uploads/assets/photos/thumbnails/'.$photo->getFilename()?>
		  <div class="user_friend">
		    <a href="<?php echo url_for('photos/show?id='.$photo->getId())?>">	        
	        <div class="album_image">
              <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
		    </div>
			</a>		
	      </div>          
        <?php endif; //if friend ?>
      <?php else: ?>
        <?php $pic_url='/uploads/assets/photos/thumbnails/'.$photo->getFilename()?>
		<div class="user_friend">
		    <a href="<?php echo url_for('photos/show?id='.$photo->getId())?>">	        
	        <div class="album_image">
              <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
		    </div>
			</a>		
	      </div>        
      <?php endif; //if visibility?>
    <?php endforeach; ?>
   </div>	
    <?php if($num_photos>5):?>
      <div class="see_all_profile"><?php echo link_to(__('see all'), '@all_photos?username='.$username)?></div>
    <?php endif;?>
 
  </div> 

 
  <div class="profile_section_nb">
    <span class="recent_activity"><?php echo __('Albums')?>(<?php echo $num_albums?>)</span>
   <div class="friends_to_be_invited_line">
    <?php foreach ($albums as $album): ?>
      <?php $visibility=$album->getVisibility();?>
      <?php //check  if album has visibility 1?>
      <?php if($visibility):?>
        <?php //in this case album is visible only to friends. Check  if  signed user is a friend to this user?>
        <?php if($subscriber->isFriend($user_id)||($user_id==$subscriber->getId())):?>
          <?php $lastPhoto=$album->getLastPhoto();?>
          <?php if(!empty($lastPhoto)): ?>
            <?php $pic_url='/uploads/assets/photos/thumbnails/'.$lastPhoto->getFilename()?>
	      <?php else:?>
           <?php $pic_url='/uploads/assets/photos/thumbnails/no_pic.gif'?>
	      <?php endif; //if !empty lastPhoto?>
	      <div class="user_friend">
	        <div class="user_album_title"><?php   echo $album->getTitle(); ?></div>
	        <a href="<?php echo url_for('albums/show?id='.$album->getId())?>">	  
	        <div class="album_image">
              <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
		    </div>		
			</a>	
		    <div class="user_album_countPhotos"><?php echo $album->countPhotos(); ?> photos</div>
	     </div>	
        <?php endif; //if friend ?>
      <?php else: ?>
        <?php $lastPhoto=$album->getLastPhoto();?>
        <?php if(!empty($lastPhoto)): ?>
          <?php $pic_url='/uploads/assets/photos/thumbnails/'.$lastPhoto->getFilename()?>
        <?php else:?>
          <?php $pic_url='/uploads/assets/photos/thumbnails/no_pic.gif'?>
        <?php endif; //if !empty lastPhoto?>
        <div class="user_friend">
          <div class="user_album_title"><?php echo truncate_text($album->getTitle(),15); ?></div>
          <a href="<?php echo url_for('albums/show?id='.$album->getId())?>">	  
	        <div class="album_image">
              <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
		    </div>		
			</a>
		  <div class="user_album_countPhotos"><?php echo __('photos')?> <?php echo $album->countPhotos(); ?> </div>
	    </div>	
      <?php endif; //if visibility?>
    <?php endforeach; ?>
   </div>
    <?php if($num_albums>5):?>
       <div class="see_all_profile"><?php echo link_to(__('see all'), '@all_albums?username='.$username)?></div> 
    <?php endif;?>
 
  </div> 
   <?php endif;?>
 </div><!--updates_status_right_column-->

   <div class="right_ad_boxes">
  <script type="text/javascript"><!--
      google_ad_client = "pub-0181717197672047";
      /* 120x600, created 10/7/10 */
      google_ad_slot = "5283049147";
      google_ad_width = 120;
      google_ad_height = 600;
      //-->
    </script>
    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
 </div>
</div><!--right_column-->
