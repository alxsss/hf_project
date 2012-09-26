<?php use_helper('Global', 'Text', 'I18N', 'Status', 'Date')?>
<?php $friendIds=array();?>
<?php foreach ($friends as $friend): ?>
  <?php $friendIds[]=$friend->getFriendId();?>
<?php endforeach; ?>
<?php foreach ($friendsAsFriendids as $friend): ?>
  <?php $friendIds[]=$friend->getUserId();?> 
<?php endforeach; ?>
<?php $friendIdsINA=array();?>
<?php foreach ($friendsINA as $friendINA): ?>
  <?php $friendIdsINA[]=$friendINA->getFriendId();?>
<?php endforeach; ?>
<?php foreach ($friendsAsFriendidsINA as $friendINA): ?>
  <?php $friendIdsINA[]=$friendINA->getUserId();?> 
<?php endforeach; ?>
<?php $ignoreduserid=array();?>
<?php foreach ($ignorelists as $ignorelist): ?>
  <?php $ignoreduserid[]=$ignorelist->getIgnoredUserId();?> 
<?php endforeach; ?>
<?php $user_group_ids=array();?>
<?php foreach ($user_groups as $user_group): ?>
  <?php $user_group_ids[]=$user_group->getGroupId();?> 
<?php endforeach; ?>
<?php array_unshift($friendIds, $user_id); //add user_id in order to see its updates in the list too?>
<?php array_unshift($friendIdsINA, $user_id);?>
<div id="updates_left_column">
  <?php include_component('friends', 'ulinks')?>
  <div class="left_boxes">
  <div class="left_boxes_title" style="margin:0 2px 0 2px;"><?php echo __('Members last logged in') ?></div>	 
  <div class="group_members">
    <div class="members_line">
      <?php foreach ($last_logged_in_users as $i=>$last_logged_in_user): ?>
        <div class="group_member">           
          <?php echo link_to(image_tag($last_logged_in_user->getThumb(), 'title=' . $last_logged_in_user ), url_for('@user_profile?username='.$last_logged_in_user) ) ?>
          <div class="group_member_title">
             <a href="<?php echo url_for('@user_profile?username='.$last_logged_in_user)?>" > <?php echo mb_substr($last_logged_in_user, 0, 9,'UTF-8').'<wbr>'.mb_substr($last_logged_in_user, 9, strlen($last_logged_in_user), 'UTF-8') ?></a>
           </div>
          </div>
         <?php if($i==2){echo '</div><div class="members_line">';}?>
       <?php endforeach ?>
     </div><!--members_line-->
   </div>	   
 </div>
    <?php include_partial('friends/ad200x200')?>

</div>	
<div id="right_column_user">
 <div id="updates_status_right_column">  
   
<?php if($user_id==4):?>
<div id="post_links"><a href="#" class="post_links_elements_active" id="post_status"><?php echo __('Status')?></a><a href="#"  class="post_links_elements"  id="post_link"><?php echo __('Link')?></a></div>
    <div id="status_box">
          <form id="user_status_form" action="<?php echo url_for('links/poststatus')?>" method="post">
            <input type="text" id="user_status_box" name="user_status_box" class="defaultText cleardefault submit_status_link_input" title="<?php echo __('What do you think?')?>"  maxlength="150" value="<?php echo __('What do you think?')?>">

<div id="atc_bar" align="center" action="postlink">
      <input type="text" name="url" size="40" id="url" value="http://" class="defaultText cleardefault post_link_url" title="http://" />
      <input type="button" name="attach" value="Parse" id="attach" />
      <input type="hidden" name="cur_image" id="cur_image" />
      <div id="loader">
         <div align="center" id="atc_loading" style="display:none"><img src="/images/load.gif" alt="Loading" /></div>
         <div id="attach_content" style="display:none">
            <div id="atc_images"></div>
            <div id="atc_info">
               <label id="atc_title"></label>
               <label id="atc_url"></label>
               <br clear="all" />
               <label id="atc_desc"></label>
               <br clear="all" />
            </div>
            <div id="atc_total_image_nav" >
               <a href="#" id="prev"><img src="/images/prev.png"  alt="Prev" border="0" /></a><a href="#" id="next"><img src="/images/next.png" alt="Next" border="0" /></a>
            </div>
            <div id="atc_total_images_info" >
               Showing <span id="cur_image_num">1</span> of <span id="atc_total_images">1</span> images
            </div>
            <br clear="all" />
         </div>
      </div>
            <input type="text" id="post_link_text" name="post_link_text" class="defaultText cleardefault post_link_text" title="<?php echo __('Say something about this link')?>"  maxlength="150" value="<?php echo __('Say something about this link')?>">

   </div>
            <div class="submit_status_link_button">
              <input type="submit" value="<?php echo __('Submit')?>" id="user_feed_button">
            </div>
          </form>
    </div>
 <div class="user_status_element_new"></div>
