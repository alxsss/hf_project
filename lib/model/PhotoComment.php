<?php

/**
 * Subclass for representing a row from the 'photo_comment' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PhotoComment extends BasePhotoComment
{
  //override photoComment's save function to increment num_comment valuer in photo table
  public function save(PropelPDO  $con = null)
  {
    $ret = parent::save($con);
    //update num_comment column in photo table
    $photo = $this->getPhoto();
    $num_comment = $photo->getNumComment();
    $photo->setNumComment($num_comment + 1);
    $photo->save($con);
    return $ret;
 }
  public function delete(PropelPDO  $con = null)
  {
    $ret = parent::delete($con);
    //update num_comment column in photo table
    $photo = $this->getPhoto();
    $num_comment = $photo->getNumComment();
    $photo->setNumComment($num_comment - 1);
    $photo->save($con);
    return $ret;
 }

}
