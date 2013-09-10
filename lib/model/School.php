<?php

class School extends BaseSchool
{
  public function __toString()
  {
    return $this->getName();
  }
}