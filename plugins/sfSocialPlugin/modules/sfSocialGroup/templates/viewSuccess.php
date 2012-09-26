<?php use_helper('I18N', 'Status',  'Date', 'Global') ?>
<?php /* escaping strategy safety */ $_user = $user;// instanceof sfGuardUser ? $user : $user->getRawValue() ?>
<div id="left_column_user">
  <?php //if($sf_user->isAuthenticated()):?> 
    <?php include_component('sfSocialGroup', 'glinks')?>
  <?php //else:?>
  <?php //include_partial('home/inhemsinif')?>	    
<?php //endif;?>   
</div>
<div id="right_column_user">
   <?php include_partial('sidebar/signin')?>
  <?php if(($group->getVisibility())&&!($group->isMember($user_id)) ):?>
    <div class="private_profile">
      <?php echo __('This group is set to private')?>
     </div>
    <?php include_partial('friends/horizontal_ad')?>
  <?php else:?>
    <div id="updates_status_right_column">
      <div class="group_title_description">
        <h3><?php echo __('Group &quot;%1%&quot;', array('%1%' => $group->getTitle())) ?></h3>
        <?php if ($sf_user->hasFlash('notice')): ?>
          <div class="notice">
            <?php if ($sf_user->hasFlash('nr')): ?>
              <?php echo __($sf_user->getFlash('notice'), array('%1%' => $sf_user->getFlash('nr'))) ?>
            <?php else: ?>
              <?php echo __($sf_user->getFlash('notice')) ?>
            <?php endif ?>
          </div>
        <?php endif; ?>
        <div id="group_body">
         <?php echo $group->getDescription() ?>
        </div>
      </div>
      <?php if($group->isAdmin($user_id)):?>
        <div id="status_box">
	      <form id="user_status_form" action="<?php echo url_for('@group_status?id='.$group->getId())?>" method="post">
	        <input type="text" id="user_status_box" name="user_status_box" class="defaultText cleardefault" title="<?php echo __('What do you think?')?>" size="50"  value="<?php echo __('What do you think?')?>">
	        <span class="submit-row">
	          <input type="submit" value="<?php echo __('Submit')?>" id="user_status_button">
	        </span>
	      </form>
        </div>
      <?php endif;?>
      <div class="group_comments">
        <div class="user_status_element_new"></div>
        <?php foreach($group_status_pager->getResults() as $status):?>
          <?php $photo=$status->getsfSocialGroup()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
          <div class="user_status">
            <div class="user_status_photo">
              <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img class=border_image'), '@sf_social_group?id='.$status->getsfSocialGroup()->getId()) ?>
            </div>
        	<div  class="status_text">
              <span class="update_username"><?php echo link_to($group->getTitle(), '@sf_social_group?id='.$status->getsfSocialGroup()->getId()) ?></span>:<?php echo $status->getStatus()?>
	          <div class="comment_actions">
                <div class="updates_action">
	              (<?php echo status_date($status->getCreatedAt('U'), format_date($status->getCreatedAt(), 'p'))?>) 			            
		          <a href="#" class="comment_status"><?php echo __('comment')?></a>
                </div>
                <div class="add_status_comment">
                  <?php include_partial('group_status_comment', array('user_id'=>$user_id, 'status_id'=>$status->getId())) ?> 
		          <div class="user_status_comment_new"></div> 
                </div>
            <div class="status_comment_box" style="display:block;">
		          <?php if ($sf_user->isAuthenticated()): ?>
			        <form action="<?php echo url_for('@add_group_status_comment')?>" method="post">
                      <input type="hidden" value="<?php echo $status->getId()?>"  name="item_id">             
                      <input type="hidden" value="<?php echo $status->getGroupId()?>"  name="item_user_id">       
			          <input type="hidden" value="1"  name="page"> 		 
			          <textarea class="expand24 status_box defaultText cleardefault" id="comment" name="comment" style="height:24px;overflow:hidden;padding:0px;" title="<?php echo __('comment')?>"><?php echo __('comment')?></textarea>     
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
	        <?php if($group->isAdmin($user_id)):?>
              <span class="delete_status">
	            <a href="#" status_id="<?php echo $status->getId()?>" action="<?php echo url_for('@delete_group_status')?>"><?php echo __('Delete')?></a>	    
              </span>
	        <?php endif;?> 
         </div> 
     <?php endforeach;?>  
  </div>
  <?php if($group_status_pager->haveToPaginate()):?>
    <div class="pagination">
      <div id="photos_pager">
        <?php echo pager_navigation($group_status_pager, '@sf_social_group?id='.$group->getId()) ?>
      </div>
    </div>
  <?php endif;?>
</div>
<div id="friend_suggestions">
  <?php include_partial('friends/ad200x200')?>
</div>
<?php endif;//visibility?>
</div>
