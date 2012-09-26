<?php

/**
 * contact actions.
 *
 * @package    twm
 * @subpackage contact
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 8507 2008-04-17 17:32:20Z fabien $
 */
class contactActions extends sfActions
{
  
 public function preExecute()
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	
      $this->subscriber = sfGuardUserPeer::retrieveByPk($this->user_id);
      $this->forward404Unless($this->subscriber);	   
	}
  }
  public function executeCreate($request)
  {
    $this->form = new AdvertiseForm();
    if (!$this->getRequest()->isMethod('post'))
    {
      // Prepare data for the template
 
      // Display the form
      return sfView::SUCCESS;
    }
   else
   {
    $this->form->bind($request->getParameter('advertise'));
    if ($this->form->isValid())
    {
      $advertise = $this->form->save();

      $this->redirect('contact/update');
    }
	}

   // $this->forward('advertise', 'update');
  
  }

  public function executeEdit($request)
  {
    $this->form = new AdvertiseForm(AdvertisePeer::retrieveByPk($request->getParameter('id')));
  }

  public function executeUpdate($request)
  {
        
  }

  
}
