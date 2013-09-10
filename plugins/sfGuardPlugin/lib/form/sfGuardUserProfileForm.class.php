<?php
class sfGuardUserProfileForm extends BasesfGuardUserProfileForm
{
  public function configure()
  {
      //  $this->widgetSchema['status_name'] = new sfWidgetFormTextarea(array(), array('cols' => 20, 'rows' =>1));
     $this->setWidgets(array(
      'lookingfor' => new sfWidgetFormTextarea(array(), array('cols' => 30, 'rows' =>2)),
      //'country_id' => new sfWidgetFormPropelChoice(array('model' => 'Country', 'add_empty' => true)),
      'website'    => new sfWidgetFormTextarea(array(), array('cols' => 30, 'rows' =>2)),
      'activities' => new sfWidgetFormTextarea(array(), array('cols' => 30, 'rows' =>2)),
      'books'      => new sfWidgetFormTextarea(array(), array('cols' => 30, 'rows' =>2)),
      'music'      => new sfWidgetFormTextarea(array(), array('cols' => 30, 'rows' =>2)),
      'movies'     => new sfWidgetFormTextarea(array(), array('cols' => 30, 'rows' =>2)),
      'tvshows'    => new sfWidgetFormTextarea(array(), array('cols' => 30, 'rows' =>2)),
      'aboutme'    => new sfWidgetFormTextarea(array(), array('cols' => 30, 'rows' =>2)),
    ));

  }

}
