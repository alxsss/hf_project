<?php
class GetContactsForm extends sfForm
{
  public function configure()
  {  
    $this->setWidgets(array(
      'email'       => new sfWidgetFormInput(array(), array("class" => "email")),
      'password'    => new sfWidgetFormInputPassword(),
		  'provider'    => new sfWidgetFormSelect(array('choices' => self::getProviders())),
			));
    $this->widgetSchema->setLabels(array(
			'email'      => 'Email',
			'password'   => 'Password',
			'provider'   => 'Provider'
		));
   //$this->setDefaults(array('email' => 'Your Email Here'));
   $this->widgetSchema->setFormFormatterName('table'); 
   $this->widgetSchema->setNameFormat('openInviter[%s]');
  $this->setValidators(array(
		    'email'   => new sfValidatorString(
	                     array('required' => true)//, array('required' => 'Email/Username is required')
                   ),
                   'password' => new sfValidatorString( 
                            array('required' => true)//,
                          //  array('required' => 'The password is required')
                     ),
                    'provider' => new sfValidatorChoice(array('choices' => array_keys(self::validateProviders())))
    ));
    
    $this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'checkProviderLogin')))  );
	}
	
		public function getProviders()
		{
			$output    = array();
	    $providers =  $this->getOption('plugins');

			foreach($providers as $type => $val)
	      foreach($val as $key => $value)
	        $output[$type][$key] = $value['name'];
	        
	    return  $output;
		}
		
		
		public function validateProviders()
		{
			$output = array();
			$providers =  $this->getOption('plugins');
	
			foreach($providers as $type => $val)
			  foreach($val as $key => $value)
			    $output[$key] = $value;
			
			return $output;
		}
		
    public function checkProviderLogin($validator, $values)
    {
    	if($values['email'] && $values['password'])
    	{ 
	      $inviter = $this->getOption('inviter');
	      
	      $inviter->startPlugin($values['provider']);
	      $internal = $inviter->getInternalError();

	      if ($internal == 1)        
	        throw new sfValidatorError($validator, 'You have to run the <b>open-inviter:install</b> task');
	      elseif ($internal == 2)        
	        throw new sfValidatorError($validator, 'Your open inviter configuration is missing the message');

       if(!$inviter->checkLoginCredentials($values['email']))
       {
	       throw new sfValidatorError($validator, $inviter->getInternalError());
       }
	     if (!$inviter->login($values['email'],$values['password']))
	        throw new sfValidatorError($validator, 'Login failed. Please check the email and password you have provided and try again later');
	     elseif (false===$contacts=$inviter->getMyContacts())
	        throw new sfValidatorError($validator, 'Unable to get contacts');
	     else
       {
         //everything is okay !
         $this->setOption('results',$contacts);        
       }
       
	      // everything is fine,return the clean values
	      return $values;
    	}
    }
}

?>
