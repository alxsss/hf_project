<?php
//require_once(dirname(__FILE__).'/../../../hemsinif/config/ProjectConfiguration.class.php');
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
sfContext::createInstance($configuration)->dispatch();
