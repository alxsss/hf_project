<?php
function tags_for($item, $max = 5)
{
  $tags = array();
 
  foreach ($item->getPopularTags($max) as $tag => $count)
  {
    $tags[] = link_to($tag, '@tag?tag='.$tag);
  }
 
  return implode(' + ', $tags);
}
?> 
