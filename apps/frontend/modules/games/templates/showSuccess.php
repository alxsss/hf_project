<?php use_helper('I18N', 'Text', 'sfSimpleForum')?>
<div id="play_game">
<?php echo forum_breadcrumb(array(
    array(__('Games'), @games),
        array(__($game->getRawValue()->getGameCategory()->getDisplayName()), 'games/category?id='.$game->getGameCategory()->getId()),
        $game->getName()
  )) ?>
    <?php echo $game->getRawValue()->getEmbedCode();?>
</div>
<div style="text-align:center; padding:20px 0;">
  <script type="text/javascript"><!--
google_ad_client = "pub-0181717197672047";
/* 728x90, created 10/18/10 */
google_ad_slot = "0174420504";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
