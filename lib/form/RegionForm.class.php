<?php

/**
 * Region form.
 *
 * @package    hemsinif
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class RegionForm extends BaseRegionForm
{
  public function configure()
  {
    $this->widgetSchema['country_id'] = new sfWidgetFormInputHidden();
  }
}
