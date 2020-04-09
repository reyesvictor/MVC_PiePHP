<?php

namespace Model;

class GameModel
{
  public function __construct() {
  }
  
  public function display() {
    echo 'DISPLAY OF GameModel';
    var_dump($this);
    echo '<hr>';
  }
}
