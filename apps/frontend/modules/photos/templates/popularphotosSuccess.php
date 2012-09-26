<?php use_helper('I18N', 'Global') ?>
<div id="updates_left_column">
<?php if($sf_user->isAuthenticated()):?> 
 <?php include_component('friends', 'ulinks')?>
<?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
<?php include_partial('friends/ad200x200')?>
</div>
<div id="right_column_user">
  <div class="friends_to_be_invited">
    <h4><?php echo __('Popular photos')?></h4>
	<div class="sort_photos">
   <?php echo __('sort by')?>:
   	  <?php if ($sf_user->getAttribute('sort', null, 'photo/sort') == 'rating'): ?>
      <?php echo link_to(__('rate'), '@popular_photos?sort=rating&type='.($sf_user->getAttribute('type', 'asc', 'photo/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo __($sf_user->getAttribute('type', 'asc', 'photo/sort')) ?>)
      <?php else: ?>
      <?php echo link_to(__('rate'), '@popular_photos?sort=rating&type=asc') ?>
      <?php endif; ?>   
	  |
	  <?php if ($sf_user->getAttribute('sort', null, 'photo/sort') == 'created_at'): ?>
      <?php echo link_to(__('date'), '@popular_photos?sort=created_at&type='.($sf_user->getAttribute('type', 'asc', 'photo/sort') == 'asc' ? 'desc' : 'asc')) ?>
      (<?php echo __($sf_user->getAttribute('type', 'asc', 'photo/sort')) ?>)
      <?php else: ?>
      <?php echo link_to(__('date'), '@popular_photos?sort=created_at&type=asc') ?>
      <?php endif; ?>
</div>	

    <div class="friends_to_be_invited_line"><?php $cnt=0;?>
    <?php foreach ($popular_photos->getResults() as $popular_photo): ?>
      <?php $cnt++;?>
      <div class="user_friend">
        <a href="<?php echo url_for('photos/showpopular?id='.$popular_photo->getId())?>">
            <?php echo image_tag('/uploads/assets/photos/thumbnails/'.$popular_photo->getFilename(), 'alt=no img class=image_with_border')?>
        </a>	
        <?php if($popular_photo->getRating()!=0): ?>
          <div class="popular_photo_title"><?php echo __('rates').'('.$popular_photo->getRating().')'?> </div>
        <?php endif;?>
       </div>	
  
 <?php if($cnt==7){echo '</div><div class="friends_to_be_invited_line">';$cnt=0;}?>	
<?php endforeach; ?>
</div>
 <?php if($popular_photos->haveToPaginate()):?>
<div class="pagination">
  <div id="photos_pager">
    <?php echo pager_navigation($popular_photos, '@popular_photos') ?>
  </div>
</div>
<?php endif;?>
</div>
</div>
<?php include_partial('friends/horizontal_ad')?>
