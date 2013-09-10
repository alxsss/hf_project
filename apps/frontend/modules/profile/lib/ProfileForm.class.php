<?php
class ProfileForm extends sfGuardUserProfileForm
{
 public function configure()
  {
    $userForm = new sfGuardUserForm();
    unset($userForm['id']);
    $this->mergeForm($userForm);	
    $years = range(date('Y')-14, date('Y')-80); //Creates array of years between actual-80 and actual year-13
    $years_list = array_combine($years, $years); //Creates new array where key and value are both values from $years list
    $this->setWidget('birthday', new sfWidgetFormDate($options = array('format' => '%day%/%month%/%year%', 'years' => $years_list)));
    $this->widgetSchema['user_id']= new sfWidgetFormInputHidden();
    $this->widgetSchema['aboutme']->setLabel('About Me');
    $this->widgetSchema['tvshows']->setLabel('TV shows');
    $this->widgetSchema['lookingfor']->setLabel('Looking for');
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
	$visibility = array(__('Everyone'), __('Friends only'));
	$this->widgetSchema['visibility'] = new sfWidgetFormSelect(array('choices' =>  $visibility));
	
	$gender=array(1=>__('Male'), 0=>__('Female'));
	$this->widgetSchema['gender']=  new sfWidgetFormChoice(array('multiple'=>false, 'choices'  => $gender, 'expanded'=>true,));
	
	$marital_status=array(0=>__(''), 1=>__('Single'), 2=>__('In a realtionship'), 3=>__('Engaged'), 4=>__('Married'), 5=>__('It is complicated'), 6=>__('Divorced/Widowed'));
	$this->widgetSchema['status']=  new sfWidgetFormSelect(array('choices'  => $marital_status));
	$this->widgetSchema['status']->setLabel('Marital Status'); 
	$countries=CountryPeer::doSelect(new Criteria());
	$default_countries=array(''=>__('select country'));
	$countries=array_merge($default_countries,$countries); 
	$this->widgetSchema['country_id'] = new sfWidgetFormPropelChoice(array('choices'  => $countries,'model' => 'Country', 'add_empty' => true ));
	$this->widgetSchema['photo'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Profile picture',
      'file_src'  => $this->getObject()->getPhoto()?'/uploads/assets/avatars/'.$this->getObject()->getPhoto():'',
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div>%file%<br />%input%<br />%delete% '.__('remove the current file').'</div>',
    ));
    //$this->widgetSchema['visibility']->setLabel('Make private');
    $this->validatorSchema['photo_delete'] = new sfValidatorPass();
	
    $this->validatorSchema['photo'] = new sfValidatorFile(array(
      'required'   => false,
      'path'       => sfConfig::get('sf_upload_dir').'/assets/avatars/',
      'validated_file_class' => 'FileSaveProfileThumb')
      );
	$this->validatorSchema['country_id']->setOption('required', false); 
	$this->widgetSchema['country_id']->setLabel('Country of residence'); 
	
	unset(
      $this['username'],
	  $this['password'],
	  $this['password_hint'],
	  $this['last_login'],
      $this['created_at'],
      $this['salt'],
	  $this['algorithm'],
      $this['is_active'],
      $this['is_super_admin'],
      $this['sf_guard_user_group_list'],
      $this['sf_guard_user_permission_list'],
	  $this['photo_vote_list'],
	  $this['photo_fav_list'],
	  $this['validate'],
	  $this['sf_simple_forum_topic_view_list'],
	  $this['sf_social_event_user_list'],
	  $this['sf_social_group_user_list'],
	  $this['school_user_list'] 
    );
	$this->setValidator('email', new sfValidatorEmail(array('required' => false, 'trim' => true)));
  $this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'checkFile')))
    );

}

 public function checkFile($validator, $values)
 {
   if(isset($values["photo"]))
   {
     $filename=$values["photo"]->getOriginalName();
     $ext  = substr($filename, -3, 3);
     if (!($this->isMedia($ext)) )
     {
      $error = new sfValidatorError($validator, __('This is not an image file(png,jpg,gif,bmp,tiff)'));
       // throw an error bound to the password field
      throw new sfValidatorErrorSchema($validator, array('photo' => $error));
     }
   }
   return $values;
 }
 protected function isMedia($ext)
 {
   return in_array(strtolower($ext), array('png', 'jpg', 'gif','bmp','jpeg','tiff'));
 }

  
   /**
   * Removes the current file for the field.
   *
   * @param string $field The field name
   * extended from the original sfPropelForm class's function to remove thumbnail also
   */

  protected function removeFile($field)
  {
    if (!$this->validatorSchema[$field] instanceof sfValidatorFile)
    {
      throw new LogicException(sprintf('You cannot remove the current file for field "%s" as the field is not a file.', $field));
    }

    $column = call_user_func(array(constant(get_class($this->object).'::PEER'), 'translateFieldName'), $field, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_PHPNAME);
    $getter = 'get'.$column;

    if (($directory = $this->validatorSchema[$field]->getOption('path')) && is_file($directory.$this->object->$getter()))
    {
      unlink($directory.$this->object->$getter());
	  //added this code to remove the corresponding thumbnail
	  if(file_exists($directory.'/thumbnails/'.$this->object->$getter()))
	  {unlink($directory.'/thumbnails/'.$this->object->$getter());}
	  if(file_exists($directory.'/normal/'.$this->object->$getter()))
	  {unlink($directory.'/normal/'.$this->object->$getter());}
    }
  }
  
   public function updateObject($values = null)
  {
    parent::updateObject($values);
    // update defaults for profile
    if (!is_null($profile = $this->getsfGuardUser()))
    {
      $values = $this->getValues();
      unset($values[$this->getPrimaryKey()]);

      $profile->fromArray($values, BasePeer::TYPE_FIELDNAME);
      $profile->save();
    }
    return $this->object;
  }
  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();
    // update defaults for profile
    if (!is_null($profile = $this->getsfGuardUser()))
    {
      $values = $profile->toArray(BasePeer::TYPE_FIELDNAME);
      unset($values[$this->getPrimaryKey()]);
      // update defaults for the main object
      if ($this->isNew)
      {
        $this->setDefaults(array_merge($values, $this->getDefaults()));
      }
      else
      {
        $this->setDefaults(array_merge($this->getDefaults(), $values));
      }
    }
  }
  protected function getsfGuardUser()
  {
    try
    {
      return $this->object->getsfGuardUser();
    }
    catch (sfException $e)
    {
      // no profile
      return null;
    }
  }
  protected function getPrimaryKey()
  {
    $profileClass = sfConfig::get('app_sf_guard_plugin_profile_class', 'sfGuardUser');
    if (class_exists($profileClass))
    {
      $tableMap = call_user_func(array($profileClass.'Peer', 'getTableMap'));
      foreach ($tableMap->getColumns() as $column)
      {
        if ($column->isPrimaryKey())
        {
          return $this->pkName = call_user_func(array($profileClass.'Peer', 'translateFieldname'), $column->getPhpName(), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_FIELDNAME);
        }
      }
    }
  }
  
  
}
