<?php

/**
 * sfApply actions.
 *
 * @package    5seven5
 * @subpackage sfApply
 * @author     Tom Boutell, tom@punkave.com
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class BasesfApplyActions extends sfActions
{
  public function executeApply1(sfRequest $request)
  {
    $this->form = $this->newForm('sfApplyApplyForm');
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('sfApplyApply'));
      if ($this->form->isValid())
      {
        $guid = "n" . self::createGuid();
        $this->form->setValidate($guid);
        $this->form->save();
        try
        {
          // Create the mailer and message objects
          $mailer = $this->getMailer();
          $message = new Swift_Message(
            sfConfig::get('app_sfApplyPlugin_apply_subject',
              "Please verify your account on " . $request->getHost()));
         
          // Render message parts
          $profile = $this->form->getObject();
          $mailContext = array('name' => $profile->getFullname(),
            'validate' => $profile->getValidate());
          $message->attach(new Swift_Message_Part($this->getPartial('sfApply/sendValidateNew', $mailContext), 'text/html'));
          $message->attach(new Swift_Message_Part($this->getPartial('sfApply/sendValidateNewText', $mailContext), 'text/plain'));
          $address = $this->getFromAddress();
          $mailer->send($message, $profile->getEmail(), $address);
          $mailer->disconnect();
          return 'After';
        }
        catch (Exception $e)
        {
          $mailer->disconnect();
          $profile = $this->form->getObject();
          $user = $profile->getUser();
          $user->delete();
          // You could re-throw $e here if you want to 
          // make it available for debugging purposes
          return 'MailerError';
        }
      }
    }
  }
  
  public function executeResetRequest(sfRequest $request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      $guardUser = $this->getUser()->getGuardUser();
      $this->forward404Unless($guardUser);
	  $this->getUser()->setAttribute('Reset',$guardUser->getId(), 'sfApplyPlugin');
      return $this->redirect('sfApply/reset');
      //return $this->resetRequestBody($guardUser);
    }
    else
    {
      $this->form = $this->newForm('sfApplyResetRequestForm');
      if ($request->isMethod('post'))
      {
        $this->form->bind($request->getParameter('sfApplyResetRequest'));
        if ($this->form->isValid())
        {
          $user = sfGuardUserPeer::retrieveByUsername($this->form->getValue('username'));
          return $this->resetRequestBody($user);
        }
      }
    }
  }

  public function resetRequestBody($user)
  {
    $this->forward404Unless($user);
    $user_email=$user->getEmail();
	$profile = $user->getProfile();
	if(!empty($user_email))
	{    
	  $guid = self::createGuid();
      $profile->setValidate('r' . $guid);
      $profile->save();
      // Create the mailer and message objects
	  $urlvalidate='http://hemsinif.com/confirm/r'.$guid;
      $mail = $this->getMailer();
	  $mail->setBodyText(<<<EOF
      Biz sizin hemsinif.com da parolunuzu dəyişmək üçün tələbinizi
      aldıq. Bunu etmək üçün siz bu linkə
	
      $urlvalidate

      gedin və yeni parolunuzu daxil edin.

      SİZ BU TƏLƏBİ GÖNDƏRMƏMİZİNİZ: nərahat olmayın, 
      yuxarıdakı linkə gedib parolunuzu dəyişməyincə,
      sizin parol dəyişməyəcək.    
EOF
);
      $mail->setFrom('info@hemsinif.com', 'hemsinif robotu');
      $mail->addTo($user->getEmail());
      $mail->setSubject('hemsinif.com profilinizə dəyişiklik');
      $mail->send();
	  
    return 'After';
	}
	else
	{
	  $this->hint=$user->getPasswordHint();
	  return 'Hint';
	}
  }
 
  public function executeReset(sfRequest $request)
  {
    $this->form = $this->newForm('sfApplyResetForm');
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('sfApplyReset'));
	  
      if ($this->form->isValid())
      {
        $this->id = $this->getUser()->getAttribute('Reset', false, 'sfApplyPlugin', false);
        $this->forward404Unless($this->id);
		$this->sfGuardUser = sfGuardUserPeer::retrieveByPk($this->id);
        $this->forward404Unless($this->sfGuardUser);
        $sfGuardUser = $this->sfGuardUser;
        $sfGuardUser->setPassword($this->form->getValue('password'));
		$password_hint=$this->form->getValue('password_hint');
		if(!empty($password_hint))
		{
		  $sfGuardUser->setPasswordHint($password_hint);
		}
        $sfGuardUser->save();
        $this->getUser()->signIn($sfGuardUser);
        $this->getUser()->setAttribute('Reset', null, 'sfApplyPlugin');
        return 'After';
      }
    }
  }
 public function executeConfirm(sfRequest $request)
  {
    $validate = $this->request->getParameter('validate');
    $c = new Criteria();
    // 0.6.3: oops, this was in sfGuardUserProfilePeer in my application
    // and therefore never got shipped with the plugin until I built
    // a second site and spotted it!
    $c->add(sfGuardUserProfilePeer::VALIDATE, $validate);
    $c->addJoin(sfGuardUserPeer::ID, sfGuardUserProfilePeer::USER_ID);
    $sfGuardUser = sfGuardUserPeer::doSelectOne($c);
    if (!$sfGuardUser)
    {
      return 'Invalid';
    }
    $type = self::getValidationType($validate);
    if (!strlen($validate))
    {
      return 'Invalid';
    }
    $profile = $sfGuardUser->getProfile();
    $profile->setValidate(null);
    $profile->save();
    if ($type == 'New')
    {
      $sfGuardUser->setIsActive(true);  
      $sfGuardUser->save();
      $this->getUser()->signIn($sfGuardUser);
    }
    if ($type == 'Reset')
    {
      $this->getUser()->setAttribute('Reset',$sfGuardUser->getId(), 'sfApplyPlugin');
      return $this->redirect('sfApply/reset');
    }
  }

  public function executeResetCancel()
  {
    $this->getUser()->setAttribute(
      'Reset', null, 'sfApplyPlugin');
    return $this->redirect('@homepage'); 
  }

  public function executeSettings(sfRequest $request)
  {
    // sfApplySettingsForm inherits from sfApplyApplyForm, which
    // inherits from sfGuardUserProfile. That minimizes the amount
    // of duplication of effort. If you want, you can use a different
    // form class. I suggest inheriting from sfApplySettingsForm and
    // making further changes after calling parent::configure() from
    // your own configure() method. 

    $profile = $this->getUser()->getProfile();
    $this->form = $this->newForm('sfApplySettingsForm', $profile);
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('sfApplySettings'));
      if ($this->form->isValid())
      {
        $this->form->save();
        return $this->redirect('@homepage');
      }
    }
  }
  protected function getFromAddress()
  {
    $from = sfConfig::get('app_sfApplyPlugin_from', false);
    if (!$from)
    {
      throw new Exception('app_sfApplyPlugin_from is not set');
    }
    $address = new Swift_Address($from['email'], $from['fullname']);
    return $address;
  }
  static private function createGuid()
  {
    $guid = "";
    for ($i = 0; ($i < 8); $i++) {
    $guid .= sprintf("%02x", mt_rand(0, 255));
    }
    return $guid;
  }
  
  static private function getValidationType($validate)
  {
    $t = substr($validate, 0, 1);  
    if ($t == 'n')
    {
      return 'New';
    } 
    elseif ($t == 'r')
    {
      return 'Reset';
    }
    else
    {
      return sfView::NONE;
    }
  }

  // There's a lot here. Symfony could benefit from a standard convenience
  // class with a method like this one.
  protected function getMailer()
  {
    ProjectConfiguration::registerZend();
    $tr = new Zend_Mail_Transport_Sendmail('-finfo@hemsinif.com');
    Zend_Mail::setDefaultTransport($tr);
    $mail = new Zend_Mail('utf-8');
    return $mail;
  }

  // A convenience method to instantiate a form of the
  // specified class... unless the user has specified a
  // replacement class in app.yml. Sweet, no?
  protected function newForm($className, $object = null)
  {
    $key = "app_sfApplyPlugin_$className" . "_class";
    $class = sfConfig::get($key,
      $className);
    if ($object !== null)
    {
      return new $class($object);
    }
    return new $class;
  }
}
