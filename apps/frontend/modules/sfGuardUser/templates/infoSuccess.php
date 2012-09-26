<?php use_helper('Text', 'I18N') ?>
<?php include_partial('sfGuardUser/profile_links', array('subscriber' => $subscriber, 'inbox_num_msgs' => $inbox_num_msgs, 'num_guests'=>$num_guests, 'num_rates'=>$num_rates,
'num_friendsRequests'=>$num_friendsRequests, 'user_id'=>$user_id)) ?>

<div id="right_column_user">
  <div id="updates_profile_right_column">
   <?php if(($subscriber->getProfile()->getVisibility())&&!(($subscriber->isFriend($user_id))||($user_id==$subscriber->getId()))):?>
   <div class="private_profile">
   <?php echo __('This profile is set to private')?>
   </div>
 <?php else:?>
  <div class="ifp_nav">
    <ul>
	  <li class="selected"><?php echo link_to(__('Info'), 'info/'.$subscriber) ?></li>
	  <li><?php echo link_to(__('Friends'), 'friend/'.$subscriber) ?></li>
	  <li class="last_nb"><?php echo link_to(__('Photos'), 'photo/'.$subscriber) ?></li>
	</ul>
  </div>
   
 <div class="profile_section">
    <span class="recent_activity"><?php echo __('Information')?></span>
	  <div class="activity_element">
       <?php echo __($subscriber->getProfile()->getSex())?>, 
       <?php echo intval ((time()-$subscriber->getProfile()->getBirthday('U'))/(24*365*3600))?> <?php echo __('years old')?>
	 </div>
	  <div class="activity_element">
       <?php echo $subscriber->getProfile()->getCity()?>
       <?php echo $subscriber->getProfile()->getState()?>
	   <?php $country=$subscriber->getProfile()->getCountry()?>
	   <?php $status=$subscriber->getProfile()->getMaritalStatus()?>
	   <?php if(!empty($country)):?> 
         <?php echo $country->getIsoCode3()?>  
       <?php endif;?> 
	   <br><br>
	   <?php if(!empty($status)):?> 
         <?php echo __('Marital Status').': '.__($status)?>  
       <?php endif;?> 
	 </div> 
  </div>
  <div class="profile_section">
    <span class="recent_activity"><?php echo __('Interests')?></span>
	<?php $lookingfor=$subscriber->getProfile()->getLookingfor()?>
	<?php $website=$subscriber->getProfile()->getWebsite()?>
	<?php $activities=$subscriber->getProfile()->getActivities()?>
	<?php $books=$subscriber->getProfile()->getBooks()?>	
	<?php $music=$subscriber->getProfile()->getMusic()?>
	<?php $movies=$subscriber->getProfile()->getMovies()?>
	<?php $tvshows=$subscriber->getProfile()->getTvshows()?>
	<?php $aboutme=$subscriber->getProfile()->getAboutme()?>
  	<table class="activity_element" cellpadding="3" cellspacing="4" bordercolor="#000000" border="0">
      <?php if(!empty($lookingfor)):?>
	    <tr><td><?php echo __('Looking for')?></td><td><?php echo $subscriber->getProfile()->getLookingfor()?></td></tr>
      <?php endif;?>
	  <?php if(!empty($website)):?>
	    <tr><td><?php echo __('Website')?></td><td><?php echo $website?></td></tr>
      <?php endif;?>
	  <?php if(!empty($activities)):?>
	    <tr><td><?php echo __('Activities')?></td><td><?php echo $activities?></td></tr>
      <?php endif;?>
	  <?php if(!empty($books)):?>
	    <tr><td><?php echo __('Books')?></td><td><?php echo $books?></td></tr>
      <?php endif;?>
      <?php if(!empty($music)):?>
	    <tr><td><?php echo __('Music')?></td><td><?php echo $music?></td></tr>
      <?php endif;?>
	   <?php if(!empty($movies)):?>
	    <tr><td><?php echo __('Movies')?></td><td><?php echo $movies?></td></tr>
      <?php endif;?>
      <?php if(!empty($tvshows)):?>
	    <tr><td><?php echo __('TV shows')?></td><td><?php echo $tvshows?></td></tr>
      <?php endif;?>
      <?php if(!empty( $aboutme)):?>
	   <tr><td><?php echo __('About Me')?></td><td><?php echo  $aboutme?></td></tr>
      <?php endif;?>	 
	</table>   
  </div>
  <div class="profile_section" style="border:none;">
    <span class="recent_activity"><?php echo __('Schools')?></span>
    <?php foreach($schoolUsers as $schoolUser):?>
	  <div class="activity_element">
        <?php echo $schoolUser->getSchool()->getVillage()->getRegion()->getName();?>,
        <?php echo $schoolUser->getSchool()->getVillage()->getName();?>, 
        <?php echo $schoolUser->getSchool()->getName();?>, 
	    <?php echo $schoolUser->getGradYear();?>	
	  </div>
    <?php endforeach?>
  </div> 
 </div><!--updates_status_right_column-->
  <div class="right_ad_boxes">
  <script type="text/javascript"><!--
      google_ad_client = "pub-0181717197672047";
      /* 120x600, created 10/7/10 */
      google_ad_slot = "5283049147";
      google_ad_width = 120;
      google_ad_height = 600;
      //-->
    </script>
    <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
 </div>
 <?php endif;?>
</div><!--right_column-->