<?php use_helper('I18N', 'Text', 'Global', 'sfSimpleForum')?>
<div id="updates_left_column">
  <?php include_component('games', 'gamecategorylinks')?>
</div>
<div id="right_column_user">
  <?php echo forum_breadcrumb(array(array(__('Games'), @games), __($game_cat->getRawValue()->getDisplayName()) )) ?>
  <div class="cat_games">
    <div class="listing-col">
      <?php foreach($games->getResults() as $i=>$game):?>
       <ul class="cat-listings">
          <li>
	    <a href="<?php echo url_for('games/show?id='.$game->getId())?>" >
              <div class="icon-overlay"></div>
              <img width="80" src="<?php echo $game->getThumb()?>" alt="" />
	      <em><?php echo truncate_text($game->getName(), 20)?></em>
	      <div class="game_desc"><?php echo truncate_text(trim($game->getDescription()),60); ?></div>
           </a>
	  </li>
	</ul>
        <?php if($i==9){echo '</div><div class="listing-col">';}?>
      <?php endforeach;?>	
    </div>	        
  </div>
 <?php if($games->haveToPaginate()):?>
    <div class="pagination">
     <div id="photos_pager">
       <?php echo pager_navigation($games, 'games/category?id='.$game_cat->getId()) ?>
     </div>
    </div>
  <?php endif;?>
</div>
<?php include_partial('friends/horizontal_ad')?>
