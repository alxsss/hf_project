<?php  
  function pager_navigation($pager, $uri)
  {
    $navigation = ''; 
    if ($pager->haveToPaginate())
    {  
      $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page='; 
      // First and previous page
      if ($pager->getPage() != 1)
      {
       $navigation .= link_to(__('First'), $uri.'1');
       $navigation .= link_to(__('Previous'), $uri.$pager->getPreviousPage()).'&nbsp;';
      } 
      // Pages one by one
      $links = array();
      foreach ($pager->getLinks() as $page)
      {
        $links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page);
      }
      $navigation .= join('&nbsp;&nbsp;', $links);
      // Next and last page
	  if ($pager->getPage() != $pager->getCurrentMaxLink())
      {
        $navigation .= '&nbsp;'.link_to(__('Next'), $uri.$pager->getNextPage());
        $navigation .= link_to(__('Last'), $uri.$pager->getLastPage());
      }
    }
    return $navigation;
}
 function pager_navigation_feed_ajax_jq($pager, $uri)
 {
    $navigation = '';
    if ($pager->haveToPaginate())
    {
      $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';
      // First and previous page
      if ($pager->getPage() != 1)
      {
        $navigation .='<span class="jq_feed_pagination">'. link_to(__('First'), $uri.'1').'</span>';
        $navigation .='<span class="jq_feed_pagination">'. link_to(__('Previous'), $uri.$pager->getPreviousPage()).'</span>&nbsp;';
      }
      // Pages one by one
      $links = array();
      foreach ($pager->getLinks() as $page)
      {
       //do not put link if the page is current one
       if($page==$pager->getPage())
        {
          $links[]=$page;
        }
        else
        {
          $links[] ='<span class="jq_feed_pagination">'.link_to($page, $uri.$page).'</span>';
        }
       //$links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page);
       }
       $navigation .= join('&nbsp;&nbsp;', $links);
       // Next and last page
       if ($pager->getPage() != $pager->getCurrentMaxLink())
       {
         $navigation .= '&nbsp;<span class="jq_feed_pagination">'.link_to(__('Next'), $uri.$pager->getNextPage().'</span>' );
         $navigation .= '<span class="jq_feed_pagination">'.link_to(__('Last'), $uri.$pager->getLastPage().'</span>');
       }
     }
    return $navigation;
 }
   
function pager_photo_navigation($photos, $uri, $photo_id)
{
  $navigation = ''; 
  $ids = array();  
  foreach ($photos as $photo)
  {
    $ids[] = $photo->getId();
  }
  $currentMaxLink = count($ids) ?count($ids) : 1;
  if (count($ids)>1)
  {  
    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'id='; 
    $index=array_search($photo_id, $ids);
	$page=$index+1;
    //previous page
    if ($page != 1)
    {	   
      $navigation .= '<div class="photo_previous">'.link_to(__('Previous'), $uri.$ids[$index-1]).'</div>';  	
    }
	//Next page	
    if ($page!= $currentMaxLink)
    {
      $navigation .= '<div class="photo_next">'.link_to(__('Next'), $uri.$ids[$index+1]).'</div>';	
    }
  }
  return $navigation;
}   

 function pager_navigation_feed($pager, $uri, $update)
  {
    $navigation = ''; 
    if ($pager->haveToPaginate())
    {  
      $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page='; 
      // First and previous page
      if ($pager->getPage() != 1)
      {
        $navigation .= link_to_remote('Prev', array('update' => $update, 'url'    => $uri.$pager->getPreviousPage(), 'before' => 'hide_submit()', 'complete' => 'show_submit()' )).'&nbsp;';
      } 
      // Pages one by one
      $links = array();
      foreach ($pager->getLinks() as $page)
      {
        if($page==$pager->getPage())
	{
	  $links[]=$page;
	}
	else
	{
          $links[] = link_to_remote($page, array('update' => $update,'url'    => $uri.$page, 'before' => 'hide_submit()',  'complete' => 'show_submit()'	));
	}	
	//$links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page);
      }
      $navigation .= join('&nbsp;&nbsp;', $links); 
      // Next and last page	
      if ($pager->getPage() != $pager->getCurrentMaxLink())
      {      
        $navigation .= '&nbsp;'.link_to_remote('Next', array('update' => $update,'url'    => $uri.$pager->getNextPage(), 'before' => 'hide_submit()',  'complete' => 'show_submit()'
                ));     
      } 
    } 
    return $navigation;
  }
?>     
