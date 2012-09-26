<?php
if (sfConfig::get('app_sf_guard_plugin_routes_register', false) && in_array('sfGuardAuth', sfConfig::get('sf_enabled_modules', array())))
{
  $this->dispatcher->connect('routing.load_configuration', array('sfGuardRouting', 'listenToRoutingLoadConfigurationEvent'));
}

foreach (array('sfGuardUser', 'sfGuardPermission') as $module)
{
  if (in_array($module, sfConfig::get('sf_enabled_modules')))
  {
    $this->dispatcher->connect('routing.load_configuration', array('sfGuardRouting', 'addRouteForAdmin'.str_replace('sfGuard', '', $module)));
  }
}