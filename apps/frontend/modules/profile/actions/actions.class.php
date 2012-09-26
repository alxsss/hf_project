<?php

/**
 * profile actions.
 *
 * @package    fmpsv
 * @subpackage profile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class profileActions extends sfActions
{
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ProfileForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new ProfileForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
	if ($this->getUser()->isAuthenticated())
	{
	  $user=sfGuardUserProfilePeer::getForToken($request->getParameter('token'));
	  $id=$user->getProfile()->getId();
	  //$this->forward404Unless($sf_guard_user_profile = sfGuardUserProfilePeer::retrieveByPk($request->getParameter('id')), sprintf('Object sf_guard_user_profile does not exist (%s).', $request->getParameter('id')));
      $this->forward404Unless($sf_guard_user_profile = sfGuardUserProfilePeer::retrieveByPk($id), sprintf('Object sf_guard_user_profile does not exist (%s).', $id));
   	  $this->form = new ProfileForm($sf_guard_user_profile);
	}
	else
	{
	  return $this->forward('sfGuardAuth','signin');
	}
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($sf_guard_user_profile = sfGuardUserProfilePeer::retrieveByPk($request->getParameter('id')), sprintf('Object sf_guard_user_profile does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProfileForm($sf_guard_user_profile);
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($sf_guard_user_profile = sfGuardUserProfilePeer::retrieveByPk($request->getParameter('id')), sprintf('Object sf_guard_user_profile does not exist (%s).', $request->getParameter('id')));
    $sf_guard_user_profile->delete();

    $this->redirect('profile/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sf_guard_user_profile = $form->save();

	 // $this->redirect('profile/'.$sf_guard_user_profile->getSfGuardUser()->getSalt());
	  $this->redirect('user/'.$sf_guard_user_profile->getSfGuardUser()->getUsername());
	  
    }
  }
}
