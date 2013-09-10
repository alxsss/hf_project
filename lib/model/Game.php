<?php

class Game extends BaseGame
{
 public function __toString()
 {
   return $this->getName();
 }
}
