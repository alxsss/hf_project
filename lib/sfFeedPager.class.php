<?php


class sfFeedPager extends sfPager
{
  protected
    $count=0;
    
  public function __construct($class, $maxPerPage = 10, $count)
  {
    parent::__construct($class, $maxPerPage);
    $this->setNbResults($count);   
  }

  public function init()
  {
    $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
    $maxRecordLimit = $this->getMaxRecordLimit();
    $count=$this->getNbResults();
    $this->setNbResults($hasMaxRecordLimit ? min($count, $maxRecordLimit) : $count);

    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
      $this->setLastPage(0);
    }
    else
    {
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
      $offset = ($this->getPage() - 1) * $this->getMaxPerPage();
      if ($hasMaxRecordLimit)
      {
        $maxRecordLimit = $maxRecordLimit - $offset;
       
      }     
    }
  }

  protected function retrieveObject($offset)
  {
    
  }

  public function getResults()
  {
    
  }

   
}