<style>
   #attach{height: 30px;background: none repeat scroll 0 0 #999900;border-style: solid none none solid;border-width: 1px medium medium 1px; box-shadow: 2px 2px 2px #CFCFCF; color: #FFFFFF; cursor: pointer; font-size: 11px;font-weight: bold;overflow: visible;padding: 2px 9px 4px 9px;}
   .post_link_url{height:30px;padding:0 0 0 2px;width:390px;}
   .post_link_text{height:30px;width:450px;display:none;}
   .post_links_elements_active{padding:0 10px 0 0;color:#000;cursor:pointer;display:block;text-decoration:none;font-weight:bold;float:left;}
   .post_links_elements{padding:0 10px 0 0;color:#3B5998;cursor:pointer;display:block;text-decoration:none;font-weight:bold;float:left;}
   #atc_bar{width:500px;float:left;display:none;padding:5px 0;}
   #attach_content{padding:5px;margin-top:5px;width:450px;}
   #atc_images {width:90px;float:left;}
   #atc_images img{width:90px}
   #atc_info {width:300px;float:left;text-align:left; padding:10px;}
   #atc_title {font-size:14px;display:block;}
   #atc_url {font-size:10px;display:block;}
   #atc_desc {font-size:12px;}
   #atc_total_image_nav{float:left;padding-left:5px}
   #atc_total_images_info{float:left;padding:4px 10px;font-size:12px;}
   .link_title{float:left;width:250px;padding:5px 0 0 10px;}
   .link_url{float:left;width:250px;font-size:11px;padding:0 0 5px 10px;}
   .link_description{float:left;width:250px;padding:0 10px;}
   #post_links{width:485px;padding:0 0 0 20px;float:left;}
   .submit_status_link_button{margin: 0 0 0 20px;padding: 0 5px;display:none;}
   .submit_status_link_input{width:450px;}
</style>
 


  <?php endif;?>



  <?php $updates=UpdatesPeer::getUpdatesPager($page, $friendIds, $user_group_ids);?>
  <?php //$userid=array();//use this array to keep user ids in order not to allow multiple uploads to appear under each other?>
  <?php if(count($updates->getResults())>0):?>
    <?php foreach($updates->getResults() as $key=>$update):?>    
      <?php //$userid[]=$update->getUserId()?>    
	      <?php if($update->getPid()==1):?>
		    <?php $user=sfGuardUserPeer::retrieveByPk($update->getUserId()); $photo=$user->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
           <div class="user_status">
             <div class="user_status_photo">
               <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img class=border_image'), '@user_profile?username='.$user->getUsername()) ?>
             </div>
	         <div  class="status_text">
              <?php //if($key>0&&$userid[$key-1]==$userid[$key])?>
               <div  class="status_photos_text">
             <span class="update_username"><?php echo link_to($user->getUsername(), '@user_profile?username='.$user->getUsername())?></span> <?php echo __('uploaded new photo')?>             
		  </div>
		  <div class="uploaded_photo">
		    <a href="<?php echo url_for('photos/show?id='.$update->getId())?>">
		      <div class="album_image">
		        <?php echo image_tag('/uploads/assets/photos/thumbnails/'.$update->getFStatusName(),'class=image_with_border')?>
		      </div>
		    </a>
		  </div>
		  <div class="comment_actions">
	           <div class="updates_action">
                    (<?php echo status_date($update->getCreatedAt('U'), format_date($update->getCreatedAt(), 'p'))?>) 			            
		    <span class="interested_block">
                      <?php $photos=PhotoPeer::retrieveByPk($update->getId())?>
                      <?php include_partial('photos/photo_rates', array('photos' => $photos)) ?>
                    </span>
		    <a href="#" class="comment_status"><?php echo __('comment')?></a> 			
                 </div>
            <div class="add_status_comment">			  
              <?php include_partial('photo_comment', array('user_id'=>$user_id, 'photo_id'=>$update->getId())) ?>  
			  <div class="user_status_comment_new"></div>
            </div>
            <div class="status_comment_box" <?php if($update->getNumComment())echo 'style="display:block;"';?>>
			 <form action="<?php echo url_for('@add_photo_comment')?>" method="post">
			   <input type="hidden" value="<?php echo $update->getId()?>"  name="item_id">             
               <input type="hidden" value="<?php echo $update->getUserId()?>"  name="item_user_id">       
			   <input type="hidden" value="<?php echo $page ?>"  name="page">  
			   <textarea class="expand24 status_box defaultText cleardefault" id="comment" name="comment" style="height:24px;overflow:hidden;padding:0px;" title="<?php echo __('comment')?>"><?php echo __('comment')?></textarea>     
               <div class="submit-row">      
                 <input type="submit" value="<?php echo __('comment')?>" class="status_comment_box_form"> 
               </div>			  
             </form>
           </div>
	    </div>	
	  </div>
     </div>
		<?php elseif($update->getPid()==2):?>	
		    <?php $user=sfGuardUserPeer::retrieveByPk($update->getUserId()); $photo=$user->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
      <div class="user_status">
        <div class="user_status_photo">
          <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img class=border_image'), '@user_profile?username='.$user->getUsername()) ?>
        </div>
	    <div  class="status_text">
		  <span class="update_username"><?php echo link_to($user->getUsername(), '@user_profile?username='.$user->getUsername())?></span>:<?php echo $update->getFStatusName()?>
		  <div class="comment_actions">
	          <div class="updates_action">
	            (<?php echo status_date($update->getCreatedAt('U'), format_date($update->getCreatedAt(), 'p'))?>) 			            
			<a href="#" class="comment_status"><?php echo __('comment')?></a>
                     <?php if($user_id==$update->getUserId()):?>
                     <span class="delete_status">
                        <a href="#" status_id="<?php echo $update->getId()?>" action="<?php echo url_for('@delete_status')?>"><?php echo __('delete')?></a>
                      </span>
                     <?php endif;?>
               </div>
               <div class="add_status_comment">
                 <?php include_partial('status_comment', array('user_id'=>$user_id, 'status_id'=>$update->getId())) ?> 
			  <div class="user_status_comment_new"></div> 
            </div>
            <div class="status_comment_box" <?php if($update->getNumComment())echo 'style="display:block;"';?>>
			  <form action="<?php echo url_for('@add_status_comment')?>" method="post">
                <input type="hidden" value="<?php echo $update->getId()?>"  name="item_id">             
                <input type="hidden" value="<?php echo $update->getUserId()?>"  name="item_user_id">       
			    <input type="hidden" value="<?php echo $page ?>"  name="page"> 		 
               <textarea class="expand24 status_box defaultText cleardefault" id="comment" name="comment" style="height: 24px; overflow: hidden; padding:0;"  title="<?php echo __('comment')?>"><?php echo __('comment')?></textarea>  
			   <div class="submit-row">      
                 <input type="submit" value="<?php echo __('comment')?>" class="status_comment_box_form"> 
                </div>			  
             </form>
           </div>
	      </div>
		</div>
       </div>
	    <?php elseif($update->getPid()==3):?>	
		  <?php $user=sfGuardUserPeer::retrieveByPk($update->getUserId()); $photo=$user->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
          <div class="user_status">
            <div class="user_status_photo">
              <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img class=border_image'), '@user_profile?username='.$user->getUsername()) ?>
            </div>
	        <div  class="status_text">	
              <?php $fuser=sfGuardUserPeer::retrieveByPk($update->getFStatusName()); ?>
              <div  class="status_photos_text">
                <span class="update_username"><?php echo link_to($user->getUsername(), '@user_profile?username='.$user->getUsername())?></span> <?php echo __('and')?>  <?php echo link_to($fuser->getUsername(), '@user_profile?username='.$fuser->getUsername())?>
			    <?php echo __('are friends now')?>             
		      </div>
		      <div class="comment_actions">
	            (<?php echo status_date($update->getCreatedAt('U'), format_date($update->getCreatedAt(), 'p'))?>) 			            
	          </div>
		   </div>
        </div>	
		<?php elseif($update->getPid()==4):?>
		  <?php $user=sfGuardUserPeer::retrieveByPk($update->getUserId()); $photo=$user->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
          <div class="user_status">
            <div class="user_status_photo">
              <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img class=border_image'), '@user_profile?username='.$user->getUsername()) ?>
            </div>
	        <div  class="status_text">
              <div  class="status_photos_text">
               <span class="update_username"><?php echo link_to($user->getUsername(), '@user_profile?username='.$user->getUsername())?></span> <?php echo __('commented on photo')?>             
		      </div>
		      <div class="uploaded_photo">
		        <a href="<?php echo url_for('photos/show?id='.$update->getId())?>">
		          <div class="album_image">
		            <?php echo image_tag('/uploads/assets/photos/thumbnails/'.$update->getFStatusName(),'class=image_with_border')?>
		          </div>
		        </a>
		      </div>		
		      <div class="comment_actions">
	            <div class="updates_action">
         	      (<?php echo status_date($update->getCreatedAt('U'), format_date($update->getCreatedAt(), 'p'))?>) 			            
	  	          <span class="interested_block">
			        <?php $photos=PhotoPeer::retrieveByPk($update->getId())?>
                    <?php include_partial('photos/photo_rates', array('photos' => $photos)) ?>
                  </span> 
			     <a href="#" class="comment_status"><?php echo __('comment')?></a>
                </div>
                <div class="add_status_comment">
                  <?php include_partial('photo_comment', array('user_id'=>$user_id, 'photo_id'=>$update->getId())) ?>
				  <div class="user_status_comment_new"></div>  
                </div>
                <div class="status_comment_box" <?php if($update->getNumComment())echo 'style="display:block;"';?>>
			      <form action="<?php echo url_for('@add_photo_comment')?>" method="post">
			        <input type="hidden" value="<?php echo $update->getId()?>"  name="item_id">             
                    <input type="hidden" value="<?php echo $update->getUserId()?>"  name="item_user_id">       
			        <input type="hidden" value="<?php echo $page ?>"  name="page">               	 
               <textarea class="expand24 status_box defaultText cleardefault" id="comment" name="comment" style="height: 24px; overflow: hidden; padding:0;"  title="<?php echo __('comment')?>"><?php echo __('comment')?></textarea>  
                    <div class="submit-row"> 
			          <input type="submit" value="<?php echo __('comment')?>" class="status_comment_box_form">                    
                    </div>			  
                  </form>
                </div>
	          </div>
			</div>
          </div>
		 <?php elseif($update->getPid()==5):?>	
		  <?php $group_status=GroupStatusPeer::retrieveByPk($update->getId()); $group=$group_status->getsfSocialGroup();$photo=$group->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
          <div class="user_status">
            <div class="user_status_photo">
              <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img class=border_image'), '@sf_social_group?id='.$group->getId()) ?>
            </div>
	        <div  class="status_text">
		      <span class="update_username"><?php echo link_to($group->getTitle(), '@sf_social_group?id='.$group->getId()) ?></span>:<?php echo $update->getFStatusName()?>
		      <div class="comment_actions">
	            <div class="updates_action">
	             (<?php echo status_date($update->getCreatedAt('U'), format_date($update->getCreatedAt(), 'p'))?>) 			            
			      <a href="#" class="comment_status"><?php echo __('comment')?></a>
                </div>
                <div class="add_status_comment">
				  <?php include_partial('sfSocialGroup/group_status_comment', array('user_id'=>$user_id, 'status_id'=>$update->getId())) ?>                  
			    <div class="user_status_comment_new"></div> 
            </div>
            <div class="status_comment_box" <?php if($update->getNumComment())echo 'style="display:block;"';?>>
			  <form action="<?php echo url_for('@add_group_status_comment')?>" method="post">
                <input type="hidden" value="<?php echo $update->getId()?>"  name="item_id">             
                <input type="hidden" value="<?php echo $group->getId()?>"  name="item_user_id">       
			    <input type="hidden" value="<?php echo $page ?>"  name="page"> 		 
               <textarea class="expand24 status_box defaultText cleardefault" id="comment" name="comment" style="height: 24px; overflow: hidden; padding:0;"  title="<?php echo __('comment')?>"><?php echo __('comment')?></textarea>  
                <div class="submit-row">      
                 <input type="submit" value="<?php echo __('comment')?>" class="status_comment_box_form"> 
                </div>			  
             </form>
           </div>
	      </div>
		</div>
       </div>
       <?php endif;?>		
     <?php  endforeach; ?>
  <?php else:?>
    <div class="no_updates"><?php echo __('This place is for your friends activity. Currently you do not have friends.');?>	</div>
	<div class="find_friend"> <?php echo link_to(__('invite friends'), '@invitefriend')?></div>	 		
  <?php endif; //end of count($updates?>		
  <div class="updates_pagination">
    <div id="photos_pager">
      <?php echo pager_navigation($updates, '@updates') ?>
    </div>
  </div>
</div><!--updates_status_right_column-->
  <div id="friend_suggestions">
    <?php $friendIdsINAignoreduserid=array_merge($friendIdsINA, $ignoreduserid);//merge friends including not approved ones and ignored users)?>
    <div class="suggestion_title"><?php echo __('Suggestions')?></div>     
	<?php $cnt=0;?>
	<?php
	 foreach($subscriber->getSchoolUsers() as $schoolUser)
	 {
	   $c=new Criteria();
	   $c->add(SchoolUserPeer::SCHOOL_ID, $schoolUser->getSchoolId());   	   
  	   $ccmate1 = $c->getNewCriterion(SchoolUserPeer::GRAD_YEAR, $schoolUser->getGradYear()-3, Criteria::GREATER_EQUAL);
	   $ccmate2 = $c->getNewCriterion(SchoolUserPeer::GRAD_YEAR, $schoolUser->getGradYear()+2, Criteria::LESS_EQUAL);
	   $ccmate1->addAnd($ccmate2);
	   $c->add($ccmate1);
   	   $c->add(SchoolUserPeer::USER_ID, $friendIdsINAignoreduserid,Criteria::NOT_IN);
   	   $classmates=SchoolUserPeer::doSelect($c);
	   foreach($classmates as $classmate)
	   {
		 $userc=$classmate->getsfGuardUser(); $photoc=$userc->getProfile()->getPhoto();  if(empty($photoc)){$photoc='no_pic.gif';}?>
		 <div  class="friend_suggestion">
		   <a href="#" class="delete_sg" id="<?php echo $userc->getId()?>">x</a>
		   <div class="user_suggest_photo">
	         <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photoc, 'alt=alt=no img'), '@user_profile?username='.$userc->getUsername()) ?>
		   </div>
		   <div class="suggestion_details">		     
  		     <?php echo link_to($userc->getUsername(), '@user_profile?username='.$userc->getUsername(), 'class=sg_name'); ?>
			 <div class="sg_reason"><?php echo __('the same school')?></div>
			 <div class="sg_links"><?php echo link_to(__('Add to friends'), 'friends/new?friend_id='.$userc->getId())?></div>
		   </div>
		 </div>
		 <?php $cnt++?>			
		 <?php if($cnt==2)break;?>
	    <?php 
	   }
	   //$cnt++;			
       if($cnt==2)break;
	 }
	?>
	<?php array_shift($friendIds)//exclude self from list of friends?> 
	<?php  $admin=array(1);$friendIds=array_diff($friendIds, $admin); //exclude admin from list of friends?>
	<?php  // write less queries 
	      $fofids = array();
	      $cfof=new Criteria();
          $cfof1 = $cfof->getNewCriterion(FriendPeer::USER_ID,  $friendIds, Criteria::IN);
          $cfof2 = $cfof->getNewCriterion(FriendPeer::FRIEND_ID, $friendIds, Criteria::IN);
          $cfof1->addOr($cfof2);
          $cfof->add($cfof1);
		  $cfof->add(FriendPeer::APPROVED,1);
		  $fofs=FriendPeer::doSelect($cfof);
		  foreach ($fofs as $fof) 
		  {
		    $fofids[]=$fof->getUserId();
		    $fofids[]=$fof->getFriendId();
		  }
		  //exclude friends and ignored users 
		  $fof_ex_f_igu=array_diff($fofids, $friendIdsINAignoreduserid);
		  //select two random keys
		  $num_of_fof_ex_f_igu=count($fof_ex_f_igu);
		  $two_random_users=array();
		  if($num_of_fof_ex_f_igu>0)
		  {
		    if($num_of_fof_ex_f_igu>1)
		    {
		      $two_random_keys=array_rand($fof_ex_f_igu,2);
			  foreach($two_random_keys as $two_random_key)
			  {
			    $two_random_users[]=$fof_ex_f_igu[$two_random_key];
			  }
		    }
		    else
		    {
		      $two_random_users=$fof_ex_f_igu;
		    }			
		  ?>
		  <?php foreach($two_random_users as $two_random_user):?>
		   <?php $useru=sfGuardUserPeer::retrieveByPk($two_random_user); $photou=$useru->getProfile()->getPhoto();  if(empty($photou)){$photou='no_pic.gif';}?>
		  <?php 
                         $c_a1=new Criteria();
	                 $c_a1->add(FriendPeer::APPROVED,1); 
		         //find friends of this user, in order to count mutual friends
			 $user_friendsu = $useru->getFriendsRelatedByUserId($c_a1);
	                 $user_friendsAsFriendidsu = $useru->getFriendsRelatedByFriendId($c_a1);			       
		         $user_friendIdsu=array();?>
                   <?php foreach ($user_friendsu as $user_friendu): ?>
                     <?php  $user_friendIdsu[]=$user_friendu->getFriendId();?>
                   <?php endforeach; ?>
                   <?php foreach ($user_friendsAsFriendidsu as $user_friendsAsFriendidu): ?>
                     <?php  $user_friendIdsu[]=$user_friendsAsFriendidu->getUserId();?> 
                    <?php endforeach; ?>	
			       <div class="friend_suggestion">
			         <a href="#" class="delete_sg" id="<?php echo $two_random_user?>" title="<?php echo __('ignore')?>">x</a>
			       <div class="user_suggest_photo">
	                 <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photou, 'alt=alt=no img'), '@user_profile?username='.$useru->getUsername()) ?>
			       </div>
				   <div class="suggestion_details">				
  			         <?php echo link_to($useru->getUsername(), '@user_profile?username='.$useru->getUsername(), 'class=sg_name'); ?>
				     <div class="sg_reason"><?php echo count(array_intersect($user_friendIdsu, $friendIds))?> <?php echo __('mutual friends')?></div>
			         <div class="sg_links"><?php echo link_to(__('Add to friends'), 'friends/new?friend_id='.$two_random_user)?></div>
			       </div>
			    </div>
			    <?php $cnt++?>
			    <?php if($cnt==2)break;?>
		     <?php endforeach;?>
			
			<?php }//end write less queries?>
			<div class="find_friends">
      <div class="suggestions_all"><?php echo __('With your help we can build the most powerful social networking. Please find and invite friends. Also let us know if you have any suggestions.')?></div>
      <div class="find_friend"> <?php echo link_to(__('invite friends'), '@invitefriend')?></div>
	</div>
