<?php

/**
 * region actions.
 *
 * @package    hemsinif
 * @subpackage region
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class regionActions extends sfActions
{
  public function preExecute()
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	
      $this->subscriber = sfGuardUserPeer::retrieveByPk($this->user_id);
      $this->forward404Unless($this->subscriber);	 
	}
  }
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($this->region = RegionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
    $this->region_id=$request->getParameter('id');
	$c=new Criteria();
	$c->add(VillagePeer::REGION_ID, $this->region_id);
	$c->addAscendingOrderByColumn(VillagePeer::NAME);
	$this->villages = VillagePeer::doSelect($c);
	$this->form = new VillageForm();
	$this->form->setDefaults(array('region_id'=>$this->region_id));
  }
  public function executeCreatesubregion(sfWebRequest $request)
  {
    $this->forward404Unless($this->region = RegionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
	$this->region_id=$request->getParameter('id');
	$c=new Criteria();
	$c->add(VillagePeer::REGION_ID, $this->region_id);
	$c->addAscendingOrderByColumn(VillagePeer::NAME);
	$this->villages = VillagePeer::doSelect($c);
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new VillageForm();

    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
      $village = $this->form->save();
      $region_id=$this->form->getValue('region_id');
      $this->redirect('region/show?id='.$region_id);
    }
    //$this->setTemplate('new');
  }
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($region = RegionPeer::retrieveByPk($request->getParameter('id')), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
    $this->form = new RegionForm($region);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

 
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $region = $form->save();

      //$this->redirect('region/edit?id='.$region->getId());
	  $this->redirect('region/new');
    }
  }
}
