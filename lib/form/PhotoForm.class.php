<?php

/**
 * Photo form.
 *
 * @package    fmpsv
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */

class PhotoForm extends BasePhotoForm
{
   public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
	$visibility = array(__('Everyone'), __('Friends only'));
	$confirm = array(__('No'), __('Yes'));
	$this->widgetSchema['visibility'] = new sfWidgetFormSelect(array('choices' =>  $visibility));
    $this->widgetSchema['popular_photo'] = new sfWidgetFormSelect(array('choices' =>$confirm));
	$this->widgetSchema['popular_photo']->setLabel('Participate in new/popular photo?');
	$this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();
	$albumCriteria = AlbumPeer::getAlbumCriteria();
        $this->widgetSchema['album_id']->setOption('criteria', $albumCriteria);
	$this->validatorSchema['album_id']->setOption('criteria', $albumCriteria);
		
	unset($this['filename']);
	unset($this['created_at']);
	unset($this['hits']);
	unset($this['rating']);
	unset($this['vote']);
	unset($this['approved']);
	unset($this['raw_ip']);
	unset($this['photo_fav_list']);	
	unset($this['photo_rate_list']);	
	unset($this['photo_vote_list']);	
  }  
}
