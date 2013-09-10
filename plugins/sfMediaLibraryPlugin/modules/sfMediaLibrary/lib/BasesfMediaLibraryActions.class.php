<?php
/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 1949 2006-09-05 14:40:20Z fabien $
 */
class BasesfMediaLibraryActions extends sfActions
{
  protected
    $uploadDir     = '',
    $uploadDirName = '',
    $useThumbnails = true,
    $thumbnailsDir = '';

  public function preExecute()
  {
    if (sfConfig::get('app_sfMediaLibrary_use_thumbnails', true) && class_exists('sfThumbnail'))
    {
      $this->useThumbnails = true;
      $this->thumbnailsDir = sfConfig::get('app_sfMediaLibrary_thumbnails_dir', 'thumbnail');
      $this->normalDir='normal';
    }
    //$this->uploadDirName = sfConfig::get('app_sfMediaLibrary_upload_dir', str_replace(sfConfig::get('sf_web_dir'), '', sfConfig::get('sf_upload_dir')).'/assets');
    //$this->uploadDirName = sfConfig::get('app_sfMediaLibrary_upload_dir', sfConfig::get('sf_upload_dir_name').'/assets');
    $this->uploadDirName='/uploads/assets';
    $this->uploadDir     = sfConfig::get('sf_web_dir').$this->uploadDirName;
  }

  public function executeIndex()
  {
    $currentDir = $this->dot2slash($this->getRequestParameter('dir'));
    $this->currentDir = $this->getRequestParameter('dir');
    $this->current_dir_slash = $currentDir.'/';
    //$this->webAbsCurrentDir = $this->getRequest()->getRelativeUrlRoot().'/'.$this->uploadDirName.'/'.$currentDir;
	 $this->webAbsCurrentDir = $this->getRequest()->getRelativeUrlRoot().$this->uploadDirName.'/'.$currentDir;

    $this->absCurrentDir = $this->uploadDir.'/'.$currentDir;

    $this->forward404Unless(is_dir($this->absCurrentDir));

    // directories
    $dirsQuery = sfFinder::type('dir')->maxdepth(0)->prune('.*')->discard('.*')->relative();
    if ($this->useThumbnails)
    {
      $dirsQuery = $dirsQuery->discard($this->thumbnailsDir);
    }
    $dirs = $dirsQuery->in($this->absCurrentDir);
    sort($dirs);
    $this->dirs = $dirs;

    // files, with stats
    $files = sfFinder::type('file')->maxdepth(0)->prune('.*')->discard('.*')->relative()->in($this->absCurrentDir);
    sort($files);
    $infos = array();
    foreach ($files as $file)
    {
      $ext = substr($file, strpos($file, '.') - strlen($file) + 1);
      if (!$this->getRequestParameter('images_only') || $this->isImage($ext))
      {
        $infos[$file] = $this->getInfo($file);
      }
    }
    $this->files = $infos;
    // parent dir
    $tmp = explode(' ', $this->currentDir);
    array_pop($tmp);
    $this->parentDir = implode(' ', $tmp);
  }

  protected function isImage($ext)
  {
    return in_array(strtolower($ext), array('png', 'jpg', 'gif','jpeg','bmp','tiff'));
  }
  
  public function executeChoice()
  {
    $this->executeIndex();
  }
  
  protected function getInfo($filename, $filedir)
  {
    $info = array();
    $info['ext']  = substr($filename, strpos($filename, '.') - strlen($filename) + 1);
	$stats = stat($this->absCurrentDir.'/'.$filedir.'/'.$filename);
    $info['size'] = $stats['size'];
    $info['thumbnail'] = true;
	$info['filedir'] = $filedir;
    if ($this->isImage($info['ext']))
    {
      if ($this->useThumbnails && is_readable(sfConfig::get('sf_web_dir').$this->webAbsCurrentDir.'/'.$filedir.'/'.$this->thumbnailsDir.'/'.$filename))
      {
         $info['icon'] = $this->webAbsCurrentDir.'/'.$filedir.'/'.$this->thumbnailsDir.'/'.$filename;
      }
      else
      {
        $info['icon'] = $this->webAbsCurrentDir.'/'.$filedir.'/'.$filename;
        $info['thumbnail'] = false;
      }
    }
    else
    {
      if (is_readable(sfConfig::get('sf_web_dir').'/sfMediaLibraryPlugin/images/'.$info['ext'].'.png'))
      {
        $info['icon'] = '/sfMediaLibraryPlugin/images/'.$info['ext'].'.png';
      }
      else
      {
        $info['icon'] = '/sfMediaLibraryPlugin/images/unknown.png';
      }
    }

    return $info;
  }

