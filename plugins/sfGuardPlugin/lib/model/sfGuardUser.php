<?php
/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUser.php 9999 2008-06-29 21:24:44Z fabien $
 */
class sfGuardUser extends sfSocialGuardUser 
{
  public function __toString()
  {
    return $this->getUsername();
  }

  public function getFriendsIdArray()
  {
    $c=new Criteria();
    $c->add(FriendPeer::APPROVED,1);
    $friendsIdArray=array();
    $friends = $this->getFriendsRelatedByUserId($c);
    $friendsAsFriendids = $this->getFriendsRelatedByFriendId($c);
    foreach($friends as $friend)
    {
      $friendsIdArray[]=$friend->getFriendId();
    }
    foreach($friendsAsFriendids as $friend)
    {
      $friendsIdArray[]=$friend->getUserId();
    }
    return $friendsIdArray;
  }

//get only one last session of a user
  public function getSession($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSessionss === null) {
			if ($this->isNew()) {
			   $this->collSessionss = array();
			} else {

				$criteria->add(SessionsPeer::USER_ID, $this->id);
                $criteria->addDescendingOrderByColumn(SessionsPeer::SESS_TIME);  
				SessionsPeer::addSelectColumns($criteria);
				
				$this->collSessionss = SessionsPeer::doSelectOne($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SessionsPeer::USER_ID, $this->id);
                $criteria->addDescendingOrderByColumn(SessionsPeer::SESS_TIME);  
				SessionsPeer::addSelectColumns($criteria);
				if (!isset($this->lastSessionsCriteria) || !$this->lastSessionsCriteria->equals($criteria)) {
					$this->collSessionss = SessionsPeer::doSelectOne($criteria, $con);
				}
			}
		}
		$this->lastSessionsCriteria = $criteria;
		return $this->collSessionss;
	}
  public function countInboxMessages()
  {
    $c=new Criteria();
	$c->add(MessagePeer::READ_UNREAD, 0);
	$c->add(MessagePeer::TO_DELTYPE, 0);
	return parent::countMessagesRelatedByToUserid($c);   
  }
   public function count_num_friend_requests()
  {
    $c_a0=new Criteria();
	$c_a0->add(FriendPeer::APPROVED,0);
	return parent::countFriendsRelatedByFriendId($c_a0);  
  }
   public function count_group_invites()
  {
    $c=new Criteria();
	$c->add(sfSocialGroupInvitePeer::REPLIED,0);
	return parent::countsfSocialGroupInvitesRelatedByUserId($c);  
  }
   public function count_event_invites()
  {
    $c=new Criteria();
	$c->add(sfSocialEventInvitePeer::REPLIED,0);
	return parent::countsfSocialEventInvitesRelatedByUserId($c);  
  }
  public function getGroupInvites()
  {
     $c=new Criteria();
     $c->add(sfSocialGroupInvitePeer::REPLIED,0);
     return $this->getsfSocialGroupInvitesRelatedByUserId($c);
  }
   public function getEventInvites()
  {
     $c=new Criteria();
     $c->add(sfSocialEventInvitePeer::REPLIED,0);
     return $this->getsfSocialEventInvitesRelatedByUserId($c);
  }
   public function getFriendsRequested()
  {
      $c_a0=new Criteria();
	  $c_a0->add(FriendPeer::APPROVED,0);
	  return $this->getFriendsRelatedByFriendId($c_a0);
  }
  public function count_num_guests()
  {
    $c=new Criteria();
	$c->add(GuestPeer::CHECKED,0);
	return parent::countGuestsRelatedByUserId($c);  
  }
  public function count_num_rates()
  {
    $c=new Criteria();
    $c->add(PhotoPeer::USER_ID, $this->id);  
    $c->add(PhotoRatePeer::CHECKED,0);
	$c->add(PhotoRatePeer::DELETED,0);
    $num_photo_rates= PhotoRatePeer::doCountJoinPhoto($c);
   	return $num_photo_rates;  
  }
	//this function returns the first album created when registering
  public function getAlbum($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'lib/model/om/BaseAlbumPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAlbums === null) {
			if ($this->isNew()) {
			   $this->collAlbums = array();
			} else {
				$criteria->add(AlbumPeer::USER_ID, $this->getId());
                //$criteria->addDescendingOrderByColumn(AlbumPeer::ID); 
				$criteria->addAscendingOrderByColumn(AlbumPeer::ID);  
				AlbumPeer::addSelectColumns($criteria);
				$this->collAlbums = AlbumPeer::doSelectOne($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.
				$criteria->add(AlbumPeer::USER_ID, $this->getId());
                $criteria->addAscendingOrderByColumn(AlbumPeer::ID);
				AlbumPeer::addSelectColumns($criteria);
				if (!isset($this->lastAlbumCriteria) || !$this->lastAlbumCriteria->equals($criteria)) {
					$this->collAlbums = AlbumPeer::doSelectOne($criteria, $con);
				}
			}
		}
		$this->lastAlbumCriteria = $criteria;
		return $this->collAlbums;
	}

	//functions related to friend search and registration
	//do not use this function, since we needed last login, which was not working with this function
  public function save_index(PropelPDO $con = null)
{
  // ...
  if (is_null($con))
  {
    $con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
  }
  $con->beginTransaction();
  try
  {
    $ret = parent::save($con);
 
    $this->updateLuceneIndex();     
	
    $con->commit();
    return $ret;
  }
  catch (Exception $e)
  {
    $con->rollBack();
    throw $e;
  }
}
public function updateLuceneIndex()
{
  $index = sfGuardUserPeer::getLuceneIndex();
  //added these two line to correct bug
  //$term  = new Zend_Search_Lucene_Index_Term($this->getId(), 'pk');
  //$query = new Zend_Search_Lucene_Search_Query_Term($term);
  // remove an existing entry
 if ($hit = $index->find('pk:'.$this->getId()))
 //if ($hit = $index->find($query))
  {
    $index->delete($hit[0]->id);
  }
  $doc = new Zend_Search_Lucene_Document();
  // store user's primary key URL to identify it in the search results
   $doc->addField(Zend_Search_Lucene_Field::Keyword('pk', $this->getId()));
  //$doc->addField(Zend_Search_Lucene_Field::UnIndexed('pk', $this->getId()));
  $doc->addField(Zend_Search_Lucene_Field::UnStored('username', $this->getUsername(), 'utf-8'));
  //$doc->addField(Zend_Search_Lucene_Field::UnStored('email', $this->getEmail(), 'utf-8'));
  $doc->addField(Zend_Search_Lucene_Field::Keyword('email', $this->getEmail(), 'utf-8')); 
  // add job to the index
  $index->addDocument($doc);
  $index->commit();
}
public function delete(PropelPDO $con = null)
{
  $index = sfGuardUserPeer::getLuceneIndex(); 
  if ($hit = $index->find('pk:'.$this->getId()))
  {
    $index->delete($hit[0]->id);
  } 
  return parent::delete($con);
}
/**	selects only one result */
	public function getStatus($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}
		if ($this->collsfGuardUserStatuss === null) {
			if ($this->isNew()) {
			   $this->collsfGuardUserStatuss = array();
			} else {
				$criteria->add(sfGuardUserStatusPeer::USER_ID, $this->id);
                $criteria->addAscendingOrderByColumn(sfGuardUserStatusPeer::CREATED_AT); 
				sfGuardUserStatusPeer::addSelectColumns($criteria);
				$this->collsfGuardUserStatuss = sfGuardUserStatusPeer::doSelectOne($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.
				$criteria->add(sfGuardUserStatusPeer::USER_ID, $this->id);
                $criteria->addAscendingOrderByColumn(sfGuardUserStatusPeer::CREATED_AT); 
    			sfGuardUserStatusPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardUserStatusCriteria) || !$this->lastsfGuardUserStatusCriteria->equals($criteria)) {
					$this->collsfGuardUserStatuss = sfGuardUserStatusPeer::doSelectOne($criteria, $con);
				}
			}
		}
		$this->lastsfGuardUserStatusCriteria = $criteria;
		return $this->collsfGuardUserStatuss;
	}	
 public function isFriend($friend_id, $list=false)
 {
    $c= new Criteria();
	/* OR STATEMENT*/
	$c1 = $c->getNewCriterion(FriendPeer::USER_ID, $this->id);
	$c12 = $c->getNewCriterion(FriendPeer::FRIEND_ID,  $friend_id);
	$c1->addAnd($c12);
	$c2 = $c->getNewCriterion(FriendPeer::USER_ID, $friend_id);
	$c22 = $c->getNewCriterion(FriendPeer::FRIEND_ID,  $this->id);
	$c2->addAnd($c22);
	$c1->addOr($c2);
    $c->add($c1);
	$c->add(FriendPeer::APPROVED,1);	
	$friend = FriendPeer::doSelect($c);
	if($list)
	{
	  return $friend;
	}
	if(empty($friend))
	  return false;
	else
	  return true; 
 }
 //this function includes friends that are not approved
 public function isFriendNotApproved($friend_id, $list=false)
 {
    $c= new Criteria();
	/* OR STATEMENT*/
	$c1 = $c->getNewCriterion(FriendPeer::USER_ID, $this->id);
	$c12 = $c->getNewCriterion(FriendPeer::FRIEND_ID,  $friend_id);
	$c1->addAnd($c12);
	$c2 = $c->getNewCriterion(FriendPeer::USER_ID, $friend_id);
	$c22 = $c->getNewCriterion(FriendPeer::FRIEND_ID,  $this->id);
	$c2->addAnd($c22);
	$c1->addOr($c2);
    $c->add($c1);	
	$friend = FriendPeer::doSelect($c);
	if($list)
	{
	  return $friend;
	}
	if(empty($friend))
	  return false;
	else
	  return true; 
 }
 public function isIgnored($user_id)
 {
    $c= new Criteria();
	$c->add(IgnorelistPeer::USER_ID, $this->id);
	$c->add(IgnorelistPeer::IGNORED_USER_ID, $user_id);
	$ignored_user =IgnorelistPeer::doSelect($c);
	if(empty($ignored_user))
	  return false;
	else
	  return true; 
 }
 public function getSchoolUser()
  {
    /*if (!is_null($this->schoolUser))
    {
      return $this->schoolUser;
    }*/
    $schoolUserClass = 'SchoolUser';
    if (!class_exists($schoolUserClass))
    {
      throw new sfException(sprintf('The user schoolUser class "%s" does not exist.', $schoolUserClass));
    }
    $fieldName = 'user_id';
    $schoolUserPeerClass =  $schoolUserClass.'Peer';
    // to avoid php segmentation fault
    class_exists($schoolUserPeerClass);
    $foreignKeyColumn = call_user_func_array(array($schoolUserPeerClass, 'translateFieldName'), array($fieldName, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_COLNAME));
    if (!$foreignKeyColumn)
    {
      throw new sfException(sprintf('The user schoolUser class "%s" does not contain a "%s" column.', $schoolUserClass, $fieldName));
    }
    $c = new Criteria();
    $c->add($foreignKeyColumn, $this->getId());
	$this->schoolUser = call_user_func_array(array($schoolUserClass.'Peer', 'doSelectOne'), array($c));
    if (!$this->schoolUser)
    {
      $this->schoolUser = new $schoolUserClass();
      if (method_exists($this->schoolUser, 'setsfGuardUser'))
      {
        $this->schoolUser->setsfGuardUser($this);
      }
      else
      {
        $method = 'set'.call_user_func_array(array($schoolUserPeerClass, 'translateFieldName'), array($fieldName, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_PHPNAME));
        $this->schoolUser->$method($this->getId());
      }
    }
    return $this->schoolUser;
  }
 
}
