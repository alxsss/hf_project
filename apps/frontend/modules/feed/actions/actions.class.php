<?php
/**
 * feed actions.
 *
 * @package    fmpsv
 * @subpackage feed
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
 
class feedActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request objec
  */
  public function executeGamecategory(sfWebRequest $request)
  {
     $uri = 'http://www.heyzap.com/publisher_api/v2/categories?embed_key=a0a44aa5ff&secret_key=9ca4d5a76c&format=xml';
     $xml = simpleXML_load_file($uri); 
	 $this->feed = $xml;	 
  }
   public function executeGame(sfWebRequest $request)
  {
    
  }
  public function executeLastPosts(sfWebRequest $request)
 {
  //$uri = 'http://groups.google.com/group/symfony-users/feed/rss_v2_0_msgs.xml';
  $uri = 'http://www.heyzap.com/publisher_api/v2/categories?embed_key=a0a44aa5ff&secret_key=9ca4d5a76c&format=xml';
  $browser = new sfWebBrowser(array(
      'user_agent' => 'sfFeedReader/0.9',
      'timeout'    => 5
  ));
  $feedString = $browser->get($uri)->getResponseText();

  $feed = new sfRssFeed();
  //$feed->setUrl($uri);
  $feed->fromXml($feedString);
  $this->feed = $feed;
  
  //$this->feed = sfFeedPeer::createFromWeb('http://groups.google.com/group/symfony-users/feed/rss_v2_0_msgs.xml');
}

}
