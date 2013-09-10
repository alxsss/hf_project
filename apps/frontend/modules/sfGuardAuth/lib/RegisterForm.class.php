<?php
class RegisterForm extends sfGuardUserAdminForm
{
  protected
    $pkName = null;
  public function configure()
  {
    parent::configure();
	sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
	//merge with school user form
	$schoolUserForm = new SchoolUserForm();
	unset($schoolUserForm['user_id']);
    $this->mergeForm($schoolUserForm);
    $gender = array(''=>__('Select Gender'), 1=>__('Male'), 0=>__('Female'));
	$this->widgetSchema['gender'] = new sfWidgetFormSelect(array('choices' =>  $gender));
	$years = range(date('Y')-14, date('Y')-80); //Creates array of years between actual-80 and actual year-13
	   
	$years_list = array_combine($years, $years); //Creates new array where key and value are both values from $years list
    $this->setWidget('birthday', new sfWidgetFormDate($options = array('empty_values'=>array('year'=>__('year'), 'month'=>__('month'), 'day'=>__('day')),'format' => '%day%/%month%/%year%', 'years' => $years_list)));
   	$this->widgetSchema['is_active'] = new sfWidgetFormInputHidden();	
    unset(
      $this['last_login'],
      $this['created_at'],
      $this['salt'],
	  $this['photo'],
      $this['algorithm'],
      //$this['is_active'],
      $this['is_super_admin'],
      $this['sf_guard_user_group_list'],
      $this['sf_guard_user_permission_list'],
	  $this['photo_vote_list'],
	  $this['photo_fav_list'],
	//  $this['password_again'],
	  $this['first_name'],
	  $this['last_name'],
	  $this['status'],
      $this['lookingfor'],
      $this['city'],
      $this['state'],
      $this['zip'],
	  $this['country_id'],
	  $this['website'],
      $this['activities'],
      $this['books'],
      $this['music'],
      $this['movies'],
      $this['tvshows'],
      $this['aboutme'],
      $this['college'],
      $this['major'],
	  $this['tab'],
	  $this['validate'],
	  $this['visibility'],
	  $this['sf_simple_forum_topic_view_list'],
	  $this['school_user_list'] 
    );
	$this->validatorSchema['password']->setOption('required', true);
	$this->validatorSchema['birthday']->setOption('required', true);
	$this->validatorSchema['gender']->setOption('required', true);
	$this->setValidator('email', new sfValidatorEmail(array('required' => false, 'trim' => true)));
	$this->setValidator('username', new sfValidatorString(array('trim' => true)));
	$this->widgetSchema['password_hint']->setLabel('Password hint');
	$this->mergePostValidator(new sfValidatorAnd(array(new sfValidatorCallback(array('callback' => array($this, 'validatePasswordHint'))),
))); 
  }
  public static function validatePasswordHint($validator, $values)
 {
   if(empty($values['email'])&&empty($values['password_hint']))
   {     
     $error = new sfValidatorError($validator, 'Password hint cannot be empty when there is no email');
     throw new sfValidatorErrorSchema($validator,  array('password_hint' => $error));         
   }
   if(preg_match('/\?/',strtolower($values['username'])))
   {
     $error = new sfValidatorError($validator, 'there is a symbol in the username that is not allowed');
     throw new sfValidatorErrorSchema($validator,  array('username' => $error));
   }
   return $values;
 }
   public function getSchoolUser()
  {
    try
    {
      return $this->object->getSchoolUser();
    }
    catch (sfException $e)
    {
      echo 'no profile';
      return null;
    }
  }
 
}
