<?php

# FROZEN_SF_LIB_DIR: C:\wamp\bin\php\php5.2.7\PEAR\symfony

# FROZEN_SF_LIB_DIR: C:\wamp\bin\php\php5.2.7\PEAR\symfony

require_once dirname(__FILE__).'/../../fmpsv/lib/symfony/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  static protected $zendLoaded = false;
 
  static public function registerZend()
  {
 if (self::$zendLoaded)
    {
      return;
    }
    //set_include_path(sfConfig::get('sf_lib_dir').'/vendor'.PATH_SEPARATOR.get_include_path());
   // set_include_path(sfConfig::get('sf_lib_dir').'/vendor');
    //require_once sfConfig::get('sf_lib_dir').'/vendor/Zend/Loader.php';
    //Zend_Loader::registerAutoload();
	require_once sfConfig::get('sf_lib_dir').'/vendor/Zend/Loader/Autoloader.php';
	Zend_Loader_Autoloader::getInstance();
	
	Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding("UTF-8");
	Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive());

    self::$zendLoaded = true;
	
  }

  public function setup()
  {
    // for compatibility / remove and enable only the plugins you want
	//$this->setWebDir($this->getRootDir().'/../www/hemsinif/web');
	$this->setWebDir($this->getRootDir().'/web');
    $this->enableAllPluginsExcept(array('sfCompat10Plugin'));
    ini_set('include_path', '/home/www/hemsinif/lib/vendor:/usr/share/pear/'); 
   }
}
