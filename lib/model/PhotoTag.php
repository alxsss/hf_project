<?php

/**
 * Subclass for representing a row from the 'photo_tag' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PhotoTag extends BasePhotoTag
{
  public function setTag($v)
  {
    parent::setTag($v);
    $this->setNormalizedTag(Tag::normalize($v));
  }
  public static function getTagsForUserAndPhoto($photo_id, $user_id, $tag)
  {
    $con = Propel::getConnection();
    $stmt = $con->prepare("select distinct tag from photo_tag where user_id=$user_id and photo_id=$photo_id and tag='$tag' ");
    $stmt->execute();
    $tags = array();
    while ($rs=$stmt->fetch(PDO::FETCH_OBJ))
    {
      $tags[] = $rs->tag;
    } 
    return $tags;
  }
  
  public function save(PropelPDO $con = null)
{
  // ...
 
  if (is_null($con))
  {
    $con = Propel::getConnection(PhotoTagPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
  $index = PhotoPeer::getLuceneIndex();
 
  // remove an existing entry
  if ($hit = $index->find('pk:'.$this->getPhotoId()))
  {
    $index->delete($hit[0]->id);
  }
 
  
  $doc = new Zend_Search_Lucene_Document();
 
  // store photos primary key URL to identify it in the search results
  $doc->addField(Zend_Search_Lucene_Field::Keyword('pk', $this->getPhotoId()));
 
  // index tag fields
  $doc->addField(Zend_Search_Lucene_Field::UnStored('tag', $this->getTag(), 'utf-8'));
  $doc->addField(Zend_Search_Lucene_Field::UnStored('title', $this->getPhoto()->getTitle(), 'utf-8'));

  // add tag to the index
  $index->addDocument($doc);
  $index->commit();
} 
  
}