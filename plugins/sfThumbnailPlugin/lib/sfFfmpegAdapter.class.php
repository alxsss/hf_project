<?php
/*
 * (c) 2008 Alexander Kingson <alxsss29@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * sfFfmpegAdapter provides a mechanism for creating flv files and thumbnails  from them.
 *
 * This is taken from class and
 * converted for PHP5 strict compliance for use with symfony.
 */
class sfFfmpegAdapter
{
  protected
    $sourceWidth,
    $sourceHeight,
    $sourceMime,
    $maxWidth,
    $maxHeight,
    $scale,
    $inflate,
    $quality,
    $source,
    $ffmpegCommands;
  /**
   * Mime types this adapter supports
   */
  protected $videoTypes = array(
    'video/flv',
    'video/mng',
    'video/mpeg',
    'video/mpeg2',
	'video/avi'
  );
  
   /**
   * ffmpeg-specific Type to Mime type map
   */
  protected $mimeMap = array(
    'flv'   => 'video/flv',
    'avi'   => 'video/avi',
    'mng'   => 'video/mng',
    'mpeg'  => 'video/mpeg',
    'mpg'   => 'video/mpeg'
  );
  public function __construct($maxWidth, $maxHeight, $scale, $inflate, $quality, $options)
  {
    $this->ffmpegCommands = array();
    $this->ffmpegCommands['ffmpeg'] = isset($options['ffmpeg']) ? escapeshellcmd($options['ffmpeg']) : 'ffmpeg';
    exec($this->ffmpegCommands['ffmpeg'], $stdout);
    if (strpos($stdout[0], 'ffmpeg') === false)
    {
      throw new Exception(sprintf("ffmpeg not found"));
    }
    $this->maxWidth = $maxWidth;
    $this->maxHeight = $maxHeight;
    $this->scale = $scale;
    $this->inflate = $inflate;
    $this->quality = $quality;
    $this->options = $options;
  }
    public function toString($thumbnail, $targetMime = null)
    {
      ob_start();
      $this->save($thumbnail, null, $targetMime);
      return ob_get_clean();
    }

  public function loadFile($thumbnail, $image)
  {
    // try and use getimagesize()
    // on failure, use identify instead
   // $imgData = @getimagesize($image);
   /* if (!$imgData)
    {
      exec($this->magickCommands['identify'].' '.escapeshellarg($image), $stdout, $retval);
      if ($retval === 1)
      {
        throw new Exception('Image could not be identified.');
      }
      else
      {
        // get image data via identify
        list($img, $type, $dimen) = explode(' ', $stdout[0]);
        list($width, $height) = explode('x', $dimen);

        $this->sourceWidth = $width;
        $this->sourceHeight = $height;
        $this->sourceMime = $this->mimeMap[strtolower($type)];
      }
    }
    else*/
    {
      // use image data from getimagesize()
      $this->sourceWidth = '120';
      $this->sourceHeight = '76';
      $this->sourceMime = 'flv';
    }
    $this->image = $image;

    // open file resource
    $source = fopen($image, 'r');

    $this->source = $source;

   // $thumbnail->initThumb($this->sourceWidth, $this->sourceHeight, $this->maxWidth, $this->maxHeight, $this->scale, $this->inflate);

    return true;
  }

  public function loadData($thumbnail, $image, $mime)
  {
    throw new Exception('This function is not yet implemented. Try a different adapter.');
  }
   public function convert($thumbnail, $thumbDest, $targetMime = null)
   {
         //$this->image=$thumbDest.'.flv';
		 $thumbDest=$thumbDest.'.flv';
	    // $ffmpegcmd =ffmpeg -i pr2f.mpg -acodec mp3 -ar 44100 -ab 64 -b 500  -f flv -s 200x140 pr2f56.flv
	   	 $ffmpegcmd = 'ffmpeg -i '.$this->image.' -acodec mp3 -ar 44100 -ab 64 -b 500  -f flv -s 200x140 '.$thumbDest;
		 $cmd = $ffmpegcmd;
		 
        $this->image=$thumbDest;
    (is_null($thumbDest))?passthru($cmd):exec($cmd);
	 $cmd1='flvmdi '.$thumbDest;
	 exec($cmd1);
	     
   }
  public function save($thumbnail, $thumbDest, $targetMime = null)
  {
    $command = '';

    $width  = $this->sourceWidth;
    $height = $this->sourceHeight;
    $x = $y = 0;
	/*
    switch (@$this->options['method']) {
      case "shave_all":
        if ($width > $height)
        {
          $x = ceil(($width - $height) / 2 );
          $width = $height;
        }
        elseif ($height > $width)
        {
          $y = ceil(($height - $width) / 2);
          $height = $width;
        }

        $command = sprintf(" -shave %dx%d", $x, $y);
        break;
      case "shave_bottom":
        if ($width > $height)
        {
          $x = ceil(($width - $height) / 2 );
          $width = $height;
        }
        elseif ($height > $width)
        {
          $y = 0;
          $height = $width;
        }

        if (is_null($thumbDest))
        {
          $command = sprintf(
            " -crop %dx%d+%d+%d %s '-' | %s",
            $width, $height,
            $x, $y,
            escapeshellarg($this->image),
            $this->magickCommands['convert']
          );

          $this->image = '-';
        }
        else
        {
          $command = sprintf(
            " -crop %dx%d+%d+%d %s %s && %s",
            $width, $height,
            $x, $y,
            escapeshellarg($this->image), escapeshellarg($thumbDest),
            $this->magickCommands['convert']
          );

          $this->image = $thumbDest;
        }

        break;
    } // end switch

    $command .= ' -thumbnail ';
    $command .= $thumbnail->getThumbWidth().'x'.$thumbnail->getThumbHeight();

    // absolute sizing
    if (!$this->scale)
    {
      $command .= '!';
    }

    if ($this->quality && $thumbnail->getMime() == 'image/jpeg')
    {
      $command .= ' -quality '.$this->quality.'% ';
    }

    // extract images such as pages from a pdf doc
    $extract = '';
    if (isset($this->options['extract']) && is_int($this->options['extract']))
    {
      if ($this->options['extract'] > 0)
      {
        $this->options['extract']--;
      }
      $extract = '['.escapeshellarg($this->options['extract']).'] ';
    }
*/
    $output = (is_null($thumbDest))?'-':$thumbDest;
    $output = (($mime = array_search($targetMime, $this->mimeMap))?$mime.':':'').$output;
    //$cmd = $this->magickCommands['convert'].' '.$command.' '.escapeshellarg($this->image).$extract.' '.escapeshellarg($output);
    //$ffmpegcmd = 'ffmpeg -i '.$inputpath.'\\'.filename.' -vframes '.$no_of_thumbs.' -ss 00:01:00 -an -vcodec '. $image_format.' -f rawvideo -s '.$size. ' '. $output;
    // echo $this->image;
	 $ffmpegcmd = 'ffmpeg -i '.$this->image.' -vframes 1 -ss 00:00:15 -an -vcodec png -f rawvideo -s  '.$width.'x'.$height.'  '.$thumbDest;

    $cmd = $ffmpegcmd;
   
    (is_null($thumbDest))?passthru($cmd):exec($cmd);
  }

