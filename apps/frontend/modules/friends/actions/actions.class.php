<?php

/**
 * friends actions.
 *
 * @package    hemsinif
 * @subpackage friends
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class friendsActions extends sfActions
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
  public function executeUpdates(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->page=$this->getRequestParameter('page', 1);
	  $c=new Criteria();
	  $c->add(FriendPeer::APPROVED,1);
	  $this->friends = $this->subscriber->getFriendsRelatedByUserId($c);
	  //extract friends using friendid
	  $this->friendsAsFriendids = $this->subscriber->getFriendsRelatedByFriendId($c);
	  //select all from friend table including not approved ones
	  $this->friendsINA = $this->subscriber->getFriendsRelatedByUserId();
	  $this->friendsAsFriendidsINA = $this->subscriber->getFriendsRelatedByFriendId();
	  $this->ignorelists=$this->subscriber->getIgnorelistsRelatedByUserId();
	  $this->newest_users=sfGuardUserPeer::getNewestUsers();
	  $this->last_logged_in_users=sfGuardUserPeer::getLastLoggedINUsers();
	  $this->popular_games=GamePeer::getPopularGames();
	  $this->user_groups = $this->subscriber->getsfSocialGroupUsers();
	  $this->popular_photos=PhotoPeer::getPopularPhotos();
	  $this->new_photos=PhotoPeer::getNewPhotos();
	}
	else
	{
	  $this->redirect('@homepage');
	}
  }
  public function executeIgnore(sfWebRequest $request)
  {
	$this->ignored_user_id=$this->getRequestParameter('id');
	//$this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
	$ignore_list =new Ignorelist();
	$ignore_list->setUserId($this->user_id);
	$ignore_list->setIgnoredUserId($this->ignored_user_id);
	$ignore_list->save();	
	$c_a1=new Criteria();
	$c_a1->add(FriendPeer::APPROVED,1);  	
    $this->friends = $this->subscriber->getFriendsRelatedByUserId($c_a1);
	$this->friendsAsFriendids = $this->subscriber->getFriendsRelatedByFriendId($c_a1);
	//select all from friend table including not approved ones
	$this->friendsINA = $this->subscriber->getFriendsRelatedByUserId();
	$this->friendsAsFriendidsINA = $this->subscriber->getFriendsRelatedByFriendId();
	$this->ignorelists=$this->subscriber->getIgnorelistsRelatedByUserId();	
  }
  public function executeList(sfWebRequest $request)
  { 
    if ($this->getUser()->isAuthenticated())
    {     
      $this->friendsRequested = $this->subscriber->getFriendsRequested();
      $this->group_invites=$this->subscriber->getGroupInvites();
	  $this->event_invites=$this->subscriber->getEventInvites();
	}
	else	
	{ 
      return $this->forward('sfGuardAuth','signin');
    }
  }
  public function executeNew(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->form = new FriendForm();	  
	  $friend_id=$request->getParameter('friend_id');
	  $this->friend = sfGuardUserPeer::retrieveByPK($friend_id);
	  $this->form->setDefaults(array('user_id'=>$this->user_id, 'friend_id'=>$friend_id));      
	}
	else	
	{
      return $this->forward('sfGuardAuth','signin');
    }
  }

  public function executeCreate(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->forward404Unless($request->isMethod('post'));
	  $this->form = new FriendForm();	  
	  $friend_id=$this->getRequestParameter('friend[friend_id]');	
	  //extract name if exists
	  $this->name=  $this->subscriber->getProfile()->getName(); 
      $this->name= trim($this->name);
	  $username= $this->subscriber->getUsername();	
      if(empty($this->name))
      {
	    $this->name=$username;
	  } 
      //check if this user has already been sent friend request     
	  $friend =  $this->subscriber->isFriendNotApproved($friend_id, true);
	  $this->recepient = sfGuardUserPeer::retrieveByPk($friend_id);
	  if(!empty($friend))
	  {
	    foreach($friend as $f)
	    {
	      $approved=$f->getApproved();
	      if($approved){$this->error='You already have this user as a friend.';}
	      else {$this->error='You have already sent friend request to this user or this user has sent you a friend request.';}
	    }
	   }
	  else
	  { 	    
	    if($this->recepient)
	    {
	      $email=$this->recepient->getEmail();
		  if(!empty($email))
		  {		  
		    $recepient_username=$this->recepient->getUsername();
		    $recepient_name=$this->recepient->getProfile()->getName();
		    $recepient_name= trim($recepient_name);
	        if(empty($recepient_name))
            {
		      $recepient_name=$recepient_username;
            }
		    $this->sendFriendRequest(trim($email), $recepient_name,  $this->name, $p_message);
		  }
	    }
	    $this->processForm($request, $this->form);
	  }    
      $this->setTemplate('new');
	}
	else	
	{
      return $this->forward('sfGuardAuth','signin');
    }
  }

  public function executeEdit(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $friend_id=$request->getParameter('id');
	  $this->friend = sfGuardUserPeer::retrieveByPK($friend_id);	  
	}
	else	
	{
      return $this->forward('sfGuardAuth','signin');
    }
	
	//$this->form = new FriendForm($this->friend_id);
  }
  public function executeAddstatuscomment(sfWebRequest $request)
  {
   if ($this->getRequest()->getMethod() == sfRequest::POST)
   {
    $this->status_id=$request->getParameter('item_id');	
	$this->status_user_id=$request->getParameter('item_user_id');	
	//$this->i=$request->getParameter('index');    
    $this->user_id= $this->getUser()->getSubscriberId();
	$status_comment=$request->getParameter('comment');
    if (!empty($status_comment))
    {	 
      $this->comment = new sfGuardUserStatusComment();
      $this->comment->setStatusId($this->status_id);
      $this->comment->setComment($status_comment);
      $this->comment->setUserId($this->user_id);
      $this->comment->save();
      //prepare to send emails to each user of comments and to owner of the status
      $user=sfGuardUserPeer::retrieveByPk($this->user_id);
      $status_owner_user = sfGuardUserPeer::retrieveByPk($this->status_user_id);
	  //extract name if exists
	  $this->name= $user->getProfile()->getName(); 
      $this->name= trim($this->name);
	  $username=$user->getUsername();	
      if(empty($this->name))
      {
	    $this->name=$username;
	  } 
	  //if the user is not the owner of the status, send email to owner
	  //send emails to users of previous comments 
	  $this->status = sfGuardUserStatusPeer::retrieveByPk($this->status_id);
	  $page=$this->getRequestParameter('page', 1);
          //send emails to users of previous comments
          //collect emails in an array
          $emails_comment_users=array();
          $usernames_comment_users=array();
	  foreach($this->status->getsfGuardUserStatusComments() as $comment)
	  {
	    //collect emails in an array
            $emails_comment_users[]=$comment->getsfGuardUser()->getEmail();
            $usernames_comment_users[]=$comment->getsfGuardUser()->getUsername();
          }
          //eliminate the same emails
          $emails_comment_users_unique=array_unique($emails_comment_users);
          $usernames_comment_users_unique=array_unique($usernames_comment_users);
          $own_email=array($user->getEmail(), $status_owner_user->getEmail());
          $own_username=array($user->getUsername(), $status_owner_user->getUsername());
          //do not send email to user himself/herself  and to owner 
          $emails_comment_users_unique_exOwn=array_diff($emails_comment_users_unique,$own_email);
          $usernames_comment_users_unique_exOwn=array_diff($usernames_comment_users_unique, $own_username);
          foreach($emails_comment_users_unique_exOwn as $i=>$email)
          {
             if(!empty($email))
	        {
			  $this->sendStatusComment(trim($email), $usernames_comment_users_unique_exOwn[$i],  $this->name, $page);
			} 
	  }	
	  if($this->user_id!=$this->status_user_id)
	  {
	    if($status_owner_user)
	    {
	      $email=$status_owner_user->getEmail();
		  if(!empty($email))
		  {
	        $recepient_username=$status_owner_user->getUsername();
		    $page=$this->getRequestParameter('page', 1);
		    $url='http://hemsinif.com/az/user/'.$recepient_username;			
		    $subject=$this->name.' hemsinif.com da sizin statusunuza rəyini bildirdi';
		$body=<<<EOF
          Salam $recepient_username,

          $this->name hemsinif.com da sizin statusunuza rəyini bildirdi. Ona  linkdə $url baxa bilərsiniz.

          Sag olun,
          hemsinif.com
EOF;
		  $this->sendhemsinifEmail(trim($email), $subject, $body);
		 }//end if email 
		}
	  }
	}
    return sfView::SUCCESS;
  }
 
   $this->forward404();
}

  public function executeAddphotocomment(sfWebRequest $request)
  {
   if ($this->getRequest()->getMethod() == sfRequest::POST)
   {
    $this->photo_id=$request->getParameter('item_id');	
	$this->photo_user_id=$request->getParameter('item_user_id');	
	//$this->i=$request->getParameter('index');    
    $this->user_id= $this->getUser()->getSubscriberId();
	$photo_comment=$request->getParameter('comment');
    if (!empty($photo_comment))
    {	 
      $this->comment = new PhotoComment();
      $this->comment->setphotoId($this->photo_id);
      $this->comment->setComment($photo_comment);
      $this->comment->setUserId($this->user_id);
      $this->comment->save();
      //prepare to send emails to each user of comments and to owner of the photo
      $user=sfGuardUserPeer::retrieveByPk($this->user_id);
      $photo_owner_user=sfGuardUserPeer::retrieveByPk($this->photo_user_id);
       //extract name if exists
      $this->name= $user->getProfile()->getName(); 
      $this->name= trim($this->name);
      $username=$user->getUsername();	
      if(empty($this->name))
      {
	    $this->name=$username;
	  } 
	  //if the user is not the owner of the photo, send email to owner
	  //send emails to users of previous comments 
	  $this->photo = PhotoPeer::retrieveByPk($this->photo_id);
      $page=$this->getRequestParameter('page', 1);
	  //send emails to users of previous comments
          //collect emails in an array
          $emails_comment_users=array();
          $usernames_comment_users=array();
          foreach($this->photo->getPhotoComments() as $comment)
          {
	    //collect emails in an array
            $emails_comment_users[]=$comment->getsfGuardUser()->getEmail();
            $usernames_comment_users[]=$comment->getsfGuardUser()->getUsername();
	  }
          //eliminate the same emails
          $emails_comment_users_unique=array_unique($emails_comment_users);
          $usernames_comment_users_unique=array_unique($usernames_comment_users);
          $own_email=array($user->getEmail(), $photo_owner_user->getEmail());
          $own_username=array($user->getUsername(),$photo_owner_user->getUsername());
          //do not send email to user himself/herself  and to owner
          $emails_comment_users_unique_exOwn=array_diff($emails_comment_users_unique,$own_email);
          $usernames_comment_users_unique_exOwn=array_diff($usernames_comment_users_unique, $own_username);
          foreach($emails_comment_users_unique_exOwn as $i=>$email)
          {
             if(!empty($email))
	     {
               $this->sendPhotoComment(trim($email), $usernames_comment_users_unique_exOwn[$i],  $this->name, $this->photo_id);
             }
          }
	  if($this->user_id!=$this->photo_user_id)
	  {
	    $email=$photo_owner_user->getEmail();
            if(!empty($email))
	    {
	        $recepient_username=$photo_owner_user->getUsername();
	        $url='http://hemsinif.com/az/photos/show/id/'.$this->photo_id;
	        $subject=$this->name.' hemsinif.com da sizin şəkilinizə rəyini bildirdi';
	        $body=<<<EOF
	      Salam $recepient_username,
              $this->name hemsinif.com da sizin şəkilinizə rəyini 
              bildirdi.  Onu bu linkdə $url baxa bilərsiniz.

           Sag olun,
           hemsinif.com
EOF;
		    $this->sendhemsinifEmail(trim($email), $subject, $body);
		  
	    }
	  }//end if userid!=
	}
    return sfView::SUCCESS;
  }
 
   $this->forward404();
}
   public function executeDeletestatuscomment(sfWebRequest $request)
  {
    $this->forward404Unless($statuscomment = sfGuardUserStatusCommentPeer::retrieveByPk($request->getParameter('id')));
  	$statuscomment->delete();	 
  }
   public function executeDeletephotocomment(sfWebRequest $request)
  {
    $this->forward404Unless($photocomment = PhotoCommentPeer::retrieveByPk($request->getParameter('id')));
	$photocomment->delete();
  }
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($friend = FriendPeer::retrieveByPk($request->getParameter('id')), sprintf('Object friend does not exist (%s).', $request->getParameter('id')));
    $this->form = new FriendForm($friend);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($friend = FriendPeer::retrieveByPk($request->getParameter('id')), sprintf('Object friend does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($friend->getFriendId()==$this->user_id); 
    $this->friend_request_user=sfGuardUserPeer::retrieveByPk($friend->getUserId());
    $this->friend_request_user_username=$this->friend_request_user->getUsername();
    $friend->delete();
    //$this->redirect('friends/list');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $friend = $form->save();
      
      $this->redirect('friends/edit?id='.$friend->getFriendId());
    }
  }
  public function executeApprove(sfWebRequest $request)
  {   	
	$this->friend = FriendPeer::retrieveByPk($request->getParameter('id'));
	$this->friend->setApproved(1);
	$this->friend->save();
	//send email
	//subcriber and user_id is defined in preExecute
	//$this->subscriber=sfGuardUserPeer::retrieveByPk($user_id);
	//extract name if exists
	$this->name= $this->subscriber->getProfile()->getName(); 
    $this->name= trim($this->name);
	$username=$this->subscriber->getUsername();	
    if(empty($this->name))
    {
	  $this->name=$username;
	} 
	//extract details of recepient
	$recepient = sfGuardUserPeer::retrieveByPk($request->getParameter('item_id'));
	if($recepient)
	{
	  $recepient_email=trim($recepient->getEmail());
	  if(!empty($recepient_email))
	  {
	    $recepient_username=$recepient->getUsername();
	    $recepient_name=$recepient->getProfile()->getName();
	    $recepient_name= trim($recepient_name);
	    if(empty($recepient_name))
            {
	     $recepient_name=$recepient_username;
            }
	      $this->sendFriendApproved($recepient_email, $recepient_name,  $this->name, $username);
	   }
           //added this to transfer username to approveSucces page
           $this->friend_request_user_username=$recepient_username;	
	}	
  }
  
  public function executeSearch(sfWebRequest $request)
  {
    if (!$this->query = $request->getParameter('query'))
    {
      return $this->redirect('@updates');
    }    
    $this->friend_list = sfGuardUserPeer::getForLuceneQuery($this->query);
  }
  
  public function executeAllfriends()
  { 
    $this->subscriber_username = sfGuardUserPeer::retrieveByUsername($this->getRequestParameter('username'));
    $this->forward404Unless($this->subscriber_username);
	$this->username_user_id=$this->subscriber_username->getId();
	$this->friend_pager = FriendPeer::getAllFriendsPager($this->getRequestParameter('page', 1), $this->username_user_id);
  }
  public function executeGuest()
  { 
    if ($this->getUser()->isAuthenticated())
    {
	  $this->guest_pager = GuestPeer::getAllGuestsPager($this->getRequestParameter('page', 1), $this->user_id);
	  $con = Propel::getConnection();
	  $c1=new Criteria();
	  $c1->add(GuestPeer::USER_ID, $this->user_id);
	  $c1->add(GuestPeer::CHECKED, 0);
	  $c2=new Criteria();
	  $c2->add(GuestPeer::USER_ID, $this->user_id);
	  $c2->add(GuestPeer::CHECKED, 1);
	  BasePeer::doUpdate($c1, $c2, $con);
	}
	else
	{
	  return $this->forward('sfGuardAuth','signin');
	}
  }
  public function executeRemoveguest(sfWebRequest $request)
  {
	$guest_id=$request->getParameter('id');
	$this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
	if($guest_id)
	{
	  $c = new Criteria();
      $c->add(GuestPeer::GUEST_ID, $guest_id);
	  $c->add(GuestPeer::USER_ID, $this->user_id);
      GuestPeer::doDelete($c);
	}	
 }   
  public function executeUsers()
  { 
    //$this->subscriber_username = sfGuardUserPeer::retrieveByUsername($this->getRequestParameter('username'));
    //$this->forward404Unless($this->subscriber_username);
	//$this->username_user_id=$this->subscriber_username->getId();
	$this->user_pager = sfGuardUserPeer::getRecentPager($this->getRequestParameter('page', 1));
  }  
  protected function sendhemsinifEmail($email, $subject, $body)
  {    
    ProjectConfiguration::registerZend();
    $tr = new Zend_Mail_Transport_Sendmail('-finfo@hemsinif.com');
    Zend_Mail::setDefaultTransport($tr);
    $mail = new Zend_Mail('utf-8');
	$mail->setBodyText($body);
    $mail->setFrom('info@hemsinif.com', 'hemsinif kollektivi');
    $mail->addTo($email);
    $mail->setSubject($subject);
    $mail->send();
  }
 protected function sendFriendRequest($email, $recepient_name,  $from_name, $p_message='')
  {    
	ProjectConfiguration::registerZend();
    $mail = new Zend_Mail('utf-8');
	$mail->setBodyText(<<<EOF
Salam $recepient_name,

  $from_name sizi hemsinifdə  dost kimi əlavə etdi.  $from_name sizin 
  dostunuz olmaq üçün siz bu təklifi təsdiq etməlisiniz.
  
  Xahiş edirik onu bu linkde
   
  http://hemsinif.com/az/friends/list 

  edəsiniz.
   
  $p_message

Sag olun,
hemsinif.com kollektivi 
EOF
);
      $mail->setFrom('info@hemsinif.com', 'hemsinif.com kollektivi');
      $mail->addTo($email);
      $mail->setSubject($from_name.' sizi hemsinif.com da dost kimi əlavə etdi');
      $mail->send();
  }
  
  protected function sendFriendApproved($email, $recepient_name,  $from_name, $from_username)
  {    
	ProjectConfiguration::registerZend();
      $tr = new Zend_Mail_Transport_Sendmail('-finfo@hemsinif.com');
         Zend_Mail::setDefaultTransport($tr);
    $mail = new Zend_Mail('utf-8');
	$url='http://hemsinif.com/az/user/'.urlencode(trim($from_username));
$mail->setBodyText(<<<EOF
Salam $recepient_name,

  $from_name hemsinif.com da sizin dostluq təklifinizi qəbul etdi. Siz 
  bu istifadəçinin profilinə bu linkdə $url baxa bilərsiniz.
	
Sag olun,
hemsinif.com kollektivi  
EOF
);
      $mail->setFrom('info@hemsinif.com', 'hemsinif kollektivi');
      $mail->addTo($email);
      $mail->setSubject($from_name.' hemsinif.com da sizin dostluq təklifinizi qəbul etdi');
      $mail->send();
  }
  
 protected function  sendStatusComment($email, $recepient_name,  $name, $page)
 {
    $url='http://hemsinif.com/updates/'.$page;
    $subject=$name.' hemsinif.com saytında sizin rəyinizdən sonra öz rəyini bildirdi';
    $body=<<<EOF
    Salam $recepient_name,
  
      $name hemsinif.com saytında sizin rəyinizdən sonra öz rəyini 
      bildirdi.  Ona bu lindkə 
      $url
      baxa bilərsiniz.

    Sag olun,
    hemsinif.com kollektivi
EOF;
    ProjectConfiguration::registerZend();
    $tr = new Zend_Mail_Transport_Sendmail('-finfo@hemsinif.com');
    Zend_Mail::setDefaultTransport($tr);
    $mail = new Zend_Mail('utf-8');
    $mail->setBodyText($body);
    $mail->setFrom('info@hemsinif.com', 'hemsinif kollektivi');
    $mail->addTo($email);
    $mail->setSubject($subject);
    $mail->send(); 
 }
  protected function  sendPhotoComment($email, $recepient_name,  $name, $photo_id)
 {
    $url='http://hemsinif.com/az/photos/show/id/'.$photo_id;
    $subject=$name.' hemsinif.com saytında sizin rəyinizdən sonra öz rəyini bildirdi';
    $body=<<<EOF
    Salam $recepient_name,
  
      $name hemsinif.com saytında sizin rəyinizdən sonra öz rəyini 
      bildirdi.  Ona bu lindkə 
      $url
      baxa bilərsiniz.

    Sag olun,
    hemsinif.com kollektivi
EOF;
    ProjectConfiguration::registerZend();
    $tr = new Zend_Mail_Transport_Sendmail('-finfo@hemsinif.com');
    Zend_Mail::setDefaultTransport($tr);
    $mail = new Zend_Mail('utf-8');
    $mail->setBodyText($body);
    $mail->setFrom('info@hemsinif.com', 'hemsinif kollektivi');
    $mail->addTo($email);
    $mail->setSubject($subject);
    $mail->send(); 
 }
 
}
