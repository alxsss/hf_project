<?php
class sfMemcacheSingletonCache extends sfMemcacheCache
{
  /**
   *
   * @see sfMemcacheCache#initialize()
   */
  public function initialize($options = array())
  {
    // we create our own memcache instance here
    // sfMemcacheCache checks for a memcache key in the
    // options array and takes this value without
    // creating a new memcache instance
    // other option values, like prefix etc. are assigned to the subclass
    $memcache = sfMemcache::getInstance();
 
    $options['memcache'] = $memcache;
    parent::initialize($options);
  }
}