  public function executeUpload()
  {    	
	if ($this->getRequest()->getMethod() != sfRequest::POST)
    {
       //if request comes from progress bar
	   if( ($progressKey = $this->getRequestParameter('progress_key')) != null )
	   {
          $status = apc_fetch('upload_'.$progressKey);
          $this->renderText( json_encode($status) );
          return sfView::NONE;
        }
	   
	   if ($this->getUser()->isAuthenticated())
	   {
		  $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	
          $this->subscriber = sfGuardUserPeer::retrieveByPk($this->user_id);    	
	   }
	   //display the form
        $this->getRequest()->setAttribute('referer', $this->getRequest()->getReferer());
	    $this->form=new uploadForm();
     }
     else //else the request is POST
     {
	     if ($this->getUser()->isAuthenticated())
		 {
		   $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');	
           $this->subscriber = sfGuardUserPeer::retrieveByPk($this->user_id);
	       $this->inbox_num_msgs = $this->subscriber->countInboxMessages();
	       $this->num_friendsRequests = $this->subscriber->count_num_friend_requests(); 
		   $this->form=new uploadForm();
		   $this->form->bind($this->getRequest()->getParameter($this->form->getName()), $this->getRequest()->getFiles($this->form->getName()));
           if ($this->form->isValid())
           {
		     $filename = $this->sanitizeFile($this->getFileName('upload[filename]'));
             //$info['ext']  = substr($filename, strpos($filename, '.') - strlen($filename) + 1);
		     $info['ext']  = substr($filename, -3, 3);			   
		     $newfileName = md5($this->getFileName('upload[filename]').time().rand(0, 99999));
             //$ext = $this->getRequest()->getFileExtension('filename');
		     $ext ='.'.$info['ext'];
             if ($this->isImage($info['ext']))
             {
               $thumbnail = new sfThumbnail(76, 76);
			   $normal = new sfThumbnail(640, 800);
               //$thumbnail->loadFile($this->getRequest()->getFilePath('filename'));
			   $thumbnail->loadFile($this->getFilePath('upload[filename]'));
			   $normal->loadFile($this->getFilePath('upload[filename]'));
	           $currentDir='photos';
	           $absCurrentDir = $this->uploadDir.'/'.$currentDir;
	           $this->forward404Unless(is_dir($absCurrentDir));
               $thumbnail->save($absCurrentDir.'/'.$this->thumbnailsDir.'/'.$newfileName.$ext);
			   $normal->save($absCurrentDir.'/'.$this->normalDir.'/'.$newfileName.$ext);
	           $mediaName = 'Photo'; 
			   $redirect='photos'; 
             }
	         //$this->moveFile('upload[filename]', $absCurrentDir.'/'.$newfileName.$ext);
		     //enter data to database
	         $media = new $mediaName();
	         //$photos->setId($this->getRequestParameter('id'));
             //$media->setAlbumId($this->getRequestParameter('album_id'));
             $this->subscriber = sfGuardUserPeer::retrieveByPk($this->getRequestParameter('id', $this->getUser()->getSubscriberId()));
		     if($mediaName=='Photo')
		     {
		       //$media->setAlbumId($this->subscriber->getAlbum()->getId());
			   $media->setAlbumId(NULL);
			   //$media->setUserId($this->subscriber->getId());
			   $media->setApproved(1);            
			   $media->setFilename($newfileName.$ext);
			   //$media->setCreatedAt(time());
		     }
		     //$media->setUserId($this->getUser()->getAttribute('subscriber_id', '', 'subscriber'));
             //$media->setRating($this->getRequestParameter('rating'));
             //$media->setVote($this->getRequestParameter('votes'));
             //$media->setTitle($this->getRequestParameter('title'));
		     $media->setRawIp($_SERVER['REMOTE_ADDR']);
		     $media->setUserId($this->subscriber->getId());          
             $media->save();
             return $this->redirect($redirect.'/edit?id='.$media->getId()); 
		  }//end of bind
         }
	     else	
	     {
		   return $this->redirect('@login');
           // return link_to_login('recommend', visual_effect('blind_down', 'login', array('duration' => 0.5)));
         }
    }
    //$this->redirect('sfMediaLibrary/index?dir='.$this->getRequestParameter('current_dir'));
  }
  public function handleErrorUpload()
  {
    return sfView::SUCCESS;
  } 
  public function executeDelete()
  {
    $currentDir = $this->dot2slash($this->getRequestParameter('current_path'));
    $currentFile = $this->getRequestParameter('name');
	$filedir = $this->getRequestParameter('filedir');
	
    
    $absCurrentFile = $this->uploadDir.'/'.$filedir.'/'.$currentDir.'/'.$currentFile;
	$this->forward404Unless(is_readable($absCurrentFile));
    unlink($absCurrentFile);
	if($filedir=='tmp')
	{
	  $this->getContext()->getUser()->getAttributeHolder()->removeOne('tfiles', $currentFile);
	  //$this->getContext()->getUser()->getAttributeHolder()->remove('tfiles');
	}
	$item_image=ItemImagePeer::retriveByFilename($currentFile);
	if(!empty($item_image))
	{
	  $item_image->delete();
	}	
	if ($this->useThumbnails)
    {
      $absThumbnailFile = $this->uploadDir.'/'.$filedir.'/'.$currentDir.'/'.$this->thumbnailsDir.'/'.$currentFile;
      if (is_readable($absThumbnailFile))
      {
        unlink($absThumbnailFile);
      }
    }
	//
	$this->webAbsCurrentDir = $this->uploadDirName;
    $this->absCurrentDir = $this->uploadDir;
    $this->forward404Unless(is_dir($this->absCurrentDir));
	$tfiles=$this->getUser()->getAttribute('tfiles');
	$infos = array();
	if(!empty($tfiles))
    {
	  foreach ($tfiles as $file)
	  {
		$infos[$file] = $this->getInfo($file, 'tmp');
	  }		   
    }
	//$this->tfiles = $infos;
	$this->id=$this->getRequestParameter('id');
	if($this->id):
	$item = ItemPeer::retrieveByPk($this->id);
	foreach( $item->getItemImages() as $image)
	{
	   $infos[$image->getFilename()] = $this->getInfo($image->getFilename(), 'items');
	} 
	endif;   
	//$this->itemfiles = $iteminfos;
	$this->files = $infos;
	//
    //$this->redirect('sfMediaLibrary/index?dir='.$this->getRequestParameter('current_path'));
	//$this->redirect('item/index?dir='.$this->getRequestParameter('current_path'));
	//$this->redirect('item/create');
  }
  
