<?php
/**
 * message actions.
 *
 * @package    hemsinif
 * @subpackage message
 * @author     Alexander Kingson
 * @version    SVN: $Id: actions.class.php 8507 2008-04-17 17:32:20Z fabien $
 */ 
class messageActions extends sfActions
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
  public function executeShow($request)
  {
    $page=$request->getParameter('page', 1);
    $this->fromuserid=$request->getParameter('fromuserid');
    $this->id=$request->getParameter('id');
    $this->message = MessagePeer::retrieveByPk($this->id);	
    $this->subject=$this->message->getSubject();
    $this->messages_pager=MessagePeer::getMessagesPager($this->subject, $this->fromuserid, $this->user_id, $page);
    $this->form = new MessageForm();
    $this->form->setDefaults(array('to_userid'=>$this->fromuserid, 'from_userid'=>$this->user_id, 'subject'=>$this->subject, 'to_deltype'=>'0', 'from_deltype'=>'0') );
  }
  public function executeInbox()
  {
    if ($this->getUser()->isAuthenticated())
    {
	  /*$c=new Criteria();
	  $c->add(MessagePeer::TO_DELTYPE, 0);
	  $c->addGroupByColumn(MessagePeer::SUBJECT);
	  $c->addGroupByColumn(MessagePeer::FROM_USERID);
	  $c->addDescendingOrderByColumn(MessagePeer::CREATED_AT);
      $this->msgs = $this->subscriber->getMessagesRelatedByToUserid($c);    */
	  $con = Propel::getConnection();
      $sql = 'SELECT * FROM (select *  from message WHERE to_deltype=0 and
	  to_userid='.$this->user_id.' order by created_at desc) msg group by subject, from_userid order by created_at desc';  
	  $stmt =$con->prepare($sql);
      $stmt->execute();  
      $this->msgs = MessagePeer::populateObjects($stmt);  
	}
	else
	{
	  return $this->forward('sfGuardAuth','signin');
	}
  }
  public function executeSentbox()
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $con = Propel::getConnection();
      $sql = 'SELECT * FROM (select *  from message WHERE from_deltype=0 and
	  from_userid='.$this->user_id.' order by created_at desc) msg group by subject, to_userid order by created_at desc';  
	  $stmt =$con->prepare($sql);
      $stmt->execute();  
      $this->msgs = MessagePeer::populateObjects($stmt);  
	}
	else
	{
	  return $this->forward('sfGuardAuth','signin');
	}     
  } 
   public function executeAdd(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {	  
      $this->forward404Unless($request->isMethod('post'));
     
	  //this done because data comes from jquery post ajax request
	  $message_array=$request->getParameter('message');
	  $message=array();
	  $message['msgtext']=$message_array[0]['value'];
	  $message['subject']=$message_array[1]['value'];
	  $message['to_userid']=$message_array[2]['value'];
	  $message['from_userid']=$message_array[3]['value'];
      $this->form = new MessageForm();
      $this->form->bind($message);
      if ($this->form->isValid())
      {
        $this->message = $this->form->save();
		$this->recepient = sfGuardUserPeer::retrieveByPk($message['to_userid']);
        $this->to_username=$this->recepient->getUsername();
        $recepient_email=$this->recepient->getEmail();
        $from_user=sfGuardUserPeer::retrieveByPk($this->user_id);
        //extract name if exists
        $from_user_name= $from_user->getProfile()->getName(); 
        $from_user_name= trim($from_user_name);
        $from_user_username=$from_user->getUsername();	
        if(empty($from_user_name))
        {
          $from_user_name=$from_user_username;
        } 
      	if(!empty($recepient_email))
        {
  	      $this->sendMessageNotification($recepient_email, $from_user_name);
        }  
      }
    }
    else
    { 
      return $this->forward('sfGuardAuth','signin');
    }
  }
  public function executeCreate($request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  //user id of the user whom the message is sent
	  $this->to_userid=$request->getParameter('to_userid');
	  $this->recepient = sfGuardUserPeer::retrieveByPk($this->to_userid);
	  $this->to_username=$this->recepient->getUsername();
	  $this->forward404Unless($this->to_userid);
	  $this->form = new MessageForm();
	  $this->form->setDefaults(array('from_userid' => $this->user_id, 'to_userid' =>$this->to_userid, 'to_deltype'=>'0', 'from_deltype'=>'0'));
      $this->setTemplate('edit');
	}
	else
	{
	  return $this->forward('sfGuardAuth','signin');
	} 
  }
  public function executeReply($request)
  {
	$this->form = new MessageForm();
	//specify this as this->id to transfer it to template in order to distingwish create and reply in update action
	$this->id=$request->getParameter('id');
	$this->message = MessagePeer::retrieveByPk($request->getParameter('id'));
	$to_userid=$this->message->getToUserId();
	$this->to_username=$this->message->getsfGuardUserRelatedByFromUserid();
	$from_userid=$this->message->getFromUserId();
	$this->recepient = sfGuardUserPeer::retrieveByPk($from_userid);
	$subject='Ca: '.$this->message->getSubject();
	$createdAt=$this->message->getCreatedAt();
	$msgText="\n\n\n";	
	$msgText.='-----Orijinal Text-----';
	$msgText.="\n";
	$msgText.='Kimdən:'.$this->to_username."\n";
	$msgText.='Tarix:'.$createdAt."\n\n";
	$msgText.=$this->message->getMsgText();
    $this->form->setDefaults(array('subject'=>$subject, 'from_userid' => $to_userid, 'to_userid' =>$from_userid, 'to_deltype'=>'0', 'from_deltype'=>'0', 'msgtext'=>$msgText));
    $this->setTemplate('edit');
  }
  public function executeEdit($request)
  {
    $this->form = new MessageForm(MessagePeer::retrieveByPk($request->getParameter('id')));
  }
  public function executeShowajax($request)
  {
    $page=$request->getParameter('page', 1);
    $this->fromuserid=$request->getParameter('fromuserid');
    $this->id=$request->getParameter('id');
    $this->message = MessagePeer::retrieveByPk($this->id);	
    $this->subject=$this->message->getSubject();
    $this->messages_pager=MessagePeer::getMessagesPager($this->subject, $this->fromuserid, $this->user_id, $page);

  }

  public function executeSent($request)
  {     
  }
 
  public function executeUpdate($request)
  {
    if ($this->getUser()->isAuthenticated())
    {	  
	  $this->forward404Unless($request->isMethod('post'));
	  //user id of the user whom the message is sent
	  //if this is a reply get message id
	  if($request->getParameter('id'))
	  { 
	    $this->id=$request->getParameter('id');
		$this->message = MessagePeer::retrieveByPk($request->getParameter('id'));
	    $this->to_userid=$this->message->getToUserId();
	    $this->to_username=$this->message->getsfGuardUserRelatedByFromUserid();
	    $from_userid=$this->message->getFromUserId();
	    $this->recepient = sfGuardUserPeer::retrieveByPk($from_userid);
	  }
	  else
	  {
	    $this->to_userid=$request->getParameter('to_userid');
	    $this->recepient = sfGuardUserPeer::retrieveByPk($this->to_userid);
	    $this->to_username=$this->recepient->getUsername();
	    
	  }
	  $recepient_email=$this->recepient->getEmail();
	  $from_user=sfGuardUserPeer::retrieveByPk( $this->user_id);
	 //extract name if exists
	  $from_user_name= $from_user->getProfile()->getName(); 
      $from_user_name= trim($from_user_name);
	  $from_user_username=$from_user->getUsername();	
      if(empty($from_user_name))
      {
	    $from_user_name=$from_user_username;
	  } 
	  
	  $this->form = new MessageForm();
      //$this->form = new MessageForm(MessagePeer::retrieveByPk($request->getParameter('id')));
      $this->form->bind($request->getParameter('message'));
      if ($this->form->isValid())
      {
        $message = $this->form->save();
		if(!empty($recepient_email))
		{
		  $this->sendMessageNotification($recepient_email, $from_user_name);
		}  
		//$this->redirect('message/sent');
                return 'After';       
      }
      
	  $this->setTemplate('edit');
     }
	 else
	 { 
	   return $this->forward('sfGuardAuth','signin');
	 }
  }
