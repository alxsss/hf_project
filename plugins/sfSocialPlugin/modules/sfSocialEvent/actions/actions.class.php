<?php

require_once dirname(__FILE__).'/../lib/BasesfSocialEventActions.class.php';

/**
 * sfSocialEvent actions.
 * 
 * @package    sfSocialPlugin
 * @subpackage sfSocialEvent
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12628 2008-11-04 14:43:36Z Kris.Wallsmith $
 */
class sfSocialEventActions extends BasesfSocialEventActions
{
  public function executeAllconfirmed()
  {
    $this->allmembers_pager = sfSocialEventUserPeer::getConfirmedUsersPager($this->getRequestParameter('id'),$this->getRequestParameter('page', 1));
    $this->setTemplate('allmembers');
  }
  public function executeAllmaybe()
  {
    $this->allmembers_pager = sfSocialEventUserPeer::getMaybeUsersPager($this->getRequestParameter('id'),$this->getRequestParameter('page', 1));
    $this->setTemplate('allmembers');
  }
 public function executeAllno()
  {
    $this->allmembers_pager = sfSocialEventUserPeer::getNoUsersPager($this->getRequestParameter('id'),$this->getRequestParameter('page', 1));
    $this->setTemplate('allmembers');
  }
  public function executeAllawaitingreply()
  {
    $this->allmembers_pager = sfSocialEventUserPeer::getAwaitingReplyUsersPager($this->getRequestParameter('id'),$this->getRequestParameter('page', 1));
    $this->setTemplate('allmembers');
  }

  public function executeStatus(sfWebRequest $request)
  {
        $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
        $this->event_id=$request->getParameter('id');
        $status_content=$request->getParameter('user_status');
    if (!empty($status_content))
    {
          $this->status=new EventStatus();
          $this->status->setEventId($this->event_id);
          $this->status->setUserId($this->user_id);
          $this->status->setStatus($status_content);
          $this->status->setCreatedAt(time());
          $this->status->save();
        }
  }
  public function executeSuggest(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
       $this->event = sfSocialEventPeer::retrieveByPK($request->getParameter('id'));
       $this->forward404Unless($this->event, 'event not found');
       $this->friend_pager = FriendPeer::getAllFriendsPager($this->getRequestParameter('page', 1), $this->user_id);
    }
    else
    {
      return $this->forward('sfGuardAuth','signin');      
    }
  }
 public function executeInvite(sfWebRequest $request)
  {
        $this->forward404Unless($request->isMethod('post'), 'invalid request');
        $event_id = $request->getParameter('event_id');
        $page = $request->getParameter('page');
        $this->event = sfSocialEventPeer::retrieveByPK($event_id);
        $this->forward404Unless($this->event, 'event not found');
        $markinvite=$request->getParameter('markinvite');
        $count=0;
        while(list($key, $value)=each($markinvite))
        {
          $invite=new sfSocialEventInvite();
          $invite->setEventId($event_id);
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
          $this->sendEventInvitationEmail($invited_user->getEmail(),$invited_user->getUsername(), $name,$this->event);
        }
    //$this->dispatcher->notify(new sfEvent($this->form->getObjects(), 'social.event_invite'));
    $this->getUser()->setFlash('notice', '%1% users invited.');
    $this->getUser()->setFlash('nr', $count);
    $this->redirect($this->getUser()->getReferer($request->getReferer()));
  }
 public function executeDeleteeventstatus($request)
 {
    $this->forward404Unless($status = EventStatusPeer::retrieveByPk($request->getParameter('id')));
        $status->delete();
  }
 public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($event = sfSocialEventPeer::retrieveByPk($request->getParameter('id') ));
    $this->forwardUnless($event->getUserAdmin()==$this->user_id, 'sfGuardAuth', 'secure');
    $event->delete();
    $this->redirect('@sf_social_event_list');
  }

  public function executeAddstatuscomment(sfWebRequest $request)
  {
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      $this->status_id=$request->getParameter('item_id');
      $this->status = EventStatusPeer::retrieveByPk($this->status_id);
      $this->forward404Unless($this->status, 'event not found');
      $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
      $comment_body=$request->getParameter('comment');
      if (!empty($comment_body))
      {
        // create comment
        $this->comment = new EventStatusComment();
        $this->comment->setEventStatusId($this->status_id);
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
        foreach($this->status->getEventStatusComments() as $comment)
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
                  $this->sendEventComment(trim($email), $this->name, $this->event->getsfSocialEvent()->getId());
                }
           return sfView::SUCCESS;
         }//end if body
  }
}

public function executeDeleteeventstatuscomment(sfWebRequest $request)
 {
    $this->forward404Unless($statuscomment = EventStatusCommentPeer::retrieveByPk($request->getParameter('id')));
        $statuscomment->delete();
 }
 protected function  sendEventComment($email, $name, $event_id)
 {
    $url='http://hemsinif.com/az/event/'.$event_id;
    $subject=$name.' hemsinifdə sizin rÉinizdÉ sonra oz rÉini bildirdi';
    $body=<<<EOF

Salam,

$name, hemsinif.com da sizin rÉinizdÉ sonra oz rÉini
bildirdi.  Onu görmÉ üçün bu linkÉ
$url

gedÉbilÉsiniz.

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

protected function  sendEventInvitationEmail($email, $username, $name, $event)
 {
    $url='http://hemsinif.com/az/event/'.$event->getId();
    $title=$event->getTitle();
    $subject=$name.' hemsinifdə sizi "'.$title.'" hadisəsinə dəvət edir';
    $body=<<<EOF

Salam $username,

$name, hemsinifdə sizi "$title" hadisəsinə dəvət edir.  Bu hadisənin səhifəsinə bu linkdə

$url

baxa bilərsiniz.

Sag olun,
hemsinif kollektivi
EOF;
    ProjectConfiguration::registerZend();
    $mail = new Zend_Mail('utf-8');
    $mail->setBodyText($body);
    $mail->setFrom('info@hemsinif.com', 'hemsinif kollektivi');
    $mail->addTo($email);
    $mail->setSubject($subject);
    $mail->send();
 }

}
