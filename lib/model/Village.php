<?php

class Village extends BaseVillage
{
  public function __toString()
  {
    return $this->getName();
  }
}