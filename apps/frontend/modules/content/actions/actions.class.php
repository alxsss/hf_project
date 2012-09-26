<?php

/**
 * content actions.
 *
 * @package    twm
 * @subpackage content
 * @author     Your name here
 * @version    SVN: $Id$
 */
class contentActions extends sfActions
{
  public function executeAbout()
  {
    //require_once('markdown.php');

    $file = sfConfig::get('sf_data_dir').'/content/about_'.$this->getUser()->getCulture().'.txt';
    if (!is_readable($file))
    {
      $file = sfConfig::get('sf_data_dir').'/content/about_en.txt';
    }

    //$this->html = markdown(file_get_contents($file));
    $this->html = file_get_contents($file);
  }
  public function executeCopyright()
  {
    
    $file = sfConfig::get('sf_data_dir').'/content/copyright_'.$this->getUser()->getCulture().'.txt';
    if (!is_readable($file))
    {
      $file = sfConfig::get('sf_data_dir').'/content/copyright_en.txt';
    }

    //$this->html = markdown(file_get_contents($file));
    $this->html = file_get_contents($file);
  }
  public function executeHelp()
  {
    //require_once('markdown.php');

    $file = sfConfig::get('sf_data_dir').'/content/help_'.$this->getUser()->getCulture().'.txt';
    if (!is_readable($file))
    {
      $file = sfConfig::get('sf_data_dir').'/content/help_az.txt';
    }

    //$this->html = markdown(file_get_contents($file));
    $this->html = file_get_contents($file);
  }
  public function executeTs()
  {
    
    $file = sfConfig::get('sf_data_dir').'/content/ts_'.$this->getUser()->getCulture().'.txt';
    if (!is_readable($file))
    {
      $file = sfConfig::get('sf_data_dir').'/content/ts_ru.txt';
    }

    //$this->html = markdown(file_get_contents($file));
    $this->html = file_get_contents($file);
  }
  public function executePrivacyp()
  {
    
    $file = sfConfig::get('sf_data_dir').'/content/privacyp_'.$this->getUser()->getCulture().'.txt';
    if (!is_readable($file))
    {
      $file = sfConfig::get('sf_data_dir').'/content/privacyp_en.txt';
    }

    //$this->html = markdown(file_get_contents($file));
    $this->html = file_get_contents($file);
  }
  public function executeContact()
  {
    
    $file = sfConfig::get('sf_data_dir').'/content/contact_'.$this->getUser()->getCulture().'.txt';
    if (!is_readable($file))
    {
      $file = sfConfig::get('sf_data_dir').'/content/contact_en.txt';
    }

    //$this->html = markdown(file_get_contents($file));
    $this->html = file_get_contents($file);
  }
  public function executeUnavailable()
  {
    require_once('markdown.php');

    $file = sfConfig::get('sf_data_dir').'/content/unavailable_'.$this->getUser()->getCulture().'.txt';
    if (!is_readable($file))
    {
      $file = sfConfig::get('sf_data_dir').'/content/unavailable_en.txt';
    }

    $this->setTitle('fmpsv! &raquo; maintenance');
  }
}
?>