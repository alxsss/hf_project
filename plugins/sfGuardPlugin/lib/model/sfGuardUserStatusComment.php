<?php

class sfGuardUserStatusComment extends BasesfGuardUserStatusComment
{
  public function save(PropelPDO  $con = null)
  {
    $ret = parent::save($con);
    //update num_comment column in status table
    $status = $this->getsfGuardUserStatus();
    $num_comment =  $status->getNumComment();
    $status->setNumComment($num_comment + 1);
    $status->save($con);
    return $ret;
 }
  public function delete(PropelPDO  $con = null)
  {
    $ret = parent::delete($con);
    //update num_comment column in status table
    $status = $this->getsfGuardUserStatus();
    $num_comment = $status->getNumComment();
    $status->setNumComment($num_comment - 1);
    $status->save($con);
    return $ret;
 }
}
