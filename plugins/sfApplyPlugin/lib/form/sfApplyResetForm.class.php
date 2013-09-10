<?php

class sfApplyResetForm extends sfForm
{
  public function configure()
  {
    $this->setWidget('password', new sfWidgetFormInputPassword(array(), array('maxlength' => 128)));
    $this->setWidget('password2', new sfWidgetFormInputPassword(array(), array('maxlength' => 128)));
	$this->setWidget('password_hint', new sfWidgetFormInput());
    $this->widgetSchema->setLabels(array('password' => 'new password', 'password2' => 'confirm password'));
    $this->widgetSchema->setNameFormat('sfApplyReset[%s]');
	$this->widgetSchema->setFormFormatterName('list');
    $this->setValidator('password', new sfValidatorString(array('required' => true, 'trim' => true, 'min_length' => 6,'max_length' => 128)));
    $this->setValidator('password2', new sfValidatorString(array('required' => true, 'trim' => true, 'min_length' => 6,'max_length' => 128)));
    $this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password2',array(), array('invalid' => 'The passwords did not match.')));
	$this->validatorSchema['password_hint'] = new sfValidatorString(array('required' => false));
  }
}