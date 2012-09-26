<?php use_helper('Date', 'Global', 'I18N') ?>
<div id="left_column_user">
  <div class="user_contact">
    <!--in case if a user is not signed in and album is visible $user_id is not defined-->
    <?php echo link_to($photo->getsfGuardUser().__('\'s profile'), '@user_profile?username='.$photo->getsfGuardUser(), 'class=user_links') ?>	
    <?php echo link_to(__('All photos by %author%', array('%author%'=>$photo->getsfGuardUser())),'@all_photos?username='.$photo->getsfGuardUser(), 'class=user_links')?>
    <?php echo link_to( __('All albums by %author%', array('%author%'=>$photo->getsfGuardUser())), '@all_albums?username='.$photo->getsfGuardUser(), 'class=user_links')?>
  </div> 
 <?php if($sf_user->isAuthenticated()):?> 
    <?php include_component('friends', 'ulinks')?>
  <?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
 <?php include_partial('friends/ad200x200')?>
</div>
<div id="right_column_user">
  <?php if($photo->getVisibility()&&!($photo_user->isFriend($user_id)||($user_id==$photo_user_id)) ):?>
    <?php echo __('This photo is set to private')?>
    <div class="photo_pagination">
      <?php echo pager_photo_navigation($photos_pager, 'photos/showpopular', $photo_id) ?>  
    </div>
  <?php else:?>
    <?php  if($photo->getAlbumId()):?>
      <?php echo __('From album')?> <?php echo link_to($photo->getAlbum()->getTitle(), 'albums/show/?id='.$photo->getAlbum()->getId())?>
    <?php endif;?>
    <div id="show_photo">
           <?php $img_url_normal='/uploads/assets/photos/normal/'.$photo->getFilename()?>
      <div id="photo">
        <div class="photo_title"><?php echo $photo->getTitle()?></div>
        <div class="photo_pagination">
          <?php echo pager_photo_navigation($photos_pager, 'photos/showpopular', $photo_id) ?>  
        </div>
        <?php echo image_tag($img_url_normal, '')?>
        <div class="photo_pagination">
          <?php echo pager_photo_navigation($photos_pager, 'photos/showpopular', $photo_id) ?>  
        </div>
         <span class="interested_block"><?php include_partial('photo_rates', array('photos' => $photo)) ?></span>
        <?php $photo_owner=$photo->getsfGuardUser()->getUsername();?>
        <?php echo __('uploaded on')?> <?php echo format_date($photo->getCreatedAt(), 'p') ?>
        <?php $photo_owner_id=$photo->getUserId();?>	
        <?php if($sf_user->isAuthenticated()&&($photo_owner_id==$user_id)):?>
          <?php echo link_to(__('edit photo'), 'photos/edit?id='.$photo->getId());?> 
        <?php  endif;?>
         <span class="interested_block"><?php include_partial('favorite', array('photos' => $photo)) ?></span> 

		<?php $rated= PhotoRatePeer::retrieveByPK($photo->getId(), $user_id); if($rated){$rate=$rated->getRate(); $read_only=1;}else{$rate=0;$read_only='';}?>
		 <div id="photo_rating" read_only="<?php echo $read_only;?>" photo_id="<?php echo $photo->getId()?>" rate="<?php echo $rate;?>"></div>        
		   <div class="rating_titles">
		     <div id="popup-1" class="popup" style="position: absolute;left:-7px; top:-40px;"><?php echo __('bad')?></div>
		     <div id="popup-2" class="popup" style="position: absolute;left: 12px; top:-40px;"><?php echo __('poor')?></div>
		     <div id="popup-3" class="popup"  style="position: absolute;left:32px;top:-40px;"><?php echo __('regular')?></div>
		     <div id="popup-4" class="popup" style="position: absolute;left: 50px;top:-40px;"><?php echo __('good')?></div>
		     <div id="popup-5" class="popup" style="position: absolute;left: 70px;top:-40px;"><?php echo __('gorgeus')?></div>
		   </div>
	  </div> 
    </div> 
    <div id="add_comment" class="add_status_comment">
      <?php include_partial('comment', array('user_id'=>$user_id, 'photos' => $photo, 'comments' =>$photo->getPhotoCommentsJoinsfGuardUser())) ?> 
      <div class="user_status_comment_new"></div>  
    </div>
    <?php if ($sf_user->isAuthenticated()): ?>
      <div class="status_comment_box" style="display:block;padding:0 0 50px 10px;">
	    <form action="<?php echo url_for('@add_comment')?>" method="post">
          <input type="hidden" value="<?php echo $photo->getId()?>"  name="item_id">             
          <input type="hidden" value="<?php echo $photo->getUserId()?>"  name="item_user_id">	   
		  <input type="hidden" value="1"  name="page">		 
          <textarea cols="20" rows="3" class="expand24 status_box" id="comment" name="comment" style="height: 24px; overflow: hidden; padding-top: 0px; padding-bottom: 0px;"></textarea>
          <div class="submit-row">      
            <input type="submit" value="<?php echo __('comment')?>" class="status_comment_box_form"> 
          </div>			  
        </form>
      </div>
    <?php else: ?>
      <div class="comment">
        <?php echo __('You must ')?><span class="toggle_to_login"><a href="#"><?php echo __('sign in')?></a><?php echo __(' to submit a comment') ?></span>
	  </div>
    <?php endif;//endif of comment ?>
  <?php endif;?>
</div><!--end right column-->
<?php include_partial('friends/horizontal_ad')?>
