<?php use_helper('Global', 'Javascript', 'Text', 'Form','I18N', 'Status')?>
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
	  <li class="selected"><?php echo link_to(__('statuses'), 'friends/index') ?></li>
	  <li class="last_nb"><?php echo link_to(__('photos'), 'friends/photos') ?></li>
	</ul>
  </div>
  <?php 
    array_unshift($friendIds, $user_id);
    $c=new Criteria();
    $c->add(sfGuardUserStatusPeer::USER_ID, $friendIds, Criteria::IN);
    $c->addDescendingOrderByColumn(sfGuardUserStatusPeer::CREATED_AT); 
    $userStatus=sfGuardUserStatusPeer::doSelectJoinsfGuardUser($c);
  ?>
  <?php foreach($userStatus as $i=>$status):?>
    <?php $photo=$status->getsfGuardUser()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
    <div class="user_status">
      <div class="user_status_photo">
        <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img'), 'user/'.$status->getsfGuardUser()) ?>
      </div>
	  <div  class="status_text">
        <?php echo link_to($status->getSfGuardUser(), 'user/'.$status->getSfGuardUser())?>:<?php echo $status->getStatusName()?>
        <div class="comment_actions">
	      (<?php echo status_date($status->getCreatedAt('U'), $status->getCreatedAt('F j, Y'))?>) 
			<a href="#" class="comment_status"><?php echo __('comment')?></a>
			<?php //if($status->countsfGuardUserStatusComments()>0):?>
            <div id="add_status_comment_<?php echo $i?>" class="add_status_comment">
              <?php include_partial('comment', array('user_id'=>$user_id, 'index'=>$i, 'comments' =>$status->getsfGuardUserStatusCommentsJoinsfGuardUser(), 'status'=>$status)) ?>  
            </div>
            <div class="status_comment_box">
              <?php echo form_remote_tag(array(
               'url'      => '@add_status_comment',
               'update'   => array('success' => 'add_status_comment_'.$i),
               'loading'  => "Element.show('indicator')",
			   'complete' => visual_effect('highlight', 'add_status_comment_'.$i),
	            )) ?>
              <?php echo input_hidden_tag('status_id', $status->getId()) ?>
	          <?php echo input_hidden_tag('index', $i) ?>
			 
                <?php echo textarea_tag('comment', '', 'size=30x3 class=expand status_box') ?>
                <div class="submit-row">      
                  <?php echo submit_tag(__('comment')) ?>
                </div>
			  
             </form>
           </div>
		<?php // else:?>
		 
		<?php //endif;?>
		   
		   
	  </div>
	</div>
  </div>

      <?php endforeach; ?>
      <?php array_shift($friendIds)?>   
</div><!--updates_left_column-->