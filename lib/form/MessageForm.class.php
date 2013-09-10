<?php

/**
 * Message form.
 *
 * @package    fmpsv
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MessageForm extends BaseMessageForm
{
  public function configure()
  {
    $this->widgetSchema['from_userid'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['to_userid'] = new sfWidgetFormInputHidden();
	/*$this->widgetSchema['from_deltype'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['to_deltype'] = new sfWidgetFormInputHidden();
	$this->widgetSchema['created_at'] = new sfWidgetFormInputHidden();*/
	unset($this['from_deltype']);
	unset($this['to_deltype']);
	unset($this['created_at']);
	$this->widgetSchema['msgtext'] = new sfWidgetFormTextarea(array(), array('cols' => 110, 'rows' =>15, 'class'=>'expand70 message_box_textarea'));
	$this->widgetSchema['subject'] = new sfWidgetFormInput(array(), array('size'=>79));
	$this->validatorSchema['msgtext']->setOption('required', true);	
  }
}
