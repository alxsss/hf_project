<?php use_stylesheet('photos.css') ?>
<div id="jobs">
  <?php include_partial('photos/listsearch', array('photos' => $photos, 'rule' => 'photos/recent')) ?>
</div>