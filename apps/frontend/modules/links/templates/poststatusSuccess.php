 <?php use_helper('I18N', 'Status', 'Date') ?> 
<?php  $photo=$user->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
        <div class="user_status_photo">
          <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img class=border_image'), '@user_profile?username='.$user->getUsername()) ?>
        </div>
         <div  class="status_text">
          <span class="update_username"><?php echo link_to($user->getUsername(), '@user_profile?username='.$user->getUsername())?></span>:<?php echo $status_content?>
                  <div class="comment_actions">
                  <div class="updates_action">
                    (<?php echo status_date(time(), format_date(time(), 'p'))?>)
                        <a href="#" class="comment_status"><?php echo __('comment')?></a>
                     <span class="delete_status">
                        <a href="#" user_id="<?php echo $user_id?>" action="<?php echo url_for('@delete_status')?>"><?php echo __('delete')?></a>
                      </span>
               </div>
               <div class="add_status_comment">
                 <div class="user_status_comment_new"></div>
            </div>
            <div class="status_comment_box">
                          <form action="<?php echo url_for('@add_status_comment')?>" method="post">
                <input type="hidden" value="<?php echo $status->getId()?>"  name="item_id">
                <input type="hidden" value="<?php echo $status->getUserId()?>"  name="item_user_id">
                            <input type="hidden" value="<?php echo $page ?>"  name="page">
               <textarea class="expand24 status_box defaultText cleardefault" id="comment" name="comment" style="height: 24px; overflow: hidden; padding:0;"  title="<?php echo __('comment')?>"><?php echo __('comment')?></textarea>
                           <div class="submit-row">
                 <input type="submit" value="<?php echo __('comment')?>" class="status_comment_box_form">
                </div>
             </form>
           </div>
         </div>
       </div>

