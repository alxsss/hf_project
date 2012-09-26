<div class="user_contact">
  <a href="<?php echo url_for('@upload')?>" class="user_links <?php if($sf_params->get('action')=='upload'){echo 'selected_link';}?>"><?php echo  __('upload a photo')?></a> 
  <a href="<?php echo url_for('school/list')?>" class="user_links <?php if($sf_params->get('module')=='school'||$sf_params->get('module')=='region'||$sf_params->get('module')=='village'||$sf_params->get('module')=='sfGuardAuth'){echo 'selected_link';}?>"><?php  echo __('add your school')?></a>
  <a href="<?php echo url_for('profile/'.$subscriber->getSalt())?>" class="user_links  <?php if($sf_params->get('module')=='profile'){echo 'selected_link';}?>"><?php echo  __('edit profile')?></a>
  <a href="<?php echo url_for('@invitefriend')?>" class="user_links <?php if($sf_params->get('action')=='invitefriend'){echo 'selected_link';}?>"><?php echo __('invite friends') ?></a>
  <a href="<?php echo url_for('@user_inbox')?>"  class="user_links <?php if($sf_params->get('module')=='message'){echo 'selected_link';}?>"> <?php echo  __('messages').($inbox_num_msgs?'(<span class="ulinks_color">'.$inbox_num_msgs.'</span>)':'')?></a>       
  <a href="<?php echo url_for('friends/list')?>" class="user_links <?php if($sf_params->get('module')=='friends'&&$sf_params->get('action')=='list'){echo 'selected_link';}?>"> <?php echo __('suggestions').($num_requests?'(<span class="ulinks_color">'.$num_requests.'</span>)':'')?></a>
  <a href="<?php echo url_for('@guest')?>"   class="user_links <?php if($sf_params->get('module')=='friends'&&$sf_params->get('action')=='guest'){echo 'selected_link';}?>"><?php echo __('guests').($num_guests?'(<span class="ulinks_color">'.$num_guests.'</span>)':'')?></a>
 <a href="<?php echo url_for('@ratings')?>"  class="user_links <?php if($sf_params->get('module')=='photos'&&$sf_params->get('action')=='ratings'){echo 'selected_link';}?>"><?php echo __('rates').($num_rates?'(<span class="ulinks_color">'.$num_rates.'</span>)':'')?></a>
</div>
