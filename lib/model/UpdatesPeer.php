<?php
class UpdatesPeer extends BaseUpdatesPeer
{
  public static function getUpdatesPager($page, $friendIds, $user_group_ids)
 {
   $pager = new sfPropelPager('Updates', sfConfig::get('app_pager_status_max'));  
   $c=new Criteria();
   //exclude admin friends from other user's updates
   $excludeadminFriends1 = $c->getNewCriterion(UpdatesPeer::USER_ID, 1, Criteria::NOT_EQUAL);
   $excludeadminFriends2 = $c->getNewCriterion(UpdatesPeer::FRIEND_ID, 1, Criteria::NOT_EQUAL);
   //$excludeadminFriends2 = $c->getNewCriterion(UpdatesPeer::PID, 3, Criteria::NOT_EQUAL);
   $excludeadminFriends1->addAnd($excludeadminFriends2);
   
   $cfriend1 = $c->getNewCriterion(UpdatesPeer::USER_ID,  $friendIds, Criteria::IN);
   $cfriend2 = $c->getNewCriterion(UpdatesPeer::FRIEND_ID, $friendIds, Criteria::IN);
   $cgroup = $c->getNewCriterion(UpdatesPeer::GROUP_ID, $user_group_ids, Criteria::IN);
   $cfriend1->addOr($cfriend2);
   $cfriend1->addOr($cgroup);
   $cfriend1->addAnd($excludeadminFriends1);
   $c->add($cfriend1);
   $c->add(UpdatesPeer::P_OWNER_ID, $friendIds, Criteria::NOT_IN);
   $c->addDescendingOrderByColumn(UpdatesPeer::CREATED_AT); 
   $pager->setCriteria($c);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelectFromView');
   $pager->init(); 
   return $pager;
 }
  public static function getUpdatesSubscriberPager($page, $user_id)
 {
   $pager = new sfPropelPager('Updates', sfConfig::get('app_pager_status_max'));  
   $cupdate=new Criteria();
   $cfriend1 = $cupdate->getNewCriterion(UpdatesPeer::USER_ID,  $user_id);
   $cfriend2 = $cupdate->getNewCriterion(UpdatesPeer::FRIEND_ID, $user_id);
   $cfriend1->addOr($cfriend2);
   $cupdate->add($cfriend1);
   $cupdate->add(UpdatesPeer::PID, 1, Criteria::NOT_EQUAL);
   $cupdate->addDescendingOrderByColumn(UpdatesPeer::CREATED_AT);   
   $pager->setCriteria($cupdate);
   $pager->setPage($page);
   $pager->setPeerMethod('doSelectFromView');
   $pager->init(); 
   return $pager;
 }
 public static function doSelectFromView(Criteria $criteria, PropelPDO $con = null)
 {
	return UpdatesPeer::populateViewObjects(UpdatesPeer::doSelectStmt($criteria, $con));
 }

  public static function populateViewObjects(PDOStatement $stmt)
  {
	$results = array();
	// set the class once to avoid overhead in the loop
	$cls = UpdatesPeer::getOMClass();
	$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
	// populate the object(s)
	while ($row = $stmt->fetch(PDO::FETCH_NUM)) 
	{
	  $obj = new $cls();
	  $obj->hydrate($row);
	  $results[] = $obj;
	}
	$stmt->closeCursor();
	return $results;
  }

}