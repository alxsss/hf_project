<?php use_helper('I18N')?>
<div id="navigation">
  <div id="search_box">
    <form action="<?php echo url_for('@friend_search') ?>" method="get">
	  <div class="search-form">
        <input type="text" name="query" value="<?php echo __('Search')?>" id="search-input" class="defaultText cleardefault" title="<?php echo __('Search')?>"/>
        <input class="search-button" type="submit"/>
      </div>
    </form>
  </div>
  <ul id="navlinks">  	
	    <?php if ($sf_user->isAuthenticated()): ?>
		  <li><?php echo link_to(__('updates'), '@updates') ?></li>
		  <li><?php echo link_to(__('photo'), '@photos?sort=created_at&type=desc') ?></li>
		  <li><?php echo link_to(__('video'), '@videos') ?></li>
		  <?php //echo link_to(__('users'), '@all_users') ?>	  
          <?php //put this instead of link_to in order to handle utf-8 chars in url?>
          <li><a href="<?php echo url_for('@user_profile?username='.$sf_user->getUsername())?>" title="<?php echo __('my profile')?>"><?php echo $sf_user->getUsername()?></a>		  </li>
          <li><?php echo link_to(__('sign out'), '@logout') ?></li>
		<?php else: ?>
		  <li><?php echo link_to(__('home'), '@homepage') ?></li>
		  <li><?php echo link_to(__('photos'), '@photos?sort=created_at&type=desc') ?></li>
		  <li><?php echo link_to(__('video'), '@videos') ?></li>
          <li><?php echo link_to(__('sign in'), '@login') ?></li>
		  <li><?php echo link_to(__('members'), '@all_users') ?></li>
        <?php endif ?> 
 <li class="last_nb" ><?php echo link_to(__('forum'), '@forum_home') ?></li>
		<?php //include_component('sfLanguageSwitch', 'get') ?>    
    </ul>
</div>
