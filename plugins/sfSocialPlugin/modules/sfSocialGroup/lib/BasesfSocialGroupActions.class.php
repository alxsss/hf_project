<?php

/**
 * Base actions for the sfSocialPlugin sfSocialGroup module.
 *
 * @package     sfSocialPlugin
 * @subpackage  sfSocialGroup
 * @author      Massimiliano Arione <garakkio@gmail.com>
 * @version     SVN: $Id: BaseActions.class.php 12628 2008-11-04 14:43:36Z Kris.Wallsmith $
 */
abstract class BasesfSocialGroupActions extends sfActions
{

  public function preExecute()
  {
    $this->user = $this->getUser()->getGuardUser();
    $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
  }

  /**
   * List of all groups
   * @param sfRequest $request A request object
   */
  public function executeList(sfWebRequest $request)
  {
    $page = $request->getParameter('page', 1);
    $this->pager = sfSocialGroupPeer::getGroups($page);
  }

  /**
   * List of user's groups
   * @param sfRequest $request A request object
   */
  public function executeMylist(sfWebRequest $request)
  {
    $this->groups = $this->user->getsfSocialGroups();
  }

  /**
   * View a a group
   * @param sfRequest $request A request object
   */
  public function executeView(sfWebRequest $request)
  {
    $this->group = sfSocialGroupPeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($this->group, 'group not found');
	$this->group_status_pager = sfSocialGroupPeer::getStatusPager($this->getRequestParameter('page', 1), $request->getParameter('id'));	
    // invite form
   /* if ($this->group->isMember($this->user_id))
    {
      $this->form = new sfSocialGroupInviteForm(null, array('user' => $this->user, 'group' => $this->group));
    }
   */
  }

  /**
   * Edit a group
   * @param sfRequest $request A request object
   */
  public function executeEdit(sfWebRequest $request)
  {
    $this->group = sfSocialGroupPeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($this->group, 'group not found');
    $this->forwardUnless($this->group->isAdmin($this->user_id), 'sfGuardAuth', 'secure');
    $this->form = new sfSocialGroupForm($this->group, array('user' => $this->user));
    if ($request->isMethod('post'))
    {
	  if ($this->form->bindAndSave($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName())))
      {
        $this->getUser()->setFlash('notice', 'Group modified');
        $this->redirect('@sf_social_group?id=' . $this->form->getObject()->getId());
      }
    }
  }

  /**
   * Create a new group
   * @param sfRequest $request A request object
   */
  public function executeCreate(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->form = new sfSocialGroupForm(null, array('user' => $this->user));
      if ($request->isMethod('post'))
      {
         if ($this->form->bindAndSave($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName())))
        {
          $this->getUser()->setFlash('notice', 'Group created');
          $this->redirect('@sf_social_group?id=' . $this->form->getObject()->getId());
        }
      }
	} 
	else
	{
	  return $this->forward('sfGuardAuth','signin');
	} 
  }

  /**
   * Invite another user to join group
   * @param sfRequest $request A request object
   */
  public function executeInvite_old(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'), 'invalid request');
    $values = $request->getParameter('sf_social_group_invite');
    $this->group = sfSocialGroupPeer::retrieveByPK($values['group_id']);
    $this->forward404Unless($this->group, 'group not found');
    $this->forwardUnless($this->group->isAdmin($this->user), 'sfGuardAuth', 'secure');
    $this->form = new sfSocialGroupInviteForm(null, array('user' => $this->user, 'group' => $this->group));
    if ($this->form->bindAndSave($values))
    {
      $this->dispatcher->notify(new sfEvent($this->form->getObjects(), 'social.group_invite'));
      $this->getUser()->setFlash('notice', '%1% users invited.');
      $this->getUser()->setFlash('nr', count($this->form->getValue('user_id')));
    }
    $this->redirect('@sf_social_group?id=' . $this->group->getId());
  }

  /**
   * Join a group directly
   * @param sfRequest $request A request object
   */
  public function executeJoin(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
      $group = sfSocialGroupPeer::retrieveByPK($request->getParameter('id'));
      $this->forward404Unless($group, 'group not found');
      if ($group->join($this->user_id))
      {
        $this->getUser()->setFlash('notice', 'Group joined');
      }
      $this->redirect('@sf_social_group?id=' . $group->getId());
    }
    else
    {
      return $this->forward('sfGuardAuth','signin');
    }
  }

  /**
   * Join a group by accepting an invite
   * @param sfRequest $request A request object
   */
  public function executeAccept(sfWebRequest $request)
  {
    $invite = sfSocialGroupInvitePeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($invite, 'invite not found');
    $this->forwardUnless($invite->getUserId() == $this->user->getId(), 'sfGuardAuth', 'secure');
    $this->group_title=$invite->getsfsocialGroup()->getTitle();
    if ($invite->getsfSocialGroup()->join($this->user_id, $invite))
    {
      $this->getUser()->setFlash('notice', 'Group joined');
    }
	if(!$this->getRequest()->isXmlHttpRequest())
	{
      $this->redirect('@sf_social_group?id=' . $invite->getsfSocialGroup()->getId());
	}  
  }

  /**
   * Deny an invite
   * @param sfRequest $request A request object
   */
  public function executeDeny(sfWebRequest $request)
  {
    $invite = sfSocialGroupInvitePeer::retrieveByPK($request->getParameter('id'));
    $this->forward404Unless($invite, 'invite not found');
    $this->forwardUnless($invite->getUserId() == $this->user->getId(), 'sfGuardAuth', 'secure');
    $this->group_title=$invite->getsfsocialGroup()->getTitle();
    if ($invite->refuse())
    {
      $this->getUser()->setFlash('notice', 'Invite refused');
    }
	if(!$this->getRequest()->isXmlHttpRequest())
	{
      $this->redirect('@sf_social_group?id=' . $invite->getsfSocialGroup()->getId());
	}
  }

  public function executeLeave(sfWebRequest $request)
  {
    $group_user = sfSocialGroupUserPeer::retrieveByPK($request->getParameter('id'),$this->user_id);
    $this->forward404Unless($group_user, 'invite not found');
    $this->forwardUnless($group_user->getUserId() == $this->user_id, 'sfGuardAuth', 'secure');
    $group_user->delete();    
    $this->redirect('@sf_social_group?id='.$request->getParameter('id'));
  }

  /**
   * Javascript for "Invite users"
   * @param sfRequest $request A request object
   */
  public function executeInvitejs(sfWebRequest $request)
  {
  }

}
