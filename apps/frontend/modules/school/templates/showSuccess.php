<?php use_helper('sfSimpleForum') ?>
<?php slot('hemsinif_breadcrumb') ?>
<?php echo forum_breadcrumb(array(
    array('home', @homepage),
	array($school->getVillage()->getRegion()->getName(), 'region/show?id='.$school->getVillage()->getRegion()->getId()),
	$school->getVillage()->getName() 
  )) ?> 
<?php end_slot() ?> 
<?php foreach($schools as $school):?>
  <?php echo link_to($school->getName(), '@register?id='.$school->getId());?>
  <br>
<?php endforeach; ?>