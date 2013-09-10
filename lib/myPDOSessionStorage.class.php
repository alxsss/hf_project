<?php
//written by A. Kingson on August 25, 2010

class myPDOSessionStorage extends sfPDOSessionStorage 
{
  /**
   * Writes session data.
   *
   * @param  string $id    A session ID
   * @param  string $data  A serialized chunk of session data
   *
   * @return bool true, if the session was written, otherwise an exception is thrown
   *
   * @throws <b>DatabaseException</b> If the session data cannot be written
   */
  /*public function sessionWrite($id, $data)
  {
    // get table/column
    $db_table    = $this->options['db_table'];
    $db_data_col = $this->options['db_data_col'];
    $db_id_col   = $this->options['db_id_col'];
    $db_time_col = $this->options['db_time_col'];
    
	$db_user_id_col	=	'user_id';
    $user=sfContext::getInstance()->getUser();
    $user_id	=	false ;
   	if (is_object($user))
	{
	  if($user->isAuthenticated())
	  {
    	$user_id=sfContext::getInstance()->getUser()->getProfile()->getUserId();
      }
	}    
	if ($user_id)
	{
	    $sql = 'UPDATE '.$db_table.' SET '.$db_user_id_col.'= '.$user_id.', '.$db_data_col.' = ?, '.$db_time_col.' = '.time().' WHERE '.$db_id_col.'= ?';		
	//}
	//else{
	    //$sql = 'UPDATE '.$db_table.' SET '.$db_data_col.' = ?, '.$db_time_col.' = '.time().' WHERE '.$db_id_col.'= ?';		
	//}    
    try
    {
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(1, $data, PDO::PARAM_STR);
      $stmt->bindParam(2, $id, PDO::PARAM_STR);
      $stmt->execute();
    }
    catch (PDOException $e)
    {
      throw new sfDatabaseException(sprintf('PDOException was thrown when trying to manipulate session data. Message: %s', $e->getMessage()));
    }
  }
    return true;
  }*/
  public function sessionRead($id)
  {
    // get table/columns
    $db_table    = $this->options['db_table'];
    $db_data_col = $this->options['db_data_col'];
    $db_id_col   = $this->options['db_id_col'];
    $db_time_col = $this->options['db_time_col'];
    
	sfContext::getInstance()->getLogger()->info('sessionRead called from myPdoSessionStorage'.$id);
	try
    {
      $sql = 'SELECT '.$db_data_col.' FROM '.$db_table.' WHERE '.$db_id_col.'=?';

      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(1, $id, PDO::PARAM_STR, 255);

      $stmt->execute();
      // it is recommended to use fetchAll so that PDO can close the DB cursor
      // we anyway expect either no rows, or one row with one column. fetchColumn, seems to be buggy #4777
      $sessionRows = $stmt->fetchAll(PDO::FETCH_NUM);
      if (count($sessionRows) == 1)
      {
        return $sessionRows[0][0];
      }
      else
      {
        
		// session does not exist, create it
       
	    //if(isset($_SESSION['symfony/user/sfUser/attributes']['sfGuardSecurityUser']['user_id']))
	    //{ 
		  //$user_id=$_SESSION['symfony/user/sfUser/attributes']['sfGuardSecurityUser']['user_id'];	
		//$sql = 'INSERT INTO '.$db_table.'('.$db_id_col.', '.$db_data_col.', '.$db_time_col.', '.$user_id.') VALUES (?, ?, ?, ?)';
        $sql = 'INSERT INTO '.$db_table.'('.$db_id_col.', '.$db_data_col.', '.$db_time_col.') VALUES (?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_STR);
        $stmt->bindValue(2, '', PDO::PARAM_STR);
        $stmt->bindValue(3, time(), PDO::PARAM_INT);
		//$stmt->bindValue(4, $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return '';
		//}
      }
    }
    catch (PDOException $e)
    {
      throw new sfDatabaseException(sprintf('PDOException was thrown when trying to manipulate session data. Message: %s', $e->getMessage()));
    }
  }
  
 public function sessionWrite($id, $data)
  {
    // get table/column
    $db_table    = $this->options['db_table'];
    $db_data_col = $this->options['db_data_col'];
    $db_id_col   = $this->options['db_id_col'];
    $db_time_col = $this->options['db_time_col'];
	
    //  print_r($_SESSION['symfony/user/sfUser/attributes']['sfGuardSecurityUser']['user_id']);
    // sfContext::getInstance()->getLogger()->info('sessionWrite called from myPdoSessionStorage--SESSION[user_id]--'.$_SESSION['symfony/user/sfUser/attributes']['sfGuardSecurityUser']['user_id'].'--id--'.$id.'--data--'.$data);
	//update table only when data is not empty
	if(isset($_SESSION['symfony/user/sfUser/attributes']['sfGuardSecurityUser']['user_id']))
	{ 
		$user_id=$_SESSION['symfony/user/sfUser/attributes']['sfGuardSecurityUser']['user_id'];	
	    $db_user_id_col   =   'user_id';
	    $sql = 'UPDATE '.$db_table.' SET '.$db_user_id_col.'= '.$user_id.', '.$db_data_col.' = ?, '.$db_time_col.' = '.time().' WHERE '.$db_id_col.'= ?';
	  }
	  else
	  {
   	    $sql = 'UPDATE '.$db_table.' SET  '.$db_data_col.' = ?, '.$db_time_col.' = '.time().' WHERE '.$db_id_col.'= ?';
	  }
      
    try
    {
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(1, $data, PDO::PARAM_STR);
      $stmt->bindParam(2, $id, PDO::PARAM_STR);
      $stmt->execute();
    }
    catch (PDOException $e)
    {
      throw new sfDatabaseException(sprintf('PDOException was thrown when trying to manipulate session data. Message: %s', $e->getMessage()));
    }
    //}
    return true;
  }
  
 
  
}
