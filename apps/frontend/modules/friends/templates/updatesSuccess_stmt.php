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
  
  <?php 
    array_unshift($friendIds, $user_id);
	$friendIds_impl=implode($friendIds, ',');
	$connection = Propel::getConnection();
    //$query = 'SELECT id, f_status_name, created_at from FROM %s where %s  order by %s';
	$query = "SELECT id, user_id, f_status_name, UNIX_TIMESTAMP(created_at) as time_u, date_format(created_at, '%M %e, %Y') as time_FjY FROM updates where user_id IN  ($friendIds_impl) order by created_at desc";
    //$query = sprintf($query, $friendIds);
    $statement = $connection->prepare($query);
    $statement->execute();
    /*$c=new Criteria();
    $c->add(UpdatesPeer::USER_ID, $friendIds, Criteria::IN);
    $c->addDescendingOrderByColumn(UpdatesPeer::CREATED_AT); 
    $updates=UpdatesPeer::doSelect($c);*/
  ?>
  <?php //foreach($updates as $i=>$update):?>
  <?php $i=0?>
  <?php print_r($statement)?>
  <?php while($update=$statement->fetch(PDO::FETCH_OBJ)):?>
   <?php //print_r($update->time_FjY)?>
    <?php $user=sfGuardUserPeer::retrieveByPk($update->user_id); $photo=$user->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
    <div class="user_status">
      <div class="user_status_photo">
        <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img'), 'user/'.$user->getUsername()) ?>
      </div>
	  <div  class="status_text">
	    <?php if(in_array(strtolower(substr($update->f_status_name, -3, 3)), array('png', 'jpg', 'gif'))):?>
          <div  class="status_photos_text">
             <?php echo link_to($user->getUsername(), 'user/'.$user->getUsername())?> <?php echo __('uploaded new photo')?>             
		  </div>
		  <div class="user_uploaded_photo">
		    <?php echo link_to(image_tag('/uploads/assets/photos/thumbnails/'.$update->f_status_name), 'photos/show?id='.$update->id)?>
		  </div>
		  <div class="comment_actions">
	      (<?php echo status_date($update->time_u, $update->time_FjY)?>) 
			<a href="#" class="comment_status"><?php echo __('comment')?></a>
			<?php //if($update->countsfGuardUserStatusComments()>0):?>
            <div id="add_status_comment_<?php echo $i?>" class="add_status_comment">
              <?php include_partial('photo_comment', array('user_id'=>$user_id, 'index'=>$i, 'photo_id'=>$update->id)) ?>  
            </div>
            <div class="status_comment_box">
              <?php echo form_remote_tag(array(
               'url'      => '@add_photo_comment',
               'update'   => array('success' => 'add_status_comment_'.$i),
               'loading'  => "Element.show('indicator')",
			   'complete' => visual_effect('highlight', 'add_status_comment_'.$i),
	            )) ?>
              <?php echo input_hidden_tag('photo_id', $update->id) ?>
			  <?php echo input_hidden_tag('photo_user_id', $update->user_id) ?>
	          <?php echo input_hidden_tag('index', $i) ?>			 
              <?php echo textarea_tag('comment', '', 'size=30x3 class=expand status_box') ?>
              <div class="submit-row">      
                <?php echo submit_tag(__('comment')) ?>
              </div>			  
             </form>
           </div>
	    </div>	
		<?php else :?>	
		  <?php echo link_to($user->getUsername(), 'user/'.$user->getUsername())?>:<?php echo $update->f_status_name?>
		  <div class="comment_actions">
	      (<?php echo status_date($update->time_u, $update->time_FjY)?>) 
			<a href="#" class="comment_status"><?php echo __('comment')?></a>
			<?php //if($update->countsfGuardUserStatusComments()>0):?>
            <div id="add_status_comment_<?php echo $i?>" class="add_status_comment">
              <?php include_partial('status_comment', array('user_id'=>$user_id, 'index'=>$i, 'status_id'=>$update->id)) ?>  
            </div>
            <div class="status_comment_box">
              <?php echo form_remote_tag(array(
               'url'      => '@add_status_comment',
               'update'   => array('success' => 'add_status_comment_'.$i),
			   'before' => visual_effect('highlight', 'add_status_comment_'.$i),
               'loading'  => "Element.show('indicator')",
			   'complete' => visual_effect('highlight', 'add_status_comment_'.$i),
	            )) ?>
              <?php echo input_hidden_tag('status_id', $update->id) ?>
			  <?php echo input_hidden_tag('status_user_id', $update->user_id) ?>
	          <?php echo input_hidden_tag('index', $i) ?>			 
              <?php echo textarea_tag('comment', '', 'size=30x3 class=expand status_box') ?>
              <div class="submit-row">      
                <?php echo submit_tag(__('comment')) ?>
              </div>			  
             </form>
           </div>
	      </div>
		<?php endif;?>	
        
		
	</div>
  </div>
  <?php $i++?>
   <?php endwhile;?>
      <?php // endforeach; ?>
</div><!--updates_left_column-->
