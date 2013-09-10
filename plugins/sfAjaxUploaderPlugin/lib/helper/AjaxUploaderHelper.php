<?php
function input_ajaxsafe_file_tag($name, $options = array()) {
  //if(sfContext::getInstance()->getRequest()->isXmlHttpRequest())
   {
    // magic
    return tag('iframe', array('src'=>url_for('ajaxUploader/uploader') . '?name=$name', 'name'=>'ajaxUploader', 'frameborder'=>0, 'width'=>250, 'height'=>28), true)
      . tag('/iframe') . input_hidden_tag($name);
  }
  // else {
    //return input_file_tag($name, $options);
  //}  
}

?>