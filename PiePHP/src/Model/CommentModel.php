<?php

namespace Model;

class CommentModel
{
  public function __construct() {
  }
  
  public function display() {
    echo '<hr>';
    echo 'DISPLAY';
    var_dump($this);
    echo '<hr>';
  }
}
