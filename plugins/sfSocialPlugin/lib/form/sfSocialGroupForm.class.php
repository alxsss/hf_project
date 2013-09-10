<?php

/**
 * sfSocialGroup form.
 *
 * @package    sfSocialPlugin
 * @subpackage form
 * @author     Massimiliano Arione <garakkio@gmail.com>
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfSocialGroupForm extends BasesfSocialGroupForm
{
  public function configure()
  {
    // hide unuseful fields
    unset($this['created_at'], $this['updated_at'], $this['sf_social_group_user_list']);
    //visibility variables
	sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
	$visibility = array(__('Everyone'), __('Members only'));
	$this->widgetSchema['visibility'] = new sfWidgetFormSelect(array('choices' =>  $visibility));
	
    // hide user_admin, binding it to current user's id
    $this->widgetSchema['user_admin'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_admin', $this->options['user']->getId());
    $this->setValidator('user_admin', new sfValidatorChoice(array('choices' => array($this->options['user']->getId()))));
	
	$this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Group picture',
      'file_src'  => $this->getObject()->getPhoto()?'/uploads/assets/avatars/'.$this->getObject()->getPhoto():'',
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div>%file%<br />%input%<br />%delete% '.__('remove the current file').'</div>',
    ));
    $this->validatorSchema['photo_delete'] = new sfValidatorPass();
	
    $this->validatorSchema['photo'] = new sfValidatorFile(array(
      'required'   => false,
      'path'       => sfConfig::get('sf_upload_dir').'/assets/avatars/',
      'validated_file_class' => 'FileSaveProfileThumb'));
	  
  }

  /**
   * ovveride to automatically make group's creator also a group member
   * @param PropelPDO $con
   */
  public function doSave($con = null)
  {
    if (!$this->getObject()->isNew())
    {
      parent::doSave($con);
    }
    else
    {
      try
      {
        $con->beginTransaction();
        parent::doSave($con);
        $groupUser = new sfSocialGroupUser;
        $groupUser->setsfSocialGroup($this->getObject());
        $groupUser->setUserId($this->getValue('user_admin'));
        $groupUser->save();
        $con->commit();
      }
      catch (Exception $e)
      {
        $con->rollBack();
        throw $e;
      }
    }
  }

}
