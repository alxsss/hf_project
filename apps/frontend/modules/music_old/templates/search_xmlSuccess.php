<?php use_helper('Date', 'Javascript', 'Form') ?>

<ul>
<?php print_r($feed); //exit;?>
  <?php foreach($feed->result as $result): ?>
  <li>
    <?php echo $result->clickurl() ?>
	
  </li>
  <?php endforeach; ?>
</ul>