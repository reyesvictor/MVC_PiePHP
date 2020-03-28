<?php

namespace Core;

class Request
{

  public $post;
  public $get;

  public function __construct()
  {
    $this->post = $this->secure($_POST);
    $this->get = $this->secure($_GET);
  }

  protected function secure($var)
  {
    if (count($var) > 0) {
      foreach ($var as $key => $value) {
        $arr[$key] = htmlspecialchars(stripslashes(trim($value)));
      }
      return $arr;
    }
  }
}