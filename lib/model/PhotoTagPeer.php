<?php
/**
 * Subclass for performing query and update operations on the 'photo_tag' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PhotoTagPeer extends BasePhotoTagPeer
{
public static function getTagsForUserLike($user_id, $tag, $max = 10)
{
  $tags = array();
 
  $con = Propel::getConnection();
  /*$query = '
    SELECT DISTINCT %s AS tag
    FROM %s
    WHERE %s = ? AND %s LIKE ?
    ORDER BY %s
  ';
 
  $query = sprintf($query,
    PhotoTagPeer::TAG,
    PhotoTagPeer::TABLE_NAME,
    PhotoTagPeer::USER_ID,
    PhotoTagPeer::TAG,
    PhotoTagPeer::TAG
  );
 
  $stmt = $con->prepareStatement($query);
  $stmt->setInt(1, $user_id);
  $stmt->setString(2, $tag.'%');
  $stmt->setLimit($max);
  $rs = $stmt->executeQuery();
  while ($rs->next())
  {
    $tags[] = $rs->getString('tag');
  }*/
  
  //
  $tag_like='"'.$tag.'%"';
  $stmt = $con->prepare("select distinct tag from photo_tag where user_id=$user_id and tag like $tag_like order by tag limit $max");
  $stmt->execute();
  while ($rs=$stmt->fetch(PDO::FETCH_OBJ))
  {
    $tags[] = $rs->tag;
  }  
  //
 
  return $tags;
}

 public static function getPopularTags($max = 5)
{
  $tags = array();
 
  $con = Propel::getConnection();
  $query = '
    SELECT '.PhotoTagPeer::NORMALIZED_TAG.' AS tag,
    COUNT('.PhotoTagPeer::NORMALIZED_TAG.') AS count
    FROM '.PhotoTagPeer::TABLE_NAME.'
    GROUP BY '.PhotoTagPeer::NORMALIZED_TAG.'
    ORDER BY count DESC';
 
  $stmt = $con->prepareStatement($query);
  $stmt->setLimit($max);
  $rs = $stmt->executeQuery();
  $max_popularity = 0;
  while ($rs->next())
  {
    if (!$max_popularity)
    {
      $max_popularity = $rs->getInt('count');
    }
 
    $tags[$rs->getString('tag')] = floor(($rs->getInt('count') / $max_popularity * 3) + 1);
  }
 
  ksort($tags);
 
  return $tags;
}
}