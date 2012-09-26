<?php use_helper('I18N') ?>
<div class="search">
  <form action="<?php echo url_for('@video_search_ajax') ?>" method="post" id="video_search_form">
    <input type="text" name="query" value="<?php echo __('enter video title'); ?>" id="search_keywords"   class="defaultText cleardefault" title="<?php echo __('enter video title')?>" size="55" />
    <input id="search_button" type="submit" value="<?php echo __('search')?>" />
    <img id="loader" src="/images/loader.gif" style="vertical-align:  middle; padding: 0 10px 10px 10px;display: none;" />
  </form>
</div>
<?php include_partial('sidebar/signin')?>
