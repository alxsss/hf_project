<?php use_helper('Text',  'I18N', 'Status', 'Date')?>
<div id="left_column_user">
<?php include_partial('sfGuardUser/profile_links', array('subscriber' => $subscriber, 'inbox_num_msgs' => $inbox_num_msgs,
'num_requests'=>$num_requests, 'num_guests'=>$num_guests, 'num_rates'=>$num_rates, 'user_id'=>$user_id)) ?>
<?php if($num_friends>0):?>
  <div class="right_boxes_profile">
      <div class="suggestion_title"><?php echo __('Friends') ?>(<?php echo $num_friends?>)</div>	 
      <div class="group_members">
       <div class="members_line">
         <?php foreach ($user_friends as $i=>$user_friend): ?>
		   <?php $photo=$user_friend->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
           <div class="group_member">           
             <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=no img class=border_image'), '@user_profile?username='.$user_friend) ?>		
             <div class="group_member_title"><?php echo link_to(mb_substr($user_friend, 0, 9,'UTF-8').'<wbr>'.mb_substr($user_friend, 9, strlen($user_friend), 'UTF-8'),url_for('@user_profile?username='.$user_friend))?>               </div>
  	  </div>
          <?php if($i==2){echo '</div><div class="members_line">';}?>
        <?php endforeach ?>
       </div><!--members_line-->
	     <?php if($num_friends>6):?>
		   <div class="see_all"><?php echo link_to(__('see all'), '@all_friends?username='.$username)?></div>
		 <?php endif;?> 
      </div>	   
    </div>
	 <?php endif;?> 
    <?php if($subscriber->countPhotoFavs()>0):?>
   <div class="right_boxes_profile">
      <div class="suggestion_title"><?php echo __('Favorite photos') ?>(<?php echo $subscriber->countPhotoFavs()?>)</div>	 
      <div class="group_members">
	   <div class="members_line">
	   <?php foreach($fav_photos as $i=>$fav_photo): ?>
          <div class="popular_photo">           
            <?php echo link_to(image_tag('/uploads/assets/photos/thumbnails/'.$fav_photo->getPhoto()->getFilename(), 'class=image_with_border alt=popular'), url_for('photos/show?id='.$fav_photo->getPhotoId()) ) ?>
             <div class="popular_photo_title"><?php //echo __('rates').'('.$popular_photo->getRating().')'?> </div>
		  </div>
		  <?php if($i==1){echo '</div><div class="members_line">';}?>
        <?php endforeach;?>
		  </div><!--members_line-->
      </div>
	  <?php if($subscriber->countPhotoFavs()>4):?>
         <div class="see_all"><?php echo link_to(__('see all'), '@all_favphotos?username='.$username)?></div>
      <?php endif;?>
	 </div><!--end right_boxes-->
   <?php endif;?>
    <?php if($num_games>0):?>
  <div class="right_boxes_profile">
      <div class="suggestion_title"><?php echo __('Games')?>(<?php echo $num_games?>)</div>	 
      <div class="group_members">
       <div class="members_line">
         <?php foreach ($game_users as $i=>$game_user): ?>
		    <?php $pic_url=$game_user->getGame()->getThumb()?>
			<?php $game_name= truncate_text($game_user->getGame()->getName(),15)?>
           <div class="game_member">           
             <?php  echo link_to(image_tag( $pic_url, 'alt=no img class=border_image'), url_for('games/show?id='.$game_user->getGameId() )) ?>		
             <div class="game_member_title"><?php echo link_to(substr($game_name, 0, 9).'<wbr>'.substr($game_name, 9, strlen($game_name)),url_for('games/show?id='.$game_user->getGameId() ))?>               </div>
  	  </div>
          <?php if($i==1){echo '</div><div class="members_line">';}?>
        <?php endforeach ?>
       </div><!--members_line-->
	      <?php if($num_games>1):?>
		   <div class="see_all"><?php echo link_to(__('see all'), 'games/allgames?username='.$username)?></div>
		  <?php endif;?> 
      </div>	   
    </div>
	 <?php endif;?>
