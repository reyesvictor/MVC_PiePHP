<?php

namespace Core;

class Request
{
  static $post;
  static $get;

  public function __construct()
  {
    self::$post = self::secure($_POST);
    self::$get = self::secure($_GET);
  }

  static protected function secure($var)
  {
    if (count($var) > 0) {
      foreach ($var as $key => $value) {
        $arr[$key] = htmlspecialchars(stripslashes(trim($value)));
      }
      return $arr;
    }
  }
}
