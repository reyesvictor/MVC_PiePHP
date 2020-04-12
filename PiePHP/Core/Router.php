<?php

namespace Core;

class Router
{
  private static $routes;
  static $id;
  static $table;

  public static function connect($url, $route)
  {
    self::$routes[$url] = $route;
  }

  public static function get($url)
  {
    //decomposer le $_SERVER pour quil recupere larray si la path correspond a /user/delete/
    $arr = explode('/', $url);
    $arr = array_values(array_filter($arr));
    if (isset($arr) && count($arr) > 0) {
      if (
        $arr[0] == 'user' && isset($arr[1]) && is_numeric($arr[1])
        || $arr[0] == 'user' && isset($arr[1]) && $arr[1] == '?'
      ) {
        Router::$id = $arr[1];
        $url = '/user/{id}';
      } else if ($arr[0] == 'user' && isset($arr[1]) && preg_match('/@/', $arr[1])) {
        Router::$id['col'] = 'users.email';
        Router::$id['id'] = $arr[1];
        $url = '/user/{id}';
      }
    }
    return array_key_exists($url, self::$routes) ? self::$routes[$url] : false;
  }
}