public function executeDeletefrominbox($request)
  {
    $this->forward404Unless($message = MessagePeer::retrieveByPk($request->getParameter('id')));
	$fromuserid=$request->getParameter('fromuserid');
    //if the other user has not deleted the same message from his/her sentbox
    $subject=$message->getSubject();
	$c=new Criteria();
	$c->add(MessagePeer::SUBJECT, $subject);
	$c->add(MessagePeer::FROM_USERID, $fromuserid);
	$c->add(MessagePeer::TO_USERID, $this->user_id);
	$msgs =MessagePeer::doSelect($c);
	foreach($msgs as $msg)    
	{
	  if($msg->getFromDeltype()==0)
	  {
        $msg->setToDeltype(1);
        $msg->save();
      }
	  else
	  {
	    $msg->delete();		
      }
	}
    $this->redirect('@user_inbox');
  }
  public function executeDeletefromsentbox($request)
  {
    $this->forward404Unless($message = MessagePeer::retrieveByPk($request->getParameter('id')));
	$toserid=$request->getParameter('touserid');
    //if the other user has not deleted the same message from his/her sentbox
    $subject=$message->getSubject();
	$c=new Criteria();
	$c->add(MessagePeer::SUBJECT, $subject);
	$c->add(MessagePeer::FROM_USERID, $this->user_id);
	$c->add(MessagePeer::TO_USERID, $toserid);
	$msgs =MessagePeer::doSelect($c);
	foreach($msgs as $msg)    
	{
	  if($msg->getToDeltype()==0)
	  {
        $msg->setFromDeltype(1);
        $msg->save();
      }
	  else
	  {
	    $msg->delete();		
      }
	}
    $this->redirect('@user_sentbox');
  }
  public function executeDelete($request)
  {
    $this->forward404Unless($message = MessagePeer::retrieveByPk($request->getParameter('id')));
	$delfrom=$request->getParameter('delfrom');
	//if message is in the inbox
    if($delfrom=='inbox')
    {
       //if the other user has not deleted the same message from his/her sentbox
       $fromdeltype=$message->getFromDeltype();
	   if($fromdeltype==0)
       {
          $message->setToDeltype(1);
		  $message->save();
	   }
       //if the other user already deleted it from sentbox
       else
	   {
	     $message->delete();
       }
	   $this->redirect('@user_inbox');
     }
	//if message is in the sentbox
    elseif($delfrom=='sentbox')
    {
      $todeltype=$message->getToDeltype();
      //if the other user has not deleted the same message from his/her inbox
      if($todeltype==0)
      {
        $message->setFromDeltype(1); 
        $message->save();
	  }
      //if the other user already deleted it from his/her inbox
      else
      {
	     $message->delete();
      }
	  $this->redirect('@user_sentbox');
	}	
  }
  public function executeDeletemessagesfrominbox(sfWebRequest $request)
  {
    $markdel=$request->getParameter('markdel');
    if(isset($markdel))
    {	  
      while(list($key, $value)=each($markdel))
      {
        $this->forward404Unless($message = MessagePeer::retrieveByPk($value));	    
	 //if message is in the inbox
        $subject=$message->getSubject();
        $fromuserid=$message->getFromuserid();
	$c=new Criteria();
	$c->add(MessagePeer::SUBJECT, $subject);
	$c->add(MessagePeer::FROM_USERID, $fromuserid);
	$c->add(MessagePeer::TO_USERID, $this->user_id);
	$msgs =MessagePeer::doSelect($c);
	foreach($msgs as $msg)    
	{
	  if($msg->getFromDeltype()==0)
	  {
            $msg->setToDeltype(1);
            $msg->save();
          }
	  else
	  {
	    $msg->delete();		
          }
	}
      }//end while		  
     }
     $this->redirect('@user_inbox');
  }
  public function executeDeletemessagesfromsentbox(sfWebRequest $request)
  {
    $markdel=$request->getParameter('markdel');
    if(isset($markdel))
    {	  
      while(list($key, $value)=each($markdel))
      {
        $this->forward404Unless($message = MessagePeer::retrieveByPk($value));	    
	 //if message is in the inbox
        $subject=$message->getSubject();
        $touserid=$message->getTouserid();
	$c=new Criteria();
	$c->add(MessagePeer::SUBJECT, $subject);
	$c->add(MessagePeer::FROM_USERID, $this->user_id);
	$c->add(MessagePeer::TO_USERID, $touserid);
	$msgs =MessagePeer::doSelect($c);
	foreach($msgs as $msg)    
	{
	  if($msg->getToDeltype()==0)
	  {
            $msg->setFromDeltype(1);
            $msg->save();
          }
	  else
	  {
	    $msg->delete();		
          }
	}
      }//end while		  
     }
     $this->redirect('@user_sentbox');
  }

  public function executeDeletemessages(sfWebRequest $request)
  {
    $markdel=$request->getParameter('markdel');
	$delfrom=$request->getParameter('fromfolder');
	if(isset($markdel))
	{	  
      while(list($key, $value)=each($markdel))
	  {
        $this->forward404Unless($message = MessagePeer::retrieveByPk($value));	    
	    //if message is in the inbox
        if($delfrom=='inbox')
        {
		  //if the other user has not deleted the same message from his/her sentbox
          $fromdeltype=$message->getFromDeltype();
	      if($fromdeltype==0)
          {
            $message->setToDeltype(1);
		    $message->save();
	      }
          //if the other user already deleted it from sentbox
          else
	      {
	        $message->delete();
          }	   
        }
	    //if message is in the sentbox
        elseif($delfrom=='sentbox')
        {
          $todeltype=$message->getToDeltype();
          //if the other user has not deleted the same message from his/her inbox
          if($todeltype==0)
          {
            $message->setFromDeltype(1); 
            $message->save();
	      }
          //if the other user already deleted it from his/her inbox
          else
          {
	        $message->delete();
          }	  
	    }
	  }//end while		  
	}
	$this->redirect('@user_'.$delfrom);
  }
  
  protected function sendMessageNotification($recepientemail, $from_name)
  {    
    ProjectConfiguration::registerZend();
    $tr = new Zend_Mail_Transport_Sendmail('-finfo@hemsinif.com');
    Zend_Mail::setDefaultTransport($tr);
    $mail = new Zend_Mail('utf-8');
	$mail->setBodyText(<<<EOF
    $from_name sizə hemsinif də məktub göndərib
	
    Bu məktuba aşağıdakı linkdə
   
    http://hemsinif.com/inbox 
        
    baxa bilərsiniz.
   
    Sag olun,
    hemsinif.com kollektivi.
EOF
);
      $mail->setFrom('info@hemsinif.com', 'hemsinif.com kollektivi');
      $mail->addTo($recepientemail);
      $mail->setSubject($from_name.' hemsinif.com da sizə məktub göndərib');
      $mail->send();
  }
}
