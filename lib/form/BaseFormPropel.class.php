<?php

/**
 * Project form base class.
 *
 * @package    fmpsv
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormBaseTemplate.php 9304 2008-05-27 03:49:32Z dwhittle $
 */
abstract class BaseFormPropel extends sfFormPropel
{
  public function setup()
  {
     // default formatter to list (instead of table)
      //$this->widgetSchema->setDefaultFormFormatterName('list');

      // i18n
     // $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('sfSocial');

  }
}
