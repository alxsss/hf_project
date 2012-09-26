<?php //use_helper('User')

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

 ?>
  <?php echo link_to_user_favorite_photo($sf_user, $photos)?>  
