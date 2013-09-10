<?php
//added by A. Kingson for invite friend module in Sep 2009.
class sfApplyInviteFriendForm  extends sfForm
{
  public function configure()
  {
    $this->setWidget('recepient_email',  new sfWidgetFormTextarea(array(), array('cols' => 30, 'rows' =>2, 'class'=>'status_box')));
    $this->setWidget('personal_message',  new sfWidgetFormTextarea(array(), array('cols' => 30, 'rows' =>5, 'class'=>'status_box')));
	$this->widgetSchema['recepient_email']->setLabel('To');
	$this->widgetSchema->setHelp('recepient_email','(separate emails by commas)');
	$this->widgetSchema->setHelp('personal_message', '(optional)');
  
    $this->widgetSchema->setNameFormat('sfApplyInviteFriend[%s]');
    $this->widgetSchema->setFormFormatterName('list');  
	
	$this->setValidators(array('recepient_email' => new sfValidatorString(array('required' => true)),));
	$this->validatorSchema->setOption('allow_extra_fields', true);    
    // add a post validator
    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'validateEmails'))));   
 }
 public function validateEmails($validator, $values)
 {
   if(isset($values['recepient_email']))
   {
     $recepients=explode(',', $values['recepient_email']);
	 foreach($recepients as $email)
	 {
	   if (!preg_match('/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i', trim($email)))
       {
         $error = new sfValidatorError($validator, 'One or more emails are invalid');
		 throw new sfValidatorErrorSchema($validator,  array('recepient_email' => $error));
       } 
	 }     
   }
   return $values;
 }
}