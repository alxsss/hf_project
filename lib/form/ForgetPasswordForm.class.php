<?php

/**
 * Advertise form.
 *
 * @package    fmpsv
 * @subpackage form
 * @author     Alexander Kingson
 */
class ForgetPasswordForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'email'   => new sfWidgetFormInput(),
    ));
	
	$this->setValidators(array(
      'email'   => new sfValidatorEmail(),
    ));
  $this->widgetSchema->setNameFormat('forgetPassword[%s]');

  }
}
