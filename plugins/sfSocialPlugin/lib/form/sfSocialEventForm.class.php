<?php

/**
 * sfSocialEvent form.
 *
 * @package    sfSocialPlugin
 * @subpackage form
 * @author     Massimiliano Arione <garakkio@gmail.com>
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfSocialEventForm extends BasesfSocialEventForm
{
  public function configure()
  {
    // hide unuseful fields
    unset($this['created_at'], $this['updated_at'], $this['sf_social_event_user_list']);
	
	//visibility variables
	sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
	$visibility = array(__('Everyone'), __('Members only'));
	$this->widgetSchema['visibility'] = new sfWidgetFormSelect(array('choices' =>  $visibility));

    // hide user_admin, binding it to current user's id
    $this->widgetSchema['user_admin'] = new sfWidgetFormInputHidden();
    $this->setDefault('user_admin', $this->options['user']->getId());
    $this->setValidator('user_admin', new sfValidatorChoice(array('choices' => array($this->options['user']->getId()))));

    // set selectable dates
    $years = range(date('Y'), date('Y') + 5);
    $ylist = array_combine($years, $years);
    $this->widgetSchema['start']->setOption('date', array('years' => $ylist));
    $this->widgetSchema['end']->setOption('date', array('years' => $ylist));

    // set default dates (today and tomorrow)
    $this->setDefault('start', time());
    $this->setDefault('end', time() + 86400);
	
	$this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Event picture',
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
}
