<?php

/**
 * village actions.
 *
 * @package    hemsinif
 * @subpackage village
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class villageActions extends sfActions
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
    $this->forward404Unless($this->village = VillagePeer::retrieveByPk($request->getParameter('id')), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
   	$this->village_id=$request->getParameter('id');
	$c=new Criteria();
	$c->add(SchoolPeer::VILLAGE_ID, $this->village_id);
	$c->addAscendingOrderByColumn('CAST(NAME AS UNSIGNED)');
	$this->schools = SchoolPeer::doSelect($c);
    $this->form = new SchoolForm();
	$this->form->setDefaults(array('village_id'=>$this->village_id));
  }
   public function executeCreateschool(sfWebRequest $request)
  {
    $this->forward404Unless($this->village = VillagePeer::retrieveByPk($request->getParameter('id')), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
	$this->village_id=$request->getParameter('id');
	$c=new Criteria();
	$c->add(SchoolPeer::VILLAGE_ID, $this->village_id);
	$c->addAscendingOrderByColumn(SchoolPeer::NAME);
	$this->schools = SchoolPeer::doSelect($c);
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new SchoolForm();

    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
      $village = $this->form->save();
      $village_id=$this->form->getValue('village_id');
      $this->redirect('village/show?id='.$village_id);
    }
    //$this->setTemplate('new');
  }
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($village = VillagePeer::retrieveByPk($request->getParameter('id')), sprintf('Object village does not exist (%s).', $request->getParameter('id')));
    $this->form = new VillageForm($village);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $village = $form->save();

      $this->redirect('village/edit?id='.$village->getId());
    }
  }
}
