<?php

/**
 * Subclass for representing a row from the 'photo_vote' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PhotoVote extends BasePhotoVote
{
  public function save(PropelPDO  $con = null)
 {  
    $ret = parent::save($con); 
    // update interested_users in question table
    $photo = $this->getPhoto();
    $votes = $photo->getVote();
    $photo->setVote($votes + 1);
    $photo->save($con); 
    return $ret;
 }
}
