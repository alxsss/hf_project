<?php

class GameCategory extends BaseGameCategory
{
  public function __toString()
  {
    return $this->getDisplayName();
  }
}
