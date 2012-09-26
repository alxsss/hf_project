<?php use_helper('Date', 'Global', 'I18N') ?>
  <div id="loader_bd">
    <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
  </div>
<div id="show_photo">
  <?php $img_url_normal='/uploads/assets/photos/normal/'.$photos->getFilename()?>
  <div id="photo">
    <div class="photo_title"><?php echo $photos->getTitle()?></div>
    <?php echo image_tag($img_url_normal, '')?>
	<div>
     <span class="interested_block"><?php include_partial('photo_rates', array('photos' => $photos)) ?></span>
	<?php echo __('uploaded on')?> <?php echo format_date($photos->getCreatedAt(), 'p') ?>
	<?php $photo_owner_id=$photos->getUserId();?>	
    <?php if($c&&($photo_owner_id==$user_id)):?>
      <?php echo link_to(__('edit photo'), 'photos/edit?id='.$photos->getId());?> 
    <?php endif; ?>
	</div>
    <span class="interested_block"><?php include_partial('favorite', array('photos' => $photos)) ?></span>
	<?php $rated= PhotoRatePeer::retrieveByPK($photos->getId(), $user_id); if($rated){$rate=$rated->getRate(); $read_only=1;}else{$rate=0;$read_only='';}?>
	<div id="photo_rating" read_only="<?php echo $read_only;?>" photo_id="<?php echo $photos->getId()?>" rate="<?php echo $rate;?>"> </div>    	
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
  <?php include_partial('comment', array('user_id'=>$user_id,'photos' => $photos, 'comments' =>$photos->getPhotoCommentsJoinsfGuardUser())) ?> 
   <div class="user_status_comment_new"></div>   
</div>
<?php if ($sf_user->isAuthenticated()): ?>
      <div class="status_comment_box" style="display:block;padding:0 0 50px 10px;">
	    <form action="<?php echo url_for('@add_comment')?>" method="post">
          <input type="hidden" value="<?php echo $photos->getId()?>"  name="item_id">             
          <input type="hidden" value="<?php echo $photos->getUserId()?>"  name="item_user_id">	   
		  <input type="hidden" value="1"  name="page">		 
          <textarea cols="30" rows="3" class="expand24 status_box" id="comment" name="comment" style="height: 24px; overflow: hidden; padding-top: 0px; padding-bottom: 0px;"></textarea>
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
	<script type="text/javascript">
	  jQuery('#photo_rating').raty();
	  jQuery("textarea[class*=expand]").TextAreaExpander(); 
	</script>
