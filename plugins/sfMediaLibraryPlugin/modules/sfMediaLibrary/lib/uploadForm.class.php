<?php
class uploadForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array('filename'  => new sfWidgetFormInputFile(), ));
    $this->setValidators(array('filename' => new sfValidatorFile(array('required' => true)), ));
    $this->widgetSchema->setNameFormat('upload[%s]'); 
    // add a post validator
   $this->validatorSchema->setPostValidator( new sfValidatorCallback(array('callback' => array($this, 'checkFile')))    );
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
  }
  public function checkFile($validator, $values)
 {
   if(isset($values["filename"]))
   {
     $filename=$values["filename"]->getOriginalName();
     //$ext  = substr($filename, strpos($filename, '.') - strlen($filename) + 1);
     $ext  = substr($filename, -3, 3);
     if(empty($filename))
     {
        $error = new sfValidatorError($validator, __('required'));
       // throw an error bound to the password field
       throw new sfValidatorErrorSchema($validator, array('filename' => $error));
     }
     else if (!($this->isMedia($ext)) )
     {
      $error = new sfValidatorError($validator, __('This is not an image file(png,jpg,gif,bmp,tiff)'));
       // throw an error bound to the password field
      throw new sfValidatorErrorSchema($validator, array('filename' => $error));
     }
   }
   return $values;
 }
 protected function isMedia($ext)
 {
   return in_array(strtolower($ext), array('png', 'jpg', 'gif','bmp','jpeg','tiff'));
 }
}
