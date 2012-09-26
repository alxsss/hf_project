<?php use_helper('Global', 'I18N', 'Text', 'Status','Date') ?>
<div id="updates_left_column">
<?php include_component('friends', 'ulinks')?>
</div>
<div id="right_column_user">
 <div class="friends_to_be_invited">
  <div class="friends_to_be_invited_line"><?php $cnt=0;?>
  <?php foreach ($guest_pager->getResults() as $guest): ?>
    <?php $cnt++;?>
     <div class="user_friend">
      <?php $guestUser=sfGuardUserPeer::retrieveByPk($guest->getGuestId()); ?>
	  <?php $photo=$guestUser->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';}?>
      <div class="user_album_title"><?php  echo link_to($guestUser, 'user/'.$guestUser ) ?></div>
      <div class="album_image" style="width:76px;border:none;padding:0px">
         <?php  echo link_to(image_tag('/uploads/assets/avatars/normal/'.$photo), 'user/'.$guestUser) ?>		  
	  </div>
	  <div class="guest_time">(<?php echo status_date($guest->getCreatedAt('U'), format_date($guest->getCreatedAt(), 'p'))?>)  </div>	
	  <div class="object_del"><a  href="<?php echo url_for('@guest_remove?id='.$guest->getGuestId())?>" title="<?php echo __('Delete')?>">[x]</a></div>	                 	  
    </div>	
   <?php if($cnt==7){echo '</div><div class="friends_to_be_invited_line">';$cnt=0;}?>
  <?php endforeach; ?>
  </div>
  <?php if($guest_pager->haveToPaginate()):?>
    <div class="pagination">
      <div id="photos_pager">
         <?php echo pager_navigation($guest_pager, 'friends/guest') ?>
      </div>
    </div>
  <?php endif;?>
</div>
</div>
<?php include_partial('friends/horizontal_ad')?>
