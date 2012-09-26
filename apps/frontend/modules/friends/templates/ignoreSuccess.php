<?php use_helper('I18N')?>
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
<?php array_unshift($friendIds, $user_id);?>
<?php array_unshift($friendIdsINA, $user_id);?>
<?php $friendIdsINAignoreduserid=array_merge($friendIdsINA, $ignoreduserid)?> 
<?php $cnt=1;?>
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
		   <a href="#" class="delete_sg" id="<?php echo $userc->getId()?>">x</a>
		   <div class="user_suggest_photo">
	         <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photoc, 'alt=alt=no img'), 'user/'.$userc->getUsername()) ?>
		   </div>
		   <div class="suggestion_details">		     
  		     <?php echo link_to($userc->getUsername(), '/'.$sf_user->getCulture().'/user/'.$userc->getUsername(), 'class=sg_name'); ?>
			 <div class="sg_reason"><?php echo __('the same school')?></div>
			 <div class="sg_links"><?php echo link_to(__('Add to friends'), 'friends/new?friend_id='.$userc->getId())?></div>
		   </div>
		 <?php $cnt++?>			
		 <?php if($cnt==2)break;?>
	    <?php 
	   }
	   //$cnt++;			
       if($cnt==2)break;
	 }
	?>
	<?php array_shift($friendIds)?>
	<?php $admin=array(1);$friendIds=array_diff($friendIds, $admin);?>
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
	                 <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photou, 'alt=alt=no img'), 'user/'.$useru->getUsername()) ?>
			       </div>
				   <div class="suggestion_details">				
  			         <?php echo link_to($useru->getUsername(), '/'.$sf_user->getCulture().'/user/'.$useru->getUsername(), 'class=sg_name'); ?>
				     <div class="sg_reason"><?php echo count(array_intersect($user_friendIdsu, $friendIds))?> <?php echo __('mutual friends')?></div>
			         <div class="sg_links"><?php echo link_to(__('Add to friends'), 'friends/new?friend_id='.$two_random_user)?></div>
			       </div>
			    </div>
			    <?php $cnt++?>
			    <?php if($cnt==2)break;?>
		     <?php endforeach;?>
			
			<?php }//end write less queries?>