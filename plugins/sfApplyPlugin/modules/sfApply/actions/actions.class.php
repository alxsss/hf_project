<?php
/**
 * sfApply actions.
 *
 * @package    5seven5
 * @subpackage sfApply
 * @author     Tom Boutell, tom@punkave.com
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */

// Necessary due to a bug in the Symfony autoloader
require_once(dirname(__FILE__).'/../lib/BasesfApplyActions.class.php');

class sfApplyActions extends BasesfApplyActions
{
  // See how this extends BasesfApplyActions? You can replace it with
  // your own version by adding a modules/sfApply/actions/actions.class.php
  // to your own application and extending BasesfApplyActions there as well.
  /* added by A. Kingson in Sep 2009*/
  
  public function executeInvitefriend(sfRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
	  $this->user=sfGuardUserPeer::retrieveByPk($user_id);	  
	  $this->forward404Unless($this->user);
	  //extract name if exists
	  $this->name= $this->user->getProfile()->getName(); 
      $this->name= trim($this->name);
	  $username=$this->user->getUsername();
	  $user_email=$this->user->getEmail();
      if(empty($this->name))
      {
	    $this->name=$username;
	  }      
	  $this->form = $this->newForm('sfApplyInviteFriendForm');
      if ($request->isMethod('post'))
      {
        $this->form->bind($request->getParameter('sfApplyInviteFriend'));
	    $this->errors=array();
        if ($this->form->isValid())
        {
          sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
		  //$mailTo=$this->form->getValue('sfApplyInviteFriend[recepient_email]');
		  $mailTo=$request->getParameter('sfApplyInviteFriend[recepient_email]');
		  $p_message=$request->getParameter('sfApplyInviteFriend[personal_message]');
	      $recepients=explode(',', $mailTo);
		  foreach($recepients as $email)
		  {
		    $email=trim($email);
			if($email==trim($user_email))
			{
			  $this->errors[]=__('You cannot send invitation to yourself');
			  continue;
			}
			$recepient = sfGuardUserPeer::retrieveByEmail($email);
		    if($recepient)
		    {
		      $friend = $this->user->isFriend($recepient->getId(), true);
			  //check if this user has already been sent friend request	
	          if(!empty($friend))
        	  {
	            foreach($friend as $f)
	            {
				  $approved=$f->getApproved();
	              if($approved)
				  { 
				    $this->errors[]=__('%email% already registered in hemsinif.com and you already have this user as a friend', array('%email%'=>$email)); 
				  }
	              else
			      {
				    $this->errors[]=__('You have already sent friend request to %email%', array('%email%'=>$email)); 
			      }
	            }
	          }
			  else
			  {
			    $this->errors[]=__('%email% already registered in hemsinif.com and we send a friend request for you', array('%email%'=>$email)); 
			    $recepient_username=$recepient->getUsername();
			    $recepient_name=$recepient->getProfile()->getName();
				$recepient_name= trim($recepient_name);
			    if(empty($recepient_name))
                {
			      $recepient_name=$recepient_username;
                }
			    $this->sendFriendRequest(trim($email), $user_id, $recepient->getId(), $recepient_name,  $this->name, $p_message);
			  }
		    }
		    else
		    {
		      $this->sendInvitation(trim($email), $username, $this->name, $p_message);
			  $this->errors[]= __('An invitation email has been sent to %email%', array('%email%'=>$email));
		    }
		  } 		
          return 'After';
        }
      }
	}
	else	
	{
      return $this->forward('sfGuardAuth','signin');;
    }
  }
  protected function sendFriendRequest($email, $user_id, $friend_id, $recepient_name,  $from_name, $p_message)
  {
    $friend=new Friend();
	$friend->setUserId($user_id);
	$friend->setFriendId($friend_id);
	$friend->save();
	$mail = $this->getMailer();
	$mail->setBodyText(<<<EOF
	Salam $recepient_name,

        $from_name sizi hemsinif-da dost kimi əlavə etdi.  $from_name 
        sizin dostunuz olmaq üçün siz bu təklifi təsdiq etməlisiniz.
       
        Xahiş edirik onu bu linkdə
   
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
  protected function sendInvitation($email, $username,  $from_name, $p_message)
  {
    $mail = $this->getMailer();
	$url='http://hemsinif.com/az/user/'.trim($username);
	$mail->setBodyText(<<<EOF
	Salam $email,
	
	  Mənim hemsinif.com da profilim var. Səni mənim profilimə baxmağa 
        və hemsinif.com da qeyd olmağa dəvət edirəm
	
	  hemsinif.com da aşağıdakı linkdə qeyd olmaq olar	
	  http://hemsinif.com/register
	
	  Mənim profilim isə bu linkdədi:	
	  $url	
	
        $p_message
	
	Sag ol.
	$from_name
EOF
);
        
	  $mail->setFrom('info@hemsinif.com', $from_name);
      $mail->addTo($email);
      $mail->setSubject($from_name.'  sizi hemsinif.com a dəvət edir');
      $mail->send();
  }
}
