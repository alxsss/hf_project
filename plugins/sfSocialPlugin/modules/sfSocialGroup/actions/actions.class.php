<?php
require_once dirname(__FILE__).'/../lib/BasesfSocialGroupActions.class.php';

/**
 * sfSocialGroup actions.
 * 
 * @package    sfSocialPlugin
 * @subpackage sfSocialGroup
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12628 2008-11-04 14:43:36Z Kris.Wallsmith $
 */
class sfSocialGroupActions extends BasesfSocialGroupActions
{
  public function executeAllmembers(sfWebRequest $request)
  {
    $this->group_id=$request->getParameter('id');
    $this->allmembers_pager = sfSocialGroupUserPeer::getAllGroupMembersPager($this->getRequestParameter('id'),$this->getRequestParameter('page', 1));
  }
  public function executeEditmembers(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
       $group_id=$request->getParameter('id');
       $this->group = sfSocialGroupPeer::retrieveByPK($group_id);
       $this->allmembers_pager = sfSocialGroupUserPeer::getAllGroupMembersPager($this->getRequestParameter('id'),$this->getRequestParameter('page', 1));
    }
    else
    {
      return $this->forward('sfGuardAuth','signin');
    }
  }

public function executeStatus(sfWebRequest $request)
  {    
	$this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
	$this->group_id=$request->getParameter('id');
	$status_content=$request->getParameter('user_status');
    if (!empty($status_content))
    {
	  $this->status=new GroupStatus();
	  $this->status->setGroupId($this->group_id);
	  $this->status->setStatus($status_content);
	  $this->status->setCreatedAt(time());
	  $this->status->save();
	}	
  }
  public function executeSuggest(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
       $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
       $this->group = sfSocialGroupPeer::retrieveByPK($request->getParameter('id'));
       $this->forward404Unless($this->group, 'group not found');	    
       $this->friend_pager = FriendPeer::getAllFriendsPager($this->getRequestParameter('page', 1), $this->user_id);
    }
    else
    {
      $this->redirect('@homepage');
    }
  }
  public function executeInvite(sfWebRequest $request)
  {
        $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
	$this->forward404Unless($request->isMethod('post'), 'invalid request');
	$group_id = $request->getParameter('group_id');
	$page = $request->getParameter('page');
	$this->group = sfSocialGroupPeer::retrieveByPK($group_id);
	$this->forward404Unless($this->group, 'group not found');
	$markinvite=$request->getParameter('markinvite');
	$count=0;
	while(list($key, $value)=each($markinvite))
	{
          $invite=new sfSocialGroupInvite();
	  $invite->setGroupId($group_id);
	  $invite->setUserId($value);
	  $invite->setUserFrom($this->user_id);
	  $invite->save();
	  $count++;
          //send emails to each invited user
          $invited_user=sfGuardUserPeer::retrieveByPk($value);
          $user=sfGuardUserPeer::retrieveByPk($this->user_id);
          //extract name if exists
          $name= $user->getProfile()->getName(); 
          $name= trim($name);
          $username=$user->getUsername();	
          if(empty($name))
          {
            $name=$username;
          }
          $this->sendGroupInvitationEmail($invited_user->getEmail(),$invited_user->getUsername(),$name,$this->group);
	}    
    //$this->dispatcher->notify(new sfEvent($this->form->getObjects(), 'social.group_invite'));
    $this->getUser()->setFlash('notice', '%1% users invited.');
    $this->getUser()->setFlash('nr', $count);    
    $this->redirect($this->getUser()->getReferer($request->getReferer()));
  }
   public function executeAddstatuscomment(sfWebRequest $request)
  {
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      $this->status_id=$request->getParameter('item_id');	
      $this->status = GroupStatusPeer::retrieveByPk($this->status_id);
      $this->forward404Unless($this->status, 'status not found');
      $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	
      //$group_admin_id=$request->getParameter('item_user_id');	;//$this->photos->getUserId();
      $comment_body=$request->getParameter('comment');
      if (!empty($comment_body))
      {
        // create comment
        $this->comment = new GroupStatusComment();
        $this->comment->setGroupStatusId($this->status_id);
        $this->comment->setComment($comment_body);
        $this->comment->setUserId($this->user_id);
        $this->comment->save();        
        $user=sfGuardUserPeer::retrieveByPk($this->user_id);
        //extract name if exists
        $this->name= $user->getProfile()->getName(); 
        $this->name= trim($this->name);
        $username=$user->getUsername();	
        if(empty($this->name))
        {
          $this->name=$username;
        }
        //send emails to users of previous comments 
        //collect emails in an array
	$emails_comment_users=array();
        foreach($this->status->getGroupStatusComments() as $comment)
        {	     
          //collect emails in an array
	  $emails_comment_users[]=$comment->getsfGuardUser()->getEmail();		  
        }
		//eliminate the same emails
		$emails_comment_users_unique=array_unique($emails_comment_users);
		$own_email=array($user->getEmail());
		//do not send email to user himself/herself   
		$emails_comment_users_unique_exOwn=array_diff($emails_comment_users_unique,$own_email);
		foreach( $emails_comment_users_unique_exOwn as $email)
		{
		  $this->sendGroupComment(trim($email), $this->name, $this->status->getsfSocialGroup()->getId());
		}		    
	   return sfView::SUCCESS;
	 }//end if body  
  } 
}
 public function executeDeletegroupstatuscomment(sfWebRequest $request)
 {
    $this->forward404Unless($statuscomment = GroupStatusCommentPeer::retrieveByPk($request->getParameter('id')));
  	$statuscomment->delete();	 
 } 
 public function executeDeletegroupstatus($request)
 {
    $this->forward404Unless($status = GroupStatusPeer::retrieveByPk($request->getParameter('id')));
	$status->delete();	
  }  
  protected function  sendGroupComment($email, $name, $group_id)
 {
    $url='http://hemsinif.com/az/group/'.$group_id;
    $subject=$name.' hemsinifdə sizin rəyinizdən sonra oz rəyini bildirdi';
    $body=<<<EOF

Salam,

$name, hemsinif.com da sizin rəyinizdən sonra oz rəyini 
bildirdi.  Onu görmək üçün bu linkə
  
$url

gedə bilərsiniz.

Sag olun,
hemsinif.com kollektivi
EOF;
    ProjectConfiguration::registerZend();
    $mail = new Zend_Mail('utf-8');
    $mail->setBodyText($body);
    $mail->setFrom('info@hemsinif.com', 'hemsinif kollektivi');
    $mail->addTo($email);
    $mail->setSubject($subject);
    $mail->send(); 
 }
