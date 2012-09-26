<?php use_helper('Global', 'I18N') ?>
<div id="updates_left_column">
<?php if($sf_user->isAuthenticated()):?> 
 <?php include_component('sfSocialGroup', 'glinks')?>
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
</div>
<div id="right_column_user">
  <?php if($group->isAdmin($user_id)): ?>
    <div class="friends_to_be_invited">
    <div class="friends_to_be_invited_line"><?php $cnt=0;?>
      <?php foreach ($allmembers_pager->getResults() as $member): ?>
        <?php $cnt++;?>
        <div class="user_friend">
         <?php $photo=$member->getSfGuardUser()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';}?>
         <div class="user_album_title"><?php  echo link_to($member->getSfGuardUser(), 'user/'.$member->getSfGuardUser() ) ?></div>
         <div class="album_image" style="width:76px;border:none;padding:0px">
            <?php  echo link_to(image_tag('/uploads/assets/avatars/normal/'.$photo), 'user/'.$member->getSfGuardUser() ) ?>		  
	 </div>
         <div class="object_del"><a href="<?php echo url_for('@group_user_delete?group_id='.$group->getId().'&user_id='.$member->getUserId())?>">[x]</a></div>
      </div>	
    <?php if($cnt==7){echo '</div><div class="friends_to_be_invited_line">';$cnt=0;}?>
    <?php endforeach;?>
  </div> 
 <?php endif;?>           	  
  <?php if($allmembers_pager->haveToPaginate()):?>
    <div class="pagination">
     <div id="photos_pager">
       <?php echo pager_navigation($allmembers_pager, '@group_edit_members?id='.$group->getId() )?>
     </div>
    </div>
  <?php endif;?>           	  
</div>
</div>
<?php include_partial('friends/horizontal_ad')?>

