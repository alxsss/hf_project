<?php

/**
 * Subclass for representing a row from the 'album' table.
 *
 * 
 *
 * @package lib.model
 */ 
 
class Album extends BaseAlbum
{
  public function __toString()
  {
    return $this->getTitle();
  }
public function getPhotos($criteria = null, PropelPDO $con = null)
	{
		$c=new Criteria(AlbumPeer::DATABASE_NAME);
		$c->addDescendingOrderByColumn(PhotoPeer::CREATED_AT);
		return parent::getPhotos($c, $con); 
		
	}

  public function getLastPhoto($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'lib/model/om/BasePhotoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPhotos === null) {
			if ($this->isNew()) {
			   $this->collPhotos = array();
			} else {

				$criteria->add(PhotoPeer::ALBUM_ID, $this->getId());
				$criteria->addDescendingOrderByColumn(PhotoPeer::CREATED_AT);  
                
				PhotoPeer::addSelectColumns($criteria);
				$this->collPhotos = PhotoPeer::doSelectOne($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PhotoPeer::ALBUM_ID, $this->getId());

				PhotoPeer::addSelectColumns($criteria);
				if (!isset($this->lastPhotoCriteria) || !$this->lastPhotoCriteria->equals($criteria)) {
					$this->collPhotos = PhotoPeer::doSelectOne($criteria, $con);
				}
			}
		}
		$this->lastPhotoCriteria = $criteria;
		return $this->collPhotos;
	}

}
