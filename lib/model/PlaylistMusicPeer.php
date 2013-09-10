<?php

class PlaylistMusicPeer extends BasePlaylistMusicPeer
{
   public static function retrieveByOnePK( $playlist_id, $con = null)
   {
     if ($con === null)
     {
       $con = Propel::getConnection(self::DATABASE_NAME);
     }
     $criteria = new Criteria();
     $criteria->add(PlaylistMusicPeer::PLAYLIST_ID, $playlist_id);
     //$criteria->add(PlaylistMusicPeer::MUSIC_ID, $music_id);
     $v = PlaylistMusicPeer::doSelect($criteria, $con);
     return !empty($v) ? $v : null;
   }
}
