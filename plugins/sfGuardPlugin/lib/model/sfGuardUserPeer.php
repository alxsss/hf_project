<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserPeer.php 9999 2008-06-29 21:24:44Z fabien $
 */
class sfGuardUserPeer extends sfSocialGuardUserPeer 
{

  public static function retrieveByUsername($username, $isActive = true)
  {
    $c = new Criteria();
    $c->add(self::USERNAME, $username);
    $c->add(self::IS_ACTIVE, $isActive);

    return self::doSelectOne($c);
  }
  
  public static function retrieveByEmail($email, $isActive = true)
  {
    $c = new Criteria();
    $c->add(self::EMAIL, $email);
    $c->add(self::IS_ACTIVE, $isActive);

    return self::doSelectOne($c);
  }

 public static function getRecentPager($page)
 {
  $pager = new sfPropelPager('sfGuardUser', sfConfig::get('app_pager_friends_max')); 
  $c = new Criteria();
  $c->addDescendingOrderByColumn(self::CREATED_AT);
  $pager->setCriteria($c);
  $pager->setPage($page);
  $pager->setPeerMethod('doSelect');
  $pager->init(); 
  return $pager;
 }
 public static function getNewestUsers()
 {
  $c = new Criteria();
  $c->addDescendingOrderByColumn(self::CREATED_AT);
  $c->setLimit(6);
  $newest_users=self::doSelect($c);
  return  $newest_users;
 }
  public static function getLastLoggedINUsers()
 {
  $c = new Criteria();
  $c->addDescendingOrderByColumn(self::LAST_LOGIN);
  $c->setLimit(6);
  $newest_users=self::doSelect($c);
  return  $newest_users;
 }
   
  static public function getByToken($token)
  {
    $criteria = new Criteria();
    $criteria->add(self::SALT, $token); 
    return self::doSelectOne($criteria);
  }
//functions related to friend serach and registration

  static public function getLuceneIndex()
  {
    ProjectConfiguration::registerZend();
    if (file_exists($index = self::getLuceneIndexFile()))
    {
      return Zend_Search_Lucene::open($index);
    }
    else
    {
      return Zend_Search_Lucene::create($index);
    }
  }
 static public function getLuceneIndexFile()
 {
   return sfConfig::get('sf_data_dir').'/friends.'.sfConfig::get('sf_environment').'.index';
 }
 static public function getForLuceneQuery($query)
 {
  $hits = self::getLuceneIndex()->find(mb_strtolower($query,"UTF-8"));
  $pks = array();
  foreach ($hits as $hit)
  {
    $pks[] = $hit->pk;
  }
 
  $criteria = new Criteria();
  $criteria->add(self::ID, $pks, Criteria::IN);
  $criteria->setLimit(20);
 
  return self::doSelect($criteria);
}
}
