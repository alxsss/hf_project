<?php use_helper('Text',  'I18N', 'Status', 'Date')?>
 <?php foreach($subscriber_updates->getResults() as $i=>$update):?> 
    <?php if($update->getPid()==2):?>	
	  <div class="user_status" style="margin:0px;">
        <div class="status_activity_element">
         <b><?php echo $subscriber?></b>: <?php echo $update->getFStatusName()?> 
 		  <span class="status_date">(<?php echo status_date($update->getCreatedAt('U'), format_date($update->getCreatedAt(), 'p'))?>)</span>
        </div>				
	    <?php if($user_id==$subscriber->getId()):?> 
          <span class="delete_status reply_to_message">
		    <a href="#" status_id="<?php echo $update->getId()?>" action="<?php echo url_for('@delete_status')?>"><?php echo __('Delete')?></a>	    
	      </span>  
        <?php endif;?>
	  </div>
	<?php elseif($update->getPid()==3):?>      
	    <div class="activity_element">
		  <?php if($update->getUserId()==$subscriber->getId()):?>
		    <?php $fuser=sfGuardUserPeer::retrieveByPk($update->getFStatusName())?>
		  <?php elseif($update->getFriendId()==$subscriber->getId()):?>
		    <?php $fuser=sfGuardUserPeer::retrieveByPk($update->getUserId())?>
		  <?php endif;?>
           <?php echo $subscriber?> <?php echo __('and')?>  <?php echo link_to($fuser->getUsername(), 'user/'.$fuser->getUsername())?>
		   <?php echo __('are friends now')?> 
		  
		  <span class="status_date">(<?php echo status_date($update->getCreatedAt('U'), format_date($update->getCreatedAt(), 'p'))?>)</span>
        </div>
 	<?php elseif($update->getPid()==4):?>
	  <?php $p_owner=sfGuardUserPeer::retrieveByPk($update->getPOwnerId())?>
	  <div class="activity_element">         
	    <?php echo $subscriber?> <?php echo __('commented on %photo% by %author%', array('%photo%'=>link_to(__('photo'), 'photos/show?id='.$update->getId()),
		'%author%'=>link_to($p_owner->getUsername(), 'user/'.$p_owner->getUsername())  ))?>
		<span class="status_date">(<?php echo status_date($update->getCreatedAt('U'), format_date($update->getCreatedAt(), 'p'))?>)</span> 	
      </div>	
   <?php endif;?>			
  <?php  endforeach; ?>
  <?php $subscriber_updates->getLinks()//this is done to correctly count getCurrentMaxLink()?>		
  <?php if (($subscriber_updates->haveToPaginate())&&($subscriber_updates->getPage() != $subscriber_updates->getCurrentMaxLink()) ):?>
	<div class="user_updates">
      <?php echo link_to(__('Next'), '@user_updates?id='.$subscriber->getId().'&page='.$subscriber_updates->getNextPage(), 'class=reply_to_message') ?>
	</div>
  <?php endif;?>  
