<?php
/**
 * Subclass for representing a row from the 'photo' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Photo extends BasePhoto
{
  public function __toString()
  {
    //return $this->getTitle();
  }
public function  removeFavPhoto($user_id)
{
  $c = new Criteria();
  $c->add(PhotoFavPeer::PHOTO_ID, $this->getId());
  $c->add(PhotoFavPeer::USER_ID, $user_id);
  PhotoFavPeer::doDelete($c);
}

public function delete(PropelPDO $con = null)
{
   //delete file from hard disk
  $uploadDirName='/uploads/assets';
  $uploadDir     = sfConfig::get('sf_web_dir').$uploadDirName;
  $photo_imageFile = $uploadDir.'/photos/normal/'.$this->getFilename();
  unlink($photo_imageFile);
  $thumbnailsDir = sfConfig::get('app_sfMediaLibrary_thumbnails_dir', 'thumbnail');
  $itemThumbnailFile = $uploadDir.'/photos/'.$thumbnailsDir.'/'.$this->getFilename();
  if (is_readable($itemThumbnailFile))
  {
     unlink($itemThumbnailFile);
  }
    //
  return parent::delete($con);
}
}
