<?php
class PhotoRate extends BasePhotoRate
{
 
  public function getRateString()
  {
    if($this->getRate()==5)
	  echo '<span style="color:#FF0000"><h1>'.$this->getRate().'</h1><h4>'.__('gorgeus').'</h4></span>';	  
	else if($this->getRate()==4)
	  echo '<span style="color:#FF9933"><h1>'.$this->getRate().'</h1><h4>'.__('good').'</h4></span>';	  
	else if($this->getRate()==3)
	  echo '<span style="color:#00FF66"><h1>'.$this->getRate().'</h1><h4>'.__('regular').'</h4></span>';	  
	else if($this->getRate()==2)
	  echo '<span style="color:#999999"><h1>'.$this->getRate().'</h1><h4>'.__('poor').'</h4></span>';	  
	else if($this->getRate()==1)
	  echo '<span style="color:#333333"><h1>'.$this->getRate().'</h1><h4>'.__('bad').'</h4></span>';	  
  }    
  public function save(PropelPDO  $con = null)
  {
    $ret = parent::save($con);
    //update rating column in photo table
    $photo = $this->getPhoto();
    $rates = $photo->getRating();
    $photo->setRating($rates + 1);
    $photo->save($con);
    return $ret;
 }
  //this function is called when a user looks in ratings page and we do not need to update rate column in photo table in this case
   public function save_checked(PropelPDO  $con = null)
  {
    $ret = parent::save($con);
    return $ret;
 }
 

}