  public function freeSource()
  {
    if (is_resource($this->source))
    {
      fclose($this->source);
    }
  }

  public function freeThumb()
  {
    return true;
  }

  public function getSourceMime()
  {
    return $this->sourceMime;
  }
 
  public function convert_media($filename, $rootpath, $inputpath, $outputpath, $width, $height, $bitrate, $samplingrate)
  {
    $outfile = "";
    // root directory path, where FFMPEG folder exist in your application.
    $rPath = $rootpath."\ffmpeg";
    // which shows FFMPEG folder exist on the root.
    // Set Media Size that is width and hieght
    $size = $width."x".$height;
    // remove origination extension from file adn add .flv extension, becuase we must give output file name to ffmpeg command.
    $outfile =$filename;
    // Media Size
    $size = Width & "x" & Height;

    //remove origination extenstion from file and add .flv extension , becuase we must give output filename to ffmpeg command.
    $outfile = 'out_file.flv';
    // Use exec command to access command prompt to execute the following FFMPEG Command and convert video to flv format.
    $ffmpegcmd1 ='ffmpeg -i '.$inputpath.'\\'.$filename.' -acodec mp3 -ar '.$samplingrate.' -ab '.$bitrate.' -f flv -s '.$size.' '.$outputpath.'\\'.$outfile;
    $ret = shell_exec($ffmpegcmd1);
    // return output file name for other operations
    return $outfile;
}

  public function set_buffering($filename,$rootpath,$path)
  {
  // root directory path
  $_rootPath = rootpath."\flvtool";
  // Execute FLV TOOL command also on exec , you can also use other tool for executing command prompt commands.
  $ffmpegcmd1 = "flvtool2 -U ".Path."\\".$filename;
  $ret = shell_exec($ffmpegcmd1);
  // Execute this command to set buffering for FLV
}

  public function grab_image($filename, $rootpath, $inputpath,$outputpath, $no_of_thumbs, $frame_number, $image_format, $width, $height)
  {
    // root directory path
    $_rootpath = rootpath."\ffmpeg";
    // Media Size
    $size = $width. "x".$height;
    // I am using static image, you can dynamic it with your own choice.
    $outfile = "sample.png";
    $ffmpegcmd1 = "ffmpeg -i ".$inputpath."\\".filename." -vframes ".$no_of_thumbs." -ss 00:01:00 -an -vcodec ". $image_format." -f rawvideo -s ".$size. " ". $outputpath.
	"\\".$outfile;
    $ret = shell_exec($ffmpegcmd1);
    return $outfile;
  }
}
/*
$_mediahandler as new media_handler;
$rootpath ="../";
$nputpath = $rootpath."/Default";
$outputpath = $rootpath. "/FLV"
$ThumbPath = $rootpath. "/Thumbs"
//Save original video in Default folder.
$source = $HTTP_POST_FILES['file1']['tmp_name'];
$name = $HTTP_POST_FILES['file1']['name'];
$fileSize = $HTTP_POST_FILES['file1']['size'];
$filetype = $HTTP_POST_FILES['file1']['type'];
$dest = '';
copy($source, $inputpath . $name);
// Convert it into FLV Format
$outfile = $_mediahandler.convert_media($name,$rootpath, $inputpath, $outputpath, 320, 240, 32, 22050);
// Grab Image from it.
  $image_name = $_mediahandler.grab_image($outfile, $rootpath, $outputpath, $thumbpath, 1, 2, "png", 110, 90)
  // user flv tool to set buffering, for this to work you must first download FLVTool and take it into the root folder of your .
  $_mediahandler.Set_Buffering($outfile, $rootpath, $outputpath)
  */