<?php if(count($friendIds)>0):?>
	<?php $friendids_string=implode(',', $friendIds);?>
	<?php
	      $connection = Propel::getConnection();
           $query ='select  u.id from sf_guard_user u, 
		   sf_guard_user_profile p where u.id=p.user_id and  ((DAYOFYEAR(p.birthday)-DAYOFYEAR(now()) )<14 AND (DAYOFYEAR(p.birthday)-DAYOFYEAR(now()) )>=0 ) and u.id IN ('.$friendids_string.')';
		   $statement = $connection->prepare($query);
	       $statement->execute(); ?>
    <?php $bday_users_ids=array();?>
	<?php while ($bday_users=$statement->fetch(PDO::FETCH_BOTH)): ?>
	   <?php $bday_users_ids[]=$bday_users['id']; ?>
	<?php endwhile; ?>	
	<?php //select two random keys
		  $num_of_bday_users=count($bday_users_ids);
		  $two_random_bday_users=array();
		  if($num_of_bday_users>0)
		  {
		    if($num_of_bday_users>1)
		    {
		      $two_random_bday_keys=array_rand($bday_users_ids,2);
			  foreach($two_random_bday_keys as $two_random_bday_key)
			  {
			    $two_random_bday_users[]=$bday_users_ids[$two_random_bday_key];
			  }
		    }
		    else
		    {
		      $two_random_bday_users=$bday_users_ids;
		    }			
		  ?>
	<div class="suggestion_title"><?php echo __('Birthdays')?></div> 
	<?php foreach($two_random_bday_users as $two_random_bday_user):?>
      <?php $bday_user=sfGuardUserPeer::retrieveByPk($two_random_bday_user); $bday_photo=$bday_user->getProfile()->getPhoto();  if(empty($bday_photo)){$bday_photo='no_pic.gif';}?>
  	  <?php $days_left=$bday_user->getProfile()->getBirthday('z')-date('z', time());?>
	  <div class="friend_suggestion">
        <div class="user_suggest_photo">
	      <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$bday_photo, 'alt=alt=no img'), '@user_profile?username='.$bday_user->getUsername() ) ?>
		</div>
	    <div class="suggestion_details">				
  		  <?php echo link_to($bday_user->getUsername(), '@user_profile?username='.$bday_user->getUsername(), 'class=sg_name'); ?>
		  <div class="sg_birthday"><?php echo $bday_user->getProfile()->getBirthday('F j')?>&nbsp&nbsp&nbsp&nbsp&nbsp
			 <?php if($days_left>0){echo __('%days% days left', array('%days%'=>$days_left));}else{echo '<span style="color:#FF0000;">'.__('today').'</span>';}?></div>
		  </div>
	 	</div>
   	  <?php endforeach;?>  
	<?php }//end if($num_of_bday_users>0) ?>