</div>	
<div id="right_column_user">
  <div id="updates_profile_right_column"> 
  <!--information section -->
   <div class="profile_section">
    <span class="recent_activity"><?php echo __('Information')?></span>
	  <div class="activity_element">
       <?php echo __($subscriber->getProfile()->getSex())?>, 
       <?php echo floor ((time()-$subscriber->getProfile()->getBirthday('U'))/(24*365*3600))?> <?php echo __('years old')?>
	 </div>
	  <div class="activity_element">
       <?php echo $subscriber->getProfile()->getCity()?>
       <?php echo $subscriber->getProfile()->getState()?>
	   <?php $country=$subscriber->getProfile()->getCountry()?>
	   <?php $status=$subscriber->getProfile()->getMaritalStatus()?>
	   <?php if(!empty($country)):?> 
         <?php echo $country->getIsoCode3()?>  
       <?php endif;?>
	  </div>  	  
	   <?php if(!empty($status)):?> 
	      <div class="activity_element">
           <?php echo __('Marital Status').': '.__($status)?>  
		 </div>
       <?php endif;?> 	 
  </div>
	<?php $lookingfor=$subscriber->getProfile()->getLookingfor()?>
	<?php $website=$subscriber->getProfile()->getWebsite()?>
	<?php $activities=$subscriber->getProfile()->getActivities()?>
	<?php $books=$subscriber->getProfile()->getBooks()?>	
	<?php $music=$subscriber->getProfile()->getMusic()?>
	<?php $movies=$subscriber->getProfile()->getMovies()?>
	<?php $tvshows=$subscriber->getProfile()->getTvshows()?>
	<?php $aboutme=$subscriber->getProfile()->getAboutme()?>
  <div class="profile_section">
    <span class="recent_activity"><?php echo __('Interests')?></span>
  	<table class="activity_element" cellpadding="3" cellspacing="4"  border="0">
      <?php if(!empty($lookingfor)):?>
	    <tr><td><?php echo __('Looking for')?></td><td><?php echo $subscriber->getProfile()->getLookingfor()?></td></tr>
      <?php endif;?>
	  <?php if(!empty($website)):?>
	    <tr><td><?php echo __('Website')?></td><td><?php echo $website?></td></tr>
      <?php endif;?>
	  <?php if(!empty($activities)):?>
	    <tr><td><?php echo __('Activities')?></td><td><?php echo $activities?></td></tr>
      <?php endif;?>
	  <?php if(!empty($books)):?>
	    <tr><td><?php echo __('Books')?></td><td><?php echo $books?></td></tr>
      <?php endif;?>
      <?php if(!empty($music)):?>
	    <tr><td><?php echo __('Music')?></td><td><?php echo $music?></td></tr>
      <?php endif;?>
	   <?php if(!empty($movies)):?>
	    <tr><td><?php echo __('Movies')?></td><td><?php echo $movies?></td></tr>
      <?php endif;?>
      <?php if(!empty($tvshows)):?>
	    <tr><td><?php echo __('TV shows')?></td><td><?php echo $tvshows?></td></tr>
      <?php endif;?>
      <?php if(!empty($aboutme)):?>
	   <tr><td><?php echo __('About Me')?></td><td><?php echo  $aboutme?></td></tr>
      <?php endif;?>	 
	</table>   
  </div>
  
 <?php if(count($schoolUsers)>0):?>
  <div class="profile_section" style="border:none;">
    <span class="recent_activity"><?php echo __('Schools')?></span>
    <div id="user_school">
      <?php foreach($schoolUsers as $schoolUser):?>
	    <div class="user_school_element">
	      <div class="school_activity_element">
          <?php echo $schoolUser->getSchool()->getVillage()->getRegion()->getName();?>,
          <?php echo $schoolUser->getSchool()->getVillage()->getName();?>, 
          <?php echo $schoolUser->getSchool()->getName();?>, 
	      <?php echo $schoolUser->getGradYear();?>
		  </div>
		  <?php if($user_id==$subscriber->getId()):?> 
            <span class="delete_school">
		      <a href="#" school_id="<?php echo $schoolUser->getSchoolId()?>"><?php echo __('Delete')?></a>	    
	        </span>  
          <?php endif;?>
	    </div>
      <?php endforeach?>
	 </div>
  </div>  
 <?php endif;?>	  
  <!--end of information section--> 
    <?php if(($subscriber->getProfile()->getVisibility())&&!(($subscriber->isFriend($user_id))||($user_id==$subscriber->getId()))):?>
      <div class="private_profile">
        <?php echo __('This profile is set to private')?>
      </div>
    <?php //include_partial('friends/horizontal_ad')?>
    <?php else:?>
   <?php if($num_photos>0):?>
    <div class="profile_section">
    <span class="recent_activity"><?php echo __('Photos')?>(<?php echo $num_photos?>)</span>
    <div class="friends_to_be_invited_line_profile">
     <?php foreach ($photos as $photo): ?>
      <?php $visibility=$photo->getVisibility();?>
      <?php //check  if photo has visibility 1?>
      <?php if($visibility):?>
        <?php //in this case album is visible only to friends. Check  if  signed user is a friend to this user?>
        <?php if($subscriber->isFriend($user_id)||($user_id==$subscriber->getId())):?>
		  <?php $pic_url='/uploads/assets/photos/thumbnails/'.$photo->getFilename()?>
          <div class="user_friend">
		    <a href="<?php echo url_for('photos/show?id='.$photo->getId())?>">	        
              <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
			</a>		
	      </div>	
        <?php endif; //if friend ?>
      <?php else: ?>
        <?php $pic_url='/uploads/assets/photos/thumbnails/'.$photo->getFilename()?>
        <div class="user_friend">
		   <a href="<?php echo url_for('photos/show?id='.$photo->getId())?>">	        
              <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
			</a>         
	    </div>	
      <?php endif; //if visibility?>
    <?php endforeach; ?>
   </div>	
    <?php if($num_photos>5):?>
      <div class="see_all_profile"><?php echo link_to(__('see all'), '@all_photos?username='.$username)?> </div> 
    <?php endif;?>
 
  </div> 
  <?php endif;?>
   <?php if($num_albums>0):?>
  <div class="profile_section">
    <span class="recent_activity"><?php echo __('Albums')?>(<?php echo $num_albums?>)</span>
   <div class="friends_to_be_invited_line_profile">
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
                <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
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
              <?php echo image_tag($pic_url, 'alt=no img class=image_with_border')?>
			</a>
	      <div class="user_album_countPhotos"><?php echo __('photos')?> <?php echo $album->countPhotos(); ?> </div>
	    </div>	
      <?php endif; //if visibility?>
    <?php endforeach; ?>
   </div>
    <?php if($num_albums>5):?>
     <div class="see_all_profile"> <?php echo link_to(__('see all'), '@all_albums?username='.$username)?>  </div> 
    <?php endif;?> 
  </div> 
 <?php endif;?> 
  <?php if($num_videolists>0):?>
    <div class="profile_section">
      <span class="recent_activity"><?php echo __('Videolists')?>(<?php echo $num_videolists?>)</span>
      <div class="friends_to_be_invited_line_profile">
        <?php foreach ($videolists as $j=>$videolist): ?>
          <?php $lastVideo=$videolist->getLastVideolistYtvideo();?>
          <?php  $thumbnailUrl ='/uploads/assets/photos/thumbnails/no_pic.gif';?>
          <?php if(!empty($lastVideo)): ?>
            <?php $videoId = $lastVideo->getYtvideoId();
             $yt = new Zend_Gdata_YouTube();
             $entry = $yt->getVideoEntry($videoId);
             if(empty($entry->mediaGroup->thumbnail[0]))
             {
               $thumbnailUrl ='/uploads/assets/photos/thumbnails/no_pic.gif';
             }
             else
             {
              $thumbnailUrl = $entry->mediaGroup->thumbnail[1]->url;
             }
            ?>
          <?php endif; //if !empty lastVideo?>
	  <div class="user_video">
	    <div class="user_album_title"><?php   echo $videolist->getName(); ?></div>
	    <a href="<?php echo url_for('editvideolist/show?videolist_id='.$videolist->getId())?>">	  
	      <?php echo image_tag($thumbnailUrl, 'alt=no img class=image_with_border')?>		
            </a>
	    <div class="user_album_countPhotos"><?php echo __('video')?> <?php echo $videolist->countVideolistYtvideos(); ?></div>
	  </div>	
        <?php endforeach; ?>
      </div>
      <?php if($num_videolists>3):?>
       <div class="see_all_profile"> <?php echo link_to(__('see all'), '@videolist')?>  </div> 
      <?php endif;?> 
    </div> 
 <?php endif;?> 

   <?php if($user_id==$subscriber->getId()):?>
    <div id="status_box">
	  <form id="user_status_form" action="<?php echo url_for('@user_status')?>" method="post">
	    <input type="text" id="user_status_box" name="user_status_box" class="defaultText cleardefault" title="<?php echo __('What do you think?')?>" size="50" maxlength="100" value="<?php echo __('What do you think?')?>">
	    <span class="submit_status_link_button">
	      <input type="submit" value="<?php echo __('Submit')?>" id="user_status_button">
	    </span>
	  </form>
    </div>
  <?php endif;?>
