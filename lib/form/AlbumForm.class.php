<?php

/**
 * Album form.
 *
 * @package    fmpsv
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class AlbumForm extends BaseAlbumForm
{
  public function configure()
  {
    $this->widgetSchema['user_id'] = new sfWidgetFormInputHidden();
	sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
	$visibility = array(__('Everyone'), __('Friends only'));
	$this->widgetSchema['visibility'] = new sfWidgetFormSelect(array('choices' =>  $visibility));
	$this->validatorSchema['description']=new sfValidatorString(array('required' => false));
	$this->validatorSchema['title']=new sfValidatorString(array('required' => true));
  }
}
