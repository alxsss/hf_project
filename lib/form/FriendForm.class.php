<?php

/**
 * Friend form.
 *
 * @package    fmpsv
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class FriendForm extends BaseFriendForm
{
  public function configure()
  {
    $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['friend_id'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['approved'] = new sfWidgetFormInputHidden();	
  }
}