<!--add recent activity and ad-->
  <?php if(count($user_groups)>0): ?>
    <div class="profile_section">
  <?php else:?>
	<div class="profile_section_nb">
  <?php endif;?>
  <span class="recent_activity"><?php echo __('Recent Activity')?></span>
   <div class="user_status_element_new"></div>
  <?php foreach($subscriber_updates->getResults() as $i=>$update):?> 
    <?php if($update->getPid()==2):?>	
	  <div class="user_status" style="margin:0px;">
        <div class="status_activity_element">
       	 <div  class="status_text">
		  <span class="update_username"><?php echo $subscriber?></span>: <?php echo $update->getFStatusName()?> 
		  <div class="comment_actions" style="margin:3px 0 0 5px;">
	          <div class="updates_action">
	            (<?php echo status_date($update->getCreatedAt('U'), format_date($update->getCreatedAt(), 'p'))?>) 			            
			<a href="#" class="comment_status"><?php echo __('comment')?></a>
	     <?php if($user_id==$subscriber->getId()):?> 
          <span class="delete_status">
		    <a href="#" status_id="<?php echo $update->getId()?>" action="<?php echo url_for('@delete_status')?>"><?php echo __('delete')?></a>	    
	      </span>  
        <?php endif;?>			
               </div>		
               <div class="add_status_comment">
                 <?php include_partial('friends/status_comment', array('user_id'=>$user_id, 'status_id'=>$update->getId())) ?> 
			  <div class="user_status_comment_new"></div> 
            </div>
            <div class="status_comment_box">
			  <?php if ($sf_user->isAuthenticated()): ?>
			  <form action="<?php echo url_for('@add_status_comment')?>" method="post">
                <input type="hidden" value="<?php echo $update->getId()?>"  name="item_id">             
                <input type="hidden" value="<?php echo $update->getUserId()?>"  name="item_user_id">       
			    <input type="hidden" value="1"  name="page"> 
				<textarea cols="30" rows="3" class="expand24 status_box" id="comment" name="comment" style="height: 24px; overflow: hidden; padding-top: 0px; padding-bottom: 0px;"></textarea>		 
                <?php //echo textarea_tag('comment', '', 'size=30x3 class=expand24 status_box') ?>
                <div class="submit-row">      
                 <input type="submit" value="<?php echo __('comment')?>" class="status_comment_box_form"> 
                </div>			  
             </form>
			 <?php else: ?>
               <div class="comment">
                  <?php echo __('You must ')?><span class="toggle_to_login"><a href="#"><?php echo __('sign in')?></a><?php echo __(' to submit a comment') ?></span>
	           </div>
             <?php endif;//endif of comment ?>
           </div>
	      </div>
		</div>
		
	 </div>
	  </div>
	<?php elseif($update->getPid()==3):?>      
	    <div class="activity_element">
		  <?php if($update->getUserId()==$subscriber->getId()):?>
		    <?php $fuser=sfGuardUserPeer::retrieveByPk($update->getFStatusName())?>
		  <?php elseif($update->getFriendId()==$subscriber->getId()):?>
		    <?php $fuser=sfGuardUserPeer::retrieveByPk($update->getUserId())?>
		  <?php endif;?>
           <?php echo $subscriber?> <?php echo __('and')?>  <?php echo link_to($fuser->getUsername(), '@user_profile?username='.$fuser->getUsername())?>
		   <?php echo __('are friends now')?> 
		  
		  <span class="status_date">(<?php echo status_date($update->getCreatedAt('U'), format_date($update->getCreatedAt(), 'p'))?>)</span>
        </div>
 	<?php elseif($update->getPid()==4):?>
	  <?php $p_owner=sfGuardUserPeer::retrieveByPk($update->getPOwnerId())?>
	  <div class="activity_element">         
	    <?php echo $subscriber?> <?php echo __('commented on %photo% by %author%', array('%photo%'=>link_to(__('photo'), 'photos/show?id='.$update->getId()),
		'%author%'=>link_to($p_owner->getUsername(), '@user_profile?username='.$p_owner->getUsername())  ))?>
		<span class="status_date">(<?php echo status_date($update->getCreatedAt('U'), format_date($update->getCreatedAt(), 'p'))?>)</span> 	
      </div>	
   <?php endif;?>			
  <?php  endforeach; ?>
  <?php $subscriber_updates->getLinks()//this is done to correctly count getCurrentMaxLink()?>	  
  <?php if (($subscriber_updates->haveToPaginate())&&($subscriber_updates->getPage() != $subscriber_updates->getCurrentMaxLink()) ):?>
	<div class="user_updates">
      <?php echo link_to(__('Next'), '@user_updates?id='.$subscriber->getId().'&page='.$subscriber_updates->getNextPage(), 'class=reply_to_message') ?>
	</div>
  <?php endif;?>   
</div>  

 
  <?php if(count($user_groups)>0): ?>
    <?php if(count($user_events)>0)://check if there is not events then output div without bottom border ?>
      <div class="profile_section">
    <?php else: ?>
     <div class="profile_section_nb">
    <?php endif;?>
    <span class="recent_activity"><?php echo __('Groups')?></span>
    <div class="school_activity_element">
    <?php foreach($user_groups as $user_group):?>
      <?php echo link_to($user_group->getsfSocialGroup()->getTitle(), '@sf_social_group?id=' . $user_group->getGroupId()) ?>		
    <?php endforeach?>
  </div>	 
   </div>		
  <?php endif;?> 
  <?php if(count($user_events)>0): ?>
    <div class="profile_section_nb">
      <span class="recent_activity"><?php echo __('Events')?></span>
        <div class="school_activity_element">
          <?php foreach($user_events as $user_event):?>
	    <?php echo link_to($user_event->getsfSocialEvent()->getTitle(), '@sf_social_event?id=' . $user_event->getEventId()) ?>		
          <?php endforeach?>
	</div>	 
    </div>		
  <?php endif;?> 
<?php endif;//endif visibility?>
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
