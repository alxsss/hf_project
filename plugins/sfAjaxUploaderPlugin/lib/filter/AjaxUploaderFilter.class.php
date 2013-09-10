<?php

class AjaxUploaderFilter extends sfFilter {
  const namespace = "sfAjaxUploaderPlugin";

  public function execute ($filterChain) {
    $context = sfContext::getInstance();
    if($context->getModuleName() != "ajaxUploader") {
      $user = $context->getUser();
      $request = $context->getRequest();
      foreach ($user->getAttributeHolder()->getAll(self::namespace) as $name=>$value) {
        if(is_array($value) && $request->hasParameter($name) && is_array($request->getParameter($name))) {
          $oldValue = $request->getParameter($name);
          foreach ($value as $key=>$val) {
            $oldValue[$key] = $val;
          }
          $request->setParameter($name, $oldValue);
        } else {
          $request->setParameter($name, $value);
        }
      }
      $user->getAttributeHolder()->removeNamespace(self::namespace);
    }

    $filterChain->execute();

  }

}
