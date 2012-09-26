<?php

/**
 * home actions.
 *
 * @package    fmpsv
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class homeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->redirect('@updates');	  
	}
	else
	{
	  $this->regions=RegionPeer::doSelect(new Criteria());	
	  $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
      $this->form = new $class();
	  //$this->forward('default', 'module');
	}
  }
  public function executeHome(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
	  $this->redirect('@updates');	  
	}
	else
	{
	  //$this->regions=RegionPeer::doSelect(new Criteria());	
	  $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
      $this->form = new $class();
	  //$this->forward('default', 'module');
	}
  }
}