  protected function dot2slash($txt)
  {
    return preg_replace('#[\+\s]+#', '/', $txt);
  }

  protected function slash2dot($txt)
  {
    return preg_replace('#/+#', '+', $txt);
  }

  protected function sanitizeDir($dir)
  {
    return preg_replace('/[^a-z0-9_-]/i', '_', $dir);
  }

  protected function sanitizeFile($file)
  {
    return preg_replace('/[^a-z0-9_\.-]/i', '_', $file);
  }
 /**********ADDED THESE METHOD SINCE THEY ARE REMOVED FROM SF1.2**********/
  /**
   * Retrieves a file name.
   *
   * @param  string $name  A file nam.
   *
   * @return string A file name, if the file exists, otherwise null
   */
  public function getFileName($name)
  {
    return $this->hasFile($name) ? $this->getFileValue($name, 'name') : null;
  }
  /**
   * Retrieves a file value.
   *
   * @param string $name A file name
   * @param string $key Value to search in the file
   * 
   * @return string File value
   */
  public function getFileValue($name, $key)
  {
    if (preg_match('/^(.+?)\[(.+?)\]$/', $name, $match))
    {
      return $_FILES[$match[1]][$key][$match[2]];
    }
    else
    {
      return $_FILES[$name][$key];
    }
  }
  /**
   * Indicates whether or not a file exists.
   *
   * @param  string $name  A file name
   *
   * @return bool true, if the file exists, otherwise false
   */
  public function hasFile($name)
  {    
    if (preg_match('/^(.+?)\[(.+?)\]$/', $name, $match))
    {
      return isset($_FILES[$match[1]]['name'][$match[2]]);
    }
    else
    {
      return isset($_FILES[$name]);
    }
  }
  /**
   * Retrieves a file path.
   *
   * @param  string $name  A file name
   *
   * @return string A file path, if the file exists, otherwise null
   */
  public function getFilePath($name)
  {
    return $this->hasFile($name) ? $this->getFileValue($name, 'tmp_name') : null;
  }
   /**
   * Moves an uploaded file.
   *
   * @param string $name      A file name
   * @param string $file      An absolute filesystem path to where you would like the
   *                          file moved. This includes the new filename as well, since
   *                          uploaded files are stored with random names
   * @param int    $fileMode  The octal mode to use for the new file
   * @param bool   $create    Indicates that we should make the directory before moving the file
   * @param int    $dirMode   The octal mode to use when creating the directory
   *
   * @return bool true, if the file was moved, otherwise false
   *
   * @throws <b>sfFileException</b> If a major error occurs while attempting to move the file
   */
  public function moveFile($name, $file, $fileMode = 0666, $create = true, $dirMode = 0777)
  {
    if ($this->hasFile($name) && $this->getFileValue($name, 'error') == UPLOAD_ERR_OK && $this->getFileValue($name, 'size') > 0)
    {
      // get our directory path from the destination filename
      $directory = dirname($file);

      if (!is_readable($directory))
      {
        $fmode = 0777;

        if ($create && !@mkdir($directory, $dirMode, true))
        {
          // failed to create the directory
          throw new sfFileException(sprintf('Failed to create file upload directory "%s".', $directory));
        }

        // chmod the directory since it doesn't seem to work on
        // recursive paths
        @chmod($directory, $dirMode);
      }
      else if (!is_dir($directory))
      {
        // the directory path exists but it's not a directory
        throw new sfFileException(sprintf('File upload path "%s" exists, but is not a directory.', $directory));
      }
      else if (!is_writable($directory))
      {
        // the directory isn't writable
        throw new sfFileException(sprintf('File upload path "%s" is not writable.', $directory));
      }

      if (@move_uploaded_file($this->getFileValue($name, 'tmp_name'), $file))
      {
        // chmod our file
        @chmod($file, $fileMode);

        return true;
      }
    }

    return false;
  }
}
