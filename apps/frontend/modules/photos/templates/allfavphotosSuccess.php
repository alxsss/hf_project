<?php use_helper('I18N', 'Global') ?>
<div id="updates_left_column">
<?php if($sf_user->isAuthenticated()):?> 
 <?php include_component('friends', 'ulinks')?>
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
</div>
<div id="right_column_user">
  <div class="friends_to_be_invited">
    <h4><?php echo __('%subscribers%\'s favorite photos', array('%subscribers%'=>$subscriber))?></h4>
    <div class="friends_to_be_invited_line"><?php $cnt=0;?>
    <?php foreach ($photos_pager->getResults() as $popular_photo): ?>
      <?php $cnt++;?>
      <div class="user_friend">
        <a href="<?php echo url_for('photos/show?id='.$popular_photo->getId())?>">
            <?php echo image_tag('/uploads/assets/photos/thumbnails/'.$popular_photo->getFilename(), 'alt=no img class=image_with_border')?>
        </a>	
        <?php if($popular_photo->getRating()!=0): ?>
          <div class="popular_photo_title"><?php echo __('rates').'('.$popular_photo->getRating().')'?> </div>
        <?php endif;?>
        <?php if($sf_user->isAuthenticated()&&($user_id==$subscriber->getId())):?>
          <div class="object_del"><a href="<?php echo url_for('@delete_fav_photo?id='.$popular_photo->getId())?>"  title="<?php echo __('Delete')?>" >[x]</a></div>
        <?php endif;?>
       </div>	
  
 <?php if($cnt==7){echo '</div><div class="friends_to_be_invited_line">';$cnt=0;}?>	
<?php endforeach; ?>
</div>
 <?php if($photos_pager->haveToPaginate()):?>
<div class="pagination">
  <div id="photos_pager">
    <?php echo pager_navigation($photos_pager, '@all_favphotos?username='.$subscriber->getUsername()) ?>
  </div>
</div>
<?php endif;?>
</div>
</div>
<?php include_partial('friends/horizontal_ad')?>
