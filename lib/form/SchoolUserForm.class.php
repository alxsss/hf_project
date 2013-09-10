<?php

/**
 * SchoolUser form.
 *
 * @package    hemsinif
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class SchoolUserForm extends BaseSchoolUserForm
{
  public function configure()
  {
   	sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
    $grad_years = range(date('Y')+8, date('Y')-80); //Creates array of years between actual-80 and actual year-13
   	$grad_years_default=array(''=>__('Select Year'));
	$grad_years = array_merge($grad_years_default, $grad_years); 
    $grad_years = array_combine($grad_years, $grad_years); //Creates new array where key and value are both values from $years list
	//$this->setWidget('grad_year', new sfWidgetFormDate($options = array('format' => '%year%', 'years' => $grad_years)));
	$this->widgetSchema['grad_year'] = new sfWidgetFormChoice(array('choices'  => $grad_years));
	$this->widgetSchema['grad_year']->setLabel('Year graduated');
  }
}