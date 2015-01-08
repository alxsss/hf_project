<?php

/**
 * photos actions.
 *
 * @package    fmpsv
 * @subpackage photos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 8507 2008-04-17 17:32:20Z fabien $
 */
class photosActions extends sfActions
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
  public function executeIndex()
  { 
    $this->page=$this->getRequestParameter('page', 1); 
       $this->popular_photos = PhotoPeer::getNewPhotosPager($this->page);
   /* 
     $memcache = new Memcache();
     $memcache->connect('127.0.0.1', 11211);// or die ("Could not connect");
      //set the key then check the cache
     $key = md5("photo_index".$this->page);
     $get_result = $memcache->get($key);
     if($get_result)
     {
       $this->popular_photos =  $get_result;
     }
     else
     {
       // Run the query and get the data from the database then cache it
       $this->popular_photos = PhotoPeer::getNewPhotosPager($this->page);
       $memcache->set($key, $this->popular_photos, TRUE, 200000); // Store the result of the query for 200000 seconds
     }
   */
    $this->processSort();
    $this->popular_photos = PhotoPeer::getNewPhotosPager($this->page);
    $c = new Criteria();
    $this->addSortCriteria($c);
    $c->add(PhotoPeer::APPROVED, 1);
    $c->add(PhotoPeer::POPULAR_PHOTO, 1);
    $c->add(PhotoPeer::VISIBILITY, 0);
    $c->addDescendingOrderByColumn(PhotoPeer::CREATED_AT);
    $this->popular_photos->setCriteria($c);
    $this->popular_photos->setPage($this->getRequestParameter('page', $this->getUser()->getAttribute('page', 1, 'photo')));
    $this->popular_photos->init();
    // save page
    if ($this->getRequestParameter('page')) {$this->getUser()->setAttribute('page', $this->getRequestParameter('page'), 'photo');} 	
  }

  public function executePopularphotos()
  { 
    $this->page=$this->getRequestParameter('page', 1); 
    $this->processSort();
    $this->popular_photos = PhotoPeer::getPopularPhotosPager($this->page);
	$c = new Criteria();
    $this->addSortCriteria($c);
	$c->add(PhotoPeer::APPROVED, 1);
    $c->add(PhotoPeer::POPULAR_PHOTO, 1);
    $c->add(PhotoPeer::VISIBILITY, 0);
    $c->addDescendingOrderByColumn(PhotoPeer::RATING);
    $this->popular_photos->setCriteria($c);
    $this->popular_photos->setPage($this->getRequestParameter('page', $this->getUser()->getAttribute('page', 1, 'photo')));
    $this->popular_photos->init();
    // save page
    if ($this->getRequestParameter('page')) {$this->getUser()->setAttribute('page', $this->getRequestParameter('page'), 'photo');} 	
  }
  protected function processSort()
  {
    if ($this->getRequestParameter('sort'))
    {
      $this->getUser()->setAttribute('sort', $this->getRequestParameter('sort'), 'photo/sort');
      $this->getUser()->setAttribute('type', $this->getRequestParameter('type', 'asc'), 'photo/sort');
    }

    if (!$this->getUser()->getAttribute('sort', null, 'photo/sort'))
    {
    }
  }
  
   protected function addSortCriteria($c)
  {
    if ($sort_column = $this->getUser()->getAttribute('sort', null, 'photo/sort'))
    {
      $sort_column = sfInflector::camelize(strtolower($sort_column));
      $sort_column = PhotoPeer::translateFieldName($sort_column, BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
      if ($this->getUser()->getAttribute('type', null, 'photo/sort') == 'asc')
      {
        $c->addAscendingOrderByColumn($sort_column);
      }
      else
      {
        $c->addDescendingOrderByColumn($sort_column);
      }
    }
  }
  public function executeRate($request)
  {
    $this->photo= PhotoPeer::retrieveByPk($this->getRequestParameter('photo_id'));
    $this->forward404Unless($this->photo); 
    $rate=$request->getParameter('rate');    
    $photoRate = new PhotoRate();
    $photoRate->setPhoto($this->photo);
    $photoRate->setUserId($this->user_id);
    $photoRate->setRate($rate);
    $photoRate->save();
  }
  public function executeRatings($request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->rated_photos_pager=PhotoRatePeer::getPhotoRatingPager($this->getRequestParameter('page', 1), $this->user_id);	
	}
	else
	{
	  return $this->forward('sfGuardAuth','signin');
	}
  }
  public function executeDeleterating(sfWebRequest $request)
  {
    $markdel=$request->getParameter('markdel');
	if(isset($markdel))
	{	  
      while(list($key, $value)=each($markdel))
	  {
        $this->forward404Unless($rating = PhotoRatePeer::retrieveByPK($value, $key));	
		//do not delete in order not to allow to the same user to rate again    
	    $rating->setDeleted(1);
		$rating->save();         
      }	     
	}
	$this->redirect('@ratings');
  }
  public function executeCreate()
  {
    $this->form = new PhotoForm();
    $this->setTemplate('edit');
  }

  public function executeEdit($request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->form = new PhotoForm(PhotoPeer::retrieveByPk($request->getParameter('id')));
	  $this->photo = PhotoPeer::retrieveByPk($this->getRequestParameter('id'));
	  $this->forward404Unless($this->photo);
	  //$photo_user_id=$this->photo->getAlbum()->getUserId();
	  $photo_user_id=$this->photo->getUserId();
	  if($photo_user_id!=$this->user_id)
      {
	    $this->redirect('photos/show?id='.$this->getRequestParameter('id'));
	  }
	  $this->albumForm = new AlbumForm();
	  $this->albumForm->setDefaults(array('user_id'=>$this->user_id));
	}
	else
	{
	  $this->redirect('@homepage');
	} 
	  
  }
  public function executeList()
   { 
    $this->page=$this->getRequestParameter('page', 1); 
    $this->photo_owner = sfGuardUserPeer::retrieveByUsername($this->getRequestParameter('username'));
    $this->forward404Unless($this->photo_owner);
    //id of a user whose photos are retrived
    $photo_owner_user_id=$this->photo_owner->getId();
    $this->photos=PhotoPeer::getAllPhotosPager($this->page, $photo_owner_user_id); 
    //id of a user who signed in
    $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	
   }
	
   public function executeUpdate($request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new PhotoForm(PhotoPeer::retrieveByPk($request->getParameter('id')));

    $this->form->bind($request->getParameter('photo'));
    if ($this->form->isValid())
    {
      $photo = $this->form->save();
      //$this->redirect('photos/edit?id='.$photo->getId());
	  //$this->logMessage('checking delete indexes before deleting');
	  $this->redirect('photos/show?id='.$photo->getId());
    }
    $this->albumForm = new AlbumForm();
    $this->setTemplate('edit');
  }

  public function executeDelete($request)
  {
    $this->forward404Unless($photo = PhotoPeer::retrieveByPk($request->getParameter('id')));
    $photo->delete();	
	if($photo->getAlbumId())
	{
	  $this->redirect('albums/show?id='.$photo->getAlbumId());
	}
	else
	{ 
	  $this->redirect('user/'.$photo->getsfGuardUser()->getUsername());
	}
  }  
  
  public function executeAddComment(sfWebRequest $request)
  {
    if ($this->getRequest()->getMethod() == sfRequest::POST)
    {
      $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
      $this->photos = PhotoPeer::retrieveByPk($request->getParameter('item_id'));
      $this->forward404Unless($this->photos);
      $photo_user_id=$request->getParameter('item_user_id');	;//$this->photos->getUserId();
      $comment_body=$request->getParameter('comment');
      if (!empty($comment_body))
      {
        // create answer
        $this->comment = new PhotoComment();
        $this->comment->setPhoto($this->photos);
        $this->comment->setComment($comment_body);
        $this->comment->setUserId($this->user_id);
        $this->comment->save();        
        $user=sfGuardUserPeer::retrieveByPk($this->user_id);
        $photo_owner_user = sfGuardUserPeer::retrieveByPk($photo_user_id);
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
        $usernames_comment_users=array();
        //send emails to users of previous comments 
        foreach($this->photos->getPhotoComments() as $comment)
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
	      $this->sendPhotoComment(trim($email),$usernames_comment_users_unique_exOwn[$i],  $this->name, $request->getParameter('item_id'));
             }
          }	  
          //if the user is not the owner of the photo, send email to owner
	  if($this->user_id!=$photo_user_id)
          {	   
            $email=$photo_owner_user->getEmail();
            if(!empty($email))
	    {
              $recepient_username=$photo_owner_user->getUsername();
              $url='http://hemsinif.com/az/photos/show/id/'.$request->getParameter('item_id');
	      $subject=$this->name.' hemsinif.com da sizin şəkilinizə rəyini bildirdi';
              $body=<<<EOF
Salam $recepient_username,

$this->name, hemsinif.com da sizin şəkilinizə rəyini bildirdi.  Ona  bu linkdə 

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
	   }//end empty(email)
	  }
	}//end if body
   return sfView::SUCCESS;
  } 
}
 public function executeDeleteComment()
 {
    if (!$this->getRequestParameter('id'))
    {
      return sfView::NONE;
    }
    $this->comment = PhotoCommentPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->comment);
    $this->comment->delete();
    $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	  
}   
   public function executeAllfavphotos()
  { 
    $this->subscriber = sfGuardUserPeer::retrieveByUsername($this->getRequestParameter('username'));
    $this->forward404Unless($this->subscriber);
    $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
    $this->photos_pager = PhotoFavPeer::getAllFavPhotoPager($this->getRequestParameter('page', 1),  $this->subscriber->getId());
  }
  public function executeFavorite()
  {
    $this->photo= PhotoPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->photo);
    $user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');     
    $photoFav = new PhotoFav();
    $photoFav->setPhoto($this->photo);
    $photoFav->setUserId($user_id);
    $photoFav->save();
  }
  
   public function executeDeletefavphoto()
  {
    $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
    $this->fav_photo = PhotoFavPeer::retrieveByPk($this->getRequestParameter('id'), $this->user_id);
    $this->forward404Unless($this->fav_photo);
    $this->forward404Unless($this->user_id==$this->fav_photo->getUserId());
    $this->fav_photo->delete();
  }
 
   public function executeShow()
   {
     $this->photos = PhotoPeer::retrieveByPk($this->getRequestParameter('id'));
     $this->photo_id=$this->getRequestParameter('id');
     $this->forward404Unless($this->photos);
     $this->photo_user_id=$this->photos->getUserId();
     //get all paged photos beloging to the user $this->photo_user_id
     $this->photos_pager=PhotoPeer::getShowPhotoPager($this->photo_user_id);
     $this->photo_user = sfGuardUserPeer::retrieveByPk($this->photo_user_id);
     //define this here if user is not signed in in order not to get undefined user_id notice
     $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	 
   }
   public function executeShownew()
   {
     $this->photo_id=$this->getRequestParameter('id');
     $this->photo=PhotoPeer::retrieveByPk($this->photo_id);
     $this->forward404Unless($this->photo);
     $this->photo_user_id=$this->photo->getUserId();
     //get all new photos pages
     $this->photos_pager=PhotoPeer::getShownewPhotoPager();
     $this->photo_user = sfGuardUserPeer::retrieveByPk($this->photo_user_id);
     //define this here if user is not signed in in order not to get undefined user_id notice
     $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	 
   }
   public function executeShowpopular()
   {
     $this->photo_id=$this->getRequestParameter('id');
     $this->photo=PhotoPeer::retrieveByPk($this->photo_id);
     $this->forward404Unless($this->photo);
     $this->photo_user_id=$this->photo->getUserId();
     //get all new photos pages
     $this->photos_pager=PhotoPeer::getShowpopularPhotoPager();
     $this->photo_user = sfGuardUserPeer::retrieveByPk($this->photo_user_id);
     //define this here if user is not signed in in order not to get undefined user_id notice
     $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	 
   }
   public function executeShowalbumphoto()
   {
     $this->photos = PhotoPeer::retrieveByPk($this->getRequestParameter('id'));
     $this->forward404Unless($this->photos);
	 //define this here if user is not signed in in order not to ger undefined user_id notice
	 $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
	 if ($this->getUser()->isAuthenticated())
     {
	   $this->c=1;
	 }
	 else
	 {
	   $this->c=0;
	 }
   }
   public function executeAddalbum($request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new AlbumForm();
    //this done because data comes from jquery post ajax request
    $album_array=$request->getParameter('album_data');
    $album=array();
    $album['title']=$album_array[0]['value'];
    $album['description']=$album_array[1]['value'];
    $album['visibility']=$album_array[2]['value'];
    $album['user_id']=$album_array[3]['value'];   
    $album['id']=$album_array[4]['value'];

    $this->form->bind($album);
    if ($this->form->isValid())
    {
      $album = $this->form->save();

      //$this->redirect('photos/edit?id='.$this->getRequestParameter('id'));
    }
    $this->photoForm = new PhotoForm();
    //$this->photoForm = new PhotoForm(PhotoPeer::retrieveByPk($request->getParameter('id')));
    //$this->redirect('photos/edit?id='.$this->getRequestParameter('id'));
   // $this->setTemplate('edit');
  }
 protected function  sendPhotoComment($email, $recepient_name,  $name, $photo_id)
 {
    $url='http://hemsinif.com/az/photos/show/id/'.$photo_id;
	$subject=$name.' hemsinif.com da sizin rəyinizdən sonra oz rəyini bildirdi';
    $body=<<<EOF
Salam $recepient_name,

$name, hemsinif.com da sizin rəyinizdən sonra oz rəyini 
bildirdi.  Ona bu linkdə
  
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
 
  public function executeSearch(sfWebRequest $request)
  {
    if (!$query = $request->getParameter('query'))
    {
      return $this->redirect('@recent_photos');
    } 
    $this->photos = PhotoPeer::getForLuceneQuery($query);
  }
}
