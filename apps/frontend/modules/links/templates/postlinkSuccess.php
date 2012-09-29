 <?php use_helper('I18N', 'Status', 'Date') ?> 
<?php  $photo=$user->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
     <div class="user_status_photo">
               <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'alt=alt=no img class=border_image'), '@user_profile?username='.$user->getUsername()) ?>
             </div>
          <div  class="status_text">
               <div  class="status_photos_text">
             <span class="update_username"><?php echo link_to($user->getUsername(), '@user_profile?username='.$user->getUsername())?></span> <?php echo $post_link_text?>
                  </div>
                  <div class="uploaded_photo">
                    <a href="<?php echo url_for($url)?>">
                      <div class="album_image">
                        <?php echo image_tag('/uploads/assets/links/'.$filename,'class=image_with_border')?>
                      </div>
                    </a>
                  </div>
                  <div class="link_title"><?php echo $title?></div>
                  <div class="link_url"><a href="<?php echo $url?>" target="blank"><?php echo $url?></a></div>
                  <div class="link_description"><?php echo $description?></div>
                  <div class="comment_actions">
                   <div class="updates_action">
                    (<?php echo status_date(time(), format_date(time(), 'p'))?>)
                    <a href="#" class="comment_status"><?php echo __('comment')?></a>
                     <span class="delete_status">
                        <a href="#" id="<?php echo $link->getId()?>"  action="<?php echo url_for('@delete_link')?>"><?php echo __('delete')?></a>
                      </span>
                 </div>
            <div class="add_status_comment">
              <?php //include_partial('photo_comment', array('user_id'=>$user_id, 'photo_id'=>$update->getId())) ?>
                          <div class="user_status_comment_new"></div>
            </div>
            <div class="status_comment_box">
                         <form action="<?php echo url_for('@add_link_comment')?>" method="post">
                           <input type="hidden" value="<?php echo $link->getId()?>"  name="item_id">
               <input type="hidden" value="<?php echo $user_id?>"  name="item_user_id">
                           <input type="hidden" value="1"  name="page">
                           <textarea class="expand24 status_box defaultText cleardefault" id="comment" name="comment" style="height:24px;overflow:hidden;padding:0px;" title="<?php echo __('comment')?>"><?php echo __('comment')?></textarea>
               <div class="submit-row">
                 <input type="submit" value="<?php echo __('comment')?>" class="status_comment_box_form">
               </div>
             </form>
           </div>
            </div>
          </div>
