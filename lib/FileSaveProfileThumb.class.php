<?php
//this class is created to override the sfValidatorFile save method to create additional thumbnails.
class FileSaveProfileThumb  extends sfValidatedFile 
{
 public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
  {
    if (is_null($file))
    {
      $file = $this->generateFilename();
    }
    if ($file[0] != '/' && $file[0] != '\\' && !(strlen($file) > 3 && ctype_alpha($file[0]) && $file[1] == ':' && ($file[2] == '\\' || $file[2] == '/')))
    {
      if (is_null($this->path))
      {
        throw new RuntimeException('You must give a "path" when you give a relative file name.');
      }
      $thumbnailfile= $this->path.DIRECTORY_SEPARATOR.'thumbnails/'.$file;
      $normalthumbnailfile= $this->path.DIRECTORY_SEPARATOR.'normal/'.$file;
      $file = $this->path.DIRECTORY_SEPARATOR.$file;
    }
    // get our directory path from the destination filename
    $directory = dirname($file);
    if (!is_readable($directory))
    {
      if ($create && !mkdir($directory, $dirMode, true))
      {
        // failed to create the directory
        throw new Exception(sprintf('Failed to create file upload directory "%s".', $directory));
      }
      // chmod the directory since it doesn't seem to work on recursive paths
      chmod($directory, $dirMode);
    }
    if (!is_dir($directory))
    {
      // the directory path exists but it's not a directory
      throw new Exception(sprintf('File upload path "%s" exists, but is not a directory.', $directory));
    }
    if (!is_writable($directory))
    {
      // the directory isn't writable
      throw new Exception(sprintf('File upload path "%s" is not writable.', $directory));
    }
    //create  tumbnail
	$thumbnail = new sfThumbnail(200, 800);
	$thumbnail->loadFile($this->getTempName());
	$thumbnail->save($file);
	//create small thumbnail
	$thumbnail = new sfThumbnail(48, 48);
	$thumbnail->loadFile($this->getTempName());
	$thumbnail->save($thumbnailfile);
	chmod($thumbnailfile, $fileMode);
	//create normal thumbnail
	$thumbnail = new sfThumbnail(76, 76);
	$thumbnail->loadFile($this->getTempName());
	$thumbnail->save($normalthumbnailfile);
	chmod($thumbnailfile, $fileMode);
    // chmod our file
    chmod($file, $fileMode);

    $this->savedName = $file;
    return is_null($this->path) ? $file : str_replace($this->path.DIRECTORY_SEPARATOR, '', $file);
  }
}
