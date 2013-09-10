<?php

class sfGuardUserProfile extends BasesfGuardUserProfile
{
  public function getName()
  {
    $firstName=$this->getFirstName();
    $lastName=$this->getLastName();
	return $firstName.' '.$lastName;
  }
  public function getSex()
  {
    if($this->getGender()==1)
	  return 'Male';
	else
	  return 'Female';
  }
   public function getMaritalStatus()
  {
    if($this->getStatus()==1)
	  return 'Single';
	else if($this->getStatus()==2)
	  return 'In a realtionship';
	else if($this->getStatus()==3)
	  return 'Engaged';
	else if($this->getStatus()==4)
	  return 'Married';
	else if($this->getStatus()==5)
	  return 'It is complicated';
	else if($this->getStatus()==6)
	  return 'Divorced/Widowed';
	else 
	  return 0;
  }
  
public function save(PropelPDO $con = null)
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
 
 // remove an existing entry
 if ($hit = $index->find('pk:'.$this->getUserId()))
 {
   $index->delete($hit[0]->id);
 }
  $doc = new Zend_Search_Lucene_Document();
 
  // store user's primary key URL to identify it in the search results
   $doc->addField(Zend_Search_Lucene_Field::Keyword('pk', $this->getUserId()));
  //$doc->addField(Zend_Search_Lucene_Field::UnIndexed('pk', $this->getId()));
 
  // index profile fields  
  $doc->addField(Zend_Search_Lucene_Field::UnStored('first_name', $this->getFirstName(), 'utf-8'));
  $doc->addField(Zend_Search_Lucene_Field::UnStored('last_name', $this->getLastName(), 'utf-8'));
  $doc->addField(Zend_Search_Lucene_Field::UnStored('username', $this->getsfGuardUser()->getUsername(), 'utf-8'));
  $doc->addField(Zend_Search_Lucene_Field::Keyword('email', $this->getsfGuardUser()->getEmail(), 'utf-8')); 

 
  // add profile fields to the index
  $index->addDocument($doc);
  $index->optimize();
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

}