protected function  sendGroupInvitationEmail($email, $username, $name, $group)
 {
    $url='http://hemsinif.com/az/group/'.$group->getId();
    $title=$group->getTitle();
    $subject=$name.' hemsinif.com saytinda sizi "'.$title.'" qrupuna dəvət edir';
    $body=<<<EOF

Salam $username,

$name, hemsinifdə sizi "$title" qrupuna dəvət edir.  Bu qrupun səhifəsinə bu linkdə 
  
$url

baxa bilərsiniz.

Sag olun,
hemsinif.com kollektivi
EOF;
    ProjectConfiguration::registerZend();
    $mail = new Zend_Mail('utf-8');
    $mail->setBodyText($body);
    $mail->setFrom('info@hemsinif.com', 'hemsinif kollektivi');
    $mail->addTo($email);
    $mail->setSubject($subject);
    $mail->send(); 
 }
 public function executeDeletecomment()
 {
    if (!$this->getRequestParameter('id'))
    {
      return sfView::NONE;
    }
    $this->comment = GroupCommentPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->comment);
    $this->comment->delete();
    $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	  
 }  
 public function executeDeletegroupuser(sfWebRequest $request)
  {
    $this->forward404Unless($group_user = sfSocialGroupUserPeer::retrieveByPk($request->getParameter('group_id'), $request->getParameter('user_id') ));
    $this->group = sfSocialGroupPeer::retrieveByPK($request->getParameter('group_id'));
    $this->forwardUnless($this->group->getUserAdmin()==$this->user_id, 'sfGuardAuth', 'secure');
    $group_user->delete();
  }
public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($group = sfSocialGroupPeer::retrieveByPk($request->getParameter('id') ));
    $this->forwardUnless($group->getUserAdmin()==$this->user_id, 'sfGuardAuth', 'secure');
    $group->delete();
    $this->redirect('@sf_social_group_list');
  }
}
