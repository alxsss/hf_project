<?php use_helper('Date', 'Text', 'I18N') ?>
<div id="left_column_user">
  <div class="user_contact">
    <!--in case if a user is not signed in and album is visible $user_id is not defined-->
    <?php if($sf_user->isAuthenticated()&&($album_user_id==$user_id)):?>
      <?php  echo link_to(__('edit album'), 'albums/edit?id='.$album->getId(),'class=user_links') ?>
    <?php  endif;?>	 
    <?php echo link_to($album->getsfGuardUser()->getUsername().__('\'s profile'), 'user/'.$album->getsfGuardUser()->getUsername(), 'class=user_links') ?>
    <?php echo link_to( __('All albums by %author%', array('%author%'=>$album->getsfGuardUser())), '@all_albums?username='.$album->getsfGuardUser(), 'class=user_links')?>
    <?php echo link_to( __('All photos by %author%', array('%author%'=>$album->getsfGuardUser())), '@all_photos?username='.$album->getsfGuardUser(), 'class=user_links')?>
<?php $description=$album->getDescription();?>
<?php  if(!empty($description)):?>
  <div class="user_links"><?php  echo  __('description').': '.truncate_text($description, 100)?></div>
<?php endif;?>
</div> 
  
 <?php if($sf_user->isAuthenticated()):?> 
   <?php include_component('friends', 'ulinks')?>  
 <?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
 <?php endif;?>
 <?php include_partial('friends/ad200x200')?>

</div>
<div id="right_column_user">

<?php $v=$album->getVisibility();?>
<?php if(!empty($firstPhoto)):?>
  <?php //if(($c==0&&$v==0)||($c==1&&$v==0)||($c==1&&$v==1&&(in_array($user_id,$friendIds)||($user_id===$album_user_id)))):?>
  <?php if(($v==0)||($sf_user->isAuthenticated()&&$v==1&&($album_owner->isFriend($user_id)||($user_id==$album_user_id)))):?>
    <div id="wrap">
      <div id="mycarousel" class="jcarousel-skin-tango">
        <div class="jcarousel-prev jcarousel-prev-horizontal jcarousel-prev-disabled jcarousel-prev-disabled-horizontal" style="display: block;" disabled="true"></div>
        <div class="jcarousel-next jcarousel-next-horizontal jcarousel-next-disabled jcarousel-next-disabled-horizontal" style="display: block;" disabled="true"></div>
        <div class="jcarousel-clip jcarousel-clip-horizontal">
          <ul class="jcarousel-list jcarousel-list-horizontal" style="width: 497px; left: 0px;">
            <?php foreach ($album->getPhotos() as $i=>$photo): ?>
              <?php $pic_url='/uploads/assets/photos/thumbnails/'.$photo->getFilename();?>
              <li class="jcarousel-item jcarousel-item-horizontal jcarousel-item-<?php echo $i+1?> jcarousel-item-<?php echo $i+1?>-horizontal" jcarouselindex="<?php echo $i+1?>">
                <a href="#">
                  <img alt="" photo_id="<?php echo $photo->getId()?>" src="<?php echo $pic_url?>" width="56" height="56"/>
                </a>	         
	          </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  <div id="photospot">
    <div id="loader_bd">
      <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
    </div>
    <div id="show_photo">     
      <?php $img_url_normal='/uploads/assets/photos/normal/'.$firstPhoto->getFilename()?>
       <?php //$photo_owner_id=$firstPhoto->getAlbum()->getUserId();?>
      <div id="photo">
	    <div class="photo_title"><?php echo $firstPhoto->getTitle()?></div>
        <?php echo image_tag($img_url_normal, '')?>
	    <div>
         <span class="interested_block"><?php include_partial('photos/photo_rates', array('photos' => $firstPhoto)) ?></span>
        <?php echo __('uploaded on')?> <?php echo format_date($firstPhoto->getCreatedAt(), 'p') ?>
        <?php if($sf_user->isAuthenticated()&&($album_user_id==$user_id)):?>
	      <?php echo link_to(__('edit photo'), 'photos/edit?id='.$firstPhoto->getId());?> 
        <?php  endif;?> 
        <span class="interested_block"><?php include_partial('photos/favorite', array('photos' =>$firstPhoto)) ?></span>
		</div>
		<?php $rated= PhotoRatePeer::retrieveByPK($firstPhoto->getId(), $user_id); if($rated){$rate=$rated->getRate(); $read_only=1;}else{$rate=0;$read_only='';}?>
		 <div id="photo_rating" read_only="<?php echo $read_only;?>" photo_id="<?php echo $firstPhoto->getId()?>" rate="<?php echo $rate;?>"> </div>
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
      <?php include_partial('photos/comment', array('user_id'=>$user_id,'photos' => $firstPhoto, 'comments' =>$firstPhoto->getPhotoComments())) ?> 
	   <div class="user_status_comment_new"></div>   
   </div> 
    <?php if ($sf_user->isAuthenticated()): ?>
      <div class="status_comment_box" style="display:block;padding:0 0 50px 10px;">
	    <form action="<?php echo url_for('@add_comment')?>" method="post">
          <input type="hidden" value="<?php echo $firstPhoto->getId()?>"  name="item_id">             
          <input type="hidden" value="<?php echo $firstPhoto->getUserId()?>"  name="item_user_id">	   
		  <input type="hidden" value="1"  name="page">		          
		  <textarea cols="30" rows="3" class="expand24 status_box" id="comment" name="comment"></textarea>
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
	
 </div> 
  <?php else:?>
     <?php echo __('This album is set to private')?>
  <?php endif; //end of if($v=0?>
<?php else:?>
  <?php echo __('No photos in this album')?>
<?php endif; //end of if($firstPhoto?>
</div><!--end of right column-->
<?php include_partial('friends/horizontal_ad')?>
