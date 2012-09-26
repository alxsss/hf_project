<?php
require_once(sfConfig::get('sf_plugins_dir').'/sfGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');
/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 9999 2008-06-29 21:24:44Z fabien $
 */
class sfGuardAuthActions extends BasesfGuardAuthActions
{
  public function executeRegister(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
      if($request->getParameter('id'))
      {  
        $class ='SchoolUserForm';
        $this->form = new $class();
        $this->school_id=$request->getParameter('id');
        $this->school = SchoolPeer::retrieveByPk($request->getParameter('id'));	
        $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
    	$this->form->setDefaults(array('school_id'=>$this->school_id, 'user_id'=>$this->user_id));
 	if ($request->isMethod('post'))
        {
	  $c=new Criteria();
          $c->add(SchoolUserPeer::SCHOOL_ID, $this->school_id);
          $c->add(SchoolUserPeer::USER_ID, $this->user_id);
          $schoolUser=SchoolUserPeer::doSelectOne($c);
          if(empty($schoolUser))
          {
            $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
            if ($this->form->isValid())
            {
	      $this->form->save();
	      $this->user = sfGuardUserPeer::retrieveByPk($this->user_id);
	      $this->redirect('user/'.$this->user->getUsername());		     
	    }
	    else
	    {
	      $this->setTemplate('register');
	    }
	  }
	  else
	  {
	    $this->user = sfGuardUserPeer::retrieveByPk($this->user_id);
	    $this->redirect('user/'.$this->user->getUsername());
	  }
	}	    
       }
       else
       {
         $this->redirect('@homepage');
       }
      }
      else
      {
        $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'RegisterForm');
        $this->form = new $class();
	$this->school_id=$request->getParameter('id');
	$this->school = SchoolPeer::retrieveByPk($request->getParameter('id'));
	$this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
	if($this->school_id)
	{
	  $this->form->setDefaults(array('is_active'=>1, 'school_id'=>$this->school_id));
	}
	else
	{
          $this->form->setDefaults(array('is_active'=>1));
	}
	//end of reCaptcha	  	
	if ($request->isMethod('post'))
        {
	  $this->processForm($request, $this->form);
	  if($request->getParameter('sf_guard_user[school_id]'))
	  {
	    $schoolUser=new SchoolUser();
	    $schoolUser->setUserId($this->form->getSchoolUser()->getUserId());
	    $schoolUser->setSchoolId($this->form->getValue('school_id'));
	    $schoolUser->setGradYear($this->form->getValue('grad_year'));
	    $schoolUser->save();
	  }
	}
      }
  }
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->sf_guard_user = $this->form->getObject();
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');
      $sf_guard_user = $form->save();
	  $sf_guard_user->updateLuceneIndex();	
  	  $sf_guard_user_username=$sf_guard_user->getUsername();
	  $sf_guard_user_password=$form->getValue('password');

	  //save guid in profile
	  //$guid = self::createGuid();
	  //$profile = $sf_guard_user->getProfile();
      //$profile->setValidate("n".$guid);
	  //$profile->save();
	  //define variables here, since in the EOF they are not defined
	  //create friend of admin as this user
	  $friend=new Friend();
	  $friend->setUserId(1);
	  $friend->setFriendId($sf_guard_user->getId());
	  $friend->setApproved(1);
	  $friend->save();
	        
	  // send an email to the user
	  //$urlvalidate='http://hemsinif.com/confirm/n'.$guid;
	  $user_email=$sf_guard_user->getEmail();
	  if(!empty($user_email))
	  {
	    ProjectConfiguration::registerZend();
         $tr = new Zend_Mail_Transport_Sendmail('-finfo@hemsinif.com');
         Zend_Mail::setDefaultTransport($tr);
        $mail = new Zend_Mail('utf-8');
        $mail->setBodyText(<<<EOF
        hemsinif.com da profil açdirdiginiza görə sag olun.
	Sizin istifadəçi adınız : $sf_guard_user_username
	              parolunuz : $sf_guard_user_password
					   
        hemsinif robotu.
EOF
);
        $mail->setFrom('info@hemsinif.com', 'hemsinif.com robotu');
        $mail->addTo($user_email);
        $mail->setSubject('hemsinif.com da profil açdırdıgınıza görə sag olun');
        $mail->send();	 
	  }
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $sf_guard_user)));
      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');
        $this->redirect('@sf_guard_user_new');
      }
      else
      {
        //$this->redirect('@sf_guard_user_edit?id='.$sf_guard_user->getId());
		//$this->redirect('@homepage');
		$this->setTemplate('registered');
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.');
	  //echo 'error validating form';
    }
  }
  static private function createGuid()
  {
    $guid = "";
    for ($i = 0; ($i < 8); $i++) 
	{
      $guid .= sprintf("%02x", mt_rand(0, 255));
    }
    return $guid;
  }
}
