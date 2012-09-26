<?php

/**
 * school actions.
 *
 * @package    hemsinif
 * @subpackage school
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class schoolActions extends sfActions
{
  public function executeList(sfWebRequest $request)
  {
      $this->regions=RegionPeer::doSelect(new Criteria());
	  $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
      $this->form = new $class();	 
  }

 
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($this->school = SchoolPeer::retrieveByPk($request->getParameter('id')), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
    $c=new Criteria();
	$c->add(SchoolPeer::VILLAGE_ID, $request->getParameter('id'));
	$this->schools = SchoolPeer::doSelect($c);
  }
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($school = SchoolPeer::retrieveByPk($request->getParameter('id')), sprintf('Object school does not exist (%s).', $request->getParameter('id')));
    $this->form = new SchoolForm($school);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

 
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $school = $form->save();

      $this->redirect('school/edit?id='.$school->getId());
    }
  }
}
