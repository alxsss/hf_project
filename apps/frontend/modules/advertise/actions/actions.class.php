<?php
// auto-generated by sfPropelCrud
// date: 2008/08/15 16:06:02
?>
<?php

/**
 * advertise actions.
 *
 * @package    fmpsv
 * @subpackage advertise
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class advertiseActions extends sfActions
{
  public function executeIndex()
  {
    return $this->forward('advertise', 'list');
  }

  public function executeList()
  {
    $this->advertises = AdvertisePeer::doSelect(new Criteria());
  }

  public function executeShow()
  {
    $this->advertise = AdvertisePeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->advertise);
  }

  public function executeCreate()
  {
    $this->advertise = new Advertise();

    $this->setTemplate('edit');
  }

  public function executeEdit()
  {
    $this->advertise = AdvertisePeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->advertise);
  }

  public function executeUpdate()
  {
    if (!$this->getRequestParameter('id'))
    {
      $advertise = new Advertise();
    }
    else
    {
      $advertise = AdvertisePeer::retrieveByPk($this->getRequestParameter('id'));
      $this->forward404Unless($advertise);
    }

    $advertise->setId($this->getRequestParameter('id'));
    $advertise->setAdvertiserName($this->getRequestParameter('advertiser_name'));
    $advertise->setCompany($this->getRequestParameter('company'));
    $advertise->setEmail($this->getRequestParameter('email'));
    $advertise->setPhone($this->getRequestParameter('phone'));
    $advertise->setComment($this->getRequestParameter('comment'));

    $advertise->save();

    return $this->redirect('advertise/show?id='.$advertise->getId());
  }

  public function executeDelete()
  {
    $advertise = AdvertisePeer::retrieveByPk($this->getRequestParameter('id'));

    $this->forward404Unless($advertise);

    $advertise->delete();

    return $this->redirect('advertise/list');
  }
}
