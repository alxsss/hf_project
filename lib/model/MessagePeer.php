<?php

/**
 * Subclass for performing query and update operations on the 'message' table.
 *
 * 
 *
 * @package lib.model
 */ 
class MessagePeer extends BaseMessagePeer
{
  public static function getMessagesPager($subject, $from_userid, $to_userid, $page)
  { 
    $pager = new sfPropelPager('Message', sfConfig::get('app_pager_message_max'));
    $c=new Criteria();
    $c->add(MessagePeer::SUBJECT, $subject);
    /* OR STATEMENT*/
    $c1 = $c->getNewCriterion(MessagePeer::TO_USERID, $to_userid);
    $c12 = $c->getNewCriterion(MessagePeer::FROM_USERID,  $from_userid);
    $c1->addAnd($c12);
    $c2 = $c->getNewCriterion(MessagePeer::TO_USERID, $from_userid);
    $c22 = $c->getNewCriterion(MessagePeer::FROM_USERID,  $to_userid);
    $c2->addAnd($c22);
    $c1->addOr($c2);
    $c->add($c1);
    $c->addAscendingOrderByColumn(MessagePeer::CREATED_AT);
    
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setPeerMethod('doSelect');
    $pager->init();
    return $pager;  
  }

}
