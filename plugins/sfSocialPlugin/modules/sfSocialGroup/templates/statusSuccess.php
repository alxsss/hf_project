<?php use_helper('I18N', 'Status', 'Date') ?>
<?php $photo=$status->getsfSocialGroup()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
    <div class="user_status_photo">
      <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img class=border_image'), '@sf_social_group?id='.$status->getsfSocialGroup()->getId()) ?>
    </div>
	<div  class="status_text">
      <span class="update_username"><?php echo link_to($status->getsfSocialGroup()->getTitle(), '@sf_social_group?id='.$status->getsfSocialGroup()->getId())?></span>:<?php echo $status->getStatus()?>
	  <div class="comment_actions">
	  <div class="updates_action">
	    (<?php echo status_date($status->getCreatedAt('U'), format_date($status->getCreatedAt(), 'p'))?>) 			            
		 <a href="#" class="comment_status"><?php echo __('comment')?></a>
         </div>
         <div class="add_status_comment">
           <?php include_partial('group_status_comment', array('user_id'=>$user_id, 'status_id'=>$status->getId())) ?> 
		    <div class="user_status_comment_new"></div> 
         </div>
		 <div class="status_comment_box">
		   <?php if ($sf_user->isAuthenticated()): ?>
			 <form action="<?php echo url_for('@add_group_status_comment')?>" method="post">
               <input type="hidden" value="<?php echo $status->getId()?>"  name="item_id">             
               <input type="hidden" value="<?php echo $status->getGroupId()?>"  name="item_user_id">       
			   <input type="hidden" value="1"  name="page"> 		 
<textarea name="comment" id="comment" class="expand24 status_box" rows="3" cols="30" style="height: 24px; overflow: hidden; padding-top: 0px; padding-bottom: 0px;"></textarea>              
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
   <span class="delete_status">
		<a href="#" status_id="<?php echo $status->getId()?>" action="<?php echo url_for('@delete_group_status')?>"><?php echo __('Delete')?></a>	    
   </span>  
