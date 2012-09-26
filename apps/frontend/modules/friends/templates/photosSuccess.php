<?php use_helper('Global',  'Text', 'I18N', 'Status')?>
<?php $friendIds=array();?>
<?php foreach ($friends as $friend): ?>
  <?php $friendIds[]=$friend->getFriendId();?>
<?php endforeach; ?>
<?php foreach ($friendsAsFriendids as $friend): ?>
  <?php $friendIds[]=$friend->getUserId();?> 
<?php endforeach; ?>
<div id="updates_left_column">
  <?php include_component('friends', 'ulinks')?>
</div>
<div id="updates_right_column">
  <div class="ifp_nav">
    <ul>
	  <li><?php echo link_to(__('statuses'), 'friends/index') ?></li>
	  <li class="last_nb selected"><?php echo link_to(__('photos'), 'friends/photos') ?></li>
	</ul>
  </div>
 

<!--PHOTOS--->

<?php 
$c=new Criteria();
$c->add(PhotoPeer::USER_ID, $friendIds, Criteria::IN);
$c->addDescendingOrderByColumn(PhotoPeer::CREATED_AT); 
$photoUploads=PhotoPeer::doSelectJoinAll($c);
?>
<?php foreach($photoUploads as $photoUpload):?>
  <?php $photo=$photoUpload->getSfGuardUser()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
        <div class="user_status">
          <div class="user_status_photo">
            <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img'), 'user/'.$photoUpload->getsfGuardUser()) ?>
          </div>
		  <div  class="status_photos_text">
            <?php echo link_to($photoUpload->getSfGuardUser(), 'user/'.$photoUpload->getSfGuardUser())?> <?php echo __('uploaded new photo')?> 
            <div class="comment_actions">
			 (<?php echo status_date($photoUpload->getCreatedAt('U'), $photoUpload->getCreatedAt('F j, Y'))?>)		 
	       </div>
		  </div>
		   <div class="user_uploaded_photo">
		     <?php echo link_to(image_tag('/uploads/assets/photos/thumbnails/'.$photoUpload->getFilename()), 'photos/show?id='.$photoUpload->getId())?>
		   </div>
		
	    </div>
<?php endforeach; ?>

<?php 
$c=new Criteria();
$c->add(PhotoCommentPeer::USER_ID, $friendIds, Criteria::IN);
$c->addDescendingOrderByColumn(PhotoCommentPeer::CREATED_AT); 
$photoComments=PhotoCommentPeer::doSelectJoinAll($c);
?>
<?php foreach($photoComments as $photoComment):?>
  <?php $photo=$photoComment->getSfGuardUser()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
	<div class="user_status">
      <div class="user_status_photo">
        <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img'), 'user/'.$photoComment->getsfGuardUser()) ?>
      </div>
	  <div  class="status_photos_text">
        <?php echo link_to($photoComment->getSfGuardUser(), 'user/'.$photoComment->getSfGuardUser())?> <?php echo __('commented on photo')?>
        <div class="comment_actions">
		   (<?php echo status_date($photoComment->getCreatedAt('U'), $photoComment->getCreatedAt('F j, Y'))?>) 		     
	    </div>
	  </div>	
		<div class="user_uploaded_photo">
		  <?php echo link_to(image_tag('/uploads/assets/photos/thumbnails/'.$photoComment->getPhoto()->getFilename()), 'photos/show?id='.$photoComment->getPhoto()->getId())?>
        </div>	 
	</div>
<?php endforeach; ?>
   
</div><!--updates_left_column-->