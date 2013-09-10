<?php

/**
 * Subclass for representing a row from the 'playlist' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Playlist extends BasePlaylist
{
  public function __toString()
  {
    return $this->getName();
  }
  
  public function  removeFavPlaylist($user_id)
  {
    $c = new Criteria();
    $c->add(PlaylistFavPeer::PLAYLIST_ID, $this->getId());
    $c->add(PlaylistFavPeer::USER_ID, $user_id);
    PlaylistFavPeer::doDelete($c);
  }
}
