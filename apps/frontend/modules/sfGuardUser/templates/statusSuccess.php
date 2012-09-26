<?php use_helper('I18N', 'Status', 'Date') ?>
<?php //foreach($statuses as $status):?>  
    <div class="status_activity_element">
       <b><?php echo $user->getUsername()?></b>:  <?php //echo __('is')?> <?php echo $status->getStatusName()?>
       <span class="status_date">(<?php echo status_date($status->getCreatedAt('U'), format_date($status->getCreatedAt(), 'p'))?>)</span>
    </div>
	  <span class="delete_status">
		<a href="#" status_id="<?php echo $status->getId()?>" action="<?php echo url_for('@delete_status')?>"><?php echo __('delete')?></a>	    
	  </span>     
<?php //endforeach; ?> 
