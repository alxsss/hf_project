<?php

/**
 * links actions.
 *
 * @package    hemsinif
 * @subpackage links
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class linksActions extends sfActions
{
   public function preExecute()
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->user_id=$this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser');
      $this->user = sfGuardUserPeer::retrieveByPk($this->user_id);
      $this->forward404Unless($this->user);
    }
  }
  public function executeAddlinkcomment(sfWebRequest $request)
  {
   if ($this->getRequest()->getMethod() == sfRequest::POST)
   {
     $this->link_id=$request->getParameter('item_id');
     $this->link_user_id=$request->getParameter('item_user_id');
     $this->user_id= $this->getUser()->getSubscriberId();
     $link_comment=$request->getParameter('comment');
     if (!empty($link_comment))
     {
      $this->comment = new UserLinkComment();
      $this->comment->setLinkId($this->link_id);
      $this->comment->setComment($link_comment);
      $this->comment->setUserId($this->user_id);
      $this->comment->save();
      //prepare to send emails to each user of comments and to owner of the link
      //$user=sfGuardUserPeer::retrieveByPk($this->user_id);
      $link_owner_user = sfGuardUserPeer::retrieveByPk($this->link_user_id);
      //extract name if exists
      $this->name= $this->user->getProfile()->getName();
      $this->name= trim($this->name);
      $username=$this->user->getUsername();
      if(empty($this->name))
      {
            $this->name=$username;
      }
      //if the user is not the owner of the link, send email to owner
      //send emails to users of previous comments
      $this->link = UserLinkPeer::retrieveByPk($this->link_id);
      $page=$this->getRequestParameter('page', 1);
      //send emails to users of previous comments
      //collect emails in an array
      $emails_comment_users=array();
      $usernames_comment_users=array();
      foreach($this->link->getUserLinkComments() as $comment)
      {
        //collect emails in an array
        $emails_comment_users[]=$comment->getsfGuardUser()->getEmail();
        $usernames_comment_users[]=$comment->getsfGuardUser()->getUsername();
      }
      //eliminate the same emails
      $emails_comment_users_unique=array_unique($emails_comment_users);
      $usernames_comment_users_unique=array_unique($usernames_comment_users);
      $own_email=array($this->user->getEmail(), $link_owner_user->getEmail());
      $own_username=array($this->user->getUsername(), $link_owner_user->getUsername());
      //do not send email to user himself/herself  and to owner
      $emails_comment_users_unique_exOwn=array_diff($emails_comment_users_unique,$own_email);
      $usernames_comment_users_unique_exOwn=array_diff($usernames_comment_users_unique, $own_username);
      foreach($emails_comment_users_unique_exOwn as $i=>$email)
      {
        if(!empty($email))
        {
          $this->sendStatusComment(trim($email), $usernames_comment_users_unique_exOwn[$i],  $this->name, $page);
        }
      }
      if($this->user_id!=$this->link_user_id)
      {
        if($link_owner_user)
        {
          $email=$link_owner_user->getEmail();
          if(!empty($email))
          {
            $recepient_username=$link_owner_user->getUsername();
            $page=$this->getRequestParameter('page', 1);
            $url='http://hemsinif.com/az/user/'.$recepient_username;
            $subject=$this->name.' hemsinif.com da sizin linkiniza rÉini bildirdi';
            $body=<<<EOF
          Salam $recepient_username,

          $this->name hemsinif.com da sizin linkiniza rÉini bildirdi. Ona  linkdÉ$url baxa bilÉsiniz.

          Sag olun,
          hemsinif.com
EOF;
                  $this->sendhemsinifEmail(trim($email), $subject, $body);
                 }//end if email
                }
          }
        }
    return sfView::SUCCESS;
  }

   $this->forward404();
}
  public function executeDeletelinkcomment(sfWebRequest $request)
  {
    $this->forward404Unless($linkcomment = UserLinkCommentPeer::retrieveByPk($request->getParameter('id')));
    $linkcomment->delete();
  }

  public function executePoststatus(sfWebRequest $request)
  {
    $this->status_content=$request->getParameter('user_status');
    if (!empty($this->status_content))
    {
      $status=new sfGuardUserStatus();
      $status->setUserId($this->user_id);
      $status->setStatusName($this->status_content);
      $status->setCreatedAt(time());
      $status->save();
    }
    $c=new Criteria();
    $c->add(sfGuardUserStatusPeer::USER_ID,$this->user_id);
    $c->addDescendingOrderByColumn(sfGuardUserStatusPeer::CREATED_AT);
    $this->status=sfGuardUserStatusPeer::doSelectOne($c);
  }

   public function executePostlink(sfWebRequest $request)
  {
    $this->uploadDirName='/uploads/assets';
    $this->uploadDir     = sfConfig::get('sf_web_dir').$this->uploadDirName;
    $this->post_link_text=$request->getParameter('post_link_text');
    $this->title=$request->getParameter('title');
    $this->description=$request->getParameter('desc');
    $this->url=$request->getParameter('url');
    $this->img_src=$request->getParameter('img_src');
    $this->filename='';
    if(!empty($this->img_src))
    {
      $thumbnail = new sfThumbnail(76, 76);
      $thumbnail->loadFile($this->img_src);
      $currentDir='links';
      $absCurrentDir = $this->uploadDir.'/'.$currentDir;
      $this->forward404Unless(is_dir($absCurrentDir));
      $info  = substr($this->img_src, -3, 3);
      $newfileName = md5($this->img_src.time().rand(0, 99999));
      $ext ='.'.$info;
      $this->filename=$newfileName.$ext;
      $thumbnail->save($absCurrentDir.'/'.$this->filename);
    }
    if(!empty($this->title))
    {
      $link=new UserLink();
      $link->setUserId($this->user_id);
      $link->setStatusText($this->post_link_text);
      $link->setCreatedAt(time());
      $link->setImg($this->filename);
      $link->setTitle($this->title);
      $link->setDescription($this->description);
      $link->setUrl($this->url);
      $link->save();
    }
    $c=new Criteria();
    $c->add(UserLinkPeer::USER_ID,$this->user_id);
    $c->addDescendingOrderByColumn(UserLinkPeer::CREATED_AT);
    $this->link=UserLinkPeer::doSelectOne($c);
  }
  public function executeDeletestatus($request)
  {
    $this->forward404Unless($this->user_id);
    $id=$request->getParameter('id');
    $this->forward404Unless($status = sfGuardUserStatusPeer::retrieveByPk($request->getParameter('id')));
    $status->delete();
  }
  public function executeDeletelink($request)
  {
    $this->forward404Unless($this->user_id);
    $id=$request->getParameter('id');
    $this->forward404Unless($link = UserLinkPeer::retrieveByPk($request->getParameter('id')));
    $filename=$link->getImg();
    if(!empty($filename))
    {
      $uploadDir = sfConfig::get('sf_web_dir').'/uploads/assets';
      if(file_exists($uploadDir.'/links/'.$filename))
      {
        unlink($uploadDir.'/links/'.$filename);    
      }
    }
    $link->delete();    
  }

  public function executeFetch(sfWebRequest $request)
  {
    $uri = urldecode($request->getParameter('url') );
    try
    {
      $client = new Zend_Http_Client($uri, array('maxredirects'=>2,'timeout'=>10,));
      // Try to mimic the requesting user's UA
      $client->setHeaders(array(
        'User-Agent' => $_SERVER['HTTP_USER_AGENT'],
        'X-Powered-By' => 'Zend Framework'
      ));
      $response = $client->request();
      // Get content-type
      list($contentType) = explode(';', $response->getHeader('content-type'));
      $this->contentType = $contentType;
      // Prepare
      $this->title = null;
      $this->description = null;
      $this->thumb = null;
      $this->imageCount = 0;
      $this->images = array();
  // Handling based on content-type
      switch( strtolower($contentType) ) {
        // Images
        case 'image/gif':
        case 'image/jpeg':
        case 'image/jpg':
        case 'image/tif': // Might not work
        case 'image/xbm':
        case 'image/xpm':
        case 'image/png':
        case 'image/bmp': // Might not work
          $this->_previewImage($uri, $response);
          break;
        // HTML
        case '':
        case 'text/html':
          $this->_previewHtml($uri, $response);
          break;
        // Plain text
        case 'text/plain':
          $this->_previewText($uri, $response);
          break;
        // Unknown
        default:
          break;
      }
    }
    catch( Exception $e )
    {
      throw $e;
      //$this->view->title = $uri;
      //$this->view->description = $uri;
      //$this->view->images = array();
      //$this->view->imageCount = 0;
    }
  }
 protected function _previewHtml($uri, Zend_Http_Response $response)
  {
    $body = $response->getBody();
    $body = trim($body);
    if( preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getHeader('content-type'), $matches) ||
        preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getBody(), $matches) ) {
      $this->charset = $charset = trim($matches[1]);
    } else {
      $this->charset = $charset = 'UTF-8';
    }
    // Get DOM
    if( class_exists('DOMDocument') ) {
      $dom = new Zend_Dom_Query($body);
    } else {
      $dom = null; // Maybe add b/c later
    }
    $title = null;
    if( $dom ) {
      $titleList = $dom->query('title');
      if( count($titleList) > 0 ) {
        $title = trim($titleList->current()->textContent);
        $title = substr($title, 0, 255);
      }
    }
    $this->title = $title;
    $description = null;
    if( $dom ) {
      $descriptionList = $dom->queryXpath("//meta[@name='description']");
      // Why are they using caps? -_-
      if( count($descriptionList) == 0 ) {
        $descriptionList = $dom->queryXpath("//meta[@name='Description']");
      }
      if( count($descriptionList) > 0 ) {
        $description = trim($descriptionList->current()->getAttribute('content'));
        $description = substr($description, 0, 255);
      }
    }
    $this->description = $description;
    $thumb = null;
    if($dom) {
      $thumbList = $dom->queryXpath("//link[@rel='image_src']");
      if( count($thumbList) > 0 ) {
        $thumb = $thumbList->current()->getAttribute('href');
      }
    }
    $this->thumb = $thumb;
    $medium = null;
    if($dom) {
      $mediumList = $dom->queryXpath("//meta[@name='medium']");
      if( count($mediumList) > 0 ) {
        $medium = $mediumList->current()->getAttribute('content');
      }
    }
    $this->medium = $medium;
    // Get baseUrl and baseHref to parse . paths
    $baseUrlInfo = parse_url($uri);
    $baseUrl = null;
    $baseHostUrl = null;
    if($dom) {
      $baseUrlList = $dom->query('base');
      if( $baseUrlList && count($baseUrlList) > 0 && $baseUrlList->current()->getAttribute('href') ) {
        $baseUrl = $baseUrlList->current()->getAttribute('href');
        $baseUrlInfo = parse_url($baseUrl);
        $baseHostUrl = $baseUrlInfo['scheme'].'://'.$baseUrlInfo['host'].'/';
      }
    }
    if(!$baseUrl) {
      $baseHostUrl = $baseUrlInfo['scheme'].'://'.$baseUrlInfo['host'].'/';
      if(empty($baseUrlInfo['path']) ) {
        $baseUrl = $baseHostUrl;
      } else {
        $baseUrl = explode('/', $baseUrlInfo['path']);
        array_pop($baseUrl);
        $baseUrl = join('/', $baseUrl);
        $baseUrl = trim($baseUrl, '/');
        $baseUrl = $baseUrlInfo['scheme'].'://'.$baseUrlInfo['host'].'/'.$baseUrl.'/';
      }
    }
   $images = array();
    if($thumb) {
      $images[] = $thumb;
    }
    if($dom) {
      $imageQuery = $dom->query('img');
      foreach( $imageQuery as $image )
      {
        $src = $image->getAttribute('src');
        // Ignore images that don't have a src
        if( !$src || false === ($srcInfo = @parse_url($src)) ) {
          continue;
        }
        $ext = ltrim(strrchr($src, '.'), '.');
        // Detect absolute url
        if( strpos($src, '/') === 0 ) {
          // If relative to root, add host
          $src = $baseHostUrl . ltrim($src, '/');
        } else if( strpos($src, './') === 0 ) {
          // If relative to current path, add baseUrl
          $src = $baseUrl . substr($src, 2);
        } else if( !empty($srcInfo['scheme']) && !empty($srcInfo['host']) ) {
          // Contians host and scheme, do nothing
        } else if( empty($srcInfo['scheme']) && empty($srcInfo['host']) ) {
          // if not contains scheme or host, add base
          $src = $baseUrl . ltrim($src, '/');
        } else if( empty($srcInfo['scheme']) && !empty($srcInfo['host']) ) {
          // if contains host, but not scheme, add scheme?
          $src = $baseUrlInfo['scheme'] . ltrim($src, '/');
        } else {
          // Just add base
          $src = $baseUrl . ltrim($src, '/');
        }
        // Ignore images that don't come from the same domain
        //if( strpos($src, $srcInfo['host']) === false ) {
          // @todo should we do this? disabled for now
          //continue;
        //}
        // Ignore images that don't end in an image extension
        if( !in_array($ext, array('jpg', 'jpeg', 'gif', 'png')) ) {
          // @todo should we do this? disabled for now
          //continue;
        }
        if( !in_array($src, $images) ) {
          $images[] = $src;
        }
      }
    }
     // Unique
    $images = array_values(array_unique($images));
    // Truncate if greater than 20
    if( count($images) > 30 ) {
      array_splice($images, 30, count($images));
    }
    $this->imageCount = count($images);
    $this->images = $images;
  }

}
