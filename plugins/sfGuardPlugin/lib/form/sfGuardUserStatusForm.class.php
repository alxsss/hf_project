<?php

/**
 * sfGuardUserStatus form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfGuardUserStatusForm extends BasesfGuardUserStatusForm
{
  public function configure()
  {
    $this->widgetSchema['user_id']= new sfWidgetFormInputHidden();
	$this->widgetSchema['status_name'] = new sfWidgetFormTextarea(array(), array('cols' => 20, 'rows' =>1));
    $this->widgetSchema['status_name']->setLabel('What are you up to?');
	unset($this['created_at']);
	
	 $this->validatorSchema['status_name']->setOption('required', true);
  }
}
