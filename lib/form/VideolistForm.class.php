<?php

/**
 * Videolist form.
 *
 * @package    fmpsv
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class VideolistForm extends BaseVideolistForm
{
  public function configure()
  {
     $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();
     unset($this['created_at']);
     $this->widgetSchema['name']->setLabel('title');
  }
}
