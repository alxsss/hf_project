<?php

/**
 * openInviter actions.
 *
 * @package    letscod
 * @subpackage openInviter
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class openInviterActions extends sfActions
{
  public function preExecute()
  {
    require_once sfConfig::get('sf_plugins_dir')."/lcOpenInviterPlugin/lib/helper/openInviterHelper.php";
    $this->inviter  = new LcOpenInviter();
    $this->plugins  = $this->inviter->getPlugins();
  }
  

  public function executeIndex(sfWebRequest $request)
  {
    $this->inviter->plugins = $this->plugins;
    $this->form = new GetContactsForm( array(), array("plugins" => $this->plugins, "inviter" => $this->inviter ) );
  }
  
  
  public function executeShow(sfWebRequest $request)
  {   
    if ($this->getRequest()->isMethod('post'))
    {
       $this->form = new GetContactsForm( array(), array("plugins" => $this->plugins, "inviter" => $this->inviter ) );
       $params = $request->getParameter('openInviter');

       $this->form->bind($params);
       if ($this->form->isValid())
       {
         $this->contacts =$this->form->getOption('results');
        /*
         $plugType  =  getPluginType($this->plugins, $params['provider']);
         // contacts found   
          foreach($get_contacts as $email => $name)
         {
           if($plugType == "email")
           $contacts[$email] = $name." (".$email.")";
           elseif($plugType == "social")
           $contacts[$email] = $name;
         }
         $this->contacts=$contacts; 
         $options = array ("contacts"  =>$contacts);
		 
                 //            "email"     =>  $params['email'],
                   //          "password"  =>  $params['password'],
                     //        "provider"  =>  $params['provider'],
                       //      "plugType"  =>  $plugType,
                         //    "sessionId" =>  $this->inviter->plugin->getSessionID()                           
                            );
       
         //putting the options in a session
         //$this->getUser()->setAttribute('show_inviter_options', $options);
         // return $this->redirect('openInviter/invite');
       */
         //$this->form = new ShowContactsForm(array(), $options);
       }
       else
        $this->setTemplate('index');
    }    
  }
  public function executeInvite(sfWebRequest $request)
  {
    //$options = $this->getUser()->getAttribute('show_inviter_options');
	$params = $request->getParameter('showInviter');
    $this->form = new ShowContactsForm(array(), $params);
    if ($this->getRequest()->isMethod('post'))
    {
      $this->form->bind($params);
      if($this->form->isValid())
      {
		 $selected_checkboxes = $params['contacts'];
  		 $selected_contacts = array();
  		 foreach($selected_checkboxes as $key => $val)
		 {
		   $selected_contacts[$params["email_or_id_".$val]] = $params["contact_name_".$val];
		 }
 		 $this->inviter->logout();
		 return 'After';
         //$this->redirect('openInviter/sent');
	  
  		
  		}
  		else
  		{
  		   $this->setTemplate('show');
           //var_dump($this->form->renderGlobalErrors());
           //foreach ($this->form as $key => $field)
           // echo $key.'->'.$field->renderError();
  		   //die('form not valid');
  		}
  	}
  }
  
   public function executeSent(sfWebRequest $request)
   {
   	  $this->sent = $this->getUser()->getAttribute('sent');
   }
}
