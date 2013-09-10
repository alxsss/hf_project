<?php
/**
 * Subclass for performing query and update operations on the 'sf_polls' table.
 *
 * @package plugins.sfPropelPollsPlugin.lib.model
 */ 
class sfPollPeer extends BasesfPollPeer
{
  public static function retrieveLast()
  {
    $c = new Criteria();
    $c->add(sfPollPeer::IS_ACTIVE, 1);
    $c->add(sfPollPeer::IS_PUBLISHED, 1);
    $c->addDescendingOrderByColumn(sfPollPeer::CREATED_AT);
    $v = sfPollPeer::doSelectOne($c);
    return !empty($v)? $v : null;
  }
  
  public static function setCookie($pollId, $answerId)
  {
    // Cookie expires in 10 years (yeah, ten)
      $cookie_expires = date('Y-m-d H:i:s', time() + (86400 * 365 * 10));
      try {
        sfContext::getInstance()->getResponse()->setCookie('poll'.$pollId, $answerId, $cookie_expires);
      } catch(Exception $e) {}
  }
}
