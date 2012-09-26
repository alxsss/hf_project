<?php
class ajaxUploaderActions extends sfActions
 {
   private  $tfiles=array();
    /**
   * Retrieves an array of file names.
   *
   * @return array An indexed array of file names
   */
  public function getFileNames()
  {
    return array_keys($_FILES);
  }
  public function preExecute()
  {
    sfConfig::set('sf_web_debug', false);
  }
  public function executeUploader()
  {
    $this->name = $this->getRequestParameter('name', 'filename');
  }
  private function keyGen($length = 10)
  {
    $keychars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    if($length < 0)
	{
      $length = 0;
    }
    $max=strlen($keychars)-1;
    $key = '';    
    for ($i=0; $i<$length; $i++)
	{
      $key .= substr($keychars, rand(0, $max), 1);
    }    
    return $key;
  }
  public function executeSubmit()
  {
    //$uploadDir = sfConfig::get('sf_upload_dir');
	$uploadDir = sfConfig::get('sf_upload_dir').'/assets/tmp';
	$this->forward404Unless(is_dir($uploadDir));
    //foreach ($this->getRequest()->getFileNames() as $filename)
	foreach ($this->getFileNames() as $filename)
	 {
        if($filename =='upload')
	    {
           //if(!$this->getRequest()->getFileError($filename))
		   if(!$this->getFileError($filename))
		   {
		      //if ($this->getUser()->isAuthenticated())
		      {
                 //$filetoUpload=$this->getRequest()->getFileName($filename);
				 $filetoUpload=$this->getFileName($filename);
				 $filetoUpload = $this->sanitizeFile($filetoUpload);
                 $info['ext']  = substr($filetoUpload, strpos($filetoUpload, '.') - strlen($filetoUpload) + 1);
		         //$newfileName = md5($this->getRequest()->getFileName($filename).time().rand(0, 99999));
				 $newfileName = md5($this->getFileName($filename).time().rand(0, 99999));
                 //$ext = $this->getRequest()->getFileExtension('filename');
		         $ext ='.'.$info['ext'];
                 if ($this->isImage($info['ext']))
                 {
                    $thumbnail = new sfThumbnail(76, 76);
                    //$thumbnail->loadFile($this->getRequest()->getFilePath($filename));
					$thumbnail->loadFile($this->getFilePath($filename));
					
					$normal = new sfThumbnail(500, 500);
			        $normal->loadFile($this->getFilePath($filename));
	                //$currentDir='photos';
	                //$absCurrentDir = $this->uploadDir.'/'.$currentDir;
					$absCurrentDir = $uploadDir;
					$this->thumbnailsDir='thumbnails';
	                $this->forward404Unless(is_dir($absCurrentDir));
                    $thumbnail->save($absCurrentDir.'/thumbnails/'.$newfileName.$ext);
					$normal->save($absCurrentDir.'/normal/'.$newfileName.$ext);
	                //$mediaName = 'Photo'; 
                  }
				}
			 ///////////////////////////
			 
			 
			 
			  $this->filename=$newfileName;
			  //$this->filename = $this->keyGen() . $filename . '___' . $this->getRequest()->getFileName($filename);
              //$this->getRequest()->moveFile($filename, $uploadDir. DIRECTORY_SEPARATOR .$this->filename.$ext);
			  $this->moveFile($filename, $uploadDir. DIRECTORY_SEPARATOR .$this->filename.$ext);
			  
			  //set session variables////////////////////////////
			  $this->tfiles=$this->getUser()->getAttribute('tfiles');
	          $this->tfiles[$this->filename.$ext]= $this->filename.$ext;
			  $this->getUser()->setAttribute('tfiles', $this->tfiles);
			  /////////////////////////////
              foreach($this->getRequest()->getParameterHolder()->getAll() as $name=>$value) 
			  {
                if(!in_array($name, array('module', 'action'))) 
				{
                  if($value == "__fieldname")
				  {
                    $value =  $this->filename;
                  } 
				  elseif (is_array($value)) 
				  {
                    $keys = array_keys($value);
                    if(count($keys)) {
                    if($this->getUser()->hasAttribute($name, AjaxUploaderFilter::namespace) && is_array($this->getUser()->getAttribute($name, null, AjaxUploaderFilter::namespace)))
					{
                      $value = $this->getUser()->getAttribute($name, null, AjaxUploaderFilter::namespace);
                    }
                  $value[$keys[0]] = $this->filename;
                }
              }
              $this->getUser()->setAttribute($name, $value, AjaxUploaderFilter::namespace);
              break;
            }
          }
        }
      }
      break;
    }
  }
 //functions from mediaLibrary plugin to be removed later 
  protected function sanitizeFile($file)
  {
    return preg_replace('/[^a-z0-9_\.-]/i', '_', $file);
  }
   protected function isImage($ext)
  {
    return in_array(strtolower($ext), array('png', 'jpg', 'gif'));
  }
 
 /**
   * Retrieves a file error.
   *
   * @param  string $name  A file name
   *
   * @return int One of the following error codes:
   *
   *             - <b>UPLOAD_ERR_OK</b>        (no error)
   *             - <b>UPLOAD_ERR_INI_SIZE</b>  (the uploaded file exceeds the
   *                                           upload_max_filesize directive
   *                                           in php.ini)
   *             - <b>UPLOAD_ERR_FORM_SIZE</b> (the uploaded file exceeds the
   *                                           MAX_FILE_SIZE directive that
   *                                           was specified in the HTML form)
   *             - <b>UPLOAD_ERR_PARTIAL</b>   (the uploaded file was only
   *                                           partially uploaded)
   *             - <b>UPLOAD_ERR_NO_FILE</b>   (no file was uploaded)
   */
  public function getFileError($name)
  {
    return $this->hasFile($name) ? $this->getFileValue($name, 'error') : UPLOAD_ERR_NO_FILE;
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