<?php endif;?>

   <div class="right_boxes">
      <div class="suggestion_title"><?php echo __('New photos') ?></div>	 
      <div class="group_members">
	      <div class="members_line">
	   <?php foreach($new_photos as $i=>$new_photo): ?>
          <div class="popular_photo">           
            <?php echo link_to(image_tag('/uploads/assets/photos/thumbnails/'.$new_photo->getFilename(), 'class=image_with_border'), url_for('photos/show?id='.$new_photo->getId()) ) ?>
            <?php if($new_photo->getRating()): ?>
			 <div class="popular_photo_title"><?php echo __('rates').'('.$new_photo->getRating().')'?> </div>
            <?php endif;?>
		  </div>
         <?php if($i==1){echo '</div><div class="members_line">';}?>
        <?php endforeach;?>
		  </div><!--members_line-->
		   <div class="see_all"><?php echo link_to(__('see all'), '@photos?sort=created_at&type=desc')?></div>
      </div>
	 </div><!--end right_boxes-->
	
     <?php include_partial('friends/ad200x200')?>
 <div class="right_boxes">
      <div class="suggestion_title"><?php echo __('Popular photos') ?></div>	 
      <div class="group_members">
	      <div class="members_line">
	   <?php foreach($popular_photos as $i=>$popular_photo): ?>
          <div class="popular_photo">           
            <?php echo link_to(image_tag('/uploads/assets/photos/thumbnails/'.$popular_photo->getFilename(), 'class=image_with_border'), url_for('photos/show?id='.$popular_photo->getId()) ) ?>
             <div class="popular_photo_title"><?php echo __('rates').'('.$popular_photo->getRating().')'?> </div>
		  </div>
         <?php if($i==1){echo '</div><div class="members_line">';}?>
        <?php endforeach;?>
		  </div><!--members_line-->
		   <div class="see_all"><?php echo link_to(__('see all'), '@popular_photos?sort=rating&type=desc')?></div>
      </div>
	 </div><!--end right_boxes-->
    <div class="right_boxes">
      <div class="suggestion_title"><?php echo __('New members') ?></div>	 
      <div class="group_members">
       <div class="members_line">
         <?php foreach ($newest_users as $i=>$newest_user): ?>
           <?php $newest_user_username= truncate_text($newest_user->getUsername(),21)?>
           <div class="group_member">           
             <?php echo link_to(image_tag($newest_user->getThumb(), 'title=' . $newest_user), url_for('@user_profile?username='.$newest_user) ) ?>
             <div class="group_member_title">
              <a href="<?php echo url_for('@user_profile?username='.$newest_user)?>" > <?php echo mb_substr($newest_user_username, 0, 9,'UTF-8').'<wbr>'.mb_substr($newest_user_username, 9, strlen($newest_user_username), 'UTF-8') ?></a>
               </div>
  	  </div>
          <?php if($i==2){echo '</div><div class="members_line">';}?>
        <?php endforeach ?>
       </div><!--members_line-->
        <div class="see_all"><?php echo link_to(__('see all'), '@all_users')?></div>
      </div><!-- group_members-->	   
    </div><!-- right_boxes-->
 
  </div><!--id="friend_suggestions"-->
</div><!--id="right_column_user"-->
