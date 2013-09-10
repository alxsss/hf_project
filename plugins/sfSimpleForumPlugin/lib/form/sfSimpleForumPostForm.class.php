<?php

/**
 * sfSimpleForumPost form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class sfSimpleForumPostForm extends BasesfSimpleForumPostForm
{
  public function configure()
  {
     $this->validatorSchema['title']->setOption('required', true);
	 $this->validatorSchema['content']->setOption('required', true);
 	 $this->widgetSchema['content'] = new sfWidgetFormTextarea(array(), array('cols' => 105, 'rows' =>4));

	 $this->widgetSchema->setNameFormat('sfSimpleForumPost[%s]');
  }
}
