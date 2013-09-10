<?php

class myUser extends sfSocialSecurityUser //sfGuardSecurityUser
{
  public function getSubscriberId()
  {
    return $this->getAttribute('user_id', '', 'sfGuardSecurityUser');
  }
  
  public function isAuthenticated()
  {
    if (!$this->authenticated)
    {      
      if($cookie = sfContext::getInstance()->getRequest()->getCookie(sfConfig::get('app_sf_guard_plugin_remember_cookie_name', 'hemsinifRememberMe')))
      {
        $c = new Criteria();
        $c->add(sfGuardRememberKeyPeer::REMEMBER_KEY, $cookie);
        $rk = sfGuardRememberKeyPeer::doSelectOne($c);
        if ($rk && $rk->getSfGuardUser())
        {
          $this->signIn($rk->getSfGuardUser());
        }
      }
    }
    
    return $this->authenticated;
  }

}
