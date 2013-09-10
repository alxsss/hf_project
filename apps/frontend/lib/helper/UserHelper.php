<?php
use_helper('I18N');
function link_to_user_interested_photo($user, $photo)
{
  if ($user->isAuthenticated())
  {
    $recommended = PhotoVotePeer::retrieveByPK($photo->getId(), $user->getSubscriberId());
    if ($recommended)
    {
      // already interested
      return __('recommended');
    }
    else
    {
      // didn't declare interest yet
	  return link_to(__('recommend'), '@interested?id='.$photo->getId());      
    }
  }
  else
  {
    return '<span class="toggle_to_login"><a href="#">'.__('recommend').'</a></span>';
  }
}
function link_to_user_favorite_photo($user, $photo)
{
  if ($user->isAuthenticated())
  {
    $favorited = PhotoFavPeer::retrieveByPK($photo->getId(), $user->getSubscriberId());
    if ($favorited)
    {
      // already interested
      return __('Added to favorite');
    }
    else
    {
      // photo is not favorite  yet
      return link_to(__('Add to favorite'),  '@favorite?id='.$photo->getId());
    }
  }
  else
  {
    return '<span class="toggle_to_login"><a href="#">'.__('Add to favorite').'</a></span>';
  }
}
function link_to_user_favorite_ytvideo($user, $video_id)
{
  if ($user->isAuthenticated())
  {
    $favorited = YtvideoFavPeer::retrieveByVideoId($video_id, $user->getSubscriberId());
    if ($favorited)
    {
      // already interested
      return 'Added to favorite';
    }
    else
    {
      //video is not favorite  yet
      return link_to(__('Add to favorite'),'@favorite_ytvideo?video_id='.$video_id);
    }
  }
  else
  {
    return '<span class="toggle_to_login"><a href="#">'.__('Add to favorite').'</a></span>';
  }
}

function link_to_login($name, $uri = null)
{ 
  if ($uri && sfContext::getInstance()->getUser()->isAuthenticated())
  {
    return link_to($name, $uri);
  }
  else
  {
    return link_to_function($name, visual_effect('blind_down', 'login', array('duration' => 0.5)));
  }
}
?>
