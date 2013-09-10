<?php
/**
 * Symfony Propel based polls plugin toolkit 
 * 
 * @package plugins
 * @subpackage polls
 * @author Ton Sharp <Ton@66Ton99.org.ua>
 */
class sfPropelPollsToolkit 
{

  /**
   * <p>Retrieves user PK from configured function or class::method. A call to 
   * <code>$function()</code> or <code>$class::$method()</code> should returns a
   * voting user primary key.</p>
   * 
   * @return mixed: int or null
   */
  public static function getUserPK()
  {
    $return = null;
    
    // Function
    $function = sfConfig::get('app_sfPropelPollsPlugin_userPk_function');
    if (!is_null($function) && function_exists($function))
    {
      $return = $function();
    }
    
    // Class::method
    $class  = sfConfig::get('app_sfPropelPollsPlugin_userPk_class');
    $method = sfConfig::get('app_sfPropelPollsPlugin_userPk_method');
    if (class_exists($class) && method_exists(new $class, $method))
    {
      $return = call_user_func(array(get_class($class), $method));
    }

    // Default
    if (empty($return) && in_array('sfGuardAuth', sfConfig::get('sf_enabled_modules', array()))) {
    	try {
	    	$user = sfContext::getInstance()->getUser();
	    	if (method_exists($user, 'getGuardUser') && method_exists($user->getGuardUser(), 'getId')) {
	    		$return = $user->getGuardUser()->getId();
	    	}
    	} catch(Exception $e) {}
    }
    
    return $return;
  }

}
